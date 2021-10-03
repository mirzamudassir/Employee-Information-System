-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2021 at 09:53 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eis`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(240) NOT NULL,
  `department_code` varchar(100) NOT NULL,
  `department_name` text NOT NULL,
  `enrolled_employees` varchar(100) NOT NULL,
  `visibility` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_code`, `department_name`, `enrolled_employees`, `visibility`) VALUES
(2, '1234', 'Human Resource', '', 'Visible');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(230) NOT NULL,
  `designation_name` varchar(100) NOT NULL,
  `pay_scale` varchar(100) NOT NULL,
  `basic_salary` varchar(100) NOT NULL,
  `enrolled_employees` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation_name`, `pay_scale`, `basic_salary`, `enrolled_employees`) VALUES
(3, 'Supervisor', 'BPS 05', '20000.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(230) NOT NULL,
  `username` varchar(100) NOT NULL,
  `employeeID` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `education` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `pay_scale` varchar(100) NOT NULL,
  `basic_salary` varchar(100) NOT NULL,
  `allowances` varchar(100) NOT NULL,
  `profile_picture` varchar(100) NOT NULL,
  `registered_by` varchar(100) NOT NULL,
  `registered_at` varchar(100) NOT NULL,
  `last_edit_by` varchar(100) NOT NULL,
  `last_edit_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(240) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `contact_no` varchar(240) NOT NULL,
  `email` varchar(200) NOT NULL,
  `access_level` varchar(200) NOT NULL,
  `account_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `username`, `password_hash`, `full_name`, `designation`, `contact_no`, `email`, `access_level`, `account_status`) VALUES
(5, 'admin', '$2y$12$ExPOtVagbYg7FxHb0BsP5uVXk3z3NMXXJKVNkhBXNKtadn/33BHrq', 'Touqeer Ahmad', 'Administrator', '0301123456789', '', 'ADMIN', 'ACTIVE'),
(6, 'employee', '$2y$10$ImXs9oiUODUeVjpLN9/W9eyfqwiaf.XYSZ84jJimwBcZgyOXLOsWm', 'Mudassir Mirza', 'Employee', '03027557810', '', 'USER', 'ACTIVE'),
(51, 'mudassir', '$2y$10$BJFvchawz87CGpwYdEOzJOJ4BL5zcgs9jewr.3H6qtbNw4rk/v9DG', 'Mudassir Mirza', 'Supervisor', '03027557810', 'mirzamudassir202@gmail.com', 'USER', 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(240) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(230) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(230) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
