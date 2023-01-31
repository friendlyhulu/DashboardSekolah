<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

//Pengecekan pilihan kelas
if(isset($_POST['kelas']))
    $_SESSION['kelas'] = $_POST['kelas'];

?>

<?php

   $query = "SELECT * FROM tabel_pelajaran JOIN tabel_guru ON tabel_pelajaran.id_mapel=tabel_guru.id_mapel WHERE tabel_guru.nama_guru = '" . $_SESSION['nama'] . "' ";
   $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
   $namauser = mysqli_fetch_assoc($hasil);
    // $namauser['id_guru']

    $query = "SELECT * FROM tabel_kelas WHERE tabel_kelas.kelas= '" . $_SESSION['kelas'] . "' ";
    $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
    $kelas = mysqli_fetch_array($hasil);
   // $kelas['id_kelas'];



//Menambahkan data ke tabel siswa
if(isset($_POST['submit'])){

    $nama_siswa     = $_POST["nama_siswa"];
    $catatan        = $_POST["catatan"];

    $query = "INSERT into catatan_guru (id_guru, nama_siswa,id_kelas, catatan) values ('".$namauser['id_guru']."', '$nama_siswa','".$kelas['id_kelas']."', '$catatan')";
    $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);

    //Notikasi ketika berhasil di tambahkan
    if ($hasil) {
        echo '<br><div class="alert alert-primary" role="alert">Catatan berhasil ditambahkan - <a href="../guru_mapel/catatan_guru.php" class="alert-link">Lihat Catatan</a></div>';
    } else {
        echo '<br><div class="alert alert-danger" role="alert">Catatan gagal ditambahkan, mohon cek kembali</div>';
    }
    
}
?>



<html>
<head>
    <title>SISWA - WALI KELAS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="../css/dashboard.css ?v=<?php echo time(); ?>">
</head>

<!-- HEADER -->
<body id="body-pd" class="body-pd">
    <header class="header body-pd" id="header">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>

        <div class="header__user">
        <a> Selamat datang, <?php echo $_SESSION['nama']; ?> &#128075; | </a>
            <?php
                $query = "SELECT * FROM tabel_pelajaran JOIN tabel_guru ON tabel_pelajaran.id_mapel=tabel_guru.id_mapel WHERE tabel_guru.nama_guru = '" . $_SESSION['nama'] . "' ";
                $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                $namauser = mysqli_fetch_assoc($hasil);
            ?>
            &ensp;
            <p><?php echo $namauser['nama_pelajaran']  ?></p>
        </div>
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
                    <a href="../guru_mapel/halaman_mapel.php" class="nav__link">
                        <i class='bx bx-grid-alt nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="../guru_mapel/halaman_nilai.php" class="nav__link">
                        <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                        <span class="nav__name">Nilai</span>
                    </a>

                    <a href="../guru_mapel/tampil_siswa.php" class="nav__link ">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Siswa</span>
                    </a>

                    <a href="../guru_mapel/catatan_guru.php" class="nav__link active">
                        <i class='bx bx-folder nav__icon'></i>
                        <span class="nav__name">Catatan</span>
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



<!-- Content --> 
    <!-- Identitas Menu--> 
    <br>
    <div class="card text-white bg-dark mb-3"> &ensp;
        <h4 style="padding-left: 15px;"><b>  Tambah Catatan</b></h4>
            <div class="card-header">Silahkan lengkapi form berikut untuk menambahkan catatan</div>
        </div>
    
    <!-- Form tambah data siswa-->
    <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded" >
        
    <a href="../guru_mapel/catatan_guru.php" class="btn text-light" style="background-color: #193498;"><i class='fas fa-angle-left'></i> Kembali</a>
    <br>
    <form action = "input_catatan.php" method = "post" id="formtambah">
        

        <br> 
        <div class = "form-group row">
        <label for = "nama" class = "col-sm-2 col-form-label">Nama</label>
        <div class = "col-sm-8">
        <input type = "text" name = "nama_siswa" class = "form-control" placeholder = "Masukkan Nama" required />
        </div>
        </div>
        <br>


        <div class = "form-group row">
        <label for = "catatan" class = "col-sm-2 col-form-label">Catatan</label>
        <div class = "col-sm-8">
        <textarea name = "catatan" class = "form-control" rows ="3" placeholder = "Masukkan catatan" required ></textarea>
        </div>
        </div>
        <br>

       

        <div class = "buttontambah1">
        <button type = "submit" name = "submit" class="btn text-light" style="background-color: #1C7947;"><i class='fas fa-plus-square'></i> Tambah</button>
        </div>
    </form>
    </div>

    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>
</html>
