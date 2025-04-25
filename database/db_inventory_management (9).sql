-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 01:52 PM
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
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_attributes`
--

INSERT INTO `tbl_product_attributes` (`id`, `fk_product_id`, `fk_product_types_id`, `fk_attribute_id`, `fk_attribute_value_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 7, 1, '1', '2025-04-21 10:46:06', '2025-04-21 10:46:06'),
(2, 1, 1, 2, 16, 1, '1', '2025-04-21 10:46:06', '2025-04-21 10:46:06'),
(3, 1, 1, 3, 19, 1, '1', '2025-04-21 10:46:06', '2025-04-21 10:46:06'),
(4, 2, 1, 1, 1, 1, '1', '2025-04-25 05:09:28', '2025-04-25 05:09:28'),
(5, 2, 1, 2, 16, 1, '1', '2025-04-25 05:09:28', '2025-04-25 05:09:28'),
(6, 2, 1, 3, 19, 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29'),
(7, 3, 1, 1, 2, 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29'),
(8, 3, 1, 2, 16, 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29'),
(9, 3, 1, 3, 19, 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29'),
(10, 4, 1, 1, 3, 1, '1', '2025-04-25 05:09:30', '2025-04-25 05:09:30'),
(11, 4, 1, 2, 16, 1, '1', '2025-04-25 05:09:30', '2025-04-25 05:09:30'),
(12, 4, 1, 3, 19, 1, '1', '2025-04-25 05:09:30', '2025-04-25 05:09:30');

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
(1, 1, 'Batch-NN-RO-250-01', 100, '2026-02-21', '2025-03-01', 1, '1', '2025-04-21 10:46:06', '2025-04-21 10:46:06'),
(2, 2, 'BATCH001', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-04-25 05:09:28', '2025-04-25 05:09:28'),
(3, 3, 'BATCH001', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29'),
(4, 4, 'BATCH001', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29');

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
(1, NULL, 1, 1, 'Online', 1, 100, NULL, 100, NULL, 1, '1', '2025-04-21 10:46:06', '2025-04-21 10:46:06'),
(2, 1, 2, 2, 'Online', 1, 50, NULL, 50, NULL, 0, '0', '2025-04-25 05:09:28', '2025-04-25 06:21:28'),
(3, 1, 3, 3, 'Online', 1, 50, NULL, 50, NULL, 0, '0', '2025-04-25 05:09:29', '2025-04-25 06:21:30'),
(4, 1, 4, 4, 'Online', 1, 50, NULL, 50, NULL, 0, '0', '2025-04-25 05:09:30', '2025-04-25 06:21:32'),
(5, 1, 2, 2, 'Online', 1, NULL, 1, 49, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(6, 1, 2, 2, 'Online', 1, NULL, 1, 48, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(7, 1, 2, 2, 'Online', 1, NULL, 1, 47, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(8, 1, 2, 2, 'Online', 1, NULL, 1, 46, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(9, 1, 2, 2, 'Online', 2, NULL, 1, 45, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(10, 1, 2, 2, 'Online', 2, NULL, 1, 44, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(11, 1, 2, 2, 'Online', 2, NULL, 1, 43, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(12, 1, 2, 2, 'Online', 2, NULL, 1, 42, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:29'),
(13, 1, 2, 2, 'Online', 2, NULL, 1, 41, '', 0, '0', '2025-04-25 06:21:29', '2025-04-25 06:21:30'),
(14, 1, 2, 2, 'Online', 2, NULL, 1, 40, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(15, 1, 2, 2, 'Online', 2, NULL, 1, 39, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(16, 1, 2, 2, 'Online', 2, NULL, 1, 38, '', 1, '1', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(17, 1, 3, 3, 'Online', 2, NULL, 1, 49, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(18, 1, 3, 3, 'Online', 2, NULL, 1, 48, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(19, 1, 3, 3, 'Online', 2, NULL, 1, 47, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(20, 1, 3, 3, 'Online', 1, NULL, 1, 46, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(21, 1, 3, 3, 'Online', 1, NULL, 1, 45, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:30'),
(22, 1, 3, 3, 'Online', 1, NULL, 1, 44, '', 0, '0', '2025-04-25 06:21:30', '2025-04-25 06:21:31'),
(23, 1, 3, 3, 'Online', 1, NULL, 1, 43, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:31'),
(24, 1, 3, 3, 'Online', 1, NULL, 1, 42, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:31'),
(25, 1, 3, 3, 'Online', 1, NULL, 1, 41, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:31'),
(26, 1, 3, 3, 'Online', 1, NULL, 1, 40, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:31'),
(27, 1, 3, 3, 'Online', 1, NULL, 1, 39, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:31'),
(28, 1, 3, 3, 'Online', 1, NULL, 1, 38, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:31'),
(29, 1, 3, 3, 'Online', 1, NULL, 1, 37, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:31'),
(30, 1, 3, 3, 'Online', 1, NULL, 1, 36, '', 0, '0', '2025-04-25 06:21:31', '2025-04-25 06:21:32'),
(31, 1, 3, 3, 'Online', 1, NULL, 1, 35, '', 0, '0', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(32, 1, 3, 3, 'Online', 1, NULL, 1, 34, '', 0, '0', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(33, 1, 3, 3, 'Online', 1, NULL, 1, 33, '', 1, '1', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(34, 1, 4, 4, 'Online', 1, NULL, 1, 49, '', 0, '0', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(35, 1, 4, 4, 'Online', 1, NULL, 1, 48, '', 0, '0', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(36, 1, 4, 4, 'Online', 1, NULL, 1, 47, '', 0, '0', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(37, 1, 4, 4, 'Online', 1, NULL, 1, 46, '', 0, '0', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(38, 1, 4, 4, 'Online', 1, NULL, 1, 45, '', 0, '0', '2025-04-25 06:21:32', '2025-04-25 06:21:32'),
(39, 1, 4, 4, 'Online', 1, NULL, 1, 44, '', 0, '0', '2025-04-25 06:21:33', '2025-04-25 06:21:33'),
(40, 1, 4, 4, 'Online', 1, NULL, 1, 43, '', 0, '0', '2025-04-25 06:21:33', '2025-04-25 06:21:33'),
(41, 1, 4, 4, 'Online', 1, NULL, 1, 42, '', 0, '0', '2025-04-25 06:21:33', '2025-04-25 06:21:33'),
(42, 1, 4, 4, 'Online', 1, NULL, 1, 41, '', 0, '0', '2025-04-25 06:21:33', '2025-04-25 06:21:33'),
(43, 1, 4, 4, 'Online', 1, NULL, 1, 40, '', 0, '0', '2025-04-25 06:21:33', '2025-04-25 06:21:33'),
(44, 1, 4, 4, 'Online', 1, NULL, 1, 39, '', 0, '0', '2025-04-25 06:21:33', '2025-04-25 06:21:33'),
(45, 1, 4, 4, 'Online', 1, NULL, 1, 38, '', 0, '0', '2025-04-25 06:21:33', '2025-04-25 06:21:33'),
(46, 1, 4, 4, 'Online', 1, NULL, 1, 37, '', 1, '1', '2025-04-25 06:21:33', '2025-04-25 06:21:33');

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
(1, 1, 1, '100% Pure Organic Honey Raw 250g ', '6', 'Test Description', 'RawOrganic0612.jpg,RawOrganic0512.jpg,RawOrganic0412.jpg,RawOrganic0312.jpg,RawOrganic0212.jpg,RawOrganic0112.jpg', '1234344434', 1, '1', '2025-04-21 10:46:06', '2025-04-25 05:10:28'),
(2, 1, 1, 'Neem', '5', 'Sample description', 'img_680b19084bcdb.jpg,img_680b19084e439.jpg,img_680b190850627.jpg,img_680b19085618c.jpg,img_680b19085817f.jpg', '987654321', 1, '1', '2025-04-25 05:09:28', '2025-04-25 05:09:28'),
(3, 1, 1, 'Tulsi', '7', 'Sample description', 'img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg', '987654322', 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29'),
(4, 1, 1, 'Himalayan', '11', 'Sample description', 'img_680b1909b1b9c.jpg,img_680b1909b940e.jpg,img_680b1909bcaec.jpg,img_680b1909c054b.jpg,img_680b1909c33a4.jpg,img_680b1909c6a9a.jpg', '987654323', 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29');

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
(1, 1, 1, 600, 500, 450, 1, '1', '2025-04-21 10:46:06', '2025-04-21 10:46:06'),
(2, 2, 2, 60, 120, 100, 1, '1', '2025-04-25 05:09:28', '2025-04-25 05:09:28'),
(3, 3, 3, 60, 120, 100, 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29'),
(4, 4, 4, 60, 120, 100, 1, '1', '2025-04-25 05:09:29', '2025-04-25 05:09:29');

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
(1, 'NIA-ACACIA-250g', 1, '1', '2025-04-24 15:23:14', '2025-04-24 15:23:14'),
(2, 'NIA-ACACIA-500g', 1, '1', '2025-04-24 15:23:34', '2025-04-24 15:23:34'),
(3, 'NIA-RAWORGANIC-250g', 1, '1', '2025-04-24 15:26:23', '2025-04-24 15:26:23'),
(4, 'NIA-RAWORGANIC-500g', 1, '1', '2025-04-24 15:26:31', '2025-04-24 15:26:31'),
(5, 'NIA-NEEM-250g', 1, '1', '2025-04-24 15:26:50', '2025-04-24 15:26:50'),
(6, 'NIA-NEEM-500g', 1, '1', '2025-04-24 15:26:58', '2025-04-24 15:26:58'),
(7, 'NIA-TULSI-250g', 1, '1', '2025-04-24 15:27:18', '2025-04-24 15:27:18'),
(8, 'NIA-TULSI-500g', 1, '1', '2025-04-24 15:27:40', '2025-04-24 15:27:40'),
(9, 'NIA-MULTIFLORA-250g', 1, '1', '2025-04-24 15:28:17', '2025-04-24 15:28:17'),
(10, 'NIA-MULTIFLORA-500g', 1, '1', '2025-04-24 15:28:52', '2025-04-24 15:28:52'),
(11, 'NIA-HIMALAYAN-250g', 1, '1', '2025-04-24 15:29:39', '2025-04-24 15:29:39'),
(12, 'NIA-HIMALAYAN-500g', 1, '1', '2025-04-24 15:29:46', '2025-04-24 15:29:46'),
(13, 'NIA-AJWAIN-250g', 1, '1', '2025-04-24 15:30:23', '2025-04-24 15:30:23'),
(14, 'NIA-AJWAIN-500g', 1, '1', '2025-04-24 15:30:31', '2025-04-24 15:30:31'),
(15, 'NIA-FOREST-250g', 1, '1', '2025-04-24 15:30:51', '2025-04-24 15:30:51'),
(16, 'NIA-FOREST-500g', 1, '1', '2025-04-24 15:31:06', '2025-04-24 15:31:06'),
(17, 'NIA-SIDR-250g', 1, '1', '2025-04-24 15:35:59', '2025-04-24 15:35:59'),
(18, 'NIA-SIDR-500g', 1, '1', '2025-04-24 15:36:13', '2025-04-24 15:36:13'),
(19, 'NIA-JAMUN-250g', 1, '1', '2025-04-24 15:36:43', '2025-04-24 15:36:43'),
(20, 'NIA-JAMUN-500g', 1, '1', '2025-04-24 15:36:54', '2025-04-24 15:36:54'),
(21, 'NIA-NATURALPURE-250g', 1, '1', '2025-04-24 15:37:17', '2025-04-24 15:37:17'),
(22, 'NIA-NATURALPURE-500g', 1, '1', '2025-04-24 15:37:32', '2025-04-24 15:37:32'),
(23, 'NIA-KASHMIRWHITE-250g', 1, '1', '2025-04-24 15:38:46', '2025-04-24 15:38:46'),
(24, 'NIA-KASHMIRWHITE-500g', 1, '1', '2025-04-24 15:39:02', '2025-04-24 15:39:02'),
(25, 'NIA-EUCALYPTUS-250g', 1, '1', '2025-04-24 15:40:09', '2025-04-24 15:40:09'),
(26, 'NIA-EUCALYPTUS-500g', 1, '1', '2025-04-24 15:40:18', '2025-04-24 15:40:18'),
(27, 'NIA-ROSEWOOD-250g', 1, '1', '2025-04-24 15:41:33', '2025-04-24 15:41:33'),
(28, 'NIA-ROSEWOOD-500g', 1, '1', '2025-04-24 15:41:39', '2025-04-24 15:41:39'),
(29, 'NIA-LITCHI-250g', 1, '1', '2025-04-24 15:42:51', '2025-04-24 15:42:51'),
(30, 'NIA-LITCHI-500g', 1, '1', '2025-04-24 15:42:59', '2025-04-24 15:42:59');

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
(1, 'Admin Admins', 'admin@admin.com', 'YkpnZDA3Vis4YXJmcnh4VXRzeE5jdz09', 1, 1, '1', '2025-03-24 00:08:50', '2025-04-24 06:06:06'),
(2, 'Inventory Manager', 'inventorymanager@gmail.com', 'WkpTcGFCQy8yVk1ENHR1VlJBTTJRQT09', 2, 1, '1', '2025-03-26 12:40:37', '2025-03-26 12:40:37'),
(3, 'Staff Staff', 'Staff@gmail.com', 'WkpTcGFCQy8yVk1ENHR1VlJBTTJRQT09', 3, 1, '1', '2025-03-27 06:59:38', '2025-03-27 06:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_log`
--

CREATE TABLE `tbl_user_log` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `inserted_table` varchar(100) DEFAULT NULL,
  `inserted_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`inserted_data`)),
  `ip_address` varchar(100) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_log`
--

INSERT INTO `tbl_user_log` (`id`, `fk_user_id`, `action`, `inserted_table`, `inserted_data`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'Updated Staff Details', 'tbl_user', '{\"name\":\"Admin Admins\",\"fk_role_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 06:06:06'),
(2, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"5\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"images\":\"img_680b19084bcdb.jpg,img_680b19084e439.jpg,img_680b190850627.jpg,img_680b19085618c.jpg,img_680b19085817f.jpg\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:28'),
(3, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"BATCH001\",\"quantity\":\"50\",\"expiry_date\":\"2025-12-31\",\"manufactured_date\":\"2025-01-01\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:28'),
(4, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:28'),
(5, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:28'),
(6, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"7\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:29'),
(7, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"BATCH001\",\"quantity\":\"50\",\"expiry_date\":\"2025-12-31\",\"manufactured_date\":\"2025-01-01\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:29'),
(8, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:29'),
(9, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:29'),
(10, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"11\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"img_680b1909b1b9c.jpg,img_680b1909b940e.jpg,img_680b1909bcaec.jpg,img_680b1909c054b.jpg,img_680b1909c33a4.jpg,img_680b1909c6a9a.jpg\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:29'),
(11, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"BATCH001\",\"quantity\":\"50\",\"expiry_date\":\"2025-12-31\",\"manufactured_date\":\"2025-01-01\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:29'),
(12, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:29'),
(13, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 05:09:30'),
(14, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":49,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(15, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":48,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(16, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":47,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(17, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":46,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(18, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":45,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(19, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":44,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(20, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":43,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(21, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":42,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(22, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":41,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:29'),
(23, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":40,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(24, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":39,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(25, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":38,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(26, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":49,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(27, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":48,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(28, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":47,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(29, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":46,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(30, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":45,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(31, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":44,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:30'),
(32, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":43,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:31'),
(33, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":42,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:31'),
(34, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":41,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:31'),
(35, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":40,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:31'),
(36, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":39,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:31'),
(37, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":38,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:31'),
(38, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":37,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:31'),
(39, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":36,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(40, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":35,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(41, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":34,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(42, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":33,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(43, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":49,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(44, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":48,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(45, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":47,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(46, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":46,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(47, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":45,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:32'),
(48, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":44,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(49, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":43,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(50, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":42,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(51, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":41,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(52, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":40,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(53, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":39,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(54, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":38,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(55, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":37,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33');

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
-- Indexes for table `tbl_user_log`
--
ALTER TABLE `tbl_user_log`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_product_batches`
--
ALTER TABLE `tbl_product_batches`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product_inventory`
--
ALTER TABLE `tbl_product_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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

--
-- AUTO_INCREMENT for table `tbl_user_log`
--
ALTER TABLE `tbl_user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
