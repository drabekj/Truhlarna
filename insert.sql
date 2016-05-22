-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2016 at 12:06 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

use Truhlarna;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Truhlarna`
--

-- --------------------------------------------------------

--
-- Table structure for table `Zamestnanec`
--

CREATE TABLE IF NOT EXISTS `Zamestnanec` (
  `ID_Zam` int(11) NOT NULL AUTO_INCREMENT,
  `Jmeno` varchar(50) DEFAULT NULL,
  `Prijmeni` varchar(50) DEFAULT NULL,
  `Sazba` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Zam`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Zamestnanec`
--

INSERT INTO `Zamestnanec` (`ID_Zam`, `Jmeno`, `Prijmeni`, `Sazba`) VALUES
(1, 'Franta', 'Banan', 90),
(2, 'Pepa', 'Novak', 100),
(3, 'Marek', 'Ševčík', 50),
(4, 'Petr', 'Vávra', 45);

-- --------------------------------------------------------

--
-- Table structure for table `Login`
--

CREATE TABLE IF NOT EXISTS `Login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` int(11) NOT NULL,
  `ID_Zam` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_Login_Zamestnanec` (`ID_Zam`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Login`
--

INSERT INTO `Login` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`, `remember_token`, `ID_Zam`) VALUES
(1, 'Honza', '$2y$10$bsM8SwC.zzTwzo2bottyMemAIuoTA7L7Pmi4Xqd8qnuHwtP4jJcMa', 'admin', '2016-05-21 18:00:43', '2016-05-21 18:00:43', 0, NULL),
(3, 'Tester', '$2y$10$bsM8SwC.zzTwzo2bottyMemAIuoTA7L7Pmi4Xqd8qnuHwtP4jJcMa', 'admin', '2016-05-19 10:12:04', '2016-05-19 10:12:04', 0, NULL),
(4, 'Pavla', '$2y$10$XeCsj8exeWcS8BARwB0Jyuis3J0t5jBxWQGtlHP20lwQYedHajBhO', 'standard', '2016-05-20 18:03:31', '2016-05-20 18:03:31', 0, NULL),
(8, 'Pepa', '$2y$10$r28bI0NSut.URgqIaI2G4O8pEz8jXp0KGQoD6oI9wUoEpX.Om.9cu', 'standard', '2016-05-20 19:59:25', '2016-05-20 19:59:25', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Objednavka`
--

CREATE TABLE IF NOT EXISTS `Objednavka` (
  `id` int(11) NOT NULL,
  `Jmeno` varchar(50) DEFAULT NULL,
  `Od` date DEFAULT NULL,
  `Do` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Objednavka`
--

INSERT INTO `Objednavka` (`id`, `Jmeno`, `Od`, `Do`) VALUES
(0, NULL, NULL, NULL),
(8, NULL, NULL, NULL),
(9, NULL, NULL, NULL),
(11, NULL, NULL, NULL),
(13, NULL, NULL, NULL),
(14, NULL, NULL, NULL),
(17, NULL, NULL, NULL),
(20, 'Drevena zidle', '2015-05-01', '2016-12-31'),
(21, 'stul', '2016-05-01', '2016-05-31'),
(22, NULL, NULL, NULL),
(23, NULL, NULL, NULL),
(24, NULL, NULL, NULL),
(27, NULL, NULL, NULL),
(28, NULL, NULL, NULL),
(32, NULL, NULL, NULL),
(11111111, NULL, NULL, NULL),
(2147483647, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Pracovni_den`
--

CREATE TABLE IF NOT EXISTS `Pracovni_den` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Datum` date NOT NULL,
  `Hodiny` int(11) DEFAULT NULL,
  `ID_Zam` int(11) DEFAULT NULL,
  `ID_Obj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_Pracovni_den_Zamestnanec` (`ID_Zam`),
  KEY `IXFK_Pracovni_den_Objednavka` (`id`),
  KEY `FK_Pracovni_den_Objednavka` (`ID_Obj`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=115 ;

--
-- Dumping data for table `Pracovni_den`
--

INSERT INTO `Pracovni_den` (`id`, `Datum`, `Hodiny`, `ID_Zam`, `ID_Obj`) VALUES
(1, '2015-01-03', 4, 1, 21),
(22, '2015-01-01', 5, 1, 20),
(23, '2015-01-02', 5, 1, 20),
(24, '2015-01-07', 5, 2, 21),
(25, '2015-02-01', 5, 1, 21),
(26, '2016-05-11', 8, 1, 21),
(27, '2015-01-07', 9, 3, 20),
(28, '2015-01-26', 4, 1, 21),
(29, '2015-01-06', 3, 1, 20),
(30, '2015-01-09', 8, 1, 20),
(31, '2015-01-12', 6, 1, 21),
(39, '2015-01-17', 4, 1, 20),
(46, '2015-01-05', 5, 1, 21),
(47, '2015-01-06', 5, 1, 21),
(52, '2015-01-06', 2, 1, 23),
(53, '2015-01-08', 5, 1, 23),
(54, '2015-01-12', 5, 1, 23),
(55, '2015-01-15', 5, 1, 23),
(56, '2015-01-02', 3, 1, 22),
(57, '2015-01-05', 6, 1, 27),
(58, '2015-01-01', 3, 1, 27),
(59, '2015-01-04', 6, 1, 11),
(60, '2015-01-07', 2, 1, 28),
(61, '2015-01-04', 1, 1, 9),
(62, '2015-01-04', 1, 1, 14),
(63, '2016-05-13', 2, 1, 21),
(64, '2016-05-17', 1, 1, 21),
(65, '2016-05-23', 6, 1, 11),
(66, '2016-05-24', 8, 1, 11),
(67, '2016-05-16', 10, 1, 23),
(68, '2016-05-17', 6, 1, 23),
(69, '2016-05-04', 8, 1, 8),
(70, '2016-05-05', 2, 1, 8),
(71, '2016-05-07', 10, 1, 24),
(72, '2016-05-08', 2, 1, 22),
(73, '2016-05-09', 6, 1, 22),
(74, '2016-05-10', 4, 1, 22),
(75, '2016-05-02', 8, 1, 14),
(76, '2016-05-05', 2, 1, 14),
(77, '2016-05-06', 2, 1, 14),
(78, '2016-05-03', 8, 1, 17),
(79, '2016-05-05', 4, 1, 17),
(80, '2016-05-06', 6, 1, 17),
(81, '2016-05-12', 4, 1, 20),
(82, '2016-05-13', 6, 1, 20),
(83, '2016-05-17', 1, 1, 20),
(84, '2016-05-18', 8, 1, 28),
(85, '2016-05-19', 8, 1, 28),
(86, '2016-05-20', 8, 1, 28),
(87, '2016-05-23', 2, 1, 28),
(88, '2016-05-02', 8, 2, 28),
(89, '2016-05-03', 8, 2, 28),
(90, '2016-05-04', 2, 2, 22),
(91, '2016-05-06', 10, 2, 21),
(92, '2016-05-09', 4, 2, 21),
(93, '2016-05-11', 1, 2, 21),
(94, '2016-05-04', 8, 2, 17),
(95, '2016-05-05', 6, 2, 17),
(96, '2016-05-09', 2, 2, 17),
(97, '2016-05-09', 2, 2, 11),
(98, '2016-05-11', 7, 2, 11),
(99, '2016-05-12', 8, 2, 14),
(100, '2016-05-13', 8, 2, 14),
(101, '2016-05-16', 3, 2, 14),
(102, '2016-05-17', 4, 2, 13),
(103, '2016-05-16', 5, 2, 24),
(104, '2016-05-17', 4, 2, 24),
(105, '2016-05-04', 8, 3, 8),
(106, '2016-05-05', 8, 3, 8),
(107, '2016-05-06', 8, 3, 8),
(108, '2016-05-18', 10, 2, 8),
(109, '2016-05-01', 7, 4, 8),
(110, '2016-05-02', 7, 4, 8),
(111, '2016-05-01', 1, 4, 13),
(112, '2016-05-02', 1, 4, 13),
(113, '2014-03-01', 7, 1, 17),
(114, '2015-01-15', 4, 4, 24);

-- --------------------------------------------------------

--
-- Table structure for table `Absencni_den`
--

CREATE TABLE IF NOT EXISTS `Absencni_den` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Datum` date NOT NULL,
  `ID_Zam` int(11) DEFAULT NULL,
  `Hodiny` int(11) DEFAULT NULL,
  `Duvod` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IXFK_Absencni_den_Zamestnanec` (`ID_Zam`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `Absencni_den`
--

INSERT INTO `Absencni_den` (`id`, `Datum`, `ID_Zam`, `Hodiny`, `Duvod`) VALUES
(5, '2015-01-09', 1, 8, 'svatek'),
(24, '2016-05-26', 1, 8, 'dovolena'),
(25, '2016-05-27', 1, 8, 'dovolena'),
(26, '2016-05-28', 1, 8, 'nemoc'),
(27, '2016-05-01', 1, 8, 'dovolena'),
(28, '2016-05-02', 1, 8, 'nemoc'),
(29, '2016-05-03', 1, 8, 'svatek');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
