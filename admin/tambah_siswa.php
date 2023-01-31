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
    $query = "SELECT * FROM tabel_kelas WHERE tabel_kelas.wali_kelas = '" . $_SESSION['nama'] . "' ";
    $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);
    $kelas = mysqli_fetch_array($hasil);

//Menambahkan data ke tabel siswa
if(isset($_POST['submit'])){
    $nis            = $_POST["nis"];
    $nama_siswa     = $_POST["nama_siswa"];
    $jenis_kelamin  = $_POST["jenis_kelamin"];
    $tempat_lahir   = $_POST["tempat_lahir"];  
    $tanggal_lahir  = $_POST["tanggal_lahir"]; 
    $alamat         = $_POST["alamat"];
    $no_hp          = $_POST["no_hp"]; 
    $ekskul         = $_POST["ekskul"]; 

    $query = "INSERT into tabel_siswa (nis, nama_siswa, id_kelas,jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_hp, ekskul) values 
    ('$nis','$nama_siswa','".$kelas['id_kelas']."','$jenis_kelamin', '$tempat_lahir','$tanggal_lahir','$alamat', '$no_hp','$ekskul')";
    $hasil = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($con), E_USER_ERROR);

    //Notikasi ketika berhasil di tambahkan
    if ($hasil) {
        echo '<br><div class="alert alert-primary" role="alert">Data siswa berhasil ditambahkan - <a href="./tampil_siswa.php" class="alert-link">Lihat Data Siswa</a></div>';
    } else {
        echo '<br><div class="alert alert-danger" role="alert">Data siswa gagal ditambahkan, mohon cek kembali</div>';
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
    <header class="header" id="header">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>

          <div class="header__user" style="margin-top:0px">
            <a> Selamat datang, <?php echo $_SESSION['nama']; ?> &#128075;</a>
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
                    <a href="../admin/halaman_admin.php" class="nav__link ">
                        <i class='bx bx-user-plus bx-sm nav__icon'></i>
                        <span class="nav__name">User</span>
                    </a>

                    <a href="../admin/tambah_guru.php" class="nav__link">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Guru</span>
                    </a>

                    <a href="../admin/tambah_wali.php" class="nav__link ">
                       <i class='bx bx-user-circle nav__icon' ></i>
                        <span class="nav__name">Wali Kelas</span>
                    </a>

                    <a href="../admin/tambah_siswa.php" class="nav__link active">
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



<!-- Content --> 
    <!-- Identitas Menu--> 
    <br>
    <div class="card text-white bg-dark mb-3"> &ensp;
        <h4 style="padding-left: 15px;"><b>  Tambah Siswa</b></h4>
            <div class="card-header">Silahkan lengkapi form berikut untuk menambahkan identitas siswa/i</div>
        </div>
    
    <!-- Form tambah data siswa-->
    <div class="content-box mb-3 content-lighten shadow-lg p-3 mb-5 bg-white rounded" >
        
    <a href="../wali_kelas/tampil_siswa.php" class="btn text-light" style="background-color: #193498;"><i class='fas fa-angle-left'></i> Kembali</a>
    <br>
    <form action = "tambah_siswa.php" method = "post" id="formtambah">
        <div class = "form-group row"> 
        <label for = "nis" class = "col-sm-2 col-form-label">NIS</label>
        <div class =  "col-sm-8">
        <input type = "text" name = "nis" class = "form-control" placeholder = "Masukkan NIS" required />
        </div>
        </div>

        <br> 
        <div class = "form-group row">
        <label for = "nama" class = "col-sm-2 col-form-label">Nama</label>
        <div class = "col-sm-8">
        <input type = "text" name = "nama_siswa" class = "form-control" placeholder = "Masukkan Nama" required />
        </div>
        </div>
        <br>

        <div class = "form-group row">
        <label for = "jenis_kelamin" class = "col-sm-2 col-form-label">Jenis Kelamin</label>
        <div class = "col-sm-8">
        <select class = "form-select" name = "jenis_kelamin">
        <option disabled selected>Pilih</option>
        <option value = "Laki-laki">Laki-Laki</option>
        <option value = "Perempuan">Perempuan</option>
        </select>
        </div>
        </div>
        <br>

        <div class = "form-group row">
        <label for = "tempat_lahir" class = "col-sm-2 col-form-label">Tempat Lahir</label>
        <div class = "col-sm-8">
        <input type = "text" name = "tempat_lahir" class = "form-control" placeholder = "Masukkan Tempat Lahir" required />
        </div>
        </div>
        <br>

        <div class = "form-group row">
        <label for = "tanggal_lahir" class = "col-sm-2 col-form-label">Tanggal Lahir</label>
        <div class = "col-sm-8">
        <input type = "date" name = "tanggal_lahir" class = "form-control" placeholder = "Masukkan Tanggal Lahir" required />
        </div>
        </div>
        <br>


        <div class = "form-group row">
        <label for = "alamat" class = "col-sm-2 col-form-label">Alamat</label>
        <div class = "col-sm-8">
        <textarea name = "alamat" class = "form-control" rows ="3" placeholder = "Masukkan Alamat" required ></textarea>
        </div>
        </div>
        <br>

        <div class = "form-group row">
        <label for = "no_hp" class = "col-sm-2 col-form-label">No.Hp</label>
        <div class = "col-sm-8">
        <input  name = "no_hp" class = "form-control" placeholder = "Masukkan No.hp" required/>
        </div>
        </div>
        <br>

        <div class = "form-group row">
        <label for = "ekskul" class = "col-sm-2 col-form-label">Ekstrakurikuler</label>
        <div class = "col-sm-8">
        <select class = "form-select" name = "ekskul">
        <option disabled selected>Pilih</option>
        <option value = "Sepak-Bola">Sepak Bola</option>
        <option value = "Badminton">Badminton</option>
        <option value = "Padus">Paduan Suara</option>
        <option value = "Basket">Basket</option>
        <option value = "Tenis Meja">Tenis Meja</option>
        </select>
        </div>
        </div>

        <div class = "buttontambah">
        <button type = "submit" name = "submit" class="btn text-light" style="background-color: #1C7947;"><i class='fas fa-plus-square'></i> Tambah</button>
        </div>
    </form>
    </div>

    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>
</html>
