<?php
    $datakategori = array();
    
    $ambil = $koneksi->query("SELECT * FROM kategori");
    while ($tiap = $ambil->fetch_assoc()) {
        $datakategori[] = $tiap;
    }
?>

<h4><strong>Ubah Produk</strong></h4>
<hr>

<?php
    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
    $pecah = $ambil->fetch_assoc();
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control" name="id_kategori">
            <option value="">Pilih Kategori</option>
            <?php foreach ($datakategori as $key => $value): ?>
            <option value="<?php echo $value['id_kategori']; ?>"
                <?php if($pecah['id_kategori']==$value['id_kategori']){ echo "selected";} ?>>
                <?php echo $value['nama_kategori']; ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" name="nama" class="form-control" value="<?php echo $pecah['nama_produk']; ?>">
    </div>
    <div class="form-group">
        <label for="harga">Harga (RP)</label>
        <input type="number" class="form-control" name="harga" value="<?php echo $pecah['harga_produk']; ?>">
    </div>
    <div class="form-group">
        <label for="ukuran">Berat</label>
        <input type="number" class="form-control" name="ukuran" value="<?php echo $pecah['ukuran_produk']; ?>">
    </div>
    <div class="form-group">
        <img class="file" src="../foto_produk/<?php echo $pecah['foto_produk']; ?>" width="200">
    </div>
    <div class="form-group">
        <label for="update-foto">Update Foto</label>
        <input type="file" class="form-control" name="update-foto">
    </div>
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="10">
            <?php echo $pecah['deskripsi_produk']; ?>
        </textarea>
    </div>
    <div class="form-group">
        <label for="">Stok</label>
        <input type="number" class="form-control" value="<?php echo $pecah['stok_produk']; ?>">
    </div>
    <button class="btn btn-primary" name="update"><i class="glyphicon glyphicon-edit"></i> Ubah Produk</button>
</form>

<?php
    if(isset($_POST['update'])) {
        $namafoto = $_FILES['foto']['name'];
        $lokasifoto = $_FILES['foto']['tmp_name'];
        if(!empty($lokasifoto)) {
            move_uploaded_file($lokasifoto, "../foto_produk/$namafoto");

            $koneksi->query("UPDATE produk SET nama_produk='$_POST[nama]', harga_produk='$_POST[harga]', ukuran_produk='$_POST[ukuran]', foto_produk='$namafoto', deskripsi_produk='$_POST[deskripsi]', stok_produk'$_POST[stok]', id_kategori='$_POST[id_kategori]' WHERE id_produk='$_GET[id]'");
        }
        else {
            $koneksi->query("UPDATE produk SET nama_produk='$_POST[nama]', harga_produk='$_POST[harga]', ukuran_produk='$_POST[ukuran]', deskripsi_produk='$_POST[deskripsi]', foto_produk='$namafoto', stok_produk='$_POST[stok]', id_kategori='$_POST[id_kategori]' WHERE id_produk='$_GET[id]'");
        }
        echo "<script>alert('Data produk berhasil di update');</script>";
        echo "<script>location='index.php?halaman=produk';</script>";
    }
?>