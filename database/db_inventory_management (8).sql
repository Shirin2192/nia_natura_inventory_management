-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 01:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attribute_master`
--

CREATE TABLE `tbl_attribute_master` (
  `id` int(11) NOT NULL,
  `fk_product_type_id` int(11) DEFAULT NULL,
  `attribute_name` varchar(100) DEFAULT NULL,
  `attribute_type` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attribute_master`
--

INSERT INTO `tbl_attribute_master` (`id`, `fk_product_type_id`, `attribute_name`, `attribute_type`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'Flavour', 'dropdown', 1, '1', '2025-03-28 06:34:52', '2025-03-28 10:27:33'),
(2, 1, 'Bottle Size', 'dropdown', 1, '1', '2025-03-28 06:35:19', '2025-03-28 06:35:19'),
(3, 1, 'Bottle Type', 'dropdown', 1, '1', '2025-03-28 06:35:45', '2025-03-28 10:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attribute_values`
--

CREATE TABLE `tbl_attribute_values` (
  `id` int(11) NOT NULL,
  `fk_attribute_id` int(11) DEFAULT NULL,
  `attribute_value` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attribute_values`
--

INSERT INTO `tbl_attribute_values` (`id`, `fk_attribute_id`, `attribute_value`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'Neem', 1, '1', '2025-04-01 09:12:26', '2025-04-01 10:03:41'),
(2, 1, 'Tulsi', 1, '1', '2025-04-01 09:13:42', '2025-04-01 09:13:42'),
(3, 1, 'Himalayan', 1, '1', '2025-04-01 09:14:02', '2025-04-11 10:25:14'),
(4, 1, 'Ajwain', 1, '1', '2025-04-01 09:14:18', '2025-04-01 09:14:18'),
(5, 1, 'Acacia', 1, '1', '2025-04-01 09:14:57', '2025-04-01 09:14:57'),
(6, 1, 'Multiflora', 1, '1', '2025-04-01 09:15:08', '2025-04-01 09:15:08'),
(7, 1, 'Raw Organic', 1, '1', '2025-04-01 09:15:19', '2025-04-01 09:15:19'),
(8, 1, 'Forest', 1, '1', '2025-04-01 09:15:35', '2025-04-01 09:15:35'),
(9, 1, 'Natural Pure', 1, '1', '2025-04-01 09:16:13', '2025-04-01 09:16:13'),
(10, 1, 'Jamun', 1, '1', '2025-04-01 09:16:30', '2025-04-01 09:16:30'),
(11, 1, 'SIDR', 1, '1', '2025-04-01 09:16:43', '2025-04-01 09:16:43'),
(12, 1, 'Kashmir White', 1, '1', '2025-04-01 09:17:02', '2025-04-01 09:17:02'),
(13, 1, 'Eucalyptus', 1, '1', '2025-04-01 09:17:22', '2025-04-01 09:17:22'),
(14, 1, 'Rose Wood', 1, '1', '2025-04-01 09:17:38', '2025-04-01 09:17:38'),
(15, 1, 'Litchi', 1, '1', '2025-04-01 09:18:02', '2025-04-01 09:18:02'),
(16, 2, '250 g', 1, '1', '2025-04-01 16:36:05', '2025-04-11 15:05:57'),
(17, 2, '125 g', 1, '1', '2025-04-01 16:36:17', '2025-04-11 14:55:17'),
(18, 2, '500 g', 1, '1', '2025-04-01 16:36:26', '2025-04-01 16:36:26'),
(19, 3, 'Glass', 1, '1', '2025-04-01 16:36:39', '2025-04-01 16:36:39'),
(20, 3, 'Plastic', 1, '1', '2025-04-01 16:36:50', '2025-04-01 16:36:50'),
(21, 2, '400 g', 1, '1', '2025-04-11 14:55:30', '2025-04-11 14:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `id` int(11) NOT NULL,
  `fk_role_id` int(11) DEFAULT NULL,
  `fk_sidebar_id` int(11) DEFAULT NULL,
  `can_view` tinyint(1) DEFAULT 0,
  `can_add` tinyint(1) DEFAULT 0,
  `can_edit` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0,
  `has_access` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_permissions`
--

INSERT INTO `tbl_permissions` (`id`, `fk_role_id`, `fk_sidebar_id`, `can_view`, `can_add`, `can_edit`, `can_delete`, `has_access`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 0, 0, 1, '2025-04-06 18:20:57', '2025-04-15 17:30:45'),
(2, 1, 2, 1, 1, 1, 0, 0, '2025-04-06 18:20:57', '2025-04-15 17:30:45'),
(3, 1, 3, 1, 1, 1, 1, 0, '2025-04-06 18:20:57', '2025-04-07 12:29:59'),
(4, 1, 4, 1, 1, 1, 1, 0, '2025-04-06 18:20:57', '2025-04-07 12:44:17'),
(5, 1, 5, 1, 1, 1, 1, 0, '2025-04-06 18:20:57', '2025-04-07 12:57:44'),
(6, 1, 6, 1, 1, 1, 1, 0, '2025-04-06 18:20:57', '2025-04-06 18:20:57'),
(7, 1, 7, 1, 1, 1, 1, 0, '2025-04-06 18:20:57', '2025-04-07 16:45:36'),
(8, 1, 8, 1, 1, 1, 1, 0, '2025-04-06 18:20:57', '2025-04-06 18:20:57'),
(9, 1, 9, 1, 1, 1, 1, 0, '2025-04-06 18:20:57', '2025-04-06 18:20:57'),
(10, 3, 1, 0, 0, 0, 0, 1, '2025-04-06 18:24:39', '2025-04-06 18:24:39'),
(11, 3, 3, 1, 0, 0, 0, 0, '2025-04-06 18:24:40', '2025-04-06 18:24:40'),
(12, 3, 4, 1, 0, 0, 0, 0, '2025-04-06 18:24:40', '2025-04-06 18:24:40'),
(13, 3, 5, 1, 0, 0, 0, 0, '2025-04-06 18:24:40', '2025-04-06 18:24:40'),
(14, 3, 6, 1, 0, 0, 0, 0, '2025-04-06 18:24:40', '2025-04-06 18:24:40'),
(15, 3, 7, 1, 0, 0, 0, 0, '2025-04-06 18:24:40', '2025-04-06 18:24:40'),
(16, 3, 8, 1, 0, 0, 0, 0, '2025-04-06 18:24:40', '2025-04-06 18:24:40'),
(17, 2, 1, 0, 0, 0, 0, 1, '2025-04-07 10:55:50', '2025-04-07 10:55:50'),
(18, 2, 3, 1, 1, 1, 1, 0, '2025-04-07 10:55:50', '2025-04-07 10:55:50'),
(19, 2, 4, 1, 1, 1, 1, 0, '2025-04-07 10:55:50', '2025-04-07 10:55:50'),
(20, 2, 5, 1, 1, 1, 1, 0, '2025-04-07 10:55:50', '2025-04-07 10:55:50'),
(21, 2, 6, 1, 1, 1, 1, 0, '2025-04-07 10:55:50', '2025-04-07 10:55:50'),
(22, 2, 7, 1, 1, 1, 1, 0, '2025-04-07 10:55:50', '2025-04-07 10:55:50'),
(23, 2, 8, 1, 1, 1, 1, 0, '2025-04-07 10:55:50', '2025-04-07 10:55:50'),
(24, 1, 10, 1, 0, 0, 0, 0, '2025-04-15 17:29:42', '2025-04-15 17:29:42'),
(25, 2, 10, 1, 0, 0, 0, 0, '2025-04-15 17:31:14', '2025-04-15 17:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_attributes`
--

CREATE TABLE `tbl_product_attributes` (
  `id` bigint(20) NOT NULL,
  `fk_product_id` int(11) NOT NULL,
  `fk_product_types_id` int(11) NOT NULL,
  `fk_attribute_id` int(11) NOT NULL,
  `fk_attribute_value_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_attributes`
--

INSERT INTO `tbl_product_attributes` (`id`, `fk_product_id`, `fk_product_types_id`, `fk_attribute_id`, `fk_attribute_value_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(2, 1, 1, 2, 16, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(3, 1, 1, 3, 19, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(4, 2, 1, 1, 2, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(5, 2, 1, 2, 16, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(6, 2, 1, 3, 19, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(7, 3, 1, 1, 3, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(8, 3, 1, 2, 16, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(9, 3, 1, 3, 19, 1, '2025-04-14 11:09:34', '2025-04-14 11:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_batches`
--

CREATE TABLE `tbl_product_batches` (
  `id` bigint(20) NOT NULL,
  `fk_product_id` int(11) DEFAULT NULL,
  `batch_no` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `manufactured_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_batches`
--

INSERT INTO `tbl_product_batches` (`id`, `fk_product_id`, `batch_no`, `quantity`, `expiry_date`, `manufactured_date`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'BATCH001', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-04-14 11:09:33', '2025-04-14 11:09:33'),
(2, 2, 'BATCH001', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(3, 3, 'BATCH001', 0, '2025-12-31', '2025-01-01', 1, '1', '2025-04-14 11:09:34', '2025-04-17 11:41:38'),
(4, 3, 'BATCH002', 100, '2025-11-17', '2025-04-15', 1, '1', '2025-04-17 11:41:38', '2025-04-17 11:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_inventory`
--

CREATE TABLE `tbl_product_inventory` (
  `id` bigint(20) NOT NULL,
  `fk_login_id` bigint(20) DEFAULT NULL,
  `fk_product_id` int(11) DEFAULT NULL,
  `fk_batch_id` int(11) DEFAULT NULL,
  `channel_type` varchar(100) DEFAULT NULL,
  `fk_sale_channel_id` int(11) DEFAULT NULL,
  `add_quantity` int(11) DEFAULT NULL,
  `deduct_quantity` int(11) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `reason` longtext DEFAULT NULL,
  `used_status` int(11) DEFAULT NULL,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_inventory`
--

INSERT INTO `tbl_product_inventory` (`id`, `fk_login_id`, `fk_product_id`, `fk_batch_id`, `channel_type`, `fk_sale_channel_id`, `add_quantity`, `deduct_quantity`, `total_quantity`, `reason`, `used_status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 'Online', 1, 50, NULL, 50, NULL, 1, '1', '2025-04-14 05:39:34', '2025-04-14 05:39:34'),
(2, NULL, 2, 2, 'Online', 1, 50, NULL, 50, NULL, 0, '0', '2025-04-14 05:39:34', '2025-04-16 12:04:25'),
(3, NULL, 3, 3, 'Online', 1, 50, NULL, 50, NULL, 0, '0', '2025-04-14 05:39:34', '2025-04-16 10:36:34'),
(4, NULL, 3, 3, 'Online', 1, NULL, 1, 49, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(5, NULL, 3, 3, 'Online', 1, NULL, 1, 48, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(6, NULL, 3, 3, 'Online', 1, NULL, 1, 47, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(7, NULL, 3, 3, 'Online', 1, NULL, 1, 46, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(8, NULL, 3, 3, 'Online', 1, NULL, 1, 45, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(9, NULL, 3, 3, 'Online', 1, NULL, 1, 44, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(10, NULL, 3, 3, 'Online', 1, NULL, 1, 43, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(11, NULL, 3, 3, 'Online', 1, NULL, 1, 42, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(12, NULL, 3, 3, 'Online', 1, NULL, 1, 41, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:34'),
(13, NULL, 3, 3, 'Online', 1, NULL, 1, 40, NULL, 0, '0', '2025-04-16 10:36:34', '2025-04-16 10:36:35'),
(14, NULL, 3, 3, 'Online', 1, NULL, 1, 39, NULL, 0, '0', '2025-04-16 10:36:35', '2025-04-16 10:42:50'),
(15, NULL, 3, 3, 'Online', 1, NULL, 1, 38, NULL, 0, '0', '2025-04-16 10:36:35', '2025-04-16 10:41:39'),
(16, NULL, 3, 3, 'Online', 1, NULL, 1, 37, NULL, 0, '0', '2025-04-16 10:41:39', '2025-04-16 10:41:40'),
(17, NULL, 3, 3, 'Online', 1, NULL, 1, 36, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(18, NULL, 3, 3, 'Online', 1, NULL, 1, 35, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(19, NULL, 3, 3, 'Online', 1, NULL, 1, 34, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(20, NULL, 3, 3, 'Online', 1, NULL, 1, 33, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(21, NULL, 3, 3, 'Online', 1, NULL, 1, 32, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(22, NULL, 3, 3, 'Online', 1, NULL, 1, 31, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(23, NULL, 3, 3, 'Online', 1, NULL, 1, 30, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(24, NULL, 3, 3, 'Online', 1, NULL, 1, 29, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(25, NULL, 3, 3, 'Online', 1, NULL, 1, 28, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:41:40'),
(26, NULL, 3, 3, 'Online', 1, NULL, 1, 27, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:42:50'),
(27, NULL, 3, 3, 'Online', 1, NULL, 1, 26, NULL, 0, '0', '2025-04-16 10:41:40', '2025-04-16 10:42:50'),
(28, NULL, 3, 3, 'Online', 1, NULL, 1, 25, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(29, NULL, 3, 3, 'Online', 1, NULL, 1, 24, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(30, NULL, 3, 3, 'Online', 1, NULL, 1, 23, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(31, NULL, 3, 3, 'Online', 1, NULL, 1, 22, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(32, NULL, 3, 3, 'Online', 1, NULL, 1, 21, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(33, NULL, 3, 3, 'Online', 1, NULL, 1, 20, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(34, NULL, 3, 3, 'Online', 1, NULL, 1, 19, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(35, NULL, 3, 3, 'Online', 1, NULL, 1, 18, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(36, NULL, 3, 3, 'Online', 1, NULL, 1, 17, NULL, 0, '0', '2025-04-16 10:42:50', '2025-04-16 10:42:50'),
(37, NULL, 3, 3, 'Online', 1, NULL, 1, 16, NULL, 0, '0', '2025-04-16 10:42:51', '2025-04-16 10:42:51'),
(38, NULL, 3, 3, 'Online', 1, NULL, 1, 15, NULL, 0, '0', '2025-04-16 10:42:51', '2025-04-16 10:42:51'),
(39, NULL, 3, 3, 'Online', 1, NULL, 1, 14, NULL, 0, '0', '2025-04-16 10:42:51', '2025-04-16 11:42:10'),
(40, NULL, 3, 3, 'Online', 1, NULL, 1, 13, NULL, 0, '0', '2025-04-16 11:42:10', '2025-04-16 11:42:10'),
(41, NULL, 3, 3, 'Online', 1, NULL, 1, 12, NULL, 0, '0', '2025-04-16 11:42:10', '2025-04-16 11:42:10'),
(42, NULL, 3, 3, 'Online', 1, NULL, 1, 11, NULL, 0, '0', '2025-04-16 11:42:10', '2025-04-16 11:42:10'),
(43, NULL, 3, 3, 'Online', 1, NULL, 1, 10, NULL, 0, '0', '2025-04-16 11:42:10', '2025-04-16 11:42:10'),
(44, NULL, 3, 3, 'Online', 1, NULL, 1, 9, NULL, 0, '0', '2025-04-16 11:42:10', '2025-04-16 11:42:10'),
(45, NULL, 3, 3, 'Online', 1, NULL, 1, 8, NULL, 0, '0', '2025-04-16 11:42:10', '2025-04-16 11:42:11'),
(46, NULL, 3, 3, 'Online', 1, NULL, 1, 7, NULL, 0, '0', '2025-04-16 11:42:11', '2025-04-16 11:42:11'),
(47, NULL, 3, 3, 'Online', 1, NULL, 1, 6, NULL, 0, '0', '2025-04-16 11:42:11', '2025-04-16 11:42:11'),
(48, NULL, 3, 3, 'Online', 1, NULL, 1, 5, NULL, 0, '0', '2025-04-16 11:42:11', '2025-04-16 11:42:11'),
(49, NULL, 3, 3, 'Online', 1, NULL, 1, 4, NULL, 0, '0', '2025-04-16 11:42:11', '2025-04-16 11:42:11'),
(50, NULL, 3, 3, 'Online', 1, NULL, 1, 3, NULL, 0, '0', '2025-04-16 11:42:11', '2025-04-16 11:42:11'),
(51, NULL, 3, 3, 'Online', 1, NULL, 1, 2, NULL, 0, '0', '2025-04-16 11:42:11', '2025-04-16 11:43:50'),
(52, NULL, 3, 3, 'Online', 1, NULL, 1, 1, NULL, 0, '0', '2025-04-16 11:43:50', '2025-04-16 11:55:17'),
(54, NULL, 3, 3, 'Online', 1, NULL, 1, 0, NULL, 0, '0', '2025-04-16 11:55:17', '2025-04-17 11:41:38'),
(55, NULL, 2, 2, 'Online', 1, NULL, 1, 49, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(56, NULL, 2, 2, 'Online', 1, NULL, 1, 48, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(57, NULL, 2, 2, 'Online', 1, NULL, 1, 47, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(58, NULL, 2, 2, 'Online', 1, NULL, 1, 46, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(59, NULL, 2, 2, 'Online', 1, NULL, 1, 45, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(60, NULL, 2, 2, 'Online', 1, NULL, 1, 44, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(61, NULL, 2, 2, 'Online', 1, NULL, 1, 43, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(62, NULL, 2, 2, 'Online', 1, NULL, 1, 42, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(63, NULL, 2, 2, 'Online', 1, NULL, 1, 41, NULL, 0, '0', '2025-04-16 12:04:25', '2025-04-16 12:04:25'),
(64, NULL, 2, 2, 'Online', 1, NULL, 1, 40, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(65, NULL, 2, 2, 'Online', 1, NULL, 1, 39, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(66, NULL, 2, 2, 'Online', 1, NULL, 1, 38, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(67, NULL, 2, 2, 'Online', 1, NULL, 1, 37, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(68, NULL, 2, 2, 'Online', 1, NULL, 1, 36, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(69, NULL, 2, 2, 'Online', 1, NULL, 1, 35, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(70, NULL, 2, 2, 'Online', 1, NULL, 1, 34, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(71, NULL, 2, 2, 'Online', 1, NULL, 1, 33, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(72, NULL, 2, 2, 'Online', 1, NULL, 1, 32, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(73, NULL, 2, 2, 'Online', 1, NULL, 1, 31, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(74, NULL, 2, 2, 'Online', 1, NULL, 1, 30, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(75, NULL, 2, 2, 'Online', 1, NULL, 1, 29, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(76, NULL, 2, 2, 'Online', 1, NULL, 1, 28, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:26'),
(77, NULL, 2, 2, 'Online', 1, NULL, 1, 27, NULL, 0, '0', '2025-04-16 12:04:26', '2025-04-16 12:04:27'),
(78, NULL, 2, 2, 'Online', 1, NULL, 1, 26, NULL, 0, '0', '2025-04-16 12:04:27', '2025-04-16 12:04:27'),
(79, NULL, 2, 2, 'Online', 1, NULL, 1, 25, NULL, 0, '0', '2025-04-16 12:04:27', '2025-04-16 12:04:27'),
(80, NULL, 2, 2, 'Online', 1, NULL, 1, 24, NULL, 0, '0', '2025-04-16 12:04:27', '2025-04-16 12:04:27'),
(81, NULL, 2, 2, 'Online', 1, NULL, 1, 23, NULL, 0, '0', '2025-04-16 12:04:27', '2025-04-16 12:04:27'),
(82, NULL, 2, 2, 'Online', 1, NULL, 1, 22, NULL, 0, '0', '2025-04-16 12:04:27', '2025-04-16 12:04:27'),
(83, NULL, 2, 2, 'Online', 1, NULL, 1, 21, NULL, 0, '0', '2025-04-16 12:04:27', '2025-04-16 12:04:27'),
(84, NULL, 2, 2, 'Online', 1, NULL, 1, 20, NULL, 1, '1', '2025-04-16 12:04:27', '2025-04-16 12:04:27'),
(85, NULL, 3, 4, 'Online', 1, 100, NULL, 100, NULL, 1, '1', '2025-04-17 11:41:38', '2025-04-17 11:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_master`
--

CREATE TABLE `tbl_product_master` (
  `id` bigint(20) NOT NULL,
  `fk_stock_availability_id` int(11) DEFAULT NULL,
  `fk_product_types_id` bigint(20) DEFAULT NULL,
  `product_name` longtext DEFAULT NULL,
  `product_sku_code` varchar(100) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `images` longtext DEFAULT NULL,
  `barcode` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_master`
--

INSERT INTO `tbl_product_master` (`id`, `fk_stock_availability_id`, `fk_product_types_id`, `product_name`, `product_sku_code`, `description`, `images`, `barcode`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Neem', '3', 'Sample description', 'img_67fcecede4f68.jpg,img_67fcecede52ad.jpg,img_67fcecede5578.jpg,img_67fcecede5907.jpg,img_67fcecede5c89.jpg', '987654321', 1, '1', '2025-04-14 11:09:33', '2025-04-14 11:09:33'),
(2, 1, 1, 'Tulsi', '4', 'Sample description', 'img_67fcecee49751.jpg,img_67fcecee49a19.jpg,img_67fcecee49cfe.jpg,img_67fcecee4a048.jpg,img_67fcecee4a4aa.jpg,img_67fcecee4a83d.jpg', '987654322', 1, '1', '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(3, 1, 1, 'Himalayan', '5', 'Sample description', 'img_67fceceebfd78.jpg,img_67fceceec06c9.jpg,img_67fceceec1200.jpg,img_67fceceec17a8.jpg,img_67fceceec1cdc.jpg,img_67fceceec228f.jpg', '987654323', 1, '1', '2025-04-14 11:09:34', '2025-04-14 11:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_price`
--

CREATE TABLE `tbl_product_price` (
  `id` bigint(20) NOT NULL,
  `fk_product_id` int(11) DEFAULT NULL,
  `fk_batch_id` bigint(20) DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `MRP` double DEFAULT NULL,
  `selling_price` double DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_price`
--

INSERT INTO `tbl_product_price` (`id`, `fk_product_id`, `fk_batch_id`, `purchase_price`, `MRP`, `selling_price`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 60, 120, 100, 1, '1', '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(2, 2, 2, 60, 120, 100, 1, '1', '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(3, 3, 3, 60, 120, 100, 1, '1', '2025-04-14 11:09:34', '2025-04-14 11:09:34'),
(4, 3, 4, 100, 200, 150, 1, '1', '2025-04-17 11:41:38', '2025-04-17 11:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_types`
--

CREATE TABLE `tbl_product_types` (
  `id` int(11) NOT NULL,
  `product_type_name` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_types`
--

INSERT INTO `tbl_product_types` (`id`, `product_type_name`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Honey', 1, '1', '2025-03-28 04:47:30', '2025-03-28 05:46:04'),
(2, 'Seeds', 1, '0', '2025-03-28 04:47:49', '2025-04-10 03:56:03'),
(3, 'eee', 1, '0', '2025-04-08 08:34:18', '2025-04-08 08:35:39'),
(4, 'A  S', 1, '0', '2025-04-09 09:50:25', '2025-04-09 09:50:33'),
(5, 'Seeds', 1, '1', '2025-04-10 03:56:09', '2025-04-10 03:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `id` bigint(20) NOT NULL,
  `role_name` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `role_name`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Account Owner', 1, '1', '2025-03-24 04:29:20', '2025-04-07 05:55:21'),
(2, 'Inventory Manager', 1, '1', '2025-03-24 04:29:20', '2025-03-24 04:29:20'),
(3, 'Staff', 1, '1', '2025-03-24 04:29:20', '2025-03-24 04:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_channel`
--

CREATE TABLE `tbl_sale_channel` (
  `id` bigint(20) NOT NULL,
  `channel_type` varchar(100) DEFAULT NULL,
  `sale_channel` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sale_channel`
--

INSERT INTO `tbl_sale_channel` (`id`, `channel_type`, `sale_channel`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Online', 'Amazon', 1, '1', '2025-03-25 03:59:32', '2025-04-01 05:14:20'),
(2, 'Online', 'Flipkart', 1, '1', '2025-03-25 07:24:09', '2025-04-01 04:43:08'),
(3, 'Offline', 'Retail Store', 1, '1', '2025-03-25 07:24:17', '2025-04-07 06:34:25'),
(4, NULL, 'asss', 1, '0', '2025-04-08 08:54:08', '2025-04-10 04:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sidebar`
--

CREATE TABLE `tbl_sidebar` (
  `id` bigint(20) NOT NULL,
  `sidebar_name` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sidebar`
--

INSERT INTO `tbl_sidebar` (`id`, `sidebar_name`, `created_at`) VALUES
(1, 'Dashboard', '2025-04-06 13:46:33'),
(2, 'Staff', '2025-04-06 13:46:33'),
(3, 'Product Type', '2025-04-06 13:46:33'),
(4, 'Product Attribute', '2025-04-06 13:46:33'),
(5, 'Product Attribute Value', '2025-04-06 13:47:35'),
(6, 'Sale Channel', '2025-04-06 13:47:35'),
(7, 'Product', '2025-04-06 13:47:35'),
(8, 'Order Detail', '2025-04-06 13:53:58'),
(9, 'Role and Access', '2025-04-06 13:53:58'),
(10, 'Inventory', '2025-04-15 17:19:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sku_code_master`
--

CREATE TABLE `tbl_sku_code_master` (
  `id` bigint(20) NOT NULL,
  `sku_code` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sku_code_master`
--

INSERT INTO `tbl_sku_code_master` (`id`, `sku_code`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'NN-KA-125', 1, '1', '2025-04-11 12:13:12', '2025-04-11 14:52:18'),
(2, 'NN-KA-400', 1, '1', '2025-04-11 12:15:19', '2025-04-11 14:53:54'),
(3, 'NN-NH-250', 1, '1', '2025-04-14 11:59:37', '2025-04-14 11:59:37'),
(4, 'NN-TH-250', 1, '1', '2025-04-14 11:59:38', '2025-04-14 11:59:38'),
(5, 'NN-HH-250', 1, '1', '2025-04-14 12:20:24', '2025-04-14 12:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_availability`
--

CREATE TABLE `tbl_stock_availability` (
  `id` bigint(20) NOT NULL,
  `stock_availability` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_stock_availability`
--

INSERT INTO `tbl_stock_availability` (`id`, `stock_availability`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'In Stock', 1, '1', '2025-03-24 04:30:59', '2025-03-24 04:30:59'),
(2, 'Out Of Stock', 1, '1', '2025-03-24 04:30:59', '2025-03-24 04:30:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `fk_role_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `email`, `password`, `fk_role_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Admin Admin', 'admin@admin.com', 'YkpnZDA3Vis4YXJmcnh4VXRzeE5jdz09', 1, 1, '1', '2025-03-24 00:08:50', '2025-03-27 06:46:07'),
(2, 'Inventory Manager', 'inventorymanager@gmail.com', 'WkpTcGFCQy8yVk1ENHR1VlJBTTJRQT09', 2, 1, '1', '2025-03-26 12:40:37', '2025-03-26 12:40:37'),
(3, 'Staff Staff', 'Staff@gmail.com', 'WkpTcGFCQy8yVk1ENHR1VlJBTTJRQT09', 3, 1, '1', '2025-03-27 06:59:38', '2025-03-27 06:59:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attribute_master`
--
ALTER TABLE `tbl_attribute_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_product_type_id`,`attribute_name`,`attribute_type`);

--
-- Indexes for table `tbl_attribute_values`
--
ALTER TABLE `tbl_attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_attribute_id`,`attribute_value`);

--
-- Indexes for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_role_id`,`fk_sidebar_id`,`can_view`,`can_add`,`can_edit`,`can_delete`),
  ADD KEY `has_access` (`has_access`);

--
-- Indexes for table `tbl_product_attributes`
--
ALTER TABLE `tbl_product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_batches`
--
ALTER TABLE `tbl_product_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_product_id`,`batch_no`,`quantity`,`expiry_date`,`manufactured_date`);

--
-- Indexes for table `tbl_product_inventory`
--
ALTER TABLE `tbl_product_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_product_id`,`fk_sale_channel_id`,`add_quantity`,`deduct_quantity`,`total_quantity`),
  ADD KEY `fk_batch_id` (`fk_batch_id`);

--
-- Indexes for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_stock_availability_id`,`product_sku_code`);

--
-- Indexes for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_id` (`fk_product_id`),
  ADD KEY `id` (`id`,`purchase_price`,`MRP`,`selling_price`);

--
-- Indexes for table `tbl_product_types`
--
ALTER TABLE `tbl_product_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`product_type_name`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`role_name`);

--
-- Indexes for table `tbl_sale_channel`
--
ALTER TABLE `tbl_sale_channel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`sale_channel`);

--
-- Indexes for table `tbl_sidebar`
--
ALTER TABLE `tbl_sidebar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sku_code_master`
--
ALTER TABLE `tbl_sku_code_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`sku_code`);

--
-- Indexes for table `tbl_stock_availability`
--
ALTER TABLE `tbl_stock_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`stock_availability`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`name`,`email`,`fk_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attribute_master`
--
ALTER TABLE `tbl_attribute_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_attribute_values`
--
ALTER TABLE `tbl_attribute_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_product_attributes`
--
ALTER TABLE `tbl_product_attributes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_product_batches`
--
ALTER TABLE `tbl_product_batches`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product_inventory`
--
ALTER TABLE `tbl_product_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product_types`
--
ALTER TABLE `tbl_product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sale_channel`
--
ALTER TABLE `tbl_sale_channel`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_sidebar`
--
ALTER TABLE `tbl_sidebar`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_sku_code_master`
--
ALTER TABLE `tbl_sku_code_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_stock_availability`
--
ALTER TABLE `tbl_stock_availability`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
