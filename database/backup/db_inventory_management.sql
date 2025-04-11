-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 01:36 PM
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
(2, '50 ml', 1, '1', '2025-03-24 11:14:20', '2025-03-24 11:14:20'),
(3, '250 ml', 1, '1', '2025-03-24 11:26:25', '2025-03-24 11:27:42');

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
(1, 'Neemsssssss', 1, '1', '2025-03-24 09:15:49', '2025-03-24 10:23:49'),
(2, 'Tulsi', 1, '1', '2025-03-24 09:16:02', '2025-03-24 09:16:02'),
(3, 'Himalaya', 1, '0', '2025-03-24 10:17:32', '2025-03-24 11:21:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` bigint(20) NOT NULL,
  `product_name` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `sale_channel` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_delete` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Admin', 'admin@admin.com', 'YkpnZDA3Vis4YXJmcnh4VXRzeE5jdz09', 1, 1, '1', '2025-03-24 05:38:50', '2025-03-24 05:38:50');

--
-- Indexes for dumped tables
--

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
  ADD KEY `id` (`id`,`product_name`);

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
-- AUTO_INCREMENT for table `tbl_bottle_size`
--
ALTER TABLE `tbl_bottle_size`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_bottle_type`
--
ALTER TABLE `tbl_bottle_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_flavour`
--
ALTER TABLE `tbl_flavour`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_inventory`
--
ALTER TABLE `tbl_product_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_type`
--
ALTER TABLE `tbl_product_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sale_channel`
--
ALTER TABLE `tbl_sale_channel`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stock_availability`
--
ALTER TABLE `tbl_stock_availability`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
