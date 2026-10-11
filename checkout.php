<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/db_connect.php';


// 1. GÜVENLİK DUVARI: Kullanıcı giriş yapmamışsa ödeme sayfasına giremez!
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// 2. KONTROL: Sepet boşsa bu sayfaya girilmez, mağazaya geri gönder.
if (empty($_SESSION['cart'])) {
    header("Location: products.php");
    exit();
}

// Order totals and stock are checked on the server inside one transaction.
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($address === '' || $phone === '') {
        $error_message = 'Please enter your address and phone number.';
    } else {
        try {
            mysqli_begin_transaction($conn);
            $items = [];
            $total = 0;
            $product = mysqli_prepare($conn, 'SELECT price, stock_quantity FROM products WHERE product_id = ? FOR UPDATE');
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $id = filter_var($id, FILTER_VALIDATE_INT);
                $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
                if (!$id || !$quantity || $quantity < 1) { throw new RuntimeException('Invalid cart item.'); }
                mysqli_stmt_bind_param($product, 'i', $id);
                mysqli_stmt_execute($product);
                $row = mysqli_fetch_assoc(mysqli_stmt_get_result($product));
                if (!$row || $row['stock_quantity'] < $quantity) { throw new RuntimeException('A product is unavailable or stock is insufficient.'); }
                $items[] = [$id, $quantity, $row['price']];
                $total += $row['price'] * $quantity;
            }
            if (!$items) { throw new RuntimeException('Your cart is empty.'); }
            $userId = (int)$_SESSION['user_id'];
            $order = mysqli_prepare($conn, "INSERT INTO orders (user_id, total_amount, address, phone, status) VALUES (?, ?, ?, ?, 'Waiting')");
            mysqli_stmt_bind_param($order, 'idss', $userId, $total, $address, $phone);
            mysqli_stmt_execute($order);
            $orderId = mysqli_insert_id($conn);
            $detail = mysqli_prepare($conn, 'INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
            $stock = mysqli_prepare($conn, 'UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?');
            foreach ($items as [$id, $quantity, $price]) {
                mysqli_stmt_bind_param($detail, 'iiid', $orderId, $id, $quantity, $price);
                mysqli_stmt_execute($detail);
                mysqli_stmt_bind_param($stock, 'ii', $quantity, $id);
                mysqli_stmt_execute($stock);
            }
            mysqli_commit($conn);
            unset($_SESSION['cart']);
            $_SESSION['order_success'] = true;
            header('Location: index.php');
            exit();
        } catch (Throwable $e) {
            mysqli_rollback($conn);
            $error_message = $e instanceof RuntimeException ? $e->getMessage() : 'Could not place the order. Please try again.';
        }
    }
}

include 'includes/header.php';
?>

<?php if ($error_message): ?><p role="alert" style="color:#b91c1c;text-align:center"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
<div class="login-container">
    <div class="login-card" style="max-width: 500px;">
        <h2>Checkout Details</h2>
        <p style="color: #777; margin-bottom: 20px;">Please provide your shipping information.</p>

        <form action="checkout.php" method="POST">
            <div class="form-group">
                <label for="address">Full Delivery Address</label>
                <textarea id="address" name="address" rows="3" required style="width: 100%; padding: 12px; border: 2px solid var(--light-green); border-radius: 10px; outline: none;"></textarea>
            </div>

            <div class="form-group">
                <label for="phone">Contact Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="e.g. 05xxxxxxxxx" required>
            </div>

            <div style="background-color: var(--light-green); padding: 10px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; color: var(--dark-green);">
                💳 Payment Method: Cash on Delivery (Kapıda Ödeme)
            </div>

            <button type="submit" name="place_order" class="btn-submit">Confirm & Place Order</button>
        </form>

        <p class="register-link"><a href="cart.php">⬅ Go back to Cart</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>