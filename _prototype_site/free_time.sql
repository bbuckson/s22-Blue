-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Apr 27, 2022 at 01:35 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `free_time`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `block_type` varchar(99) NOT NULL,
  `start_time` time(6) NOT NULL,
  `end_time` time(6) NOT NULL,
  `start_date` date NOT NULL,
  `user_id` int(99) NOT NULL,
  `event_id` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `block_type`, `start_time`, `end_time`, `start_date`, `user_id`, `event_id`) VALUES
(141, 'free', '03:00:00.000000', '07:00:00.000000', '2022-04-26', 5, NULL),
(142, 'blocked', '08:00:00.000000', '09:30:00.000000', '2022-04-26', 5, NULL),
(143, 'event', '12:00:00.000000', '14:30:00.000000', '2022-04-26', 5, 35),
(144, 'event', '12:00:00.000000', '14:30:00.000000', '2022-04-26', 1, 35),
(145, 'event', '12:00:00.000000', '14:30:00.000000', '2022-04-26', 4, 35),
(146, 'free', '16:15:00.000000', '17:45:00.000000', '2022-04-26', 5, NULL),
(147, 'free', '09:00:00.000000', '11:30:00.000000', '2022-04-26', 4, NULL),
(148, 'blocked', '05:00:00.000000', '08:00:00.000000', '2022-04-26', 4, NULL),
(149, 'blocked', '17:00:00.000000', '19:20:00.000000', '2022-04-26', 4, NULL),
(150, 'free', '21:00:00.000000', '23:30:00.000000', '2022-04-26', 4, NULL),
(151, 'event', '08:00:00.000000', '09:00:00.000000', '2022-04-26', 6, 36),
(152, 'event', '08:00:00.000000', '09:00:00.000000', '2022-04-26', 4, 36),
(153, 'blocked', '04:00:00.000000', '07:00:00.000000', '2022-04-26', 6, NULL),
(154, 'blocked', '10:00:00.000000', '13:00:00.000000', '2022-04-26', 6, NULL),
(155, 'free', '13:30:00.000000', '15:30:00.000000', '2022-04-26', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(99) NOT NULL,
  `description` varchar(999) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `start_date` date NOT NULL,
  `user_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start_time`, `end_time`, `start_date`, `user_id`) VALUES
(35, 'Drinks With Radar', 'Martinis in the Swamp', '12:00:00', '14:30:00', '2022-04-26', 1),
(36, 'Morning Coffee!', 'Stella Cafe for coffee', '08:00:00', '09:00:00', '2022-04-26', 6);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id_1` int(11) NOT NULL,
  `user_id_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id_1`, `user_id_2`) VALUES
(63, 1, 3),
(64, 3, 1),
(65, 6, 1),
(66, 1, 6),
(67, 4, 1),
(68, 1, 4),
(69, 5, 1),
(70, 1, 5),
(71, 6, 4),
(72, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(99) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `time_recieved` datetime NOT NULL,
  `message` varchar(9999) NOT NULL,
  `sender_user_id` int(11) NOT NULL DEFAULT '0',
  `users_in_event_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `user_id`, `seen`, `time_recieved`, `message`, `sender_user_id`, `users_in_event_id`, `event_id`) VALUES
(137, 'event_updated', 5, 0, '2022-04-26 21:46:00', 'thematthaslem has updated Drinks With Radar. <input type=\"hidden\" name=\"sending_user_id\" value=\"1\" /><input type=\"hidden\" name=\"event_id\" value=\"35\" />', 1, 0, 35),
(138, 'event_updated', 1, 0, '2022-04-26 21:46:00', 'thematthaslem has updated Drinks With Radar. <input type=\"hidden\" name=\"sending_user_id\" value=\"1\" /><input type=\"hidden\" name=\"event_id\" value=\"35\" />', 1, 0, 35),
(141, 'event_request', 4, 0, '2022-04-26 21:50:22', 'LindaBelcher invited you to Morning Coffee!. <input type=\"hidden\" name=\"sending_user_id\" value=\"6\" /><input type=\"hidden\" name=\"event_id\" value=\"36\" />', 6, 32, 36);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `username` varchar(99) NOT NULL,
  `email` varchar(99) NOT NULL,
  `first_name` varchar(99) NOT NULL,
  `last_name` varchar(99) NOT NULL,
  `password` varchar(999) NOT NULL,
  `image` varchar(99) NOT NULL DEFAULT 'default.svg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `first_name`, `last_name`, `password`, `image`) VALUES
(1, 'thematthaslem', 'mhasl002@odu.edu', 'Matt', 'Haslem', '$2y$10$WJkirV7XSZetLAn1lkIHouoUl8j1Dk92ezms4Yim8Z/L0sgD4kJCy', 'matt.png'),
(2, 'User1', 'user1@test.test', 'User', 'One', '$2y$10$8OzhJrVpKxCPzdqIrWlI8u6KK1iKRdwhP9u1rDNSq2oKiQwUxfM26', 'default.svg'),
(3, 'JohnJingle', 'john@example.com', 'John', 'Jingle', '$2y$10$RrbScV3wdz9e77ul89/ScukhP0B1OQAIfdeqA/OEhBrZDu4QZpmDC', 'john.jpg'),
(4, 'LisaPisa', 'lisa@example.com', 'Lisa', 'Pisa', '$2y$10$nvhAYe3if61gqilMruo95uoa3hDGz1KP8WXnMxI65qCZyIZa8AxbG', 'lisa.jpg'),
(5, 'BenPierce', 'bp@example.com', 'Benjamin', 'Pierce', '$2y$10$BkB3BqihZx0ngBwrvuga7.cWETBhlpZg/0aj9v/cxRd7R530tFpTa', 'ben.jpg'),
(6, 'LindaBelcher', 'linda@example.com', 'Linda', 'Belcher', '$2y$10$U4Rv0GeJ7PRwPOk0ev9wSeyaq04.o40KpwRNCV0GRpgid8q8rr22C', 'linda.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_in_event`
--

CREATE TABLE `users_in_event` (
  `id` int(11) NOT NULL,
  `receiving_user_id` int(9) NOT NULL,
  `sending_user_id` int(9) NOT NULL,
  `event_id` int(9) NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_in_event`
--

INSERT INTO `users_in_event` (`id`, `receiving_user_id`, `sending_user_id`, `event_id`, `accepted`) VALUES
(22, 2, 2, 33, 0),
(27, 1, 2, 34, 0),
(28, 5, 5, 35, 1),
(29, 1, 5, 35, 1),
(30, 4, 1, 35, 1),
(31, 6, 6, 36, 1),
(32, 4, 6, 36, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_in_event`
--
ALTER TABLE `users_in_event`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_in_event`
--
ALTER TABLE `users_in_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
