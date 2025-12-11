-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2025 at 08:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengaduan_masyarakat`
--

-- --------------------------------------------------------

--
-- Table structure for table `masyarakat`
--

CREATE TABLE `masyarakat` (
  `nik` char(16) NOT NULL,
  `nama` varchar(35) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `telp` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `masyarakat`
--

INSERT INTO `masyarakat` (`nik`, `nama`, `username`, `password`, `telp`) VALUES
('3233444455556666', 'Dewi Lestari Ayu', 'Bu Ayu', '$2y$10$AWmMGzpACGbyEh4ktpfxUOm8x/WUn8Ad6xCM840qi6c8wud3ATjbS', '081233445123'),
('3323111122223333', 'Rudi Santoso', 'Pak Rudi', '$2y$10$wOQWtrzkMVe4gfG4lkxTW.c8b69TfbZoTNXv8YBlvpbcX0Skdc0NW', '085709876566'),
('3323123411112222', 'farrell ega maulana', 'farrell', '$2y$10$DskHHD8G6Ob7bGD/BlUpsuf.bW/82xB8.J9AEC84LaNyV7LKIRuFG', '085704989439');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int NOT NULL,
  `tgl_pengaduan` date DEFAULT NULL,
  `nik` char(16) DEFAULT NULL,
  `isi_laporan` text,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('0','proses','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tingkat` enum('info','warning','urgent') DEFAULT 'info'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `tgl_pengaduan`, `nik`, `isi_laporan`, `foto`, `status`, `tingkat`) VALUES
(39, '2025-01-01', '3323123411112222', 'tolong perbaikin jalan area gapura, karna banyak bolong bolong, bahaya buat keselamatan warga.', '1761627216_pengaduan.jpeg', 'selesai', 'warning'),
(40, '2025-01-02', '3323123411112222', 'tolong umumin buat gotong royong ke warga, karna atap rumah pak somat roboh diterjang angin tadi sore', '1761627269_pengaduan.jpeg', 'selesai', 'urgent'),
(41, '2025-01-03', '3323123411112222', 'umumin hari minggu gotong royong jalan sekitar desa', '1761627322_pengaduan.jpeg', 'selesai', 'info'),
(42, '2025-02-01', '3323111122223333', 'Kebakaran Rumah di Jalan Melati No. 45, Api besar melanda rumah warga, merembet ke rumah sekitar.', '1761644710_pengaduan.jpg', 'selesai', 'urgent'),
(43, '2025-03-14', '3323111122223333', 'Air PDAM Tidak Mengalir Selama 2 Hari, Warga kesulitan air bersih, terutama di daerah atas.', '1761644943_pengaduan.jpeg', 'selesai', 'warning'),
(44, '2025-05-27', '3323111122223333', 'Sampah Menumpuk di TPS Dekat SDN 05, TPS penuh dan belum diangkut sejak akhir pekan.', '1761645057_pengaduan.jpg', 'proses', 'info'),
(45, '2025-02-17', '3233444455556666', 'Lampu Jalan Mati di Perumahan Griya Asri, Lampu penerangan jalan mati sejak 3 hari lalu.', '1761645219_pengaduan.jpeg', 'selesai', 'info'),
(46, '2025-03-23', '3233444455556666', 'Papan Nama Jalan Hilang di Blok D, Papan nama jalan hilang, warga baru sulit mencari alamat.', '1761645321_pengaduan.jpg', 'proses', 'info'),
(47, '2025-02-22', '3233444455556666', 'Longsor Kecil di Jalan Perkebunan Cikaret, Sebagian tanah longsor menutup akses jalan desa.', '1761645453_pengaduan.jpeg', 'selesai', 'warning'),
(48, '2025-05-22', '3323123411112222', 'frfr', '1761705363_pengaduan.jpg', 'selesai', 'urgent'),
(49, '2025-05-27', '3323123411112222', 'efwfw', '1761705381_pengaduan.jpg', 'proses', 'warning'),
(50, '1111-11-11', '3323111122223333', 'fefwe', '1761719028_pengaduan.jpg', '0', 'urgent');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int NOT NULL,
  `nama_petugas` varchar(35) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `telp` varchar(13) DEFAULT NULL,
  `level` enum('admin','petugas') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `telp`, `level`) VALUES
(7, 'gian1', 'gian', '$2y$10$mduEPGizihIZ7ZswGwGrqOrcSex.JKp12NojZCbMezoJZLQqLh1Ia', '08123452222', 'petugas'),
(8, 'pak maulana', 'maulana', '$2y$10$XC113/7NbvvjoPOMKiorU.wWr5eduETKHaOBMQDpjLLJwwptETzfi', '0893873311', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int NOT NULL,
  `id_pengaduan` int DEFAULT NULL,
  `tgl_tanggapan` date DEFAULT NULL,
  `tanggapan` text,
  `id_petugas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_pengaduan`, `tgl_tanggapan`, `tanggapan`, `id_petugas`) VALUES
(10, 40, '2025-10-29', 'siap sudah saya sampaikan ke semua warga', 8),
(11, 39, '2025-10-29', 'sudah saya kerahkan pengecor untuk segera memperbaikinya', 8),
(12, 41, '2025-10-29', 'sudah saya umumkan lewat mic masjid', 8),
(13, 42, '2025-10-29', 'siap saya sudah telponkan 2 pemadam dan ambulan untuk kesana', 7),
(14, 45, '2025-10-29', 'siap besok pagi langsung saya suruh pln perbaiki lampunya\r\n', 7),
(15, 47, '2025-10-29', 'siap, saya langsung kerahkan 2 alat berat dan para warga untuk membantu membersihkan jalanan agar aman', 7),
(16, 43, '2025-10-29', 'siap sudah saya kerahkan 3 orang pdam dan warga untuk membantu memperbaiki saluran nya\r\n', 7),
(17, 48, '2025-10-29', 'gerger', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `masyarakat`
--
ALTER TABLE `masyarakat`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`),
  ADD KEY `id_pengaduan` (`id_pengaduan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `masyarakat` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD CONSTRAINT `tanggapan_ibfk_1` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tanggapan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
