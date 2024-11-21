<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
</head>

<h4><strong>List Produk Terpisah</strong></h4>
<hr>
<h5><strong>Produk Terpisah</strong></h5>
<h5 style="color:darkgray;">Dibawah ini adalah Produk Terpisah :</h5>

<div class="table-responsive" style="margin-top: 10px;">
    <table id="produkterpisahTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Berat Satuan</th>
                <th class="text-center">Berat Kiloan</th>
                <th class="text-center">Berat Literan</th>
                <th class="text-center">Berat Rencengan</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor=1; ?>
            <?php $ambil=$koneksi->query("SELECT * FROM produk_terpisah LEFT JOIN kategori ON produk_terpisah.id_kategori=kategori.id_kategori"); ?>
            <?php while($pecah = $ambil->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['nama_kategori']; ?></td>
                <td><?php echo $pecah['nama_produk']; ?></td>
                <td class="text-center">Rp. <?php echo number_format($pecah['harga_eceran']); ?></td>
                <td class="text-center"><?php echo $pecah['berat_satuan']; ?> g</td>
                <td class="text-center"><?php echo $pecah['berat_kiloan']; ?> kg</td>
                <td class="text-center"><?php echo $pecah['berat_literan']; ?> l</td>
                <td class="text-center"><?php echo $pecah['berat_rencengan']; ?> pcs</td>
                <td class="text-center"><?php echo $pecah['stok_terpisah']; ?></td>
                <td>
                    <img src="../foto_produk_terpisah/<?php echo $pecah['foto_terpisah']; ?>" width="100">
                </td>
                <td class="text-center">
                    <a href="index.php?halaman=hapusprodukterpisah&id=<?php echo $pecah['id_produk_terpisah']; ?>"
                        class="btn btn-danger" onclick="return confirm('Yakin mau hapus?')"><i
                            class="glyphicon glyphicon-trash"></i> Hapus Produk Terpisah</a>
                    <a href="index.php?halaman=ubahprodukterpisah&id=<?php echo $pecah['id_produk_terpisah']; ?>"
                        class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Ubah Produk Terpisah</a>
                    <a href="index.php?halaman=detailprodukterpisah&id=<?php echo $pecah['id_produk_terpisah']; ?>"
                        class="btn btn-info"><i class="fa fa-book"></i> Detail Produk Terpisah</a>
                </td>
            </tr>
            <?php $nomor++; ?>
            <?php } ?>
        </tbody>
    </table>
</div>
<a href="index.php?halaman=tambahprodukterpisah" class="btn btn-primary" style="margin-top: 10px;"><i
        class="fa fa-plus"></i> Tambah Produk Terpisah</a>

<script>
$(document).ready(function() {
    $('#produkterpisahTable').DataTable();
});
</script>