-- phpMyAdmin SQL Dump
-- version 4.2.9.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 08, 2014 at 01:35 AM
-- Server version: 5.6.17
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dotatrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `matchId` int(10) NOT NULL,
  `skillLevel` int(1) NOT NULL,
  `duration` int(1) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `gameMode` int(2) NOT NULL,
  `region` int(3) NOT NULL,
  `date` date NOT NULL,
  `matchType` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `match`
--

INSERT INTO `match` (`matchId`, `skillLevel`, `duration`, `result`, `gameMode`, `region`, `date`, `matchType`) VALUES
(378075206, 0, 2593, 1, 1, 0, '2013-11-10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `performance`
--

CREATE TABLE IF NOT EXISTS `performance` (
`performanceId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  `playerId` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `hero` int(11) NOT NULL DEFAULT '0',
  `kill` int(11) DEFAULT NULL,
  `deaths` int(11) DEFAULT NULL,
  `assists` int(11) DEFAULT NULL,
  `lastHits` int(11) DEFAULT NULL,
  `denies` int(11) DEFAULT NULL,
  `xpm` int(11) DEFAULT NULL,
  `gpm` int(11) DEFAULT NULL,
  `heroDamage` int(11) DEFAULT NULL,
  `towerDamage` int(11) DEFAULT NULL,
  `item0` int(11) DEFAULT NULL,
  `item1` int(11) DEFAULT NULL,
  `item2` int(11) DEFAULT NULL,
  `item3` int(11) DEFAULT NULL,
  `item4` int(11) DEFAULT NULL,
  `item5` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `performance`
--

INSERT INTO `performance` (`performanceId`, `matchId`, `playerId`, `level`, `hero`, `kill`, `deaths`, `assists`, `lastHits`, `denies`, `xpm`, `gpm`, `heroDamage`, `towerDamage`, `item0`, `item1`, `item2`, `item3`, `item4`, `item5`) VALUES
(1, 378075206, 2147483647, 25, 39, 15, 2, 17, 89, 11, 751, 527, 21050, 829, 46, 96, 108, 63, 123, 36),
(2, 378075206, 2147483647, 22, 9, 9, 4, 17, 135, 11, 612, 559, 16326, 4311, 212, 147, 149, 168, 46, 50),
(3, 378075206, 2147483647, 17, 5, 7, 6, 6, 65, 1, 375, 363, 6701, 892, 48, 152, 108, 13, 69, 0),
(4, 378075206, 2147483647, 4, 70, 0, 0, 1, 4, 0, 24, 185, 269, 0, 0, 0, 0, 0, 0, 0),
(5, 378075206, 83414088, 25, 56, 22, 3, 6, 118, 3, 750, 561, 25591, 2035, 0, 63, 141, 98, 116, 135),
(6, 378075206, 2147483647, 15, 32, 7, 11, 3, 38, 1, 302, 221, 17306, 0, 71, 3, 44, 63, 46, 170),
(7, 378075206, 2147483647, 14, 15, 2, 12, 5, 110, 9, 260, 283, 7460, 365, 212, 63, 125, 154, 0, 0),
(8, 378075206, 85595353, 14, 102, 0, 11, 5, 60, 9, 241, 209, 2133, 339, 50, 46, 38, 166, 0, 0),
(9, 378075206, 2147483647, 13, 35, 2, 12, 2, 56, 0, 216, 242, 6784, 626, 29, 36, 164, 212, 24, 170),
(10, 378075206, 106977695, 17, 58, 3, 9, 2, 92, 0, 389, 261, 3452, 623, 121, 63, 40, 23, 0, 42);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `playerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`playerId`) VALUES
(83414088),
(85595353),
(2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match`
--
ALTER TABLE `match`
 ADD PRIMARY KEY (`matchId`);

--
-- Indexes for table `performance`
--
ALTER TABLE `performance`
 ADD PRIMARY KEY (`performanceId`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
 ADD PRIMARY KEY (`playerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `performance`
--
ALTER TABLE `performance`
MODIFY `performanceId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
