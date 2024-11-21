<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"])) {
        echo "<script>alert('Silahkan login terlebih dahulu');</script>";
        echo "<script>location='login.php';</script>";
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
    <title>Online Shop || Riwayat Pembelian</title>
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
</style>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <section class="riwayat">
        <div class="container">
            <h1 class="text-center" style="color: #03AC0E;"><strong>TOKO ALWI</strong></h1>
            <h5 class="text-center"><i class="fa fa-book"></i> RIWAYAT CHECKOUT
                <strong><?php echo $_SESSION["pelanggan"]["nama_pelanggan"]; ?></strong>
            </h5>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Resi Pengiriman</th>
                            <th>Total Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $nomor = 1;
                    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
                    $ambil = $koneksi->query("
                    SELECT pembelian.*, pembayaran.nama, pembayaran.bank, pembayaran.no_rekening, pembayaran.jumlah, pembayaran.tanggal, pembayaran.bukti, pembayaran.metode_pembayaran 
                    FROM pembelian 
                    LEFT JOIN pembayaran ON pembelian.id_pembelian = pembayaran.id_pembelian 
                    WHERE pembelian.id_pelanggan='$id_pelanggan'
                ");
                    while ($pecah = $ambil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $nomor; ?></td>
                            <td><?php echo date("d F Y", strtotime($pecah["tanggal_pembelian"])); ?></td>
                            <td><?php echo $pecah["status_pembelian"]; ?></td>
                            <td><?php echo $pecah["resi_pengiriman"]; ?></td>
                            <td>Rp. <?php echo number_format($pecah["total_pembelian"]); ?></td>
                            <td><?php echo $pecah["metode_pembayaran"]; ?></td>
                            <td>
                                <a href="note.php?id=<?php echo $pecah["id_pembelian"]; ?>"
                                    class="btn btn-primary btn-sm"><i class="fa fa-file-text"></i>
                                    <strong>Detail Pesanan</strong></a>
                                <?php if ($pecah['status_pembelian'] == "Barang Dalam Pengiriman" || $pecah['status_pembelian'] == "Barang Sudah Sampai"): ?>
                                <a href="lihat_pembayaran.php?id=<?php echo $pecah['id_pembelian']; ?>"
                                    class="btn btn-secondary btn-sm"><i class="fa fa-money"></i>
                                    <strong>Invoice</strong></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $nomor++; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="admin/assets/js/bootstrap.min.js"></script>
</body>

</html>