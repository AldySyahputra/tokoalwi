<?php
    $id_produk = $_GET['id'];

    $ambil = $koneksi->query("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id_kategori WHERE id_produk='$id_produk'");
    $detailproduk = $ambil->fetch_assoc();

    $produkfoto = array(); 
    $ambilfoto = $koneksi->query("SELECT * FROM produk_foto WHERE id_produk='$id_produk'");
    while($tiap = $ambilfoto->fetch_assoc()) {
        $produkfoto[] = $tiap;
    }
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
        <td>Rp. <?php echo number_format($detailproduk['harga_produk']); ?></td>
    </tr>
    <tr>
        <th>Berat</th>
        <td><?php echo $detailproduk['ukuran_produk']; ?></td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td><?php echo $detailproduk['deskripsi_produk']; ?></td>
    </tr>
    <tr>
        <th>Stok</th>
        <td><?php echo $detailproduk['stok_produk']; ?></td>
    </tr>
    <tr>
        <th>Foto Produk</th>
        <th><?php echo $detailproduk["foto_produk"] ?></th>
    </tr>
</table>
<!-- 
<div class="row">
    <?php foreach($produkfoto as $key => $value): ?>
    <div class="col-md-3">
        <img src="../foto_produk/<?php echo $value['nama_produk_foto']; ?>" alt="" class="img-responsive">
        <a href="index.php?halaman=hapusfotoproduk&idfoto=<?php echo $value['id_produk_foto'] ?>&idproduk=<?php echo $id_produk ?>"
            class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')"><i
                class="glyphicon glyphicon-trash"></i> Delete</a>
    </div>
    <?php endforeach ?>
</div>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="">File foto</label>
        <input type="file">
    </div>
    <button class="btn btn-primary" name="simpan">Simpan</button>
</form>

<?php
    if(isset($_POST['simpan'])) {
        $lokasifoto = $_FILES['foto']['tmp_name'];
        $namafoto = $_FILES['foto']['name'];

        $namafoto = date('YmdHis').$namafoto;
        move_uploaded_file($lokasifoto, "../foto_produk/".$namafoto);

        $koneksi->query("INSERT INTO produk_foto (id_produk, nama_produk_foto) VALUES ('$id_produk', '$namafoto')");

        echo "<script>alert('Foto produk berhasil tersimpan');</script>";
        echo "<script>location='index.php?halaman=detailproduk&id=$id_produk';</script>";
    }
?> -->