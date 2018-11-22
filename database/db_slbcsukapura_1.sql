-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22 Nov 2018 pada 02.02
-- Versi Server: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_slbcsukapura`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_device`
--

CREATE TABLE `tb_device` (
  `id_device` varchar(15) NOT NULL,
  `nuptk` varchar(16) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_device`
--

INSERT INTO `tb_device` (`id_device`, `nuptk`, `tipe`, `nama`, `status`) VALUES
('105569', 'BKS', 'Android', 'New Device', 'tidak aktif'),
('105680', 'BKS', 'Android', 'New Device', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_geofencing`
--

CREATE TABLE `tb_geofencing` (
  `id_geofencing` int(11) NOT NULL,
  `id_user` varchar(16) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `jenis` enum('sekolah','orangtua') NOT NULL,
  `status` enum('0','1') NOT NULL,
  `bentuk` enum('rectangle','polygon') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_geofencing`
--

INSERT INTO `tb_geofencing` (`id_geofencing`, `id_user`, `nama`, `jenis`, `status`, `bentuk`) VALUES
(35, 'BKS', NULL, 'sekolah', '1', 'polygon'),
(36, 'BKS', NULL, 'sekolah', '1', 'polygon'),
(37, 'BKS', NULL, 'sekolah', '1', 'polygon'),
(38, 'BKS', NULL, 'sekolah', '1', 'polygon'),
(39, 'BKS', 'tempat_lain', 'sekolah', '0', 'rectangle'),
(40, 'BKS', 'sekolah', 'sekolah', '0', 'polygon');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
--

CREATE TABLE `tb_guru` (
  `nuptk` varchar(16) NOT NULL,
  `nip` varchar(18) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(25) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `kode_jabatan` varchar(3) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '0',
  `id_kelas` varchar(4) DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `smartphone` enum('ya','tidak') DEFAULT NULL,
  `no_hp` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_guru`
--

INSERT INTO `tb_guru` (`nuptk`, `nip`, `foto`, `nama`, `tempat_lahir`, `tgl_lahir`, `kode_jabatan`, `password`, `status`, `id_kelas`, `longitude`, `latitude`, `smartphone`, `no_hp`) VALUES
('1010', '1111', 'swafoto_1540682149.jpg', 'reyhan audian dwi putra', 'bandung', '0000-00-00', 'GKS', '1010', '0', 'S8', 107.654117, -6.930971, 'ya', NULL),
('1054740642200043', '196207221992031003', '372809-200_1540680394.png', 'Drs. Gunansyah Priyatna', 'Jakarta', '1962-07-22', 'KSK', '110', '0', 'S8', 107.654984, -6.930299, 'ya', NULL),
('111', '111', 'foto-default.jpg', 'bakiyadi', '111', '2018-05-09', 'GKS', '111', '1', 'S2', 107.6826437, -6.9527148, 'ya', NULL),
('112', '-', 'foto-default.jpg', 'Cucu Sulastini', 'Sukabumi', '1977-06-02', 'GKS', '112', '0', 'S1', 107.6158464, -6.912409599999999, 'tidak', '082129421010'),
('BKS', '-', 'foto-default.jpg', 'Puri Purnamasari,S.Pd', 'Bandung', '1989-01-22', 'BKS', 'BKS', '0', 'S4', 107.68257410000001, -6.952464099999999, 'tidak', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `kode_jabatan` varchar(3) NOT NULL,
  `nama_jabatan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`kode_jabatan`, `nama_jabatan`) VALUES
('BKP', 'Bagian Kepegawaian'),
('BKS', 'Bagian Kesiswaan'),
('GKS', 'Guru Kelas'),
('KSK', 'Kepala Sekolah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` varchar(4) NOT NULL,
  `kelas` varchar(3) DEFAULT NULL,
  `tingkatan` varchar(5) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `kelas`, `tingkatan`, `jam_masuk`, `jam_keluar`) VALUES
('S1', '1', 'SDLB', '03:00:00', '11:00:00'),
('S11', '11', 'SMALB', '07:00:00', '12:00:00'),
('S2', '2', 'SDLB', '07:00:00', '10:00:00'),
('S3', '3', 'SDLB', '07:00:00', '10:00:00'),
('S4', '4', 'SDLB', '07:00:00', '12:00:00'),
('S7A', '7A', 'SMPLB', '07:00:00', '11:00:00'),
('S8', '8', 'SMPLB', '12:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_koordinat`
--

CREATE TABLE `tb_koordinat` (
  `id_koordinat` int(11) NOT NULL,
  `id_geofencing` int(11) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_koordinat`
--

INSERT INTO `tb_koordinat` (`id_koordinat`, `id_geofencing`, `latitude`, `longitude`) VALUES
(125, 35, -6.930220678003682, 107.65330920104975),
(126, 35, -6.9303218572625225, 107.65318716053957),
(127, 35, -6.930604094027627, 107.65329042558665),
(128, 35, -6.930887661928057, 107.65350902562136),
(129, 35, -6.930755862784295, 107.65376517658228),
(130, 35, -6.930454987833151, 107.65386978273386),
(131, 35, -6.930144793545313, 107.65386508886809),
(132, 35, -6.930202039716794, 107.65361363177294),
(206, 36, -6.93006092123499, 107.6541460502624),
(207, 36, -6.930202705369905, 107.65399919931883),
(208, 36, -6.930371115578042, 107.654163484621),
(209, 36, -6.930569480093825, 107.65429893617625),
(210, 36, -6.9302286658406995, 107.65471736078257),
(211, 36, -6.93009020997998, 107.65451351289744),
(212, 37, -6.930035626408324, 107.6548451009869),
(213, 37, -6.930136140053669, 107.65529269461626),
(214, 37, -6.930440010645836, 107.65522563939089),
(215, 37, -6.930327182486065, 107.6547039497375),
(216, 38, -6.907865901801467, 107.59468922376266),
(217, 38, -6.9453557701666515, 107.59022602796188),
(218, 38, -6.917068236240201, 107.64962086438766),
(235, 40, -6.93036078830614, 107.65438107087698),
(236, 40, -6.930528532805136, 107.65430060460653),
(237, 40, -6.93060441720174, 107.65455809667196),
(238, 40, -6.930427353590659, 107.65456211998548),
(239, 39, -6.93062805751877, 107.65469053869242),
(240, 39, -6.93062805751877, 107.65547642593378),
(241, 39, -6.931064725366204, 107.65547642593378),
(242, 39, -6.931064725366204, 107.65469053869242);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id_laporan` int(11) NOT NULL,
  `nis` varchar(14) NOT NULL,
  `waktu_kabur` timestamp NULL DEFAULT NULL,
  `waktu_ketemu` timestamp NULL DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `longtitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_laporan`, `nis`, `waktu_kabur`, `waktu_ketemu`, `lat`, `longtitude`) VALUES
(5, '112', '2018-07-16 11:54:20', '2018-10-30 04:26:07', -6.930387, 107.654664),
(8, '112', '2018-07-16 08:59:14', '2018-07-30 06:46:23', -6.930792, 107.65448),
(9, '112', '2018-08-02 21:28:26', '2018-10-30 04:26:27', -6.930387, 107.654664),
(10, '112', '2018-08-02 22:19:41', NULL, NULL, NULL),
(11, '112', '2018-08-02 22:59:24', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_notifikasi`
--

CREATE TABLE `tb_notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `nis` varchar(16) DEFAULT NULL,
  `nuptk` varchar(16) DEFAULT NULL,
  `pesan_notif` varchar(150) DEFAULT NULL,
  `waktu` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_notifikasi`
--

INSERT INTO `tb_notifikasi` (`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES
(1, '112', '111', 'keluar sekolah', '2018-07-16 08:59:14', 1),
(5, '112', '111', 'keluar sekolah', '2018-07-16 11:54:20', 1),
(7, '112', '1010', 'keluar sekolah', '2018-08-02 21:28:26', 1),
(8, '112', '1010', 'keluar sekolah', '2018-08-02 21:35:25', 2),
(9, '112', '112', 'keluar sekolah', '2018-08-02 22:19:41', 1),
(10, '112', NULL, 'keluar sekolah', '2018-08-02 22:32:29', 0),
(11, '112', NULL, 'keluar sekolah', '2018-08-02 22:41:51', 0),
(12, '112', NULL, 'keluar sekolah', '2018-08-02 22:58:26', 0),
(13, '112', '112', 'keluar sekolah', '2018-08-02 22:59:24', 1),
(15, '112', '112', 'baterai lemah', '2018-11-01 03:00:00', 1),
(16, '112', NULL, 'keluar sekolah', '2018-11-20 15:12:40', 0),
(17, '112', NULL, 'baterai lemah', '2018-11-20 20:29:02', 0),
(18, '112', NULL, 'keluar sekolah', '2018-11-20 20:32:10', 0),
(19, '112', NULL, 'keluar sekolah', '2018-11-20 20:34:52', 0),
(20, '112', NULL, 'keluar sekolah', '2018-11-20 22:40:21', 0),
(21, '112', NULL, 'baterai lemah', '2018-11-20 22:41:01', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_orangtua`
--

CREATE TABLE `tb_orangtua` (
  `id_orangtua` varchar(4) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_telp` varchar(13) DEFAULT NULL,
  `password` varchar(15) NOT NULL,
  `status` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_orangtua`
--

INSERT INTO `tb_orangtua` (`id_orangtua`, `nama`, `foto`, `alamat`, `no_telp`, `password`, `status`) VALUES
('O101', 'reyhan audian', '84903_1540690256.jpg', 'saluyu', '085737953188', '101', '0'),
('O112', 'sansan', 'thumb-1920-411820_1525827139.jpg', 'sadari', '311', 'O112', '0'),
('O123', 'jaja', NULL, 'mlb', NULL, 'O123', '0'),
('O132', 'geje', 'foto-default.jpg', 'aklsjdas', '23213', '111', '0'),
('O321', 'jun', 'gge', 'hksa', '9709', 'O321', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pesan`
--

CREATE TABLE `tb_pesan` (
  `id_pesan` int(11) NOT NULL,
  `id_pengirim` varchar(16) NOT NULL,
  `id_penerima` varchar(16) NOT NULL,
  `isi_pesan` varchar(500) DEFAULT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pesan`
--

INSERT INTO `tb_pesan` (`id_pesan`, `id_pengirim`, `id_penerima`, `isi_pesan`, `waktu`, `status`) VALUES
(1, '112', 'O112', 'hai apa kabar', '2018-11-05 05:59:28', '1'),
(2, 'O112', '112', 'hi juga kenapa emang?', '2018-11-05 05:59:58', '1'),
(3, '112', '1010', 'pagi pak', '2018-11-05 06:04:07', '0'),
(4, '112', 'O112', 'tes kirim', '2018-11-05 06:57:25', '1'),
(5, '112', 'O112', 'hallo', '2018-11-05 08:47:25', '1'),
(6, '112', 'O112', 'hiya hiya', '2018-11-05 08:49:20', '0'),
(7, 'O112', '112', 'emang kenapa?', '2018-11-05 09:06:58', '1'),
(8, 'O112', '112', 'tes lagi', '2018-11-05 09:08:12', '1'),
(9, 'O112', '112', 'lagi lagi', '2018-11-05 09:08:48', '1'),
(10, '112', '111', 'hei baki', '2018-11-05 15:06:47', '0'),
(11, '112', '111', 'oiii baki', '2018-11-05 15:08:41', '0'),
(12, '112', 'O101', 'tes', '2018-11-22 05:07:32', '0'),
(13, '1010', '112', 'testes', '2018-11-22 05:27:16', '0'),
(14, '112', 'O112', 'wkwk', '2018-11-22 07:00:04', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` varchar(14) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(25) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `password` varchar(15) NOT NULL,
  `id_kelas` varchar(4) DEFAULT NULL,
  `id_orangtua` varchar(4) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `baterai` int(11) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT '0',
  `nuptk` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`nis`, `nama`, `alamat`, `tempat_lahir`, `tgl_lahir`, `password`, `id_kelas`, `id_orangtua`, `foto`, `lat`, `longitude`, `baterai`, `update_time`, `status`, `nuptk`) VALUES
('112', 'Asep', 'sekeloa', 'Garut', '2018-05-03', '112', 'S1', 'O321', 'foto-default.jpg', -6.929884, 107.65467, 10, NULL, '4', '112');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_status`
--

CREATE TABLE `tb_status` (
  `id_status` int(11) NOT NULL,
  `id_notifikasi` int(11) DEFAULT NULL,
  `id_user` varchar(16) DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_status`
--

INSERT INTO `tb_status` (`id_status`, `id_notifikasi`, `id_user`, `status`) VALUES
(67, 1, '111', 1),
(68, 5, '111', 1),
(70, 7, '111', 1),
(71, 8, '111', 1),
(72, 9, '111', 1),
(73, 10, '111', 1),
(74, 11, '111', 1),
(75, 12, '111', 0),
(76, 13, '111', 0),
(87, 1, 'BKS', 0),
(88, 5, 'BKS', 0),
(90, 7, 'BKS', 0),
(91, 8, 'BKS', 0),
(92, 9, 'BKS', 0),
(93, 10, 'BKS', 0),
(94, 11, 'BKS', 0),
(95, 12, 'BKS', 0),
(96, 13, 'BKS', 0),
(97, 1, '1010', 1),
(98, 5, '1010', 1),
(100, 7, '1010', 1),
(101, 8, '1010', 1),
(102, 9, '1010', 1),
(103, 10, '1010', 1),
(104, 11, '1010', 1),
(105, 12, '1010', 1),
(106, 13, '1010', 1),
(173, 1, '112', 1),
(174, 5, '112', 1),
(175, 7, '112', 1),
(176, 8, '112', 1),
(202, 9, '112', 1),
(203, 10, '112', 1),
(204, 11, '112', 1),
(205, 12, '112', 1),
(206, 13, '112', 1),
(207, 15, '112', 1),
(216, 19, '112', 1),
(228, 20, '112', 1),
(229, 21, '112', 1),
(230, 17, '112', 1),
(231, 16, '112', 1),
(232, 18, '112', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_device`
--
ALTER TABLE `tb_device`
  ADD PRIMARY KEY (`id_device`),
  ADD KEY `nuptk` (`nuptk`);

--
-- Indexes for table `tb_geofencing`
--
ALTER TABLE `tb_geofencing`
  ADD PRIMARY KEY (`id_geofencing`);

--
-- Indexes for table `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`nuptk`),
  ADD KEY `fk_id_kelas` (`id_kelas`),
  ADD KEY `fk_kode_jabatan` (`kode_jabatan`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`kode_jabatan`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tb_koordinat`
--
ALTER TABLE `tb_koordinat`
  ADD PRIMARY KEY (`id_koordinat`),
  ADD KEY `id_geofencing` (`id_geofencing`);

--
-- Indexes for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `fk_nis_kabur` (`nis`);

--
-- Indexes for table `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `fk_nis_notif` (`nis`),
  ADD KEY `nuptk` (`nuptk`);

--
-- Indexes for table `tb_orangtua`
--
ALTER TABLE `tb_orangtua`
  ADD PRIMARY KEY (`id_orangtua`);

--
-- Indexes for table `tb_pesan`
--
ALTER TABLE `tb_pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `fk_id_kelas_siswa` (`id_kelas`),
  ADD KEY `fk_id_orangtua` (`id_orangtua`),
  ADD KEY `fk_nuptk` (`nuptk`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `fk_notifikasi` (`id_notifikasi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_geofencing`
--
ALTER TABLE `tb_geofencing`
  MODIFY `id_geofencing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tb_koordinat`
--
ALTER TABLE `tb_koordinat`
  MODIFY `id_koordinat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_pesan`
--
ALTER TABLE `tb_pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_status`
--
ALTER TABLE `tb_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_device`
--
ALTER TABLE `tb_device`
  ADD CONSTRAINT `fk_id_device_nuptk` FOREIGN KEY (`nuptk`) REFERENCES `tb_guru` (`nuptk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD CONSTRAINT `fk_id_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kode_jabatan` FOREIGN KEY (`kode_jabatan`) REFERENCES `tb_jabatan` (`kode_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_koordinat`
--
ALTER TABLE `tb_koordinat`
  ADD CONSTRAINT `fk_id_geofencing` FOREIGN KEY (`id_geofencing`) REFERENCES `tb_geofencing` (`id_geofencing`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD CONSTRAINT `fk_nis_kabur` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  ADD CONSTRAINT `fk_nis_notif` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nuptk_notif` FOREIGN KEY (`nuptk`) REFERENCES `tb_guru` (`nuptk`);

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `fk_id_kelas_siswa` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_orangtua` FOREIGN KEY (`id_orangtua`) REFERENCES `tb_orangtua` (`id_orangtua`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nuptk` FOREIGN KEY (`nuptk`) REFERENCES `tb_guru` (`nuptk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_status`
--
ALTER TABLE `tb_status`
  ADD CONSTRAINT `fk_notifikasi` FOREIGN KEY (`id_notifikasi`) REFERENCES `tb_notifikasi` (`id_notifikasi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
