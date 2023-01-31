<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

$id_siswa = $_GET['id_siswa'];

//Hapus data
$query = "DELETE FROM tabel_siswa WHERE id_siswa=$id_siswa";
$hasil = mysqli_query($con, $query);

if ($hasil) {
    echo '<br><div class="alert alert-primary" role="alert">Data siswa berhasil dihapus</div>';
    header("Location:tampil_siswa.php");
} else {
    echo '<br><div class="alert alert-danger" role="alert">Data siswa gagal dihapus</div>';
}

?>
