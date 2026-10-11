<?php
include 'includes/db_connect.php';
include 'includes/header.php';
?>

<style>
    /* 1. RENKLER VE ÖZEL ÇİÇEK İMLEÇ (CURSOR) */
    :root {
        --bg-pink: #FFF0F5;
        --primary-pink: #FFB6C1;
        --light-green: #E8F5E9;
        --dark-green: #6B8E23;
    }

    /* Tüm sayfada çiçek imleci - Tıklama noktası tam merkeze alındı */
    body {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>🌸</text></svg>") 16 16, auto;
    }

    /* Tıklanabilir alanlarda parmak imleci - Tıklama noktası parmağın ucuna alındı */
    a,
    button,
    .add-cart-btn,
    input[type="submit"] {
        cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'><text y='24' font-size='24'>👆</text></svg>") 16 0, pointer;
    }

    /* 2. HAREKETLİ SOFT ARKA PLAN (Ana sayfadaki gibi) */
    .products-page-container {
        padding: 60px 20px;
        background: linear-gradient(-45deg, #ffffff, #FFF0F5, #ffffff, #E8F5E9);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        min-height: 80vh;
        font-family: 'Arial', sans-serif;
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

    /* 3. BAŞLIK TASARIMI */
    .page-title {
        text-align: center;
        margin-bottom: 50px;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        padding: 30px;
        border-radius: 25px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        border: 2px solid rgba(255, 182, 193, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .page-title h1 {
        font-size: 42px;
        color: var(--dark-green);
        font-family: 'Playfair Display', serif;
        margin-top: 0;
        margin-bottom: 10px;
        text-shadow: 0 0 15px rgba(107, 142, 35, 0.2);
    }

    .page-title p {
        color: #666;
        font-size: 18px;
        margin: 0;
    }

    /* 4. PREMIUM IZGARA VE CAM EFEKTLİ KARTLAR */
    .product-page-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 35px;
        max-width: 1300px;
        margin: 0 auto;
    }

    .product-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        border: 2px solid transparent;
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* KARTLARA PASTEL NEON HOVER EFEKTİ */
    .product-card:hover {
        transform: translateY(-15px);
        border-color: var(--light-green);
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(107, 142, 35, 0.2), 0 0 25px rgba(255, 182, 193, 0.5);
    }

    .product-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 20px;
        transition: 0.5s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card h3 {
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .product-card p {
        font-size: 22px;
        color: var(--dark-green);
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* NEON BUTON UYARLAMASI */
    .add-cart-btn {
        display: block;
        width: 100%;
        background-color: var(--dark-green);
        color: white;
        padding: 14px 20px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        border-radius: 20px;
        font-weight: bold;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(107, 142, 35, 0.2);
    }

    .add-cart-btn:hover {
        background-color: var(--primary-pink);
        color: var(--dark-green);
        transform: translateY(-3px);
        box-shadow: 0 0 20px rgba(255, 182, 193, 0.8);
    }

    /* Mobil Uyumluluk */
    @media (max-width: 1024px) {
        .product-page-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .product-page-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<main class="products-page-container">

    <div class="page-title">
        <h1>Our Premium Collection</h1>
        <p>Explore our boutique bouquets freshly picked and arranged just for you.</p>
    </div>

    <div class="product-page-grid">

        <?php
        // Esma'nın Veritabanı Bağlantısı
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                // Zeynep'in resim formatını otomatik oluştur (örn: "Red Tulip" -> "red-tulip.jpg.png")
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
            echo "<div style='grid-column: 1 / -1; text-align: center; padding: 50px;'><p style='color: #777; font-size: 20px;'>No flowers available yet. Please tell the admin to add some!</p></div>";
        }
        ?>

    </div>
</main>

<?php include 'includes/footer.php'; ?>