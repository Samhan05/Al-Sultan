-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2026 at 04:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxury_cars_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `make` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(4) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `specs` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('Available','Sold') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `make`, `model`, `year`, `price`, `description`, `specs`, `image`, `status`) VALUES
(4, 'Rolls-Royce', 'Phantom Extended', 2024, 540000.00, 'The quietest and most luxurious cabin in the world, offering an unmatched \"magic carpet ride\".', '6.75L V12 Twin-Turbo, 563 HP, 0-60 in 5.1s', 'Rolls-Royce Phantom Extended (2024).png', 'Available'),
(5, 'Bugatti', 'Chiron Super Sport', 2023, 3800000.00, 'A masterpiece of engineering that combines extreme speed with luxury grand touring capabilities.', '8.0L W16 Quad-Turbo, 1578 HP, Top Speed 273 mph', 'Bugatti Chiron Super Sport (2023).png', 'Available'),
(6, 'Ferrari', 'SF90 Stradale', 2024, 650000.00, 'Ferrari\'s first series-production PHEV (Plug-in Hybrid Electric Vehicle) spider, setting new performance standards.', '4.0L V8 Twin-Turbo + 3 E-Motors, 986 HP, AWD', 'Ferrari SF90 Stradale (2024).png', 'Available'),
(7, 'Lamborghini', 'Revuelto', 2024, 608000.00, 'The first High Performance Electrified Vehicle (HPEV) hybrid super sports car from Lamborghini.', '6.5L V12 naturally aspirated + 3 E-Motors, 1001 HP', 'Lamborghini Revuelto (2024).png', 'Available'),
(8, 'Bentley', 'Flying Spur Mulliner', 2024, 315000.00, 'The ultimate luxury sedan that blends sports sedan performance with limousine luxury.', '6.0L W12 Twin-Turbo, 626 HP, 0-60 in 3.7s', 'Bentley Flying Spur Mulliner (2024).png', 'Available'),
(9, 'Aston Martin', 'Valhalla', 2024, 800000.00, 'A mid-engine hybrid supercar that brings F1 technology to the road.', '4.0L V8 Twin-Turbo Hybrid, 937 HP, Carbon Fiber Chassis', 'Aston Martin Valhalla (2024).png', 'Available'),
(10, 'McLaren', '765LT Spider', 2023, 388000.00, 'Defined by fearless engineering, this Longtail is lighter, more powerful, and has higher levels of engagement.', '4.0L V8 Twin-Turbo, 755 HP, 0-60 in 2.7s', 'McLaren 765LT Spider (2023).png', 'Available'),
(11, 'Porsche', '911 GT3 RS', 2024, 285000.00, 'A road-legal race car designed for maximum performance on the track.', '4.0L Flat-6 NA, 518 HP, DRS Drag Reduction System', 'Porsche 911 GT3 RS (2024).png', 'Available'),
(12, 'Mercedes-Maybach', 'S 680', 2024, 235000.00, 'The pinnacle of the Mercedes-Benz brand, featuring a V12 engine and first-class rear cabin.', '6.0L V12 Biturbo, 621 HP, Burmester 4D Sound', 'Mercedes-Maybach S 680 (2024).png', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `reply` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `replied_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `reply`, `is_read`, `created_at`, `replied_at`) VALUES
(1, 3, 'سلطان عماد تاج الدين سمحان', 'sultan@gmail.com', '', 'sadwsd', 'Hello there', 1, '2026-01-03 14:28:39', '2026-01-03 14:33:51'),
(2, 2, 'سلطان عماد تاج الدين سمحان', 'sultan@gmail.com', '', 'sadwd', 'how can i help you?\r\n', 1, '2026-01-03 14:39:16', '2026-01-03 14:40:01');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `reserve_date` date NOT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `car_id`, `reserve_date`, `message`, `status`) VALUES
(2, 2, 4, '2025-12-19', '', 'Approved'),
(3, 2, 4, '2025-12-09', '', 'Approved'),
(4, 4, 6, '2025-12-24', '', 'Approved'),
(5, 6, 9, '2025-12-22', '', 'Approved'),
(6, 2, 4, '2025-12-11', '', 'Approved'),
(7, 2, 11, '2026-01-12', '', 'Approved'),
(8, 2, 12, '2026-01-27', '', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Customer') NOT NULL DEFAULT 'Customer',
  `avatar` varchar(255) DEFAULT 'default_avatar.png',
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `avatar`, `remember_token`) VALUES
(2, 'Customer', 'user@gmail.com', 'user123', 'Customer', 'default_avatar.png', '665efcd0d5b26cc1fba303cf10b9fa822b30a3bcc0092dbc88f9f588e7b39e55'),
(3, 'Sultan Samhan', 'sultan@gmail.com', '1234', 'Admin', 'default_avatar.png', 'e04b4f360dba3c01aacf19af04b4f5cac9aa0ea8cd14069413432f97e81c5724'),
(4, 'Sanad', 'sanadtdm@gmail.com', '978645312S@nad', 'Customer', 'default_avatar.png', NULL),
(5, 'Adwan', 'jairody68@gmail.com', 'asd', 'Customer', 'default_avatar.png', NULL),
(6, 'shahad', 'shahadftit11@gmail.com', '0790389296Sh', 'Customer', 'default_avatar.png', '053141e6aaed7c9ff7f9fd86e8f3decaee2a5298521d56bc6fdce46720f700a5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
