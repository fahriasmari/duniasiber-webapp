-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2020 at 08:29 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `duniasiber_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `akun_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` enum('ADMIN','PELANGGAN') NOT NULL,
  `foto_indeks` varchar(255) NOT NULL,
  `token_indeks` varchar(255) NOT NULL,
  `diaktivasi_pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`akun_id`, `nama`, `email`, `username`, `password`, `peran`, `foto_indeks`, `token_indeks`, `diaktivasi_pada`) VALUES
(115, 'admin', 'admin123@email.com', 'admin123', 'dbf0f310ca404c8a4a19e8fc96cb985c826fdf07', 'ADMIN', 'AKUN-c103b6bb580b6dc6', 'AKUN-4aafa8ecbb6c8f89', '2020-06-13 11:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `anak-komentar`
--

CREATE TABLE `anak-komentar` (
  `anak-komentar_id` int(11) NOT NULL,
  `akun_id` int(11) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `komentar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `foto_id` int(11) NOT NULL,
  `nilai` varchar(255) NOT NULL,
  `foto_indeks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`foto_id`, `nilai`, `foto_indeks`) VALUES
(126, '3a3ad26816c607e8.gif', 'AKUN-c103b6bb580b6dc6'),
(127, 'ed17cdde46fcf667.png', 'KRSS-c564eed92e726b41'),
(128, 'e851d1d980f4df72.png', 'KRSS-f9790ad745ccfd3c'),
(129, '2c0cf37f3402f20f.jpg', 'KRSS-dfbbd7362a718645'),
(130, 'cce10413f806495e.jpg', 'KRSS-4b6df707f4c4482d'),
(131, '8e2f59f4a1699f21.jpg', 'KRSS-e439d342c1e9d528');

-- --------------------------------------------------------

--
-- Table structure for table `instruktur`
--

CREATE TABLE `instruktur` (
  `instruktur_id` int(11) NOT NULL,
  `akun_id` int(11) NOT NULL,
  `profesi` varchar(255) NOT NULL,
  `tentang` text NOT NULL,
  `rekening_bank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instruktur`
--

INSERT INTO `instruktur` (`instruktur_id`, `akun_id`, `profesi`, `tentang`, `rekening_bank`) VALUES
(15, 115, 'admin', 'hai saya adalah admin DuniaSiber\r\nmiauuu :3....', '{\r\n                            \"nomor_rekening\" : \"0123456789\",\r\n                            \"nama_bank\"      : \"EBC\",\r\n                            \"atas_nama\"      : \"admin\"\r\n                           }');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `komentar_id` int(11) NOT NULL,
  `akun_id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `konten_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `konten_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` longtext NOT NULL,
  `kursus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `kursus_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto_indeks` varchar(255) NOT NULL,
  `peringkat` decimal(2,1) NOT NULL,
  `deskripsi` text NOT NULL,
  `instruktur_id` int(11) NOT NULL,
  `di_review` enum('YA','TIDAK') NOT NULL,
  `di_publikasikan` enum('YA','TIDAK') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`kursus_id`, `nama`, `foto_indeks`, `peringkat`, `deskripsi`, `instruktur_id`, `di_review`, `di_publikasikan`) VALUES
(17, 'test_0', 'KRSS-c564eed92e726b41', '0.0', 'deskripsi test_0', 15, 'TIDAK', 'TIDAK'),
(18, 'test_1', 'KRSS-f9790ad745ccfd3c', '0.0', 'deskripsi test_1', 15, 'TIDAK', 'TIDAK'),
(19, 'test_2', 'KRSS-dfbbd7362a718645', '0.0', 'deskripsi test_2', 15, 'TIDAK', 'TIDAK'),
(20, 'test_3', 'KRSS-4b6df707f4c4482d', '0.0', 'deskripsi test_3', 15, 'TIDAK', 'TIDAK'),
(21, 'test_4', 'KRSS-e439d342c1e9d528', '0.0', 'deskripsi test_4', 15, 'TIDAK', 'TIDAK');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `token_id` int(11) NOT NULL,
  `nilai` varchar(255) DEFAULT NULL,
  `tgl_kadaluwarsa` datetime DEFAULT NULL,
  `tujuan` enum('VERIFIKASI','RESETPASSWORD','UBAHEMAIL') DEFAULT NULL,
  `token_indeks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`token_id`, `nilai`, `tgl_kadaluwarsa`, `tujuan`, `token_indeks`) VALUES
(20, NULL, NULL, NULL, 'AKUN-4aafa8ecbb6c8f89');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `ulasan_id` int(11) NOT NULL,
  `akun_id` int(11) NOT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `nilai_bintang` decimal(2,1) NOT NULL,
  `kursus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`akun_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `foto_indeks` (`foto_indeks`),
  ADD KEY `token_indeks` (`token_indeks`);

--
-- Indexes for table `anak-komentar`
--
ALTER TABLE `anak-komentar`
  ADD PRIMARY KEY (`anak-komentar_id`),
  ADD KEY `komentar_id` (`komentar_id`),
  ADD KEY `akun_id` (`akun_id`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`foto_id`),
  ADD KEY `foto_indeks` (`foto_indeks`);

--
-- Indexes for table `instruktur`
--
ALTER TABLE `instruktur`
  ADD PRIMARY KEY (`instruktur_id`),
  ADD KEY `akun_id` (`akun_id`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`komentar_id`),
  ADD KEY `konten_id` (`konten_id`),
  ADD KEY `akun_id` (`akun_id`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`konten_id`),
  ADD KEY `kursus_id` (`kursus_id`) USING BTREE;

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`kursus_id`),
  ADD KEY `instruktur_id` (`instruktur_id`),
  ADD KEY `foto_indeks` (`foto_indeks`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `nilai` (`nilai`),
  ADD KEY `token_indeks` (`token_indeks`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`ulasan_id`),
  ADD KEY `kursus_id` (`kursus_id`),
  ADD KEY `akun_id` (`akun_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `akun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `anak-komentar`
--
ALTER TABLE `anak-komentar`
  MODIFY `anak-komentar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `foto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `instruktur`
--
ALTER TABLE `instruktur`
  MODIFY `instruktur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `komentar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `konten_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `kursus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `ulasan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `akun_ibfk_1` FOREIGN KEY (`foto_indeks`) REFERENCES `foto` (`foto_indeks`),
  ADD CONSTRAINT `akun_ibfk_2` FOREIGN KEY (`token_indeks`) REFERENCES `token` (`token_indeks`);

--
-- Constraints for table `anak-komentar`
--
ALTER TABLE `anak-komentar`
  ADD CONSTRAINT `anak-komentar_ibfk_1` FOREIGN KEY (`komentar_id`) REFERENCES `komentar` (`komentar_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `anak-komentar_ibfk_2` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`akun_id`) ON DELETE CASCADE;

--
-- Constraints for table `instruktur`
--
ALTER TABLE `instruktur`
  ADD CONSTRAINT `instruktur_ibfk_1` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`akun_id`);

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`konten_id`) REFERENCES `konten` (`konten_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`akun_id`) ON DELETE CASCADE;

--
-- Constraints for table `konten`
--
ALTER TABLE `konten`
  ADD CONSTRAINT `konten_ibfk_1` FOREIGN KEY (`kursus_id`) REFERENCES `kursus` (`kursus_id`) ON DELETE CASCADE;

--
-- Constraints for table `kursus`
--
ALTER TABLE `kursus`
  ADD CONSTRAINT `kursus_ibfk_1` FOREIGN KEY (`instruktur_id`) REFERENCES `instruktur` (`instruktur_id`),
  ADD CONSTRAINT `kursus_ibfk_2` FOREIGN KEY (`foto_indeks`) REFERENCES `foto` (`foto_indeks`);

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`kursus_id`) REFERENCES `kursus` (`kursus_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`akun_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `hapus_token_kadaluwarsa` ON SCHEDULE EVERY 30 MINUTE STARTS '2020-01-01 00:00:01' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `token`
SET
`nilai` = NULL,
`tgl_kadaluwarsa` = NULL,
`tujuan` = NULL
WHERE `tgl_kadaluwarsa` < NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
