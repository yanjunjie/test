-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2019 at 02:58 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `Mobile` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Website` varchar(50) NOT NULL,
  `ContactName` varchar(50) NOT NULL,
  `Address` text NOT NULL,
  `City` varchar(50) NOT NULL,
  `PostalCode` varchar(20) NOT NULL,
  `Country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `CustomerName`, `Mobile`, `Email`, `Website`, `ContactName`, `Address`, `City`, `PostalCode`, `Country`) VALUES
(1, 'Masud Rana', '01739191910', 'masudvpi@gmail.com', '', '', '', '', '', 'Bangladesh'),
(2, 'Kamrul Islam', '01739191911', 'kamrulislam@gmail.com', 'www.kamrulislam.com', '', '', 'Kurigram', '5600', 'Soudiarabia'),
(3, 'Ariful Islam', '01739191912', 'arifulislam@gmail.com', 'www.arifulislam.com', '', '', 'Kurigram', '5600', 'Soudiarabia'),
(4, 'Foysal Mahmud', '01739191913', 'foysalmahmud@gmail.com', 'www.foysalmahmud.com', 'Foysal', '', 'Comilla', '3500', 'Bangladesh'),
(5, 'Kartic', '01739191914', 'kartik12@gmail.com', 'www.kartik12.com', '', '', 'Kolkata', '5800', 'India'),
(6, 'Shamim Islam', '01739191916', 'arifulislam@gmail.com', 'www.shamimislam.com', '', '', 'Karachi', '5700', 'Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `ShipperID` int(11) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustomerID`, `EmployeeID`, `ShipperID`, `OrderDate`) VALUES
(1, 1, 1, 1, '2019-02-24 12:45:57'),
(2, 2, 1, 2, '2019-02-24 12:45:57'),
(3, 3, 2, 3, '2019-02-24 12:46:22'),
(4, 2, 3, 2, '2019-02-24 12:46:22'),
(5, 4, 5, 5, '2019-02-24 12:46:58'),
(6, 4, 3, 6, '2019-02-24 12:46:58'),
(7, 6, 5, 7, '2019-02-24 12:47:22'),
(8, 6, 5, 4, '2019-02-24 12:47:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
