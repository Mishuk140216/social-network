-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2022 at 07:21 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_media`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed`
--

CREATE TABLE `tbl_feed` (
  `id` int(20) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `feed_description` text NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_feed`
--

INSERT INTO `tbl_feed` (`id`, `user_id`, `feed_description`, `create_date`) VALUES
(1, '3', 'First Feed', '2022-08-10 22:33:04'),
(2, '3', 'Second Feed', '2022-08-10 22:33:32'),
(3, '3', 'Third Feed', '2022-08-10 22:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_info`
--

CREATE TABLE `tbl_login_info` (
  `id` int(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` text NOT NULL,
  `expire_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_login_info`
--

INSERT INTO `tbl_login_info` (`id`, `email`, `token`, `expire_time`) VALUES
(1, 'mishuk@test.com', '7824f155f4ef94fdfabac0f62a5aa600', '2022-08-10 02:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page`
--

CREATE TABLE `tbl_page` (
  `id` int(20) NOT NULL,
  `page_id` varchar(50) NOT NULL,
  `page_name` varchar(200) NOT NULL,
  `page_info` text NOT NULL,
  `creator_id` varchar(50) NOT NULL,
  `modarator_id` text NOT NULL,
  `followers_id` text NOT NULL,
  `create_date` datetime NOT NULL,
  `last_modify_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_page`
--

INSERT INTO `tbl_page` (`id`, `page_id`, `page_name`, `page_info`, `creator_id`, `modarator_id`, `followers_id`, `create_date`, `last_modify_date`) VALUES
(3, '3_1660144581', 'Test Page', 'This is a test page', '3', '', '3,', '2022-08-10 21:16:21', '2022-08-10 21:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE `tbl_post` (
  `id` int(20) NOT NULL,
  `page_id` varchar(100) NOT NULL,
  `creator_id` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `post_conditions` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `page_id`, `creator_id`, `content`, `post_conditions`, `create_date`) VALUES
(1, '', '3', 'Test Post', '', '2022-08-10 22:04:36'),
(2, '3_1660144581', '3', 'Test Post for Page', '', '2022-08-10 22:15:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_info`
--

CREATE TABLE `tbl_user_info` (
  `id` int(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_pass` varchar(200) NOT NULL,
  `followers_id_list` text NOT NULL,
  `last_modify_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`id`, `first_name`, `middle_name`, `last_name`, `user_email`, `user_pass`, `followers_id_list`, `last_modify_date`) VALUES
(3, 'Moksedul', 'Islam', 'Mishuk', 'mishuk@test.com', '1234', '', '2022-08-10 00:29:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_login_info`
--
ALTER TABLE `tbl_login_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page`
--
ALTER TABLE `tbl_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_login_info`
--
ALTER TABLE `tbl_login_info`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_page`
--
ALTER TABLE `tbl_page`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
