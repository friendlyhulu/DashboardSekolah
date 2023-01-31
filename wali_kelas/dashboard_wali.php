<?php
//Membutuhkan koneksi ke database
require('../database/koneksi.php');
//Membuat sesi baru
session_start();

if($_SESSION['role'] == ""){
    header("Location:login.php?pesan=gagal");
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - WALI KELAS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>   
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

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
                <a href="../wali_kelas/dashboard_wali.php" class="nav__logo">
                    <i class='bx bx-layer nav__logo-icon'></i>
                    <span class="nav__logo-name">Akademik</span>
                </a>

                <div class="nav__list">
                    <a href="../wali_kelas/dashboard_wali.php" class="nav__link active">
                        <i class='bx bx-grid-alt nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <a href="../wali_kelas/tampil_siswa.php" class="nav__link">
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

    <!-- Test Sidebar -->
    


<!-- Content -->
    <div class="container-fluid">
        <br>
        
        <div class="row">
            <!--JUMLAH SISWA -->
            <div class="col-sm-6 mb-2 col-md-8" style="text-align: center;">
                <div class="content-box content-lighten shadow-lg p-3 mb-5 bg-white rounded" style="margin-left: -14px;">
                    <h3 style="float: left; text-align:left"><b>Informasi <br>Kelas</b></h3>
                    <br>
        
                <!-- QUERY UNTUK INFORMASI JUMLAH SISWA -->
                <?php 
                  //Jumlah siswa-siswi
                $query = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                $jumlah_siswa = mysqli_num_rows($hasil);  

                  //Jumlah Laki-laki
                $query2 = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE jenis_kelamin='Laki-Laki' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";;
                $hasil2 = mysqli_query($con, $query2) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                $jumlah_laki = mysqli_num_rows($hasil2);  

                //Jumlah perempuan
                $query3 = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE jenis_kelamin='Perempuan' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                $hasil3 = mysqli_query($con, $query3) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                $jumlah_perempuan = mysqli_num_rows($hasil3);  
                ?>
                <!-- QUERY UNTUK INFORMASI JUMLAH SISWA -->

                &ensp;  
                <span style="font-size:25px;"><img src="https://img.icons8.com/color/96/000000/classroom.png"/><b><?php echo $jumlah_siswa ?> Pelajar</b></span> 
                &ensp;&ensp;&ensp;  &ensp;&ensp;&ensp;   &ensp;&ensp;&ensp;   &ensp;&ensp;&ensp;   &ensp;&ensp;&ensp;  &ensp;&ensp;&ensp;   &ensp;&ensp;&ensp;             
                <span style="font-size:25px; padding-left: 50px;"><img src="https://img.icons8.com/color/96/000000/classmates-sitting.png" style="margin-left: -10px:"/><b><?php echo $jumlah_perempuan ?>(P) / <?php echo $jumlah_laki ?>(L)</b></span>

                <?php
                ?>
                </div>
            </div>

            <!-- EKSTRAKURIKULER -->
            <div class="col-sm-3 mb-2 col-md-4">
                <div class="content-box content-lighten shadow-lg p-3 mb-5 bg-white rounded">
                <span style="font-size: 18px"><b> Ekstrakurikuler </b>
                    <p style="font-size:15px">(*siswa)</p>
                </span>
                    
                    <!-- Menampilkan Chart -->
                    <div>
                    <div style="width: 370px; margin-bottom: -12px; margin-top: -60px; margin-left: 80px;">
                    <canvas id="myChart" ></canvas>
                    </div>
                     <div class="ceklis" style="margin-top:-40px";>
                     <input type="checkbox" id="persen" value="persen"> Persen(%)<br>
                        </div>
                        <!--SCRIPT UNTUK CHART EKSTRAKURIKULER-->
                        <script>
                        Chart.register(ChartDataLabels);
                        var ctx = document.getElementById("myChart").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ["Sepak Bola", "Badminton", "Padus","Basket"],
                                datasets: [{
                                    label: '',
                                    data: [
                                    //QUERY UNTUK MENGHITUNG EKSKUL SEPAK BOLA    
                                    <?php 
                                    $sql = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE ekskul='Sepak-Bola' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $sepak_bola = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    echo mysqli_num_rows($sepak_bola);
                                    ?>,

                                    //QUERY UNTUK MENGHITUNG EKSKUL BADMINTON  
                                    <?php 
                                    $sql = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE ekskul='Badminton' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";
                                    $badminton= mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    echo mysqli_num_rows($badminton);
                                    ?>,
                                    <?php
                                    $sql = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE ekskul='Padus' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";
                                    $padus= mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    echo mysqli_num_rows($padus);
                                    ?>,
                                    <?php
                                    $sql = "SELECT * FROM tabel_siswa JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE ekskul='Basket' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";
                                    $basket= mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    echo mysqli_num_rows($basket);
                                    ?>,
                                    ],
                                    backgroundColor: [
                                    'rgb(255, 166, 0)',
                                    'rgb(102, 81, 145)',
                                    'rgb(212,80,135)',
                                    'rgb(255,124,67)'
                                    ],
                                    hoverOffset: 4
                                }]
                            }, options: {
                                 plugins :{ 
                                    responsive:true,
                                    legend:{
                                     position:'right',
                                    },
                                    datalabels: {
                                        color: '#fff',
                                        anchor: 'center',
                                        align: 'start',
                                        offset: -10,
                                        font:{
                                            weight:'bold',
                                            size: '15'
                                        }, formatter: (value, ctx)=>{
                                              let sum = 0;
                                              let dataArr = ctx.chart.data.datasets[0].data;
                                              dataArr.map(data => {
                                                  sum += data;
                                              });
                                              let percentage = Math.round(value*100 / sum).toFixed(0)+"%";
                                              var checkbox = document.getElementById("persen");
                                              if(checkbox.checked == true){
                                                return percentage;
                                              }
                                               else if (value >0){
                                                value = value.toString();
                                                value = value.split(/(?=(?:...)*$)/);
                                                value = value.join(',');
                                                return value;
                                            }
                                              
                                        }
                                    }
                                }
                            }

                            
                        });
                    </script>
                   </div>
                    <!--SCRIPT UNTUK CHART EKSTRAKURIKULER-->
                    <br>

                    
            <hr  style="height: 1px; margin-top: -10px; ">           

            <!-- PERSENTASE NILAI DIBAWAH KKM -->
            <span style="font-size: 18px"><b> Jumlah Nilai Siswa < KKM </b>
                <p style="font-size:15px">(*siswa)</p>
                 <span style="float:right; margin-top:-60px"; >
                            <!--FILTER SEMESTER -->  

                    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">        
                        <select name="pilih_semester" id="semester" style="width:170px";>
                            <option value="" disabled="" selected="">Pilih semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                        <button type="submit" name="login" class="btn btn-secondary" style="width:60px">Pilih</button>
                        </span >
                            </form>
            </span>

            <!-- Menampilkan Chart -->
            <div style="width: 370px; margin-top: -10px; margin-left: 80px;";>
                <?php
                error_reporting(0);
                if($_GET['pilih_semester'] == 1)  {
                    ?>
                    <p style="font-size:14px; margin-left: -79px;">Semester 1</p>

                    <canvas id="myChart2"  style="margin-top:-40px;"></canvas>
                    </div>
                     <div class="ceklis" style="margin-top:-40px";>
                     <input type="checkbox" id="persen1" value="persen"> Persen(%)<br>
                        </div>
                     <script>
                        var ctx = document.getElementById("myChart2").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ["Matematika", "Fisika","Kimia"],
                                datasets: [{
                                    data: [
                                    <?php 
                                
                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '1' AND nama_pelajaran='Matematika' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $matematika = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count2 =  mysqli_num_rows($matematika);
                              
                                    echo $count2 ;

                                    ?>
                                    ,
                                    <?php 
                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '1' AND nama_pelajaran='Fisika' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $fisika = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count2=  mysqli_num_rows($fisika);
                                 
                                    echo $count2;

                                    ?>
                                     ,
                                     <?php 
                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '1' AND nama_pelajaran='Kimia' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $kimia = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count3=  mysqli_num_rows($kimia);
                              
                                    echo $count3;


                                    ?>
                                    ,
                                    ],
                                    backgroundColor: [
                                    'rgb(105,41,196)',
                                    'rgb(17,146,232)',
                                    'rgb(212,80,135)'
                                    ],
                                }],

                            }, 
                            options: {
                                legend: {
                                    position:'bottom'
                                },
                                responsive:true,
                                plugins :{
                                    legend:{
                                            position:'right',
                                    
                                    },
                                   datalabels: {
                                        color: '#fff',
                                        anchor: 'center',
                                        align: 'center',
                                        offset:-10,
                                        font:{
                                            weight:'bold',
                                            size: '14'
                                        }, formatter: (value, ctx)=>{
                                              let sum = 0;
                                              let dataArr = ctx.chart.data.datasets[0].data;
                                              dataArr.map(data => {
                                                  sum += data;
                                              });
                                              let percentage = Math.round(value*100 / sum).toFixed(0)+"%";
                                              var checkbox = document.getElementById("persen1");
                                              if(checkbox.checked == true){
                                                return percentage;
                                              }
                                               else if (value >0){
                                                value = value.toString();
                                                value = value.split(/(?=(?:...)*$)/);
                                                value = value.join(',');
                                                return value;
                                            }
                                              
                                        }
                                    }
                                }
                            }
                               
                        }); 
                    </script>
                    <?php 

                  } else if ($_GET['pilih_semester'] == 2)  {
                    ?>
                    <p style="font-size:14px; margin-left: -79px;">Semester 2</p>
                    <canvas id="myChart2"  style="margin-top:-40px;"></canvas>  
                    </div>
                     <div class="ceklis" style="margin-top:-40px";>
                     <input type="checkbox" id="persen2" value="persen"> Persen(%)<br>
                        </div>
                     <script>
                        var ctx = document.getElementById("myChart2").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ["Matematika", "Fisika","Kimia"],
                                datasets: [{
                                    data: [
                                    <?php 
                                
                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '2' AND nama_pelajaran='Matematika' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $matematika = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count2 =  mysqli_num_rows($matematika);
                                  
                                    echo $count2 ;

                                    ?>
                                    ,
                                    <?php 
                                  
                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '2' AND nama_pelajaran='Fisika' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $fisika = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count2=  mysqli_num_rows($fisika);
                                    echo $count2;

                                    ?>
                                     ,
                                     <?php 
                                

                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '2' AND nama_pelajaran='Kimia' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $kimia = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count3=  mysqli_num_rows($kimia);
                            
                                    echo $count3;


                                    ?>
                                    ,
                                    ],
                                    backgroundColor: [
                                    'rgb(105,41,196)',
                                    'rgb(17,146,232)',
                                    'rgb(212,80,135)'
                                    ],
                                }],

                            }, 
                            options: {
                                legend: {
                                    position:'bottom'
                                },
                                responsive:true,
                                plugins :{
                                    legend:{
                                            position:'right',
                                    
                                    },
                                   datalabels: {
                                        color: '#fff',
                                        anchor: 'center',
                                        align: 'start',
                                        offset:-40,
                                        font:{
                                            weight:'bold',
                                            size: '14'
                                        }, formatter: (value, ctx)=>{
                                              let sum = 0;
                                              let dataArr = ctx.chart.data.datasets[0].data;
                                              dataArr.map(data => {
                                                  sum += data;
                                              });
                                              let percentage = (value*100 / sum).toFixed(2)+"%";
                                              //return percentage;
                                              var checkbox = document.getElementById("persen2");
                                              if(checkbox.checked == true){
                                                return percentage;
                                              }
                                              else if(value >0 ){
                                                value = value.toString();
                                                value = value.split(/(?=(?:...)*$)/);
                                                value = value.join(',');
                                                return value;
                                            }else{
                                                value = "";
                                                return value;
                                            }
                                        }
                                    }
                                }
                            }
                               
                        }); 
                    </script>
                    <?php 
                    }  else {
                        ?>
                    <p style="font-size:14px; margin-left: -79px;">Semester 1</p>
                    <canvas id="myChart2"  style="margin-top:-40px;"></canvas>
                    </div>
                     <div class="ceklis" style="margin-top:-40px";>
                     <input type="checkbox" id="persen3" value="persen"> Persen(%)<br>
                        </div>
                     <script>
                        var ctx = document.getElementById("myChart2").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ["Matematika", "Fisika","Kimia"],
                                datasets: [{
                                    data: [
                                    <?php 

                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '1' AND nama_pelajaran='Matematika' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $matematika = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count2 =  mysqli_num_rows($matematika);
                                
                                    echo $count2 ;

                                    ?>
                                    ,
                                    <?php 
                                
                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '1' AND nama_pelajaran='Fisika' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $fisika = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count2=  mysqli_num_rows($fisika);
                            
                                    echo $count2;

                                    ?>
                                     ,
                                     <?php 

                                    $sql = "SELECT rata_nilai FROM tabel_nilai JOIN tabel_siswa ON tabel_nilai.nis=tabel_siswa.nis JOIN tabel_pelajaran ON tabel_nilai.id_mapel=tabel_pelajaran.id_mapel JOIN tabel_kelas ON tabel_siswa.id_kelas=tabel_kelas.id_kelas WHERE semester =  '1' AND nama_pelajaran='Kimia' AND rata_nilai<tabel_pelajaran.kkm AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'  ";
                                    $kimia = mysqli_query($con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);
                                    $count3=  mysqli_num_rows($kimia);
                             
                                    echo $count3;


                                    ?>
                                    ,
                                    ],
                                    backgroundColor: [
                                    'rgb(105,41,196)',
                                    'rgb(17,146,232)',
                                    'rgb(212,80,135)'
                                    ],
                                }],

                            }, 
                            options: {
                                legend: {
                                    position:'bottom'
                                },
                                responsive:true,
                                plugins :{
                                    legend:{
                                            position:'right',
                                    
                                    },
                                   datalabels: {
                                        color: '#fff',
                                        anchor: 'center',
                                        align: 'start',
                                        offset:0,
                                        font:{
                                            weight:'bold',
                                            size: '14'
                                        }, formatter: (value, ctx)=>{
                                              let sum = 0;
                                              let dataArr = ctx.chart.data.datasets[0].data;
                                              dataArr.map(data => {
                                                  sum += data;
                                              });
                                              let percentage = (value*100 / sum).toFixed(0)+"%";
                                              //return percentage;

                                              var checkbox = document.getElementById("persen3");
                                              if(checkbox.checked == true){
                                                return percentage;
                                              }
                                              else if(value >0){
                                                value = value.toString();
                                                value = value.split(/(?=(?:...)*$)/);
                                                value = value.join(',');
                                                //return value;
                                            }
                                            
                                        }
                                    }
                                }
                            }
                               
                        }); 
                    </script>
                 <?php
                     }
                
              ?>

                  
        </div>
        </div>
            </div>
    </div>
        <br>
    <div class="row" style="margin-top:-720px;">
    <div class="col-sm-6 mb-2 col-md-8" style="text-align: center;">
       <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded" style="margin-top:1px;">
        
        <!-- SCRIPT CHART Rata-rata Nilai Pelajaran -->
            <h3 style="text-align: left;"><b> Rata-rata Nilai Pelajaran </b></h3> 
            <canvas id="bar-chart" width="700" height="350"></canvas>
            <script type="text/javascript">
                // Bar chart
                new Chart(document.getElementById("bar-chart"), {
                    type: 'bar',
                    data: {
                    labels: ["Fisika", "Kimia", "Matematika", "Bahasa Indonesia", "Seni", "Pkn"],
                    datasets: [
                        {
                        label: "Semester 1",
                        backgroundColor: "#003f5c",
                        data: [
                        <?php
                         $query = "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Fisika' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;

                        ?>
                        ,
                         <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Kimia' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?>
                        ,
                        <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Matematika' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?> ,
                         <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Bahasa Indonesia' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?>, 
                        <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Seni' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?> , 
                        <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Pkn' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?>
                        ],hoverOffset: 4,
                          borderRadius : 7,
                          maxBarThickness : 90


                        }, {
                        label: "Semester 2",
                        backgroundColor: "#ff6361",
                        data: [
                        <?php 
                        $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Fisika' AND semester='2' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                        $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                        $row = mysqli_fetch_assoc($hasil);
                        $average = $row['average'];
                        echo $average;
                        ?>
                        ,
                        <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Kimia' AND semester='2' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?>
                        ,
                         <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Matematika' AND semester='2' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?> , 
                        <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Bahasa Indonesia' AND semester='2' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?> , 
                        <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Seni' AND semester='2' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?> , 
                        <?php 
                         $query =  "SELECT AVG(rata_nilai) AS average FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Pkn' AND semester='2' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "'";
                         $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR); 
                         $row = mysqli_fetch_assoc($hasil);
                         $average = $row['average'];
                         echo $average;
                        ?>
                        ],hoverOffset: 4,
                          borderRadius : 7,
                          maxBarThickness : 90  
                        } , 
                    ]
                    },
                    options: {
                      scales: {
                        y :{
                              beginAtZero:true,
                              max:100,
                              grid: {
                                display: true
                              }  
                        }, 
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                        
                         plugins :{
                                  responsive:true,
                                  legend:{
                                    padding: {
                                        bottom:300
                                    }
                                  },
                                 datalabels: {
                                        color: '#2f4b7c',
                                        anchor: 'end',
                                        align: 'start',
                                        offset: -25,
                                        font:{
                                            size: '14',
                                            weight:'bold'
                                        }, 
                                           formatter: function(value) {
                                            if(isNaN(value)){
                                                return " ";
                                            }
                                            return Math.round(value);
                                        },
                                        
                                    }
                                }
                            }
                });
                </script>
        </div>
    </div>
