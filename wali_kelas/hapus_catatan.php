<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

$id_catatan = $_GET['id_catatan'];

//Hapus data
$query = "DELETE FROM tabel_catatan WHERE id_catatan=$id_catatan";
$hasil = mysqli_query($con, $query);

if ($hasil) {
    echo '<br><div class="alert alert-primary" role="alert">Catatan berhasil dihapus</div>';
    header("Location:catatan_wali.php");
} else {
    echo '<br><div class="alert alert-danger" role="alert">Catatan gagal dihapus</div>';
}

?>
