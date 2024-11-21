<?php
    $ambil = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$_GET[id]'");
    $pecah = $ambil->fetch_assoc();
    $fototerpisah = $pecah['foto_terpisah'];
    if(file_exists("../foto_produk_terpisah/$fototerpisah")) {
        unlink("../foto_produk_terpisah/$fototerpisah");
    }

    $koneksi->query("DELETE FROM produk_terpisah WHERE id_produk_terpisah='$_GET[id]'");

    echo "<script>alert('Produk terpisah berhasil terhapus');</script>";
    echo "<script>location='index.php?halaman=produkterpisah';</script>";
?>