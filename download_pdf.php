<?php
require_once 'vendor/tecnickcom/tcpdf/tcpdf.php'; // Pastikan path ini sesuai dengan lokasi instalasi TCPDF Anda
include 'koneksi.php';

$id_pembelian = isset($_GET['id']) ? $_GET['id'] : die('ID Pembelian tidak ditemukan!');

// Query untuk mendapatkan data pembayaran
$query = $koneksi->query("SELECT 
pembayaran.*, 
pembelian.*, 
pembelian_produk.*, 
pelanggan.*, 
ongkir.nama_kota AS kota_ongkir, 
ongkir.tarif AS tarif_ongkir,
produk.nama_produk AS nama_produk,
produk_terpisah.nama_produk AS nama_produk
FROM pembelian 
LEFT JOIN pembayaran ON pembayaran.id_pembelian = pembelian.id_pembelian 
LEFT JOIN pembelian_produk ON pembelian_produk.id_pembelian = pembelian.id_pembelian 
LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembelian.id_pelanggan 
LEFT JOIN ongkir ON pembelian.id_ongkir = ongkir.id_ongkir
LEFT JOIN produk ON pembelian_produk.id_produk = produk.id_produk
LEFT JOIN produk_terpisah ON pembelian_produk.id_produk = produk_terpisah.id_produk_terpisah
WHERE pembelian.id_pembelian = '$id_pembelian'
");
$data = $query->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Membuat instance PDF
$pdf = new TCPDF();

// Mengatur informasi dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Toko Alwi');
$pdf->SetTitle('Bukti Pembayaran');
$pdf->SetSubject('Bukti Pembayaran');
$pdf->SetKeywords('TCPDF, PDF, bukti, pembayaran');

// Menambahkan halaman
$pdf->AddPage();

// Menambahkan isi
$html = '<h2 style="color: #03ac0e; font-family: Trebuchet MS, Lucida Sans Unicode, Lucida Grande, Lucida Sans, Arial, sans-serif;"><strong>Toko Alwi</strong></h2>';
$html .= '<p><strong>Invoice Toko Alwi</strong><br>Invoice ini merupakan pembayaran yang sah, dan diterbitkan atas nama Partner :</p>';
$html .= '<img src="admin/assets/img/logo1.jpg" width="130" height=""><br>' ;
$html .= '<strong style="margin-top: 50px">Nama: </strong>' . $data['nama_pelanggan'] . '<br>';
$html .= '<strong>Tanggal: </strong>' . date("d F Y", strtotime($data['tanggal'])) . '<br><br>';
$html .= '<table border="1" cellpadding="4">';
$html .= '<tr><th>Status</th><td>' . $data['status_pembelian'] . '</td></tr>';
// Menambahkan logika untuk mendapatkan nama produk dan membuat tabel HTML
$html .= '<tr><th>Produk</th><td>';
$html .= '<table border="0" cellpadding="4" style="width: 120%;">';

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

    $html .= '<tr>';
    $html .= '<td style="width: 5%;">' . $nomor . '</td>';
    $html .= '<td style="width: 65%;">' . $nama_produk . '</td>';
    $html .= '</tr>';
    $nomor++;
}

$html .= '</table>';
$html .= '</td></tr>';
$html .= '<tr><th>No. Pelanggan</th><td>' . $data['telepon_pelanggan'] . '</td></tr>';
$html .= '<tr><th>Nama</th><td>' . $data['nama_pelanggan'] . '</td></tr>';
$html .= '<tr><th>Alamat</th><td>' . $data['alamat_pelanggan'] . '</td></tr>';
$html .= '<tr><th>Total Tagihan</th><td>Rp. ' . number_format($data['total_pembelian']) . '</td></tr>';
$html .= '<tr><th>Metode Pembayaran</th><td>' . $data['metode_pembayaran'] . '</td></tr>';
if ($data['metode_pembayaran'] !== 'Cash on Delivery (COD)') {
    $html .= '<tr><th>Bank</th><td>' . $data['bank'] . '</td></tr>';
    $html .= '<tr><th>No. Rekening</th><td>' . $data['no_rekening'] . '</td></tr>';
}
$html .= '</table><br>';

// Menambahkan bagian Biaya Ongkir dan Total Pembayaran
$html .= '<p><strong>Biaya Ongkir : </strong> <span style="float: right;">Rp. ' . number_format($data['tarif_ongkir']) . '</span></p>';
$html .= '<p><strong>TOTAL PEMBAYARAN </strong> </p>';
$html .= '<p><strong>Total Bayar : </strong> <span style="float: right; color: #03AC0E;">Rp. ' . number_format($data['total_pembelian']) . '</span></p><br>';

$html .= '<p><strong>Detail Periode Terbayar</strong></p>';
$html .= '<table border="1" cellpadding="4">';
$html .= '<tr><th>Periode</th><td>' . date("d F Y", strtotime($data['tanggal'])) . '</td></tr>';
$html .= '<tr><th>Tagihan</th><td>Rp. ' . number_format($data['total_pembelian']) . '</td></tr>';
$html .= '</table><br>';

if ($data['metode_pembayaran'] !== 'Cash on Delivery (COD)') {
    $html .= '<p><strong>Bukti Pembayaran</strong></p>';
    $html .= '<img src="bukti_pembayaran/' . $data['bukti'] . '" width="300" height="300">';
}


$pdf->writeHTML($html, true, false, true, false, '');

// Menutup dan output PDF
$pdf->Output('bukti_pembayaran.pdf', 'I');
?>