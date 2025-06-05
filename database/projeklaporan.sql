-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 11:28 AM
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
(8, 'CCTV Fly Over arah Kadrie Oening', 'CCTV'),
(9, 'Kel. Lempake', 'CCTV');

-- --------------------------------------------------------

--
-- Table structure for table `lapor_gangguan`
--

CREATE TABLE `lapor_gangguan` (
  `id_laporan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `device` varchar(100) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `tanggal_gangguan` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `status` enum('open','pending','closed','') DEFAULT 'open',
  `image` varchar(150) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_gangguan`
--

CREATE TABLE `list_gangguan` (
  `id` int(11) NOT NULL,
  `id_device` int(11) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status` enum('open','pending','closed','') DEFAULT 'open',
  `tanggal_gangguan` datetime DEFAULT NULL,
  `tiket` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(25) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('teknisi','admin','user','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `type`) VALUES
(1, 'user', 'user', 'user'),
(2, 'admin', 'admin', 'admin'),
(3, 'teknisi', 'teknisi', 'teknisi'),
(4, 'fachri', '123', 'user'),
(5, 'bagas', 'bagas', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lapor_gangguan`
--
ALTER TABLE `lapor_gangguan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `list_gangguan`
--
ALTER TABLE `list_gangguan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tiket` (`tiket`),
  ADD KEY `id_device` (`id_device`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lapor_gangguan`
--
ALTER TABLE `lapor_gangguan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_gangguan`
--
ALTER TABLE `list_gangguan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lapor_gangguan`
--
ALTER TABLE `lapor_gangguan`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `list_gangguan`
--
ALTER TABLE `list_gangguan`
  ADD CONSTRAINT `id_device` FOREIGN KEY (`id_device`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
