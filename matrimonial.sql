-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2023 at 09:16 PM
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
-- Database: `matrimonial`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `matchmaker_id` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `height` decimal(5,2) NOT NULL,
  `cnic` varchar(13) NOT NULL,
  `cast` varchar(255) NOT NULL,
  `maslak` varchar(255) NOT NULL,
  `complexion` varchar(50) DEFAULT NULL,
  `marital_status` enum('Single','Nikkah Break','Separated','Widowed','Divorced') CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `div_reason` varchar(255) DEFAULT NULL,
  `children` int(11) DEFAULT 0,
  `education` varchar(255) NOT NULL,
  `job` varchar(255) DEFAULT NULL,
  `business` varchar(255) DEFAULT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `mother_tongue` varchar(255) DEFAULT NULL,
  `belongs` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `family_status` varchar(255) DEFAULT NULL,
  `full_address` text NOT NULL,
  `home_type` varchar(255) DEFAULT NULL,
  `home_size` varchar(255) DEFAULT NULL,
  `father` varchar(255) DEFAULT NULL,
  `mother` varchar(255) DEFAULT NULL,
  `brothers` varchar(255) DEFAULT NULL,
  `sisters` varchar(255) DEFAULT NULL,
  `req_age` int(11) DEFAULT NULL,
  `req_cast` varchar(255) DEFAULT NULL,
  `req_maslak` varchar(255) DEFAULT NULL,
  `req_height` decimal(5,2) DEFAULT NULL,
  `req_family_status` varchar(255) DEFAULT NULL,
  `req_marital_status` varchar(255) DEFAULT NULL,
  `req_education` varchar(255) DEFAULT NULL,
  `req_city` varchar(255) DEFAULT NULL,
  `req_country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `matchmaker_id`, `gender`, `name`, `age`, `height`, `cnic`, `cast`, `maslak`, `complexion`, `marital_status`, `div_reason`, `children`, `education`, `job`, `business`, `income`, `mother_tongue`, `belongs`, `photo_path`, `country`, `province`, `city`, `area`, `family_status`, `full_address`, `home_type`, `home_size`, `father`, `mother`, `brothers`, `sisters`, `req_age`, `req_cast`, `req_maslak`, `req_height`, `req_family_status`, `req_marital_status`, `req_education`, `req_city`, `req_country`) VALUES
(9, 23, 'Male', 'faraz', 20, 175.00, '4220112312312', 'Piracha', 'Muslim', 'Fair', 'Single', '', 0, 'BS Software Engineering', 'Student', 'Freelance', 0.00, 'Urdu', 'Pakistan', 'images\\9.jpeg', '', '', '', '', '', '', '', '', '', '', '', '', 20, 'Any', 'Muslim', 0.00, '', 'Single', 'Bachelor\'s', 'Karachi', 'Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `matchmakers`
--

CREATE TABLE `matchmakers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `matchmakers`
--

INSERT INTO `matchmakers` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`) VALUES
(23, 58, 'faraz', 'naeem', 'faraz@gmail.com', '03212232026');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `status`) VALUES
(37, 'admin@gmail.com', 'admin_password', 2),
(58, 'faraz@gmail.com', 'pass', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnic` (`cnic`),
  ADD KEY `matchmaker_id` (`matchmaker_id`);

--
-- Indexes for table `matchmakers`
--
ALTER TABLE `matchmakers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `matchmakers`
--
ALTER TABLE `matchmakers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `matchmaker_id_fk` FOREIGN KEY (`matchmaker_id`) REFERENCES `matchmakers` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `matchmakers`
--
ALTER TABLE `matchmakers`
  ADD CONSTRAINT `matchmakers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
