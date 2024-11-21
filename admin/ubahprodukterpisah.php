<?php
    $datakategori = array();
    
    $ambil = $koneksi->query("SELECT * FROM kategori");
    while ($tiap = $ambil->fetch_assoc()) {
        $datakategori[] = $tiap;
    }
?>

<h4><strong>Ubah Produk Terpisah</strong></h4>
<hr>

<?php
    $ambil = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$_GET[id]'");
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
        <input type="text" name="nama_produk" class="form-control" value="<?php echo $pecah['nama_produk']; ?>">
    </div>
    <div class="form-group">
        <label for="harga">Harga (RP)</label>
        <input type="number" class="form-control" name="harga_eceran" value="<?php echo $pecah['harga_eceran']; ?>">
    </div>
    <div class="form-group">
        <label for="berat_satuan">Berat Satuan (g)</label>
        <input type="number" class="form-control" name="berat_satuan" value="<?php echo $pecah['berat_satuan']; ?>">
    </div>
    <div class="form-group">
        <label for="berat_kiloan">Berat Kiloan (kg)</label>
        <input type="number" class="form-control" name="berat_kiloan" value="<?php echo $pecah['berat_kiloan']; ?>">
    </div>
    <div class="form-group">
        <label for="berat_literan">Berat Literan (L)</label>
        <input type="text" class="form-control" name="berat_literan" id="berat_literan"
            value="<?php echo $pecah['berat_literan']; ?>" onchange="validateLiteran(this)">
    </div>
    <div class="form-group">
        <label for="berat_rencengan">Berat Rencengan (pcs)</label>
        <input type="number" class="form-control" name="berat_rencengan"
            value="<?php echo $pecah['berat_rencengan']; ?>">
    </div>
    <div class="form-group">
        <img class="file" src="../foto_produk_terpisah/<?php echo $pecah['foto_terpisah']; ?>" width="200">
    </div>
    <div class="form-group">
        <label for="update-foto">Update Foto</label>
        <input type="file" class="form-control" name="foto_terpisah">
    </div>
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi_produk" class="form-control"
            rows="10"><?php echo $pecah['deskripsi_produk']; ?></textarea>
    </div>
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" class="form-control" name="stok_terpisah" value="<?php echo $pecah['stok_terpisah']; ?>">
    </div>
    <button class="btn btn-primary" name="update"><i class="glyphicon glyphicon-edit"></i> Ubah Produk</button>
</form>

<?php
    if(isset($_POST['update'])) {
        $namafoto = $_FILES['foto_terpisah']['name'];
        $lokasifoto = $_FILES['foto_terpisah']['tmp_name'];
        if(!empty($lokasifoto)) {
            move_uploaded_file($lokasifoto, "../foto_produk_terpisah/$namfoto");

            $koneksi->query("UPDATE produk_terpisah SET nama_produk='$_POST[nama_produk]', harga_eceran='$_POST[harga_eceran]', berat_satuan='$_POST[berat_satuan]', berat_kiloan='$_POST[berat_kiloan]', berat_literan='$_POST[berat_literan]', berat_rencengan='$_POST[berat_rencengan]', foto_terpisah='$namafoto', deskripsi_produk='$_POST[deskripsi_produk]', stok_terpisah='$_POST[stok_terpisah]', id_kategori='$_POST[id_kategori]' WHERE id_produk_terpisah='$_GET[id]'");
        }
        else {
            $koneksi->query("UPDATE produk_terpisah SET nama_produk='$_POST[nama_produk]', harga_eceran='$_POST[harga_eceran]', berat_satuan='$_POST[berat_satuan]', berat_kiloan='$_POST[berat_kiloan]', berat_literan='$_POST[berat_literan]', berat_rencengan='$_POST[berat_rencengan]', deskripsi_produk='$_POST[deskripsi_produk]', foto_terpisah='$namafoto', stok_terpisah='$_POST[stok_terpisah]', id_kategori='$_POST[id_kategori]' WHERE id_produk_terpisah='$_GET[id]'");
        }
        echo "<script>alert('Data produk terpisah berhasil diupdate');</script>";
        echo "<script>location='index.php?halaman=produkterpisah';</script>";
    }
?>

<script>
function validateLiteran(input) {
    var value = input.value.trim();
    if (value.includes('/')) {
        // Jika input berupa pecahan
        var parts = value.split('/');
        if (parts.length === 2 && !isNaN(parts[0]) && !isNaN(parts[1]) && parts[1] !== '0') {
            input.value = (parseFloat(parts[0]) / parseFloat(parts[1])).toFixed(2);
        } else {
            alert('Format pecahan tidak valid. Gunakan format "a/b" di mana a dan b adalah angka, dan b bukan 0.');
            input.value = '';
        }
    } else if (!isNaN(value)) {
        // Jika input berupa angka desimal
        input.value = parseFloat(value).toFixed(2);
    } else {
        alert('Masukkan angka desimal atau pecahan yang valid.');
        input.value = '';
    }
}
</script>