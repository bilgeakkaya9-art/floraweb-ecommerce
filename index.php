<?php
include 'includes/db_connect.php';
include 'includes/header.php';
?>
<?php if (!empty($_SESSION['order_success'])): unset($_SESSION['order_success']); ?>
<script>alert('Your order was placed successfully!');</script>
<?php endif; ?>
<style>
    * {
        box-sizing: border-box;
    }

    /* Tüm sayfada çiçek imleci */
    body {
        margin: 0;
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>🌸</text></svg>") 16 16, auto;
    }

    /* Tıklanabilir alanlarda parmak imleci */
    a,
    button,
    .btn-shop,
    .add-cart-btn,
    input[type="submit"] {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>👆</text></svg>") 16 0, pointer;
    }

    /* 2. HAREKETLİ SOFT ARKA PLAN */
    .premium-home-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 20px;
        background: linear-gradient(-45deg, #ffffff, #FFF0F5, #ffffff, #E8F5E9);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        min-height: 80vh;
        font-family: 'Arial', sans-serif;
        overflow-x: hidden;
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

    /* 3. DEVASA VE PASTEL NEON SLIDER */
    .slider-container {
        position: relative;
        width: 100%;
        max-width: 1400px;
        height: 650px;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 0 40px rgba(255, 182, 193, 0.6), 0 0 80px rgba(107, 142, 35, 0.2);
        margin-bottom: 70px;
        border: 2px solid #ffffff;
    }

    .slider-wrapper {
        display: flex;
        width: 200%;
        height: 100%;
        animation: slideAnimation 14s infinite cubic-bezier(0.8, 0, 0.2, 1);
    }

    .slide {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0.9) 0%, transparent 70%);
        z-index: 1;
    }

    .slide-content {
        position: relative;
        z-index: 2;
        text-align: left;
        max-width: 550px;
        margin-right: auto;
        margin-left: 100px;
        color: var(--dark-green);
        padding: 40px;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 25px;
        border: 2px solid rgba(255, 182, 193, 0.5);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        animation: floatUp 2s ease-in-out infinite alternate;
    }

    @keyframes floatUp {
        0% {
            transform: translateY(0px);
        }

        100% {
            transform: translateY(-10px);
        }
    }

    .slide-content h2 {
        font-size: 55px;
        margin: 0;
        font-family: 'Playfair Display', serif;
        color: var(--dark-green);
        text-shadow: 2px 2px 10px rgba(107, 142, 35, 0.2);
    }

    .slide-content p {
        font-size: 20px;
        margin: 20px 0 30px;
        font-weight: bold;
        color: #555;
    }

    .slide:nth-child(1) {
        background-image: url('assets/images/carnation.jpg');
    }

    .slide:nth-child(2) {
        background-image: url('assets/images/red-carnation.jpg');
    }

    @keyframes slideAnimation {

        0%,
        45% {
            transform: translateX(0);
        }

        50%,
        95% {
            transform: translateX(-50%);
        }

        100% {
            transform: translateX(0);
        }
    }

    /* 4. NEDEN BİZ? */
    .features-section {
        display: flex;
        justify-content: center;
        gap: 40px;
        width: 100%;
        max-width: 1200px;
        margin-bottom: 80px;
    }

    .feature-box {
        flex: 1;
        background: rgba(255, 255, 255, 0.8);
        padding: 40px 20px;
        border-radius: 30px;
        text-align: center;
        border: 2px solid transparent;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.03);
    }

    .feature-box i {
        font-size: 50px;
        color: var(--primary-pink);
        margin-bottom: 20px;
        transition: all 0.4s ease;
    }

    .feature-box h3 {
        color: var(--dark-green);
        font-size: 22px;
        margin-bottom: 10px;
    }

    .feature-box p {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
    }

    .feature-box:hover {
        transform: translateY(-15px);
        background: #ffffff;
        border: 2px solid var(--primary-pink);
        box-shadow: 0 0 25px rgba(255, 182, 193, 0.6);
    }

    .feature-box:hover i {
        color: var(--dark-green);
        text-shadow: 0 0 15px rgba(107, 142, 35, 0.5);
        transform: scale(1.2);
    }

    /* 5. VİTRİN KISMI */
    .products-section {
        text-align: center;
        width: 100%;
        max-width: 1400px;
        margin-bottom: 60px;
        background: rgba(255, 255, 255, 0.5);
        padding: 40px 0;
        border-radius: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .products-section h2 {
        color: var(--dark-green);
        margin-bottom: 10px;
        font-size: 36px;
        font-family: 'Playfair Display', serif;
        text-shadow: 0 0 15px rgba(107, 142, 35, 0.3);
    }

    .product-grid {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        gap: 30px;
        width: 100%;
        padding: 30px 20px 50px 20px;
        scroll-behavior: smooth;
    }

    .product-grid::-webkit-scrollbar {
        height: 10px;
    }

    .product-grid::-webkit-scrollbar-thumb {
        background-color: var(--primary-pink);
        border-radius: 10px;
    }

    .product-card {
        background: #ffffff;
        border-radius: 25px;
        padding: 20px;
        min-width: 300px;
        flex: 0 0 auto;
        scroll-snap-align: center;
        box-sizing: border-box;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.4s ease;
        border: 2px solid transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .product-card:hover {
        transform: translateY(-15px);
        border: 2px solid var(--light-green);
        box-shadow: 0 15px 35px rgba(107, 142, 35, 0.2), 0 0 20px rgba(255, 182, 193, 0.4);
    }

    .product-card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 20px;
        transition: 0.5s;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card h3 {
        color: #333;
        font-size: 22px;
        margin: 0 0 10px 0;
        font-weight: bold;
    }

    .product-card p {
        color: var(--dark-green);
        font-weight: bold;
        font-size: 24px;
        margin: 0 0 20px 0;
    }

    .btn-shop,
    .add-cart-btn {
        background-color: var(--dark-green);
        color: white !important;
        border: none;
        border-radius: 25px;
        font-weight: bold;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(107, 142, 35, 0.3);
    }

    .add-cart-btn {
        width: 100%;
        padding: 15px;
        font-size: 16px;
        display: inline-block;
    }

    .btn-shop {
        padding: 15px 40px;
        font-size: 18px;
    }

    .btn-shop:hover,
    .add-cart-btn:hover {
        background-color: var(--primary-pink);
        box-shadow: 0 0 20px rgba(255, 182, 193, 0.8);
        transform: translateY(-3px);
        color: var(--dark-green) !important;
    }

    /* 6. SOL ALT KAPATILABİLİR VİDEO CSS KODLARI */
    .floating-video-widget {
        position: fixed;
        bottom: 20px;
        left: 20px;
        width: 160px;
        border-radius: 15px;
        z-index: 9999;
        box-shadow: 0 8px 20px rgba(255, 182, 193, 0.5);
        border: 2px solid var(--light-green);
        transition: transform 0.3s ease, border-color 0.3s ease, opacity 0.5s ease;
    }

    .floating-video-widget:hover {
        transform: scale(1.05) translateY(-5px);
        border-color: var(--primary-pink);
        box-shadow: 0 12px 25px rgba(107, 142, 35, 0.3);
    }

    .floating-video-widget video {
        width: 100%;
        display: block;
        border-radius: 13px;
        /* Köşeleri dış çerçeveye uydurduk */
        object-fit: cover;
    }

    /* Kapatma Butonu X */
    .close-video-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: var(--primary-pink);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        transition: transform 0.2s, background-color 0.2s;
    }

    .close-video-btn:hover {
        background-color: #e83e8c;
        transform: scale(1.2);
    }
</style>

<div class="premium-home-wrapper">

    <div class="slider-container">
        <div class="slider-wrapper">
            <div class="slide">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <h2>Fresh Blooms,<br>Sweet Moments</h2>
                    <p>Hand-crafted boutique bouquets designed to make every second special. Delivered with love.</p>
                    <a href="products.php" class="btn-shop">Explore Collection</a>
                </div>
            </div>
            <div class="slide">
                <div class="slide-overlay"></div>
                <div class="slide-content" style="border-color: rgba(107, 142, 35, 0.5);">
                    <h2 style="color: var(--primary-pink);">Celebrate Spring</h2>
                    <p>Upgrade your space with nature's finest colors. Explore our flower collection!</p>
                    <a href="products.php" class="btn-shop" style="background-color: var(--primary-pink); color: var(--dark-green) !important;">Claim My Discount</a>
                </div>
            </div>
        </div>
    </div>

    <div class="features-section">
        <div class="feature-box">
            <i class="fa-solid fa-leaf"></i>
            <h3>100% Fresh</h3>
            <p>Our flowers are sourced directly from local farms every single morning to ensure maximum vitality.</p>
        </div>
        <div class="feature-box">
            <i class="fa-solid fa-truck-fast"></i>
            <h3>Express Delivery</h3>
            <p>Same-day delivery available. We bring nature's beauty directly to your doorstep safely.</p>
        </div>
        <div class="feature-box">
            <i class="fa-solid fa-heart"></i>
            <h3>Made with Love</h3>
            <p>Every bouquet is hand-crafted by expert florists who pour their passion into every detail.</p>
        </div>
    </div>

    <section id="products-showcase" class="products-section">
        <h2>Our Premium Collection</h2>
        <p style="color: #666; margin-bottom: 30px; font-size: 18px;">Swipe to discover our most loved arrangements 🌸</p>

        <div class="product-grid">
            <?php
            $sql = "SELECT * FROM products LIMIT 10";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $img_name = strtolower(str_replace(' ', '-', $row['product_name'])) . '.jpg.png';
                    if (!is_file(__DIR__ . '/assets/images/' . $img_name)) { $img_name = 'floraweb-logo.png'; }
            ?>
                    <div class="product-card">
                        <img src="assets/images/<?php echo $img_name; ?>" alt="<?php echo $row['product_name']; ?>" onerror="this.onerror=null;this.src='assets/images/floraweb-logo.png'">
                        <h3><?php echo $row['product_name']; ?></h3>
                        <p>$<?php echo $row['price']; ?></p>

                        <form action="cart.php" method="POST" style="width: 100%;">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                            <button type="submit" name="add_to_cart" class="add-cart-btn"><i class="fa-solid fa-cart-plus" style="margin-right: 5px;"></i>Add to Cart</button>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<p style='color: #777;'>No flowers available yet.</p>";
            }
            ?>
        </div>
    </section>

</div>

<div class="floating-video-widget" id="promoVideo">
    <button class="close-video-btn" onclick="document.getElementById('promoVideo').style.display='none'">✖</button>
    <video autoplay loop muted playsinline>
        <source src="assets/images/floraweb-video.mp4" type="video/mp4">
        Tarayıcınız video etiketini desteklemiyor.
    </video>
</div>

<?php include 'includes/footer.php'; ?>