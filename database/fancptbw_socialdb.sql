-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2023 at 09:28 PM
-- Server version: 10.3.37-MariaDB-log-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fancptbw_socialdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(128) NOT NULL,
  `user_fullname` varchar(60) NOT NULL,
  `user_photo` varchar(255) NOT NULL DEFAULT 'assets/images/users/no_profile.png',
  `user_created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_email`, `user_password`, `user_fullname`, `user_photo`, `user_created_at`) VALUES
(1, 'admin@test.com', '$2y$10$BLwThWFZ3kzisUZvabY2wuhhqbM1wgig8DTb4103v7xIF4qli9cwG', 'Admin', 'assets/images/users/julian-wan.jpeg', '2023-01-08 15:52:42'),
(2, 'marcel@test.com', '$2y$10$BLwThWFZ3kzisUZvabY2wuhhqbM1wgig8DTb4103v7xIF4qli9cwG', 'Marcel Butcovan', 'assets/images/users/no_profile.png', '2023-01-08 19:08:21'),
(3, 'jack@test.com', '$2y$10$BLwThWFZ3kzisUZvabY2wuhhqbM1wgig8DTb4103v7xIF4qli9cwG', 'Jack Mason', 'assets/images/users/jack_mason.jpeg', '2023-01-08 20:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `users_follow`
--

CREATE TABLE `users_follow` (
  `x_id` int(11) NOT NULL,
  `y_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_follow`
--

INSERT INTO `users_follow` (`x_id`, `y_id`) VALUES
(3, 2),
(2, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
