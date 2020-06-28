-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2020 at 02:02 PM
-- Server version: 5.7.30
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpingh_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats` (
  `id` int(10) UNSIGNED NOT NULL,
  `jobID` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `userID` varchar(100) NOT NULL,
  `userType` tinyint(1) NOT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `jobType` tinyint(1) NOT NULL,
  `jobDescription` varchar(500) NOT NULL,
  `distance` tinyint(1) NOT NULL,
  `duration` tinyint(1) NOT NULL,
  `startDate` date NOT NULL,
  `isApproved` tinyint(1) DEFAULT NULL,
  `pairedUserID` varchar(30) DEFAULT NULL,
  `jobID` int(15) NOT NULL,
  `completed` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_history`
--

DROP TABLE IF EXISTS `jobs_history`;
CREATE TABLE `jobs_history` (
  `userID` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `userType` tinyint(1) NOT NULL,
  `jobTitle` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `jobType` tinyint(1) NOT NULL,
  `jobDescription` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `distance` tinyint(1) NOT NULL,
  `duration` tinyint(1) NOT NULL,
  `startDate` date NOT NULL,
  `isApproved` tinyint(1) DEFAULT NULL,
  `pairedUserID` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `jobID` int(15) NOT NULL DEFAULT '0',
  `completed` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `chatId` int(10) UNSIGNED NOT NULL,
  `userId` varchar(30) NOT NULL,
  `message` varchar(4000) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages_history`
--

DROP TABLE IF EXISTS `messages_history`;
CREATE TABLE `messages_history` (
  `id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `chatId` int(10) UNSIGNED NOT NULL,
  `userId` varchar(30) NOT NULL,
  `message` varchar(4000) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pwdReset`
--

DROP TABLE IF EXISTS `pwdReset`;
CREATE TABLE `pwdReset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userID` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(250) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(500) CHARACTER SET utf8 NOT NULL,
  `userType` tinyint(1) NOT NULL,
  `secQuestion` tinyint(1) NOT NULL,
  `secAnswer` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `address` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
  `postcode` varchar(12) CHARACTER SET utf8mb4 DEFAULT NULL,
  `phoneNumber` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `isVetted` tinyint(1) DEFAULT NULL,
  `vettingFileName` varchar(500) CHARACTER SET utf8mb4 DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT '0.0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pwdReset`
--
ALTER TABLE `pwdReset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jobID` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pwdReset`
--
ALTER TABLE `pwdReset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
