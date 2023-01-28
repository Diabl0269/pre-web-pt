-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2018 at 04:41 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--
CREATE DATABASE forum;
USE forum;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) NOT NULL UNIQUE,
  `name` varchar(50) NOT NULL UNIQUE,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`, `description`) VALUES
(1, 'Hacking', 'Shared exploits by white hat hackers'),
(2, 'Programming', 'A place for all levels to learn and give advice in various programming issues'),
(3, 'Crypto', 'News about all the latests crypto things and coins');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL UNIQUE,
  `username` varchar(20) NOT NULL UNIQUE,
  `password` varchar(30) NOT NULL,
  `displayName` varchar(30) NOT NULL UNIQUE,
  `role` BOOLEAN -- user/false admin/true
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `displayName`, `role`) VALUES
(1, 'admin@admin.com', 'Admin1!', 'Administrator', true),
(2, 'tal123', 'A123456a', 'Tal', false),
(3, 'funAdmin', 'notanAdmin', 'Hacker', false);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `topicId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `content` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `messages` (`topicId`, `userId`, `content`) VALUES
(1, 1, 'I`ll post an exploit to hack the NSA!'),
(1, 2, 'I`ll post an exploit to hack the FBI!'),
(1, 3, 'I`ll post an exploit to hack the CIA!'),
(2, 1, 'React is the best!'),
(2, 2, 'Fun with PHP :)'),
(2, 3, 'Isn`t this the hacking topic?'),
(3, 1, 'Bitcoin FTW!'),
(3, 2, 'Can we trade here in NFTs?'),
(3, 3, 'Selling an NFT of Elon Musk flying to Mars created by OpenAI');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
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
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
