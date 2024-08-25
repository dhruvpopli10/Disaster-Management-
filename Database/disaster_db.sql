-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2024 at 04:42 PM
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
-- Database: `disaster_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `disasterinformation`
--

CREATE TABLE `disasterinformation` (
  `DisasterID` int(11) NOT NULL,
  `DisasterType` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DateOccured` date DEFAULT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disasterinformation`
--

INSERT INTO `disasterinformation` (`DisasterID`, `DisasterType`, `Description`, `DateOccured`, `Location`) VALUES
(1, 'flood', 'hi', '2024-08-21', 'rajouri '),
(2, 'earthquake', 'major quake', '2024-08-21', 'subash nagar');

-- --------------------------------------------------------

--
-- Table structure for table `publicmessage`
--

CREATE TABLE `publicmessage` (
  `messageId` int(11) NOT NULL,
  `Institute` int(11) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `DatePosted` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publicmessage`
--

INSERT INTO `publicmessage` (`messageId`, `Institute`, `Title`, `Message`, `DatePosted`) VALUES
(1, 2, 'huge volcanic eruption', 'critical situation', '2024-08-23');

-- --------------------------------------------------------

--
-- Table structure for table `reliefinformation`
--

CREATE TABLE `reliefinformation` (
  `ReliefID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_granted` date DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reliefinformation`
--

INSERT INTO `reliefinformation` (`ReliefID`, `Title`, `description`, `date_granted`, `Amount`) VALUES
(2, 'ngos', 'hi', '2024-08-22', 500000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `usertype` enum('General User','Rehabilitation Institutes') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `contact_info`, `address`, `usertype`, `created_at`, `user_type`) VALUES
(2, 'boy', 'boy@gmail.com', '$2y$10$eu5y9NVAJOlqKB.RaVdIbO8uoEzvzMrMd6S78SZta/66ze.EXVSYW', '8989', 'punjabi bagh', 'Rehabilitation Institutes', '2024-08-22 16:56:32', 'Rehabilitation Institute'),
(3, 'his', 'his@gmail.com', '123', '8989', 'subhash nagar', 'General User', '2024-08-22 17:19:42', 'Rehabilitation Institute'),
(5, 'her', 'her@gmail.com', '$2y$10$0uVnuGuN4QZalOhY/RPOw.UFWmUHHT2zwLBY7.0xEZukuhtxzROV2', '8989', 'paschim vihar', 'General User', '2024-08-23 07:05:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disasterinformation`
--
ALTER TABLE `disasterinformation`
  ADD PRIMARY KEY (`DisasterID`);

--
-- Indexes for table `publicmessage`
--
ALTER TABLE `publicmessage`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `Institute` (`Institute`);

--
-- Indexes for table `reliefinformation`
--
ALTER TABLE `reliefinformation`
  ADD PRIMARY KEY (`ReliefID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `disasterinformation`
--
ALTER TABLE `disasterinformation`
  MODIFY `DisasterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `publicmessage`
--
ALTER TABLE `publicmessage`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reliefinformation`
--
ALTER TABLE `reliefinformation`
  MODIFY `ReliefID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `publicmessage`
--
ALTER TABLE `publicmessage`
  ADD CONSTRAINT `publicmessage_ibfk_1` FOREIGN KEY (`Institute`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
