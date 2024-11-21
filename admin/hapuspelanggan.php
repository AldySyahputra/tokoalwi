<?php
    session_start();
    $koneksi = new mysqli("localhost", "root", "", "onlineshop");

    if(!isset($_SESSION['admin'])) {
        echo "<script>alert('Anda harus login');</script>";
        echo "<script>location='login.php';</script>";
        exit();
    }

    if(isset($_GET['id'])) {
        $id_pelanggan = $_GET['id'];
        $koneksi->query("DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");

        // Redirect to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
?>