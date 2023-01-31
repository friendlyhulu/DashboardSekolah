 <?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');

//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");

//Pengecekan pilihan kelas
if(isset($_POST['kelas']))
    $_SESSION['kelas'] = $_POST['kelas'];
}

?>

<html>
<head>
    <title>Dashboard - GURU</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>    
    
    <link rel="stylesheet" href="../css/dashboard.css ?v=<?php echo time(); ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>

<body id="body-pd" class="body-pd"> 
    <header class="header body-pd" id="header">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>

        <div class="header__user">
            <!--  MENAMPILKAN NAMA USER LOGIN && MAPEL -->
            <p> Selamat datang, <?php echo $_SESSION['nama']; ?> &#128075; |</p>
            <?php
                $query = "SELECT * FROM tabel_pelajaran JOIN tabel_guru ON tabel_pelajaran.id_mapel=tabel_guru.id_mapel WHERE tabel_guru.nama_guru = '" . $_SESSION['nama'] . "' ";
                $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                $namauser = mysqli_fetch_assoc($hasil);
            ?>
            &ensp;
            <p><?php echo $namauser['nama_pelajaran'] ?></p>
        </div>
            <!--  MENAMPILKAN NAMA USER LOGIN && MAPEL -->
    </header>

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

                    <a href="../guru_mapel/halaman_nilai.php" class="nav__link active">
                        <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                        <span class="nav__name">Nilai</span>
                    </a>

                    <a href="../guru_mapel/tampil_siswa.php" class="nav__link">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Siswa</span>
                    </a>

                    <a href="../guru_mapel/catatan_guru.php" class="nav__link">
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

