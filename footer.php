<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <link href="admin/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="admin/assets/css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="admin/assets/css/style.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
/* style.css */
footer {
    background-color: #000;
    color: #fff;
    padding: 10px 0;
    /* Kurangi padding atas dan bawah */
    font-family: Arial, sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
    text-align: left;
}

.footer-section {
    flex: 1;
    min-width: 200px;
    margin: 5px;
    /* Kurangi margin antar section */
}

.footer-logo {
    max-width: 150px;
    margin-bottom: 10px;
    /* Kurangi margin bawah logo */
}

.footer-section h3 {
    font-size: 18px;
    margin-bottom: 5px;
    /* Kurangi margin bawah heading */
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 5px;
    /* Kurangi margin bawah list item */
}

.footer-section ul li a {
    color: #fff;
    text-decoration: none;
}

.footer-section ul li a:hover {
    text-decoration: underline;
}

.footer-section p {
    margin: 5px 0;
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #444;
    padding-top: 5px;
    /* Kurangi padding atas */
    margin-top: 10px;
    /* Kurangi margin atas */
}

.footer-bottom p {
    margin: 0;
}

.footer-social a {
    color: #fff;
    margin: 0 5px;
    /* Kurangi margin antar icon sosial */
    text-decoration: none;
    font-size: 18px;
}

.footer-social a:hover {
    color: #ddd;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
    }

    .footer-section {
        margin: 10px 0;
        /* Kurangi margin antar section pada layar kecil */
        text-align: center;
    }

    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }

    .footer-social {
        margin-top: 5px;
        /* Kurangi margin atas */
    }
}
</style>

<body>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3><strong>Toko Alwi</strong></h3>
                <ul>
                    <li style="font-size: 16px;"><a href="index.php" style="text-decoration: none;">Beranda</a></li>
                    <li style="font-size: 16px;"><a href="produk.php" style="text-decoration: none;">Produk</a></li>
                    <?php if (!isset($_SESSION['pelanggan'])): ?>
                    <li style="font-size: 16px;"><a href="tentangkami.php" style="text-decoration: none;">Tentang
                            Kami</a></li>
                    <?php else: ?>
                    <li style="font-size: 16px;"><a href="keranjang.php" style="text-decoration: none;">Keranjang</a>
                    </li>
                    <li style="font-size: 16px;"><a href="checkout.php" style="text-decoration: none;">Checkout</a></li>
                    <li style="font-size: 16px;"><a href="riwayat.php" style="text-decoration: none;">Riwayat
                            Checkout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="footer-section">
                <h3><strong>Layanan Kami</strong></h3>
                <ul>
                    <li style="font-size: 16px;"><a href="" style="text-decoration: none;">Pengiriman</a></li>
                    <li style="font-size: 16px;"><a href="" style="text-decoration: none;">Kontak</a>
                    </li>
                </ul>
            </div>
            <div class="footer-section">
                <h3><strong>Hubungi Kami</strong></h3>
                <p>
                    <i class="fa fa-map-marker"></i> Jl. Teratai 2, Wanajaya, Kec. Cibitung, Kabupaten
                    Bekasi, Jawa
                    Barat 17520
                </p>
                <p>
                    <i class="fa fa-envelope-o"></i> tokoalwi@gmail.com
                </p>
                <p>
                    <strong>CS Toko Alwi</strong>
                </p>
                <p>
                    <i class="fa fa-phone"></i> +62 812-8766-5556
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            <p><strong>©2024 by Aldy Syahputra Harianja. All Right Reserved</strong></p>
            <div class="footer-social">
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin-square"></i></a>
            </div>
        </div>
    </footer>
</body>

</html>