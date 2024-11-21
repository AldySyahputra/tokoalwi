<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
</head>

<h4><strong>List Akun User</strong></h4>
<hr>
<h5><strong>Akun User</strong></h5>
<h5 style="color:darkgray;">Dibawah ini adalah list user yang berhasil registrasi :</h5>

<div class="table-responsive">
    <table id="userTable" class="table table-bordered" style="margin-top: 15px;">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Tanggal Lahir</th>
                <th class="text-center">Alamat Rumah</th>
                <th class="text-center">No. Telephone</th>
                <th class="text-center">Email</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor=1; ?>
            <?php $ambil = $koneksi->query("SELECT * FROM pelanggan"); ?>
            <?php while ($pecah = $ambil->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['nama_pelanggan']; ?></td>
                <td><?php echo $pecah['gender']; ?></td>
                <td><?php echo $pecah['tanggal_lahir']; ?></td>
                <td><?php echo $pecah['alamat_pelanggan']; ?></td>
                <td><?php echo $pecah['telepon_pelanggan']; ?></td>
                <td><?php echo $pecah['email_pelanggan']; ?></td>
                <td>
                    <a href="hapuspelanggan.php?id=<?php echo $pecah['id_pelanggan']; ?>" class="btn btn-danger"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">Hapus Akun User</a>
                </td>
            </tr>
            <?php $nomor++; ?>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#userTable').DataTable();
});
</script>