-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2021 at 11:44 PM
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
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(200) NOT NULL,
  `allowance_code` varchar(50) NOT NULL,
  `pay_scale` varchar(100) DEFAULT NULL,
  `allowance_name` varchar(100) NOT NULL,
  `allowance_percentage` varchar(100) NOT NULL,
  `posted_by` varchar(200) NOT NULL,
  `posted_timestamp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `allowance_code`, `pay_scale`, `allowance_name`, `allowance_percentage`, `posted_by`, `posted_timestamp`) VALUES
(4, '0031', 'BPS 05', 'Medical Allowance', '20', 'admin', 'December 10, 2021, 9:56 pm'),
(5, '0021', 'BPS 05', 'House Rent', '12', 'admin', 'December 10, 2021, 9:57 pm'),
(6, '0031', 'BPS 06', 'Medical Allowance', '22', 'admin', 'December 12, 2021, 1:40 am'),
(7, '0021', 'BPS 06', 'House Rent', '12', 'admin', 'December 18, 2021, 6:56 pm'),
(8, '0041', 'BPS 06', 'Convey Allowance', '20', 'admin', 'December 18, 2021, 6:59 pm');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_sheet`
--

CREATE TABLE `attendance_sheet` (
  `id` int(240) NOT NULL,
  `employeeID` varchar(240) NOT NULL,
  `punch_in_timestamp` varchar(50) NOT NULL,
  `punch_out_timestamp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_sheet`
--

INSERT INTO `attendance_sheet` (`id`, `employeeID`, `punch_in_timestamp`, `punch_out_timestamp`) VALUES
(14, 'EIS-001', 'November 25, 2021, 1:04 pm', 'December 21, 2021, 3:37 am'),
(16, 'EIS-001', 'November 26, 2021, 11:12 pm', 'December 21, 2021, 3:37 am'),
(17, 'EIS-001', 'November 27, 2021, 12:39 am', 'December 21, 2021, 3:37 am'),
(18, 'EIS-005', 'November 27, 2021, 12:43 am', 'November 27, 2021, 12:43 am'),
(19, 'EIS-004', 'November 27, 2021, 6:40 pm', 'November 27, 2021, 6:49 pm'),
(20, 'EIS-004', 'November 26, 2021, 11:12 pm', 'November 27, 2021, 12:43 am'),
(21, 'EIS-001', 'November 30, 2021, 11:31 am', 'December 21, 2021, 3:37 am'),
(22, 'EIS-002', 'November 30, 2021, 11:32 am', 'November 30, 2021, 11:35 am'),
(23, 'EIS-001', 'December 1, 2021, 12:14 am', 'December 21, 2021, 3:37 am'),
(25, 'EIS-002', 'December 1, 2021, 12:20 am', 'December 1, 2021, 12:22 am'),
(26, 'EIS-001', 'December 5, 2021, 5:35 pm', 'December 5, 2021, 5:39 pm'),
(27, 'EIS-002', 'December 5, 2021, 5:36 pm', 'December 5, 2021, 5:39 pm'),
(28, 'EIS-001', 'December 12, 2021, 12:05 am', 'December 21, 2021, 3:37 am'),
(29, 'EIS-003', 'December 21, 2021, 12:10 am', 'December 21, 2021, 3:42 am'),
(32, 'EIS-002', 'December 21, 2021, 3:36 am', 'December 21, 2021, 3:41 am'),
(33, 'EIS-001', 'December 21, 2021, 3:39 am', 'December 21, 2021, 3:40 am');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(200) NOT NULL,
  `deduction_code` varchar(50) NOT NULL,
  `deduction_name` varchar(100) NOT NULL,
  `deduction_type` varchar(100) NOT NULL,
  `deduction_percentage` varchar(100) NOT NULL,
  `pay_scale` varchar(100) NOT NULL,
  `posted_by` varchar(200) NOT NULL,
  `posted_timestamp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `deduction_code`, `deduction_name`, `deduction_type`, `deduction_percentage`, `pay_scale`, `posted_by`, `posted_timestamp`) VALUES
(2, '3251', 'Tax on Income', 'Income Tax', '11', 'BPS 08', 'admin', 'December 10, 2021, 8:36 pm'),
(5, '3301', 'Group Insurance', 'Insurance', '5', 'BPS 05', 'admin', 'December 12, 2021, 2:43 am'),
(6, '3301', 'Group Insurance', 'Insurance', '4', 'BPS 06', 'admin', 'December 18, 2021, 6:55 pm'),
(7, '3251', 'Tax on Income', 'Income Tax', '6', 'BPS 05', 'admin', 'December 18, 2021, 8:38 pm'),
(8, '3251', 'Tax on Income', 'Income Tax', '6', 'BPS 06', 'admin', 'November 1, 2021, 6:58 pm');

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
(4, '3220', 'General Accounts', '', 'Visible'),
(9, '1234', 'Human Resource', '', 'Visible');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(230) NOT NULL,
  `designation_name` varchar(100) NOT NULL,
  `pay_scale` varchar(100) NOT NULL,
  `basic_salary` varchar(100) NOT NULL,
  `allowed_leaves` int(20) DEFAULT NULL,
  `paid_leave_charges` varchar(50) NOT NULL,
  `enrolled_employees` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation_name`, `pay_scale`, `basic_salary`, `allowed_leaves`, `paid_leave_charges`, `enrolled_employees`) VALUES
