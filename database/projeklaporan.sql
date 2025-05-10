-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 10:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projeklaporan`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_user`
--

CREATE TABLE `all_user` (
  `id` int(25) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_type` varchar(10) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `all_user`
--

INSERT INTO `all_user` (`id`, `user_name`, `password`, `admin_type`, `no_hp`) VALUES
(1, 'user', 'user', 'user', NULL),
(2, 'admin', 'admin', 'admin', NULL),
(3, 'teknisi', 'teknisi', 'teknisi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `device` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `device`, `type`) VALUES
(1, 'CCTV Simpang 3 Loa Janan', 'CCTV'),
(2, 'Kec. Palaran', 'link'),
(3, 'Kel. Rapak Dalam', 'link'),
(4, 'Kel. Rawa Makmur', 'link'),
(5, 'CCTV Mahkota 2 (Palaran)', 'CCTV'),
(6, 'CCTV Fly Over arah Juanda', 'CCTV'),
(7, 'Kel. Gunung Panjang', 'link'),
(8, 'CCTV Fly Over arah Kadrie Oening', 'CCTV');

-- --------------------------------------------------------

--
-- Table structure for table `lapor_gangguan`
--

CREATE TABLE `lapor_gangguan` (
  `id_laporan` int(11) NOT NULL,
  `device` varchar(100) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `tanggal_gangguan` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `status` varchar(15) DEFAULT 'tidak_aktif',
  `image` varchar(150) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lapor_gangguan`
--

INSERT INTO `lapor_gangguan` (`id_laporan`, `device`, `keterangan`, `tanggal_gangguan`, `tanggal_selesai`, `status`, `image`, `aktif`) VALUES
(1, 'Kel. Rapak Dalam', 'FO putus', '2025-05-05 09:08:54', NULL, 'tidak_aktif', 'WhatsApp Image 2025-02-16 at 17.33.07_309ed243.jpg', 1),
(2, 'adawd', 'awdawd', '2025-05-09 09:41:59', '2025-05-09 10:10:41', 'aktif', 'Screenshot 2025-02-14 201637.png', 1),
(3, 'awd', 'da', '2025-05-09 10:06:31', '2025-05-09 10:10:56', 'aktif', 'WhatsApp Image 2025-02-16 at 17.33.07_309ed243.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `list_gangguan`
--

CREATE TABLE `list_gangguan` (
  `id` int(11) NOT NULL,
  `id_device` int(11) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'tidak_aktif',
  `tanggal_gangguan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list_gangguan`
--

INSERT INTO `list_gangguan` (`id`, `id_device`, `keterangan`, `status`, `tanggal_gangguan`) VALUES
(1, 2, '', 'tidak_aktif', '2025-05-09 10:00:53'),
(2, 1, '', 'tidak_aktif', '2025-05-09 10:00:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_user`
--
ALTER TABLE `all_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lapor_gangguan`
--
ALTER TABLE `lapor_gangguan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `list_gangguan`
--
ALTER TABLE `list_gangguan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_device` (`id_device`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_user`
--
ALTER TABLE `all_user`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lapor_gangguan`
--
ALTER TABLE `lapor_gangguan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `list_gangguan`
--
ALTER TABLE `list_gangguan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list_gangguan`
--
ALTER TABLE `list_gangguan`
  ADD CONSTRAINT `id_device` FOREIGN KEY (`id_device`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