</div>

        <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded" style="margin-top:1px;">
        <h3><b>Peringkat Mata Pelajaran</b></h3>
        <p>*Silahkan pilih mata pelajaran yang akan dilihat</p>
        <p>**Kemudian pilih semester</p>

    <!--FORM UNTUK TABEL PERINGKAT -->    
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET">    
        <div id="filters">
        <!--FILTER MATA PELAJARAN -->   
        <select name="mapel" id="mapel">
            <option value="" disabled="" selected="">Pilih Mata Pelajaran</option>
            <option value="Fisika">Fisika</option>
            <option value="Kimia">Kimia</option>
            <option value="Matematika">Matematika</option>
            <option value="Bahasa Indonesia">Bahasa Indonesia</option>
            <option value="Seni">Seni</option>
            <option value="Pkn">PKn</option>
        </select>

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

            <!-- TABEL NILAI -->
                <div class="containernilai">
                <table class="table table-bordered table-hover">
                <br>
                    <thread>
                    <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Semester</th>
                    <th>Mata Pelajaran</th>
                    <th style="width: 20%;">KKM (Kriteria Ketuntasan Minimal)</th>
                    <th>Nilai Akhir</th>
                    </tr>
                    </thread>
                    <!-- QUERY UNTUK MENAMPILKAN DATA PERINGKAT -->
                    <?php
                    if(isset($_GET['mapel']) && isset($_GET['semester'])){
                        $mapel = trim($_GET['mapel']);
                        $semester = trim($_GET['semester']);   
                        $sql = "SELECT * FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='$mapel' AND semester='$semester' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ORDER BY rata_nilai desc";

                        } else {
                            $sql = "SELECT * FROM tabel_nilai JOIN tabel_kelas ON tabel_nilai.id_kelas = tabel_kelas.id_kelas JOIN tabel_siswa ON tabel_nilai.nis = tabel_siswa.nis JOIN tabel_pelajaran on tabel_nilai.id_mapel=tabel_pelajaran.id_mapel WHERE nama_pelajaran='Fisika' AND semester='1' AND tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ORDER BY rata_nilai desc ";
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
                            <td><?php echo $data["semester"]; ?></td>
                            <td><b><?php echo $data["nama_pelajaran"]; ?></b></td>
                            <td><?php echo $data["kkm"]; ?></td>
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