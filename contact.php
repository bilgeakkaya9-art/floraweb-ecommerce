<?php
// Session başlatma kontrolü (Zeynep'in mantığı)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php';

$message_status = "";

// Form gönderildiğinde çalışacak PHP kodu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_message'])) {
    $name = htmlspecialchars($_POST['name']);
    // Zeynep'in başarı mesajını neon konsepte uydurduk
    $message_status = "<div class='neon-success-alert'>Thank you for reaching out, <strong>$name</strong>! We will get back to you soon. 🌸</div>";
}
?>

<style>
    /* 1. RENKLER VE ÖZEL ÇİÇEK İMLEÇ (CURSOR) */
    :root {
        --bg-pink: #FFF0F5;
        --primary-pink: #FFB6C1;
        --light-green: #E8F5E9;
        --dark-green: #6B8E23;
    }

    body {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>🌸</text></svg>") 16 16, auto;
    }

    a,
    button,
    input[type="submit"],
    .btn-submit {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>👆</text></svg>") 16 0, pointer;
    }

    /* 2. HAREKETLİ SOFT ARKA PLAN (İndex.php ile aynı) */
    .premium-contact-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 85vh;
        padding: 60px 20px;
        /* İndex.php ile aynı arka plan kodları */
        background: linear-gradient(-45deg, #ffffff, #FFF0F5, #ffffff, #E8F5E9);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* 3. CAM EFEKTLİ NEON İLETİŞİM KARTI */
    .contact-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        padding: 50px;
        border-radius: 30px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 600px;
        text-align: center;
        border: 2px solid rgba(255, 182, 193, 0.4);
        transition: all 0.4s ease;
    }

    .contact-card:hover {
        border-color: var(--light-green);
        box-shadow: 0 0 30px rgba(107, 142, 35, 0.2), 0 0 15px rgba(255, 182, 193, 0.3);
    }

    .contact-card h1 {
        color: var(--dark-green);
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 38px;
        font-family: 'Playfair Display', serif;
        text-shadow: 0 0 15px rgba(107, 142, 35, 0.2);
    }

    .contact-card p {
        color: #555555;
        margin-bottom: 35px;
        font-size: 16px;
        line-height: 1.6;
    }

    /* 4. BAŞARI MESAJI (Neon Glow Effect) */
    .neon-success-alert {
        background: rgba(107, 142, 35, 0.1);
        color: var(--dark-green);
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        border: 1px solid var(--dark-green);
        font-weight: bold;
        box-shadow: 0 0 15px rgba(107, 142, 35, 0.3);
        animation: pulseAlert 2s infinite alternate;
    }

    @keyframes pulseAlert {
        0% {
            box-shadow: 0 0 15px rgba(107, 142, 35, 0.2);
        }

        100% {
            box-shadow: 0 0 25px rgba(107, 142, 35, 0.6);
        }
    }

    /* 5. FORM ELEMANLARI TASARIMI */
    .form-group {
        text-align: left;
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        color: #555;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 15px;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid var(--light-green);
        border-radius: 15px;
        box-sizing: border-box;
        outline: none;
        transition: all 0.3s;
        font-family: 'Arial', sans-serif;
        font-size: 15px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--primary-pink);
        box-shadow: 0 0 15px rgba(255, 182, 193, 0.4);
        background: #ffffff;
    }

    /* 6. NEON GÖNDER BUTONU */
    .btn-submit {
        width: 100%;
        padding: 16px;
        background-color: var(--dark-green);
        color: #ffffff;
        border: none;
        border-radius: 25px;
        font-weight: bold;
        font-size: 18px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(107, 142, 35, 0.3);
        letter-spacing: 1px;
    }

    .btn-submit:hover {
        background-color: var(--primary-pink);
        color: var(--dark-green);
        transform: translateY(-3px);
        box-shadow: 0 0 25px rgba(255, 182, 193, 0.7);
    }
</style>

<div class="premium-contact-wrapper">
    <div class="contact-card">

        <h1>Contact Us 🌸</h1>
        <p>Have any questions or want to order a special boutique bouquet? Send us a message and we'll craft the perfect response!</p>

        <?php echo $message_status; ?>

        <form id="contactForm" action="contact.php" method="POST">
            <div class="form-group">
                <label for="contactName">YOUR NAME</label>
                <input type="text" id="contactName" name="name" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label for="contactEmail">EMAIL ADDRESS</label>
                <input type="email" id="contactEmail" name="email" placeholder="john@example.com" required>
            </div>

            <div class="form-group">
                <label for="contactMessage">YOUR MESSAGE</label>
                <textarea id="contactMessage" name="message" rows="5" placeholder="How can we help you today?" required></textarea>
            </div>

            <button type="submit" name="submit_message" class="btn-submit">Send Message</button>
        </form>

    </div>
</div>

<?php include 'includes/footer.php'; ?>