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
    <title>Online Shop</title>
</head>

<style>
.btn-primary.btn-sm {
    background-color: white;
    color: #03AC0E;
}

.btn-primary.btn-sm:hover {
    background-color: white;
    color: #03AC0E;
}

.btn-secondary.btn-sm {
    background-color: #03AC0E;
    color: white;
}

.btn-secondary.btn-sm:hover {
    background-color: #03AC0E;
    color: white;
}

.banner {
    background-color: #dadada;
}

.banner-caption h1 {
    margin-top: 100px
}

.produkfavorit {
    text-align: center;
}

.img-fluid1 {
    width: 80%;
    margin-left: -103px;
    margin-top: 50px;
}

.img-fluid2 {
    width: 80%;
    margin-left: 170px;
    margin-top: 50px;
}

.banner {
    margin-left: -30px;
}

.overlay-text h1 {
    margin-top: 65px;
}

.card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.thumbnail {
    flex-grow: 1;
}

@media (max-width: 767px) {
    .col-xs-12.col-sm-6.col-md-3 {
        margin-bottom: 15px;
        /* Jarak bawah untuk perangkat kecil */
    }

    .img-fluid1,
    .img-fluid2 {
        width: 100%;
        /* Ubah lebar gambar menjadi 100% */
        margin-left: 0;
        /* Hapus margin kiri */
    }

    .banner-caption h1 {
        font-size: 30px;
        margin-top: 10px;
        /* Sesuaikan ukuran font untuk perangkat kecil */
    }

    .overlay-text h1 {
        font-size: 30px;
        margin-left: 10px;
        /* Sesuaikan ukuran font untuk perangkat kecil */
    }

    .overlay-text p {
        margin-left: 13px;
        /* Sesuaikan ukuran font untuk perangkat kecil */
    }

    .col-md-6 img {
        width: 100%;
    }
}

/* Tambahan untuk perangkat besar */
@media (min-width: 768px) {

    .img-fluid1,
    .img-fluid2 {
        width: 80%;
        /* Kembalikan lebar gambar untuk perangkat besar */
    }

    .col-md-3 {
        margin-bottom: 30px;
        /* Jarak bawah untuk perangkat besar */
    }
}
</style>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <!-- banner -->
    <div class="container-fluid banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="banner-caption">
                        <h1 style="color: black;"><strong>Selamat Datang di Toko Alwi</strong></h1>
                        <p>Tempat terbaik untuk menemukan produk berkualitas dengan harga terjangkau.</p>
                        <a href="produk.php" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i> <strong>Lihat
                                Semua Produk</strong></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="banner/banner.png" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- produk terfavorit -->
    <section class="container-fluid">
        <div class="container">
            <div class="row">
                <h1 class="produkfavorit" style="color: black;"><strong>Produk Favorit</strong></h1>
            </div>
            <div class="row">
                <?php 
            $ambil = $koneksi->query("SELECT * FROM produk ORDER BY RAND() LIMIT 4"); // Mengambil 4 produk secara acak
            while($perproduk = $ambil->fetch_assoc()) : 
            ?>
                <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="thumbnail">
                            <img src="foto_produk/<?= $perproduk['foto_produk']; ?>" class="card-img-top img-fluid"
                                alt="<?= $perproduk['nama_produk']; ?>"
                                style="object-fit: cover; height: 200px; width: 100%;">
                            <div class="caption p-2">
                                <h5 class="text-truncate" style="max-width: 100%;"><?= $perproduk['nama_produk']; ?>
                                </h5>
                                <p>Rp. <?= number_format($perproduk['harga_produk']); ?></p>
                                <div class="d-flex justify-content-between">
                                    <a href="detail.php?id=<?= $perproduk['id_produk']; ?>"
                                        class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i>
                                        <strong>Beli</strong></a>
                                    <a href="detail.php?id=<?= $perproduk['id_produk']; ?>"
                                        class="btn btn-secondary btn-sm"><i class="fa fa-book"></i>
                                        <strong>Detail</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- tentang kami -->
    <div class="container-fluid banner">
        <div class="container">
            <div class="row">
                <div class="col-md-4 d-none d-md-block">
                    <img src="banner/tentangkami2.png" class="img-fluid1" alt="Left Image">
                </div>
                <div class="col-md-4 text-center my-auto">
                    <div class="banner">
                        <div class="overlay-text mx-auto" style="max-width: 400px; margin: 0 auto;">
                            <h1 style="color: black;"><strong>Tentang Kami</strong></h1>
                            <p style="color: black;">
                                Toko Alwi hadir untuk melayani kebutuhan Anda dengan sepenuh hati. Kami menyediakan
                                berbagai macam produk dengan harga yang kompetitif dan kualitas terbaik.
                            </p>
                            <a href="tentangkami.php" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i>
                                <strong>Lihat Tentang Kami</strong></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-none d-md-block">
                    <img src="banner/tentangkami1.png" class="img-fluid2" alt="Right Image">
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div style="margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>

    <script src="admin/assets/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>