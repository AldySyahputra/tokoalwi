<?php
    session_start();
    $koneksi = new mysqli("localhost", "root", "", "onlineshop");

    if(!isset($_SESSION['admin'])) {
        echo "<script>alert('Anda harus login');</script>";
        echo "<script>location='login.php';</script>";
        header('location:login.php');
        exit();
    }

    // Ambil data pelanggan dari session
    $id_admin = $_SESSION["admin"]["id_admin"];

    // Ambil data pelanggan dari database
    $ambil = $koneksi->query("SELECT * FROM admin WHERE id_admin='$id_admin'");
    $detail = $ambil->fetch_assoc();

    $ambil = $koneksi->query("SELECT COUNT(*) as jumlah_notifikasi FROM pembelian WHERE notifikasi = 1");
    $pecah = $ambil->fetch_assoc();
    $jumlah_notifikasi = $pecah['jumlah_notifikasi'];
    ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard || Online Shop</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <script src="assets/js/jquery-1.10.2.js"></script>
</head>
<style>
@media (max-width: 768px) {

    .navbar-cls-top,
    .navbar-default.navbar-side {
        width: 100%;
        position: relative;
    }

    .sidebar-collapse {
        display: none;
    }

    .navbar-toggle {
        display: block;
    }
}

.user-image {
    width: 50px;
    height: 50px;
    margin-left: 20px;
}

@media (max-width: 768px) {
    .text-center {
        flex-direction: column;
        align-items: center;
    }
}

.nav {
    width: 100%;
}

.navbar-default .sidebar-collapse .nav>ul>li>a:hover,
.navbar-default .sidebar-collapse .nav>ul>li>a:focus {
    background-color: #03ac0e;
    color: #03ac0e;
}
</style>

<body>
    <div id="wrapper" style="background-color: #d3d3d3;">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation"
            style="margin-bottom: 0; background-color:#dadada;">
            <img src="../admin/assets/img/logo1.png"
                style="width: 150px; height: 50px; margin-top: 5px; margin-left: 25px">
            <h4
                style="margin-left: 190px; margin-top: -55px; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; color: #03ac0e;">
                <strong>Toko Alwi</strong>
            </h4>
            <h5
                style="margin-left: 190px; margin-top: -10px; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; color: #03ac0e;">
                <strong>Online shop management system</strong>
            </h5>
            <div class="navbar-header" style="background-color: #dadada;">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse"
                    style="background-color: #03ac0e;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation" style="background-color:#dadada;">
            <div class="sidebar-collapse">
                <ul class=" nav" id="main-menu">
                    <li class="text-center" style="display: flex; align-items: center; object-fit: cover;">
                        <img src="assets/img/admin.png" class="user-image img-responsive"
                            style="width: 70px; height: 70px; margin-right: 10px;" />
                        <h5 style="margin-top: 45px; margin-left: -30px;">
                            <strong><?php echo $detail["nama_lengkap"] ?></strong> Administrator
                        </h5>
                    </li>
                    <li>
                        <a href="index.php" style="background-color: #dadada; color:#03ac0e;"><i class="fa fa-home"></i>
                            <strong>DASHBOARD ADMIN</strong></a>
                    </li>
                    <li>
                        <a href="index.php?halaman=kategori" style="background-color: #dadada; color:#03ac0e;"><i
                                class="fa fa-cube"></i> <strong>LIST KATEGORI</strong></a>
                    </li>
                    <li>
                        <a href="index.php?halaman=produk" style="background-color: #dadada; color:#03ac0e;"><i
                                class="fa fa-shopping-cart"></i> <strong>LIST PRODUK</strong></a>
                    </li>
                    <li>
                        <a href="index.php?halaman=produk_terpisah" style="background-color: #dadada; color:#03ac0e;"><i
                                class="fa fa-shopping-cart"></i> <strong>LIST PRODUK TERPISAH</strong></a>
                    </li>
                    <li>
                        <a href="index.php?halaman=transaksi" style="background-color: #dadada; color:#03ac0e;"><i
                                class="fa fa-dollar"></i> <strong>LIST TRANSAKSI</strong>
                            <?php if ($jumlah_notifikasi > 0): ?>
                            <span class="badge badge-danger"><?php echo $jumlah_notifikasi; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?halaman=laporan_pembelian"
                            style="background-color: #dadada; color:#03ac0e;"><i class="fa fa-file"></i> <strong>LIST
                                LAPORAN PENJUALAN</strong></a>
                    </li>
                    <li>
                        <a href="index.php?halaman=pelanggan" style="background-color: #dadada; color:#03ac0e;"><i
                                class="fa fa-user"></i> <strong>LIST AKUN USER</strong></a>
                    </li>
                    <li>
                        <a href="index.php?halaman=logout" style="background-color: #dadada; color:#03ac0e;"><i
                                class="fa fa-sign-out"></i> <strong>KELUAR</strong>
                        </a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <?php
                    if(isset($_GET['halaman'])) {
                        if($_GET['halaman']=="produk") {
                            include 'produk.php';
                        }
                        else if($_GET['halaman']=="produk_terpisah") {
                            include 'produk_terpisah.php';
                        }
                        else if($_GET['halaman']=="transaksi") {
                            include 'pembelian.php';
                        }
                        else if($_GET['halaman']=="pelanggan") {
                            include 'pelanggan.php';
                        }
                        else if($_GET['halaman']=="detail"){
                            include 'detail.php';
                        }
                        else if($_GET['halaman']=="tambahproduk") {
                            include 'tambahproduk.php';
                        }
                        else if($_GET['halaman']=="tambahprodukterpisah") {
                            include 'tambahprodukterpisah.php';
                        }
                        else if($_GET['halaman']=="hapusproduk") {
                            include 'hapusproduk.php';
                        }
                        else if($_GET['halaman']=="hapusprodukterpisah") {
                            include 'hapusprodukterpisah.php';
                        }
                        else if($_GET['halaman']=="ubahproduk") {
                            include 'ubahproduk.php';
                        }
                        else if($_GET['halaman']=="ubahprodukterpisah") {
                            include 'ubahprodukterpisah.php';
                        }
                        else if($_GET['halaman']=="logout") {
                            include 'logout.php';
                        }
                        else if($_GET['halaman']=="pembayaran") {
                            include 'pembayaran.php';
                        }
                        else if($_GET['halaman']=="laporan_pembelian") {
                            include 'laporan_pembelian.php';
                        }
                        else if($_GET['halaman']=="kategori") {
                            include 'kategori.php';
                        }
                        else if($_GET['halaman']=="detailproduk") {
                            include 'detailproduk.php';
                        }
                        else if($_GET['halaman']=="detailprodukterpisah") {
                            include 'detailprodukterpisah.php';
                        }
                        else if($_GET['halaman']=="hapusfotoproduk") {
                            include 'hapusfotoproduk.php';
                        }
                        else if($_GET['halaman']=="hapuspelanggan") {
                            include 'hapuspelanggan.php';
                        }
                    }
                    else {
                        include 'home.php';
                    }
                ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- MORRIS CHART SCRIPTS -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

</body>

</html>