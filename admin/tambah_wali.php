<?php
//Koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();

if($_SESSION['role'] == ""){
    header("Location:login_admin.php?pesan=gagal");
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

<?php
    if(isset($_POST['simpan'])){

        $kelas = $_POST['kelas'];
        $wali_kelas = $_POST['wali_kelas'];

        $sql = "INSERT into tabel_kelas (kelas, wali_kelas) values ('$kelas', '$wali_kelas')";
        $proses = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);

  if ($proses) {
        echo '<br><div class="alert alert-primary" role="alert"> Wali kelas berhasil ditambahkan</div>';
    } else {
        echo '<br><div class="alert alert-danger" role="alert">Wali kelas gagal ditambahkan, mohon cek kembali</div>';
    }
    

    }

?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Halaman ADMIN</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link type="text/css" rel="stylesheet" href="../css/dashboard.css"?<?php echo time(); ?>>

</head>
<body id="body-pd" class="body-pd">
    <header class="header body-pd" id="header">
        <div class="header__toggle">
        </div>

        <!--  MENAMPILKAN NAMA USER LOGIN && KELAS -->
        <div class="header__user" style="margin-top:0px">
            <a> Selamat datang, <?php echo $_SESSION['nama']; ?> &#128075;</a>
        </div>
        <!--  MENAMPILKAN NAMA USER LOGIN && KELAS -->
    </header>

<!-- SIDEBAR -->
    <div class="l-navbar show" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav__logo">
                    <i class='bx bx-layer nav__logo-icon'></i>
                    <span class="nav__logo-name">Akademik</span>
                </a>

                <div class="nav__list">
                    <a href="../admin/halaman_admin.php" class="nav__link ">
                        <i class='bx bx-user-plus bx-sm nav__icon'></i>
                        <span class="nav__name">User</span>
                    </a>

                    <a href="../admin/tambah_guru.php" class="nav__link">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Guru</span>
                    </a>

                    <a href="../admin/tambah_wali.php" class="nav__link active">
                       <i class='bx bx-user-circle nav__icon' ></i>
                        <span class="nav__name">Wali Kelas</span>
                    </a>
                    
                     <a href="../admin/tambah_siswa.php" class="nav__link">
                        <i class='bx bx-id-card nav__icon'></i>
                        <span class="nav__name">Siswa</span>
                    </a>
                </div>

                <br><br><br>
                <a href="../logout.php" class="nav__link">
                <i class='bx bx-log-out nav__icon'></i> 
                <span class="nav__name">Keluar<span>
            </a>
            </div>
        </nav>
    </div>

      <br>
     <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded"> 
       <div class="card text-white bg-dark mb-3"> &ensp;
        <h5 style="padding-left: 15px; margin-top: -10px;"><b>Tambah Wali Kelas</b></h4>
        </div>
        <br>
         <form method="POST">
              <div class="row">

                <div class="col">
                  <label for = "kelas" class = "col-sm col-form-label"><b>Kelas</b></label>  
                  <input type="text" name="kelas" class="form-control"  required>
                </div>

                <div class="col">
                  <label for = "wali_kelas" class = "col-sm col-form-label"><b>Nama Lengkap</b></label>  
                  <input type="text" name="wali_kelas" class="form-control" required>
                </div>

               </div>
               <br>
                <button type="submit" name="simpan" class="btn text-light" style="float:right; background-color: #1C7947;">Simpan</button> 
                <br>

        </form>
        </div>
           <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded" style="margin-top:-30px">  
            <p>*Nama lengkap harus sesuai dengan nama lengkap pada User</p>
        <table class="table table-bordered table-hover">
        <thread>
        <tr>
        <th style="text-align: center;">No</th>
        <th>Kelas</th>
        <th>Wali Kelas</th>
        <th colspan='1' style="text-align:center;"> Aksi</th>
        </tr>
        </thread>
            <!-- QUERY UNTUK MENAMPILKAN IDENTITAS SISWA -->
            <?php     
            $sql   = "SELECT * FROM tabel_kelas";
            $hasil = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
            $no    = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                $no++;
                ?>
                <tbody>
                <tr>
                <td style="text-align:center;"><?php echo $no ?></td>    
                <td><?php echo $data["kelas"]; ?></td>
                <td><?php echo $data["wali_kelas"]; ?></td>
                  <td style="text-align: center;">
                    <a href = "./hapus_wali.php? id_kelas=<?php echo htmlspecialchars($data['id_kelas']); ?>" class="btn btn-danger" role="button">Hapus</a>
                    </td>
                    </tr>
                    </tbody>
                    <?php
                }
                ?>
            </table>
    </div>

           </div>   

</body>
</html>