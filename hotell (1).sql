-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 09:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotell`
--

-- --------------------------------------------------------

--
-- Table structure for table `broneeringud`
--

CREATE TABLE `broneeringud` (
  `id` int(11) NOT NULL,
  `kylastaja_id` int(11) NOT NULL,
  `ruum_id` int(11) NOT NULL,
  `kood` varchar(10) DEFAULT NULL,
  `saabumise_kuupaev` date NOT NULL,
  `lahkumise_kuupaev` date NOT NULL,
  `staatus` enum('aktiivne','tühistatud','lõpetatud') DEFAULT 'aktiivne',
  `loodud` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `broneeringud`
--

INSERT INTO `broneeringud` (`id`, `kylastaja_id`, `ruum_id`, `kood`, `saabumise_kuupaev`, `lahkumise_kuupaev`, `staatus`, `loodud`) VALUES
(23, 27, 1, '2GUEN', '2025-06-12', '2025-06-23', 'aktiivne', '2025-06-11 07:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `kasutajad`
--

CREATE TABLE `kasutajad` (
  `id` int(11) NOT NULL,
  `kasutajanimi` varchar(50) NOT NULL,
  `parool` varchar(255) NOT NULL,
  `roll` varchar(20) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kasutajad`
--

INSERT INTO `kasutajad` (`id`, `kasutajanimi`, `parool`, `roll`, `created_at`) VALUES
(1, 'admin', '$2y$10$3UCc8ViU5n1ypnOyI8a5c.EmMS1YT0rmWr81KPAt5wRe6rX8x5He6', 'admin', '2025-06-09 12:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `kylastajad`
--

CREATE TABLE `kylastajad` (
  `id` int(11) NOT NULL,
  `eesnimi` varchar(50) NOT NULL,
  `perenimi` varchar(50) NOT NULL,
  `isikukood` varchar(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `loodud` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kylastajad`
--

INSERT INTO `kylastajad` (`id`, `eesnimi`, `perenimi`, `isikukood`, `email`, `telefon`, `loodud`) VALUES
(1, 'Mari', 'Tamm', '12345678901', 'mari.tamm@example.com', '55512345', '2025-06-09 10:07:10'),
(2, 'Jaan', 'Kask', '12345678901', 'jaan.kask@example.com', '55523456', '2025-06-09 10:07:10'),
(3, 'Liis', 'Vaher', '12345678901', 'liis.vaher@example.com', '55534567', '2025-06-09 10:07:10'),
(27, 'joosep', 'alasoo', '50000000000', 'lrampage0@redcross.org', '56821234', '2025-06-11 07:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `ruumid`
--

CREATE TABLE `ruumid` (
  `id` int(11) NOT NULL,
  `ruumi_nr` varchar(10) NOT NULL,
  `tyyp` varchar(50) NOT NULL,
  `hind` decimal(10,2) NOT NULL,
  `olek` enum('vaba','broneeritud','hoolduses') DEFAULT 'vaba',
  `kirjeldus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruumid`
--

INSERT INTO `ruumid` (`id`, `ruumi_nr`, `tyyp`, `hind`, `olek`, `kirjeldus`) VALUES
(1, '101', 'Üheinimese', 60.00, 'broneeritud', 'Vaatega aeda, sisaldab hommikusööki'),
(2, '102', 'Kaheinimese', 85.00, 'vaba', 'Kaheinimesevoodi ja rõduga'),
(3, '201', 'Sviit', 150.00, 'vaba', 'Privaatne rõdu ja vann'),
(4, '202', 'Kaheinimese', 80.00, 'vaba', 'Standardne tuba kahele');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `broneeringud`
--
ALTER TABLE `broneeringud`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kood` (`kood`),
  ADD KEY `kylastaja_id` (`kylastaja_id`),
  ADD KEY `ruum_id` (`ruum_id`);

--
-- Indexes for table `kasutajad`
--
ALTER TABLE `kasutajad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kasutajanimi` (`kasutajanimi`);

--
-- Indexes for table `kylastajad`
--
ALTER TABLE `kylastajad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ruumid`
--
ALTER TABLE `ruumid`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `broneeringud`
--
ALTER TABLE `broneeringud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kasutajad`
--
ALTER TABLE `kasutajad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kylastajad`
--
ALTER TABLE `kylastajad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ruumid`
--
ALTER TABLE `ruumid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `broneeringud`
--
ALTER TABLE `broneeringud`
  ADD CONSTRAINT `broneeringud_ibfk_1` FOREIGN KEY (`kylastaja_id`) REFERENCES `kylastajad` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `broneeringud_ibfk_2` FOREIGN KEY (`ruum_id`) REFERENCES `ruumid` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
