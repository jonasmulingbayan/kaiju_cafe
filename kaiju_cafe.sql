-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 08:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kaiju_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `reservation_ID` int(11) NOT NULL,
  `reservation_firstName` varchar(255) NOT NULL,
  `reservation_lastName` varchar(255) NOT NULL,
  `reservation_mobileNumber` varchar(255) NOT NULL,
  `reservation_email` varchar(255) NOT NULL,
  `reservation_occasion` varchar(255) NOT NULL,
  `reservation_request` varchar(255) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `reservation_pax` int(11) NOT NULL,
  `reservation_seating` varchar(255) NOT NULL,
  `reservation_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`reservation_ID`, `reservation_firstName`, `reservation_lastName`, `reservation_mobileNumber`, `reservation_email`, `reservation_occasion`, `reservation_request`, `reservation_date`, `reservation_time`, `reservation_pax`, `reservation_seating`, `reservation_status`) VALUES
(1, 'Jonas Isaiah', 'Mulingbayan', '+63 9994322222', 'jonasipm29@gmail.com', 'anniversary', 'Test', '2024-06-26', '18:00:00', 1, 'Indoor', 'FINISHED'),
(2, 'Jonas Isaiah', 'Mulingbayan', '+63 9994322222', 'jonasipm29@gmail.com', 'anniversary', '', '2024-06-26', '17:00:00', 1, 'Indoor', 'CANCELED'),
(3, 'Jonas Isaiah', 'Mulingbayan', '+63 9994322222', 'jonasipm29@gmail.com', 'anniversary', 'Testing', '2024-06-20', '08:00:00', 1, 'Alfresco', 'FINISHED'),
(4, 'Jonas Isaiah', 'Mulingbayan', '+63 9994322222', 'jonasipm29@gmail.com', 'birthday', 'Test', '2024-08-19', '08:00:00', 16, 'Indoor', 'PENDING'),
(5, 'Test', 'Testing', '+63 9223423323', 'testing@gmail.com', 'business', 'Testing', '2024-07-24', '16:00:00', 20, 'Alfresco', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_ID`, `username`, `user_password`, `firstName`, `lastName`, `email`, `role`) VALUES
(2, 'jonas29', '$2y$10$CpJZpok21ZbkDR3gjok/SeAtOTAto.kiYtxARr0xTW8QjDH37FBa.', 'Jonas', 'Mulingbayan', 'jonasmulingbayan@gmail.com', 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`reservation_ID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `reservation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
