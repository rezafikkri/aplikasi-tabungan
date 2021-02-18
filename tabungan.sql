-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2020 at 10:17 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabungan`
--
CREATE DATABASE `tabungan`;
use `tabungan`;
-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(18) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `password` varchar(98) NOT NULL,
  `username` varchar(32) NOT NULL,
  `waktu` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `nama`, `password`, `username`, `waktu`) VALUES
('1234re43', 'Reza Sariful Fikri', '$argon2i$v=19$m=65536,t=4,p=1$Q2g3SjF4L2liYzFoL1luWg$MvZzrFDtuh+37+ES374IDSpORxSFx7lJy0aBlZttCj0', 'reza', 1582157318);

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `anggota_id` varchar(18) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `jml_tabungan` int(16) NOT NULL DEFAULT 0,
  `waktu` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`anggota_id`, `nama`, `jml_tabungan`, `waktu`) VALUES
('2710acb71f924710', 'Inka Al-qori&#39;ah Karin', 990500, 1582157713),
('5a75793502b5fb45', 'Puji Ashari', 145000, 1582157696),
('737dc9b6932d9041', 'Dian Pranata', 0, 1582157656),
('fb5949dcaf4517ea', 'Rina Veronika', 70000, 1582157684);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` varchar(18) NOT NULL,
  `admin_id` varchar(18) NOT NULL,
  `anggota_id` varchar(18) NOT NULL,
  `type` enum('add','get') NOT NULL,
  `jml_uang` int(16) NOT NULL,
  `waktu` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `admin_id`, `anggota_id`, `type`, `jml_uang`, `waktu`) VALUES
('0288dbb647d1d375', '1234re43', '2710acb71f924710', 'add', 100000, 1582159474),
('0bd18eeebe13e54b', '1234re43', '2710acb71f924710', 'add', 235000, 1582159507),
('1b219fc4e4d47662', '1234re43', '2710acb71f924710', 'add', 25000, 1582159470),
('4a3138a774971559', '1234re43', '2710acb71f924710', 'add', 250000, 1582159390),
('57da69cbb3262371', '1234re43', '2710acb71f924710', 'add', 40000, 1582159499),
('647c798e059ea1da', '1234re43', '5a75793502b5fb45', 'add', 100000, 1582159377),
('64a6832e74854ba5', '1234re43', '2710acb71f924710', 'add', 10000, 1582159466),
('861e7587f702e3b7', '1234re43', '2710acb71f924710', 'add', 150000, 1582159484),
('8c870632a225c2fc', '1234re43', 'fb5949dcaf4517ea', 'add', 70000, 1582159417),
('b95bbc786872423f', '1234re43', '2710acb71f924710', 'add', 100000, 1582158693),
('bf0ed638d0954f69', '1234re43', '5a75793502b5fb45', 'add', 10, 1582158966),
('d29b817707eb6397', '1234re43', '2710acb71f924710', 'add', 80500, 1582159520),
('d5ae3b420471098e', '1234re43', '5a75793502b5fb45', 'get', 10, 1582159370),
('da056444c4b92d59', '1234re43', '2710acb71f924710', 'get', 10000, 1582158390),
('ed68d1ec455372ec', '1234re43', '5a75793502b5fb45', 'add', 45000, 1582159362),
('f5ed195a4c791111', '1234re43', '2710acb71f924710', 'add', 10000, 1582158379);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`anggota_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `anggota_id` (`anggota_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`anggota_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
