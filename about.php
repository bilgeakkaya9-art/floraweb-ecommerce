<?php
include 'includes/db_connect.php';
// Header bağlantısını aktif ettik! Artık CSS ve menüler çalışacak.
include 'includes/header.php';
?>

<style>
    /* Özel Çiçek İmleç (Cursor) Ayarları */
    body {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>🌸</text></svg>") 16 16, auto;
    }

    /* Tıklanabilir Alanlar İçin Parmak İmleci */
    a,
    button,
    .feature-item,
    input[type="submit"] {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>👆</text></svg>") 16 0, pointer;
    }

    /* Hakkımızda Sayfasına Özel Premium Dokunuşlar */
    .premium-about-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        padding: 60px 20px;
        background-color: var(--bg-pink, #FFF0F5);
        gap: 40px;
    }

    .about-card {
        background-color: #ffffff;
        padding: 50px;
        border-radius: 25px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 900px;
        text-align: center;
        border: 2px solid var(--light-green, #E8F5E9);
    }

    .about-card h1 {
        color: var(--dark-green, #6B8E23);
        margin-bottom: 25px;
        font-size: 36px;
        font-family: 'Playfair Display', serif;
    }

    .about-card p.main-desc {
        color: #555555;
        line-height: 1.8;
        font-size: 18px;
        margin-bottom: 40px;
        padding: 0 20px;
    }

    .about-features {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 40px;
    }

    .feature-item {
        background-color: var(--bg-pink, #FFF0F5);
        padding: 25px;
        border-radius: 20px;
        flex: 1;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #FFB6C1;
    }

    .feature-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(255, 182, 193, 0.3);
    }

    .feature-item h3 {
        color: var(--dark-green, #6B8E23);
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 20px;
    }

    .feature-item p {
        font-size: 15px;
        margin: 0;
        color: #666;
        line-height: 1.6;
    }

    /* ESMA'NIN NEON MISYON & VIZYON KARTLARI */
    .mission-vision-container {
        display: flex;
        gap: 30px;
        width: 100%;
        max-width: 900px;
    }

    .neon-card {
        flex: 1;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 35px 25px;
        border-radius: 25px;
        text-align: center;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .neon-card p {
        color: #555;
        line-height: 1.7;
        font-size: 16px;
        position: relative;
        z-index: 2;
    }

    /* FloraWeb Yeşili Neon Etkisi (Vision) */
    .neon-green {
        border: 2px solid var(--dark-green);
        box-shadow: 0 0 15px rgba(107, 142, 35, 0.2),
            inset 0 0 20px rgba(107, 142, 35, 0.1);
    }

    .neon-green h2 {
        color: var(--dark-green);
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
        text-shadow: 0 0 10px rgba(107, 142, 35, 0.4);
        /* Yazıya hafif glow */
    }

    .neon-green:hover {
        transform: translateY(-10px);
        box-shadow: 0 0 25px rgba(107, 142, 35, 0.6),
            inset 0 0 30px rgba(107, 142, 35, 0.3);
    }

    /* FloraWeb Pembesi Neon Etkisi (Mission) */
    .neon-pink {
        border: 2px solid var(--primary-pink);
        box-shadow: 0 0 15px rgba(255, 182, 193, 0.4),
            inset 0 0 20px rgba(255, 182, 193, 0.2);
    }

    .neon-pink h2 {
        color: #e85a71;
        /* Pembenin daha okunaklı ve parlayan tonu */
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
        text-shadow: 0 0 10px rgba(255, 182, 193, 0.8);
        /* Yazıya hafif glow */
    }

    .neon-pink:hover {
        transform: translateY(-10px);
        box-shadow: 0 0 25px rgba(255, 182, 193, 0.8),
            inset 0 0 30px rgba(255, 182, 193, 0.4);
    }
</style>

<div class="premium-about-wrapper">

    <div class="about-card">
        <h1>About FloraWeb 🌸</h1>
        <p class="main-desc">Welcome to FloraWeb, where nature meets elegance. We are a dedicated team of florists and computer engineers bringing you the freshest flowers and most beautiful arrangements for your special moments.</p>

        <div class="about-features">
            <div class="feature-item">
                <h3>Fresh Blooms</h3>
                <p>We handpick our flowers daily to ensure they stay fresh and beautiful.</p>
            </div>
            <div class="feature-item">
                <h3>Fast Delivery</h3>
                <p>Our team ensures your orders are delivered on time, with perfect care.</p>
            </div>
        </div>
    </div>

    <div class="mission-vision-container">

        <div class="neon-card neon-pink">
            <h2>Our Mission</h2>
            <p>To spread joy, love, and comfort through the universal language of flowers. We strive to provide unparalleled quality and a seamless digital shopping experience, connecting people with nature's finest creations one bouquet at a time.</p>
        </div>

        <div class="neon-card neon-green">
            <h2>Our Vision</h2>
            <p>To become the leading online floral boutique, recognized for our innovative designs, sustainable sourcing, and a technological infrastructure that redefines how emotions are delivered in the modern world.</p>
        </div>

    </div>

</div>

<?php
include 'includes/footer.php';
?>