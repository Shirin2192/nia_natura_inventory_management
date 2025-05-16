-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 02:47 PM
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
-- Table structure for table `tbl_inventory_entry_type`
--

CREATE TABLE `tbl_inventory_entry_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inventory_entry_type`
--

INSERT INTO `tbl_inventory_entry_type` (`id`, `name`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Regular', '1', '2025-05-14 18:14:23', '2025-05-14 18:14:23'),
(2, 'Sample', '1', '2025-05-14 18:14:23', '2025-05-14 18:14:23'),
(3, 'Sale', '1', '2025-05-14 18:14:23', '2025-05-15 12:10:20'),
(4, 'Return', '1', '2025-05-14 18:14:23', '2025-05-15 12:10:27'),
(5, 'Damaged', '1', '2025-05-15 12:10:43', '2025-05-15 12:10:43');

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
(25, 2, 10, 1, 0, 0, 0, 0, '2025-04-15 17:31:14', '2025-04-15 17:31:14'),
(26, 1, 11, 1, 1, 1, 1, 0, '2025-04-30 14:00:08', '2025-04-30 14:00:08'),
(27, 1, 13, 1, 1, 1, 1, 0, '2025-05-15 11:56:07', '2025-05-15 11:56:07'),
(28, 2, 13, 1, 1, 1, 1, 0, '2025-05-15 11:56:23', '2025-05-15 11:56:23');

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
(1, 1, 1, 1, 1, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(2, 1, 1, 2, 18, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(3, 1, 1, 3, 19, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(4, 2, 1, 1, 2, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(5, 2, 1, 2, 18, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(6, 2, 1, 3, 19, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(7, 3, 1, 1, 3, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(8, 3, 1, 2, 18, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(9, 3, 1, 3, 19, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(10, 4, 1, 1, 11, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(11, 4, 1, 2, 16, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(12, 4, 1, 3, 19, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41');

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
(1, 1, 'NIA-NEEM-500g-01', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(2, 2, 'NIA-TULSI-500g-01', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(3, 3, 'NIA-HIMALAYAN-500g-01', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(4, 4, 'NIA-SIDR-250g-01', 50, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(5, 1, 'NIA-NEEM-500g-02', 100, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(6, 2, 'NIA-TULSI-500g-02', 100, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(7, 3, 'NIA-HIMALAYAN-500g-02', 100, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(8, 4, 'NIA-SIDR-250g-02', 100, '2025-12-31', '2025-01-01', 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42');

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
  `fk_sourcing_partner_id` int(11) DEFAULT NULL,
  `fk_inventory_entry_type` int(11) DEFAULT NULL,
  `fk_inventory_entry_type_sale_id` int(11) DEFAULT NULL,
  `fk_inventory_entry_type_return_id` int(11) DEFAULT NULL,
  `fk_inventory_entry_type_damage_id` int(11) DEFAULT NULL,
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

INSERT INTO `tbl_product_inventory` (`id`, `fk_login_id`, `fk_product_id`, `fk_batch_id`, `channel_type`, `fk_sale_channel_id`, `fk_sourcing_partner_id`, `fk_inventory_entry_type`, `fk_inventory_entry_type_sale_id`, `fk_inventory_entry_type_return_id`, `fk_inventory_entry_type_damage_id`, `add_quantity`, `deduct_quantity`, `total_quantity`, `reason`, `used_status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL, 1, 1, NULL, NULL, NULL, 50, NULL, 50, NULL, 0, '0', '2025-05-15 10:07:41', '2025-05-15 10:09:39'),
(2, 1, 2, 2, NULL, NULL, 1, 1, NULL, NULL, NULL, 50, NULL, 50, NULL, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(3, 1, 3, 3, NULL, NULL, 1, 1, NULL, NULL, NULL, 50, NULL, 50, NULL, 0, '0', '2025-05-15 10:07:41', '2025-05-16 05:23:59'),
(4, 1, 4, 4, NULL, NULL, 1, 1, NULL, NULL, NULL, 50, NULL, 50, NULL, 0, '0', '2025-05-15 10:07:41', '2025-05-16 03:33:45'),
(5, 1, 1, 5, NULL, NULL, 1, 1, NULL, NULL, NULL, 100, NULL, 100, NULL, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(6, 1, 2, 6, NULL, NULL, 1, 1, NULL, NULL, NULL, 100, NULL, 100, NULL, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(7, 1, 3, 7, NULL, NULL, 1, 1, NULL, NULL, NULL, 100, NULL, 100, NULL, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(8, 1, 4, 8, NULL, NULL, 1, 1, NULL, NULL, NULL, 100, NULL, 100, NULL, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(9, 1, 1, 1, 'Online', 1, 1, 1, 3, NULL, NULL, NULL, 10, 40, 'Product Sale', 0, '0', '2025-05-15 10:09:39', '2025-05-15 10:11:32'),
(10, 1, 1, 1, 'Online', 1, 1, 1, NULL, 4, NULL, 5, NULL, 45, 'Product Return', 0, '0', '2025-05-15 10:11:32', '2025-05-15 11:11:25'),
(11, 1, 1, 1, 'Online', 1, 1, 1, NULL, NULL, 5, NULL, 2, 43, 'Product Damage', 0, '0', '2025-05-15 11:11:25', '2025-05-15 11:44:33'),
(12, 1, 1, 1, 'Online', 1, 1, 1, 3, NULL, NULL, NULL, 10, 33, 'Product Return', 1, '1', '2025-05-15 11:44:33', '2025-05-15 11:44:33'),
(13, 1, 4, 4, 'Online', 1, 1, 1, 3, NULL, NULL, NULL, 20, 30, 'Product Sale', 0, '0', '2025-05-16 03:33:45', '2025-05-16 05:23:59'),
(14, 1, 4, 4, 'Online', 1, 1, 1, 3, NULL, NULL, NULL, 10, 20, 'Order Received for SIDR Product', 1, '1', '2025-05-16 05:23:59', '2025-05-16 05:23:59'),
(15, 1, 3, 3, 'Online', 1, 1, 1, 3, NULL, NULL, NULL, 15, 35, 'Order Received for HIMALAYAN Product', 1, '1', '2025-05-16 05:23:59', '2025-05-16 05:23:59');

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
(1, 1, 1, 'Neem', '6', 'Sample description', NULL, '987654321', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(2, 1, 1, 'Tulsi', '8', 'Sample description', NULL, '987654322', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(3, 1, 1, 'Himalayan', '12', 'Sample description', NULL, '987654323', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(4, 1, 1, 'SIDR', '17', 'Sample description', NULL, '987654323', 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41');

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
(1, 1, 1, 60, 120, 100, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(2, 2, 2, 60, 120, 100, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(3, 3, 3, 60, 120, 100, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(4, 4, 4, 60, 120, 250, 1, '1', '2025-05-15 10:07:41', '2025-05-15 10:07:41'),
(5, 1, 5, 60, 120, 100, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(6, 2, 6, 60, 120, 100, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(7, 3, 7, 60, 120, 100, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42'),
(8, 4, 8, 60, 120, 250, 1, '1', '2025-05-15 10:07:42', '2025-05-15 10:07:42');

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
(10, 'Inventory', '2025-04-15 17:19:44'),
(11, 'Sourcing Partner', '2025-04-30 13:58:41'),
(12, 'SKU Code Master', '2025-05-13 18:12:49'),
(13, 'Order Return / Damaged', '2025-05-15 11:54:39');

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
(30, 'NIA-LITCHI-500g', 1, '1', '2025-04-24 15:42:59', '2025-04-24 15:42:59'),
(31, 'NIA-TULSI-5000g', 1, '1', '2025-05-01 17:24:30', '2025-05-01 17:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sourcing_partner`
--

CREATE TABLE `tbl_sourcing_partner` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sourcing_partner`
--

INSERT INTO `tbl_sourcing_partner` (`id`, `name`, `address`, `email`, `contact_no`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Test Name', 'test', 'testemail1@email.com', '9865232345', '0', '2025-04-30 09:25:58', '2025-04-30 12:25:02'),
(2, 'Test Name', 'test', 'testemail@email.com', '9865232322', '1', '2025-04-30 09:26:52', '2025-04-30 12:00:23');

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
(55, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":37,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 06:21:33'),
(56, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":0,\"can_add\":0,\"can_edit\":0,\"can_delete\":0,\"has_access\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:07'),
(57, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":0,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:07'),
(58, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:07'),
(59, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:07'),
(60, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:07'),
(61, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:07'),
(62, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:08'),
(63, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:08'),
(64, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:08'),
(65, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":0,\"can_edit\":0,\"can_delete\":0,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:08'),
(66, 1, 'Inserted Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0,\"fk_role_id\":\"1\",\"fk_sidebar_id\":11}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 08:30:08'),
(67, 1, 'Insert Sourcing Partner', 'tbl_sourcing_partner', '{\"name\":\"Test Name\",\"email\":\"testemail@email.com\",\"contact_no\":\"98652323233\",\"address\":\"test\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 09:25:58'),
(68, 1, 'Insert Sourcing Partner', 'tbl_sourcing_partner', '{\"name\":\"Test Name\",\"email\":\"testemail@email.com\",\"contact_no\":\"98652323233\",\"address\":\"test\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 09:26:52'),
(69, 1, 'Update Sourcing Partner', 'tbl_sourcing_partner', '{\"name\":\"Test Name\",\"email\":\"testemail1@email.com\",\"contact_no\":\"9865232345\",\"address\":\"test\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 11:51:57'),
(70, 1, 'Update Sourcing Partner', 'tbl_sourcing_partner', '{\"name\":\"Test Name\",\"email\":\"testemail@email.com\",\"contact_no\":\"98652323233\",\"address\":\"test\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 11:52:12'),
(71, 1, 'Update Sourcing Partner', 'tbl_sourcing_partner', '{\"name\":\"Test Name\",\"email\":\"testemail1@email.com\",\"contact_no\":\"9865232345\",\"address\":\"test\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 12:00:02'),
(72, 1, 'Update Sourcing Partner', 'tbl_sourcing_partner', '{\"name\":\"Test Name\",\"email\":\"testemail@email.com\",\"contact_no\":\"9865232322\",\"address\":\"test\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 12:00:23'),
(73, 1, 'Delete Sourcing Partner', 'tbl_sourcing_partner', '{\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-04-30 12:25:02'),
(74, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"img_680b1909b1b9c.jpg,img_680b1909b940e.jpg,img_680b1909bcaec.jpg,img_680b1909c054b.jpg,img_680b1909c33a4.jpg,img_680b1909c6a9a.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:05:12'),
(75, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":null,\"total_quantity\":\"37\",\"channel_type\":null,\"fk_sale_channel_id\":null,\"reason\":\"Sourcing Partener Updated\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:05:12'),
(76, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"img_680b1909b1b9c.jpg,img_680b1909b940e.jpg,img_680b1909bcaec.jpg,img_680b1909c054b.jpg,img_680b1909c33a4.jpg,img_680b1909c6a9a.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:15:00'),
(77, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":null,\"total_quantity\":\"37\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"Sourcing Partener Updated\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:15:00'),
(78, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:22:04'),
(79, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":null,\"total_quantity\":\"33\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"Update Sourcing partner\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:22:04'),
(80, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":37,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(81, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":36,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(82, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":35,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(83, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":34,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(84, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":33,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(85, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":32,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(86, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":31,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(87, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":30,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:45'),
(88, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":29,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(89, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":28,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(90, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":27,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(91, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":26,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(92, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":32,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(93, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":31,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(94, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":30,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(95, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":29,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(96, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":28,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:46'),
(97, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":27,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(98, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":26,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(99, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":25,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(100, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":24,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(101, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":23,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(102, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":22,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(103, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":21,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(104, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":20,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(105, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":19,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(106, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":18,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:47'),
(107, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":17,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(108, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":16,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(109, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":36,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(110, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":35,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(111, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":34,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(112, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":33,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(113, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":32,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(114, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":31,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(115, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":30,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:48'),
(116, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":29,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:49'),
(117, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":28,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:49'),
(118, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":27,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:49'),
(119, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":26,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:49'),
(120, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":25,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:49'),
(121, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":24,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:24:49'),
(122, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":25,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(123, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":24,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(124, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":23,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(125, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":22,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40');
INSERT INTO `tbl_user_log` (`id`, `fk_user_id`, `action`, `inserted_table`, `inserted_data`, `ip_address`, `user_agent`, `created_at`) VALUES
(126, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":21,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(127, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":20,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(128, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":19,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(129, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":18,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(130, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":17,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(131, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":16,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:40'),
(132, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":15,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(133, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":14,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(134, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":15,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(135, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":14,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(136, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":13,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(137, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":12,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(138, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":11,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(139, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":10,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(140, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":9,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(141, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":8,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:41'),
(142, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":7,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:42'),
(143, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":6,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:42'),
(144, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":5,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:42'),
(145, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":4,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:42'),
(146, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":3,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:42'),
(147, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":2,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(148, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":1,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(149, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":0,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(150, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":23,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(151, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":22,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(152, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":21,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(153, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":20,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(154, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":19,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:43'),
(155, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":18,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(156, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":17,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(157, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":16,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(158, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":15,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(159, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":14,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(160, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":13,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(161, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":12,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(162, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":11,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:27:44'),
(163, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:30:58'),
(164, 1, 'Inserted New Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"BATCH002\",\"quantity\":\"50\",\"manufactured_date\":\"2025-04-01\",\"expiry_date\":\"2026-03-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:30:58'),
(165, 1, 'Inserted New Batch Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":5,\"purchase_price\":\"200\",\"MRP\":\"500\",\"selling_price\":\"450\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:30:58'),
(166, 1, 'Inserted New Batch Inventory Details', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_login_id\":\"1\",\"fk_batch_id\":5,\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"reason\":\"39849489348385895\",\"used_status\":1,\"fk_sourcing_partner_id\":\"2\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:30:58'),
(167, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:40:38'),
(168, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\",39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:40:39'),
(169, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":null,\"total_quantity\":null,\"fk_sourcing_partner_id\":null,\"reason\":\",39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:40:39'),
(170, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:57:54'),
(171, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\",,39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:57:54'),
(172, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":null,\"total_quantity\":null,\"fk_sourcing_partner_id\":null,\"reason\":\",,39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 09:57:54'),
(173, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:14:17'),
(174, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\",39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:14:17'),
(175, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":null,\"total_quantity\":null,\"fk_sourcing_partner_id\":null,\"reason\":\",39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:14:17'),
(176, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:29:07'),
(177, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:29:19'),
(178, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:30:36'),
(179, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:31:21'),
(180, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:34:02'),
(181, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:34:35'),
(182, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:35:22'),
(183, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:51:10'),
(184, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:51:45'),
(185, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\",,39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:51:45'),
(186, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:51:52'),
(187, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\",,39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:51:52'),
(188, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:53:29'),
(189, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\",,,39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 10:53:29'),
(190, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"images\":\"img_680b190914ffb.jpg,img_680b19091a6d9.jpg,img_680b19091f51a.jpg,img_680b1909224c3.jpg,img_680b190925685.jpg,img_680b1909284bd.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:00:50'),
(191, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\",,,,39849489348385895\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:00:50'),
(192, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":13,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:52'),
(193, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":12,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:52'),
(194, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":11,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:52'),
(195, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":10,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(196, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":9,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(197, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":8,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(198, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":7,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(199, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":6,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(200, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":5,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(201, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":4,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(202, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":3,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(203, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"2\",\"deduct_quantity\":\"1\",\"total_quantity\":2,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(204, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":10,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:53'),
(205, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":9,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(206, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":8,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(207, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":7,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(208, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":6,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(209, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":5,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(210, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":4,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(211, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":3,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(212, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":2,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(213, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":1,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:54'),
(214, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"1\",\"total_quantity\":0,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:14:55'),
(215, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"img_680b1909b1b9c.jpg,img_680b1909b940e.jpg,img_680b1909bcaec.jpg,img_680b1909c054b.jpg,img_680b1909c33a4.jpg,img_680b1909c6a9a.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:16:35'),
(216, 1, 'Inserted New Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"BATCH002\",\"quantity\":\"500\",\"manufactured_date\":\"2025-03-01\",\"expiry_date\":\"2026-03-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:16:35'),
(217, 1, 'Inserted New Batch Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":6,\"purchase_price\":\"500\",\"MRP\":\"1200\",\"selling_price\":\"1150\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:16:35'),
(218, 1, 'Inserted New Batch Inventory Details', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_login_id\":\"1\",\"fk_batch_id\":6,\"add_quantity\":\"500\",\"total_quantity\":\"500\",\"reason\":\"111\",\"used_status\":1,\"fk_sourcing_partner_id\":\"2\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:16:35'),
(219, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"img_680b1909b1b9c.jpg,img_680b1909b940e.jpg,img_680b1909bcaec.jpg,img_680b1909c054b.jpg,img_680b1909c33a4.jpg,img_680b1909c6a9a.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:22:31'),
(220, 1, 'Inserted New Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"BATCH003\",\"quantity\":\"200\",\"manufactured_date\":\"2025-03-01\",\"expiry_date\":\"2025-11-30\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:22:32'),
(221, 1, 'Inserted New Batch Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":7,\"purchase_price\":\"200\",\"MRP\":\"500\",\"selling_price\":\"500\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:22:32'),
(222, 1, 'Inserted New Batch Inventory Details', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_login_id\":\"1\",\"fk_batch_id\":7,\"add_quantity\":\"200\",\"total_quantity\":\"200\",\"reason\":\"New Batch\",\"used_status\":1,\"fk_sourcing_partner_id\":\"2\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:22:32'),
(223, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(224, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":8,\"purchase_price\":\"Sample description\",\"MRP\":\"60\",\"selling_price\":\"120\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(225, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":8,\"channel_type\":\"Honey\",\"fk_sale_channel_id\":null,\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(226, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"31\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"C:\\\\Users\\\\user\\\\Downloads\\\\Tulsi6.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Tulsi5.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Tulsi4.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Tulsi3.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Tulsi1.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Tulsi.jpg\",\"fk_product_types_id\":null}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(227, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":5,\"batch_no\":\"NIA-TULSI-5000g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(228, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":5,\"fk_batch_id\":9,\"purchase_price\":\"Sample description\",\"MRP\":\"60\",\"selling_price\":\"120\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(229, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":5,\"fk_batch_id\":9,\"channel_type\":\"Honey\",\"fk_sale_channel_id\":null,\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(230, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan6.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan5.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan4.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan3.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan2.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan1.jpg\",\"fk_product_types_id\":null}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:30'),
(231, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":6,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:31'),
(232, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":6,\"fk_batch_id\":10,\"purchase_price\":\"Sample description\",\"MRP\":\"60\",\"selling_price\":\"120\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:31'),
(233, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":6,\"fk_batch_id\":10,\"channel_type\":\"Honey\",\"fk_sale_channel_id\":null,\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:31'),
(234, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan6.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan5.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan4.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan3.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan2.jpg,C:\\\\Users\\\\user\\\\Downloads\\\\Himalayan1.jpg\",\"fk_product_types_id\":null}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:31'),
(235, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":7,\"batch_no\":\"NIA-HIMALAYAN-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:31'),
(236, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":7,\"fk_batch_id\":11,\"purchase_price\":\"Sample description\",\"MRP\":\"60\",\"selling_price\":\"120\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:31'),
(237, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":7,\"fk_batch_id\":11,\"channel_type\":\"Honey\",\"fk_sale_channel_id\":null,\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:54:31'),
(238, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08'),
(239, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08'),
(240, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08'),
(241, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08'),
(242, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"31\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08'),
(243, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-5000g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08'),
(244, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08');
INSERT INTO `tbl_user_log` (`id`, `fk_user_id`, `action`, `inserted_table`, `inserted_data`, `ip_address`, `user_agent`, `created_at`) VALUES
(245, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:08'),
(246, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(247, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(248, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(249, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(250, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(251, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-HIMALAYAN-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(252, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(253, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 11:59:09'),
(254, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\",Himalayan6.jpg,Himalayan5.jpg,Himalayan4.jpg,Himalayan3.jpg,Himalayan2.jpg,Himalayan1.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:02:46'),
(255, 1, 'Inserted New Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-HIMALAYAN-250g-02\",\"quantity\":\"200\",\"manufactured_date\":\"2025-04-16\",\"expiry_date\":\"2026-08-01\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:02:46'),
(256, 1, 'Inserted New Batch Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":5,\"purchase_price\":\"500\",\"MRP\":\"1200\",\"selling_price\":\"1100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:02:46'),
(257, 1, 'Inserted New Batch Inventory Details', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_login_id\":\"1\",\"fk_batch_id\":5,\"add_quantity\":\"200\",\"total_quantity\":\"200\",\"reason\":\"New Batch\",\"used_status\":1,\"fk_sourcing_partner_id\":\"2\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:02:46'),
(258, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\",Himalayan6.jpg,Himalayan5.jpg,Himalayan4.jpg,Himalayan3.jpg,Himalayan2.jpg,Himalayan1.jpg\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:06:37'),
(259, 1, 'Inserted New Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-HIMALAYAN-250g-03\",\"quantity\":\"500\",\"manufactured_date\":\"2025-02-01\",\"expiry_date\":\"2025-11-30\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:06:37'),
(260, 1, 'Inserted New Batch Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":6,\"purchase_price\":\"150\",\"MRP\":\"300\",\"selling_price\":\"300\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:06:37'),
(261, 1, 'Inserted New Batch Inventory Details', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_login_id\":\"1\",\"fk_batch_id\":6,\"add_quantity\":\"500\",\"total_quantity\":\"500\",\"reason\":\"New Batch\",\"used_status\":1,\"fk_sourcing_partner_id\":\"2\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-01 12:06:37'),
(262, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:49'),
(263, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(264, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(265, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(266, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"8\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(267, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(268, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(269, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(270, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(271, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(272, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(273, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:50'),
(274, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(275, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-SIDR-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(276, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(277, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(278, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(279, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(280, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(281, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"2\",\"batch_no\":\"NIA-TULSI-500g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(282, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(283, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(284, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"NIA-HIMALAYAN-500g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(285, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(286, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(287, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-SIDR-250g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(288, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(289, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 07:09:51'),
(290, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":\"1\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"5\",\"total_quantity\":45,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 08:38:39'),
(291, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":\"2\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"5\",\"total_quantity\":45,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 08:38:40'),
(292, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"2\",\"total_quantity\":48,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 08:38:40'),
(293, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"deduct_quantity\":\"2\",\"total_quantity\":48,\"used_status\":1,\"reason\":\"\",\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 08:38:40'),
(294, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(295, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(296, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(297, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(298, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"8\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(299, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(300, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(301, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:48'),
(302, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(303, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(304, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(305, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(306, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(307, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-SIDR-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(308, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(309, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(310, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(311, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(312, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(313, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"2\",\"batch_no\":\"NIA-TULSI-500g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(314, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(315, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(316, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"NIA-HIMALAYAN-500g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(317, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(318, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(319, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-SIDR-250g-02\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(320, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:49'),
(321, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"fk_sourcing_partner_id\":\"Online\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:32:50'),
(322, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:45:44'),
(323, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"sdddd\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:45:44'),
(324, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"sdddd\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-13 10:45:44'),
(325, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 05:02:26'),
(326, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"sdddd\",\"fk_inventory_entry_type\":[\"1\",\"1\"]}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 05:02:26'),
(327, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"sdddd\",\"fk_inventory_entry_type\":[\"1\",\"1\"]}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 05:02:26'),
(328, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"images\":\"\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 05:04:09'),
(329, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"sdddd\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 05:04:09'),
(330, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"sdddd\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 05:04:09'),
(331, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:05:32'),
(332, 1, 'Insert Product Inventory For Deduct Quantity', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:05:33'),
(333, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":0,\"can_add\":0,\"can_edit\":0,\"can_delete\":0,\"has_access\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(334, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":0,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(335, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(336, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(337, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(338, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(339, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(340, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(341, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(342, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":0,\"can_edit\":0,\"can_delete\":0,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(343, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(344, 1, 'Inserted Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0,\"fk_role_id\":\"1\",\"fk_sidebar_id\":13}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:07'),
(345, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":0,\"can_add\":0,\"can_edit\":0,\"can_delete\":0,\"has_access\":1}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(346, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(347, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(348, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(349, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(350, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(351, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(352, 1, 'Update Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":0,\"can_edit\":0,\"can_delete\":0,\"has_access\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(353, 1, 'Inserted Role Permission', 'tbl_permissions', '{\"can_view\":1,\"can_add\":1,\"can_edit\":1,\"can_delete\":1,\"has_access\":0,\"fk_role_id\":\"2\",\"fk_sidebar_id\":13}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 06:26:23'),
(354, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 07:11:02'),
(355, 1, 'Insert Product Inventory For Deduct Quantity', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 07:11:02'),
(356, 1, 'Update Product Master', 'tbl_product_master', '{\"product_name\":\"Neem\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"images\":\"\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:42:31'),
(357, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"40\",\"total_quantity\":\"40\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"Product Return\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:42:32'),
(358, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"fk_login_id\":\"1\",\"add_quantity\":\"40\",\"total_quantity\":\"40\",\"fk_sourcing_partner_id\":\"2\",\"reason\":\"Product Return\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:42:32'),
(359, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(360, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(361, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(362, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(363, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"8\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(364, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(365, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(366, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(367, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(368, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(369, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(370, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(371, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(372, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-SIDR-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(373, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(374, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(375, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(376, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(377, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(378, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"2\",\"batch_no\":\"NIA-TULSI-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(379, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(380, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(381, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"NIA-HIMALAYAN-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(382, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(383, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:46'),
(384, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-SIDR-250g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:47'),
(385, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:47'),
(386, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:50:47');
INSERT INTO `tbl_user_log` (`id`, `fk_user_id`, `action`, `inserted_table`, `inserted_data`, `ip_address`, `user_agent`, `created_at`) VALUES
(387, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(388, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(389, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(390, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(391, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"8\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(392, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(393, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(394, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:27'),
(395, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(396, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(397, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(398, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(399, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(400, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-SIDR-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(401, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(402, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(403, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(404, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(405, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(406, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"2\",\"batch_no\":\"NIA-TULSI-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(407, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(408, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(409, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"NIA-HIMALAYAN-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(410, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(411, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(412, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-SIDR-250g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(413, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(414, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"fk_sourcing_partner_id\":\"Test Sourcing Partner\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":{\"id\":\"1\"}}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:54:28'),
(415, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(416, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(417, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(418, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"8\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(419, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(420, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(421, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(422, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(423, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:02'),
(424, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(425, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-SIDR-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(426, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(427, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(428, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(429, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"2\",\"batch_no\":\"NIA-TULSI-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(430, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(431, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"NIA-HIMALAYAN-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(432, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(433, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-SIDR-250g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(434, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 08:59:03'),
(435, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:25'),
(436, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:25'),
(437, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:25'),
(438, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:25'),
(439, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"8\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:25'),
(440, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:25'),
(441, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:25'),
(442, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(443, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(444, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(445, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(446, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(447, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(448, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-SIDR-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(449, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(450, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(451, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(452, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(453, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(454, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"2\",\"batch_no\":\"NIA-TULSI-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(455, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(456, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(457, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"NIA-HIMALAYAN-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:26'),
(458, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:27'),
(459, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:27'),
(460, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-SIDR-250g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:27'),
(461, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:27'),
(462, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:04:27'),
(463, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:08:03'),
(464, 1, 'Insert Product Inventory For Deduct Quantity', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:08:03'),
(465, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:33:52'),
(466, 1, 'Insert Product Inventory For Deduct Quantity', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:33:52'),
(467, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:37:36'),
(468, 1, 'Insert Product Inventory For Deduct Quantity', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:37:36'),
(469, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:43:25'),
(470, 1, 'Insert Product Inventory For Deduct Quantity', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 09:43:25'),
(471, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Neem\",\"product_sku_code\":\"6\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654321\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(472, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":1,\"batch_no\":\"NIA-NEEM-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(473, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(474, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":1,\"fk_batch_id\":1,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(475, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Tulsi\",\"product_sku_code\":\"8\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654322\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(476, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":2,\"batch_no\":\"NIA-TULSI-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(477, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(478, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":2,\"fk_batch_id\":2,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(479, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"Himalayan\",\"product_sku_code\":\"12\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(480, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":3,\"batch_no\":\"NIA-HIMALAYAN-500g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(481, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(482, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":3,\"fk_batch_id\":3,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(483, 1, 'Insert Product', 'tbl_product_master', '{\"product_name\":\"SIDR\",\"product_sku_code\":\"17\",\"fk_stock_availability_id\":\"1\",\"barcode\":\"987654323\",\"description\":\"Sample description\",\"fk_product_types_id\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(484, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":4,\"batch_no\":\"NIA-SIDR-250g-01\",\"quantity\":\"50\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(485, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(486, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":4,\"fk_batch_id\":4,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"50\",\"total_quantity\":\"50\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:41'),
(487, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"1\",\"batch_no\":\"NIA-NEEM-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(488, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(489, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":5,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(490, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"2\",\"batch_no\":\"NIA-TULSI-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(491, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(492, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"2\",\"fk_batch_id\":6,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(493, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"3\",\"batch_no\":\"NIA-HIMALAYAN-500g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(494, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"100\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(495, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":7,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(496, 1, 'Insert Product Batch', 'tbl_product_batches', '{\"fk_product_id\":\"4\",\"batch_no\":\"NIA-SIDR-250g-02\",\"quantity\":\"100\",\"manufactured_date\":\"2025-01-01\",\"expiry_date\":\"2025-12-31\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(497, 1, 'Insert Product Price', 'tbl_product_price', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"purchase_price\":\"60\",\"MRP\":\"120\",\"selling_price\":\"250\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(498, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":8,\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"100\",\"total_quantity\":\"100\",\"used_status\":1,\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:07:42'),
(499, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:09:39'),
(500, 1, 'Insert Product Inventory Operation', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":\"1\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"total_quantity\":40,\"used_status\":1,\"fk_login_id\":\"1\",\"reason\":\"Product Sale\",\"fk_inventory_entry_type\":\"1\",\"fk_sourcing_partner_id\":\"1\",\"deduct_quantity\":\"10\",\"fk_inventory_entry_type_sale_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:09:39'),
(501, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:11:32'),
(502, 1, 'Insert Product Inventory Operation', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":\"1\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"total_quantity\":45,\"used_status\":1,\"fk_login_id\":\"1\",\"reason\":\"Product Return\",\"fk_inventory_entry_type\":\"1\",\"fk_sourcing_partner_id\":\"1\",\"add_quantity\":\"5\",\"fk_inventory_entry_type_return_id\":\"4\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 10:11:32'),
(503, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 11:11:25'),
(504, 1, 'Insert Product Inventory Operation', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":\"1\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"total_quantity\":43,\"used_status\":1,\"fk_login_id\":\"1\",\"reason\":\"Product Damage\",\"fk_inventory_entry_type\":\"1\",\"fk_sourcing_partner_id\":\"1\",\"deduct_quantity\":\"2\",\"fk_inventory_entry_type_damage_id\":\"5\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 11:11:25'),
(505, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 11:44:33'),
(506, 1, 'Insert Product Inventory Operation', 'tbl_product_inventory', '{\"fk_product_id\":\"1\",\"fk_batch_id\":\"1\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"total_quantity\":33,\"used_status\":1,\"fk_login_id\":\"1\",\"reason\":\"Product Return\",\"fk_inventory_entry_type\":\"1\",\"fk_sourcing_partner_id\":\"1\",\"deduct_quantity\":\"10\",\"fk_inventory_entry_type_sale_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-15 11:44:33'),
(507, 1, 'Update Product Inventory', 'tbl_product_inventory', '{\"used_status\":0,\"is_delete\":\"0\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-16 03:33:45'),
(508, 1, 'Insert Product Inventory Operation', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"total_quantity\":30,\"used_status\":1,\"fk_login_id\":\"1\",\"reason\":\"Product Sale\",\"fk_inventory_entry_type\":\"1\",\"fk_sourcing_partner_id\":\"1\",\"deduct_quantity\":\"20\",\"fk_inventory_entry_type_sale_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-16 03:33:45'),
(509, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"4\",\"fk_batch_id\":\"4\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"total_quantity\":20,\"used_status\":1,\"reason\":\"Order Received for SIDR Product\",\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\",\"fk_sourcing_partner_id\":\"1\",\"deduct_quantity\":\"10\",\"fk_inventory_entry_type_sale_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-16 05:23:59'),
(510, 1, 'Insert Product Inventory', 'tbl_product_inventory', '{\"fk_product_id\":\"3\",\"fk_batch_id\":\"3\",\"channel_type\":\"Online\",\"fk_sale_channel_id\":\"1\",\"total_quantity\":35,\"used_status\":1,\"reason\":\"Order Received for HIMALAYAN Product\",\"fk_login_id\":\"1\",\"fk_inventory_entry_type\":\"1\",\"fk_sourcing_partner_id\":\"1\",\"deduct_quantity\":\"15\",\"fk_inventory_entry_type_sale_id\":\"3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-16 05:23:59');

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
-- Indexes for table `tbl_inventory_entry_type`
--
ALTER TABLE `tbl_inventory_entry_type`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tbl_sourcing_partner`
--
ALTER TABLE `tbl_sourcing_partner`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `tbl_inventory_entry_type`
--
ALTER TABLE `tbl_inventory_entry_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_product_attributes`
--
ALTER TABLE `tbl_product_attributes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_product_batches`
--
ALTER TABLE `tbl_product_batches`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_product_inventory`
--
ALTER TABLE `tbl_product_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_sku_code_master`
--
ALTER TABLE `tbl_sku_code_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_sourcing_partner`
--
ALTER TABLE `tbl_sourcing_partner`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
