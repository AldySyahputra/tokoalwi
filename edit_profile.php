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

// Proses update profil
if (isset($_POST['update_profil'])) {
    $nama_baru = $koneksi->real_escape_string($_POST['nama_baru']);
    $gender_baru = $koneksi->real_escape_string($_POST['gender_baru']);
    $tanggal_lahir_baru = $koneksi->real_escape_string($_POST['tanggal_lahir_baru']);
    $alamat_baru = $koneksi->real_escape_string($_POST['alamat_baru']);

    // Proses upload foto
    if (!empty($_FILES['foto_profil']['name'])) {
        $foto_profil = $_FILES['foto_profil']['name'];
        $lokasi_foto = $_FILES['foto_profil']['tmp_name'];
        $nama_foto_baru = date("YmdHis") . $foto_profil;
        move_uploaded_file($lokasi_foto, "foto_profil/$nama_foto_baru");

        // Update foto_profil di database
        $koneksi->query("UPDATE pelanggan SET foto_profil='$nama_foto_baru' WHERE id_pelanggan='$id_pelanggan'");

        // Update session
        $_SESSION["pelanggan"]["foto_profil"] = $nama_foto_baru;
    }

    // Update profil di database
    $koneksi->query("UPDATE pelanggan SET nama_pelanggan='$nama_baru', gender='$gender_baru', tanggal_lahir='$tanggal_lahir_baru', alamat_pelanggan='$alamat_baru' WHERE id_pelanggan='$id_pelanggan'");

    // Update session
    $_SESSION["pelanggan"]["nama_pelanggan"] = $nama_baru;
    $_SESSION["pelanggan"]["gender"] = $gender_baru;
    $_SESSION["pelanggan"]["tanggal_lahir"] = $tanggal_lahir_baru;
    $_SESSION["pelanggan"]["alamat_pelanggan"] = $alamat_baru;

    echo "<script>alert('Profil berhasil diupdate');</script>";
    echo "<script>location='profile.php';</script>";
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
    <title>Online Shop || Edit Profile</title>
</head>

<style>
body {
    background-image: url('admin/assets/img/bakground_profil1.jpg');
    background-size: cover;
    background-position: center;
    object-fit: cover;
}

.btn-primary.btn-custom {
    background-color: #03AC0E;
    color: white;
}

.btn-primary.btn-custom:hover {
    background-color: #03AC0E;
    color: white;
}

.btn-secondary.btn-custom {
    background-color: white;
    color: #03AC0E;
}

.btn-secondary.btn-custom:hover {
    background-color: white;
    color: #03AC0E;
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
        width: 80px;
        /* Mengurangi ukuran gambar profil pada layar kecil */
        height: 80px;
        /* Mengurangi ukuran gambar profil pada layar kecil */
    }

    .profile-header h3 {
        font-size: 1.2em;
        /* Mengurangi ukuran font pada layar kecil */
    }

    .btn-primary.btn-custom,
    .btn-secondary.btn-custom {
        width: 100%;
        /* Tombol akan mengambil lebar penuh pada layar kecil */
    }

    .form-group {
        width: 100%;
        /* Memastikan form group mengambil lebar penuh */
    }
}
</style>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1 class="text-center" style="color: black;"><strong>Edit Profile</strong></h1><br>
        <div class="profile-container">
            <div class="profile-left">
                <form action="edit_profile.php" method="post" enctype="multipart/form-data">
                    <div class="profile-header">
                        <img src="<?php echo empty($detail['foto_profil']) ? 'admin/assets/img/find_user.png' : $detail['foto_profil']; ?>"
                            alt="">
                        <h3 class="text"><strong><?php echo $detail['nama_pelanggan']; ?></strong></h3>
                    </div>
                    <div class="form-group">
                        <label for="nama_baru">Nama</label>
                        <input type="text" class="form-control" id="nama_baru" name="nama_baru"
                            value="<?php echo $detail['nama_pelanggan']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender_baru">Jenis Kelamin</label>
                        <select class="form-control" id="gender_baru" name="gender_baru">
                            <option value="Laki-laki" <?php if ($detail['gender'] == 'Laki-laki') echo 'selected'; ?>>
                                Laki-laki</option>
                            <option value="Perempuan" <?php if ($detail['gender'] == 'Perempuan') echo 'selected'; ?>>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir_baru">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir_baru" name="tanggal_lahir_baru"
                            value="<?php echo $detail['tanggal_lahir']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="alamat_baru">Alamat</label>
                        <input type="text" class="form-control" id="alamat_baru" name="alamat_baru"
                            value="<?php echo $detail['alamat_pelanggan']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom" name="update_profil"><i
                            class="glyphicon glyphicon-cloud-upload"></i> <strong>Ubah Profil</strong></button>
                    <a href="profile.php" class="btn btn-secondary btn-custom"><i class="fa fa-arrow-left"></i>
                        <strong>Kembali ke Profil</strong></a>
                </form>
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