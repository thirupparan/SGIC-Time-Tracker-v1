-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 21, 2019 at 04:28 AM
-- Server version: 8.0.16
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgic-user`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `deleteUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser` (IN `u_c_id` INT(11))  BEGIN   
           DELETE FROM user_company WHERE user_company_id = u_c_id;  
           END$$

DROP PROCEDURE IF EXISTS `insertUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUser` (IN `user_id_company` INT(11), `company_name` INT(11), `recruited_date` DATE, `work_role` VARCHAR(100), `Contract_Period` VARCHAR(100))  BEGIN  
                INSERT INTO user_company(user_id, company_id,recruited_date,working_status,work_role,Contract_Period) VALUES (user_id_company, company_name,recruited_date,'Working',work_role,Contract_Period);   
                END$$

DROP PROCEDURE IF EXISTS `selectUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `selectUser` (IN `u_id` INT(11))  BEGIN  
      SELECT  oc.company_name,uc.recruited_date,uc.working_status,uc.user_company_id,uc.work_role,uc.contract_period
      FROM USER_COMPANY uc JOIN out_source_company oc 
      ON uc.company_id = oc.company_id 
      WHERE user_id=u_id ORDER BY user_company_id DESC; 
      END$$

DROP PROCEDURE IF EXISTS `updateUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUser` (IN `u_c_id` INT(11), `company_name` INT(11), `recruited_date1` DATE, `work_role1` VARCHAR(100), `Contract_Period1` VARCHAR(100))  BEGIN   
                UPDATE user_company SET company_id = company_name, recruited_date = recruited_date1,work_role = work_role1,Contract_Period = Contract_Period1
                WHERE user_company_id = u_c_id;  
                END$$

DROP PROCEDURE IF EXISTS `whereUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `whereUser` (IN `u_company_id` INT(11))  BEGIN   
      SELECT * FROM USER_COMPANY WHERE user_company_id = u_company_id;  
      END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `out_source_company`
--

DROP TABLE IF EXISTS `out_source_company`;
CREATE TABLE IF NOT EXISTS `out_source_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_name` (`company_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_status` enum('In_progress','Finished') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

DROP TABLE IF EXISTS `pwdreset`;
CREATE TABLE IF NOT EXISTS `pwdreset` (
  `pwdResetId` int(11) NOT NULL AUTO_INCREMENT,
  `pwdResetEmail` text COLLATE utf8_unicode_ci NOT NULL,
  `pwdResetSelector` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pwdResetToken` longtext COLLATE utf8_unicode_ci NOT NULL,
  `pwdResetExpires` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pwdResetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL,
  `user_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_status`) VALUES
(18, 'thirupparan', 'thirupparan1994@gmail.com', '$2y$10$W8xM9cwWrI6MmP15mxUP7OgkHFqB/leEmXF5VXKdHnmfexbhwGL2u', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

DROP TABLE IF EXISTS `user_company`;
CREATE TABLE IF NOT EXISTS `user_company` (
  `user_company_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `recruited_date` date NOT NULL,
  `working_status` enum('Working','Not_working') COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_period` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`profile_id`, `user_id`, `first_name`, `last_name`, `address`, `contact_number`, `photo`) VALUES
(8, 18, 'paran123', 'shanmuganathan', '																																																																																																																																																								sgic																																												', '0778368806', '6fc84d975a1d3ec9c0fd76241d4436ba.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`, `role_status`) VALUES
(1, 'Admin', 'Active'),
(2, 'HR', 'Active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
