<?php
// Veritabanı ve session bağlantısı
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/db_connect.php';


$error_message = '';

if (isset($_POST['login'])) {
    // Veritabanı sütun isimlerine (küçük harf) uyumlu hale getirildi
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // SENİN KODUN: Şifre kontrolü güvenli (password_verify) şekilde yapılıyor
        if (password_verify($password, $user['password'])) {

            session_regenerate_id(true);
            // Oturum değişkenleri senin sistemine göre ayarlandı
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];

            // SENİN KODUN: Admin ve Müşteri yönlendirmesi
            if ($user['role'] == 'admin') {
                header("Location: admin/index.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "User not found!";
    }
}
include 'includes/header.php';
?>

<style>
    /* İmleç Ayarları */
    body {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>🌸</text></svg>") 16 16, auto;
    }

    a,
    button,
    input[type="submit"] {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>👆</text></svg>") 16 0, pointer;
    }

    /* Zeynep'in Tam Ekran Ortalama Mantığı */
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 75vh;
        background-color: var(--bg-pink, #FFF0F5);
        padding: 40px 20px;
    }

    /* İçerideki beyaz şık form kutusu ve Zeynep'in Animasyonu */
    .login-card {
        background: #ffffff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border: 2px solid var(--light-green, #E8F5E9);
        width: 100%;
        max-width: 400px;
        animation: pullOutLetter 0.9s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        opacity: 0;
    }

    @keyframes pullOutLetter {
        0% {
            opacity: 0;
            transform: translateY(60px) scale(0.95);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .login-card h2 {
        color: var(--dark-green, #6B8E23);
        margin-bottom: 25px;
        text-align: center;
    }

    /* Input ve Etiket Makyajı */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
    }

    /* Buton Tasarımı */
    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: var(--dark-green, #6B8E23);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background-color: #55721c;
    }

    /* Alt Kısımdaki Link */
    .register-link {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
    }

    .register-link a {
        color: var(--dark-green, #6B8E23);
        font-weight: bold;
        text-decoration: none;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <h2>Login to Your Account</h2>

        <?php if ($error_message): ?>
            <p style="color: #c0392b; font-weight: bold; margin-bottom: 15px; text-align: center; background: #fde8e8; padding: 10px; border-radius: 5px;">
                <?php echo $error_message; ?>
            </p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login" class="btn-submit">Sign In</button>
        </form>

        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>