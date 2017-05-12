-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 12, 2017 at 03:35 AM
-- Server version: 5.6.33
-- PHP Version: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lending_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `english_books`
--

CREATE TABLE `english_books` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(200) NOT NULL,
  `author_name` varchar(200) NOT NULL,
  `old_number` varchar(20) NOT NULL,
  `book_rate` float(7,2) NOT NULL,
  `is_multiple` varchar(10) NOT NULL,
  `multiple_data` varchar(500) DEFAULT NULL,
  `is_active` varchar(10) NOT NULL DEFAULT 'yes',
  `book_language` varchar(20) NOT NULL DEFAULT 'english',
  `book_category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `english_books`
--

INSERT INTO `english_books` (`book_id`, `book_name`, `author_name`, `old_number`, `book_rate`, `is_multiple`, `multiple_data`, `is_active`, `book_language`, `book_category`) VALUES
(9, 'harry potter', 'zyxqq', '3235', 500.00, 'no', NULL, 'yes', 'english', 'old');

-- --------------------------------------------------------

--
-- Table structure for table `lend_book`
--

CREATE TABLE `lend_book` (
  `lb_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `advance_paid` int(11) NOT NULL,
  `balance_amount` int(11) NOT NULL,
  `balance_given` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lend_booklist`
--

CREATE TABLE `lend_booklist` (
  `lbl_id` int(11) NOT NULL,
  `lb_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_language` varchar(30) NOT NULL,
  `book_category` varchar(50) NOT NULL,
  `book_rate` int(11) NOT NULL,
  `lending_rate` int(11) NOT NULL,
  `lending_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `nick_name` varchar(30) NOT NULL,
  `address` varchar(500) NOT NULL,
  `deposit_amount` float(7,2) NOT NULL,
  `membership_amount` float(7,2) NOT NULL,
  `join_date` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `member_name`, `phone_number`, `nick_name`, `address`, `deposit_amount`, `membership_amount`, `join_date`, `status`) VALUES
(9, 'ramu', '1234', '', 'qwerty', 500.00, 200.00, '2016-11-05', ''),
(10, 'roni', '2434', '', 'ad', 900.00, 400.00, '2016-11-17', '');

-- --------------------------------------------------------

--
-- Table structure for table `tamil_books`
--

CREATE TABLE `tamil_books` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(200) NOT NULL,
  `author_name` varchar(200) NOT NULL,
  `old_number` varchar(20) NOT NULL,
  `book_rate` float(7,2) NOT NULL,
  `is_multiple` varchar(10) NOT NULL,
  `multiple_data` varchar(500) DEFAULT NULL,
  `is_active` varchar(10) NOT NULL DEFAULT 'yes',
  `book_language` varchar(20) NOT NULL DEFAULT 'tamil',
  `book_category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `english_books`
--
ALTER TABLE `english_books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `book_id` (`book_id`);

--
-- Indexes for table `lend_book`
--
ALTER TABLE `lend_book`
  ADD PRIMARY KEY (`lb_id`),
  ADD UNIQUE KEY `lb_id` (`lb_id`);

--
-- Indexes for table `lend_booklist`
--
ALTER TABLE `lend_booklist`
  ADD PRIMARY KEY (`lbl_id`),
  ADD UNIQUE KEY `lbl_id` (`lbl_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `member_id` (`member_id`);

--
-- Indexes for table `tamil_books`
--
ALTER TABLE `tamil_books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `english_books`
--
ALTER TABLE `english_books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `lend_book`
--
ALTER TABLE `lend_book`
  MODIFY `lb_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lend_booklist`
--
ALTER TABLE `lend_booklist`
  MODIFY `lbl_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tamil_books`
--
ALTER TABLE `tamil_books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
