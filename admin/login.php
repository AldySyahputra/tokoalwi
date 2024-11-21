<?php
    session_start();
    $koneksi = new mysqli("localhost", "root", "", "onlineshop");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login || Online Shop</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

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
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <h2 style="color: #03AC0E"><strong>Selamat Datang Admin</strong></h2>

                <h5 class="fa fa-home"> Masuk untuk melihat semua data pada penjualan di Toko Alwi</h5>
                <br />
            </div>
        </div>
        <div class=" row ">

            <div class=" col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <strong> Masukkan Email & Password </strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <br />
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></i></span>
                                <input type="text" class="form-control" name="username" />
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control" name="password" />
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" /> Remember me
                                </label>
                                <span class="pull-right">
                                    <a href="#">Forget password ? </a>
                                </span>
                            </div>

                            <button class="btn btn-primary btn-custom" name="login"><i class="fa fa-sign-in"></i>
                                <strong>Masuk</strong></button>
                        </form>
                        <?php
                            if(isset($_POST['login'])) {
                                $ambil = $koneksi->query("SELECT * FROM admin WHERE username='$_POST[username]' AND password='$_POST[password]'");
                                $yangcocok = $ambil->num_rows;
                                if($yangcocok==1) {
                                    $_SESSION['admin'] = $ambil->fetch_assoc();
                                    echo "<div class='alert alert-info'>Masuk berhasil</div>";
                                    echo "<meta http-equiv='refresh' content='1;url=index.php'>";
                                }
                                else {
                                    echo "<div class='alert alert-danger'>Masuk gagal</div>";
                                    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
                                }
                            }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

</body>

</html>