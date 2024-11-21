<?php
    session_start();
    include 'koneksi.php';

    // jika belum login maka akan dilarikan ke login.php
    if(!isset($_SESSION["pelanggan"])) {
        echo "<script>alert('Silahkan Login terlebih dahulu');</script>";
        echo "<script>location='login.php';</script>";
    }

    // jika keranjang kosong maka akan dilarikan ke halaman produk
    if(empty($_SESSION["keranjang"])) {
        echo "<script>alert('Keranjang belanja Anda kosong, silahkan belanja terlebih dahulu');</script>";
        echo "<script>location='produk.php';</script>";
    }

    // jika tidak ada produk yang dipilih maka akan dilarikan ke halaman keranjang
    if(empty($_POST["produk_dipilih"])) {
        echo "<script>alert('Tidak ada produk yang dipilih untuk di-checkout');</script>";
        echo "<script>location='keranjang.php';</script>";
    }

    $produk_dipilih = $_POST["produk_dipilih"];
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
    <title>Online Shop || Checkout</title>
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
</style>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <!-- konten -->
    <section class="konten">
        <div class="container">
            <h1 class="text-center" style="color: #03AC0E;"><strong>TOKO ALWI</strong></h1>
            <h5 class="text-center"><i class="fa fa-shopping-cart"></i> CHECKOUT BELANJA
                <strong><?php echo $_SESSION["pelanggan"]["nama_pelanggan"]; ?></strong>
            </h5>
            <br>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>SubHarga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1; $totalbelanja = 0; ?>
                    <?php foreach ($produk_dipilih as $id_produk): ?>
                    <?php
                        $jumlah = $_SESSION["keranjang"][$id_produk];
                        $id_produk_asli = explode('-eceran', $id_produk)[0];
                        $is_eceran = strpos($id_produk, '-eceran') !== false;

                        $harga_produk = 0;
                        $nama_produk = "Produk tidak ditemukan";

                        // Cek di tabel produk
                        $ambil_produk = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk_asli'");
                        if ($ambil_produk->num_rows > 0) {
                            $data_produk = $ambil_produk->fetch_assoc();
                            $harga_produk = isset($data_produk['harga_produk']) ? $data_produk['harga_produk'] : 0;
                            $nama_produk = $data_produk['nama_produk'];
                        }

                        // Cek di tabel produk_terpisah
                        $ambil_produk_terpisah = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$id_produk_asli'");
                        if ($ambil_produk_terpisah->num_rows > 0) {
                            $data_produk_terpisah = $ambil_produk_terpisah->fetch_assoc();
                            $harga_produk = isset($data_produk_terpisah['harga_eceran']) ? $data_produk_terpisah['harga_eceran'] : $harga_produk;
                            $nama_produk = $data_produk_terpisah['nama_produk'];
                        }

                        $subharga = $harga_produk * $jumlah;
                    ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $nama_produk; ?></td>
                        <td>Rp. <?php echo number_format($harga_produk); ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td>Rp. <?php echo number_format($subharga); ?></td>
                    </tr>
                    <?php $nomor++; $totalbelanja += $subharga; ?>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total Belanja</th>
                        <th>Rp. <?php echo number_format($totalbelanja); ?></th>
                    </tr>
                </tfoot>
            </table>

            <form action="" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" readonly
                                value="<?php echo $_SESSION["pelanggan"]["nama_pelanggan"]; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" readonly
                                value="<?php echo $_SESSION["pelanggan"]["telepon_pelanggan"]; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="id_ongkir" required>
                            <option value="">Kurir Toko Kami</option>
                            <?php
                            $ambil = $koneksi->query("SELECT * FROM ongkir");
                            while ($perongkir = $ambil->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $perongkir["id_ongkir"]; ?>">
                                <?php echo $perongkir["nama_kota"]; ?>
                                Rp. <?php echo number_format($perongkir["tarif"]); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_pengiriman">Alamat Lengkap</label>
                    <textarea class="form-control" name="alamat_pengiriman"
                        placeholder="Masukkan alamat lengkap anda"></textarea>
                </div>
                <button class="btn btn-primary btn-custom" name="checkout"><i class="fa fa-money"></i> <strong>Bayar
                        Produk</strong></button>
                <?php foreach ($produk_dipilih as $id_produk): ?>
                <input type="hidden" name="produk_dipilih[]" value="<?php echo $id_produk; ?>">
                <?php endforeach; ?>
            </form>

            <?php
            if (isset($_POST["checkout"])) {
                $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
                $id_ongkir = $_POST["id_ongkir"];
                $tanggal_pembelian = date("Y-m-d");
                $alamat_pengiriman = $_POST['alamat_pengiriman'];

                $ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
                $arrayongkir = $ambil->fetch_assoc();
                $nama_kota = $arrayongkir['nama_kota'];
                $tarif = $arrayongkir['tarif'];

                $total_pembelian = $totalbelanja + $tarif;

                // Menyimpan data ke tabel pembelian
                $koneksi->query("INSERT INTO pembelian (id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian, nama_kota, tarif, alamat_pengiriman) 
                    VALUES ('$id_pelanggan', '$id_ongkir', '$tanggal_pembelian', '$total_pembelian', '$nama_kota', '$tarif', '$alamat_pengiriman')");

                // Mendapatkan id_pembelian barusan
                $id_pembelian_barusan = $koneksi->insert_id;

                foreach ($_POST["produk_dipilih"] as $id_produk) {
                    $jumlah = $_SESSION["keranjang"][$id_produk];
                    $id_produk_asli = explode('-eceran', $id_produk)[0];
                    $is_eceran = strpos($id_produk, '-eceran') !== false;

                    $harga_produk = 0;
                    $nama_produk = "Produk tidak ditemukan";

                    // Cek di tabel produk
                    $ambil_produk = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk_asli'");
                    if ($ambil_produk->num_rows > 0) {
                        $data_produk = $ambil_produk->fetch_assoc();
                        $harga_produk = isset($data_produk['harga_produk']) ? $data_produk['harga_produk'] : 0;
                        $nama_produk = $data_produk['nama_produk'];
                    }

                    // Cek di tabel produk_terpisah
                    $ambil_produk_terpisah = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$id_produk_asli'");
                    if ($ambil_produk_terpisah->num_rows > 0) {
                        $data_produk_terpisah = $ambil_produk_terpisah->fetch_assoc();
                        $harga_produk = isset($data_produk_terpisah['harga_eceran']) ? $data_produk_terpisah['harga_eceran'] : $harga_produk;
                        $nama_produk = $data_produk_terpisah['nama_produk'];
                    }

                    $subharga = $harga_produk * $jumlah;

                    $koneksi->query("INSERT INTO pembelian_produk (id_pembelian, id_produk, nama, harga, subharga, jumlah) 
                        VALUES ('$id_pembelian_barusan', '$id_produk_asli', '$nama','$harga_produk', '$subharga', '$jumlah')");

                    // Update stok produk
                    if ($is_eceran) {
                        $koneksi->query("UPDATE produk SET stok_eceran = stok_eceran - $jumlah WHERE id_produk = '$id_produk_asli'");
                    } else {
                        $koneksi->query("UPDATE produk SET stok_produk = stok_produk - $jumlah WHERE id_produk = '$id_produk_asli'");
                    }
                }

                // Kosongkan keranjang belanja
                foreach ($_POST["produk_dipilih"] as $id_produk) {
                    unset($_SESSION["keranjang"][$id_produk]);
                }

                // Redirect ke halaman nota, nota.php?id=ID_PEMBELIAN_BARUSAN
                echo "<script>location='pembayaran.php?id=$id_pembelian_barusan';</script>";
            }
            ?>
        </div>
    </section>

    <script src="admin/assets/js/bootstrap.min.js"></script>
    <script src="admin/assets/js/jquery-1.10.2.js"></script>
    <script src="admin/assets/js/jquery.min.js"></script>
</body>

</html>