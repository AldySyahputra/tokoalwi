<?php
session_start();
include 'koneksi.php';

// Cek apakah pelanggan sudah login
if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('Anda harus login terlebih dahulu');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

// Ambil data pelanggan dari session
$id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];

// Ambil data pelanggan dari database
$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");
$detail = $ambil->fetch_assoc();

// Proses upload foto
if (isset($_POST["upload_foto"])) {
    $foto_profil = $_FILES["foto_profil"]["name"];
    $lokasi_foto = $_FILES["foto_profil"]["tmp_name"];
    $nama_foto_baru = date("YmdHis") . $foto_profil;
    $folder = "foto_profil/" . $nama_foto_baru;

    // Cek apakah direktori foto_profil ada, jika tidak buat direktori tersebut
    if (!is_dir('foto_profil')) {
        mkdir('foto_profil', 0755, true);
    }

    // Pindahkan file foto ke folder tujuan
    if (move_uploaded_file($lokasi_foto, $folder)) {
        // Simpan path foto ke database
        $koneksi->query("UPDATE pelanggan SET foto_profil='$folder' WHERE id_pelanggan='$id_pelanggan'");

        // Update session
        $_SESSION["pelanggan"]["foto_profil"] = $folder;

        echo "<script>alert('Foto profil berhasil diubah');</script>";
        echo "<script>location='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal mengunggah foto');</script>";
    }
}

// Proses update alamat
if (isset($_POST['update_alamat'])) {
    $alamat_baru = $koneksi->real_escape_string($_POST['alamat_baru']);

    // Update alamat di database
    $koneksi->query("UPDATE pelanggan SET alamat_pelanggan='$alamat_baru' WHERE id_pelanggan='$id_pelanggan'");

    // Refresh halaman untuk menampilkan alamat yang baru
    echo "<script>alert('Alamat berhasil diupdate');</script>";
    echo "<script>location='profile.php';</script>";
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
    <title>Online Shop || Profile</title>
    <style>
    body {
        background-image: url('admin/assets/img/bakground_profil1.jpg');
        background-size: cover;
        background-position: center;
        object-fit: cover;
    }

    .profile-container {
        display: flex;
        justify-content: space-between;
    }

    .profile-left {
        flex: 1;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-right {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .logo-background {
        max-width: 100%;
        height: auto;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .profile-header img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        margin-right: 20px;
    }

    .profile-header h3 {
        margin: 0;
    }

    .profile-section {
        margin-bottom: 20px;
    }

    .profile-section h3 {
        margin-bottom: 10px;
        color: #333;
    }

    .profile-section p {
        margin: 0;
        color: #666;
    }

    .profile-section a {
        color: #007bff;
        text-decoration: none;
    }

    .profile-section a:hover {
        text-decoration: underline;
    }

    .btn-primary.btn-custom {
        background-color: #03AC0E;
        color: white;
    }

    .btn-primary.btn-custom:hover {
        background-color: #03AC0E;
        color: white;
    }

    .profile-header .text {
        color: #000000;
    }

    .profile-section .text {
        color: #000000;
    }

    .btn-primary.btn-custom {
        background-color: #03AC0E;
        color: white;
    }

    .btn-primary.btn-custom:hover {
        background-color: #03AC0E;
        color: white;
    }

    .profile-header .text {
        color: #000000;
    }

    .profile-section .text {
        color: #000000;
    }

    @media (max-width: 768px) {
        .profile-container {
            flex-direction: column;
            /* Mengubah arah flex menjadi kolom pada layar kecil */
        }

        .profile-left,
        .profile-right {
            flex: none;
            /* Menghilangkan flex agar elemen tidak saling bersebelahan */
            width: 100%;
            /* Memastikan lebar 100% pada layar kecil */
            margin-bottom: 20px;
            /* Menambahkan jarak antar elemen */
        }

        .profile-header img {
            width: 30px;
            /* Mengurangi ukuran gambar profil pada layar kecil */
            height: 30px;
            /* Mengurangi ukuran gambar profil pada layar kecil */
        }

        .profile-header h3 {
            font-size: 18px;
            /* Mengurangi ukuran font pada layar kecil */
        }

        .btn-primary.btn-custom {
            width: 100%;
            /* Tombol akan mengambil lebar penuh pada layar kecil */
        }
    }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1 class="text-center" style="color: black;"><strong> Profile</strong></h1><br>
        <div class="profile-container">
            <div class="profile-left">
                <div class="profile-header">
                    <img src="<?php echo empty($detail['foto_profil']) ? 'admin/assets/img/find_user.png' : $detail['foto_profil']; ?>"
                        alt="">
                    <h3 class="text"><strong><?php echo $detail['nama_pelanggan']; ?></strong></h3>
                </div>
                <form action="profile.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto_profil">Choose Photo</label>
                        <input type="file" id="foto_profil" name="foto_profil">
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom" name="upload_foto"><i
                            class="glyphicon glyphicon-cloud-upload"></i>
                        <strong>Ubah Foto</strong></button>
                </form>
                <div class="profile-section">
                    <h3 class="text"><strong>PROFILE</strong></h3>
                    <p style="color: black">Jenis Kelamin : <?php echo $detail['gender']; ?></p>
                    <p style="color: black">Tanggal Lahir: <?php echo $detail['tanggal_lahir']; ?></p>
                </div>
                <div class="profile-section">
                    <h3 class="text"><strong>KONTAK</strong></h3>

                    <p style="color: black">Email : <?php echo $detail['email_pelanggan']; ?></p>
                    <p style="color: black">No. Telephone : <?php echo $detail['telepon_pelanggan']; ?></p>
                </div>
                <div class="profile-section">
                    <h3 class="text"><strong>Alamat</strong></h3>
                    <p style="color: black"><?php echo $detail['alamat_pelanggan']; ?></p>
                </div>
                <a href="edit_profile.php" class="btn btn-primary btn-custom"><i
                        class="glyphicon glyphicon-cloud-upload"></i> <strong>Edit Profil</strong></a>
            </div>
            <div class="profile-right">
                <img src="admin/assets/img/profil.png" alt="Logo" class="logo-background">
            </div>
        </div>
    </div>

    <!-- footer -->
    <div style="margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>

    <script src="admin/assets/js/jquery-1.10.2.js"></script>
    <script src="admin/assets/js/bootstrap.min.js"></script>
</body>

</html>