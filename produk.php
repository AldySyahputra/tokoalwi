<?php
    session_start();
    include 'koneksi.php';

    // Tentukan jumlah produk per halaman
    $produk_per_halaman = 8;

    // Ambil halaman saat ini dari URL, jika tidak ada default ke halaman 1
    $halaman_saat_ini = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    $offset = ($halaman_saat_ini - 1) * $produk_per_halaman;

    // Hitung total produk
    $total_produk_query = $koneksi->query("SELECT COUNT(*) as total FROM (
        SELECT id_produk FROM produk
        UNION ALL
        SELECT id_produk_terpisah FROM produk_terpisah
    ) as total_produk");
    $total_produk = $total_produk_query->fetch_assoc()['total'];
    $total_halaman = ceil($total_produk / $produk_per_halaman);

    // Ambil produk untuk halaman saat ini
    $ambil = $koneksi->query("SELECT 'produk' as tipe, id_produk as id, nama_produk, harga_produk as harga, foto_produk as foto FROM produk
                              UNION ALL
                              SELECT 'produk_terpisah' as tipe, id_produk_terpisah as id, nama_produk, harga_eceran as harga, foto_terpisah as foto FROM produk_terpisah
                              ORDER BY RAND()
                              LIMIT $produk_per_halaman OFFSET $offset");
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
    <title>Online Shop || Produk</title>
    <style>
    .btn-primary.btn-custom {
        background-color: #03AC0E;
        color: white;
    }

    .btn-primary.btn-custom:hover {
        background-color: #03AC0E;
        color: white;
    }

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

    .produk {
        text-align: center;
    }

    @media (max-width: 767px) {
        .col-xs-12.col-sm-6.col-md-3.mb-3 {
            width: 50%;
            float: left;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .navbar-form {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .input-group {
            width: 100%;
        }

        .input-group .form-control {
            width: 80%;
        }

        .input-group-btn {
            width: 20%;
        }

        .produk {
            text-align: center;
            width: 100%;
        }

        /* Tambahan untuk responsif */
        .card {
            margin-bottom: 20px;
        }

        .thumbnail img {
            height: auto;
            width: 100%;
        }

        .caption {
            padding: 10px;
        }

        .banner-caption {
            text-align: center;
        }

        .col-md-6 img {
            width: 100%;
        }
    }

    /* CSS untuk pagination */
    .pagination .page-link {
        color: #03AC0E;
    }

    .pagination .page-item.active .page-link {
        background-color: #03AC0E;
        border-color: #03AC0E;
    }

    .pagination .page-link:hover {
        background-color: #03AC0E;
        border-color: #03AC0E;
        color: white;
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
                    <h1 style="color: black;"><strong>Produk</strong></h1>
                    <p style="text-align: justify; color:black;">
                        Temukan berbagai macam produk berkualitas dengan harga terjangkau. Kami menyediakan berbagai
                        jenis produk mulai dari kebutuhan sehari-hari.
                        <br><br>
                        Setiap produk yang kami tawarkan telah melalui proses seleksi yang ketat untuk memastikan
                        kualitas terbaik bagi Anda. Dengan harga yang kompetitif, kami berkomitmen untuk memberikan
                        pengalaman berbelanja yang menyenangkan dan memuaskan.
                        <br><br>
                        Belanja sekarang dan nikmati kemudahan berbelanja online dengan layanan pengiriman cepat dan
                        aman.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <img src="banner/banner.png" alt="">
            </div>
        </div>
    </div>

    <!-- konten -->
    <div class="container">
        <div class="row">
            <h1 class="produk" style="color: black;"><strong>Produk</strong></h1>
        </div>
        <div class="row">
            <form action="pencarian.php" method="get" class="navbar-form navbar-right"
                style="margin-top: 10px; margin-bottom: 15px;">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari Produk">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-custom" type="submit"><i class="fa fa-search"></i>
                            <strong>Cari Produk</strong></button>
                    </span>
                </div>
            </form>
        </div>
        <div class="row">
            <?php 
    $counter = 0;
    while($perproduk = $ambil->fetch_assoc()) : 
        if ($counter % 4 == 0 && $counter != 0) {
            echo '</div><div class="row">'; // Menambahkan baris baru setelah setiap 4 produk
        }
    ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                <!-- Ubah kolom menjadi 3 untuk 4 produk per baris -->
                <!-- Mengubah kolom untuk responsif -->
                <div class="card h-100">
                    <div class="thumbnail">
                        <img src="<?= $perproduk['tipe'] == 'produk' ? 'foto_produk/' : 'foto_produk_terpisah/'; ?><?= $perproduk['foto']; ?>"
                            class="card-img-top img-fluid" alt="<?= $perproduk['nama_produk']; ?>"
                            style="object-fit: cover; height: 200px; width: 100%;">
                        <div class="caption p-2">
                            <h5 class="text-truncate" style="max-width: 100%;"><?= $perproduk['nama_produk']; ?></h5>
                            <p>Rp. <?= number_format($perproduk['harga']); ?></p>
                            <div class="d-flex justify-content-between">
                                <a href="<?= $perproduk['tipe'] == 'produk' ? 'detail.php' : 'detail_terpisah.php'; ?>?id=<?= $perproduk['id']; ?>"
                                    class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i>
                                    <strong>Beli</strong></a>
                                <a href="<?= $perproduk['tipe'] == 'produk' ? 'detail.php' : 'detail_terpisah.php'; ?>?id=<?= $perproduk['id']; ?>"
                                    class="btn btn-secondary btn-sm"><i class="fa fa-book"></i>
                                    <strong>Detail</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        $counter++;
    endwhile; 
    ?>
        </div>

        <!-- Navigasi Pagination -->
        <div class="row text-center">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if($halaman_saat_ini > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halaman_saat_ini - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $total_halaman; $i++): ?>
                    <li class="page-item <?= $i == $halaman_saat_ini ? 'active' : ''; ?>">
                        <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if($halaman_saat_ini < $total_halaman): ?>
                    <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halaman_saat_ini + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script>
    function scrollToContent() {
        document.querySelector('.container').scrollIntoView({
            behavior: 'smooth'
        });
    }
    </script>

</body>

</html>