(3, 'Supervisor', 'BPS 05', '20000.00', 2, '1500.00', ''),
(5, 'Accountant', 'BPS 06', '30000.00', 2, '2000.00', ''),
(6, 'Clerk', 'BPS 05', '26000.00', NULL, '', ''),
(7, 'Administrator', 'BPS 08', '80000.00', 2, '3000.00', '');

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
  `allowances` varchar(100) NOT NULL,
  `deductions` varchar(250) DEFAULT NULL,
  `profile_picture` varchar(100) NOT NULL,
  `registered_by` varchar(100) NOT NULL,
  `registered_at` varchar(100) NOT NULL,
  `last_edit_by` varchar(100) NOT NULL,
  `last_edit_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `username`, `employeeID`, `full_name`, `education`, `department`, `designation`, `pay_scale`, `allowances`, `deductions`, `profile_picture`, `registered_by`, `registered_at`, `last_edit_by`, `last_edit_at`) VALUES
(10, 'admin', 'EIS-001', 'M. Touqeer', 'PHD. Computer Science', 'General Accounts', 'Administrator', 'BPS 08', ',,', '', '../assets/img/profilePictures/touqeer.jpg', 'Touqeer Ahmad', 'November 23, 2021, 5:35 pm', 'admin', 'November 29, 2021, 4:43 pm'),
(19, 'awais', 'EIS-002', 'Awais Qarni', 'BS Computer Science', 'Human Resource', 'Supervisor', 'BPS 05', '0021,0031', '3301,3251', '../assets/img/profilePictures/awais.png', 'admin', 'November 29, 2021, 5:05 pm', 'admin', 'December 19, 2021, 5:21 pm'),
(20, 'naveed', 'EIS-003', 'Naveed Ahmad', 'M.Phil Chemistry', 'General Accounts', 'Accountant', 'BPS 06', ',0021,0031,0041', ',3301,3251,,,', '../assets/img/profilePictures/IMG_20201006_185852.jpg', 'admin', 'November 29, 2021, 5:09 pm', 'admin', 'December 19, 2021, 11:10 pm');

-- --------------------------------------------------------

--
-- Table structure for table `leaves_requests`
--

CREATE TABLE `leaves_requests` (
  `id` int(200) NOT NULL,
  `request_id` varchar(200) NOT NULL,
  `employeeID` varchar(100) NOT NULL,
  `no_of_leaves` int(50) NOT NULL,
  `leaves_from` varchar(50) NOT NULL,
  `leaves_to` varchar(50) NOT NULL,
  `report_back_date` varchar(50) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `request_status` varchar(50) NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `supervision_by` varchar(50) NOT NULL,
  `supervision_timestamp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leaves_requests`
--

INSERT INTO `leaves_requests` (`id`, `request_id`, `employeeID`, `no_of_leaves`, `leaves_from`, `leaves_to`, `report_back_date`, `leave_type`, `reason`, `request_status`, `remarks`, `supervision_by`, `supervision_timestamp`) VALUES
(5, 'LR001', 'EIS-002', 1, 'December 01, 2021', 'December 01, 2021', 'December 02, 2021', 'Casual Leave', 'wedding function', 'Rejected', 'too much leaves this month', 'admin', 'November 30, 2021, 11:23 pm'),
(6, 'LR002', 'EIS-002', 1, 'December 01, 2021', 'December 01, 2021', 'December 02, 2021', 'Paid Leave', 'wedding function', 'Approved', 'paid', 'admin', 'November 30, 2021, 11:23 pm'),
(7, 'LR003', 'EIS-002', 2, 'December 04, 2021', 'December 05, 2021', 'December 06, 2021', 'Casual Leave', 'wedding', 'Rejected', 'it will be paid.. make another request', 'admin', 'December 3, 2021, 11:51 pm'),
(8, 'LR004', 'EIS-002', 2, 'December 06, 2021', 'December 07, 2021', 'December 08, 2021', 'Casual Leave', 'wedding function', 'Rejected', 'it will be paid leave only', 'admin', 'December 5, 2021, 5:41 pm'),
(9, 'LR005', 'EIS-002', 2, 'December 06, 2021', 'December 07, 2021', 'December 08, 2021', 'Paid Leave', 'wedding function', 'Approved', 'ok', 'admin', 'December 5, 2021, 5:41 pm'),
(10, 'LR006', 'EIS-002', 1, 'December 06, 2021', 'December 07, 2021', 'December 08, 2021', 'Casual Leave', 'd', '', '', '', ''),
(12, 'LR007', 'EIS-003', 17, 'December 19, 2021', 'December 20, 2021', 'December 21, 2021', 'Emergency Leave', 'on medical gorunds', 'Approved', '', 'admin', 'December 20, 2021, 6:49 pm');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(250) NOT NULL,
  `payment_reference_no` varchar(240) NOT NULL,
  `paid_to` varchar(240) NOT NULL,
  `paid_amount` varchar(240) NOT NULL,
  `paid_allowances` varchar(240) NOT NULL,
  `paid_allowances_amount` varchar(240) NOT NULL,
  `paid_deductions` varchar(240) NOT NULL,
  `paid_deductions_amount` varchar(240) NOT NULL,
  `payment_made_by` varchar(100) NOT NULL,
  `payment_timestamp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_reference_no`, `paid_to`, `paid_amount`, `paid_allowances`, `paid_allowances_amount`, `paid_deductions`, `paid_deductions_amount`, `payment_made_by`, `payment_timestamp`) VALUES
(9, 'EISDP1681221800', 'EIS-003', '41200.00', '0031,0021,0041', '16200.00', '3301,3251', '5000.00', 'admin', 'December 21, 2021, 3:42 am');

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
  `account_status` varchar(200) NOT NULL,
  `remarks` varchar(240) NOT NULL DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `username`, `password_hash`, `full_name`, `designation`, `contact_no`, `email`, `access_level`, `account_status`, `remarks`) VALUES
(5, 'admin', '$2y$10$To5QW2qqlKqrsalu4Bydj.I2djBHOHZASXf6QLRXVabxUops4EOBa', 'M. Touqeer', 'Administrator', '0301-7064021', 'mc190401547@vu.edu.pk', 'ADMIN', 'ACTIVE', 'email updated'),
(69, 'awais', '$2y$10$QouXgSeQKVXztkxLMXgDnO/FuXtcLaC06Div4fdo4.NVBmeVIcstS', 'Awais Qarni', 'Supervisor', '0300-1234567', 'awais@gmail.com', 'USER', 'ACTIVE', ''),
(70, 'naveed', '$2y$10$LiwzWZgEzrdP0XFK8LEARuP8VSfOqRWrqRZL34nMZ/F6UV00xEHJ6', 'Naveed Ahmad', 'Accountant', '0300-1234567', 'naveed@gmail.com', 'USER', 'ACTIVE', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_sheet`
--
ALTER TABLE `attendance_sheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `leaves_requests`
--
ALTER TABLE `leaves_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
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
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `attendance_sheet`
--
ALTER TABLE `attendance_sheet`
  MODIFY `id` int(240) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(240) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(230) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(230) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `leaves_requests`
--
ALTER TABLE `leaves_requests`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
