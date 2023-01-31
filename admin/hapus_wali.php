<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

$id_kelas = $_GET['id_kelas'];

//Hapus data
$query = "DELETE FROM tabel_kelas WHERE id_kelas=$id_kelas";
$hasil = mysqli_query($con, $query);

if ($hasil) {
    echo '<br><div class="alert alert-primary" role="alert">Data siswa berhasil dihapus</div>';
    header("Location:tambah_wali.php");
} else {
    echo '<br><div class="alert alert-danger" role="alert">Data siswa gagal dihapus</div>';
}

?>
