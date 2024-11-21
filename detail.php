<?php
    session_start();
    include 'koneksi.php';

    $id_produk = $_GET["id"];

    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
    $detail = $ambil->fetch_assoc();
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
    <title>Online Shop || Detail Produk</title>
</head>

<style>
.btn-primary.btn-custom {
    background-color: #03AC0E;
    color: white;
}

.btn-primary.btn-custom:hover {
    background-color: #03AC0E;
    color: white;
}

@media (max-width: 767px) {
    .col-md-6 img {
        width: 100%;
        float: none;
        margin-bottom: 20px;
    }

    .img-responsive {
        width: 50%;
        height: auto;
    }
}
</style>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <section class="konten">
        <section class="konten">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="foto_produk/<?php echo $detail['foto_produk']; ?>"
                            style="height: 450px; margin-bottom: 30px; margin-top: 30px;" class="img-responsive">
                    </div>
                    <div class="col-md-6">
                        <h3><strong><?php echo $detail["nama_produk"]; ?></strong></h3>
                        <h4><strong>Rp. <?php echo number_format($detail["harga_produk"]); ?></strong></h4>
                        <h5 style="color: #03AC0E"><strong>Stok : <?php echo $detail['stok_produk']; ?></strong></h5>

                        <form action="" method="post">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control" name="jumlah"
                                        max="<?php echo $detail['stok_produk']; ?>">
                                    <div class="input-group-btn mt-3">
                                        <button class="btn btn-primary btn-custom" name="beli"> <i
                                                class="fa fa-plus"></i>
                                            <strong>Keranjang</strong></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php
                        if(isset($_POST["beli"])) {
                            $jumlah = $_POST["jumlah"];
                            $_SESSION["keranjang"]["$id_produk"] = $jumlah;

                            // update stok
                            $koneksi->query("UPDATE produk SET stok_produk=stok_produk -$jumlah WHERE id_produk='$id_produk'");

                            echo "<script>alert('Produk telah masuk kedalam keranjang');</script>";
                            echo "<script>location='keranjang.php';</script>";
                        }
                    ?>
                        <!-- Tambahkan informasi spesifikasi produk -->
                        <h4><strong>Spesifikasi Produk</strong></h4>
                        <table class="table">
                            <tr>
                                <td>Merek</td>
                                <td><?php echo $detail["merek"]; ?></td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td><?php echo $detail["jenis"]; ?></td>
                            </tr>
                            <tr>
                                <td>Berat Produk</td>
                                <td><?php echo $detail["ukuran_produk"]; ?> kg</td>
                            </tr>
                            <tr>
                                <td>Masa Penyimpanan</td>
                                <td><?php echo $detail["masa_penyimpanan"]; ?></td>
                            </tr>
                            <tr>
                                <td>Stok</td>
                                <td><?php echo $detail["stok_produk"]; ?></td>
                            </tr>
                        </table>
                        <h4><strong>Deskripsi Produk</strong></h4>
                        <p style="text-align: justify;"><?php echo $detail["deskripsi_produk"]; ?></p>
                    </div>
                </div>
        </section>

        <!-- footer -->
        <?php include 'footer.php'; ?>

        <script src="admin/assets/js/bootstrap.min.js"></script>

</body>

</html>