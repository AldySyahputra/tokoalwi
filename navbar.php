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
</head>

<body>
    <nav class="navbar navbar-default warna3">
        <div class="container-fluid">
            <div class="navbar-header" style="background-color: #dadada;">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" style="background-color: #03AC0E;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand visible-xs" href="index.php">
                    <img src="./admin/assets/img/logo1.png" style="width: 120px; margin-top: -5px;">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" style="margin-top: 5px">
                    <li class="hidden-xs"><a href="index.php"><img src="./admin/assets/img/logo1.png"
                                style="width: 120px; margin-top: -5px;"></a>
                    </li>
                    <li><a href="index.php" class="fa fa-home"> <strong>Beranda</strong></a></li>
                    <li><a href="produk.php" class="fa fa-tags"> <strong>Produk</strong></a></li>
                    <?php if(isset($_SESSION["pelanggan"])): ?>
                    <li><a href="keranjang.php" class="fa fa-shopping-cart"> <strong>Keranjang</strong></a></li>
                    <li><a href="checkout.php" class="fa fa-credit-card"> <strong>Checkout</strong></a></li>
                    <li><a href="riwayat.php" class="fa fa-book"> <strong>Riwayat Checkout</strong></a></li>
                    <?php else: ?>
                    <li><a href="tentangkami.php" class="fa fa-film"> <strong>Tentang Kami</strong></a></li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right mt-5" style=" margin-top: 5px">
                    <?php if(!isset($_SESSION["pelanggan"])): ?>
                    <li><a href="login.php" class="fa fa-sign-in"> <strong>Masuk</strong></a></li>
                    <li><a href="register.php" class="fa fa-user"> <strong>Daftar</strong></a></li>
                    <?php else: ?>
                    <?php
                        $foto_profil = $_SESSION["pelanggan"]["foto_profil"];
                        $nama_pelanggan = $_SESSION["pelanggan"]["nama_pelanggan"]; // Ambil nama pelanggan dari sesi
                    ?>
                    <li><a href="profile.php"><strong><?php echo $nama_pelanggan; ?><img
                                    src="admin/assets/img/profile.png" class="img-circle" width="30"
                                    height="20"></strong></a></li>
                    <li><a href="logout.php" class="fa fa-sign-out"> <strong>Keluar</strong></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>