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

    $koneksi->query("UPDATE pembelian SET status_pembelian='DIBATALKAN' WHERE id_pembelian='$idpem'");

    echo "<script>alert('Berhasil membatalkan pesanan anda');</script>";
    echo "<script>location='riwayat.php';</script>";

    $id_pelanggan_beli = $detpem["id_pelanggan"];
    $id_pelanggan_login = $_SESSION["pelanggan"]["id_pelanggan"];

    if($id_pelanggan_beli!==$id_pelanggan_login) {
        echo "<script>alert('Jangan asal melihat noted orang lain !!');</script>";
        echo "<script>location='riwayat.php';</script>";
        exit();
    }
?>