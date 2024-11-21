<?php
    session_start();

    // mendapatkan id produk dari url
    $id_produk = $_GET['id'];

    // jika sudah ada produk di keranjang, maka produk tersebut berjumlah +1
    if(isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk]+=1;
    }

    // selain itu (blm ada di keranjang), maka produk itu dianggap dibeli 1
    else {
        $_SESSION['keranjang'][$id_produk] = 1;
    }

    // lanjut ke halaman keranjang
    echo "<script>alert('produk telah masuk ke keranjang belanja');</script>";
    echo "<script>location='keranjang.php';</script>";
?>