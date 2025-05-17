-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 17, 2025 at 07:56 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easybank_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `pan_number` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `id_proof` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `account_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `account_number` (`account_number`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `fullname`, `dob`, `gender`, `email`, `phone`, `address`, `account_type`, `pan_number`, `photo`, `id_proof`, `signature`, `account_number`, `password`, `created_at`, `balance`) VALUES
(11, 'John Doe', '1992-01-24', 'Male', 'john@gmail.com', '9565451212', 'John Villa\r\n1st Street\r\nTrivandrum\r\nKerala', 'savings', 'AAAPA7825A', 'assets/uploads/Image/6822f09fad7ad_JohnDoe.jpg', 'assets/uploads/6822f5bac73a8.jpg', 'assets/uploads/Signature/6822f09fb0832_johnsign.png', 'ACC390491652384', '$2y$10$OV3QCcOTSgPayB2bH1ybBeVmWUbZfi1TU3jfW7l7ua0cl6sOKaRPu', '2025-05-13 07:11:27', 8000.00),
(12, 'Anamika', '1996-05-20', 'Female', 'anamika@gmail.com', '9995554444', 'Aami Bhavan\r\n2nd Street\r\nTrivandrum\r\nKerala', 'savings', 'AAAPA2995A', 'assets/uploads/Image/6822f67a572d3_amaya.jpg', 'assets/uploads/6822f6e628465.jpg', 'assets/uploads/Signature/6822f67a59515_sign.png', 'ACC529010116954', '$2y$10$HgvN./13quYZo9yLCfGAEOJDeSnRuOX/aa7bjgRop25TegdHZoCke', '2025-05-13 07:36:26', 10000.00),
(7, 'Amaya', '1995-05-20', 'Female', 'amaya@gmail.com', '9876543210', 'Amaya Nivas\r\n2nd Street\r\nTrivandrum\r\nKerala', 'savings', 'AAAPA1234A', 'assets/uploads/681c95bd99989.jpg', 'assets/uploads/681c964a0bc41.jpg', 'assets/uploads/Signature/681c5b50d2b12_sign.png', 'ACC351939078589', '$2y$10$J60ZzMzUbYMRiTyNVM7e0.P4juHtJ/qTMoqbD0D4.zO0mwJEnPYNq', '2025-05-08 07:20:49', 9000.00),
(10, 'Anu John', '2002-12-10', 'Female', 'anu@gmail.com', '9876543210', 'Anu Villa\r\n3rd Street\r\nKochi\r\nKerala', 'savings', 'AAAPA1224A', 'assets/uploads/Image/68220967286b2_anu.jpg', 'assets/uploads/68220a696a5f6.jpg', 'assets/uploads/Signature/682209672ae52_sign.png', 'ACC590357464006', '$2y$10$ZORIkgNojPbjht5MRn7lSOEV2cyngisBxqsqJjplKGx6G6dXMBOAm', '2025-05-12 14:44:55', 13000.00),
(15, 'Lina Park', '1996-05-20', 'Female', 'linapark@gmail.com', '9845634785', '123, Gandhi Nagar,\r\nNear City Mall, Sector 12,\r\nDelhi - 110001\r\nIndia', 'savings', 'AAAPA1824A', 'assets/uploads/Image/6825ee4c3a4e8_Lina Parkk.jpg', 'assets/uploads/Id/6825ee4c3a892_anamika_id.jpg', 'assets/uploads/Signature/6825ee4c3ab38_sign.png', 'ACC938246308860', '$2y$10$yB629EZoYBriWpoXdCm5g.3/v5ykqxoeSx47VYT.1d9/ItU6Enk/K', '2025-05-15 13:38:20', 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`, `status`) VALUES
(1, 'John', 'john@gmail.com', 'Loan', 'I am interested in learning more about the loan options available at your bank.', '2025-05-15 15:04:13', 'resolved'),
(2, 'Anamika', 'anamika@gmail.com', 'Education Loan', 'I would like to understand the eligibility criteria, loan amount limits, interest rates, repayment terms, and the documentation required', '2025-05-15 15:26:38', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` enum('deposit','withdraw') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `created_at`) VALUES
(18, 10, 'deposit', 2500.00, '2025-05-12 20:18:10'),
(17, 7, 'withdraw', 6000.00, '2025-05-12 19:20:56'),
(8, 7, 'deposit', 25000.00, '2025-05-08 13:13:09'),
(9, 7, 'withdraw', 10000.00, '2025-05-08 13:13:27'),
(24, 15, 'withdraw', 15000.00, '2025-05-15 19:10:31'),
(23, 15, 'deposit', 25000.00, '2025-05-15 19:09:53'),
(22, 10, 'withdraw', 4500.00, '2025-05-13 20:56:39'),
(21, 10, 'deposit', 15000.00, '2025-05-13 20:56:19'),
(20, 12, 'deposit', 10000.00, '2025-05-13 13:07:19'),
(19, 11, 'deposit', 8000.00, '2025-05-13 13:02:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(500) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(11, 'John Doe', 'john@gmail.com', '9565451212', '$2y$10$Ozq1NVPBx.NCZyd3LzVNm.5xdzKTc9lFhTweUhIHKQdLvjewke5mS', 'user', '2025-05-13 07:08:51'),
(8, 'admin', 'admin2025@gmail.com', '9362514253', '$2y$10$3AjqM9WZH2i7DtMc3sj1nevhDZ.RADM9PSAPBAVhkby/wbEamoQf6', 'admin', '2025-05-12 13:49:50'),
(7, 'Amaya', 'amaya@gmail.com', '9876543210', '$2y$10$ggvKeSQxaZUPdRk1ygTtCuOEbJiFPOD7lqdZjv2WVef.w925UPHke', 'user', '2025-05-12 11:39:03'),
(10, 'Anu John', 'anu@gmail.com', '9876543210', '$2y$10$nkqjDFEDq9euH5FRqkghD.6zejQsm6SOtBcemnDjav3dj7pYX9BeG', 'user', '2025-05-12 14:09:40'),
(12, 'Anamika', 'anamika@gmail.com', '9995554444', '$2y$10$iKlsQdZP3Rcgb6IzmdopleCy20laE98znMmD3dGmREmKB7PKZXPFS', 'user', '2025-05-13 07:34:27'),
(15, 'Lina Park', 'linapark@gmail.com', '9845634785', '$2y$10$McAmLZOTs2RuHqEuA/uUzOxA7Gjy9JjNCVaRGtPBnBq0lQ9SMKH2C', 'user', '2025-05-15 13:36:53');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
