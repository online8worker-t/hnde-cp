-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2025 at 12:26 PM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `hnde_rh_users`
--

CREATE TABLE `hnde_rh_users` (
  `id` int(11) NOT NULL,
  `unique_key` varchar(255) NOT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `payment_receipt_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hnde_rh_users`
--

INSERT INTO `hnde_rh_users` (`id`, `unique_key`, `registration_number`, `full_name`, `course`, `email`, `whatsapp`, `payment_receipt_path`, `status`, `created_at`) VALUES
(16, '3bbb30ad46', 'COL/BSE/2020/F/056', 'K.R.Madhushankha', 'HNDBSE', 'ravindu@gdoop.us', '0765395434', 'uploads/3bbb30ad46.pdf', 'allowed', '2025-09-26 09:34:21'),
(17, 'a824870ac1', 'COL/CE/2020/F/033', 'A.M.Harsha', 'HNDCE', 'HARSHA@QQ.COM', '0753322991', 'uploads/a824870ac1.pdf', 'pending', '2025-09-26 10:05:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hnde_rh_users`
--
ALTER TABLE `hnde_rh_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_key` (`unique_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hnde_rh_users`
--
ALTER TABLE `hnde_rh_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
