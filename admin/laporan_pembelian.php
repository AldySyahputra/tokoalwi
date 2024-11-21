<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
</head>

<?php
    $semuadata = array();
    $tgl_mulai = "";
    $tgl_selesai = "";
    $status = "";

    if(isset($_POST['kirim'])) {
        $tgl_mulai = $_POST['tglm'];
        $tgl_selesai = $_POST['tgls'];
        $status = $_POST['status'];
        $ambil = $koneksi->query("SELECT * FROM pembelian pm LEFT JOIN pelanggan pl ON pm.id_pelanggan=pl.id_pelanggan WHERE status_pembelian='$status' AND tanggal_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai'");
        while($pecah = $ambil->fetch_assoc()) {
            $semuadata[] = $pecah;
        }
    }
?>


<h4><strong>Detail Laporan Penjualan Dari <?php echo $tgl_mulai; ?> Hingga
        <?php echo $tgl_selesai; ?></strong></h4>
<hr>
<h5><strong>Laporan Hasil Penjualan</strong></h5>
<h5 style="color:darkgray;">Dibawah ini adalah Laporan Hasil Penjualan :</h5>

<form action="" method="post" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="tglm">Dari Tanggal</label>
                <input type="date" class="form-control" name="tglm" value="<?php echo $tgl_mulai; ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="tgls">Sampai Tanggal</label>
                <input type="date" class="form-control" name="tgls" value="<?php echo $tgl_selesai; ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="tgls">Status</label>
                <select class="form-control" name="status">
                    <option value="">Pilih Status</option>
                    <option value="pending">pending</option>
                    <option value="Sudah kirim pembayaran">Sudah kirim pembayaran</option>
                    <option value="barang dalam pengiriman">Barang Dalam Pengiriman</option>
                    <option value="barang sudah sampai">Barang Sudah Sampai</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <label>&nbsp;</label><br>
            <button class="btn btn-primary" name="kirim"><i class="fa fa-search"></i> Lihat</button>
        </div>
    </div>
</form>

<table id="laporanTable" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $total=0; ?>
        <?php foreach($semuadata as $key => $value): ?>
        <?php $total+=$value['total_pembelian']; ?>
        <tr>
            <td><?php echo $key+1; ?></td>
            <td><?php echo $value['nama_pelanggan']; ?></td>
            <td class="text-center"><?php echo date("d F Y", strtotime($value['tanggal_pembelian'])); ?></td>
            <td class="text-center">Rp. <?php echo number_format($value['total_pembelian']); ?></td>
            <td class="text-center"><?php echo $value['status_pembelian']; ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th>Rp. <?php echo number_format($total); ?></th>
            <th></th>
        </tr>
    </tfoot>
</table>

<script>
$(document).ready(function() {
    $('#laporanTable').DataTable();
});
</script>