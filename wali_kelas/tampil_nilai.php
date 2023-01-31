<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

if(isset($_GET['mapel'])){
    $_SESSION['mapel'] = $_GET['mapel'];
}

if(isset($_POST['semester'])){
    $_SESSION['semester'] = $_GET['semester'];

}
?>

<html>
<head>
    <title>Dashboard - WALI KELAS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
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

                    <a href="../wali_kelas/tampil_siswa.php" class="nav__link">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Siswa</span>
                    </a>

                    <a href="../wali_kelas/tampil_nilai.php" class="nav__link active">
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
    <br>
    <div class="card text-white bg-dark mb-3"> &ensp;
        <h4 style="padding-left: 15px;"><b>  Daftar Nilai</b></h4>
            <div class="card-header">Halaman ini memuat daftar nilai dari siswa/siswi</div>
        </div>

    <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded">  
        <p>*Silahkan pilih mata pelajaran yang akan dilihat</p>  
        <p>**Kemudian pilih semester</p>

    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">    
    <div id="filters">
        <!-- FILTER MATA PELAJARAN-->
        <select name="mapel" id="mapel">
            <option value="" disabled="" selected="">Pilih Mata Pelajaran</option>
            <option value="Fisika">Fisika</option>
            <option value="Kimia">Kimia</option>
            <option value="Matematika">Matematika</option>
            <option value="Bahasa">Bahasa Indonesia</option>
            <option value="Seni">Seni</option>
            <option value="Pkn">PKn</option>
        </select>

    <span>
        <!-- FILTER SEMESTER-->    
        <select name="semester" id="semester">
            <option value="" disabled="" selected="">Pilih semester</option>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
        </select>
        </span>
    <span >
            <button type="submit" name="login" class="btn btn-secondary" style="width:100px">Pilih</button>
        </span>    
    </form>

    <br>
  
    <!-- TABEL NILAI -->
    <div class="containernilai">       
    <table class="table table-bordered table-hover">
    <br>
        <thread>
        <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Mata Pelajaran</th>
        <th style="width:10%;">Semester</th>
        <th>Tugas 1</th>
        <th>Tugas 2</th>
        <th>Tugas 3</th>
        <th>Tugas 4</th>
        <th>UTS</th>
        <th>UAS</th>
        <th>Nilai Akhir</th>
        </tr>
        </thread>
            <!-- QUERY UNTUK MENAMPILKAN DATA NILAI -->    
            <?php
            if(isset($_GET['mapel']) && isset($_GET['semester'])){
            $mapel = trim($_GET['mapel']);

            $semester = trim($_GET['semester']); 

            $sql = "SELECT * FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='$mapel' AND semester='$semester' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";

            } else { 
                $sql = "SELECT * FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Matematika' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";
            } 
                $hasil = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                $no++;
                ?>
                <tbody>
                <tr>
                <td><?php echo $no ?></td>    
                <td><?php echo $data["nis"]; ?></td>
                <td><b><?php echo $data["nama_siswa"]; ?></b></td>
                <td><?php echo $data["nama_pelajaran"]; ?></td>
                <td><?php echo $data["semester"]; ?></td>
                <td><?php echo $data["nilai_tugas1"]; ?></td>
                <td><?php echo $data["nilai_tugas2"]; ?></td>
                <td><?php echo $data["nilai_tugas3"]; ?></td>
                <td><?php echo $data["nilai_tugas4"]; ?></td>
                <td><?php echo $data["nilai_uts"]; ?></td>
                <td><?php echo $data["nilai_uas"]; ?></td>
                <td><b><?php echo $data["rata_nilai"]; ?></b></td>
                    </tr>
                    </tbody>
                    <?php
                }
                ?>
                </table>
    </div>
    </div>
    </div>

    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>
</html>