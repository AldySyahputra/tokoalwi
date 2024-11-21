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
    <link href="admin/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="admin/assets/css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/style.css">
    <title>Online Shop || Note</title>
</head>

<style>
.btn-secondary.btn-custom {
    background-color: #03AC0E;
    color: white;
}

.btn-secondary.btn-custom:hover {
    background-color: #03AC0E;
    color: white;
}
</style>

<body>
    <?php include 'navbar.php'; ?>

    <section class="konten">
        <div class="container">
            <h2 style="color: #03AC0E;"><strong>Detail Pesanan</strong></h2>
            <img src="./admin/assets/img/logo1.png" style="width: 120px; margin-top: 10px;">

            <?php
                $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$_GET[id]'");
                $detail = $ambil->fetch_assoc();
                $idpelangganyangbeli = $detail["id_pelanggan"];
                $idpelangganyanglogin = $_SESSION["pelanggan"]["id_pelanggan"];

                if($idpelangganyangbeli !== $idpelangganyanglogin) {
                    echo "<script>alert('Jangan asal melihat noted orang lain !!');</script>";
                    echo "<script>location='riwayat.php';</script>";
                    exit();
                }
            ?>

            <div class="row">
                <div class="col-md-4">
                    <h3>Pembelian :</h3>
                    <strong>No. Resi : <?php echo $detail['resi_pengiriman']; ?></strong> <br>
                    Tanggal : <?php echo date("d F Y", strtotime($detail['tanggal_pembelian'])); ?> <br>
                    Total : Rp. <?php echo number_format($detail['total_pembelian']); ?>
                </div>
                <div class="col-md-4">
                    <h3>Pelanggan :</h3>
                    <strong>NAMA : <?php echo $detail['nama_pelanggan']; ?></strong> <br>
                    No. Tel : <?php echo $detail['telepon_pelanggan']; ?> <br>
                    Email : <?php echo $detail['email_pelanggan']; ?>
                </div>
                <div class="col-md-4">
                    <h3>Pengiriman :</h3>
                    <strong>Ongkos Pengiriman : Rp. <?php echo number_format($detail['tarif']); ?></strong> <br>
                    Alamat Pengiriman : <?php echo $detail['alamat_pengiriman']; ?> <br>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Berat</th>
                        <th>Jumlah</th>
                        <th>Sub Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor = 1; 
                        $total_belanja = 0;
                        $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'");
                        while($pecah = $ambil->fetch_assoc()) {
                            $id_produk = $pecah['id_produk'];
                            $harga_produk = 0;
                            $berat_produk = 0;
                            $nama_produk = "Produk tidak ditemukan";
                            $satuan_berat = "";

                            // Cek di tabel produk
                            $ambil_produk = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                            if ($ambil_produk->num_rows > 0) {
                                $data_produk = $ambil_produk->fetch_assoc();
                                $harga_produk = isset($data_produk['harga_produk']) ? $data_produk['harga_produk'] : 0;
                                $berat_produk = isset($data_produk['ukuran_produk']) ? $data_produk['ukuran_produk'] : 0;
                                $nama_produk = $data_produk['nama_produk'];
                                $satuan_berat = isset($data_produk['satuan_berat']) ? $data_produk['satuan_berat'] : "";
                            }

                            // Cek di tabel produk_terpisah
                            $ambil_produk_terpisah = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$id_produk'");
                            if ($ambil_produk_terpisah->num_rows > 0) {
                                $data_produk_terpisah = $ambil_produk_terpisah->fetch_assoc();
                                $harga_produk = isset($data_produk_terpisah['harga_eceran']) ? $data_produk_terpisah['harga_eceran'] : $harga_produk;
                                $berat_produk = 0;
                                $berat_produk += isset($data_produk_terpisah['berat_satuan']) ? floatval($data_produk_terpisah['berat_satuan']) : 0;
                                $berat_produk += isset($data_produk_terpisah['berat_kiloan']) ? floatval($data_produk_terpisah['berat_kiloan']) : 0;
                                $berat_produk += isset($data_produk_terpisah['berat_literan']) ? floatval($data_produk_terpisah['berat_literan']) : 0;
                                $berat_produk += isset($data_produk_terpisah['berat_rencengan']) ? floatval($data_produk_terpisah['berat_rencengan']) : 0;
                                $nama_produk = $data_produk_terpisah['nama_produk'];
                                // Satuan berat tidak ada dalam tabel produk_terpisah, jadi kita bisa menggunakan nilai default atau menghapus baris ini
                                // $satuan_berat = isset($data_produk_terpisah['satuan_berat']) ? $data_produk_terpisah['satuan_berat'] : $satuan_berat;
                            }

                            $subharga = $harga_produk * $pecah['jumlah'];
                            $total_belanja += $subharga;
                    ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $nama_produk; ?></td>
                        <td>Rp. <?php echo number_format($harga_produk); ?></td>
                        <td><?php echo $berat_produk; ?> <?php echo $satuan_berat; ?></td>
                        <td><?php echo $pecah['jumlah']; ?></td>
                        <td>Rp. <?php echo number_format($subharga); ?></td>
                    </tr>
                    <?php 
                            $nomor++; 
                        } 
                        $total_belanja += $detail['tarif'];
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">Total</th>
                        <th>Rp. <?php echo number_format($total_belanja); ?></th>
                    </tr>
                </tfoot>
            </table>

            <!-- Tombol Back -->
            <a href="riwayat.php" class="btn btn-secondary btn-custom"><i class="fa fa-arrow-left"></i>
                <strong>Kembali</strong></a>
        </div>
    </section>

    <script src="admin/assets/js/bootstrap.min.js"></script>

</body>

</html>