<?php
    session_start();
    include 'koneksi.php';

    $keyword = $_GET['keyword'];
    $semuadata = array();

    // Tentukan jumlah produk per halaman
    $produk_per_halaman = 8;

    // Ambil halaman saat ini dari URL, jika tidak ada default ke halaman 1
    $halaman_saat_ini = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    $offset = ($halaman_saat_ini - 1) * $produk_per_halaman;

    // Query untuk mencari produk berdasarkan nama produk dan nama kategori dari kedua tabel
    $query = "(SELECT produk.id_produk, produk.nama_produk, produk.harga_produk AS harga, produk.foto_produk, kategori.nama_kategori, 'produk' AS tipe_produk 
            FROM produk 
            JOIN kategori ON produk.id_kategori = kategori.id_kategori 
            WHERE produk.nama_produk LIKE ?)
            UNION
            (SELECT produk_terpisah.id_produk_terpisah AS id_produk, produk_terpisah.nama_produk, produk_terpisah.harga_eceran AS harga, produk_terpisah.foto_terpisah AS foto_produk, kategori.nama_kategori, 'produk_terpisah' AS tipe_produk 
            FROM produk_terpisah 
            JOIN kategori ON produk_terpisah.id_kategori = kategori.id_kategori 
            WHERE produk_terpisah.nama_produk LIKE ?)
            LIMIT ? OFFSET ?";

    $stmt = $koneksi->prepare($query);

    $keyword = "%$keyword%";
    $stmt->bind_param("ssii", $keyword, $keyword, $produk_per_halaman, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $semuadata[] = $row;
    }

    // Hitung total produk yang sesuai dengan kata kunci pencarian
    $total_produk_query = $koneksi->prepare("(SELECT COUNT(*) as total FROM produk 
                                              JOIN kategori ON produk.id_kategori = kategori.id_kategori 
                                              WHERE produk.nama_produk LIKE ?)
                                              UNION ALL
                                              (SELECT COUNT(*) as total FROM produk_terpisah 
                                              JOIN kategori ON produk_terpisah.id_kategori = kategori.id_kategori 
                                              WHERE produk_terpisah.nama_produk LIKE ?)");
    $total_produk_query->bind_param("ss", $keyword, $keyword);
    $total_produk_query->execute();
    $total_produk_result = $total_produk_query->get_result();
    $total_produk = 0;
    while ($row = $total_produk_result->fetch_assoc()) {
        $total_produk += $row['total'];
    }
    $total_halaman = ceil($total_produk / $produk_per_halaman);
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

    .back {
        color: #03AC0E;
        font-size: 16px;
        margin-left: 15px;
    }

    .back:hover {
        color: #03AC0E;
        font-size: 16px;
        text-decoration: none;
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

    /* CSS untuk pagination responsif */
    @media (max-width: 767px) {
        .pagination {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
    }
    </style>
</head>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <a href="produk.php" class="back"><i class="fa fa-arrow-left"></i> Kembali ke
                    Produk</a>
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
                <h3 style="margin-left: 15px;">Pencarian :
                    <strong><?php echo htmlspecialchars($_GET['keyword']); ?></strong>
                </h3>
            </div>

            <?php if(empty($semuadata)): ?>
            <div class="alert alert-danger text-center">Produk
                <strong><?php echo htmlspecialchars($_GET['keyword']); ?></strong> tidak ditemukan
            </div>
            <?php endif ?>

            <div class="row">
                <?php foreach($semuadata as $key => $value): ?>
                <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="thumbnail">
                            <?php
                                $foto = $value['foto_produk'];
                                $id_produk = $value['id_produk'];
                                $tipe_produk = $value['tipe_produk'];
                                $foto_path = ($tipe_produk == 'produk') ? 'foto_produk/' : 'foto_produk_terpisah/';
                            ?>
                            <img src="<?= $foto_path . $foto; ?>" class="card-img-top img-fluid"
                                alt="<?= htmlspecialchars($value['nama_produk']); ?>"
                                style="object-fit: cover; height: 200px; width: 100%;">
                            <div class="caption p-2">
                                <h5 class="text-truncate" style="max-width: 100%;">
                                    <?= htmlspecialchars($value['nama_produk']); ?></h5>
                                <p>Rp. <?= number_format($value['harga']); ?></p>
                                <div class="d-flex justify-content-between">
                                    <a href="<?= $tipe_produk == 'produk' ? 'detail.php' : 'detail_terpisah.php'; ?>?id=<?= $id_produk; ?>"
                                        class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i>
                                        <strong>Beli</strong></a>
                                    <a href="<?= $tipe_produk == 'produk' ? 'detail.php' : 'detail_terpisah.php'; ?>?id=<?= $id_produk; ?>"
                                        class="btn btn-secondary btn-sm"><i class="fa fa-book"></i>
                                        <strong>Detail</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>

            <!-- Navigasi Pagination -->
            <div class="row text-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if($halaman_saat_ini > 1): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="?keyword=<?= urlencode($_GET['keyword']); ?>&halaman=<?= $halaman_saat_ini - 1; ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for($i = 1; $i <= $total_halaman; $i++): ?>
                        <li class="page-item <?= $i == $halaman_saat_ini ? 'active' : ''; ?>">
                            <a class="page-link"
                                href="?keyword=<?= urlencode($_GET['keyword']); ?>&halaman=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if($halaman_saat_ini < $total_halaman): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="?keyword=<?= urlencode($_GET['keyword']); ?>&halaman=<?= $halaman_saat_ini + 1; ?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

</body>

</html>