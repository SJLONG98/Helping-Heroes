-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2020 at 09:17 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpingheroes_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `keyrequest`
--

CREATE TABLE `keyrequest` (
  `userID` varchar(30) NOT NULL,
  `userType` tinyint(1) NOT NULL,
  `requestType` tinyint(1) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL,
  `volunteerID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` varchar(30) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(500) NOT NULL,
  `userType` tinyint(1) NOT NULL,
  `secQuestion` tinyint(1) NOT NULL,
  `secAnswer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `email`, `password`, `userType`, `secQuestion`, `secAnswer`) VALUES
('AdminTest', 'test@email.com', '$2y$10$6okqhBclGz117nRpeyn8luSw8Y3K5flsbRE81IcudFAvkHsmf5xxa', 1, 1, 'answer');

-- --------------------------------------------------------

--
-- Table structure for table `volunteerrequest`
--

CREATE TABLE `volunteerrequest` (
  `userID` varchar(30) NOT NULL,
  `userType` tinyint(1) NOT NULL,
  `offerType` tinyint(1) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL,
  `isWorkerID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `volunteerrequest`
--
ALTER TABLE `volunteerrequest`
  ADD PRIMARY KEY (`userID`,`userType`,`offerType`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
