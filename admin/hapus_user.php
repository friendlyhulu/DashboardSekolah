<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

$kode_user = $_GET['kode_user'];

//Hapus data
$query = "DELETE FROM user WHERE kode_user=$kode_user";
$hasil = mysqli_query($con, $query);

if ($hasil) {
    echo '<br><div class="alert alert-primary" role="alert">Data siswa berhasil dihapus</div>';
    header("Location:halaman_admin.php");
} else {
    echo '<br><div class="alert alert-danger" role="alert">Data siswa gagal dihapus</div>';
}

?>