<!-- Content     <br>
    <div class="card text-white bg-dark mb-3"> &ensp;
        <h4 style="padding-left: 15px;"><b>  Daftar Nilai</b></h4>
            <div class="card-header">Halaman ini memuat daftar nilai dari siswa/siswi</div>
        </div>  -->

     
   <!--  Form input nilai -->
     <br>
     <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded"> 
        <div class="card text-white bg-dark mb-3"> &ensp;
        <h5 style="padding-left: 15px; margin-top: -15px;"><b>Input dan Edit Nilai</b></h4>
        </div>
             <form method="POST">
              <div class="row">

                <div class="col">
                  <label for = "nama_siswa" class = "col-sm col-form-label"><b>Nama</b></label>  
                  <select class = "form-select" name = "nama_siswa" style="margin-top: 0px;">
                        <option disabled selected>Pilih Nama Siswa</option>
                        <?php
                            $sql = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas = tabel_kelas.id_kelas WHERE tabel_kelas.kelas = '" . $_SESSION['kelas'] . "' ORDER BY nama_siswa";
                            $hasil = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                            while ($data = mysqli_fetch_array($hasil)){
                              ?>
                                <option value="<?=$data['nis']?>"><?=$data['nama_siswa']?></option> 
                             <?php     
                            } 
                        ?>
                    </select>
                </div>

                <div class="col">
                  <label for = "semester" class = "col-sm col-form-label"><b>Semester</b></label>  
                   <select class = "form-select" name = "semester" style="margin-top: 0px;">
                        <option disabled selected>Pilih Semester</option>
                        <option value = "1">Semester 1</option>
                        <option value = "2">Semester 2</option>
                    </select>
                </div>

                 <div class="col">
                  <label for = "jenis_nilai" class = "col-sm col-form-label"><b>Jenis Nilai</b></label>  
                  <select class = "form-select" name = "jenis_nilai" style="margin-top: 0px;">
                        <option disabled selected>Pilih</option>
                        <option value = "nilai_tugas1">Tugas 1</option>
                        <option value = "nilai_tugas2">Tugas 2</option>
                        <option value = "nilai_tugas3">Tugas 3</option>
                        <option value = "nilai_tugas4">Tugas 4</option>
                        <option value = "nilai_UTS">UTS</option>
                        <option value = "nilai_UAS">UAS</option>
                    </select>
                </div>

                 <div class="col">
                  <label for = "nilai" class = "col-sm col-form-label"><b>Nilai</b></label>  
                  <input type="number" name="nilai" class="form-control">
                </div>
  
              </div>
              <br>
              <button type="submit" name="simpan" class="btn text-light" style="float:right; background-color: #1C7947;">Simpan</button>
              <br> 
              <br>
                <p style="font-size:20px; font-weight: bolder;">
            <?php 
            error_reporting(0);
            if(!empty( $_SESSION['kelas'])){
                $sql = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas = tabel_kelas.id_kelas WHERE tabel_kelas.kelas = '" . $_SESSION['kelas'] . "'";
                $hasil = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR); 
                $namakelas = mysqli_fetch_assoc($hasil);
            }else {
                echo '<div class="alert alert-danger" role="alert">
                Silahkan pilih kelas terlebih dahulu 
                </div>';
            }
            
        ?>
              <?php
              if(isset($_POST['simpan'])) {
                    $semester = $_POST['semester']; 
                    $nis      = $_POST['nama_siswa'];
                    $tugas1   = $_POST['nilai']; 

                            switch ($_POST['jenis_nilai']) {
                                case 'nilai_tugas1':
                                    $query = "SELECT * FROM tabel_nilai  WHERE nis=$nis AND semester=$semester AND id_mapel='".$namauser['id_mapel']."' ";
                                    $results = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query- Error: ".mysqli_error($con), E_USER_ERROR);
                                    $rows = mysqli_num_rows($results);

                                    if ($rows === 0) { 
                                        $result = "INSERT INTO tabel_nilai (semester, id_mapel, id_guru, nis, id_kelas,nilai_tugas1) values
                                            ('$semester','".$namauser['id_mapel']."' , '". $namauser['id_guru']."' , '$nis' , '".$namakelas['id_kelas']."','$tugas1')";
                                         $hasil = mysqli_query($con, $result) or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($con), E_USER_ERROR);
                                        if ($hasil) {
                                                echo '<div class="alert alert-primary" role="alert">Nilai berhasil ditambahkan</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">Nilai gagal ditambahkan, mohon cek kembali</div>';
                                            }
                                    } else {
                                        $result = "UPDATE tabel_nilai SET nilai_tugas1 = $tugas1 WHERE nis=$nis AND semester=$semester AND id_mapel='".$namauser['id_mapel']."'  ";
                                        $hasil = mysqli_query($con, $result) or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($con), E_USER_ERROR);
                                        if ($hasil) {
                                                echo '<div class="alert alert-primary" role="alert">Nilai berhasil ditambahkan</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">Nilai gagal ditambahkan, mohon cek kembali</div>';
                                            }
                                     }   
              
                                    break;
                                case 'nilai_tugas2':

                                    $result = "UPDATE tabel_nilai SET nilai_tugas2 = $tugas1 WHERE nis=$nis AND semester=$semester AND id_mapel='".$namauser['id_mapel']."' ";
                                    $hasil = mysqli_query($con, $result) or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($con), E_USER_ERROR);
                                    if ($hasil) {
                                                echo '<div class="alert alert-primary" role="alert">Nilai berhasil ditambahkan</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">Nilai gagal ditambahkan, mohon cek kembali</div>';
                                            }
                                    break;
                                case 'nilai_tugas3':

                                    $result = "UPDATE tabel_nilai SET nilai_tugas3 = $tugas1 WHERE nis=$nis AND semester=$semester AND id_mapel='".$namauser['id_mapel']."' ";
                                    $hasil = mysqli_query($con, $result) or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($con), E_USER_ERROR);
                                    if ($hasil) {
                                                echo '<div class="alert alert-primary" role="alert">Nilai berhasil ditambahkan</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">Nilai gagal ditambahkan, mohon cek kembali</div>';
                                            }
                                    break;
                                case 'nilai_tugas4':

                                    $result = "UPDATE tabel_nilai SET nilai_tugas4 = $tugas1 WHERE nis=$nis AND semester=$semester AND id_mapel='".$namauser['id_mapel']."' ";
                                    $hasil = mysqli_query($con, $result) or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($con), E_USER_ERROR);
                                    if ($hasil) {
                                                echo '<div class="alert alert-primary" role="alert">Nilai berhasil ditambahkan</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">Nilai gagal ditambahkan, mohon cek kembali</div>';
                                            }
                                    break;
                                case 'nilai_UTS':

                                    $result = "UPDATE tabel_nilai SET nilai_uts = $tugas1 WHERE nis=$nis AND semester=$semester  AND id_mapel='".$namauser['id_mapel']."' ";
                                    $hasil = mysqli_query($con, $result) or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($con), E_USER_ERROR);
                                    if ($hasil) {
                                                echo '<div class="alert alert-primary" role="alert">Nilai berhasil ditambahkan</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">Nilai gagal ditambahkan, mohon cek kembali</div>';
                                            }
                                    break;
                                case 'nilai_UAS':

                                    $result = "UPDATE tabel_nilai SET nilai_uas = $tugas1 WHERE nis=$nis AND semester=$semester AND id_mapel='".$namauser['id_mapel']."' ";
                                    $hasil = mysqli_query($con, $result) or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($con), E_USER_ERROR);
                                    if ($hasil) {
                                                echo '<div class="alert alert-primary" role="alert">Nilai berhasil ditambahkan</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">Nilai gagal ditambahkan, mohon cek kembali</div>';
                                            }
                                    break;
                            }

                    }
                    ?>    
            </form>
        </div> 
     <!-- Form input nilai -->


    <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded">  
        <!--MENAMPILKAN NAMA KELAS-->
        <p style="font-size:20px; font-weight: bolder;">
            <?php 
            if(!empty( $_SESSION['kelas'])){
                $sql = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas = tabel_kelas.id_kelas WHERE tabel_kelas.kelas = '" . $_SESSION['kelas'] . "'";
                $hasil = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR); 
                $namakelas = mysqli_fetch_assoc($hasil);

                echo 'Kelas : ', $namakelas['kelas'];
            }
        ?></p>

    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">    
    <p>**Untuk melihat nilai, silahkan pilih semester terlebih dahulu</p>
    <!--Button input Nilai -->
        
      
        <span style="float: left;">
            <!--FILTER SEMESTER-->
            <select name="semester" id="semester">
                <option value="" disabled="" selected="">Pilih semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
            </select>
                <button type="submit" name="login" class="btn btn-secondary" style="width:100px">Pilih</button>
          </span>
    </form>
