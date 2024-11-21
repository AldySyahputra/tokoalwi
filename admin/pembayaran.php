<h4><strong>Bukti Transaksi</strong></h4>
<hr>
<h5><strong>Bukti Transaksi User</strong></h5>
<h5 style="color:darkgray;">Dibawah ini adalah Bukti Transaksi User :</h5>

<?php
    $id_pembelian = $_GET['id'];

    // mengambil data pembayaran berdasarkan id_pembelian
    $ambil = $koneksi->query("SELECT 
                            pembayaran.*, 
                            pembelian.*, 
                            pembelian_produk.*, 
                            pelanggan.*, 
                            ongkir.nama_kota AS kota_ongkir, 
                            ongkir.tarif AS tarif_ongkir
                        FROM pembelian 
                        LEFT JOIN pembayaran ON pembayaran.id_pembelian = pembelian.id_pembelian 
                        LEFT JOIN pembelian_produk ON pembelian_produk.id_pembelian = pembelian.id_pembelian 
                        LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembelian.id_pelanggan 
                        LEFT JOIN ongkir ON pembelian.id_ongkir = ongkir.id_ongkir
                        WHERE pembelian.id_pembelian = '$id_pembelian'
                    ");
    $detail = $ambil->fetch_assoc();

    // Fungsi untuk menghasilkan nomor resi otomatis
    function generateResi() {
        return 'RESI-' . strtoupper(uniqid());
    }
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered" style="margin-top: 10px;">
                <tr>
                    <th>Status</th>
                    <th><?php echo $detail['status_pembelian']; ?></th>
                </tr>
                <tr>
                    <th>Produk</th>
                    <th>
                        <?php
        $ambil_produk = $koneksi->query("SELECT 
                                        pembelian_produk.jumlah,
                                        pembelian_produk.id_produk
                                    FROM pembelian_produk
                                    WHERE pembelian_produk.id_pembelian = '$id_pembelian'");
        $nomor = 1;
        while($row = $ambil_produk->fetch_assoc()) {
            $id_produk = $row['id_produk'];
            $nama_produk = "Produk tidak ditemukan";

            // Cek di tabel produk
            $ambil_produk_detail = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
            if ($ambil_produk_detail->num_rows > 0) {
                $data_produk = $ambil_produk_detail->fetch_assoc();
                $nama_produk = $data_produk['nama_produk'];
            }

            // Cek di tabel produk_terpisah
            $ambil_produk_terpisah = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$id_produk'");
            if ($ambil_produk_terpisah->num_rows > 0) {
                $data_produk_terpisah = $ambil_produk_terpisah->fetch_assoc();
                $nama_produk = $data_produk_terpisah['nama_produk'];
            }

            echo '<div style="display: flex; align-items: center;">';
            echo '<span style="display: inline-block; width: 20px;">' . $nomor . '.</span>';
            echo '<span style="display: inline-block; width: 400px;">' . $nama_produk . '</span>';
            echo '</div>';
            $nomor++;
        }
        ?>
                    </th>
                </tr>
                <tr>
                    <th>No. Pelanggan</th>
                    <th><?php echo $detail['telepon_pelanggan']; ?></th>
                </tr>
                <tr>
                    <th>Nama</th>
                    <th><?php echo $detail['nama_pelanggan']; ?></th>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <th><?php echo $detail['alamat_pelanggan']; ?></th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th><?php echo date("d F Y",strtotime($detail['tanggal'])); ?></th>
                </tr>
                <tr>
                    <th>Total Ongkir</th>
                    <th>Rp. <?php echo number_format($detail['tarif']); ?></th>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <th><?php echo $detail['metode_pembayaran']; ?></th>
                </tr>
                <?php if($detail['metode_pembayaran'] !== 'Cash on Delivery (COD)'): ?>
                <tr>
                    <th>Bank</th>
                    <th><?php echo $detail['bank']; ?></th>
                </tr>
                <tr>
                    <th>No. Rekening</th>
                    <th><?php echo $detail['no_rekening']; ?></th>
                </tr>
                <?php endif; ?>
                <tr>
                    <th>Total Tagihan</th>
                    <th>Rp. <?php echo number_format($detail['total_pembelian']); ?></th>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <img src="../bukti_pembayaran/<?php echo $detail['bukti']; ?>" alt="" class="img-responsive">
        </div>
    </div>
</div>

<form action="" method="post">
    <div class="form-group">
        <label for="resi">No Resi Pengiriman</label>
        <input type="text" class="form-control" name="resi" value="<?php echo generateResi(); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" name="status" id="">
            <option value="">Pilih Status</option>
            <option value="Barang Dalam Pengiriman">Barang Dalam Pengiriman</option>
            <option value="Barang Sudah Sampai">Barang Sudah Sampai</option>
        </select>
    </div>
    <button class="btn btn-primary" name="proses"><i class="fa fa-check-circle"></i> Proses</button>
</form>

<?php
    if(isset($_POST['proses'])) {
        $resi = $_POST['resi'];
        $status = $_POST['status'];

        $koneksi->query("UPDATE pembelian SET resi_pengiriman='$resi', status_pembelian='$status' WHERE id_pembelian='$id_pembelian'");

        echo "<script>alert('Data pembelian terupdate');</script>";
        echo "<script>location='index.php?halaman=transaksi';</script>";
    }
?>