<?php
    session_start();
    include 'koneksi.php';

    $id_pembelian = $_GET["id"];

    $ambil = $koneksi->query("SELECT 
                            pembayaran.*, 
                            pembelian.*, 
                            pembelian_produk.*, 
                            pelanggan.*, 
                            ongkir.nama_kota AS kota_ongkir, 
                            ongkir.tarif AS tarif_ongkir,
                            produk.nama_produk AS nama_produk,
                            produk_terpisah.nama_produk AS nama_produk
                        FROM pembelian 
                        LEFT JOIN pembayaran ON pembayaran.id_pembelian = pembelian.id_pembelian 
                        LEFT JOIN pembelian_produk ON pembelian_produk.id_pembelian = pembelian.id_pembelian 
                        LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembelian.id_pelanggan 
                        LEFT JOIN ongkir ON pembelian.id_ongkir = ongkir.id_ongkir
                        LEFT JOIN produk ON pembelian_produk.id_produk = produk.id_produk
                        LEFT JOIN produk_terpisah ON pembelian_produk.id_produk = produk_terpisah.id_produk_terpisah
                        WHERE pembelian.id_pembelian = '$id_pembelian'
                    ");
$detbay = $ambil->fetch_assoc();

    // Data yang belum melakukan pembayaran
    if(empty($detbay)) {
        echo "<script>alert('Anda tidak bisa mengakses dikarenakan anda belum membayar tagihan anda');</script>";
        echo "<script>location='riwayat.php';</script>";
        exit();
    }

    // Data pelanggan yang bayar tidak sesuai dengan yang login
    if($_SESSION["pelanggan"]["id_pelanggan"]!==$detbay["id_pelanggan"]) {
        echo "<script>alert('Anda tidak berhak melihat pembayaran orang lain');</script>";
        echo "<script>location='riwayat.php';</script>";
        exit();
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
    <title>Online Shop || Detail Pembayaran</title>
</head>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2
            style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; color: #03AC0E;">
            <strong>Toko Alwi</strong>
        </h2>
        <p><strong>Invoice Toko Alwi</strong> <br>
            Invoice ini merupakan pembayaran yang sah, dan diterbitkan atas nama Partner :
        </p>
        <img src="admin/assets/img/logo1.png" width="150" height="50"> <br>
        <strong>Nama : </strong><?php echo $detbay['nama_pelanggan']; ?> <br>
        <strong>Tanggal : </strong><?php echo date("d F Y",strtotime($detbay['tanggal'])); ?>

        <div class="row" style="margin-top: 15px;">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Status</th>
                            <th><?php echo $detbay['status_pembelian']; ?></th>
                        </tr>
                        <tr>
                            <th>Produk</th>
                            <th>
                                <?php
                                $ambil_produk = $koneksi->query("SELECT 
                                                                pembelian_produk.jumlah,
                                                                pembelian_produk.id_produk
                                                            FROM pembelian_produk
                                                            WHERE pembelian_produk.id_pembelian = '$id_pembelian'");
                                $nomor = 1;
                                while($row = $ambil_produk->fetch_assoc()) {
                                    $id_produk = $row['id_produk'];
                                    $nama_produk = "Produk tidak ditemukan";

                                    // Cek di tabel produk
                                    $ambil_produk_detail = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                                    if ($ambil_produk_detail->num_rows > 0) {
                                        $data_produk = $ambil_produk_detail->fetch_assoc();
                                        $nama_produk = $data_produk['nama_produk'];
                                    }

                                    // Cek di tabel produk_terpisah
                                    $ambil_produk_terpisah = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$id_produk'");
                                    if ($ambil_produk_terpisah->num_rows > 0) {
                                        $data_produk_terpisah = $ambil_produk_terpisah->fetch_assoc();
                                        $nama_produk = $data_produk_terpisah['nama_produk'];
                                    }

                                    echo '<div style="display: flex; align-items: center;">';
                                    echo '<span style="display: inline-block; width: 20px;">' . $nomor . '.</span>';
                                    echo '<span style="display: inline-block; width: 400px;">' . $nama_produk . '</span>';
                                    echo '</div>';
                                    $nomor++;
                                }
                            ?>
                            </th>
                        </tr>
                        <tr>
                            <th>No. Pelanggan</th>
                            <th><?php echo $detbay['telepon_pelanggan']; ?></th>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <th><?php echo $detbay['nama_pelanggan']; ?></th>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <th><?php echo $detbay['alamat_pelanggan']; ?></th>
                        </tr>
                        <tr>
                            <th>Total Tagihan</th>
                            <th>Rp. <?php echo number_format($detbay['total_pembelian']); ?></th>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <th><?php echo $detbay['metode_pembayaran']; ?></th>
                        </tr>
                        <?php if($detbay['metode_pembayaran'] !== 'Cash on Delivery (COD)'): ?>
                        <tr>
                            <th>Bank</th>
                            <th><?php echo $detbay['bank']; ?></th>
                        </tr>
                        <tr>
                            <th>No. Rekening</th>
                            <th><?php echo $detbay['no_rekening']; ?></th>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <p style="font-size: 15px; margin-top: -20px"><strong>Biaya Ongkir</strong> <span
                        style="margin-left: 350px">Rp<?php echo number_format($detbay['tarif']); ?></span></p>
                <p style="font-size: 15px;"><strong>TOTAL PEMBAYARAN :</strong></p>
                <hr>
                <p style="font-size: 15px; margin-top: -20px"><strong>Total Bayar</strong> <span
                        style="color: #03AC0E; margin-left: 350px">Rp<?php echo number_format($detbay['total_pembelian']); ?></span>
                </p>

            </div>
            <div class="col-md-6">
                <img src="bukti_pembayaran/<?php echo $detbay['bukti']; ?>" alt="" class="img-responsive">
            </div>
        </div>

        <p><strong>Detail Periode Terbayar</strong></p>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Periode</th>
                            <th><?php echo date("d F Y",strtotime($detbay['tanggal'])); ?></th>
                        </tr>
                        <tr>
                            <th>Tagihan</th>
                            <th>Rp. <?php echo number_format($detbay['total_pembelian']); ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <a class="btn btn-primary" href="download_pdf.php?id=<?php echo $id_pembelian ?>"><i class="fa fa-print"></i>
            Print Invoice</a>
    </div>

</body>

</html>