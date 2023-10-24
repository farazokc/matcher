-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 22, 2023 at 12:12 AM
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
  `gender` enum('male','female') DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `contact` varchar(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `matchmaker_id`, `gender`, `first_name`, `last_name`, `dob`, `photo_path`, `education`, `occupation`, `contact`, `location`, `description`) VALUES
(26, 23, 'male', 'faraz', 'naeem', '2023-10-21', 'images\\26.jpeg', 'HSSC', 'Block 10-A Gulshan-e-Iqbal', '03123456789', 'Block 10-A Gulshan-e-Iqbal', 'Faraz Naeem'),
(27, 23, 'male', 'sample', 'person', '2023-10-17', 'images\\27.jpg', 'SSC', '1234 Line', '03123456789', '1234 Line', 'Sample Record'),
(28, 24, 'male', 'simple', 'person', '2023-10-04', 'images\\28.jpg', 'HSSC', '231 Address', '03212456789', '231 Address', 'Simple person');

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
(23, 58, 'faraz', 'naeem', 'faraz@gmail.com', '03212232026'),
(24, 59, 'jahiz', 'ahmad', 'jahiz.ahmed@gmail.com', '03123456789'),
(25, 60, 'ateeq', 'ahmad', 'ateeq.ahmad@gmail.com', '03123456789');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_admin`) VALUES
(37, 'admin@gmail.com', 'admin_password', 2),
(58, 'faraz@gmail.com', 'pass', 0),
(59, 'jahiz.ahmed@gmail.com', 'password', 0),
(60, 'ateeq.ahmad@gmail.com', 'ateeqahmad', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `matchmakers`
--
ALTER TABLE `matchmakers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`matchmaker_id`) REFERENCES `matchmakers` (`id`);

--
-- Constraints for table `matchmakers`
--
ALTER TABLE `matchmakers`
  ADD CONSTRAINT `matchmakers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
