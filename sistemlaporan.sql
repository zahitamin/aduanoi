-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2016 at 04:09 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sistemlaporan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL,
  `idpengguna` varchar(20) NOT NULL,
  `katalaluan` varchar(30) NOT NULL,
  `level` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `idpengguna`, `katalaluan`, `level`) VALUES
(1, 'admin', 'admin', 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `aduan`
--

CREATE TABLE IF NOT EXISTS `aduan` (
  `aduan_id` int(11) NOT NULL,
  `jenis_aset` varchar(50) NOT NULL,
  `perihal_laporan` varchar(50) NOT NULL,
  `tarikh_laporan` varchar(50) NOT NULL,
  `no_bilik` varchar(50) NOT NULL,
  `nama_penggadu` varchar(50) NOT NULL,
  `no_matrik` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aduan`
--

INSERT INTO `aduan` (`aduan_id`, `jenis_aset`, `perihal_laporan`, `tarikh_laporan`, `no_bilik`, `nama_penggadu`, `no_matrik`, `status`) VALUES
(11, 'KERUSI', 'PATAH', '05/31/2016', '5-6', 'zahit amin', '112233', 'Diproses'),
(12, 'ALMARI', 'pecah', '05/24/2016', '404', 'zahit amin', '112233', 'Selesai'),
(13, 'TANDAS', 'jamban pecah', '05/30/2016', '14', 'pokka johari', '2130987', 'Diproses'),
(14, 'TILAM', 'koyak', '10/14/2015', '5-6', 'wan muhamad hafiz wan ahmad sayutti', '2130199', 'Diproses');

-- --------------------------------------------------------

--
-- Table structure for table `pelajar`
--

CREATE TABLE IF NOT EXISTS `pelajar` (
  `StudentID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `NoMatrik` int(7) NOT NULL,
  `NoIC` int(12) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `VerifyPassword` varchar(20) NOT NULL,
  `UserName` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelajar`
--

INSERT INTO `pelajar` (`StudentID`, `FirstName`, `LastName`, `NoMatrik`, `NoIC`, `Email`, `Password`, `VerifyPassword`, `UserName`) VALUES
(1, 'wan muhamad hafiz', 'wan ahmad sayutti', 2130199, 2147483647, 'apih@yahoo.com', '12345', '12345', 'apih'),
(2, 'zahit', 'amin', 112233, 2147483647, 'zahitamin@gmail.com', '123', '123', 'zahit'),
(10, 'pokka', 'johari', 2130987, 375123, 'pokka@gmail.com', '123456', '123456', 'kaka');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `aduan`
--
ALTER TABLE `aduan`
  ADD PRIMARY KEY (`aduan_id`);

--
-- Indexes for table `pelajar`
--
ALTER TABLE `pelajar`
  ADD PRIMARY KEY (`StudentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `aduan`
--
ALTER TABLE `aduan`
  MODIFY `aduan_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `pelajar`
--
ALTER TABLE `pelajar`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
