<?php
    $datakategori = array();
    
    $ambil = $koneksi->query("SELECT * FROM kategori");
    while ($tiap = $ambil->fetch_assoc()) {
        $datakategori[] = $tiap;
    }
?>

<h4><strong>Tambah Produk</strong></h4>
<hr>

<form action="" method="post" enctype="multipart/form-data">
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
        <input type="text" class="form-control" name="nama">
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
        <input type="number" class="form-control" name="harga">
    </div>
    <div class="form-group">
        <label for="ukuran">Berat</label>
        <input type="number" class="form-control" name="ukuran">
    </div>
    <div class="form-group">
        <label for="nama">Massa Penyimpanan</label>
        <input type="text" class="form-control" name="masa_penyimpanan">
    </div>
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label for="">Stok</label>
        <input type="number" class="form-control" name="stok">
    </div>
    <div class="form-group">
        <label for="foto">Foto</label>
        <div class="letak-input" style="margin-bottom: 10px;">
            <input type="file" class="form-control" name="foto">
        </div>
        <span class="btn btn-primary btn-tambah">
            <i class="fa fa-plus"></i>
        </span>
    </div>
    <button class="btn btn-primary" name="save"><i class="fa fa-save"></i> Save</button>
</form>

<?php
    if(isset($_POST['save'])) {
        $namanamafoto = $_FILES['foto']['name'];
        $lokasilokasifoto = $_FILES['foto']['tmp_name'];
        move_uploaded_file($lokasilokasifoto, "../foto_produk/" .$namanamafoto);

        $koneksi->query("INSERT INTO produk (nama_produk, merek, jenis, harga_produk, ukuran_produk, masa_penyimpanan, foto_produk, deskripsi_produk, stok_produk, id_kategori) VALUES ('$_POST[nama]', '$_POST[merek]', '$_POST[jenis]', '$_POST[harga]', '$_POST[ukuran]', '$_POST[masa_penyimpanan]', '$namanamafoto', '$_POST[deskripsi]', '$_POST[stok]', '$_POST[id_kategori]')");

        // mendapatkan id_produk barusan
        $id_produk_barusan = $koneksi->insert_id;

        foreach ($namanamafoto as $key => $tiap_nama) {
            $tiap_lokasi = $lokasilokasifoto[$key];
            move_uploaded_file($tiap_lokasi, "../foto_produk/. $tiap_nama");

            // simpan ke mysql
            $koneksi->query("INSERT INTO produk_foto (id_produk, nama_produk_foto) VALUES ('$id_produk_barusan', '$tiap_nama')");
        }

        echo "<div class='alert alert-info'>Data Tersimpan</div>";
        echo "<meta http-equiv='refresh' content='2; url=index.php?halaman=produk'>";

    }
?>

<script>
$(document).ready(function() {
    $(".btn-tambah").on("click", function() {
        $(".letak-input").append("<input type='file' class='form-control' name='foto'>");
    })
})
</script>