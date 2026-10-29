-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2026 at 08:38 PM
-- Server version: 10.5.29-MariaDB-0+deb11u1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klaudia2`
--

-- --------------------------------------------------------

--
-- Table structure for table `examinations`
--

CREATE TABLE `examinations` (
  `examination_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `measure_id` int(10) NOT NULL,
  `value_a` int(10) NOT NULL,
  `value_b` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examinations`
--

INSERT INTO `examinations` (`examination_id`, `user_id`, `measure_id`, `value_a`, `value_b`, `created_at`) VALUES
(1, 5, 1, 69, 69, '2026-04-29 22:00:00'),
(2, 5, 1, 120, 80, '2026-05-19 22:00:00'),
(3, 5, 2, 48, NULL, '2026-05-21 22:00:00'),
(4, 5, 3, 39, NULL, '2026-05-03 22:00:00'),
(5, 12, 1, 190, 80, '2026-05-23 22:00:00'),
(6, 12, 1, 221, 103, '2026-05-21 22:00:00'),
(7, 12, 1, 78, 49, '2026-05-08 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `measure_id` int(10) NOT NULL,
  `measure_name` varchar(50) DEFAULT NULL,
  `unit_id` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`measure_id`, `measure_name`, `unit_id`, `user_id`) VALUES
(1, 'Ciśnienie krwi', 5, NULL),
(2, 'Glukoza', 2, NULL),
(3, 'Temperatura', 3, NULL),
(4, 'BPM', 4, NULL),
(6, 'Hemoglobine', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`login_id`, `user_id`, `user_email`, `success`, `ip_address`, `login_at`) VALUES
(1, 5, '', 1, '10.130.19.154', '2026-05-18 23:23:09'),
(9, 5, '', 1, '10.130.19.154', '2026-05-19 20:14:04'),
(10, 5, '', 0, '10.130.19.154', '2026-05-19 20:14:55'),
(11, 5, '', 1, '10.130.19.154', '2026-05-20 17:30:13'),
(12, NULL, 'klaud1@gmail.com', 1, '10.130.19.154', '2026-05-20 18:11:59'),
(13, NULL, 'klaudiagalka@student.agh.edu.pl', 1, '10.130.19.154', '2026-05-20 18:12:42'),
(14, NULL, 'pbieniek@agh.edu.pl', 1, '10.130.19.154', '2026-05-20 18:15:25'),
(15, 11, 'pbieniek@agh.edu.pl', 1, '10.130.19.154', '2026-05-20 18:44:04'),
(16, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-20 19:26:29'),
(17, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-20 19:27:26'),
(18, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-20 19:35:45'),
(19, 5, 'adam@gmail.com', 0, '10.130.19.154', '2026-05-20 19:37:50'),
(20, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-20 19:38:02'),
(21, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-20 21:11:37'),
(22, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-20 21:23:08'),
(23, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-20 22:24:16'),
(24, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-21 09:41:52'),
(25, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-21 10:46:30'),
(26, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-23 21:42:24'),
(27, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-23 22:42:58'),
(28, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-23 22:43:32'),
(29, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-23 22:59:52'),
(30, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-23 23:01:54'),
(31, 5, 'adam@gmail.com', 1, '10.130.19.154', '2026-05-23 23:07:22'),
(32, 5, 'adam@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 06:40:12'),
(33, 5, 'adam@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 07:18:34'),
(34, 5, 'adam@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 11:42:29'),
(35, 5, 'adam@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 11:59:49'),
(36, NULL, 'magda@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 12:12:55'),
(37, 12, 'magda@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 12:13:14'),
(38, 5, 'adam@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 12:20:32'),
(39, 12, 'magda@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 12:22:21'),
(40, NULL, 'magds@gmail.com', 0, '2001:6d8:10:8210::39a', '2026-05-25 12:23:49'),
(41, 12, 'magda@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 12:24:54'),
(42, 12, 'magda@gmail.com', 1, '2001:6d8:10:8210::39a', '2026-05-25 12:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(10) NOT NULL,
  `unit_name` varchar(32) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `user_id`) VALUES
(2, 'mg/dL', NULL),
(3, '°C', NULL),
(4, 'Number', NULL),
(5, 'mmHg', NULL),
(7, '%', NULL),
(8, 'g/mol', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_passwordhash` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `user_email`, `user_passwordhash`) VALUES
(2, 'klsudd', 'klsudd@gmail.com', '$2y$10$.ZDM8BOIMdAZzKN2Pwp.EuAvyfdz.JdPNX7pc8D8DpryeOcYOo8U2'),
(4, 'nina', 'nina@gmail.com', '$2y$10$A.rqn88xvJBX/4qDakt4n.YEY9H3HD17svy83LD.eYe2f9/Np7Ai6'),
(5, 'adam', 'adam@gmail.com', '$2y$10$bIeLbeEA27VPxpUPReyyWOrE2GxIYn7CIDUWkWdByEy0BV4myFk7K'),
(7, 'klsudd', 'klaudiagalka@gmail.com', '$2y$10$61yLvcqJ2YaswATdZIk1u.jbMq8d/Oe1v9bpv.K0gjOgZJW0b9FSC'),
(9, 'klaud', 'klaud1@gmail.com', '$2y$10$paOzAmXi.MVIEejj.BbFUeY6.xjgAjCeiqUE9/LTENBW1RwYSTPlW'),
(10, 'klaudia', 'klaudiagalka@student.agh.edu.pl', '$2y$10$iRyT28iB8VdOsvacZ4/1J.3wprYV0v.3UfevemEYFc1mQBGYJW8z.'),
(11, 'pawel', 'pbieniek@agh.edu.pl', '$2y$10$1pZc.7p2R6VYs6PQ0nbMA.skRo1mZbSpV18xa34CuvVzwEs/ohqfG'),
(12, 'magda', 'magda@gmail.com', '$2y$10$7eDdilPnMWXlLd3uzaaDY.u8Z0LVnJYfwu9bsrjRWVYXvriD8rHmm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `examinations`
--
ALTER TABLE `examinations`
  ADD PRIMARY KEY (`examination_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `measure_id` (`measure_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`measure_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `examinations`
--
ALTER TABLE `examinations`
  MODIFY `examination_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `measure_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `examinations`
--
ALTER TABLE `examinations`
  ADD CONSTRAINT `examinations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `examinations_ibfk_2` FOREIGN KEY (`measure_id`) REFERENCES `exams` (`measure_id`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`);

--
-- Constraints for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
