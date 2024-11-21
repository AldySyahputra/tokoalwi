<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"])) {
        echo "<script>alert('Silahkan login terlebih dahulu');</script>";
        echo "<script>location='login.php';</script>";
        exit();
    }

    $idpem = $_GET["id"];
    $ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$idpem'");
    $detpem = $ambil->fetch_assoc();

    $id_pelanggan_beli = $detpem["id_pelanggan"];
    $id_pelanggan_login = $_SESSION["pelanggan"]["id_pelanggan"];

    if($id_pelanggan_beli!==$id_pelanggan_login) {
        echo "<script>alert('Jangan asal melihat noted orang lain !!');</script>";
        echo "<script>location='riwayat.php';</script>";
        exit();
    }

    $produk_dipilih = isset($_POST["produk_dipilih"]) ? $_POST["produk_dipilih"] : [];
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
    <title>Online Shop || Pembayaran Produk</title>
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

    <div class="container">
        <h2 style="color: #03AC0E;"><strong>Konfirmasi Pembayaran</strong></h2>
        <img src="admin/assets/img/logo1.png" style="width: 120px; margin-top: 10px;">

        <div class="alert alert-success" style="margin-top: 15px;">Total tagihan anda <strong
                style="color: #03AC0E;">Rp.
                <?php echo number_format($detpem["total_pembelian"]) ?></strong></div>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama">
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" name="jumlah" min="1"
                    value="<?php echo $detpem['total_pembelian']; ?>">
            </div>
            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" onchange="toggleFoto()">
                    <option value="">Silahkan Pilih</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="Cash on Delivery (COD)">Cash on Delivery (COD)</option>
                </select>
            </div>
            <div class="form-group" id="virtual-account-group">
                <label for="virtual_account">Bank</label>
                <select class="form-control" name="bank" id="bank" onchange="updateNoRekening()">
                    <option value="">Pilih Bank</option>
                    <option value="BRI" data-rekening="7257 0100 4926 503">BRI</option>
                </select>
            </div>
            <div class="form-group" id="no-rekening-group">
                <label for="no_rekening">No. Rekening</label>
                <input type="text" class="form-control" name="no_rekening" id="no_rekening">
            </div>
            <div class=" form-group" id="foto-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto">
                <p class="text-danger">Foto bukti harus JPG maksimal 2MB</p>
            </div>
            <button class="btn btn-primary btn-custom" name="kirim"><i class="glyphicon glyphicon-envelope"></i>
                <strong>Kirim Pembayaran</strong></button>
        </form>
    </div>

    <?php
        if(isset($_POST["kirim"])) {
            $namabukti = $_FILES["foto"]["name"];
            $lokasibukti = $_FILES["foto"]["tmp_name"];
            $namafiks = date("YmdHis").$namabukti;
            move_uploaded_file($lokasibukti, "bukti_pembayaran/$namafiks");

            $nama = $_POST["nama"];
            $bank = $_POST["bank"];
            $jumlah = $_POST["jumlah"];
            $tanggal = date("Y-m-d");
            $metode_pembayaran = $_POST["metode_pembayaran"];
            $no_rekening = $_POST["no_rekening"];

            // simpan bukti pembayaran
            $koneksi->query("INSERT INTO pembayaran(id_pembelian, nama, bank, no_rekening, jumlah, tanggal, bukti, metode_pembayaran) VALUES ('$idpem', '$nama', '$bank', '$no_rekening', '$jumlah', '$tanggal', '$namafiks', '$metode_pembayaran')");

            // update data pembelian 
            $koneksi->query("UPDATE pembelian SET status_pembelian='Sudah kirim pembayaran' WHERE id_pembelian='$idpem'");

            echo "<script>alert('Terimakasih sudah mengirimkan bukti pembayaran');</script>";
            echo "<script>location='riwayat.php';</script>";
        }
    ?>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="admin/assets/js/bootstrap.min.js"></script>
    <script src="admin/assets/js/jquery.min.js"></script>


    <script>
    function toggleFoto() {
        var metodePembayaran = document.getElementById("metode_pembayaran").value;
        var fotoGroup = document.getElementById("foto-group");
        var fotoInput = document.getElementById("foto");
        var virtualAccountGroup = document.getElementById("virtual-account-group");
        var noRekeningGroup = document.getElementById("no-rekening-group");

        if (metodePembayaran === "Cash on Delivery (COD)") {
            fotoGroup.style.display = "none";
            fotoInput.disabled = true;
            virtualAccountGroup.style.display = "none";
            noRekeningGroup.style.display = "none";
        } else {
            fotoGroup.style.display = "block";
            fotoInput.disabled = false;
            virtualAccountGroup.style.display = "block";
            noRekeningGroup.style.display = "block";
        }
    }

    function updateNoRekening() {
        var bankSelect = document.getElementById("bank");
        var selectedOption = bankSelect.options[bankSelect.selectedIndex];
        var noRekening = selectedOption.getAttribute("data-rekening");
        document.getElementById("no_rekening").value = noRekening ? noRekening : "";
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        toggleFoto();
    });
    </script>
</body>

</html>