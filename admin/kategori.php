<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
</head>

<h4><strong>List Kategori</strong></h4>
<hr>
<h5><strong>Tambah Kategori Baru</strong></h5>
<form method="POST" action="">
    <input type="text" name="nama_kategori" required placeholder="Masukkan nama kategori">
    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Kategori</button>
</form>
<h5 style="color:darkgray;">Dibawah ini adalah Kategori :</h5>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama_kategori'])) {
        $nama_kategori = $koneksi->real_escape_string($_POST['nama_kategori']);
        $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
        $koneksi->query($query);
        echo "<script>alert('Kategori berhasil ditambahkan!'); window.location='kategori.php';</script>";
    }

    $semuadata = array();
    $ambil=$koneksi->query("SELECT * FROM kategori"); 
    while($tiap = $ambil->fetch_assoc()) {
        $semuadata[] = $tiap;
    }
?>

<table id="kategoriTable" class="table table-bordered" style="margin-top: 10px;">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-center">Kategori</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($semuadata as $key => $value): ?>
        <tr>
            <td><?php echo $key+1; ?></td>
            <td><?php echo $value['nama_kategori']; ?></td>
            <td class="text-center">
                <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')"><i
                        class="glyphicon glyphicon-trash"></i> Hapus Kategori</a>
                <a href="" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> Ubah Kategori</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('#kategoriTable').DataTable();
});
</script>