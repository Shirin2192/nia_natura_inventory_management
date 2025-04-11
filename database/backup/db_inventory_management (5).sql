-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2025 at 02:22 PM
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
(3, 1, 'Himalaya', 1, '1', '2025-04-01 09:14:02', '2025-04-01 09:14:02'),
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
(16, 2, '30 g', 1, '1', '2025-04-01 16:36:05', '2025-04-01 16:36:05'),
(17, 2, '100 g', 1, '1', '2025-04-01 16:36:17', '2025-04-01 16:36:17'),
(18, 2, '500 g', 1, '1', '2025-04-01 16:36:26', '2025-04-01 16:36:26'),
(19, 3, 'Glass', 1, '1', '2025-04-01 16:36:39', '2025-04-01 16:36:39'),
(20, 3, 'Plastic', 1, '1', '2025-04-01 16:36:50', '2025-04-01 16:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bottle_size`
--

CREATE TABLE `tbl_bottle_size` (
  `id` bigint(20) NOT NULL,
  `bottle_size` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bottle_size`
--

INSERT INTO `tbl_bottle_size` (`id`, `bottle_size`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, '30 ml', 1, '0', '2025-03-24 11:11:45', '2025-03-24 11:24:40'),
(2, '50 g', 1, '1', '2025-03-24 11:14:20', '2025-03-25 07:24:35'),
(3, '250 g', 1, '1', '2025-03-24 11:26:25', '2025-03-25 07:24:41'),
(4, '500 g', 1, '1', '2025-03-25 07:07:07', '2025-03-25 07:07:07'),
(5, '1000 g', 1, '1', '2025-03-25 07:24:58', '2025-03-25 07:24:58'),
(6, '30 g', 1, '1', '2025-03-27 04:56:08', '2025-03-27 04:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bottle_type`
--

CREATE TABLE `tbl_bottle_type` (
  `id` bigint(20) NOT NULL,
  `bottle_type` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bottle_type`
--

INSERT INTO `tbl_bottle_type` (`id`, `bottle_type`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Jar', 1, '1', '2025-03-24 11:59:38', '2025-03-24 12:06:47'),
(2, 'Glass', 1, '1', '2025-03-24 12:09:45', '2025-03-24 12:09:45'),
(3, 'Plastic', 1, '1', '2025-03-24 12:11:11', '2025-03-24 12:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_flavour`
--

CREATE TABLE `tbl_flavour` (
  `id` bigint(20) NOT NULL,
  `flavour_name` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_flavour`
--

INSERT INTO `tbl_flavour` (`id`, `flavour_name`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Neem', 1, '1', '2025-03-24 09:15:49', '2025-03-25 04:24:35'),
(2, 'Tulsi', 1, '1', '2025-03-24 09:16:02', '2025-03-24 09:16:02'),
(3, 'Himalaya', 1, '1', '2025-03-24 10:17:32', '2025-03-25 06:30:49'),
(4, 'Ajwain', 1, '1', '2025-03-25 06:31:03', '2025-03-25 06:31:03'),
(5, 'Acacia', 1, '1', '2025-03-25 06:31:33', '2025-03-25 06:31:33'),
(6, 'Multiflora', 1, '1', '2025-03-25 06:31:50', '2025-03-25 06:31:50'),
(7, 'Raw Organic', 1, '1', '2025-03-25 06:32:14', '2025-03-25 06:32:14'),
(8, 'Forest', 1, '1', '2025-03-25 06:32:27', '2025-03-25 06:32:27'),
(9, 'Natural Pure', 1, '1', '2025-03-25 06:33:06', '2025-03-25 06:33:06'),
(10, 'Jamun', 1, '1', '2025-03-25 06:33:16', '2025-03-25 06:33:16'),
(11, 'SIDR', 1, '1', '2025-03-25 06:33:48', '2025-03-25 06:33:48'),
(12, 'Kashmir White', 1, '1', '2025-03-25 06:34:05', '2025-04-01 03:47:14'),
(13, 'Eucalyptus', 1, '1', '2025-03-25 06:34:31', '2025-03-25 06:34:31'),
(14, 'Rose Wood', 1, '1', '2025-03-25 06:43:43', '2025-03-25 06:43:43'),
(15, 'Litchi', 1, '1', '2025-03-25 06:43:56', '2025-03-26 08:18:01'),
(16, 'sssssss sssssssssssss22222', 1, '0', '2025-03-27 04:17:56', '2025-03-27 04:18:03'),
(17, 'S SSSS', 1, '0', '2025-03-27 04:18:38', '2025-03-27 04:18:50'),
(18, 'a', 1, '0', '2025-03-27 04:48:31', '2025-03-27 04:53:21'),
(19, 'Kashmir White', 1, '0', '2025-03-27 04:53:35', '2025-03-27 04:53:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` bigint(20) NOT NULL,
  `product_name` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `product_name`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Nia Natura 100% Pure Organic Honey Tulsi 500g | Unprocessed, Raw, Without Sugar | Tulsi', 1, '1', '2025-03-25 07:14:09', '2025-03-26 08:32:13');

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
(1, 1, 1, 3, 19, 1, '2025-04-01 12:19:34', '2025-04-01 12:19:34'),
(2, 1, 1, 2, 18, 1, '2025-04-01 12:19:34', '2025-04-01 12:19:34'),
(3, 1, 1, 1, 2, 1, '2025-04-01 12:19:34', '2025-04-01 12:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_category`
--

CREATE TABLE `tbl_product_category` (
  `id` bigint(20) NOT NULL,
  `fk_product_id` int(11) DEFAULT NULL,
  `fk_flavour_id` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_category`
--

INSERT INTO `tbl_product_category` (`id`, `fk_product_id`, `fk_flavour_id`, `description`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Nia Natura Tulsi Honey is a pure and raw forest honey, enriched with the natural nectar of Tulsi (Holy Basil) flowers. Tulsi has been revered in Ayurveda for centuries due to its powerful immunity-boosting, anti-inflammatory, and stress-relieving benefits. This honey has a unique herbal aroma and a mild sweetness, making it an excellent choice for those looking for a natural remedy for cough, cold, and respiratory health. Use it as a natural sweetener in teas, herbal drinks, or take a spoonful daily for overall well-being.', 1, '1', '2025-03-25 07:14:09', '2025-03-26 08:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_inventory`
--

CREATE TABLE `tbl_product_inventory` (
  `id` bigint(20) NOT NULL,
  `fk_product_id` int(11) DEFAULT NULL,
  `fk_product_category_id` int(11) DEFAULT NULL,
  `fk_product_type_id` int(11) DEFAULT NULL,
  `fk_product_price_id` int(11) DEFAULT NULL,
  `fk_sale_channel_id` int(11) DEFAULT NULL,
  `add_quantity` int(11) DEFAULT NULL,
  `deduct_quantity` int(11) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `used_status` int(11) DEFAULT NULL,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_inventory`
--

INSERT INTO `tbl_product_inventory` (`id`, `fk_product_id`, `fk_product_category_id`, `fk_product_type_id`, `fk_product_price_id`, `fk_sale_channel_id`, `add_quantity`, `deduct_quantity`, `total_quantity`, `used_status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, 50, NULL, 50, 1, '1', '2025-04-01 12:19:34', '2025-04-01 12:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_master`
--

CREATE TABLE `tbl_product_master` (
  `id` bigint(20) NOT NULL,
  `fk_stock_availability_id` int(11) DEFAULT NULL,
  `product_name` longtext DEFAULT NULL,
  `product_sku_code` varchar(100) DEFAULT NULL,
  `batch_no` varchar(250) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `images` longtext DEFAULT NULL,
  `barcode` longtext DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `MRP` double DEFAULT NULL,
  `selling_price` double DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_master`
--

INSERT INTO `tbl_product_master` (`id`, `fk_stock_availability_id`, `product_name`, `product_sku_code`, `batch_no`, `description`, `images`, `barcode`, `purchase_price`, `MRP`, `selling_price`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nia Natura 100% Pure Organic Honey Tulsi 500g | Unprocessed, Raw, Without Sugar | Tulsi', '4533535', '232434345553434', 'Product description\r\nNia Natura Tulsi Honey is a pure and raw forest honey, enriched with the natural nectar of Tulsi (Holy Basil) flowers. Tulsi has been revered in Ayurveda for centuries due to its powerful immunity-boosting, anti-inflammatory, and stress-relieving benefits. This honey has a unique herbal aroma and a mild sweetness, making it an excellent choice for those looking for a natural remedy for cough, cold, and respiratory health. Use it as a natural sweetener in teas, herbal drinks, or take a spoonful daily for overall well-being.', 'Tulsi619.jpg,Tulsi519.jpg,Tulsi419.jpg,Tulsi319.jpg,Tulsi121.jpg,Tulsi40.jpg', '2344554', 500, 500, 500, 1, '1', '2025-04-01 12:19:34', '2025-04-01 12:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_price`
--

CREATE TABLE `tbl_product_price` (
  `id` bigint(20) NOT NULL,
  `fk_product_id` int(11) DEFAULT NULL,
  `fk_product_category_id` int(11) DEFAULT NULL,
  `fk_product_type_id` int(11) DEFAULT NULL,
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

INSERT INTO `tbl_product_price` (`id`, `fk_product_id`, `fk_product_category_id`, `fk_product_type_id`, `purchase_price`, `MRP`, `selling_price`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 500, 500, 500, 1, '1', '2025-04-01 12:19:34', '2025-04-01 12:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_type`
--

CREATE TABLE `tbl_product_type` (
  `id` bigint(20) NOT NULL,
  `fk_product_id` int(11) DEFAULT NULL,
  `fk_product_category_id` int(11) DEFAULT NULL,
  `fk_bottle_size_id` int(11) DEFAULT NULL,
  `fk_bottle_type_id` int(11) DEFAULT NULL,
  `fk_sale_channel_id` int(11) NOT NULL,
  `product_sku_code` varchar(100) DEFAULT NULL,
  `fk_stock_availability_id` int(11) DEFAULT NULL,
  `batch_no` varchar(250) DEFAULT NULL,
  `images` longtext DEFAULT NULL,
  `barcode` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_type`
--

INSERT INTO `tbl_product_type` (`id`, `fk_product_id`, `fk_product_category_id`, `fk_bottle_size_id`, `fk_bottle_type_id`, `fk_sale_channel_id`, `product_sku_code`, `fk_stock_availability_id`, `batch_no`, `images`, `barcode`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 2, 1, '213', 1, '1111111qq', '61qVJagIBxL__SL1080_2.jpg,613IJB0MIqL__SX679_2.jpg,61nH5ZiWpzL__SX679_2.jpg,51+s50v+R2L__SX38_SY50_CR50_2.jpg,713H74q1e4L__SX679_2.jpg,51iLKddRvDL__SX679_2.jpg', '12221212', 1, '1', '2025-03-25 07:14:09', '2025-03-26 08:32:49');

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
(2, 'Seeds', 1, '1', '2025-03-28 04:47:49', '2025-03-28 05:45:46');

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
(1, 'Admin', 1, '1', '2025-03-24 04:29:20', '2025-03-24 04:29:20'),
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
(3, 'Offline', 'Retail Store', 1, '1', '2025-03-25 07:24:17', '2025-04-01 05:15:48');

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
-- Indexes for table `tbl_bottle_size`
--
ALTER TABLE `tbl_bottle_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bottle_size` (`bottle_size`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_bottle_type`
--
ALTER TABLE `tbl_bottle_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bottle_type` (`bottle_type`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_flavour`
--
ALTER TABLE `tbl_flavour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`flavour_name`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `tbl_product_attributes`
--
ALTER TABLE `tbl_product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_product_id`,`fk_flavour_id`);

--
-- Indexes for table `tbl_product_inventory`
--
ALTER TABLE `tbl_product_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_product_id`,`fk_product_category_id`,`fk_product_type_id`,`fk_product_price_id`,`fk_sale_channel_id`,`add_quantity`,`deduct_quantity`,`total_quantity`);

--
-- Indexes for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`fk_stock_availability_id`,`product_sku_code`,`purchase_price`,`MRP`,`selling_price`);

--
-- Indexes for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_id` (`fk_product_id`),
  ADD KEY `id` (`id`,`fk_product_category_id`,`fk_product_type_id`,`purchase_price`,`MRP`,`selling_price`);

--
-- Indexes for table `tbl_product_type`
--
ALTER TABLE `tbl_product_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_id` (`fk_product_id`),
  ADD KEY `fk_product_category_id` (`fk_product_category_id`),
  ADD KEY `fk_bottle_size_id` (`fk_bottle_size_id`),
  ADD KEY `fk_bottle_type_id` (`fk_bottle_type_id`),
  ADD KEY `product_sku_code` (`product_sku_code`),
  ADD KEY `fk_sale_channel_id` (`fk_sale_channel_id`,`fk_stock_availability_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_bottle_size`
--
ALTER TABLE `tbl_bottle_size`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_bottle_type`
--
ALTER TABLE `tbl_bottle_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_flavour`
--
ALTER TABLE `tbl_flavour`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product_attributes`
--
ALTER TABLE `tbl_product_attributes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product_inventory`
--
ALTER TABLE `tbl_product_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product_type`
--
ALTER TABLE `tbl_product_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product_types`
--
ALTER TABLE `tbl_product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sale_channel`
--
ALTER TABLE `tbl_sale_channel`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
