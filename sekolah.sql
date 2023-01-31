-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Feb 2022 pada 05.42
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_guru`
--

CREATE TABLE `catatan_guru` (
  `id_catatan` int(10) NOT NULL,
  `id_guru` varchar(10) NOT NULL,
  `nama_siswa` varchar(20) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `catatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `catatan_guru`
--

INSERT INTO `catatan_guru` (`id_catatan`, `id_guru`, `nama_siswa`, `id_kelas`, `catatan`) VALUES
(2, 'G001', 'Renly', 1, 'Tugas 4 belum dikumpulkan'),
(21, 'G001', 'Alexandria', 1, 'Konsultasi tugas 3'),
(24, 'G001', 'Ayu', 1, 'Konsultasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_catatan`
--

CREATE TABLE `tabel_catatan` (
  `id_catatan` int(10) NOT NULL,
  `nama_siswa` varchar(20) NOT NULL,
  `catatan` varchar(60) NOT NULL,
  `id_kelas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_catatan`
--

INSERT INTO `tabel_catatan` (`id_catatan`, `nama_siswa`, `catatan`, `id_kelas`) VALUES
(4, 'Alexandria', 'Konsultasi terkait tugas ', 1),
(7, 'Ayu', 'Konsultasi 17 november 2021 terkait nilai UTS', 1),
(13, 'Ayu', 'Konsultasi terkait UAS', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_guru`
--

CREATE TABLE `tabel_guru` (
  `id_guru` varchar(10) NOT NULL,
  `nama_guru` varchar(30) NOT NULL,
  `id_mapel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_guru`
--

INSERT INTO `tabel_guru` (`id_guru`, `nama_guru`, `id_mapel`) VALUES
('G001', 'Junita', 'FSK01'),
('G002', 'Selamat', 'MTK01'),
('G003', 'Solidarman', 'KIM01'),
('G004', 'Robert', 'BIND01'),
('G005', 'Lestarina', 'Seni01'),
('G006', 'Hidayat', 'PKN01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_kelas`
--

CREATE TABLE `tabel_kelas` (
  `id_kelas` int(10) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `wali_kelas` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_kelas`
--

INSERT INTO `tabel_kelas` (`id_kelas`, `kelas`, `wali_kelas`) VALUES
(1, 'X IPA 1', 'Andi'),
(2, 'X IPA 2', 'Alfrida'),
(10, 'XI IPA 1', 'Junita');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_nilai`
--

CREATE TABLE `tabel_nilai` (
  `id_nilai` int(5) NOT NULL,
  `semester` int(5) NOT NULL,
  `id_mapel` varchar(10) NOT NULL,
  `id_guru` varchar(10) NOT NULL,
  `nis` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `nilai_tugas1` int(10) NOT NULL,
  `nilai_tugas2` int(10) NOT NULL,
  `nilai_tugas3` int(10) NOT NULL,
  `nilai_tugas4` int(10) NOT NULL,
  `nilai_uts` int(10) NOT NULL,
  `nilai_uas` int(10) NOT NULL,
  `rata_nilai` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_nilai`
--

INSERT INTO `tabel_nilai` (`id_nilai`, `semester`, `id_mapel`, `id_guru`, `nis`, `id_kelas`, `nilai_tugas1`, `nilai_tugas2`, `nilai_tugas3`, `nilai_tugas4`, `nilai_uts`, `nilai_uas`, `rata_nilai`) VALUES
(45, 1, 'FSK01', 'G001', 998512001, 1, 70, 70, 70, 70, 68, 66, 69),
(46, 1, 'MTK01', 'G002', 998512001, 1, 80, 77, 78, 88, 67, 90, 79),
(47, 1, 'BIND01', 'G004', 998512001, 1, 66, 78, 80, 76, 90, 76, 78),
(48, 1, 'Seni01', 'G005', 998512001, 1, 80, 78, 80, 78, 89, 80, 81),
(49, 1, 'PKN01', 'G006', 998512001, 1, 70, 79, 80, 80, 90, 80, 80),
(50, 1, 'KIM01', 'G003', 998512001, 1, 60, 67, 70, 60, 60, 80, 67),
(51, 1, 'FSK01', 'G001', 998512002, 1, 70, 92, 78, 80, 80, 80, 80),
(52, 1, 'FSK01', 'G001', 998512003, 1, 67, 60, 66, 80, 90, 68, 73),
(53, 1, 'FSK01', 'G001', 998512005, 1, 80, 88, 60, 60, 88, 87, 78),
(54, 1, 'FSK01', 'G001', 998512004, 1, 84, 83, 90, 60, 77, 80, 79),
(55, 2, 'FSK01', 'G001', 998512001, 1, 80, 80, 80, 80, 80, 80, 80),
(56, 2, 'FSK01', 'G001', 998512002, 1, 80, 80, 80, 80, 0, 0, 48),
(57, 1, 'MTK01', 'G002', 998512002, 1, 80, 78, 89, 98, 90, 67, 83),
(58, 1, 'MTK01', 'G002', 998512003, 1, 80, 0, 88, 0, 0, 0, 25),
(59, 1, 'MTK01', 'G002', 998512005, 1, 66, 0, 0, 0, 0, 0, 10),
(60, 1, 'MTK01', 'G002', 998512004, 1, 80, 0, 0, 0, 0, 0, 12),
(61, 2, 'MTK01', 'G002', 998512001, 1, 80, 80, 80, 80, 80, 80, 80),
(62, 2, 'MTK01', 'G002', 998512002, 1, 80, 80, 80, 80, 0, 0, 48),
(63, 1, 'KIM01', 'G003', 998512002, 1, 88, 89, 75, 79, 90, 99, 87),
(64, 1, 'KIM01', 'G003', 998512003, 1, 80, 86, 66, 70, 79, 68, 75),
(65, 1, 'KIM01', 'G003', 998512005, 1, 67, 98, 90, 80, 78, 88, 83),
(66, 1, 'KIM01', 'G003', 998512004, 1, 77, 82, 85, 77, 90, 78, 82),
(67, 2, 'KIM01', 'G003', 998512001, 1, 80, 80, 79, 80, 94, 80, 83),
(68, 2, 'KIM01', 'G003', 998512002, 1, 80, 80, 80, 80, 80, 80, 80),
(69, 1, 'BIND01', 'G004', 998512002, 1, 78, 71, 76, 65, 89, 90, 79),
(70, 1, 'PKN01', 'G006', 998512002, 1, 80, 68, 60, 73, 68, 83, 72),
(71, 1, 'PKN01', 'G006', 998512003, 1, 89, 79, 79, 75, 77, 79, 80),
(72, 1, 'PKN01', 'G006', 998512005, 1, 67, 80, 77, 77, 87, 87, 80),
(73, 1, 'PKN01', 'G006', 998512004, 1, 80, 66, 87, 88, 76, 88, 81),
(74, 1, 'BIND01', 'G004', 998512003, 1, 31, 90, 89, 87, 77, 73, 75),
(75, 1, 'BIND01', 'G004', 998512005, 1, 21, 75, 71, 87, 80, 90, 72),
(76, 1, 'BIND01', 'G004', 998512004, 1, 60, 70, 70, 70, 70, 70, 69),
(77, 2, 'PKN01', 'G006', 998512001, 1, 80, 80, 80, 80, 80, 80, 80),
(78, 2, 'PKN01', 'G006', 998512002, 1, 80, 80, 80, 80, 78, 90, 82),
(79, 1, 'Seni01', 'G005', 998512002, 1, 31, 73, 77, 87, 94, 92, 77),
(80, 1, 'Seni01', 'G005', 998512003, 1, 22, 71, 81, 84, 88, 100, 76),
(81, 1, 'Seni01', 'G005', 998512005, 1, 30, 79, 99, 86, 92, 87, 80),
(82, 2, 'BIND01', 'G004', 998512001, 1, 80, 78, 78, 78, 78, 78, 78),
(83, 2, 'BIND01', 'G004', 998512002, 1, 60, 78, 60, 78, 56, 78, 68),
(84, 1, 'Seni01', 'G005', 998512004, 1, 33, 88, 76, 76, 84, 82, 74),
(85, 2, 'Seni01', 'G005', 998512001, 1, 80, 80, 80, 80, 80, 80, 80),
(86, 2, 'Seni01', 'G005', 998512002, 1, 80, 80, 80, 80, 80, 80, 80),
(87, 2, 'FSK01', 'G001', 998512003, 1, 80, 87, 70, 70, 0, 0, 46),
(88, 2, 'FSK01', 'G001', 998512005, 1, 80, 90, 0, 0, 0, 0, 26),
(89, 2, 'FSK01', 'G001', 998512004, 1, 60, 98, 0, 0, 0, 0, 24),
(90, 1, 'FSK01', 'G001', 998512006, 1, 80, 0, 0, 0, 0, 0, 12),
(91, 1, 'FSK01', 'G001', 2147483647, 1, 70, 0, 0, 0, 0, 0, 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_pelajaran`
--

CREATE TABLE `tabel_pelajaran` (
  `id_mapel` varchar(10) NOT NULL,
  `nama_pelajaran` varchar(30) NOT NULL,
  `kkm` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_pelajaran`
--

INSERT INTO `tabel_pelajaran` (`id_mapel`, `nama_pelajaran`, `kkm`) VALUES
('BIND01', 'Bahasa Indonesia', 77),
('FSK01', 'Fisika', 70),
('KIM01', 'Kimia', 75),
('MTK01', 'Matematika', 70),
('PKN01', 'Pkn', 70),
('Seni01', 'Seni', 70);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_siswa`
--

CREATE TABLE `tabel_siswa` (
  `id_siswa` int(5) NOT NULL,
  `nis` int(10) NOT NULL,
  `nama_siswa` varchar(20) NOT NULL,
  `id_kelas` int(5) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan','','') NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(30) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `ekskul` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_siswa`
--

INSERT INTO `tabel_siswa` (`id_siswa`, `nis`, `nama_siswa`, `id_kelas`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `ekskul`) VALUES
(1, 998512001, 'Alexandria', 1, 'Perempuan', 'Medan, Sumatera Utara', '1998-08-16', 'Gunungsitoli, Nias', '0812311141232', 'Basket'),
(4, 998512002, 'Ayu', 1, 'Perempuan', 'Medan, Sumatera Utara', '1998-03-02', 'Gunungsitoli, Nias', '081234123122', 'Padus'),
(5, 998512003, 'Melissa', 1, 'Perempuan', 'Medan, Sumatera Utara', '1998-07-04', 'Gunungsitoli, Nias', '081231412312', 'Badminton'),
(6, 998512004, 'Surya', 1, 'Laki-laki', 'Medan, Sumatera Utara', '1998-04-06', 'Gunungsitoli, Nias', '081231412312', 'Padus'),
(7, 998512005, 'Renly', 1, 'Laki-laki', 'Medan, Sumatera Utara', '1998-02-17', 'Gunungsitoli, Nias', '081231412545', 'Sepak-Bola'),
(15, 2147483647, 'Rinto', 1, 'Laki-laki', 'Gunungsitoli, Nias', '1998-02-12', 'Gunungsitoli, Nias', '08123141231', 'Badminton');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `kode_user` int(12) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` enum('wali','mapel','admin','') NOT NULL,
  `nama_lengkap` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`kode_user`, `username`, `password`, `role`, `nama_lengkap`) VALUES
(1, 'andi12', '12345', 'wali', 'Andi'),
(2, 'junita12', '12345', 'mapel', 'Junita'),
(3, 'selamat12', '12345', 'mapel', 'Selamat'),
(4, 'solidarman12', '12345', 'mapel', 'Solidarman'),
(5, 'admin', 'admin', 'admin', 'admin'),
(7, 'alfrida12', '12345', 'wali', 'Alfrida'),
(14, 'robert12', '12345', 'mapel', 'Robert'),
(15, 'lestarina12', '12345', 'mapel', 'Lestarina'),
(16, 'hidayat12', '12345', 'mapel', 'Hidayat'),
(18, 'junita13', '12345', 'wali', 'Junita');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `catatan_guru`
--
ALTER TABLE `catatan_guru`
  ADD PRIMARY KEY (`id_catatan`);

--
-- Indeks untuk tabel `tabel_catatan`
--
ALTER TABLE `tabel_catatan`
  ADD PRIMARY KEY (`id_catatan`);

--
-- Indeks untuk tabel `tabel_kelas`
--
ALTER TABLE `tabel_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `tabel_nilai`
--
ALTER TABLE `tabel_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `tabel_pelajaran`
--
ALTER TABLE `tabel_pelajaran`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `tabel_siswa`
--
ALTER TABLE `tabel_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`kode_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `catatan_guru`
--
ALTER TABLE `catatan_guru`
  MODIFY `id_catatan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tabel_catatan`
--
ALTER TABLE `tabel_catatan`
  MODIFY `id_catatan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tabel_kelas`
--
ALTER TABLE `tabel_kelas`
  MODIFY `id_kelas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tabel_nilai`
--
ALTER TABLE `tabel_nilai`
  MODIFY `id_nilai` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `tabel_siswa`
--
ALTER TABLE `tabel_siswa`
  MODIFY `id_siswa` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `kode_user` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
