-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 11, 2024 at 05:55 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apartment_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`, `phone_number`) VALUES
(1, 'Abhyudith', '12345', 'abhyudith@gmail.com', '9742911000');

-- --------------------------------------------------------

--
-- Table structure for table `apartment`
--

DROP TABLE IF EXISTS `apartment`;
CREATE TABLE IF NOT EXISTS `apartment` (
  `apartment_id` int NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) NOT NULL,
  `unit_number` varchar(10) NOT NULL,
  `owner_id` int NOT NULL,
  PRIMARY KEY (`apartment_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `apartment`
--

INSERT INTO `apartment` (`apartment_id`, `building_name`, `unit_number`, `owner_id`) VALUES
(1, 'Prestige Shantiniketan', 'A1', 1),
(2, 'Salarpuria Sattva Greenage', 'B2', 2),
(3, 'Sobha Silicon Oasis', 'C3', 3),
(4, 'Brigade Millennium', 'D4', 4),
(5, 'Purva Riviera', 'E5', 5);

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

DROP TABLE IF EXISTS `complaint`;
CREATE TABLE IF NOT EXISTS `complaint` (
  `complaint_id` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `tenant_id` int DEFAULT NULL,
  `owner_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  PRIMARY KEY (`complaint_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `owner_id` (`owner_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`complaint_id`, `description`, `tenant_id`, `owner_id`, `employee_id`) VALUES
(9, 'HELLO', 12, NULL, 4),
(10, 'This is a complaint regarding the water supply, Kindly Fix the Connection at the earliest', 12, NULL, 5),
(11, 'n;kvafd;fvn', 14, NULL, 5),
(12, 'Water Shortage at Room 101, Please Look into it.', 15, NULL, 5),
(13, 'Water Shortage at Room 101, Please Look into it.', 15, NULL, 5),
(14, 'Electricity issue', 17, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE IF NOT EXISTS `complaints` (
  `complaint_id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int DEFAULT NULL,
  `complaint_text` text,
  `complaint_date` date DEFAULT NULL,
  `tenant_id` int DEFAULT NULL,
  PRIMARY KEY (`complaint_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `admin_id` int DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `owner_id` int DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `admin_id` (`admin_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `first_name`, `last_name`, `email`, `phone_number`, `admin_id`, `username`, `password`, `owner_id`, `name`) VALUES
(5, 'Sandhya', 'Prithvi', 'sprithvi@gmail.com', '9739550101', NULL, 'sprithvi', '12345', NULL, ''),
(12, 'Anurag', 'Patil', 'anup@gmail.com', '9743879428', NULL, 'anup003', '12345', NULL, ''),
(11, 'Kenneth', 'Oswin', 'kenosw@gmail.com', '3472893457', NULL, 'ko', '12345', NULL, ''),
(9, 'Ezekiel', 'David', 'ezewdavid@gmail.com', '7483985955', NULL, 'eze', 'eze12345', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

DROP TABLE IF EXISTS `enquiries`;
CREATE TABLE IF NOT EXISTS `enquiries` (
  `enquiry_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `enquiry_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`enquiry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`enquiry_id`, `name`, `email`, `contact`, `enquiry_date`) VALUES
(1, 'Abhishek', 'abhis@gmail.com', '9873425353', '2024-02-27 04:03:43'),
(14, 'Sanjay', 'sanjay@gmail.com', '9933321354', '2024-03-17 14:52:59'),
(3, 'Sheldon', 'sheldoncoop@gmail.com', '1231231234', '2024-03-17 13:31:01'),
(15, 'Abhyu', 'abhyudith@gmail.com', '97634454533', '2024-03-25 05:29:16');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE IF NOT EXISTS `hotel` (
  `building_id` int NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) NOT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_payment`
--

DROP TABLE IF EXISTS `maintenance_payment`;
CREATE TABLE IF NOT EXISTS `maintenance_payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `service_name` varchar(255) NOT NULL,
  `fee_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `service_id` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `maintenance_payment`
--

INSERT INTO `maintenance_payment` (`payment_id`, `tenant_id`, `amount_paid`, `payment_date`, `service_id`, `service_name`, `fee_amount`) VALUES
(1, 1, 0.01, '2024-02-18', NULL, '', 0.00),
(2, 1, 0.02, '2024-02-18', NULL, '', 0.00),
(3, 12, 50.00, '2024-02-22', 1, '', 0.00),
(4, 14, 70.00, '2024-02-23', 3, '', 0.00),
(5, 12, 60.00, '2024-02-23', 2, '', 0.00),
(6, 12, 40.00, '2024-02-23', 4, '', 0.00),
(7, NULL, 100.00, '2024-02-23', 2, '', 0.00),
(8, 12, 50.00, '2024-02-23', 1, '', 0.00),
(9, 14, 80.00, '2024-02-26', 5, '', 0.00),
(10, 15, 50.00, '2024-02-26', 1, '', 0.00),
(11, 1, 100.00, '2024-02-27', 1, '0', 50.00),
(12, 15, 60.00, '2024-03-17', 2, '', 0.00),
(13, 16, 40.00, '2024-03-17', 4, '', 0.00),
(14, 17, 70.00, '2024-03-18', 3, '', 0.00),
(15, 17, 1.00, '2024-03-18', 1, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

DROP TABLE IF EXISTS `owner`;
CREATE TABLE IF NOT EXISTS `owner` (
  `owner_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `admin_id` int DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`owner_id`),
  UNIQUE KEY `username` (`username`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `first_name`, `last_name`, `email`, `phone_number`, `admin_id`, `username`, `password`) VALUES
(6, 'Sandhya', 'Prithvi', 'sandhyaprithvi@gmail.com', '9739550101', 1, 'sandhya', '12345'),
(8, 'zz', 'aaaaabhyu', 'abhyu@gmail.com', '87878787', 1, 'abhyu', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

DROP TABLE IF EXISTS `parking`;
CREATE TABLE IF NOT EXISTS `parking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `parking_slot` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `employee_id`, `parking_slot`) VALUES
(1, 5, '4'),
(2, 5, '6'),
(3, 5, '6'),
(4, 5, '6'),
(5, 5, '6'),
(6, 5, '5'),
(7, 5, '4'),
(8, 5, '2'),
(9, 5, '11'),
(10, 5, '3'),
(11, 5, '4'),
(12, 5, '2'),
(13, 5, '3'),
(14, 5, '6');

-- --------------------------------------------------------

--
-- Table structure for table `parking_slot`
--

DROP TABLE IF EXISTS `parking_slot`;
CREATE TABLE IF NOT EXISTS `parking_slot` (
  `parking_slot_id` int NOT NULL AUTO_INCREMENT,
  `slot_number` int NOT NULL,
  `owner_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  PRIMARY KEY (`parking_slot_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parking_slot`
--

INSERT INTO `parking_slot` (`parking_slot_id`, `slot_number`, `owner_id`, `employee_id`) VALUES
(1, 1, 6, NULL),
(2, 2, 6, NULL),
(3, 3, 6, NULL),
(4, 5, 6, NULL),
(5, 11, 7, NULL),
(6, 10, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `room_id` int NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) NOT NULL,
  `unit_number` int NOT NULL,
  `owner_id` int DEFAULT NULL,
  `total_flats` int DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `building_name`, `unit_number`, `owner_id`, `total_flats`) VALUES
(1, 'RV', 1, 1, 70),
(2, 'Mantri Pinacle', 100, 6, 70),
(3, 'Brigade Millenium', 101, 7, 70);

-- --------------------------------------------------------

--
-- Table structure for table `salary_requests`
--

DROP TABLE IF EXISTS `salary_requests`;
CREATE TABLE IF NOT EXISTS `salary_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int DEFAULT NULL,
  `current_salary` decimal(10,2) DEFAULT NULL,
  `requested_increment` decimal(10,2) DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `salary_requests`
--

INSERT INTO `salary_requests` (`id`, `employee_id`, `current_salary`, `requested_increment`, `reason`) VALUES
(1, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL),
(11, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL),
(15, NULL, NULL, NULL, NULL),
(16, NULL, NULL, NULL, NULL),
(17, NULL, NULL, NULL, NULL),
(18, NULL, NULL, NULL, NULL),
(19, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  `fee_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `fee_amount`) VALUES
(1, 'Plumbing Repair', 50.00),
(2, 'Electrical Maintenance', 60.00),
(3, 'HVAC Service', 70.00),
(4, 'Pest Control', 40.00),
(5, 'Appliance Repair', 80.00);

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

DROP TABLE IF EXISTS `service_requests`;
CREATE TABLE IF NOT EXISTS `service_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `requested_time` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `service_id` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`request_id`, `tenant_id`, `service_id`, `requested_time`, `status`) VALUES
(9, 15, 1, '0000-00-00 00:00:00', 'Approved'),
(10, 16, 4, '0000-00-00 00:00:00', 'Approved'),
(11, 16, 2, '0000-00-00 00:00:00', 'Approved'),
(12, 15, 5, '0000-00-00 00:00:00', ''),
(13, 17, 1, '0000-00-00 00:00:00', 'Approved'),
(14, 17, 1, '0000-00-00 00:00:00', ''),
(15, 21, 1, '0000-00-00 00:00:00', ''),
(16, 15, 2, '0000-00-00 00:00:00', ''),
(17, 16, 2, '0000-00-00 00:00:00', 'Approved'),
(18, 17, 4, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

DROP TABLE IF EXISTS `tenant`;
CREATE TABLE IF NOT EXISTS `tenant` (
  `tenant_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `age` int NOT NULL,
  `dob` date NOT NULL,
  `owner_id` int DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`tenant_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_id`, `first_name`, `last_name`, `email`, `phone_number`, `age`, `dob`, `owner_id`, `username`, `password`) VALUES
(17, 'Ankit', 'Raj', 'rajankit1364@gmail.com', '3787583754', 20, '2003-11-29', 5, '', ''),
(15, 'Vijay', 'Kumar', 'lucky123@gmail.com', '9873632347', 10, '2014-07-16', 5, '', ''),
(16, 'Murali', 'Bharadhwaj', 'sandhyaprithvi@gmail.com', '9972611000', 47, '1975-10-29', 10, '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
