<?php
//Koneksi ke database
require('./database/koneksi.php');

//Membuat sesi baru
session_start();

if(isset($_POST['login'])){
//Menerima inputan dari form login
$username = $_POST['username'];
$password = $_POST['password'];
//Pengecekan jika username atau password sesuai
$query   = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result   = mysqli_query($con, $query);
//Mengecek jika username dan password ada pada database
$cek = mysqli_num_rows($result);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);

    //Fungsi Login sebagai Guru Mata Pelajaran
    if ($data['role'] == "mapel") {
        $_SESSION['nama']     = $data['nama_lengkap'];  
        $_SESSION['role']     = "mapel";

        //Menuju halaman Guru Mata Pelajaran
        header("Location:./guru_mapel/halaman_mapel.php");
    } elseif ($data['role'] == "wali") {
        $_SESSION['nama']     = $data['nama_lengkap'];   
        $_SESSION['role']     = "wali";

        //Menuju halaman Wali Kelas
        header("Location:./wali_kelas/dashboard_wali.php");
    } else {
        header("Location:login.php?pesan=gagal");
    }
} else {
    header("location:login.php?pesan=gagal");
  }
}
?>

<?php 
    //Alert Ketika Gagal Login
    if(isset($_GET['pesan'])){
        if($_GET['pesan']=="gagal"){
        echo "<script>alert('Username dan Password Salah, Silahkan Masuk Cek Kembali');history.go(-1);</script>";
    }
}
?>

<html>
    <head>
        <title>MASUK</title>
        
            <!--Import css-->
            <link type="text/css" rel="stylesheet" href="./css/login.css"? <?php echo time(); ?> />
        </head>
    <body>
        <!-- FORM INPUT UNTUK LOGIN -->    
        <form action="login.php" class="form" method="post" name="login" style="margin-top: 70px;">
                <div class="container">

                    <h1>Masuk</h1>
                    <p>Silahkan lengkapi form untuk masuk.</p>
                    <hr>

                    <!--Input username-->
                    <label for="name"><b>Username</b></label>
                    <input type="text" class="login-input" name="username" style="font-size: 14px;" placeholder="Silahkan masukkan username" required />

                    <!--Input password-->
                    <label for="name"><b>Password</b></label>
                    <input type="password" class="login-input" name="password" style="font-size: 14px;" placeholder="Silahkan masukkan password" required />

                    
                    <hr>

                    <!--Tombol Login-->
                    <div class="tombol">
                    <input type="submit" name="login" value="Masuk" class="login-button" style="width: 40%;">
                    </div>

                </div>
                <p style="text-align: center;">Masuk sebagai admin ? <a href="./admin/login_admin.php">Admin</a></p>
        </form>
        <!-- FORM INPUT UNTUK LOGIN -->   
</body>
</html>