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
    <!-- FONTAWESOME STYLES-->
    <link href="admin/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="admin/assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/style.css">
    <title>Online Shop || Login</title>
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

@media (max-width: 768px) {
    .login-image {
        margin-bottom: 20px;
        text-align: center;
        margin-top: -60px;
    }

    .vertical-line {
        display: none;
    }

    .form-container {
        margin-top: -100px;
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
                <h2 style="color: #03AC0E"><strong>Masukkan Akun Anda</strong></h2>

                <h5 class="fa fa-home"> Masuk untuk mendapatkan produk menarik</h5>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center" style="color: black;">
                        <strong> Masukkan Email & Password</strong>
                    </div>
                    <div class="panel-body">
                        <div class="vertical-line"></div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 login-image text-center">
                                <img src="admin/assets/img/backgorund_login.png" class="img-responsive"
                                    alt="Login Image">
                            </div>
                            <div class="col-md-6 col-xs-12 form-container">
                                <!-- Tambahkan form-container -->
                                <form role="form" method="post">
                                    <br />
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="text" class="form-control" name="email" />
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control" name="password" />
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="remember" /> Remember me
                                        </label>
                                        <span class="pull-right">
                                            <a href="forgot_password.php" class="text-decoration-none"
                                                style="color: #03AC0E; text-decoration: none;">Forget password ? </a>
                                        </span>
                                    </div>

                                    <button class="btn btn-primary btn-custom form-control" name="login"><i
                                            class="fa fa-sign-in"></i>
                                        <strong>Masuk</strong></button>
                                    <div class="text-center">
                                        <hr />
                                        Belum mendaftar? <a href="register.php"
                                            style="color: #03AC0E; text-decoration: none">Daftar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password'");
            $akun = $ambil->num_rows;
            if($akun==1) {
                $akun = $ambil->fetch_assoc();
                $_SESSION["pelanggan"] = $akun;
                echo "<script>alert('Anda berhasil masuk');</script>";
                if(isset($_SESSION["keranjang"]) OR !empty($_SESSION["keranjang"])) {
                    echo "<script>location='checkout.php';</script>";
                }
                else {
                    echo "<script>location='index.php';</script>";
                }
            }
            else {
                echo "<script>alert('Anda gagal masuk, periksa akun anda');</script>";
                echo "<script>location='login.php';</script>";
            }
        }
    ?>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="admin/assets/js/jquery-1.10.2.js"></script>
    <script src="admin/assets/js/bootstrap.min.js"></script>
</body>

</html>