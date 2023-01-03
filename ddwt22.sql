-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 03, 2023 at 02:20 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ddwt22`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `content`, `datetime`) VALUES
(1, 'tenant1', 'owner1', '<MESSAGE TEXT TENANT1-OWNER1>', '2023-01-03 11:14:32'),
(2, 'owner1', 'tenant1', '<RESPONSE TEXT OWNER1-TENANT1>', '2023-01-03 11:17:28'),
(3, 'tenant2', 'owner1', '<MESSAGE TEXT TENANT2-OWNER1>', '2023-01-03 11:15:15'),
(4, 'owner2', 'tenant1', '<MESSAGE TEXT OWNER2-TENANT1>', '2023-01-03 11:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `opt-ins`
--

CREATE TABLE `opt-ins` (
  `id` int(11) NOT NULL,
  `tenant` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `opt-ins`
--

INSERT INTO `opt-ins` (`id`, `tenant`, `room_id`) VALUES
(1, 'tenant1', 1),
(2, 'tenant2', 1),
(3, 'tenant1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `address`, `type`, `size`, `price`, `owner`) VALUES
(1, 'Broerstraat 5, 9712 CP, Groningen', 'Room', '16 m2', '550,- euro', 'owner1'),
(2, 'Oude Kijk in Het Jatstraat 26, 9712 EK Groningen', 'Room', '20 m2', '700,- euro', 'owner2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_nr` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `profession` varchar(255) NOT NULL,
  `languages` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `name`, `role`, `email`, `phone_nr`, `password`, `birth_date`, `profession`, `languages`, `bio`) VALUES
('owner1', 'Owner One', 1, 'owner1@example.com', 612345678, 'owner1', '2023-01-01', 'Landlord', 'Dutch, English', 'example_bio'),
('owner2', 'Owner Two', 1, 'owner2@example.com', 612345678, 'owner2', '2023-01-01', 'Landlord', 'Dutch, English', 'example_bio'),
('tenant1', 'Tenant One', 2, 'tenant1@example.com', 612345678, 'tenant1', '2023-01-01', 'Student', 'Dutch, English', 'example_bio'),
('tenant2', 'Tenant Two', 2, 'tenant2@example.com', 612345678, 'tenant2', '2023-01-01', 'Student', 'Dutch, English', 'example_bio');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexes for table `opt-ins`
--
ALTER TABLE `opt-ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant` (`tenant`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `opt-ins`
--
ALTER TABLE `opt-ins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `receiver` FOREIGN KEY (`receiver`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `sender` FOREIGN KEY (`sender`) REFERENCES `users` (`username`);

--
-- Constraints for table `opt-ins`
--
ALTER TABLE `opt-ins`
  ADD CONSTRAINT `room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `tenant` FOREIGN KEY (`tenant`) REFERENCES `users` (`username`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `owner` FOREIGN KEY (`owner`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
