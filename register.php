<?php
    include 'koneksi.php';
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
    <title>Online Shop || Register Akun</title>
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

.vertical-line {
    border-left: 1px solid #ddd;
    height: 82%;
    position: absolute;
    left: 50%;
    top: 41px;
}

.register-image {
    margin-top: 100px;
}

@media (max-width: 768px) {
    .register-image {
        text-align: center;
        margin-top: -20px;
    }

    .vertical-line {
        display: none;
    }

    .form-container {
        margin-top: -20px;
    }
}
</style>

<body>

    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <h2 style="color: #03AC0E"><strong>Buat Akun</strong></h2>

                <h5 class="fa fa-home"> Membuat Akun Baru</h5>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <strong> Pengguna baru ? Daftarkan Akun Anda </strong>
                    </div>
                    <div class="panel-body">
                        <div class="vertical-line"></div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 register-image text-center">
                                <img src="admin/assets/img/background_daftar.png" class="img-responsive"
                                    alt="Register Image">
                            </div>
                            <div class="col-md-6 col-xs-12 form-container">
                                <form role="form" method="post">
                                    <br />
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" placeholder="Nama" name="nama"
                                            required />
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                            required />
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control" placeholder="Password"
                                            name="password" required />
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-map-marker"></i></span>
                                        <input type="text" class="form-control" placeholder="Alamat Rumah" name="alamat"
                                            required />
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-earphone"></i></span>
                                        <input type="text" class="form-control" placeholder="No. Telephone"
                                            name="telepon" required />
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <select class="form-control" name="gender" required>
                                            <option value="">Jenis Kelamin</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" class="form-control" name="tanggal_lahir" required />
                                    </div>
                                    <button class="btn btn-primary btn-custom form-control" name="register"><i
                                            class="fa fa-user"></i>
                                        <strong>Daftar</strong></button>
                                    <div class="text-center">
                                        <hr />
                                        Sudah terdaftar ? <a href="login.php"
                                            style="color: #03AC0E; text-decoration: none">Masuk</a>
                                    </div>
                                </form>
                                <?php
                                    if(isset($_POST["register"])) {
                                        $nama = $_POST["nama"];
                                        $email = $_POST["email"];
                                        $password = $_POST["password"];
                                        $alamat = $_POST["alamat"];
                                        $telepon = $_POST["telepon"];
                                        $gender = $_POST["gender"];
                                        $tanggal_lahir = $_POST["tanggal_lahir"];

                                        $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
                                        $yangcocok = $ambil->num_rows;
                                        if($yangcocok==1) {
                                            echo "<script>alert('Register Gagal, Email sudah digunakan');</script>";
                                            echo "<script>location='register.php';</script>";
                                        }
                                        else {
                                            $koneksi->query("INSERT INTO pelanggan (nama_pelanggan, email_pelanggan, password_pelanggan, alamat_pelanggan, telepon_pelanggan, gender, tanggal_lahir) VALUES ('$nama', '$email', '$password', '$alamat', '$telepon', '$gender', '$tanggal_lahir')");
                                            echo "<script>alert('Register Success');</script>";
                                            echo "<script>location='login.php';</script>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="admin/assets/js/jquery-1.10.2.js"></script>
    <script src="admin/assets/js/bootstrap.min.js"></script>
</body>

</html>