-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 15, 2016 at 08:04 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lending_library`
--
CREATE DATABASE IF NOT EXISTS `lending_library` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lending_library`;

-- --------------------------------------------------------

--
-- Table structure for table `lend_book`
--

CREATE TABLE IF NOT EXISTS `lend_book` (
  `lb_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `advance_paid` int(11) NOT NULL,
  `balance_amount` int(11) NOT NULL,
  `balance_given` int(11) NOT NULL,
  PRIMARY KEY (`lb_id`),
  UNIQUE KEY `lb_id` (`lb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lend_booklist`
--

CREATE TABLE IF NOT EXISTS `lend_booklist` (
  `lbl_id` int(11) NOT NULL AUTO_INCREMENT,
  `lb_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_language` varchar(30) NOT NULL,
  `book_category` varchar(50) NOT NULL,
  `book_rate` int(11) NOT NULL,
  `lending_rate` int(11) NOT NULL,
  `lending_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`lbl_id`),
  UNIQUE KEY `lbl_id` (`lbl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
