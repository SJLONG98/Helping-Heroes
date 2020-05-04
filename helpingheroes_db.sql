-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2020 at 09:13 PM
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `userID` varchar(100) NOT NULL,
  `userType` tinyint(1) NOT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `jobType` tinyint(1) NOT NULL,
  `jobDescription` varchar(500) NOT NULL,
  `distance` tinyint(1) NOT NULL,
  `duration` tinyint(1) NOT NULL,
  `startDate` date NOT NULL DEFAULT current_timestamp(),
  `isApproved` tinyint(1) DEFAULT NULL,
  `pairedUserID` varchar(30) DEFAULT NULL,
  `jobID` int(15) NOT NULL
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
  `secAnswer` varchar(500) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `postcode` varchar(12) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `isVetted` tinyint(1) DEFAULT NULL,
  `vettingFileName` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `email`, `password`, `userType`, `secQuestion`, `secAnswer`, `address`, `postcode`, `phoneNumber`, `dob`, `isVetted`, `vettingFileName`) VALUES
('Admin1', 'admin1@gmail.com', '$2y$10$M2IDIRujXQVIDpA7eezUKutyWmp8QovgFi.aOrOIhS3F4rX2rsaW6', 1, 2, 'Turquoise', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jobID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