<br>
<br>
    <!-- TABEL NILAI -->
    <div class="containernilai">  

  
            <!-- QUERY UNTUK MENAMPILKAN DAFTAR NILAI-->
            <?php
            if(empty( $_SESSION['kelas'])){

                echo '';

            } else {

            ?>

            <table class="table table-bordered table-hover">
                    <thread>
                    <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th style="width: 8%;">Semester</th>
                    <th>Tugas 1</th>
                    <th>Tugas 2</th>
                    <th>Tugas 3</th>
                    <th>Tugas 4</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>
                    </tr>
                    </thread>
            <?php
            $kelas = $_SESSION['kelas'];
            $mapel  = $namauser['id_mapel'];
            if (isset($_GET['semester'])) {
                $semester = trim($_GET['semester']);
            
                //$lihat = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas = tabel_kelas.id_kelas WHERE tabel_kelas.kelas = '$kelas'";
                $sql = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='$semester' AND tabel_kelas.kelas = '" . $_SESSION['kelas'] . "' ORDER BY nama_siswa";

            } else {
                //$lihat = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas = tabel_kelas.id_kelas WHERE tabel_kelas.kelas = '$kelas'";
                $sql = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND tabel_kelas.kelas = ' " . $_SESSION['kelas'] . "' ORDER BY nama_siswa";

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
                    <td><?php echo $data["semester"]; ?></td>
                    <td><?php echo $data["nilai_tugas1"]; ?></td>
                    <td><?php echo $data["nilai_tugas2"]; ?></td>
                    <td><?php echo $data["nilai_tugas3"]; ?></td>
                    <td><?php echo $data["nilai_tugas4"]; ?></td>
                    <td><?php echo $data["nilai_uts"]; ?></td>
                    <td><?php echo $data["nilai_uas"]; ?></td>
                    <td><b><?php 

                       $tugas = ($data["nilai_tugas1"]) + ($data["nilai_tugas2"]) + ($data["nilai_tugas3"]) + ($data["nilai_tugas4"]);
                       $rata_tugas = $tugas/4;
                       $akhir = $rata_tugas*0.6 + ($data['nilai_uts']*0.2)+($data['nilai_uas']*0.2); 
                       echo round($akhir); 
                        $nis =  $data["nis"];
                        $semester = $data["semester"];
                        $input_rata = "UPDATE tabel_nilai SET rata_nilai = '$akhir' WHERE nis='$nis' AND semester='$semester' AND id_mapel='".$namauser['id_mapel']."'";
                        $hasil2 = mysqli_query($con, $input_rata) or trigger_error("Query Failed! SQL: $input_rata - Error: ".mysqli_error($con), E_USER_ERROR);  
                      ?> </td>   
                        </tr>
                        </tbody>
                        <?php
                       }
                    ?>
                    </table>
                    <?php
                }
        ?>
        </b>
    </div>
    </div>
    </div>

   <script type="text/javascript">
        $(document).ready(function () {
         
        window.setTimeout(function() {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
                $(this).remove(); 
            });
        }, 600);
         
        });
        </script>
    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>
</html>