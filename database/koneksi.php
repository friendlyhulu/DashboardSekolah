<?php

//Masukkan hostname, database username, password, database name
$con = mysqli_connect("localhost","root","","sekolah");
//Check koneksi
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} 

?>