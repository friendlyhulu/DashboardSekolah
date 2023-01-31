<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');


session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

$id_guru= $_GET['id_guru'];
$id_mapel = $_GET['id_mapel'];


$query = "DELETE FROM tabel_guru WHERE id_guru= '$id_guru'";
$hasil = mysqli_query($con, $query)or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);

$query1 = "DELETE FROM tabel_pelajaran WHERE id_mapel= '$id_mapel'";
$hasil1 = mysqli_query($con, $query1)or trigger_error("Query Failed! SQL: $query1 - Error: ".mysqli_error($con), E_USER_ERROR);

if ($hasil && $hasil1) {
    echo '<br><div class="alert alert-primary" role="alert">Data siswa berhasil dihapus</div>';
    header("Location:tambah_guru.php");
} else {
    echo '<br><div class="alert alert-danger" role="alert">Data siswa gagal dihapus</div>';
}

?>
