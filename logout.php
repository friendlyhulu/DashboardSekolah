<?php 
// Untuk mengaktifkan session pada php
session_start();

$_SESSION['username']='';
$_SESSION['role']='';


unset($_SESSION['username']);
unset($_SESSION['role']);

session_unset();
// Untuk menghapus semua session
session_destroy();
// pindah halaman ke halaman login
header("location:login.php");
?>