<?php
    $id_produk_terpisah = $_GET['id'];

    $ambil = $koneksi->query("SELECT * FROM produk_terpisah LEFT JOIN kategori ON produk_terpisah.id_kategori=kategori.id_kategori WHERE id_produk_terpisah='$id_produk_terpisah'");
    $detailproduk = $ambil->fetch_assoc();
?>

<table class="table table-bordered">
    <tr>
        <th>Kategori</th>
        <td><?php echo $detailproduk['nama_kategori']; ?></td>
    </tr>
    <tr>
        <th>Produk</th>
        <td><?php echo $detailproduk['nama_produk']; ?></td>
    </tr>
    <tr>
        <th>Harga</th>
        <td>Rp. <?php echo number_format($detailproduk['harga_eceran']); ?></td>
    </tr>
    <tr>
        <th>Berat Satuan</th>
        <td><?php echo $detailproduk['berat_satuan']; ?></td>
    </tr>
    <tr>
        <th>Berat Kiloan</th>
        <td><?php echo $detailproduk['berat_kiloan']; ?></td>
    </tr>
    <tr>
        <th>Berat Literan</th>
        <td><?php echo $detailproduk['berat_literan']; ?></td>
    </tr>
    <tr>
        <th>Berat Rencengan</th>
        <td><?php echo $detailproduk['berat_rencengan']; ?></td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td><?php echo $detailproduk['deskripsi_produk']; ?></td>
    </tr>
    <tr>
        <th>Stok</th>
        <td><?php echo $detailproduk['stok_terpisah']; ?></td>
    </tr>
    <tr>
        <th>Foto Produk</th>
        <th><?php echo $detailproduk["foto_terpisah"] ?></th>
    </tr>
</table>