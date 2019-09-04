-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2019 at 02:07 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamer_kids_taxi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banktransactions`
--

CREATE TABLE `tbl_banktransactions` (
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `payable` bigint(20) UNSIGNED NOT NULL,
  `paid` bigint(20) UNSIGNED NOT NULL,
  `touch_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` char(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `state_code` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `bank_state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `bank_state_code` int(11) NOT NULL DEFAULT '-10000',
  `bank_trace_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `banek_rrn` bigint(20) NOT NULL DEFAULT '0',
  `bank_refrence_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `merchant_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `web_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `transaction_reference` binary(16) NOT NULL,
  `bank_token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_banktransactions`
--

INSERT INTO `tbl_banktransactions` (`transaction_id`, `order_id`, `user_id`, `payable`, `paid`, `touch_date`, `ip_address`, `state`, `state_code`, `bank_state`, `bank_state_code`, `bank_trace_no`, `banek_rrn`, `bank_refrence_no`, `merchant_id`, `web_address`, `user_pan`, `transaction_reference`, `bank_token`) VALUES
(42, 0, 1234, 10250, 0, '2019-09-04 04:55:16', '178.239.158.4', 'PayFailed', 5, 'Canceled By User', -1, '0', 0, '', 11475043, '', '', 0x11e9ceaa29f4a8a2a161aec13034fa80, 'Tig6Fno2K6PFa7RmAIJlZiNZbDW/cStr8MyIv+9f+9b4cNhArrMmu7ythN8B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_banktransactions`
--
ALTER TABLE `tbl_banktransactions`
  ADD PRIMARY KEY (`transaction_id`) USING BTREE,
  ADD UNIQUE KEY `UNIQ_9C409CBFED84D250` (`transaction_reference`) USING BTREE,
  ADD KEY `order_index` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_banktransactions`
--
ALTER TABLE `tbl_banktransactions`
  MODIFY `transaction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
