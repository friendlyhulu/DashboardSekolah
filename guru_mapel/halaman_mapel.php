<?php

//Membutuhkan koneksi ke database
require('../database/koneksi.php');


//Membuat sesi baru
session_start();
if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
}

//Pengecekan pilihan kelas
if (isset($_POST['kelas'])) 
    $_SESSION['kelas'] = $_POST['kelas'];
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
      <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <link rel="stylesheet" href="../css/dashboard.css ?v=<?php echo time(); ?>">
    
  


</head>

<body id="body-pd" class="body-pd">
    <header class="header body-pd" id="header">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>

        <div class="header_kelas">
            
        </div>    

        <!--  MENAMPILKAN NAMA USER LOGIN && MAPEL -->
        <div class="header__user">
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
                    <a href="../guru_mapel/halaman_mapel.php" class="nav__link active">
                        <i class='bx bx-grid-alt nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="../guru_mapel/halaman_nilai.php" class="nav__link">
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
    <br>

     <!--FORM UNTUK PILIH KELAS -->
     <div class="alert alert-success " role="alert" style="height:100px">
                        <form method="POST">
                        <label><b>Kelas</b></label>
                        <br>
                        <select name="kelas" id="kelas" >
                            <option disabled selected>Pilih Kelas</option>
                            <!-- QUERY UNTUK MEMILIH KELAS YANG AKAN DITAMPILKAN -->
                            <?php
                                $query = "SELECT * FROM  tabel_kelas";
                                $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                while ($data = mysqli_fetch_array($hasil)){
                                    ?>
                                    <option value="<?=$data['kelas']?>"><?=$data['kelas']?></option> 
                                <?php    
                                }
                            ?>
                        </select>
                        <button type="submit" name="simpan" class="btn" style="background-color:#032D23; color: white; width:100px;" >Pilih</button>
                    </form>
                    <!--FORM UNTUK PILIH KELAS -->
    </div>
    <!-- Content container -->        <!-- two box -->
        <div class="row">
            <div class="col-sm-6 mb-2 col-md-6">
                <div class="content-box content-lighten shadow-lg p-3 mb-5 bg-white rounded">

            <!-- SCRIPT UNTUK MENAMPILKAN CHART BART RATA-RATA -->
            <h4><b> Rata-rata Nilai</b></h3>
            <?php 
              if(empty( $_SESSION['kelas'])){

                echo '<div class="alert alert-danger" role="alert">
                Silahkan pilih kelas terlebih dahulu 
                </div>';

            } else {
                ?>
                 <canvas id="myChart" width="800" height="421"></canvas>
                        <script type="text/javascript">
                         Chart.register(ChartDataLabels);
                        var ctx = document.getElementById("myChart").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ["Semester 1", "Semester 2"],
                                datasets: [{
                                    data: [
                                    <?php
                                    $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      $row = mysqli_fetch_assoc($hasil);
                                        $average = $row['average'];
                                        echo $average;
                                    ?>,
                                    <?php 
                                    $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      $row = mysqli_fetch_assoc($hasil);
                                        $average = $row['average'];
                                        echo $average;

                                    ?>
                                    ],
                                    backgroundColor: [
                                    'rgb(255, 166, 0)',
                                    'rgb(102, 81, 145)'
                                    ],
                                    hoverOffset: 4,
                                    borderRadius : 7,
                                    maxBarThickness : 70
                                }]
                            },
                            options: { 
                                indexAxis: 'y', 
                                scales: {
                                    yAxes: [ {  
                                        ticks: {
                                            beginAtZero:true,
                                            maxBarThickness: 100
                                        }
                                    }]
                                },  plugins: {
                                    legend:{
                                        display:false,
                                    },
                                      datalabels: {
                                        color: '#2f4b7c',
                                        anchor: 'end',
                                        align: 'start',
                                        offset: -25,
                                        font: {
                                          weight: 'bold'
                                        },
                                        formatter: function(value) {
                                            if(isNaN(value)){
                                                return " ";
                                            }
                                            return Math.round(value);
                                        },
                                        padding: 1
                                      }
                                    },
                            }
                        });
                    </script>      
              <?php
            }

            ?> 
            

        </div>
            </div>
            <div class="col-sm-6 mb-2 col-md-6 ">
                <div class="content-box content-lighten shadow-lg p-3 mb-5 bg-white rounded">

                        <h4><b> Jumlah Nilai Siswa < KKM [<?php echo $namauser['kkm']  ?>]</b></h3> 
                        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">    
                        <div id="filters">
                            
                        <span style="float:right; padding-bottom: 20px;">
                            <!--FILTER SEMESTER -->  
                        <select name="pilih_semester" id="semester">
                            <option value="" disabled="" selected="">Pilih semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                        <button type="submit" name="login" class="btn btn-secondary" style="width:100px">Pilih</button>
                        </span >
                        </form>

                        <?php
                         error_reporting(0);
                         if($_GET['pilih_semester'] == 1) {
                            ?>
                            <p> Semester 1</p>
                            <canvas id="bar-chart" width="800" height="350"></canvas>
                            <script type="text/javascript">
                                
                            // Bar chart
                            new Chart(document.getElementById("bar-chart"), {
                                type: 'bar',
                                data: {
                                labels: ["Tugas 1", "Tugas 2","Tugas 3","Tugas 4", "UTS", "UAS",],
                                datasets: [
                                    {
                                    label: "Dibawah KKM",
                                    backgroundColor: "#003f5c",
                                    data: [
                                    //Tugas 1
                                    <?php
                                    $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas1 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 2
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas2 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 3
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas3 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 4
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas4 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //UTS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uts < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //UAS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uas < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>] ,  borderRadius : 7,
                                    }, {
                                    label: "Diatas KKM",
                                    backgroundColor: "#ff6361",
                                    data: [
                                    //Tugas 1
                                    <?php
                                    $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas1 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 2
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas2 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 3
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas3 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 4
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas4 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil)  ;
                                    ?>,
                                    //UTS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uts >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //UAS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uas >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>

                                    ] ,  borderRadius : 7,
                                    }
                                ]
                                },
                                options: {
                                    scales: {
                                        y :{  max : 6,
                                              beginAtZero:true,
                                              grid: {
                                                display: true,
                                              }, ticks: {
                                                precision: 0
                                              }, 
                                        }, 
                                        x: {
                                            grid: {
                                                display: false
                                            }
                                        }
                                    },
                                    responsive:true,
                                     plugins: { 
                                      datalabels: {
                                        
                                        color: '#2f4b7c',
                                        anchor: 'end',
                                        align: 'start',
                                        offset: -25,
                                        font:{
                                            size: '14',
                                            weight:'bold'
                                        },
                                        formatter: Math.round,
                                        padding: 6
                                      }
                                    },                               
                            }
                            });
                            </script>
                           <?php 
                         } else if ($_GET['pilih_semester'] == 2) {
                            ?>
                            <p> Semester 2</p>
                            <canvas id="bar-chart" width="800" height="350"></canvas>
                            <script type="text/javascript">
                            // Bar chart
                            new Chart(document.getElementById("bar-chart"), {
                                type: 'bar',
                                data: {
                                labels: ["Tugas 1", "Tugas 2","Tugas 3","Tugas 4", "UTS", "UAS",],
                                datasets: [
                                    {
                                    label: "Dibawah KKM",
                                    backgroundColor: "#003f5c",
                                    data: [
                                    //Tugas 1
                                    <?php
                                    $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas1 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 2
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas2 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 3
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas3 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 4
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas4 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //UTS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_uts < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //UAS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_uas < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>] ,  borderRadius : 7,
                                    }, {
                                    label: "Diatas KKM",
                                    backgroundColor: "#ff6361",
                                    data: [
                                    //Tugas 1
                                    <?php
                                    $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas1 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 2
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas2 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 3
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas3 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //Tugas 4
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_tugas4 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil)  ;
                                    ?>,
                                    //UTS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_uts >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>,
                                    //UAS
                                    <?php 
                                     $mapel  = $namauser['id_mapel'];
                                     $kelas = $_SESSION['kelas'];
                                      $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='2' AND nilai_uas >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                      $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                                      echo mysqli_num_rows($hasil);
                                    ?>

                                    ] ,  borderRadius : 7,
                                    }
                                ]
                                },
                                options: {
                                    scales: {
                                        y :{  max : 6,
                                              beginAtZero:true,
                                              grid: {
                                                display: true
                                              },
                                              ticks: {
                                                precision: 0
                                              },  
                                        }, 
                                        x: {
                                            grid: {
                                                display: false
                                            }
                                        }
                                    },
                                    plugins: {
                                      datalabels: {
                                        color: '#2f4b7c',
                                        anchor: 'end',
                                        align: 'start',
                                        offset: -25,
                                        font:{
                                          
                                            size: '14',
                                            weight:'bold'
                                        },
                                        formatter: Math.round,
                                        padding: 6
                                      }
                                    },
                                }
                            });
                            </script>
                            <?php 
                         } else {
                             if (empty($_SESSION['kelas'])) {
                                 echo '<div class="alert alert-danger" role="alert">
                                Silahkan pilih kelas terlebih dahulu 
                                </div>';
                             } else {
                                 ?>
                            <p> Semester 1</p>
                            <canvas id="bar-chart" width="800" height="350"></canvas>
                            <script type="text/javascript">
                                
                            // Bar chart
                            new Chart(document.getElementById("bar-chart"), {
                                type: 'bar',
                                data: {
                                labels: ["Tugas 1", "Tugas 2","Tugas 3","Tugas 4", "UTS", "UAS",],
                                datasets: [
                                    {
                                    label: "Dibawah KKM",
                                    backgroundColor: "#003f5c",
                                    data: [
                                    //Tugas 1
                                    <?php
                                    $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas1 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //Tugas 2
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas2 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //Tugas 3
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas3 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //Tugas 4
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas4 < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //UTS
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uts < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //UAS
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uas < tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>] ,  borderRadius : 7,
                                    },  {
                                    label: "Diatas KKM",
                                    backgroundColor: "#ff6361",
                                    data: [
                                    //Tugas 1
                                    <?php
                                    $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas1 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //Tugas 2
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas2 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //Tugas 3
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas3 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //Tugas 4
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_tugas4 >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil)  ; ?>,
                                    //UTS
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uts >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>,
                                    //UAS
                                    <?php
                                     $mapel  = $namauser['id_mapel'];
                                 $kelas = $_SESSION['kelas'];
                                 $query = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='1' AND nilai_uas >= tabel_pelajaran.kkm AND tabel_kelas.kelas = '".$kelas."'";
                                 $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
                                 echo mysqli_num_rows($hasil); ?>

                                    ] ,  borderRadius : 7,
                                    }
                                ]
                                },
                                options: {
                                     scales: {
                                        y :{  max : 6,  
                                              beginAtZero:true,
                                              grid: {
                                                display: true
                                              }, ticks: {
                                                 precision: 0
                                              }, 
                                        }, 
                                        x: {
                                            grid: {
                                                display: false
                                            }
                                        }
                                    },
                                    plugins: {
                                       
                                      datalabels: {
                                        color: '#2f4b7c',
                                        anchor: 'end',
                                        align: 'start',
                                        offset: -25,
                                        font:{
                                  
                                            size: '14',
                                            weight:'bold'
                                        },
                                        formatter: Math.round,
                                        padding: 6
                                      }
                                    },
                              }
                            });
                            </script>
                           <?php
                             }
                         }
                        ?>
            
                        
                </div>
            </div>
        </div>
  
        <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded">
        <h3><b>Peringkat Mata Pelajaran</b></h3>
        <p>**Untuk melihat peringkat, silahkan pilih semester terlebih dahulu</p>

    <!--FORM UNTUK TABEL PERINGKAT -->    
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">    
        <div id="filters">
            
        <span>
            <!--FILTER SEMESTER -->  
        <select name="semester" id="semester">
            <option value="" disabled="" selected="">Pilih semester</option>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
        </select>
        <span >

            <button type="submit" name="login" class="btn btn-secondary" style="width:100px">Pilih</button>
        </span>   
        </form>
    <br>
    <br>                    
            <!-- TABEL NILAI -->
                <div class="containernilai">
                <?php
            if(empty( $_SESSION['kelas'])){

                echo '<div class="alert alert-danger" role="alert">
                Silahkan pilih kelas terlebih dahulu 
                </div>';

            } else {

            ?>
            <table class="table table-bordered table-hover">
                    <thread>
                    <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th style="text-align:center;">Semester</th>
                    <th>Nilai Akhir </th>
                    </tr>
                    </thread>
            <?php
            $mapel  = $namauser['id_mapel'];
            if (isset($_GET['semester'])) {
                $semester = trim($_GET['semester']);

            $sql = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas AND semester='$semester' AND tabel_kelas.kelas = '" . $_SESSION['kelas'] . "' ORDER BY rata_nilai desc";
            } else {
                $sql = "SELECT * FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_siswa.id_kelas JOIN tabel_guru ON tabel_nilai.id_guru=tabel_guru.id_guru JOIN tabel_pelajaran ON  tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE tabel_nilai.id_mapel ='$mapel' AND tabel_siswa.id_kelas = tabel_kelas.id_kelas  AND semester='1' AND tabel_kelas.kelas = ' " . $_SESSION['kelas'] . "' ORDER BY rata_nilai desc ";
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
                    <td><?php echo $data["nama_siswa"]; ?></td>
                    <td style="text-align:center;"><?php echo $data["semester"]; ?></td>
                    <td><b><?php echo $data["rata_nilai"]; ?></b></td>
                        </tr>
                        </tbody>
                            <?php
                    }
                    ?>
                    </table>
                    <?php
                }
        ?>
                </div>
        </div>
    </div>


    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>
</html>