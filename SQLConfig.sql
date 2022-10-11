-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2022 at 10:09 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `track_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `follower_id` int(11) NOT NULL,
  `follower_sender_id` int(11) NOT NULL,
  `follower_recever_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`follower_id`, `follower_sender_id`, `follower_recever_id`) VALUES
(50, 9, 8),
(51, 9, 7),
(52, 7, 9),
(53, 7, 10),
(54, 8, 9),
(55, 8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_user_id` int(11) NOT NULL,
  `post_content` varchar(500) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_user_id`, `post_content`, `post_date`) VALUES
(16, 7, 'a post from ali', '2022-10-11 18:51:06'),
(17, 8, 'a post from john', '2022-10-11 18:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_user_name` varchar(50) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_profile_image` varchar(50) NOT NULL DEFAULT 'user.jpg',
  `user_bio` varchar(50) NOT NULL,
  `user_followers_number` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_user_name`, `user_name`, `user_email`, `user_password`, `user_profile_image`, `user_bio`, `user_followers_number`) VALUES
(7, 'ali', 'Ali Ashour', 'ali@gmail.com', 'eefd366a83e970224c791853502bfeadfd9e1002', '6345bc135ac29ali.jpg', '', 0),
(8, 'john', 'John Smith', 'john@gmail.com', '89414f71d0d3ba2ca171dc3727301054bc010534', '6345bb7955f66john.jpg', '', 0),
(9, 'zaki', 'Zaki Nabil', 'zaki@gmail.com', '284c9de78eb920e0ed760bc128c3e5606879161d', '6345bbeca3a7czaki.png', '', 0),
(10, 'admin', 'Admin Admoun', 'admin@gmail.com', '9f37ea425f39219198cd2e7f616568878f8adb7a', 'user.jpg', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`follower_id`,`follower_sender_id`,`follower_recever_id`),
  ADD KEY `FK_RECEVER_USER` (`follower_recever_id`),
  ADD KEY `FK_SENDER_USER` (`follower_sender_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_user_id` (`post_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `follower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `FK_RECEVER_USER` FOREIGN KEY (`follower_recever_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SENDER_USER` FOREIGN KEY (`follower_sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
