<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/db_connect.php';


// --- 1. SEPETE ÜRÜN EKLEME ---
if (isset($_POST['add_to_cart'])) {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    if (!$product_id || $product_id < 1) { header('Location: products.php'); exit(); }
    $exists = mysqli_prepare($conn, 'SELECT product_id FROM products WHERE product_id = ?');
    mysqli_stmt_bind_param($exists, 'i', $product_id);
    mysqli_stmt_execute($exists);
    if (!mysqli_fetch_assoc(mysqli_stmt_get_result($exists))) { header('Location: products.php'); exit(); }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    header("Location: cart.php");
    exit();
}

// --- 2. SEPETTEN ÜRÜN SİLME ---
if (isset($_GET['remove'])) {
    $remove_id = filter_input(INPUT_GET, 'remove', FILTER_VALIDATE_INT);
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
}

// --- 3. OTOMATİK MİKTAR GÜNCELLEME (Trendyol Mantığı) ---
if (isset($_POST['update_quantity_flag'])) {
    $update_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    if (!$update_id || $update_id < 1) { header('Location: cart.php'); exit(); }
    $new_quantity = (int)$_POST['quantity'];

    if ($new_quantity > 0) {
        $_SESSION['cart'][$update_id] = $new_quantity; // Miktarı güncelle
    } else {
        unset($_SESSION['cart'][$update_id]); // 0 yaparsa sepetten sil
    }

    header("Location: cart.php");
    exit();
}
include 'includes/header.php';
?>

<style>
    /* İmleçler */
    body {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>🌸</text></svg>") 16 16, auto;
    }

    a,
    button,
    input[type="submit"],
    .btn-remove,
    .btn-checkout {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>👆</text></svg>") 16 0, pointer;
    }

    /* Sepet Tasarımı ve Sündürme Düzeltmesi */
    .cart-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 60px 20px;
        background-color: var(--bg-pink, #FFF0F5);
        min-height: 70vh;
        font-family: 'Arial', sans-serif;
    }

    .cart-container {
        background-color: #ffffff;
        width: 100%;
        max-width: 900px;
        height: fit-content;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 2px solid var(--light-green, #E8F5E9);
    }

    .cart-container h1 {
        color: var(--dark-green, #6B8E23);
        text-align: center;
        margin-top: 0;
        margin-bottom: 30px;
        font-size: 28px;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .cart-table th {
        background-color: var(--light-green, #E8F5E9);
        color: var(--dark-green, #6B8E23);
        padding: 15px;
        text-align: left;
        font-size: 16px;
    }

    .cart-table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
        vertical-align: middle;
    }

    .item-name {
        font-weight: bold;
        color: #333;
    }

    .btn-remove {
        color: #c0392b;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .btn-remove:hover {
        color: #e74c3c;
        text-decoration: underline;
    }

    /* Anında Tepki Veren Input Stili */
    .qty-form {
        display: inline-block;
        margin: 0;
    }

    .qty-input {
        width: 70px;
        padding: 10px;
        border: 2px solid var(--light-green, #E8F5E9);
        border-radius: 10px;
        text-align: center;
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        font-size: 16px;
        color: var(--dark-green, #6B8E23);
        outline: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .qty-input:focus,
    .qty-input:hover {
        border-color: var(--primary-pink, #FFB6C1);
        box-shadow: 0 0 10px rgba(255, 182, 193, 0.3);
    }

    .cart-summary {
        text-align: right;
        padding-top: 20px;
        border-top: 2px solid var(--light-green, #E8F5E9);
    }

    .cart-summary h3 {
        color: #333;
        font-size: 22px;
        margin-bottom: 20px;
    }

    .cart-summary span {
        color: var(--dark-green, #6B8E23);
        font-size: 26px;
    }

    .btn-checkout {
        display: inline-block;
        padding: 14px 40px;
        background-color: var(--dark-green, #6B8E23);
        color: white;
        text-decoration: none;
        border-radius: 30px;
        font-weight: bold;
        font-size: 16px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(107, 142, 35, 0.3);
    }

    .btn-checkout:hover {
        background-color: #55721c;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(107, 142, 35, 0.4);
    }

    .empty-cart {
        text-align: center;
        padding: 40px 0;
    }

    .empty-cart p {
        color: #777;
        font-size: 18px;
        margin-bottom: 25px;
    }
</style>

<div class="cart-wrapper">
    <div class="cart-container">
        <h1>Your Shopping Cart 🛒</h1>

        <?php if (empty($_SESSION['cart'])): ?>

            <div class="empty-cart">
                <p>Your cart is currently empty. Let's find some beautiful flowers! 🌸</p>
                <a href="products.php" class="btn-checkout">Continue Shopping</a>
            </div>

        <?php else: ?>

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;

                    foreach ($_SESSION['cart'] as $id => $quantity):
                        $id = (int)$id;
                        $query = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
                        if ($row = mysqli_fetch_assoc($query)):
                            $subtotal = $row['price'] * $quantity;
                            $total_price += $subtotal;
                    ?>
                            <tr>
                                <td class="item-name"><?php echo $row['product_name']; ?></td>
                                <td>$<?php echo number_format($row['price'], 2); ?></td>

                                <td>
                                    <form action="cart.php" method="POST" class="qty-form">
                                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="update_quantity_flag" value="1">
                                        <input type="number" name="quantity" class="qty-input" value="<?php echo $quantity; ?>" min="0" onchange="this.form.submit()">
                                    </form>
                                </td>

                                <td><strong style="color: var(--primary-pink);">$<?php echo number_format($subtotal, 2); ?></strong></td>
                                <td><a href="cart.php?remove=<?php echo $id; ?>" class="btn-remove">Remove ❌</a></td>
                            </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <h3>Total Amount: <span>$<?php echo number_format($total_price, 2); ?></span></h3>
                <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>