<?php
    session_start();
    include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <!-- FONTAWESOME STYLES-->
    <link href="admin/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="admin/assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="admin/assets/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Online Shop || Tentang Kami</title>
    <style>
    .contact-section {
        background-color: #f8f9fa;
        /* Warna latar belakang yang sesuai */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .responsive-img {
        max-width: 100%;
        height: auto;
        margin-top: 20px;
        margin-left: 0;
    }

    @media (min-width: 768px) {
        .responsive-img {
            margin-top: 200px;
            margin-left: 130px;
        }
    }

    .banner {
        background-color: #dadada;
    }

    @media (max-width: 767px) {
        .banner-caption {
            text-align: center;
        }

        .banner-caption h1 {
            margin-top: -50px;
        }
    }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center" style="position: relative;">
        <div class="container text-white">
            <div class="col-md-6" style="margin-top: 10px;">
                <div class="banner-caption">
                    <br>
                    <br>
                    <br>
                    <h1 style="color: black;"><strong>Tentang Kami</strong></h1>
                    <p style="text-align: justify; color:black;">
                        Buka setiap hari, siap melayani Anda dari pukul 07.00 pagi hingga 19.00 malam.<br>
                        <br>
                        Tutup toko, setiap hari sabtu dan minggu<br>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <img src="banner/banner.png" alt="">
            </div>
        </div>
    </div>

    <!-- main -->
    <div class="container-fluid py-5">
        <div class="container fs-5">
            <div class="row">
                <div class="col-md-6 text-md-start">
                    <h1 style="color: black;"><strong>Tentang Kami</strong></h1>
                    <p style="text-align: justify; color: black;">
                        Toko Alwi berdiri pada tahun 2009 di perumahan Kirana CIbitung, tepatnya di Jalan Anggrek Nomor
                        12, Toko
                        Alwi hadir untuk melayani kebutuhan
                        Anda dengan sepenuh hati. Kami menyediakan berbagai macam produk dengan harga yang kompetitif
                        dan
                        kualitas terbaik.
                        <br><br>
                        Visi Kami: Menjadi toko pilihan utama bagi masyarakat dengan menyediakan produk berkualitas
                        tinggi dan
                        layanan terbaik. <br>
                        Misi Kami : Menyediakan berbagai macam produk dengan harga yang kompetitif, Memberikan layanan
                        terbaik
                        kepada pelanggan, Menjalin kerjasama yang saling menguntungkan dengan pemasok dan pelanggan,
                        Berkomitmen
                        untuk selalu meningkatkan kualitas produk dan layanan.
                        <br><br>
                        Berlokasi strategis di perumahan Kirana Cibitung, belakang indomaret jembatan pertama, Toko Alwi
                        siap
                        melayani segala kebutuhan Anda. Dengan berbagai produk berkualitas dan harga terjangkau, kami
                        siap
                        menjadi pilihan utama Anda.<br><br>
                        Buka setiap hari, siap melayani Anda dari pukul 07.00 pagi hingga 19.00 malam.<br><br>
                        Tutup toko, setiap hari sabtu dan minggu<br><br>
                        Toko Alwi adalah pilihan tepat untuk Anda yang mencari produk berkualitas tinggi dengan harga
                        yang
                        kompetitif dan layanan terbaik. Kunjungi toko kami sekarang dan rasakan pengalaman berbelanja
                        yang
                        menyenangkan!
                    </p>
                </div>
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <img src="banner/tentangkami.png" alt="Tentang Kami" class="img-fluid responsive-img">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6 text-md-start">
                    <h2 style="color: black;"><strong>Lokasi Toko Kami</strong></h2>
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1980.1234567890123!2d107.1234567890123!3d-6.1234567890123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1234567890123%3A0x1234567890123!2sJl.%20Teratai%202%2C%20Wanajaya%2C%20Kec.%20Cibitung%2C%20Kabupaten%20Bekasi%2C%20Jawa%20Barat%2017520!5e0!3m2!1sen!2sid!4v1234567890123"
                            width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                            aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
                <div class="col-md-6 text-md-start">
                    <h2 style="color: black;"><strong>Hubungi Kami</strong></h2>
                    <form action="send_email.php" method="post" class="contact-section">
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Nama</strong></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>Email</strong></label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label"><strong>Pesan</strong></label>
                            <textarea class="form-control" id="message" name="message" rows="4"
                                placeholder="Tulis pesan Anda di sini" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="margin-top: 10px;">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="admin/assets/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_REAL_API_KEY&callback=initMap"></script>
</body>

</html>