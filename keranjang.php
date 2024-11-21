<?php
    session_start();
    include 'koneksi.php';

    // Cek apakah pengguna sudah login
    if (!isset($_SESSION["pelanggan"])) {
        echo "<script>alert('Silahkan login terlebih dahulu');</script>";
        echo "<script>location='login.php';</script>";
        exit();
    }

    // jika keranjang kosong maka akan dilarikan ke halaman produk
    if(empty($_SESSION["keranjang"])) {
        echo "<script>alert('Keranjang belanja Anda kosong, silahkan belanja terlebih dahulu');</script>";
        echo "<script>location='produk.php';</script>";
    }
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
    <title>Online Shop || Keranjang</title>
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

    <!-- konten -->
    <section class="konten">
        <div class="container">
            <h1 class="text-center" style="color: #03AC0E;"><strong>TOKO ALWI</strong></h1>
            <h5 class="text-center"><i class="fa fa-shopping-cart"></i> KERANJANG BELANJA
                <strong><?php echo $_SESSION["pelanggan"]["nama_pelanggan"]; ?></strong>
            </h5>
            <form action="checkout.php" method="post">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>SubHarga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor=1; $totalbelanja = 0; ?>
                        <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
                        <?php
                            // Pisahkan ID produk dan penanda eceran jika ada
                            $id_produk_asli = explode('-eceran', $id_produk)[0];
                            $is_eceran = strpos($id_produk, '-eceran') !== false;

                            // Inisialisasi variabel
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
                            $totalbelanja += $subharga;
                        ?>
                        <tr>
                            <td><input type="checkbox" name="produk_dipilih[]" value="<?php echo $id_produk; ?>"></td>
                            <td><?php echo $nomor; ?></td>
                            <td><?php echo $nama_produk; ?></td>
                            <td>Rp. <?php echo number_format($harga_produk); ?></td>
                            <td><?php echo $jumlah; ?></td>
                            <td>Rp. <?php echo number_format($subharga); ?></td>
                            <td>
                                <a href="hapuskeranjang.php?id=<?php echo $id_produk; ?>" class="btn btn-danger btn-xs"
                                    onclick="return confirm('Yakin mau hapus?')"><i
                                        class="glyphicon glyphicon-trash"></i>
                                    Hapus</a>
                            </td>
                        </tr>
                        <?php $nomor++; ?>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total</th>
                            <th>Rp. <?php echo number_format($totalbelanja); ?></th>
                        </tr>
                    </tfoot>
                </table>
                <a href="produk.php" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i>
                    <strong>Lanjutkan
                        Belanja</strong></a>
                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-credit-card"></i>
                    <strong>Checkout</strong></button>
            </form>
        </div>
    </section>

    <script src="admin/assets/js/bootstrap.min.js"></script>
</body>

</html>