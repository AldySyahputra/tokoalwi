<?php
    session_start();
    include 'koneksi.php';

    // Periksa apakah id_produk ada di URL
    if (!isset($_GET["id"]) || empty($_GET["id"])) {
        echo "ID produk tidak ditemukan.";
        exit;
    }

    $id_produk = $_GET["id"];

    // Ambil data produk dari database
    $ambil = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$id_produk'");
    $detail = $ambil->fetch_assoc();

    // Periksa apakah produk ditemukan
    if (!$detail) {
        echo "Produk tidak ditemukan.";
        exit;
    }
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
    .col-md-6 {
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
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="foto_produk_terpisah/<?php echo $detail['foto_terpisah']; ?>"
                        style="height: 450px; margin-bottom: 30px; margin-top: 30px;" class="img-responsive">
                </div>
                <div class="col-md-6">
                    <h3><strong><?php echo $detail["nama_produk"]; ?></strong></h3>
                    <h4><strong>Rp. <?php echo number_format($detail["harga_eceran"]); ?></strong></h4>
                    <h5 style="color: #03AC0E"><strong>Stok <?php echo $detail['stok_terpisah']; ?></strong></h5>

                    <form action="" method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="1" class="form-control" name="jumlah"
                                    max="<?php echo $detail['stok_terpisah']; ?>">
                                <div class="input-group-btn mt-3">
                                    <button class="btn btn-primary btn-custom" name="beli"> <i class="fa fa-plus"></i>
                                        <strong>Keranjang</strong></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["beli"])) {
                        $jumlah = $_POST["jumlah"];
                        if (is_numeric($jumlah) && $jumlah > 0) {
                            $_SESSION["keranjang"]["$id_produk"] = $jumlah;

                            // update stok
                            $koneksi->query("UPDATE produk_terpisah SET stok_terpisah=stok_terpisah - $jumlah WHERE id_produk_terpisah='$id_produk'");

                            echo "<script>alert('Produk telah masuk kedalam keranjang');</script>";
                            echo "<script>location='keranjang.php';</script>";
                        } else {
                            echo "<script>alert('Jumlah tidak valid');</script>";
                        }
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
                            <td>Formulasi</td>
                            <td>
                                <?php
                                if (!empty($detail["berat_rencengan"])) {
                                    echo $detail["berat_rencengan"] . " Renceng";
                                } elseif (!empty($detail["berat_kiloan"])) {
                                    echo $detail["berat_kiloan"] . " kg";
                                } elseif (!empty($detail["berat_literan"])) {
                                    echo $detail["berat_literan"] . " liter";
                                } elseif (!empty($detail["berat_satuan"])) {
                                    echo $detail["berat_satuan"] . " satuan";
                                } else {
                                    echo "Tidak tersedia";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Masa Penyimpanan</td>
                            <td><?php echo $detail["masa_penyimpanan"]; ?></td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td><?php echo $detail["stok_terpisah"]; ?></td>
                        </tr>
                    </table>
                    <h4><strong>Deskripsi Produk</strong></h4>
                    <p style="text-align: justify;"><?php echo $detail["deskripsi_produk"]; ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="admin/assets/js/bootstrap.min.js"></script>

</body>

</html>