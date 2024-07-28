-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 03:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `id` int(11) NOT NULL,
  `verification_code` varchar(15) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `id_number` varchar(12) NOT NULL,
  `year_graduated` varchar(10) NOT NULL,
  `school_graduated` varchar(100) NOT NULL,
  `program_graduated` varchar(100) NOT NULL,
  `admission` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`id`, `verification_code`, `fullname`, `email`, `password`, `contact`, `address`, `sex`, `dob`, `occupation`, `id_number`, `year_graduated`, `school_graduated`, `program_graduated`, `admission`, `is_verified`) VALUES
(88, '643654', 'Roxan Hilba', 'roxanhilba17@gmail.com', '', '09505501863', '', 'Female', '2000-06-28', '', '2020-1212', '2023', '', 'BSIT', '2020', 1),
(89, '979722', 'vince lauron', 'lauronvince13@gmail.com', '', '09094513507', '', 'Male', '2002-12-30', '', '2021-1412', '2020-2021', '', 'BSIT', '2021', 1),
(90, '662364', 'Bryan James Desuyo', 'bryanjamesdesuyo15@gmail.com', '', '09123767434', '', 'Male', '2003-05-15', '', '2021-1407', '2025', '', 'BSIT', '2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_number` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_number`, `fullname`, `name`, `description`, `user_id`, `folder_id`, `file_type`, `file_path`, `file_name`, `is_public`, `date_updated`) VALUES
(38, '212863916736', 'rolly recabar', 'bantayan', 'cute', 1, 11, 'jpg', '1718952300_bantayan.jpg', '', 0, '2024-06-21 14:45:27'),
(44, '925899206894', 'vince lauron simuelle', 'maya', 'cute ako', 1, 0, 'png', '1718958420_maya.png', '', 0, '2024-06-21 21:20:24'),
(45, '352050093990', 'vince lauron simuelle', 'image', 'for capstone only', 1, 14, 'jpg', '1718976060_448419021_7658616977540041_1247959626365689670_n.jpg', '', 0, '2024-06-21 21:21:58'),
(46, '283569122930', 'vince lauron simuelle', 'VINCE', 'agfafgad', 1, 0, 'jpg', '1718978940_448419021_7658616977540041_1247959626365689670_n.jpg', '', 0, '2024-06-25 13:36:17'),
(47, '065057693318', 'rolly recabar', 'Screenshot (103)', 'cue', 1, 0, 'png', '1719041160_Screenshot (103).png', '', 0, '2024-06-22 15:26:16'),
(48, '118238754620', 'argie magallanes', 'maya ||1', 'hahhaah', 1, 0, 'png', '1719283860_maya.png', '', 0, '2024-06-25 10:51:51'),
(50, '751899944151', 'vince lauron simuelle', 'Innovative presentation - JJV', 'innovative', 3, 0, '', '1719389880_Innovative presentation - JJV..pptx', '', 0, '2024-06-26 16:18:16'),
(51, '239391047770', 'vincelauron', 'ryan123', 'afafaf', 1, 0, 'pptx', '1719472440_ryan123.pptx', '', 0, '2024-06-27 15:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `file_track`
--

CREATE TABLE `file_track` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tracking_number` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_track`
--

INSERT INTO `file_track` (`id`, `user_id`, `tracking_number`, `date_created`) VALUES
(1, 1, 2147483647, '2024-06-21 21:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `parent_id` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `user_id`, `name`, `description`, `parent_id`) VALUES
(11, 1, 'Enrolless', '', 0),
(14, 1, 'mcc nso', '', 0),
(15, 1, 'Certificates', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'unread',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_email`, `message`, `status`, `date_created`) VALUES
(1, 'roxanhilba17@gmail.com', 'New request submitted by Roxan Hilba.', '1', '2024-07-17 03:08:53'),
(2, 'roxanhilba17@gmail.com', 'New request submitted by Vince Lauron.', '1', '2024-07-17 03:41:56'),
(3, 'roxanhilba17@gmail.com', 'New request submitted by Vince Lauron', '1', '2024-07-17 08:29:04'),
(4, 'roxanhilba17@gmail.com', 'New request submitted by vince lauron simuelle', '1', '2024-07-17 08:44:28'),
(5, 'roxanhilba17@gmail.com', 'New request submitted by Vince Lauron', '1', '2024-07-17 08:50:02'),
(6, 'roxanhilba17@gmail.com', 'New request submitted by Joebert Bilbao', '1', '2024-07-17 08:57:38'),
(7, 'roxanhilba17@gmail.com', 'New request submitted by Vince Lauron', '1', '2024-07-17 09:08:51'),
(8, 'roxanhilba17@gmail.com', 'New request submitted by vince lauron simuelle', '1', '2024-07-17 09:22:07'),
(9, 'roxanhilba17@gmail.com', 'New request submitted by vincelauron', '1', '2024-07-19 03:34:15'),
(10, 'roxanhilba17@gmail.com', 'New request submitted by vince lauron simuelle', '1', '2024-07-19 03:36:41'),
(11, 'roxanhilba17@gmail.com', 'New request submitted by Joebert Bilbao', '1', '2024-07-19 03:43:05'),
(12, 'lauronvince13@gmail.com', 'New request submitted by Vince Lauron', '1', '2024-07-19 11:12:47'),
(13, 'roxanhilba17@gmail.com', 'New request submitted by Vince Lauron', '1', '2024-07-20 02:48:22'),
(14, 'roxanhilba17@gmail.com', 'New request submitted by Vince Lauron', '1', '2024-07-20 06:03:30'),
(15, 'bryanjamesdesuyo15@gmail.com', 'New request submitted by Bryan James Desuyo', 'unread', '2024-07-20 12:46:17'),
(16, 'roxanhilba17@gmail.com', 'New request submitted by Vince Lauron', 'unread', '2024-07-20 13:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `course` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `id_number` varchar(15) NOT NULL,
  `docu_type` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','onprocess','released','rejected','') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `email`, `fullname`, `course`, `contact`, `id_number`, `docu_type`, `purpose`, `note`, `date_created`, `status`) VALUES
(179, 'rizelbrace442@gmail.com', 'Rizel Bracero', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '31414141423', '2021-1221', 'TRANSCRIPT OF RECORDS', 'for employment', '', '2024-07-10 14:00:00', ''),
(180, 'rizelbrace442@gmail.com', 'Rizel Bracero', 'BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT', '0945452582', '2021-1602', 'TRANSCRIPT OF RECORDS', 'for employment', '', '2024-07-10 14:23:00', 'rejected'),
(181, 'rizelbrace442@gmail.com', 'Rizel Bracero', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '0945452582', '2021-1412', 'TRANSCRIPT OF RECORDS', 'for employment', 'lack of requirements', '2024-07-10 14:34:00', 'rejected'),
(186, 'lauronvincesimuelle@gmail.com', 'vince lauron simuelle', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '09866545643', '2021-1602', 'Good Moral Certificates', 'test', 'd ma view', '2024-07-10 15:27:00', 'rejected'),
(210, 'jbbilbao80@gmail.com', 'Joebert Bilbao', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '12345678909', '2021-1602', 'Good Moral Certificates', 'testing lng gane', 'ok nani', '2024-07-13 14:35:00', 'released'),
(211, 'jbbilbao80@gmail.com', 'rolly recabar', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '0945452582', '2021-1412', 'TRANSCRIPT OF RECORDS', 'for employment', 'please claim your document', '2024-07-13 14:38:00', 'released'),
(212, 'jbbilbao80@gmail.com', 'Joebert Bilbao', 'BACHELOR OF SCIENCE IN HOSPITALITY MANAGMENT', '09866545643', '2021-1412', 'TRANSCRIPT OF RECORDS', 'adadas', '', '2024-07-13 15:26:00', 'released'),
(213, 'jbbilbao80@gmail.com', 'Vince Lauron', 'BACHELOR OF SCIENCE IN HOSPITALITY MANAGMENT', '31414141423', '2021-1412', 'TRANSCRIPT OF RECORDS', 'for testing', '', '2024-07-13 17:54:00', 'released'),
(214, 'jbbilbao80@gmail.com', 'Vince Lauron', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '12345678909', '2021-1412', 'TRANSCRIPT OF RECORDS', 'afsfaasfsa', '', '2024-07-17 11:36:00', 'pending'),
(215, 'jbbilbao80@gmail.com', 'Joebert Bilbao', 'BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION', '0945452582', '2021-1412', 'TRANSCRIPT OF RECORDS', 'asadasda', 'lack of requirements', '2024-07-16 11:40:00', 'rejected'),
(216, 'jbbilbao80@gmail.com', 'Joebert Bilbao', 'BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO', '0945452582', '2021-1412', 'TRANSCRIPT OF RECORDS', 'for testing', '', '2024-07-16 12:25:00', 'rejected'),
(217, 'jbbilbao80@gmail.com', 'rolly recabar', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '31414141423', '2021-1602', 'TRANSCRIPT OF RECORDS', 'testing', '', '2024-07-16 12:26:00', 'rejected'),
(218, 'jbbilbao80@gmail.com', 'Joebert Bilbao', 'BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT', '09866545643', '2021-1412', 'TRANSCRIPT OF RECORDS', 'hahaha', '', '2024-07-16 12:27:00', 'pending'),
(236, 'lauronvince13@gmail.com', 'Vince Lauron', 'BACHELOR OF SCIENCE IN HOSPITALITY MANAGMENT', '09094513507', '2021-1412', 'TRANSCRIPT OF RECORDS', 'dfsdf', '', '2024-07-19 19:12:00', 'rejected'),
(240, 'bryanjamesdesuyo15@gmail.com', 'Bryan James Desuyo', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '0945452582', '2021-1407', 'TRANSCRIPT OF RECORDS', 'for emplyoment', 'pwede na makuha', '2024-07-20 20:46:00', 'released');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1+admin , 2 = users'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `code`, `status`, `type`) VALUES
(1, 'Administrator', 'admin@admin.com', 'admin123', '', '', 1),
(5, 'Vince Lauron', 'lauronvince13@gmail.com', 'vince123', '', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_track`
--
ALTER TABLE `file_track`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
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
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `file_track`
--
ALTER TABLE `file_track`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
