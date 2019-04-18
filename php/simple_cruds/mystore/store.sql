-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2013 at 05:33 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: 'store'
--

-- --------------------------------------------------------

--
-- Table structure for table 'category'
--

DROP TABLE IF EXISTS category;
CREATE TABLE category (
  category_id int(11) NOT NULL AUTO_INCREMENT,
  category_name varchar(50) NOT NULL,
  PRIMARY KEY (category_id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'category'
--

INSERT INTO category (category_id, category_name) VALUES(1, 'Hardwere');
INSERT INTO category (category_id, category_name) VALUES(2, 'Softwere');
INSERT INTO category (category_id, category_name) VALUES(3, 'others');

-- --------------------------------------------------------

--
-- Table structure for table 'products'
--

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  product_id int(11) NOT NULL,
  category_id int(11) NOT NULL,
  product_name varchar(50) NOT NULL,
  description text,
  total_unit int(11) NOT NULL,
  unit_price int(11) NOT NULL,
  product_image varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'products'
--

INSERT INTO products (product_id, category_id, product_name, description, total_unit, unit_price, product_image) VALUES(1, 1, 'HP Laptop', 'Processor Dual Core 3.06GHz, Harddisk 320GB, RAM 2.00GB', 5, 25000, 'images/laptop.jpeg');
INSERT INTO products (product_id, category_id, product_name, description, total_unit, unit_price, product_image) VALUES(2, 1, 'Canon Digital Camera', 'It has high resulation image capturing capability. ', 5, 10000, 'images/sonny.jpeg');
INSERT INTO products (product_id, category_id, product_name, description, total_unit, unit_price, product_image) VALUES(3, 1, 'SAMSUNG Galaxy note-2', 'You can do everything..', 5, 15000, 'images/galaxy.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table 'user'
--

DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  username varchar(15) NOT NULL,
  user_pass varchar(15) NOT NULL,
  user_fullname varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'user'
--

INSERT INTO user (username, user_pass, user_fullname) VALUES('admin', 'admin', 'Md. Bablu Mia');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('', '', '');
INSERT INTO user (username, user_pass, user_fullname) VALUES('admin', 'admin', 'admin');
