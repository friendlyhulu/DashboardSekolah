<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
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
        
        <!--  MENAMPILKAN NAMA USER LOGIN && KELAS -->
        <div class="header__user">
        <a> Selamat datang, <?php echo $_SESSION['nama']; ?> &#128075; | </a>
            <?php
                $query = "SELECT id_kelas, kelas, wali_kelas FROM tabel_kelas where tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";
                $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                $namauser = mysqli_fetch_assoc($hasil);
            ?>
            &ensp;
            <p><?php echo $namauser['kelas']  ?></p>
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
                    <a href="../wali_kelas/dashboard_wali.php" class="nav__link ">
                        <i class='bx bx-grid-alt nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="../wali_kelas/tampil_siswa.php" class="nav__link active">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Siswa</span>
                    </a>

                    <a href="../wali_kelas/tampil_nilai.php" class="nav__link">
                        <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                        <span class="nav__name">Nilai</span>
                    </a>

                    <a href="../wali_kelas/catatan_wali.php" class="nav__link">
                        <i class='bx bx-folder nav__icon'></i>
                        <span class="nav__name">Catatan <br>& Ekstrakurikuler</span>
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
        <h4 style="padding-left: 15px;"><b>  Daftar Siswa</b></h4>
            <div class="card-header">Halaman ini memuat daftar siswa/siswi</div>
        </div>
    
    <!-- Tampil daftar identitas Siswa-->
    <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded">  
        <!--Tombol tambah data
        <a href="../wali_kelas/tambah_siswa.php" class="btn text-light" style="background-color: #1C7947;"><i class='fas fa-plus-square'></i> Tambah</a>
        <br> -->
        
    <!-- TABEL SISWA -->
    <table class="table table-bordered table-hover display" id="myTable">
    <br>
        <thead>
        <tr>
        <th style="text-align: center;">No</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>No.Hp</th>
        <th> Aksi</th>
        </tr>
        </thead>
            <!-- QUERY UNTUK MENAMPILKAN IDENTITAS SISWA -->
            <?php     
            $sql   = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas = tabel_kelas.id_kelas WHERE tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";
            $hasil = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
            $no    = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                $no++;
                ?>
                <tbody>
                <tr>
                <td style="text-align:center;"><?php echo $no ?></td>    
                <td><?php echo $data["nis"]; ?></td>
                <td><b><?php echo $data["nama_siswa"]; ?></td>
                <td><?php echo $data["jenis_kelamin"]; ?></td>
                <td><?php echo $data["tempat_lahir"]; ?></td>
                <td><?php echo date('d M Y', strtotime($data["tanggal_lahir"]));   ?></td>
                <td><?php echo $data["alamat"]; ?></td>
                <td><b><?php echo $data["no_hp"]; ?></b></td>
                <td style="text-align: center;">
                    <a href = "./update_siswa.php? id_siswa=<?php echo htmlspecialchars($data['id_siswa']); ?>"class = "btn text-light" style="background-color: #CE7B40;" role = "button" > Ubah </a>
            
                
                  
                    </td>
                    </tr>
                    </tbody>
                    <?php
                }
                ?>
            </table>
    </div>

   

    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>
</html>
