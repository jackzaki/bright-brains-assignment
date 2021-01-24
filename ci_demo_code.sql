-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2021 at 08:23 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_demo_code`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `uniquecode` varchar(32) NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_date` datetime NOT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `uniquecode`, `creationdate`, `last_login_date`, `username`, `email`, `password`, `gender`, `profile_pic`) VALUES
(1, '5b204eb1fcb1a6c8b000b53a842e894b', '2018-10-23 16:26:26', '0000-00-00 00:00:00', 'superadmin', 'admin@example.com', '$2y$10$nuS7wFkNSCPixXwyFXq70uLm1DzZTX9AmxYUjhpRFoh/AbdCNw3I6', 'Male', 'f97a2b6f773e3e9f343b9989dc5a5d44.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(15) UNSIGNED NOT NULL,
  `uniquecode` varchar(32) NOT NULL,
  `user_id` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `status` enum('Inactive','Active') NOT NULL DEFAULT 'Inactive',
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastupdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `uniquecode`, `user_id`, `name`, `price`, `color`, `picture`, `status`, `creationdate`, `lastupdate`) VALUES
(1, '4932b1914e3986def5cf85a76634b254', '5f064cd65e5208b7c60a148f1130693e', 'Faith Norton', '361', 'Pariatur Et ea magn', '82c40d396fed716acd771b275739e87b.jpg', 'Inactive', '2021-01-23 19:06:00', '2021-01-23 19:06:00'),
(2, '95a4d659cd498f8fd4bf41ade7817251', '5f064cd65e5208b7c60a148f1130693e', 'Sybil Burks', '259', 'Consequatur officia', '31099f8678da0e266486797ba768d009.jpg', 'Active', '2021-01-23 19:06:13', '2021-01-23 19:06:13'),
(3, '752da5caea79a48e29f5efd2633130e5', 'd87ce4dc8f5ea70d6ac67ad9768e34a8', 'Melanie Knight', '408', 'Obcaecati nemo sed e', 'e041d6afd39e5ec63d4a69ace784cfc0.jpg', 'Active', '2021-01-23 19:06:47', '2021-01-23 19:06:47'),
(4, 'ab3f89de97e925a0e90487ddc44c511c', 'd87ce4dc8f5ea70d6ac67ad9768e34a8', 'Evan Davidson', '495', 'Aliquid impedit dol', '8d6867cfd81d89e6bd0c241acc57462d.jpg', 'Inactive', '2021-01-23 19:06:57', '2021-01-23 19:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `deposit_int` int(11) DEFAULT NULL,
  `payment_int` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `deposit_int`, `payment_int`) VALUES
(1, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uniquecode` varchar(32) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `mobile` varchar(20) DEFAULT NULL,
  `verify_code` varchar(50) DEFAULT '',
  `verify_time` datetime DEFAULT NULL,
  `is_verify` enum('0','1') NOT NULL DEFAULT '0',
  `country` varchar(100) DEFAULT NULL,
  `country_code` varchar(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `profile_pic` varchar(50) DEFAULT NULL,
  `pin` varchar(50) DEFAULT NULL,
  `sales_code` varchar(50) NOT NULL DEFAULT '',
  `status` enum('Active','Inactive','Delete') NOT NULL DEFAULT 'Inactive',
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastupdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uniquecode`, `full_name`, `email`, `password`, `gender`, `mobile`, `verify_code`, `verify_time`, `is_verify`, `country`, `country_code`, `currency`, `profile_pic`, `pin`, `sales_code`, `status`, `creationdate`, `lastupdate`) VALUES
(1, 'ffc91fdbcf5ef2640a39570c5fe42c25', 'majy@mailinator.com', 'zexihaxyky@mailinator.com', '$2y$10$k/TETIiJU2jCA47Ya3a10OzoiwdjaSq/Mztutx0hadezE3eFDCm5u', 'Female', '+1 (883) 873-3693', '34f8cbba7bcca4e2c5c22c5e9b81eeba', '2021-01-24 00:33:37', '0', 'in', '91', NULL, NULL, NULL, '', 'Active', '2021-01-23 19:03:37', '2021-01-23 19:03:37'),
(2, '5f064cd65e5208b7c60a148f1130693e', 'godami', 'weni@mailinator.com', '$2y$10$yDEAJjOvDVNL6Sfv.hgvHubKALK8ysBZgTtvaWHVsMV72UivqGEAK', 'Male', '+1 (701) 319-5916', 'c47d2f93dfb8eaadaeb4880c7cdbe082', '2021-01-24 00:33:48', '0', 'in', '91', NULL, NULL, NULL, '', 'Active', '2021-01-23 19:03:48', '2021-01-23 19:03:48'),
(3, 'd87ce4dc8f5ea70d6ac67ad9768e34a8', 'jemo', 'womota@mailinator.com', '$2y$10$jqi.OuWiCUuPXZ8Dh7oCmugRFjobyej3DWWjemw/bngO1Rcjvr2yy', 'Female', '+1 (738) 479-5911', 'c08bb33475e0b7bbd811c45dde02b91c', '2021-01-24 00:34:00', '0', 'in', '91', NULL, NULL, NULL, '', 'Active', '2021-01-23 19:04:00', '2021-01-23 19:04:00'),
(4, '4a2f6faba53499bb34c5bccdf555fc10', 'xika', 'cihipa@mailinator.com', '$2y$10$lwP1yHAb4gvaBcf5M4dJDun9nR8O.ut7cdt15iQ7PDXnapcDRUAgG', 'Male', '+1 (666) 788-2638', 'c648ff8cd5a6eb55ac69ccfa86cf544b', '2021-01-24 00:34:10', '0', 'in', '91', NULL, NULL, NULL, '', 'Active', '2021-01-23 19:04:10', '2021-01-23 19:04:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `creationdate` (`creationdate`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
