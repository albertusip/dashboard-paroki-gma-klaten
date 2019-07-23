-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql307.epizy.com
-- Generation Time: May 01, 2019 at 03:02 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epiz_22626699_siuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE IF NOT EXISTS `wilayah` (
  `id_wilayah` varchar(2) NOT NULL,
  `nama_wilayah` varchar(50) NOT NULL,
  `wil_pengurus` varchar(50) NOT NULL,
  `wil_kontak` varchar(20) NOT NULL,
  PRIMARY KEY (`id_wilayah`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id_wilayah`, `nama_wilayah`, `wil_pengurus`, `wil_kontak`) VALUES
('01', 'WILAYAH SANTA MARIA ASSUMPTA KLATEN', '', ''),
('02', 'WILAYAH SANTO MATHEUS BLATERAN', '', ''),
('03', 'WILAYAH SANTA MARIA BARENG', '', ''),
('04', 'WILAYAH SANTO YUSUF PEKERJA JEBUGAN', '', ''),
('05', 'WILAYAH SANTO YOHANES MOJAYAN', '', ''),
('06', 'WILAYAH SANTO YOSAPHAT KLATEN', '', ''),
('07', 'WILAYAH SANTO GABRIEL TONGGALAN', '', ''),
('08', 'WILAYAH SANTO IGNATIUS GAYAMPRIT', '', ''),
('09', 'WILAYAH KRISTUS RAJA PADANGAN', '', ''),
('10', 'WILAYAH SANTO PETRUS-PAULUS BIRIN', '', ''),
('11', 'WILAYAH SANTO IGNATIUS ANTIOKHIA KETANDAN UTARA', '', ''),
('12', 'WILAYAH SANTO PAULUS KARANGANOM', '', ''),
('13', 'WILAYAH SANTO GABRIEL GERGUNUNG', '', ''),
('14', 'WILAYAH SANTO BONIFATIUSNGINGAS', '', ''),
('15', 'WILAYAH SANTO MIKAEL KETANDAN TENGGARA', '', ''),
('16', 'WILAYAH SANTO YUSUP TAMBONG', '', ''),
('17', 'WILAYAH SANTO PETRUS PULUHWATU', '', ''),
('18', 'WILAYAH SANTO KLEMENS KUNDEN', '', ''),
('19', 'WILAYAH SANTO VINCENTIUS SORAN', '', ''),
('20', 'WILAYAH SANTO ANTONIUS MANJUNG', '', ''),
('21', 'WILAYAH SANTA MARIA DE FATIMA JATINOM', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
