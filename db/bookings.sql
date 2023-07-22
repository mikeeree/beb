-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2023 at 03:16 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookings`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `file_src` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `userid` int NOT NULL,
  `roomid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `capacity` int NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `img_src` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `capacity`, `description`, `img_src`) VALUES
(1, 'Leong Hall', 476, 'test', NULL),
(2, 'Escaler Hall', 250, 'Escaler Hall is a lecture hall situated on the first floor of the SEC A building. The hall is equipped with LCD screens, microphones, computers, and clickers. It is fully air-conditioned and features chairs with foldable tables. Escaler Hall is an ideal venue for general assemblies, talks, or lectures, as it can accommodate a large number of people and provides tables for attendees to take notes.', NULL),
(3, 'MVP Roof Deck', 400, 'Located at the top floor of the MVP Building, this venue, although it lacks air conditioning, offers a nice overlooking view of Ateneo, a large space perfect for team building. It does not come with projectors, microphones, and screens, but it can be made available upon request. MVP Roofdeck is mostly used for organizational events that would require team building, games, and other physical activities for a large group of people.\r\n', NULL),
(4, 'Rizal Mini Theatre', 200, 'Rizal Mini Theatre, also known as Faber Hall, is a theater located near the entrance of the Xavier Building. The theater is fully air-conditioned and equipped with a spacious stage, making it an ideal venue for performances and plays. Additionally, its capacity to accommodate a substantial number of people is perfect for hosting various types of performances.\r\n', NULL),
(5, 'Ching Tan Room', 98, 'Located on the first floor of the JGSOM Building, Ching Tan is an airconditioned room equipped with LCD, Screen, and Microphone perfect for big classes, conferences, and lectures. Moreover, the room has different levels of long tables that are also equipped with sockets. Usually, this room is used for case studies, and general assemblies of organizations.\r\n', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`) VALUES
(1, 'user1', 'user123', 'Daniel', 'user'),
(2, 'admin1', 'admin1', 'Lebron James', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_idx` (`userid`),
  ADD KEY `fk_room_idx` (`roomid`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_room_idx` FOREIGN KEY (`roomid`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_idx` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
