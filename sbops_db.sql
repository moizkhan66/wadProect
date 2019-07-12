-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2019 at 08:30 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sbops_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `anecdotal_tb`
--

CREATE TABLE `anecdotal_tb` (
  `anecdotal_id` int(255) NOT NULL,
  `anecdotal_date` date NOT NULL,
  `anecdotal_note` varchar(255) NOT NULL,
  `anecdotal_giver` varchar(255) NOT NULL,
  `term` varchar(10) NOT NULL DEFAULT '3rd',
  `giver_rltn` varchar(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `adate_encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `studstatus_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anecdotal_tb`
--

INSERT INTO `anecdotal_tb` (`anecdotal_id`, `anecdotal_date`, `anecdotal_note`, `anecdotal_giver`, `term`, `giver_rltn`, `user_id`, `adate_encoded`, `studstatus_id`) VALUES
(1, '1111-11-11', 'a1', 'a1', '3rd', NULL, NULL, '2019-04-26 02:24:44', 2),
(3, '1111-11-11', 'sar dard', 'sar dard', '3rd', NULL, 6, '2019-04-27 23:25:57', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ay_tb`
--

CREATE TABLE `ay_tb` (
  `ay_id` int(255) NOT NULL,
  `ay_name` varchar(255) NOT NULL,
  `ay_start_date` date NOT NULL,
  `ay_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ay_tb`
--

INSERT INTO `ay_tb` (`ay_id`, `ay_name`, `ay_start_date`, `ay_end_date`) VALUES
(4, '1998-11-11', '1998-11-11', '1998-11-11'),
(5, '1998-11-11', '2222-11-22', '2222-02-22'),
(6, '1111-12-11', '1111-11-11', '1111-11-11'),
(7, '1111-11-11', '1111-11-11', '1111-11-11');

-- --------------------------------------------------------

--
-- Table structure for table `counseling_tb`
--

CREATE TABLE `counseling_tb` (
  `counseling_id` int(255) NOT NULL,
  `term` varchar(255) NOT NULL DEFAULT '3rd',
  `counseling_date` date NOT NULL,
  `counseling_concern` varchar(255) NOT NULL,
  `action_plan` varchar(255) NOT NULL,
  `counseling_status` varchar(10) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `cdate_encoded` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `studstatus_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `counseling_tb`
--

INSERT INTO `counseling_tb` (`counseling_id`, `term`, `counseling_date`, `counseling_concern`, `action_plan`, `counseling_status`, `user_id`, `cdate_encoded`, `studstatus_id`) VALUES
(1, '1998-11-11', '1111-11-11', 'any', 'any', 'on-going', 6, '2019-04-26 00:42:17.577619', 2),
(2, '1111-11-11', '1111-11-11', 'none', 'none', 'done', 6, '2019-04-26 03:18:36.765240', 4),
(4, '1111-11-11', '1111-11-11', 'awin', 'awin', 'on-going', 7, '2019-04-27 04:00:42.846283', 4),
(5, '3rd', '1111-11-11', 'to drank', 'no soda', 'on-going', 6, '2019-04-28 16:32:38.235253', 3);

-- --------------------------------------------------------

--
-- Table structure for table `grade_tb`
--

CREATE TABLE `grade_tb` (
  `grade_id` int(255) NOT NULL,
  `grade_level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_tb`
--

INSERT INTO `grade_tb` (`grade_id`, `grade_level`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6'),
(7, '7'),
(8, '8'),
(9, '9'),
(10, '10'),
(11, '11'),
(12, '12'),
(13, 'IB 1'),
(14, 'IB 2');

-- --------------------------------------------------------

--
-- Table structure for table `pshycht_tb`
--

CREATE TABLE `pshycht_tb` (
  `psycht_id` int(255) NOT NULL,
  `psycht_date` varchar(255) NOT NULL,
  `test_type` varchar(255) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `term` varchar(10) NOT NULL DEFAULT '255',
  `user_id` int(255) DEFAULT NULL,
  `pdate_encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `studstatus_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pshycht_tb`
--

INSERT INTO `pshycht_tb` (`psycht_id`, `psycht_date`, `test_type`, `test_name`, `term`, `user_id`, `pdate_encoded`, `studstatus_id`) VALUES
(1, '1111-11-11', 'Low', 'Blood Cell', '255', 6, '2019-04-28 22:56:11', 3);

-- --------------------------------------------------------

--
-- Table structure for table `section_tb`
--

CREATE TABLE `section_tb` (
  `section_id` int(255) NOT NULL,
  `section` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section_tb`
--

INSERT INTO `section_tb` (`section_id`, `section`) VALUES
(1, 'A'),
(2, 'B');

-- --------------------------------------------------------

--
-- Table structure for table `student_tb`
--

CREATE TABLE `student_tb` (
  `stud_number` varchar(255) NOT NULL,
  `stud_lname` varchar(100) NOT NULL,
  `stud_fname` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_tb`
--

INSERT INTO `student_tb` (`stud_number`, `stud_lname`, `stud_fname`, `birthdate`, `gender`, `nationality`, `user_id`) VALUES
('12', 'max', 'max', '1111-11-11', 'male', '11', 6),
('1234er', 'rocket', 'adam', '1998-11-11', 'male', 'uk', 6);

-- --------------------------------------------------------

--
-- Table structure for table `studstatus_tb`
--

CREATE TABLE `studstatus_tb` (
  `studstatus_id` int(255) NOT NULL,
  `stud_number` varchar(255) NOT NULL,
  `grade_id` int(255) NOT NULL,
  `section_id` int(255) NOT NULL,
  `ay_id` int(255) NOT NULL,
  `stud_status` varchar(255) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studstatus_tb`
--

INSERT INTO `studstatus_tb` (`studstatus_id`, `stud_number`, `grade_id`, `section_id`, `ay_id`, `stud_status`) VALUES
(1, '1234er', 3, 2, 4, 'Active'),
(2, '123', 3, 0, 5, 'Active'),
(3, '12', 1, 1, 6, 'Active'),
(4, '12345er', 12, 0, 7, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `user_id` int(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `license_id` varchar(255) DEFAULT NULL,
  `license_ed` varchar(255) DEFAULT NULL,
  `user_type` varchar(20) NOT NULL,
  `user_status` varchar(20) NOT NULL DEFAULT 'Active',
  `user_contact` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`user_id`, `user_name`, `user_email`, `user_username`, `user_password`, `license_id`, `license_ed`, `user_type`, `user_status`, `user_contact`) VALUES
(6, 'Administrator', 'admin@admin.com', 'admin', '$2y$10$AGJQZ.RkQwP8bNLde6vwjuA5AGXqSO1H/hNsa33snfzcoqVWIl0se', '', '', 'admin', 'Active', 11111111);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anecdotal_tb`
--
ALTER TABLE `anecdotal_tb`
  ADD PRIMARY KEY (`anecdotal_id`);

--
-- Indexes for table `ay_tb`
--
ALTER TABLE `ay_tb`
  ADD PRIMARY KEY (`ay_id`);

--
-- Indexes for table `counseling_tb`
--
ALTER TABLE `counseling_tb`
  ADD PRIMARY KEY (`counseling_id`);

--
-- Indexes for table `grade_tb`
--
ALTER TABLE `grade_tb`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `pshycht_tb`
--
ALTER TABLE `pshycht_tb`
  ADD PRIMARY KEY (`psycht_id`);

--
-- Indexes for table `section_tb`
--
ALTER TABLE `section_tb`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `student_tb`
--
ALTER TABLE `student_tb`
  ADD PRIMARY KEY (`stud_number`);

--
-- Indexes for table `studstatus_tb`
--
ALTER TABLE `studstatus_tb`
  ADD PRIMARY KEY (`studstatus_id`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anecdotal_tb`
--
ALTER TABLE `anecdotal_tb`
  MODIFY `anecdotal_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ay_tb`
--
ALTER TABLE `ay_tb`
  MODIFY `ay_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `counseling_tb`
--
ALTER TABLE `counseling_tb`
  MODIFY `counseling_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grade_tb`
--
ALTER TABLE `grade_tb`
  MODIFY `grade_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pshycht_tb`
--
ALTER TABLE `pshycht_tb`
  MODIFY `psycht_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `studstatus_tb`
--
ALTER TABLE `studstatus_tb`
  MODIFY `studstatus_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
