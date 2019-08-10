-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2019 at 06:15 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verisoft-sandesh-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_message`
--

CREATE TABLE `tb_message` (
  `id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `contacts` varchar(1000) NOT NULL,
  `message` varchar(500) NOT NULL,
  `tb_user_id` int(11) NOT NULL,
  `purpose` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_message`
--

INSERT INTO `tb_message` (`id`, `date`, `contacts`, `message`, `tb_user_id`, `purpose`) VALUES
(1, '2019-04-09', '1234567890,9807654321', 'I am testing the message', 10001, 'Testing'),
(2, '2019-08-09', '1234567890,9876543210', 'I am testing', 10001, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `firmName` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `messagesLeft` int(11) NOT NULL DEFAULT '0',
  `messagesSent` int(11) NOT NULL DEFAULT '0',
  `daysRemaining` int(11) NOT NULL DEFAULT '0',
  `renewalDate` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `firmName`, `email`, `messagesLeft`, `messagesSent`, `daysRemaining`, `renewalDate`) VALUES
(10001, 'demo firm name', 'demo@gmail.com', 16, 204, 394, '12/12/2020');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_message`
--
ALTER TABLE `tb_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_message_tb_user_idx` (`tb_user_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_message`
--
ALTER TABLE `tb_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_message`
--
ALTER TABLE `tb_message`
  ADD CONSTRAINT `fk_tb_message_tb_user` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
