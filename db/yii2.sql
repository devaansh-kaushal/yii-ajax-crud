-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2022 at 07:54 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_student` (IN `name` VARCHAR(50), IN `fees` INT(10), IN `email` VARCHAR(100), IN `profile_pic` VARCHAR(200))  NO SQL
BEGIN

DECLARE outid int;

INSERT student VALUES (NULL,name,fees,email,profile_pic);

SELECT LAST_INSERT_ID() as outid;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_student` (IN `stid` INT(20))  NO SQL
BEGIN 

DELETE FROM student WHERE id = stid;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_student` (IN `stid` INT(20), IN `stname` VARCHAR(50), IN `stfees` INT(20), IN `stemail` VARCHAR(50), IN `stprofilepic` VARCHAR(150))  NO SQL
BEGIN

DECLARE outid int;

SET @outid := 0;

SELECT @outid := stid as outid;

UPDATE student
SET name = stname,fees = stfees,email = stemail,profile_pic = stprofilepic WHERE id = stid;

SELECT @outid;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `fees` int(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `fees`, `email`, `profile_pic`) VALUES
(2, 'devanushu', 20, 'shark@shark.com', 'hey'),
(8, 'devanu', 123, 'tar@tar.com', 'asf'),
(9, 'divya bhatt', 123, '23132a1sd', 'asdasd'),
(10, 'asdasd', 123, 'tar@tar.co', 'asd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
