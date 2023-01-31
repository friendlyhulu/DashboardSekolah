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
$query = "DELETE FROM catatan_guru WHERE id_catatan= $id_catatan";
$hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);

if ($hasil) {
    echo '<br><div class="alert alert-primary" role="alert">Catatan berhasil dihapus</div>';
    header("Location:catatan_guru.php");
} else {
    echo '<br><div class="alert alert-danger" role="alert">Catatan gagal dihapus</div>';
}

?>
        