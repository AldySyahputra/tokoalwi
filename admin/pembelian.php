<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
</head>

<h4><strong>List Transaksi</strong></h4>
<hr>
<h5><strong>Transaksi User</strong></h5>
<h5 style="color:darkgray;">Dibawah ini adalah Transaksi User :</h5>

<?php
// Update status notifikasi menjadi 0 setelah ditampilkan
$koneksi->query("UPDATE pembelian SET notifikasi = 0 WHERE notifikasi = 1");
?>

<table id="transaksiTable" class="table table-bordered" style="margin-top: 20px;">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-center">Nama Pelanggan</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Status</th>
            <th class="text-center">Total</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor=1; ?>
        <?php $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan"); ?>
        <?php while($pecah = $ambil->fetch_assoc()) { ?>
        <tr <?php if ($pecah['notifikasi'] == 1) echo 'style="background-color: #ffeb3b;"'; ?>>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_pelanggan']; ?></td>
            <td><?php echo date("d F Y",strtotime($pecah['tanggal_pembelian'])); ?></td>
            <td><?php echo $pecah['status_pembelian']; ?></td>
            <td>Rp. <?php echo number_format($pecah['total_pembelian']); ?></td>
            <td>
                <a href="index.php?halaman=detail&id=<?php echo $pecah['id_pembelian']; ?>" class="btn btn-primary"><i
                        class="fa fa-file-text"></i> Detail Pesanan</a>

                <?php if ($pecah['status_pembelian'] !== "pending"): ?>
                <a href="index.php?halaman=pembayaran&id=<?php echo $pecah['id_pembelian']; ?>"
                    class="btn btn-success"><i class="fa fa-money"></i> Bukti Transaksi</a>
                <?php endif ?>
            </td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('#transaksiTable').DataTable();
});
</script>