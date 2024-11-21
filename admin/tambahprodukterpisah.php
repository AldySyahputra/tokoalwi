<?php
    $datakategori = array();
    
    $ambil = $koneksi->query("SELECT * FROM kategori");
    while ($tiap = $ambil->fetch_assoc()) {
        $datakategori[] = $tiap;
    }
?>

<h4><strong>Tambah Produk Terpisah</strong></h4>
<hr>

<form action="" method="post" enctype="multipart/form-data" style="margin-top: 20px;">
    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control" name="id_kategori">
            <option value="">Pilih Kategori</option>
            <?php foreach ($datakategori as $key => $value): ?>
            <option value="<?php echo $value['id_kategori']; ?>"><?php echo $value['nama_kategori']; ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama_produk">
    </div>
    <div class="form-group">
        <label for="nama">Merek</label>
        <input type="text" class="form-control" name="merek">
    </div>
    <div class="form-group">
        <label for="nama">Jenis</label>
        <input type="text" class="form-control" name="jenis">
    </div>
    <div class="form-group">
        <label for="harga">Harga (RP)</label>
        <input type="number" class="form-control" name="harga_eceran">
    </div>
    <div class="form-group">
        <label for="berat_satuan">Berat Satuan (g)</label>
        <input type="number" class="form-control" name="berat_satuan">
    </div>
    <div class="form-group">
        <label for="berat_kiloan">Berat Kiloan (kg)</label>
        <input type="number" class="form-control" name="berat_kiloan">
    </div>
    <div class="form-group">
        <label for="berat_literan">Berat Literan (l)</label>
        <input type="number" class="form-control" name="berat_literan">
    </div>
    <div class="form-group">
        <label for="berat_rencengan">Berat Rencengan (pcs)</label>
        <input type="number" class="form-control" name="berat_rencengan">
    </div>
    <div class="form-group">
        <label for="nama">Massa Penyimpanan</label>
        <input type="text" class="form-control" name="masa_penyimpanan">
    </div>
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi_produk" class="form-control" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" class="form-control" name="stok_terpisah">
    </div>
    <div class="form-group">
        <label for="foto">Foto</label>
        <div class="letak-input" style="margin-bottom: 10px;">
            <input type="file" class="form-control" name="foto_terpisah">
        </div>
        <span class="btn btn-primary btn-tambah">
            <i class="fa fa-plus"></i>
        </span>
    </div>
    <button class="btn btn-primary" name="save">Save</button>
</form>

<?php
    if(isset($_POST['save'])) {
        $namafoto = $_FILES['foto_terpisah']['name'];
        $lokasifoto = $_FILES['foto_terpisah']['tmp_name'];
        move_uploaded_file($lokasifoto, "../foto_produk_terpisah/" .$namafoto);

        $koneksi->query("INSERT INTO produk_terpisah (nama_produk, merek, jenis, harga_eceran, berat_satuan, berat_kiloan, berat_literan, berat_rencengan, masa_penyimpanan, foto_terpisah, deskripsi_produk, stok_terpisah, id_kategori) VALUES ('$_POST[nama_produk]', '$_POST[merek]', '$_POST[jenis]', '$_POST[harga_eceran]', '$_POST[berat_satuan]', '$_POST[berat_kiloan]', '$_POST[berat_literan]', '$_POST[berat_rencengan]', '$_POST[masa_penyimpanan]', '$namafoto', '$_POST[deskripsi_produk]', '$_POST[stok_terpisah]', '$_POST[id_kategori]')");

        echo "<div class='alert alert-info'>Data Tersimpan</div>";
        echo "<meta http-equiv='refresh' content='1; url=index.php?halaman=produk_terpisah'>";
    }
?>

<script>
$(document).ready(function() {
    $(".btn-tambah").on("click", function() {
        $(".letak-input").append("<input type='file' class='form-control' name='foto_terpisah'>");
    });
});
</script>