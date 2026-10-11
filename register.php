<?php
include 'includes/db_connect.php';
include 'includes/header.php';

$error_message = '';
$success_message = '';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $raw_password = $_POST['password'];

    // --- YENİ EKLENEN ŞİFRE GÜVENLİK KONTROLÜ ---
    // En az 8 karakter, en az 1 büyük harf, en az 1 rakam kontrolü
    if (strlen($raw_password) < 8 || !preg_match('/[A-Z]/', $raw_password) || !preg_match('/[0-9]/', $raw_password)) {
        $error_message = "Password must be at least 8 characters long, contain at least 1 uppercase letter and 1 number.";
    } else {
        // Şifre kurallara uyuyorsa hashle
        $password = password_hash($raw_password, PASSWORD_DEFAULT);

        // E-posta veritabanında var mı diye kontrol et
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "This email address is already registered. Please login.";
        } else {
            // Yeni kullanıcıyı kaydet
            $sql = "INSERT INTO users (name, surname, email, password, role) VALUES ('$name', '$surname', '$email', '$password', 'customer')";

            if (mysqli_query($conn, $sql)) {
                $success_message = "Registration successful! You can now login.";
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
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

    /* Form Ortalama ve Animasyon */
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 75vh;
        background-color: var(--bg-pink, #FFF0F5);
        padding: 40px 20px;
    }

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

    /* YENİ: Silik Şifre Uyarısı Tasarımı */
    .password-hint {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #999;
        /* Silik gri ton */
        font-style: italic;
        line-height: 1.4;
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
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 15px;
    }

    .btn-submit:hover {
        background-color: #55721c;
    }

    /* Alt Kısımdaki Linklerin Ortalanması */
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
        <h2>Create an Account</h2>

        <?php if ($error_message): ?>
            <p style="color: #c0392b; font-weight: bold; margin-bottom: 15px; text-align: center; background: #fde8e8; padding: 10px; border-radius: 5px;">
                <?php echo $error_message; ?>
            </p>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <p style="color: #27ae60; font-weight: bold; margin-bottom: 15px; text-align: center; background: #e8fdf0; padding: 10px; border-radius: 5px;">
                <?php echo $success_message; ?> <br><br>
                <a href="login.php" class="btn-submit" style="text-decoration:none; display: block;">Go to Login</a>
            </p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="name">First Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your first name" required>
            </div>

            <div class="form-group">
                <label for="surname">Last Name</label>
                <input type="text" id="surname" name="surname" placeholder="Enter your last name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
                <small class="password-hint">* Must be at least 8 characters, include 1 uppercase letter and 1 number.</small>
            </div>

            <button type="submit" name="register" class="btn-submit">Register</button>
        </form>

        <div class="register-link">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>