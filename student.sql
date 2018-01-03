-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2017 at 07:01 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `startdate` varchar(48) NOT NULL,
  `enddate` varchar(48) NOT NULL,
  `allDay` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id`, `title`, `startdate`, `enddate`, `allDay`) VALUES
(3, 'New Event', '2017-11-06T00:00:00+05:30', '2017-11-06T00:00:00+05:30', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event`
--

CREATE TABLE `tbl_event` (
  `event_id` int(11) NOT NULL,
  `user_id` int(15) NOT NULL,
  `title` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `event_date` date NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_event`
--

INSERT INTO `tbl_event` (`event_id`, `user_id`, `title`, `detail`, `image`, `start_time`, `end_time`, `event_date`, `added_date`) VALUES
(3, 1, 'Testing2', 'Testing', 'Testing.jpg', '2017-11-07 00:00:00', '2017-11-08 00:00:00', '2017-11-08', '2017-11-06 17:49:38'),
(2, 1, 'test', 'Testing', 'Testing.jpg', '2017-11-06 06:00:00', '2017-11-06 06:30:00', '2017-11-06', '2017-11-06 17:02:09'),
(4, 1, 'Testing3', 'Testing', 'Testing.jpg', '2017-11-07 00:00:00', '2017-11-08 00:00:00', '2017-11-08', '2017-11-06 17:49:49'),
(5, 1, 'Testing4', 'Testing', 'Testing.jpg', '2017-11-07 00:00:00', '2017-11-08 00:00:00', '2017-11-08', '2017-11-06 17:49:56'),
(8, 1, '123456', 'Testing', 'Testing.jpg', '2017-11-08 00:00:00', '2017-11-09 00:00:00', '2017-11-09', '2017-11-07 12:06:33'),
(7, 1, 'dddd', 'Testing', 'Testing.jpg', '2017-11-09 00:00:00', '2017-11-10 00:00:00', '2017-11-10', '2017-11-07 01:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pagination`
--

CREATE TABLE `tbl_pagination` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pagination`
--

INSERT INTO `tbl_pagination` (`id`, `name`, `age`) VALUES
(1, 'name1', 1),
(2, 'demo2', 7),
(3, 'demo3', 8),
(4, 'demo4', 9),
(5, 'demo5', 10),
(6, 'demo6', 11),
(7, 'demo7', 12),
(8, 'demo8', 13),
(9, 'demo9', 14),
(10, 'demo10', 15),
(11, 'demo11', 16),
(12, 'demo12', 17),
(13, 'demo13', 18),
(14, 'demo14', 19),
(15, 'demo15', 20),
(16, 'demo16', 21),
(17, 'demo17', 22),
(18, 'demo18', 23),
(19, 'demo19', 24),
(20, 'demo20', 25),
(21, 'demo21', 26),
(22, 'demo22', 27),
(23, 'demo23', 28),
(24, 'demo24', 29),
(25, 'demo25', 30),
(26, 'demo26', 31),
(27, 'demo27', 32),
(28, 'demo28', 33),
(29, 'demo29', 34),
(30, 'demo30', 35),
(31, 'demo31', 36),
(32, 'demo32', 37),
(33, 'demo33', 38),
(34, 'demo34', 39),
(35, 'demo35', 40),
(36, 'demo36', 41),
(37, 'demo37', 42),
(38, 'demo38', 43),
(39, 'demo39', 44),
(40, 'demo40', 45),
(41, 'demo41', 46),
(42, 'demo42', 47),
(43, 'demo43', 48),
(44, 'demo44', 49),
(45, 'demo45', 50),
(46, 'demo46', 51),
(47, 'demo47', 52),
(48, 'demo48', 53),
(49, 'demo49', 54),
(50, 'demo50', 55),
(51, 'demo51', 56),
(52, 'demo52', 57),
(53, 'demo53', 58),
(54, 'demo54', 59),
(55, 'demo55', 60),
(56, 'demo56', 61),
(57, 'demo57', 62),
(58, 'demo58', 63),
(59, 'demo59', 64),
(60, 'demo60', 65),
(61, 'demo61', 66),
(62, 'demo62', 67),
(63, 'demo63', 68),
(64, 'demo64', 69),
(65, 'demo65', 70),
(66, 'demo66', 71),
(67, 'demo67', 72),
(68, 'demo68', 73),
(69, 'demo69', 74),
(70, 'demo70', 75),
(71, 'demo71', 76),
(72, 'demo72', 77),
(73, 'demo73', 78),
(74, 'demo74', 79),
(75, 'demo75', 80),
(76, 'demo76', 81),
(77, 'demo77', 82),
(78, 'demo78', 83),
(79, 'demo79', 84),
(80, 'demo80', 85),
(81, 'demo81', 86),
(82, 'demo82', 87),
(83, 'demo83', 88),
(84, 'demo84', 89),
(85, 'demo85', 90),
(86, 'demo86', 91),
(87, 'demo87', 92),
(88, 'demo88', 93),
(89, 'demo89', 94),
(90, 'demo90', 95),
(91, 'demo91', 96),
(92, 'demo92', 97),
(93, 'demo93', 98),
(94, 'demo94', 99),
(95, 'demo95', 100),
(96, 'demo96', 101),
(97, 'demo97', 102),
(98, 'demo98', 103),
(99, 'demo99', 104),
(100, 'demo100', 105);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stud`
--

CREATE TABLE `tbl_stud` (
  `stuid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `stud` int(11) NOT NULL,
  `maths` int(10) NOT NULL,
  `science` int(10) NOT NULL,
  `english` int(10) NOT NULL,
  `total_marks` int(10) NOT NULL,
  `result` varchar(20) NOT NULL,
  `total_pass` tinyint(1) NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_stud`
--

INSERT INTO `tbl_stud` (`stuid`, `firstname`, `lastname`, `stud`, `maths`, `science`, `english`, `total_marks`, `result`, `total_pass`, `added_date`) VALUES
(1, 'test', '456', 3, 10, 10, 10, 30, 'Fail', 0, '2017-11-01 16:00:21'),
(2, 'test', '4', 3, 10, 10, 10, 30, 'Fail', 0, '2017-11-01 16:00:27'),
(3, 'test', '123', 3, 25, 40, 40, 105, 'Fail', 0, '2017-11-01 16:01:00'),
(4, 'test', '123', 3, 77, 78, 79, 234, 'Pass', 3, '2017-11-01 16:01:11'),
(5, 'test', '123', 3, 77, 78, 79, 234, 'Pass', 3, '2017-11-01 16:01:14'),
(6, 'test', '123', 3, 77, 78, 79, 234, 'Pass', 3, '2017-11-01 16:01:14'),
(7, 'test', '123', 3, 77, 78, 79, 234, 'Pass', 3, '2017-11-01 16:01:15'),
(8, 'test', '123', 3, 77, 78, 79, 234, 'Pass', 3, '2017-11-01 16:01:15'),
(9, 'test', '123', 3, 77, 78, 79, 234, 'Pass', 3, '2017-11-01 16:01:16'),
(10, 'test', '123', 3, 77, 78, 79, 234, 'Pass', 3, '2017-11-01 16:01:16'),
(14, 'test', '123', 3, 10, 10, 10, 30, 'Fail', 0, '2017-11-01 16:00:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tbl_event`
--
ALTER TABLE `tbl_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbl_pagination`
--
ALTER TABLE `tbl_pagination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_stud`
--
ALTER TABLE `tbl_stud`
  ADD PRIMARY KEY (`stuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_event`
--
ALTER TABLE `tbl_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_pagination`
--
ALTER TABLE `tbl_pagination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `tbl_stud`
--
ALTER TABLE `tbl_stud`
  MODIFY `stuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
