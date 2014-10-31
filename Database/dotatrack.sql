-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2014 at 03:49 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

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
-- Table structure for table `hero`
--

CREATE TABLE IF NOT EXISTS `hero` (
  `heroId` int(11) NOT NULL,
  `heroName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hero`
--

INSERT INTO `hero` (`heroId`, `heroName`) VALUES
(1, 'Anti-Mage'),
(2, 'Axe'),
(3, 'Bane'),
(4, 'Bloodseeker'),
(5, 'Crystal Maiden'),
(6, 'Drow Ranger'),
(7, 'Earthshaker'),
(8, 'Juggernaut'),
(9, 'Mirana'),
(10, 'Morphling'),
(11, 'Shadow Fiend'),
(12, 'Phantom Lancer'),
(13, 'Puck'),
(14, 'Pudge'),
(15, 'Razor'),
(16, 'Sand King'),
(17, 'Storm Spirit'),
(18, 'Sven'),
(19, 'Tiny'),
(20, 'Vengeful Spirit'),
(21, 'Windranger'),
(22, 'Zeus'),
(23, 'Kunkka'),
(25, 'Lina'),
(26, 'Lion'),
(27, 'Shadow Shaman'),
(28, 'Slardar'),
(29, 'Tidehunter'),
(30, 'Witch Doctor'),
(31, 'Lich'),
(32, 'Riki'),
(33, 'Enigma'),
(34, 'Tinker'),
(35, 'Sniper'),
(36, 'Necrophos'),
(37, 'Warlock'),
(38, 'Beastmaster'),
(39, 'Queen of Pain'),
(40, 'Venomancer'),
(41, 'Faceless Void'),
(42, 'Wraith King'),
(43, 'Death Prophet'),
(44, 'Phantom Assassin'),
(45, 'Pugna'),
(46, 'Templar Assassin'),
(47, 'Viper'),
(48, 'Luna'),
(49, 'Dragon Knight'),
(50, 'Dazzle'),
(51, 'Clockwerk'),
(52, 'Leshrac'),
(53, 'Nature''s Prophet'),
(54, 'Lifestealer'),
(55, 'Dark Seer'),
(56, 'Clinkz'),
(57, 'Omniknight'),
(58, 'Enchantress'),
(59, 'Huskar'),
(60, 'Night Stalker'),
(61, 'Broodmother'),
(62, 'Bounty Hunter'),
(63, 'Weaver'),
(64, 'Jakiro'),
(65, 'Batrider'),
(66, 'Chen'),
(67, 'Spectre'),
(68, 'Ancient Apparition'),
(69, 'Doom'),
(70, 'Ursa'),
(71, 'Spirit Breaker'),
(72, 'Gyrocopter'),
(73, 'Alchemist'),
(74, 'Invoker'),
(75, 'Silencer'),
(76, 'Outworld Devourer'),
(77, 'Lycan'),
(78, 'Brewmaster'),
(79, 'Shadow Demon'),
(80, 'Lone Druid'),
(81, 'Chaos Knight'),
(82, 'Meepo'),
(83, 'Treant Protector'),
(84, 'Ogre Magi'),
(85, 'Undying'),
(86, 'Rubick'),
(87, 'Disruptor'),
(88, 'Nyx Assassin'),
(89, 'Naga Siren'),
(90, 'Keeper of the Light'),
(91, 'Io'),
(92, 'Visage'),
(93, 'Slark'),
(94, 'Medusa'),
(95, 'Troll Warlord'),
(96, 'Centaur Warrunner'),
(97, 'Magnus'),
(98, 'Timbersaw'),
(99, 'Bristleback'),
(100, 'Tusk'),
(101, 'Skywrath Mage'),
(102, 'Abaddon'),
(103, 'Elder Titan'),
(104, 'Legion Commander'),
(105, 'Techies'),
(106, 'Ember Spirit'),
(107, 'Earth Spirit'),
(109, 'Terrorblade'),
(110, 'Phoenix');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `matchId` int(10) NOT NULL,
  `skillLevel` int(1) NOT NULL,
  `duration` int(1) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `gameMode` int(2) NOT NULL,
  `region` int(3) NOT NULL,
  `date` int(11) NOT NULL,
  `matchType` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`matchId`, `skillLevel`, `duration`, `result`, `gameMode`, `region`, `date`, `matchType`) VALUES
(378075206, 0, 2593, 1, 1, 0, 20131110, 0);

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
  `kills` int(11) DEFAULT NULL,
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
  `item5` int(11) DEFAULT NULL,
  `slot` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `performance`
--

INSERT INTO `performance` (`performanceId`, `matchId`, `playerId`, `level`, `hero`, `kills`, `deaths`, `assists`, `lastHits`, `denies`, `xpm`, `gpm`, `heroDamage`, `towerDamage`, `item0`, `item1`, `item2`, `item3`, `item4`, `item5`, `slot`) VALUES
(1, 378075206, 2147483647, 25, 39, 15, 2, 17, 89, 11, 751, 527, 21050, 829, 46, 96, 108, 63, 123, 36, 0),
(2, 378075206, 2147483647, 22, 9, 9, 4, 17, 135, 11, 612, 559, 16326, 4311, 212, 147, 149, 168, 46, 50, 0),
(3, 378075206, 2147483647, 17, 5, 7, 6, 6, 65, 1, 375, 363, 6701, 892, 48, 152, 108, 13, 69, 0, 0),
(4, 378075206, 2147483647, 4, 70, 0, 0, 1, 4, 0, 24, 185, 269, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 378075206, 83414088, 25, 56, 22, 3, 6, 118, 3, 750, 561, 25591, 2035, 0, 63, 141, 98, 116, 135, 0),
(6, 378075206, 2147483647, 15, 32, 7, 11, 3, 38, 1, 302, 221, 17306, 0, 71, 3, 44, 63, 46, 170, 0),
(7, 378075206, 2147483647, 14, 15, 2, 12, 5, 110, 9, 260, 283, 7460, 365, 212, 63, 125, 154, 0, 0, 0),
(8, 378075206, 85595353, 14, 102, 0, 11, 5, 60, 9, 241, 209, 2133, 339, 50, 46, 38, 166, 0, 0, 0),
(9, 378075206, 2147483647, 13, 35, 2, 12, 2, 56, 0, 216, 242, 6784, 626, 29, 36, 164, 212, 24, 170, 0),
(10, 378075206, 106977695, 17, 58, 3, 9, 2, 92, 0, 389, 261, 3452, 623, 121, 63, 40, 23, 0, 42, 0);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `playerId` int(11) NOT NULL,
  `profileName` varchar(30) DEFAULT NULL,
  `avatarUrl` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`playerId`, `profileName`, `avatarUrl`) VALUES
(83414088, 'classic™', 'fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb.jpg'),
(85595353, 'leyarotheconquerer', 'c0/c0646af67a3795fcdd68ab2c86db0df9315b1cb8.jpg'),
(2147483647, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hero`
--
ALTER TABLE `hero`
 ADD PRIMARY KEY (`heroId`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
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
