<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
</head>

<h4><strong>List Produk</strong></h4>
<hr>
<h5><strong>Produk</strong></h5>
<h5 style="color:darkgray;">Dibawah ini adalah Produk :</h5>

<div class="table-responsive" style="margin-top: 10px;">
    <table id="produkTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Merek</th>
                <th class="text-center">Jenis</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Berat</th>
                <th class="text-center">Masa Penyimpanan</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor=1; ?>
            <?php $ambil=$koneksi->query("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id_kategori"); ?>
            <?php while($pecah = $ambil->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['nama_kategori']; ?></td>
                <td><?php echo $pecah['nama_produk']; ?></td>
                <td><?php echo $pecah['merek']; ?></td>
                <td><?php echo $pecah['jenis']; ?></td>
                <td class="text-center">Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                <td class="text-center"><?php echo $pecah['ukuran_produk']; ?> KG</td>
                <td><?php echo $pecah['masa_penyimpanan']; ?></td>
                <td class="text-center"><?php echo $pecah['stok_produk']; ?></td>
                <td>
                    <img src="../foto_produk/<?php echo $pecah['foto_produk']; ?>" width="100">
                </td>
                <td class="text-center">
                    <a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-danger"
                        onclick="return confirm('Yakin mau hapus?')"><i class="glyphicon glyphicon-trash"></i> Hapus
                        Produk</a>
                    <a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id_produk']; ?>"
                        class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Ubah Produk</a>
                    <a href="index.php?halaman=detailproduk&id=<?php echo $pecah['id_produk']; ?>"
                        class="btn btn-info"><i class="fa fa-book"></i> Detail Produk</a>
                </td>
            </tr>
            <?php $nomor++; ?>
            <?php } ?>
        </tbody>
    </table>
</div>
<a href="index.php?halaman=tambahproduk" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i>
    Tambah Produk</a>

<script>
$(document).ready(function() {
    $('#produkTable').DataTable();
});
</script>