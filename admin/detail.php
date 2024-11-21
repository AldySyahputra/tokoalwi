<h4><strong>Detail Pembelian</strong></h4>
<hr>
<h5><strong>Detail Pembelian User</strong></h5>
<h5 style="color:darkgray;">Dibawah ini adalah Detail Pembelian User :</h5>

<?php
    $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$_GET[id]'");
    $detail = $ambil->fetch_assoc();
?>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h4>PEMBELIAN</h3>
                <strong>
                    Status Barang : <?php echo $detail["status_pembelian"]; ?> <br>
                    No. Resi : <?php echo $detail["resi_pengiriman"]; ?> <br>
                </strong>
                Tanggal : <?php echo $detail["tanggal_pembelian"]; ?> <br>
                Total : <?php echo $detail["total_pembelian"]; ?>
        </div>
        <div class="col-md-3">
            <h4>PELANGGAN</h3>
                <strong>NAMA : <?php echo $detail["nama_pelanggan"]; ?></strong> <br>
                No. Telepon : <?php echo $detail["telepon_pelanggan"]; ?> <br>
                Email : <?php echo $detail["email_pelanggan"]; ?>
        </div>
        <div class="col-md-3">
            <h4>PENGIRIMAN</h3>
                <strong>Ongkos Pengiriman : Rp. <?php echo number_format($detail['tarif']); ?></strong> <br>
                Alamat Pengiriman : <?php echo $detail['alamat_pengiriman']; ?>
        </div>
    </div>
</div>
<table class="table table-bordered" style="margin-top: 10px;">
    <thead>
        <tr>
            <th>No</th>
            <th class="text-center">Nama Produk</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
             $nomor = 1; 
             $total_belanja = 0;
             $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'");
             while($pecah = $ambil->fetch_assoc()) {
                 $id_produk = $pecah['id_produk'];
                 $harga_produk = 0;
                 $berat_produk = 0;
                 $nama_produk = "Produk tidak ditemukan";
                 $satuan_berat = "";

                // Cek di tabel produk
                $ambil_produk = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                if ($ambil_produk->num_rows > 0) {
                    $data_produk = $ambil_produk->fetch_assoc();
                    $harga_produk = isset($data_produk['harga_produk']) ? $data_produk['harga_produk'] : 0;
                    $berat_produk = isset($data_produk['ukuran_produk']) ? $data_produk['ukuran_produk'] : 0;
                    $nama_produk = $data_produk['nama_produk'];
                    $satuan_berat = isset($data_produk['satuan_berat']) ? $data_produk['satuan_berat'] : "";
                }

                // Cek di tabel produk_terpisah
                $ambil_produk_terpisah = $koneksi->query("SELECT * FROM produk_terpisah WHERE id_produk_terpisah='$id_produk'");
                if ($ambil_produk_terpisah->num_rows > 0) {
                    $data_produk_terpisah = $ambil_produk_terpisah->fetch_assoc();
                    $harga_produk = isset($data_produk_terpisah['harga_eceran']) ? $data_produk_terpisah['harga_eceran'] : $harga_produk;
                    $berat_produk = 0;
                    $berat_produk += isset($data_produk_terpisah['berat_satuan']) ? floatval($data_produk_terpisah['berat_satuan']) : 0;
                    $berat_produk += isset($data_produk_terpisah['berat_kiloan']) ? floatval($data_produk_terpisah['berat_kiloan']) : 0;
                    $berat_produk += isset($data_produk_terpisah['berat_literan']) ? floatval($data_produk_terpisah['berat_literan']) : 0;
                    $berat_produk += isset($data_produk_terpisah['berat_rencengan']) ? floatval($data_produk_terpisah['berat_rencengan']) : 0;
                    $nama_produk = $data_produk_terpisah['nama_produk'];
                    // Satuan berat tidak ada dalam tabel produk_terpisah, jadi kita bisa menggunakan nilai default atau menghapus baris ini
                    $satuan_berat = isset($data_produk_terpisah['satuan_berat']) ? $data_produk_terpisah['satuan_berat'] : $satuan_berat;
                }

                 $subharga = $harga_produk * $pecah['jumlah'];
                 $total_belanja += $subharga;
         ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $nama_produk; ?></td>
            <td class="text-center">Rp. <?php echo number_format($harga_produk); ?></td>
            <td class="text-center"><?php echo $pecah['jumlah']; ?></td>
            <td class="text-center">Rp. <?php echo number_format($subharga); ?></td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>