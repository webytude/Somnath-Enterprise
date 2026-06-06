-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 06, 2026 at 10:08 PM
-- Server version: 8.4.7
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sm_ent`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_id` bigint UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `attendance_status` enum('absent','present','present_with_bike','half_day') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'absent',
  `overtime_hours` decimal(5,2) DEFAULT '0.00',
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_staff_id_attendance_date_unique` (`staff_id`,`attendance_date`),
  KEY `attendances_created_by_foreign` (`created_by`),
  KEY `attendances_updated_by_foreign` (`updated_by`),
  KEY `attendances_location_id_foreign` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `staff_id`, `attendance_date`, `attendance_status`, `overtime_hours`, `location_id`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-02-23', 'present', 0.50, 2, NULL, 2, 2, '2026-02-22 22:40:10', '2026-02-23 01:01:03'),
(2, 2, '2026-02-23', 'present_with_bike', 0.00, 4, NULL, 2, 2, '2026-02-23 09:54:19', '2026-02-23 09:54:37'),
(3, 2, '2026-02-24', 'present_with_bike', 0.00, 4, NULL, 2, 2, '2026-02-24 03:27:00', '2026-02-24 03:27:12'),
(4, 1, '2026-02-24', 'present', 0.00, 2, NULL, 2, 2, '2026-02-24 03:27:05', '2026-02-24 03:27:15'),
(5, 2, '2026-02-25', 'present_with_bike', 0.00, 4, NULL, 2, 2, '2026-02-25 03:19:08', '2026-02-25 03:19:36'),
(6, 1, '2026-02-25', 'present', 0.00, 3, NULL, 2, 2, '2026-02-25 03:19:18', '2026-02-25 03:19:39'),
(7, 2, '2026-02-27', 'present', 0.00, 4, NULL, 2, 2, '2026-02-26 21:45:57', '2026-02-26 21:46:09'),
(8, 1, '2026-02-27', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-02-26 21:46:02', '2026-02-26 21:46:12'),
(9, 2, '2026-02-28', 'present', 0.00, 4, NULL, 2, 2, '2026-02-27 21:25:28', '2026-02-27 21:26:08'),
(10, 1, '2026-02-28', 'present_with_bike', 1.00, 2, NULL, 2, 2, '2026-02-27 21:26:44', '2026-02-27 21:27:02'),
(11, 2, '2026-03-01', 'present', 0.00, 4, NULL, 2, 2, '2026-03-01 09:58:01', '2026-03-01 09:58:29'),
(12, 1, '2026-03-01', 'present', 0.00, 3, NULL, 2, 2, '2026-03-01 09:58:07', '2026-03-01 09:58:27'),
(13, 2, '2026-03-02', 'present', 0.00, 4, NULL, 2, 2, '2026-03-01 20:41:29', '2026-03-01 20:41:37'),
(14, 1, '2026-03-02', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-01 20:41:32', '2026-03-01 20:41:41'),
(15, 2, '2026-03-03', 'half_day', 0.00, 4, NULL, 2, 2, '2026-03-03 11:11:22', '2026-03-05 04:14:32'),
(16, 1, '2026-03-03', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-03 11:11:26', '2026-03-03 11:11:34'),
(17, 2, '2026-03-04', 'present', 0.00, 4, NULL, 2, 2, '2026-03-03 21:12:29', '2026-03-03 21:12:57'),
(18, 1, '2026-03-04', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-03 21:12:33', '2026-03-03 21:13:00'),
(19, 2, '2026-03-05', 'half_day', 0.00, 4, NULL, 2, 2, '2026-03-04 19:53:49', '2026-03-04 19:54:09'),
(20, 1, '2026-03-05', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-04 19:53:53', '2026-03-04 19:54:11'),
(21, 2, '2026-03-06', 'present', 0.00, 4, NULL, 2, 2, '2026-03-05 19:21:46', '2026-03-05 19:22:10'),
(22, 1, '2026-03-06', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-05 19:22:04', '2026-03-05 19:22:37'),
(23, 2, '2026-03-08', 'half_day', 0.50, 4, NULL, 2, 2, '2026-03-07 20:10:28', '2026-03-08 06:31:46'),
(24, 1, '2026-03-08', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-07 20:10:32', '2026-03-07 20:10:44'),
(25, 2, '2026-03-07', 'present', 0.00, NULL, NULL, 2, 2, '2026-03-08 06:32:25', '2026-03-08 06:32:25'),
(26, 1, '2026-03-07', 'present_with_bike', 0.00, NULL, NULL, 2, 2, '2026-03-08 06:32:30', '2026-03-08 06:32:30'),
(27, 2, '2026-03-10', 'present', 0.00, 4, NULL, 2, 2, '2026-03-10 02:48:22', '2026-03-10 02:48:27'),
(28, 1, '2026-03-10', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-10 02:48:30', '2026-03-10 02:48:37'),
(29, 2, '2026-03-12', 'present', 0.00, 4, NULL, 2, 2, '2026-03-11 18:48:49', '2026-03-11 18:49:12'),
(30, 1, '2026-03-12', 'half_day', 0.00, 3, NULL, 2, 2, '2026-03-11 18:48:54', '2026-03-11 18:49:25'),
(31, 2, '2026-03-13', 'present', 0.00, 4, NULL, 2, 2, '2026-03-13 12:18:09', '2026-03-13 12:18:21'),
(32, 1, '2026-03-13', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-13 12:18:14', '2026-03-13 12:18:23'),
(33, 2, '2026-03-26', 'present', 0.00, 4, NULL, 2, 2, '2026-03-26 14:34:10', '2026-03-26 14:34:29'),
(34, 1, '2026-03-26', 'present_with_bike', 0.00, 3, NULL, 2, 2, '2026-03-26 14:34:17', '2026-03-26 14:34:32'),
(35, 2, '2026-04-02', 'present', 0.00, 1, NULL, 2, 2, '2026-04-01 22:15:47', '2026-04-01 22:15:57'),
(36, 1, '2026-04-02', 'present', 0.00, 4, NULL, 2, 2, '2026-04-01 22:15:51', '2026-04-01 22:15:59'),
(37, 2, '2026-04-04', 'present', 0.00, 4, NULL, 2, 2, '2026-04-03 22:21:25', '2026-04-03 22:21:32'),
(38, 8, '2026-04-06', 'present', 0.00, 9, NULL, 2, 2, '2026-04-06 08:01:47', '2026-04-06 08:02:29'),
(39, 7, '2026-04-06', 'present', 0.00, 17, NULL, 2, 2, '2026-04-06 08:02:43', '2026-04-06 08:02:51'),
(40, 5, '2026-04-06', 'present_with_bike', 0.00, 9, NULL, 2, 2, '2026-04-06 08:03:03', '2026-04-06 08:07:28'),
(41, 3, '2026-04-06', 'present_with_bike', 0.00, 9, NULL, 2, 2, '2026-04-06 08:03:31', '2026-04-06 08:03:46'),
(42, 8, '2026-04-07', 'present', 0.00, 9, NULL, 2, 2, '2026-04-07 08:58:17', '2026-04-07 08:58:24'),
(43, 7, '2026-04-07', 'present', 0.00, 21, NULL, 2, 2, '2026-04-07 08:58:29', '2026-04-07 08:58:36'),
(44, 5, '2026-04-07', 'present_with_bike', 0.00, 9, NULL, 2, 2, '2026-04-07 08:58:41', '2026-04-07 08:58:52'),
(45, 3, '2026-04-07', 'present_with_bike', 0.00, 7, NULL, 2, 2, '2026-04-07 08:58:58', '2026-04-07 08:59:07'),
(46, 8, '2026-04-21', 'present_with_bike', 0.00, 24, NULL, 2, 2, '2026-04-20 21:34:53', '2026-04-20 21:35:10'),
(47, 3, '2026-04-21', 'present_with_bike', 0.00, 9, NULL, 2, 2, '2026-04-20 21:35:20', '2026-04-20 21:35:26'),
(48, 4, '2026-04-21', 'present_with_bike', 0.00, 5, NULL, 2, 2, '2026-04-20 21:35:30', '2026-04-20 21:35:49'),
(49, 8, '2026-04-25', 'present', 0.00, NULL, NULL, 2, 2, '2026-04-25 15:09:36', '2026-04-25 15:09:36'),
(50, 7, '2026-04-25', 'present', 0.00, NULL, NULL, 2, 2, '2026-04-25 15:09:39', '2026-04-25 15:09:39'),
(51, 8, '2026-04-28', 'absent', 0.00, NULL, NULL, 2, 2, '2026-04-28 14:50:53', '2026-04-28 14:50:53'),
(52, 8, '2026-05-10', 'present', 0.00, 8, NULL, 3, 3, '2026-05-09 18:53:58', '2026-05-09 18:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `bill_inwards`
--

DROP TABLE IF EXISTS `bill_inwards`;
CREATE TABLE IF NOT EXISTS `bill_inwards` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `firm_id` bigint UNSIGNED NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `party_gst` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_pan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `bill_attachment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_bhadu_labour` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bill_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_status` enum('Pending','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `payment_ref_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_inwards_firm_id_foreign` (`firm_id`),
  KEY `bill_inwards_party_id_foreign` (`party_id`),
  KEY `bill_inwards_created_by_foreign` (`created_by`),
  KEY `bill_inwards_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_inward_details`
--

DROP TABLE IF EXISTS `bill_inward_details`;
CREATE TABLE IF NOT EXISTS `bill_inward_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bill_inward_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gst_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_inward_details_bill_inward_id_foreign` (`bill_inward_id`),
  KEY `bill_inward_details_material_id_foreign` (`material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_outwards`
--

DROP TABLE IF EXISTS `bill_outwards`;
CREATE TABLE IF NOT EXISTS `bill_outwards` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `firm_id` bigint UNSIGNED NOT NULL,
  `firm_gst` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `bill_attachment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `party_gst` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `add_bhadu_labour` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bill_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_status` enum('Pending','Received') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `sd_percentage` decimal(5,2) DEFAULT NULL,
  `tds_percentage` decimal(5,2) DEFAULT NULL,
  `gst_deduction_percentage` decimal(5,2) DEFAULT NULL,
  `lc_percentage` decimal(5,2) DEFAULT NULL,
  `tc_percentage` decimal(5,2) DEFAULT NULL,
  `total_deduction` decimal(10,2) NOT NULL DEFAULT '0.00',
  `net_received_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_ref_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_outwards_firm_id_foreign` (`firm_id`),
  KEY `bill_outwards_party_id_foreign` (`party_id`),
  KEY `bill_outwards_created_by_foreign` (`created_by`),
  KEY `bill_outwards_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_outward_details`
--

DROP TABLE IF EXISTS `bill_outward_details`;
CREATE TABLE IF NOT EXISTS `bill_outward_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bill_outward_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED DEFAULT NULL,
  `work_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gst_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_outward_details_bill_outward_id_foreign` (`bill_outward_id`),
  KEY `bill_outward_details_material_id_foreign` (`material_id`),
  KEY `bill_outward_details_work_id_foreign` (`work_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

DROP TABLE IF EXISTS `contractors`;
CREATE TABLE IF NOT EXISTS `contractors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedhi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_cont_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_term` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `remaining_amount` decimal(10,2) DEFAULT NULL,
  `payment_slab_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contractors_payment_slab_id_foreign` (`payment_slab_id`),
  KEY `contractors_created_by_foreign` (`created_by`),
  KEY `contractors_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`id`, `pedhi`, `gst`, `pan`, `bank_name`, `ifsc`, `branch_name`, `bank_account_no`, `address`, `mobile`, `contact_person`, `contact_person_mobile`, `ref_by`, `ref_cont_no`, `payment_term`, `amount`, `remaining_amount`, `payment_slab_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'JAYANTILAL KARSHANBHAI MAKAVANA', NULL, 'BEEPM7298P', 'Bank of Baroda', 'BARB0JAMJOD', 'JamJodhpur', '17958100003709', 'Azad Gas Godaun, Chhaya, Dist. Porbandar-360578', '9726165715', 'Jentibhai', '8160362755', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 04:45:31', '2026-04-07 09:01:19'),
(3, 'VIJAYBHAI KHIMABHAI PARMAR', NULL, 'BXPPV8334P', 'State Bank of India', 'SBIN0015325', 'KENEDY', '44898501632', 'At. Udepur (Sidasara), Kudar Vari Sheri, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', '9537302922', 'Vijay Parmar', '9537302922', NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, '2026-04-05 04:33:51', '2026-04-05 04:33:51'),
(5, 'KISHAN TRIKAMBHAI PARMAR', NULL, 'DOSPP0681H', 'HDFC BANK', 'HDFC0002184', 'Halvad', '50100353000032', 'Behind Bus Station, Halvad, Surendranagar-363330', '8849275821', 'Kishanbhai', '9638726610', 'Khumanshinh Zala', '9904769388', NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 05:03:17', '2026-04-07 08:40:14'),
(6, 'JAMANBHAI BHIKHABHAI SONAGRA', NULL, 'JOLPS3813D', 'State Bank of India', 'SBIN0015325', 'KENEDY', '20347465816', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', '9574901966', 'Jamanbhai', '9574901966', NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, '2026-04-05 08:31:32', '2026-04-05 08:31:32'),
(7, 'ANILKUMAR ARJANBHAI KHANDHAR', NULL, 'CPDPK7804J', 'Bank of Baroda', 'BARB0JAMJAM', 'Khambhalia', '26120100029609', 'At. Dharampur, Jagasi Vadi, Ta. Khambhalia, Dist. Devbhumi Dwarka-361305', '9316893354', 'Anilbhai', '9898643563', 'Atulbhai', '9974945224', NULL, NULL, NULL, NULL, 2, NULL, '2026-04-05 08:37:35', '2026-04-05 08:37:35'),
(8, 'JAMANBHAI PREMJIBHAI NAKUM', NULL, 'BNKPN9325B', 'State Bank of India', 'SBIN0015325', 'KENEDY', '36154151492', 'At. Kenedi, Juna Rabari Padani Bajuma, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', '9265351063', 'Jamanbhai P.', '9265351063', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 08:56:35', '2026-04-07 08:39:45'),
(9, 'SHERASIYA MAHMADMASUD ALAVADIBHAI', NULL, 'QVQPS5702C', 'State Bank of India', 'SBIN0009863', 'Pipliyaraj', '38936201873', 'At. Pipliyaraj,Ta. Wankaner, Dist. Morbi-363621', '9925151254', 'Maksudbhai', '9925151254', 'Illubhai Pre', '9979009234', NULL, NULL, NULL, NULL, 2, NULL, '2026-04-09 05:21:53', '2026-04-09 05:21:53'),
(10, 'BABULAL JAGDISHBHAI KANZARIYA', NULL, 'FGLPK5511G', 'State Bank of India', 'SBIN0060071', 'Para Bazar-Morbi', '33303458328', 'Hadani ni Vadi, Nr. Byepass Chowkadi, Panchasar Road, Morbi-363641', '9925522396', 'Maheshbhai', '9979071346', 'Jagabhai Jashabhai', '9825668169', NULL, NULL, NULL, NULL, 2, 2, '2026-04-09 11:57:28', '2026-04-13 05:40:26'),
(11, 'BUMTARIYA DIPAK YASVANTBHAI', NULL, 'EPKPB9214J', 'Central Bank of India', 'CBIN0284652', 'DHROL', '3613715242', 'Dhrol, Dholeshvar Vari Sheri, Dist. Jamnagar-361210', NULL, NULL, NULL, 'Sunilbhai Banshi Welding', '9824505802', NULL, NULL, NULL, NULL, 2, NULL, '2026-04-17 09:58:30', '2026-04-17 09:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_locations`
--

DROP TABLE IF EXISTS `contractor_locations`;
CREATE TABLE IF NOT EXISTS `contractor_locations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contractor_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contractor_locations_contractor_id_location_id_unique` (`contractor_id`,`location_id`),
  KEY `contractor_locations_location_id_foreign` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractor_locations`
--

INSERT INTO `contractor_locations` (`id`, `contractor_id`, `location_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 2, 3, NULL, NULL),
(3, 8, 7, NULL, NULL),
(4, 5, 13, NULL, NULL),
(5, 4, 16, NULL, NULL),
(6, 9, 17, NULL, NULL),
(7, 10, 20, NULL, NULL),
(8, 10, 21, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contractor_materials`
--

DROP TABLE IF EXISTS `contractor_materials`;
CREATE TABLE IF NOT EXISTS `contractor_materials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contractor_id` bigint UNSIGNED NOT NULL,
  `material_list_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contractor_materials_contractor_id_material_list_id_unique` (`contractor_id`,`material_list_id`),
  KEY `contractor_materials_material_list_id_foreign` (`material_list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_works`
--

DROP TABLE IF EXISTS `contractor_works`;
CREATE TABLE IF NOT EXISTS `contractor_works` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contractor_id` bigint UNSIGNED NOT NULL,
  `work_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contractor_works_contractor_id_work_id_unique` (`contractor_id`,`work_id`),
  KEY `contractor_works_work_id_foreign` (`work_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractor_works`
--

INSERT INTO `contractor_works` (`id`, `contractor_id`, `work_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 5, 3, NULL, NULL),
(4, 4, 5, NULL, NULL),
(5, 9, 6, NULL, NULL),
(6, 10, 8, NULL, NULL),
(7, 10, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_expenses`
--

DROP TABLE IF EXISTS `daily_expenses`;
CREATE TABLE IF NOT EXISTS `daily_expenses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_expenses_staff_id_foreign` (`staff_id`),
  KEY `daily_expenses_location_id_foreign` (`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_payments`
--

DROP TABLE IF EXISTS `daily_payments`;
CREATE TABLE IF NOT EXISTS `daily_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_id` bigint UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_payments_staff_id_payment_date_unique` (`staff_id`,`payment_date`),
  KEY `daily_payments_created_by_foreign` (`created_by`),
  KEY `daily_payments_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'FOREST AND ENVIRONMENT', 2, NULL, '2026-04-04 07:59:02', '2026-04-04 07:59:02'),
(4, 'ROAD & BUILDING', 2, NULL, '2026-04-04 07:59:20', '2026-04-04 07:59:20'),
(5, 'Energy & Petrochemicals', 2, NULL, '2026-04-05 21:33:34', '2026-04-05 21:33:34'),
(6, 'Education Department', 2, NULL, '2026-04-09 05:28:12', '2026-04-09 05:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `subdepartment_id` bigint UNSIGNED DEFAULT NULL,
  `head_of_division_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `head_mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `divisions_department_id_foreign` (`department_id`),
  KEY `divisions_subdepartment_id_foreign` (`subdepartment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `department_id`, `subdepartment_id`, `head_of_division_name`, `address`, `head_mobile_number`, `contact_number`, `contact_person_name`, `contact_person_mobile_number`, `bank_name`, `bank_account_no`, `ifsc_code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Executive Engineer, Panchayat Road and Building Division, MORBI', 4, 7, 'Executive Engineer', '205-209, Jilla Panchayat, Shobheshvar Road, Morbi', 'Divyesh Patel', '9925247333', 'Hasmukhbhai Vadaviya', '7434800748', NULL, NULL, NULL, 2, 2, '2026-04-05 21:53:36', '2026-04-05 21:53:36'),
(2, 'Executive Engineer, Panchayat R&B Division, Jamnagar', 4, 7, 'Executive Engineer', 'Jilla Panchayat Building, Nr. Lal Bunglow, Jamnagar-361001', 'Chhaiyasir', '9558888838', 'Bhargavbhai Ac', '9638768380', NULL, NULL, NULL, 2, 2, '2026-04-05 22:13:28', '2026-04-05 22:13:28'),
(3, 'Executive Engineer, Panchayat R&B Division, Devbhumi Dwarka', 4, 7, 'Executive Engineer', 'District Panchayat Building, Lalpur Byepass Road, R & B (P) Div. 2nd Floor, 12-B (West),Khambhaliya, Dist. Devbhumi Dwarka', 'Prajapatisir', NULL, 'Bharatbhai Gojiya', '8128127714', NULL, NULL, NULL, 2, 2, '2026-04-05 22:16:56', '2026-04-05 22:16:56'),
(4, 'DCF, SF DIVISION,DEVBHUMI DWARKA', 3, 5, 'Deputy Conservator of Forest', '\"Van Bhavan\", Khambhaliya-Jamnagar Road, Opp. ITI, Khambhaliya-361305', 'Arunkumar', '6381485649', 'Abdulbhai', '9106770716', NULL, NULL, NULL, 2, 2, '2026-04-05 22:20:59', '2026-04-05 22:20:59'),
(5, 'DCF, Wild Ass Sanctuary-Dhangadhra', 3, 6, 'Deputy Conservator of Forest', 'Deputy Conservator of Forest, Wild Ass Sanctuary, Mayurnagar, Halvad Road, Dhangadhra', 'B M Patel', '9408896003', 'Karanbhai', '8140081035', NULL, NULL, NULL, 2, 2, '2026-04-05 22:25:38', '2026-04-05 22:25:38'),
(6, 'GSECL, Thermal Power Station, Sikka', 5, 4, 'Chief Engineer', 'Chief Engineer, Gujarat State Electricity Corporation Ltd., Thermal Power Station, Sikka-361140', 'Mundhvasir', NULL, 'Janisir', '7567047231', NULL, NULL, NULL, 2, 2, '2026-04-05 22:29:38', '2026-04-05 22:29:38'),
(7, 'Gujarat Council of School Education (GCSE)', 6, 8, 'State Project Director', 'Samagra Shiksha, Gujarat Council of School Education, State Project Office, Sector-19, Gandhinagar, Gujarat', NULL, '07922881000', NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-09 05:30:36', '2026-04-09 05:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firms`
--

DROP TABLE IF EXISTS `firms`;
CREATE TABLE IF NOT EXISTS `firms` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pancard` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pf_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firms_created_by_foreign` (`created_by`),
  KEY `firms_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `firms`
--

INSERT INTO `firms` (`id`, `name`, `address`, `pancard`, `gst`, `pf_code`, `mobile_number`, `email`, `bank_name`, `bank_account_no`, `ifsc_code`, `head_name`, `head_mobile_number`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SOMNATH ELECTRICALS', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', 'DUKPS7804B', '24DUKPS7804B2ZK', 'GJRAJ1458281000', '9723890408', 'somnathelectricals22@gmail.com', 'SBI', '44874298083', 'SBIN0060093', 'Keshubhai', '9723890408', 'No', 2, 2, '2026-02-22 22:41:46', '2026-04-04 07:26:33'),
(2, 'SOMNATH ENTERPRISE', 'At. Kenedi, Ta. Kalyanpur , Dist. Devbhumi Dwarka-361315', 'ADWFS8150L', '24ADWFS8150L1ZA', 'GJRAJ2075419000', '9727690408', 'somnathenterprise23@gmail.com', 'State Bank of India', '44440055825', 'SBIN0015325', 'Keshubhai', '9723890408', 'No', 2, 2, '2026-02-22 22:43:06', '2026-04-04 07:37:27'),
(3, 'GOKUL AGENCY', 'At. Ramnagar, Ta. Khambhaliya, Dist. Devbhumi Dwarka-361305', 'AKIPN1866F', '24AKIPN1866F1Z5', 'GJRAJ342563000', '9924012719', 'gokulagency62@gmail.com', 'State Bank of India', '42261995245', 'SBIN0060178', 'JAMANBHAI K. NAKUM', '9924012719', 'NO', 2, 2, '2026-04-04 07:52:12', '2026-04-04 07:52:12'),
(4, 'SHREE KAMDHENU ENTERPRISE', 'Gani Sheth Ni Vadi, Salaya Road, Harshidhinagar, Harshadpur, Ta. Khambhaliya, Dist. Devbhumi Dwarka-361305', 'AGAPN4890P', '24AGAPN4890P1ZV', 'NA', '9737423912', NULL, 'State Bank of India', '44129849779', 'SBIN0060178', 'Khimajibhai R. Nakum', '9737423912', NULL, 2, 2, '2026-04-04 07:56:59', '2026-04-04 07:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `firm_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `subdepartment_id` bigint UNSIGNED DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `sub_division_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locations_department_id_foreign` (`department_id`),
  KEY `locations_subdepartment_id_foreign` (`subdepartment_id`),
  KEY `locations_division_id_foreign` (`division_id`),
  KEY `locations_sub_division_id_foreign` (`sub_division_id`),
  KEY `locations_firm_id_foreign` (`firm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `firm_id`, `department_id`, `subdepartment_id`, `division_id`, `sub_division_id`, `name`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 2, 3, 5, 4, 2, 'Harsiddhivan', NULL, 2, 2, '2026-04-05 22:49:52', '2026-04-05 22:49:52'),
(6, 1, 3, 5, 4, 1, 'Haripar Nursery', NULL, 2, 2, '2026-04-05 22:48:06', '2026-04-05 22:48:06'),
(5, 1, 3, 5, 4, 1, 'Sanosara Nursery', NULL, 2, 2, '2026-04-05 22:47:37', '2026-04-05 22:47:37'),
(8, 2, 3, 5, 4, 2, 'Devaliya Vankavach', NULL, 2, 2, '2026-04-05 22:50:40', '2026-04-05 22:50:51'),
(9, 2, 3, 5, 4, 3, 'Vachchhu Nursery', NULL, 2, 2, '2026-04-06 06:24:03', '2026-04-06 06:24:03'),
(10, 2, 3, 5, 4, 3, 'VanKavach-Dwarka', NULL, 2, 2, '2026-04-06 06:27:47', '2026-04-06 06:27:47'),
(11, 3, 3, 5, 4, 4, 'Vankavach-Nikava', NULL, 2, 2, '2026-04-06 06:31:29', '2026-04-06 06:31:29'),
(12, 3, 3, 5, 4, 4, 'Police Pared Ground', NULL, 2, 2, '2026-04-06 06:31:58', '2026-04-06 06:31:58'),
(13, 2, 3, 6, 5, 15, 'Grass Godown', NULL, 2, 2, '2026-04-06 06:34:56', '2026-04-06 06:34:56'),
(14, 2, 3, 6, 5, 15, 'Sara Chokdi', NULL, 2, 2, '2026-04-06 06:35:19', '2026-04-06 06:35:19'),
(15, 2, 5, 4, 6, 13, 'Sikka Colony', NULL, 2, 2, '2026-04-06 06:37:51', '2026-04-06 06:37:51'),
(16, 3, 3, 5, 4, 5, 'Guard Quarter', NULL, 2, 2, '2026-04-06 06:38:49', '2026-04-06 06:38:49'),
(17, 1, 4, 7, 1, 9, 'PipaliyaRaj', NULL, 2, 2, '2026-04-06 06:39:25', '2026-04-06 06:39:25'),
(18, 1, 4, 7, 1, 9, 'Bhatiya', NULL, 2, 2, '2026-04-06 06:39:53', '2026-04-06 06:39:53'),
(19, 1, 4, 7, 1, 9, 'Palasadi', NULL, 2, 2, '2026-04-06 06:40:18', '2026-04-06 06:40:18'),
(20, 1, 4, 7, 1, 8, 'Jepur', NULL, 2, 2, '2026-04-06 06:40:46', '2026-04-06 06:40:46'),
(21, 1, 4, 7, 1, 8, 'Panchasar', NULL, 2, 2, '2026-04-06 06:41:09', '2026-04-06 06:41:09'),
(22, 1, 4, 7, 3, 12, 'Ranparda', NULL, 2, 2, '2026-04-06 06:41:41', '2026-04-06 06:41:41'),
(23, 1, 4, 7, 3, 12, 'Patelka', NULL, 2, 2, '2026-04-06 06:42:05', '2026-04-06 06:42:05'),
(24, 2, 6, 8, 7, 16, 'Kenedi School', NULL, 2, 2, '2026-04-09 05:34:04', '2026-04-09 05:34:04'),
(25, 2, 3, 5, 4, 2, 'Jam Raval', NULL, 2, 2, '2026-04-17 03:01:20', '2026-04-17 03:01:20'),
(26, 1, 3, 5, 4, 17, 'Salaya', NULL, 2, 2, '2026-04-17 03:05:30', '2026-04-17 03:05:30'),
(27, 1, 3, 5, 4, 18, 'Jam Jodhpur', NULL, 2, 2, '2026-04-17 03:06:04', '2026-04-17 03:06:04'),
(28, 1, 4, 7, 2, 11, 'Dhrol All GramPanchayat', NULL, 2, 2, '2026-04-17 10:01:46', '2026-04-17 10:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `material_categories`
--

DROP TABLE IF EXISTS `material_categories`;
CREATE TABLE IF NOT EXISTS `material_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_categories_created_by_foreign` (`created_by`),
  KEY `material_categories_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_categories`
--

INSERT INTO `material_categories` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'CIVIL MATERIAL', 2, 2, '2026-04-07 08:16:40', '2026-04-07 08:16:40'),
(2, 'Plumbing Materials', 2, 2, '2026-04-07 08:17:12', '2026-04-07 08:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `material_inwards`
--

DROP TABLE IF EXISTS `material_inwards`;
CREATE TABLE IF NOT EXISTS `material_inwards` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `work_id` bigint UNSIGNED DEFAULT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `party_gst` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_pan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_voucher_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_voucher_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_voucher_date` date DEFAULT NULL,
  `material_inward_at_site_date` date DEFAULT NULL,
  `bill_voucher_attachment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_bhadu` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bill_voucher_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('Pending','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `payment_ref_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_inwards_location_id_foreign` (`location_id`),
  KEY `material_inwards_work_id_foreign` (`work_id`),
  KEY `material_inwards_party_id_foreign` (`party_id`),
  KEY `material_inwards_created_by_foreign` (`created_by`),
  KEY `material_inwards_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_inwards`
--

INSERT INTO `material_inwards` (`id`, `location_id`, `work_id`, `party_id`, `party_gst`, `party_pan`, `bill_voucher_type`, `bill_voucher_number`, `bill_voucher_date`, `material_inward_at_site_date`, `bill_voucher_attachment`, `add_bhadu`, `total_bill_voucher_amount`, `payment_status`, `payment_ref_number`, `payment_date`, `payment_remarks`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 4, 4, 4, '24AAPPP4858A1ZL', 'AAPPP4858A', 'Bill', '2077', '2026-02-12', '2026-02-13', NULL, 145.00, 35207.97, 'Pending', NULL, NULL, NULL, NULL, 2, NULL, '2026-03-05 04:27:24', '2026-03-05 04:27:24'),
(4, 2, 2, 1, '24AATFR6205K1ZU', 'AATFR6205K', NULL, 'RS/1899', '2026-01-28', '2026-01-29', NULL, 826.00, 53653.72, 'Pending', NULL, NULL, NULL, NULL, 2, NULL, '2026-03-05 04:31:22', '2026-03-05 04:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `material_inward_details`
--

DROP TABLE IF EXISTS `material_inward_details`;
CREATE TABLE IF NOT EXISTS `material_inward_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_inward_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `make` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gst_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_inward_details_material_inward_id_foreign` (`material_inward_id`),
  KEY `material_inward_details_material_id_foreign` (`material_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_inward_details`
--

INSERT INTO `material_inward_details` (`id`, `material_inward_id`, `material_id`, `make`, `quantity`, `unit`, `rate`, `amount`, `gst_percentage`, `sub_total`, `created_at`, `updated_at`) VALUES
(4, 3, 2, 'Urkarsh', 138.20, 'KG', 51.69, 7143.56, 18.00, 8429.40, '2026-03-05 04:27:24', '2026-03-05 04:27:24'),
(5, 3, 2, 'Nilkanth', 219.20, 'KG', 50.85, 11146.32, 18.00, 13152.66, '2026-03-05 04:27:24', '2026-03-05 04:27:24'),
(6, 3, 3, 'Utkarsh', 203.20, 'KG', 52.97, 10763.50, 18.00, 12700.93, '2026-03-05 04:27:24', '2026-03-05 04:27:24'),
(7, 3, 3, 'Binding', 10.00, 'KG', 66.10, 661.00, 18.00, 779.98, '2026-03-05 04:27:24', '2026-03-05 04:27:24'),
(8, 4, 3, 'Urkarsh', 149.80, 'KG', 51.69, 7743.16, 18.00, 9136.93, '2026-03-05 04:31:22', '2026-03-05 04:31:22'),
(9, 4, 3, 'Nilkanth', 143.20, 'KG', 53.81, 7705.59, 18.00, 9092.60, '2026-03-05 04:31:22', '2026-03-05 04:31:22'),
(10, 4, 2, 'Utkarsh', 289.50, 'KG', 52.54, 15210.33, 18.00, 17948.19, '2026-03-05 04:31:22', '2026-03-05 04:31:22'),
(11, 4, 2, 'Nilkanth', 79.80, 'KG', 52.54, 4192.69, 18.00, 4947.37, '2026-03-05 04:31:22', '2026-03-05 04:31:22'),
(12, 4, 1, 'Watertank', 1.00, 'Nos.', 5932.20, 5932.20, 18.00, 7000.00, '2026-03-05 04:31:22', '2026-03-05 04:31:22'),
(13, 4, 2, 'Binding', 62.27, 'KG', 64.00, 3985.28, 18.00, 4702.63, '2026-03-05 04:31:22', '2026-03-05 04:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `material_lists`
--

DROP TABLE IF EXISTS `material_lists`;
CREATE TABLE IF NOT EXISTS `material_lists` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_lists_material_category_id_foreign` (`material_category_id`),
  KEY `material_lists_created_by_foreign` (`created_by`),
  KEY `material_lists_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_lists`
--

INSERT INTO `material_lists` (`id`, `material_category_id`, `name`, `unit`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cement', 'Bag', NULL, 2, 2, '2026-04-07 08:17:36', '2026-04-07 08:17:36'),
(2, 1, 'Steel 8mm', 'Nos.', NULL, 2, 2, '2026-04-07 08:18:01', '2026-04-07 08:18:01'),
(3, 1, 'Steel 10mm', 'Mtr.', NULL, 2, 2, '2026-04-07 08:18:33', '2026-04-07 08:18:33'),
(4, 1, 'Steel 12mm', 'KG', NULL, 2, 2, '2026-04-07 08:20:42', '2026-04-07 08:20:42'),
(5, 1, 'Steel 16mm', 'Mtr.', NULL, 2, 2, '2026-04-07 08:21:02', '2026-04-07 08:22:21'),
(6, 1, 'Reti', 'Ton', NULL, 2, 2, '2026-04-07 08:22:45', '2026-04-07 08:22:45'),
(7, 1, 'Bela 5x9x12', 'Nos.', NULL, 2, 2, '2026-04-07 08:23:09', '2026-04-07 08:23:09'),
(8, 1, 'Bela 7x9x15', 'Nos.', NULL, 2, 2, '2026-04-07 08:23:30', '2026-04-07 08:23:30'),
(9, 1, 'Agreegate 20mm', 'Ton', NULL, 2, 2, '2026-04-07 08:23:55', '2026-04-07 08:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_26_184007_create-department-table', 1),
(5, '2025_11_26_184015_create-sub-department-table', 1),
(6, '2025_11_26_184032_create-division-table', 1),
(7, '2025_11_26_184042_create-pedhi-table', 1),
(8, '2025_12_04_185829_create_locations_table', 1),
(9, '2025_12_09_163856_create_staff_table', 1),
(10, '2025_12_09_165854_create_attendances_table', 1),
(11, '2025_12_09_170748_create_daily_payments_table', 1),
(12, '2025_12_09_180419_create_payment_slabs_table', 1),
(13, '2025_12_09_181131_create_site_materials_table', 1),
(14, '2025_12_09_182827_create_parties_table', 1),
(15, '2025_12_09_183337_create_contractors_table', 1),
(16, '2025_12_09_184958_create_site_progress_table', 1),
(17, '2025_12_09_185611_create_tool_lists_table', 1),
(18, '2025_12_09_190902_create_gst_bill_lists_table', 1),
(19, '2025_12_09_191641_create_scrap_materials_table', 1),
(20, '2025_12_09_192028_create_scrap_lists_table', 1),
(21, '2026_01_11_193912_create_sub_divisions_table', 1),
(22, '2026_01_11_194203_add_sub_division_id_to_locations_table', 1),
(23, '2026_01_11_194842_update_staff_table_structure', 1),
(24, '2026_01_11_195232_remove_father_name_from_staff_table', 1),
(25, '2026_01_11_201840_create_daily_expenses_table', 1),
(26, '2026_01_11_202233_add_staff_id_to_daily_expenses_table', 1),
(27, '2026_01_11_202648_add_user_id_to_staff_table', 1),
(28, '2026_01_15_093720_create_site_material_details_table', 1),
(29, '2026_01_15_093735_add_party_id_to_site_materials_table', 1),
(30, '2026_01_15_094706_update_parties_table_add_pedhi_remove_price_date_add_list_of_material', 1),
(31, '2026_01_15_095215_create_site_material_requirements_table', 1),
(32, '2026_01_15_095218_create_site_material_requirement_details_table', 1),
(33, '2026_01_15_100033_add_gst_to_site_materials_table', 1),
(34, '2026_01_15_100338_add_gst_to_site_material_details_table', 1),
(35, '2026_01_15_104658_add_location_id_and_work_stage_to_site_progress_table', 1),
(36, '2026_01_15_105214_update_tool_lists_add_location_id_person_name_date', 1),
(37, '2026_01_29_133854_add_location_id_to_tool_lists_table_if_not_exists', 1),
(38, '2026_01_29_134123_make_location_nullable_in_tool_lists_table', 1),
(39, '2026_01_29_134816_remove_location_column_from_tool_lists_table', 1),
(40, '2026_02_02_125352_add_salary_fields_to_staff_table', 1),
(41, '2026_02_02_125817_update_attendances_table_add_status_and_overtime', 1),
(42, '2026_02_03_004624_add_location_id_to_attendances_table', 1),
(43, '2026_02_03_010151_create_firms_table', 1),
(44, '2026_02_03_011720_add_additional_fields_to_divisions_table', 1),
(45, '2026_02_03_013244_add_additional_fields_to_sub_divisions_table', 1),
(46, '2026_02_04_003943_replace_pedhi_with_firm_in_locations_and_parties', 1),
(47, '2026_02_04_011808_create_material_categories_table', 1),
(48, '2026_02_04_011815_create_material_lists_table', 1),
(49, '2026_02_07_171242_add_relative_fields_to_staff_table', 1),
(50, '2026_02_07_172343_add_location_id_to_daily_expenses_table', 1),
(51, '2026_02_07_172841_add_work_name_to_locations_table', 1),
(52, '2026_02_07_185859_remove_work_name_from_locations_table', 1),
(53, '2026_02_07_190038_create_works_table', 1),
(54, '2026_02_07_201834_add_fields_to_parties_table', 1),
(55, '2026_02_07_201843_create_party_materials_table', 1),
(56, '2026_02_07_201847_create_party_locations_table', 1),
(57, '2026_02_07_203158_add_fields_to_contractors_table', 1),
(58, '2026_02_07_203201_create_contractor_materials_table', 1),
(59, '2026_02_07_203204_create_contractor_locations_table', 1),
(60, '2026_02_07_204449_add_work_id_to_site_material_requirements_table', 1),
(61, '2026_02_07_204452_add_time_within_days_to_site_material_requirement_details_table', 1),
(62, '2026_02_14_220402_update_site_material_requirement_details_table_add_material_id', 1),
(63, '2026_02_14_230005_create_contractor_works_table', 1),
(64, '2026_02_14_232321_create_material_inwards_table', 1),
(65, '2026_02_14_232327_create_material_inward_details_table', 1),
(66, '2026_02_14_234051_create_bill_inwards_table', 1),
(67, '2026_02_14_234056_create_bill_inward_details_table', 1),
(68, '2026_02_14_235441_create_bill_outwards_table', 1),
(69, '2026_02_14_235444_create_bill_outward_details_table', 1),
(70, '2026_02_22_184308_remove_location_column_from_locations_table', 1),
(71, '2026_02_22_193530_create_stages_table', 1),
(72, '2026_02_22_193959_update_site_progress_table_add_work_id_stage_id', 1),
(73, '2026_02_22_201611_create_payments_table', 1),
(74, '2026_02_25_000001_add_gst_amount_to_works_table', 1),
(75, '2026_03_09_000000_add_location_and_work_to_stages_table', 1),
(76, '2026_03_09_000001_add_shelf_location_to_tool_lists_table', 1),
(77, '2026_03_09_000002_add_material_inward_ids_to_payments_table', 1),
(78, '2026_03_27_000003_add_payment_status_to_material_inwards_table', 1),
(79, '2026_04_01_100000_create_work_orders_table', 1),
(80, '2026_04_01_100001_create_work_order_details_table', 1),
(81, '2026_04_01_120000_add_number_prefix_to_work_orders_table', 1),
(82, '2026_04_01_150000_add_work_order_vendor_payment_tracking', 1),
(83, '2026_04_05_120000_nullable_subdepartment_id_set_null_on_delete', 1),
(84, '2026_04_05_140000_set_null_on_delete_department_division_location_work', 1),
(90, '2026_04_26_013000_add_remark_to_attendances_table', 2),
(89, '2026_04_26_011000_create_staff_locations_table', 2),
(88, '2026_04_26_003000_add_location_id_to_staff_table', 2),
(91, '2026_05_03_000001_create_roles_and_permissions_tables', 3),
(92, '2026_05_05_000001_create_rbac_tables', 4),
(93, '2026_05_05_200001_create_roles_and_permissions_tables', 5),
(94, '2026_05_05_200002_update_is_staff_to_role_index', 5),
(95, '2026_05_08_000001_create_roles_table', 6),
(96, '2026_05_08_000002_create_permissions_table', 6),
(97, '2026_05_08_000003_create_role_permission_table', 6),
(98, '2026_05_08_000004_add_role_id_to_users_table', 6),
(99, '2026_05_08_020001_create_roles_table', 7),
(100, '2026_05_08_020002_create_permissions_table', 7),
(101, '2026_05_08_020003_create_role_permissions_table', 7),
(102, '2026_05_10_150000_ensure_role_permission_schema_and_permission_name', 8),
(103, '2026_05_11_100000_add_timestamps_to_roles_table_if_missing', 9),
(104, '2026_06_06_191700_create_personal_access_tokens_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

DROP TABLE IF EXISTS `parties`;
CREATE TABLE IF NOT EXISTS `parties` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firm_id` bigint UNSIGNED DEFAULT NULL,
  `gst` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pancard` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bank_account_holder_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name_branch` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list_of_material` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parties_created_by_foreign` (`created_by`),
  KEY `parties_updated_by_foreign` (`updated_by`),
  KEY `parties_firm_id_foreign` (`firm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `firm_id`, `gst`, `pancard`, `address`, `mobile`, `contact_person_name`, `contact_person_mobile`, `remark`, `bank_account_holder_name`, `bank_name_branch`, `bank_account_no`, `ifsc_code`, `list_of_material`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(6, 'Satishkumar Vithaldas Paun', 2, '24AAPPP4858A1ZL', 'AAPPP4858A', 'Near Govt. Hospital, Main Bazar Viththaldas Market, Bhatiya, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', '9426458025', 'Jigarbhai', '9426994569', 'Steel', 'SATISHKUMAR VITHALDAS PAUN', 'SBI-BHATIA', '56093084476', 'SBIN0060093', NULL, 2, 2, '2026-04-05 04:18:24', '2026-04-07 08:25:54'),
(7, 'DEKAVADIYA ENTERPRISE', 1, '24AANFD0119Q1Z9', 'AANFD0119Q', 'Plot No.4, 22 P2, Nurani Chambers, 8A National Highway, Near Dargah, Chandrapur', '9998687183', 'Rahilbhai', '9998687183', NULL, 'DEKAVADIYA ENTERPRISE', 'Central Bank of India-Wankaner', '3595693992', 'CBIN0284994', NULL, 2, NULL, '2026-04-07 08:31:48', '2026-04-07 08:31:48'),
(8, 'PAVANSUT ENTERPRISE', 1, '24BEVPP4067G1Z1', 'BEVPP4067G', 'Nr. Kamdhenu Party Plot, Kandla Byepass Road, Morbi-1', '7621041041', 'Manojbhai', '7046672060', NULL, 'PAVANSUT ENTERPRISE', 'HDFC BANK-MORBI', '59209909064202', 'HDFC0003110', NULL, 2, NULL, '2026-04-07 08:36:02', '2026-04-07 08:36:02'),
(9, 'Royal Stone Morbi', 1, NULL, NULL, '8A,National Highway,Nr. Amrut Cement, Opp. Timbadi,Morbi-2, Dist. Morbi', '9825686789', 'Niravbhai', '9825686789', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-09 05:49:47', '2026-04-09 05:50:00'),
(10, 'RACHNA STEEL-DHROL', 1, '24AATFR6205K1ZU', 'AATFR6205K', 'Bavni Nadi Pase, Jamnagar Road, Dhrol-361210', '6353234441', 'Kantibhai', '9998926721', NULL, 'RACHNA STEEL', 'HDFC BANK-DHROL', '50200039443360', 'HDFC0003193', NULL, 2, NULL, '2026-04-09 05:56:42', '2026-04-09 05:56:42'),
(11, 'KRISHNA STEEL TRADERS-KHAMBHALIA', 2, '24AMGPK0369N1ZT', 'AMGPK0369N', 'Khambhalia, Navapara Sheri No.7, Khambhalia, Dist. Devbhumi Dwarka-361305', '9924021499', 'Yogeshbhai', '9924021499', NULL, 'Krishna Steel Traders', 'ICICI-Khambhalia', '170405500180', 'ICIC0001704', NULL, 2, NULL, '2026-04-09 06:10:32', '2026-04-09 06:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `party_locations`
--

DROP TABLE IF EXISTS `party_locations`;
CREATE TABLE IF NOT EXISTS `party_locations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `party_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `party_locations_party_id_location_id_unique` (`party_id`,`location_id`),
  KEY `party_locations_location_id_foreign` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `party_locations`
--

INSERT INTO `party_locations` (`id`, `party_id`, `location_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(8, 2, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(5, 4, 4, NULL, NULL),
(6, 5, 4, NULL, NULL),
(9, 6, 8, NULL, NULL),
(10, 6, 7, NULL, NULL),
(11, 6, 23, NULL, NULL),
(12, 6, 9, NULL, NULL),
(13, 7, 18, NULL, NULL),
(14, 7, 17, NULL, NULL),
(15, 8, 20, NULL, NULL),
(16, 8, 21, NULL, NULL),
(17, 9, 20, NULL, NULL),
(18, 9, 21, NULL, NULL),
(19, 10, 6, NULL, NULL),
(20, 10, 5, NULL, NULL),
(21, 11, 24, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `party_materials`
--

DROP TABLE IF EXISTS `party_materials`;
CREATE TABLE IF NOT EXISTS `party_materials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `party_id` bigint UNSIGNED NOT NULL,
  `material_list_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `party_materials_party_id_material_list_id_unique` (`party_id`,`material_list_id`),
  KEY `party_materials_material_list_id_foreign` (`material_list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `party_materials`
--

INSERT INTO `party_materials` (`id`, `party_id`, `material_list_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 2, 1, NULL, NULL),
(5, 2, 4, NULL, NULL),
(6, 3, 1, NULL, NULL),
(7, 3, 2, NULL, NULL),
(8, 3, 3, NULL, NULL),
(9, 4, 1, NULL, NULL),
(10, 4, 2, NULL, NULL),
(11, 4, 3, NULL, NULL),
(12, 5, 7, NULL, NULL),
(13, 5, 1, NULL, NULL),
(14, 6, 2, NULL, NULL),
(15, 6, 3, NULL, NULL),
(16, 6, 4, NULL, NULL),
(17, 6, 5, NULL, NULL),
(18, 7, 1, NULL, NULL),
(19, 7, 2, NULL, NULL),
(20, 7, 3, NULL, NULL),
(21, 7, 4, NULL, NULL),
(22, 7, 5, NULL, NULL),
(23, 8, 1, NULL, NULL),
(24, 8, 2, NULL, NULL),
(25, 8, 3, NULL, NULL),
(26, 8, 4, NULL, NULL),
(27, 8, 5, NULL, NULL),
(28, 9, 9, NULL, NULL),
(29, 10, 2, NULL, NULL),
(30, 10, 3, NULL, NULL),
(31, 10, 4, NULL, NULL),
(32, 10, 5, NULL, NULL),
(33, 11, 1, NULL, NULL),
(34, 11, 2, NULL, NULL),
(35, 11, 3, NULL, NULL),
(36, 11, 4, NULL, NULL),
(37, 11, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_type` enum('staff','party','vendor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `party_id` bigint UNSIGNED DEFAULT NULL,
  `material_inward_ids` json DEFAULT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `work_order_id` bigint UNSIGNED DEFAULT NULL,
  `salary_payable` decimal(10,2) DEFAULT '0.00',
  `expense_payable` decimal(10,2) DEFAULT '0.00',
  `total_payable` decimal(10,2) DEFAULT '0.00',
  `reason_of_payment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_bill_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_payable` decimal(10,2) DEFAULT '0.00',
  `amount_payable` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tds_percentage` decimal(5,2) DEFAULT '0.00',
  `total_deduction` decimal(10,2) DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ref_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_staff_id_foreign` (`staff_id`),
  KEY `payments_party_id_foreign` (`party_id`),
  KEY `payments_vendor_id_foreign` (`vendor_id`),
  KEY `payments_created_by_foreign` (`created_by`),
  KEY `payments_updated_by_foreign` (`updated_by`),
  KEY `payments_work_order_id_foreign` (`work_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_type`, `staff_id`, `party_id`, `material_inward_ids`, `vendor_id`, `work_order_id`, `salary_payable`, `expense_payable`, `total_payable`, `reason_of_payment`, `reason_bill_no`, `bill_payable`, `amount_payable`, `tds_percentage`, `total_deduction`, `paid_amount`, `ref_number`, `payment_date`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'vendor', NULL, NULL, NULL, 10, 1, 0.00, 0.00, 0.00, NULL, 'Advance', 192500.00, 40000.00, 1.00, 400.00, 40000.00, 'CT0ACTVNE5', '2026-04-07', NULL, 2, NULL, '2026-04-16 04:22:24', '2026-04-16 04:22:24');

-- --------------------------------------------------------

--
-- Table structure for table `pedhi`
--

DROP TABLE IF EXISTS `pedhi`;
CREATE TABLE IF NOT EXISTS `pedhi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `module`, `action`, `created_at`, `updated_at`) VALUES
(1, 'admin.dashboard', 'dashboard', 'dashboard', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(2, 'users.index', 'users', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(3, 'users.create', 'users', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(4, 'users.store', 'users', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(5, 'users.show', 'users', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(6, 'users.edit', 'users', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(7, 'users.update', 'users', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(8, 'users.destroy', 'users', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(9, 'departments.index', 'departments', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(10, 'departments.create', 'departments', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(11, 'departments.store', 'departments', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(12, 'departments.show', 'departments', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(13, 'departments.edit', 'departments', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(14, 'departments.update', 'departments', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(15, 'departments.destroy', 'departments', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(16, 'sub-departments.index', 'sub-departments', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(17, 'sub-departments.create', 'sub-departments', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(18, 'sub-departments.store', 'sub-departments', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(19, 'sub-departments.show', 'sub-departments', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(20, 'sub-departments.edit', 'sub-departments', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(21, 'sub-departments.update', 'sub-departments', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(22, 'sub-departments.destroy', 'sub-departments', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(23, 'division.getSubdepartments', 'division', 'getSubdepartments', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(24, 'division.index', 'division', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(25, 'division.create', 'division', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(26, 'division.store', 'division', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(27, 'division.show', 'division', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(28, 'division.edit', 'division', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(29, 'division.update', 'division', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(30, 'division.destroy', 'division', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(31, 'sub-division.index', 'sub-division', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(32, 'sub-division.create', 'sub-division', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(33, 'sub-division.store', 'sub-division', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(34, 'sub-division.show', 'sub-division', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(35, 'sub-division.edit', 'sub-division', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(36, 'sub-division.update', 'sub-division', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(37, 'sub-division.destroy', 'sub-division', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(38, 'pedhi.index', 'pedhi', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(39, 'pedhi.create', 'pedhi', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(40, 'pedhi.store', 'pedhi', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(41, 'pedhi.show', 'pedhi', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(42, 'pedhi.edit', 'pedhi', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(43, 'pedhi.update', 'pedhi', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(44, 'pedhi.destroy', 'pedhi', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(45, 'locations.getSubdepartments', 'locations', 'getSubdepartments', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(46, 'locations.getDivisions', 'locations', 'getDivisions', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(47, 'locations.getSubDivisions', 'locations', 'getSubDivisions', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(48, 'locations.index', 'locations', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(49, 'locations.create', 'locations', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(50, 'locations.store', 'locations', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(51, 'locations.show', 'locations', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(52, 'locations.edit', 'locations', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(53, 'locations.update', 'locations', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(54, 'locations.destroy', 'locations', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(55, 'works.getSubdepartments', 'works', 'getSubdepartments', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(56, 'works.getDivisions', 'works', 'getDivisions', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(57, 'works.getSubDivisions', 'works', 'getSubDivisions', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(58, 'works.getLocations', 'works', 'getLocations', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(59, 'works.index', 'works', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(60, 'works.create', 'works', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(61, 'works.store', 'works', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(62, 'works.show', 'works', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(63, 'works.edit', 'works', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(64, 'works.update', 'works', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(65, 'works.destroy', 'works', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(66, 'firms.index', 'firms', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(67, 'firms.create', 'firms', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(68, 'firms.store', 'firms', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(69, 'firms.show', 'firms', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(70, 'firms.edit', 'firms', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(71, 'firms.update', 'firms', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(72, 'firms.destroy', 'firms', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(73, 'staff.index', 'staff', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(74, 'staff.create', 'staff', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(75, 'staff.store', 'staff', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(76, 'staff.show', 'staff', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(77, 'staff.edit', 'staff', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(78, 'staff.update', 'staff', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(79, 'staff.destroy', 'staff', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(80, 'attendance.index', 'attendance', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(81, 'attendance.update', 'attendance', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(82, 'attendance.get', 'attendance', 'get', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(83, 'attendance.report', 'attendance', 'report', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(84, 'daily-expense.index', 'daily-expense', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(85, 'daily-expense.create', 'daily-expense', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(86, 'daily-expense.store', 'daily-expense', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(87, 'daily-expense.show', 'daily-expense', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(88, 'daily-expense.edit', 'daily-expense', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(89, 'daily-expense.update', 'daily-expense', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(90, 'daily-expense.destroy', 'daily-expense', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(91, 'parties.index', 'parties', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(92, 'parties.create', 'parties', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(93, 'parties.store', 'parties', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(94, 'parties.show', 'parties', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(95, 'parties.edit', 'parties', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(96, 'parties.update', 'parties', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(97, 'parties.destroy', 'parties', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(98, 'contractors.getWorksByLocations', 'contractors', 'getWorksByLocations', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(99, 'contractors.index', 'contractors', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(100, 'contractors.create', 'contractors', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(101, 'contractors.store', 'contractors', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(102, 'contractors.show', 'contractors', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(103, 'contractors.edit', 'contractors', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(104, 'contractors.update', 'contractors', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(105, 'contractors.destroy', 'contractors', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(106, 'site-progress.getWorksByLocation', 'site-progress', 'getWorksByLocation', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(107, 'site-progress.getStagesByWork', 'site-progress', 'getStagesByWork', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(108, 'site-progress.index', 'site-progress', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(109, 'site-progress.create', 'site-progress', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(110, 'site-progress.store', 'site-progress', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(111, 'site-progress.show', 'site-progress', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(112, 'site-progress.edit', 'site-progress', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(113, 'site-progress.update', 'site-progress', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(114, 'site-progress.destroy', 'site-progress', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(115, 'tool-lists.index', 'tool-lists', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(116, 'tool-lists.create', 'tool-lists', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(117, 'tool-lists.store', 'tool-lists', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(118, 'tool-lists.show', 'tool-lists', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(119, 'tool-lists.edit', 'tool-lists', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(120, 'tool-lists.update', 'tool-lists', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(121, 'tool-lists.destroy', 'tool-lists', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(122, 'scrap-materials.index', 'scrap-materials', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(123, 'scrap-materials.create', 'scrap-materials', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(124, 'scrap-materials.store', 'scrap-materials', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(125, 'scrap-materials.show', 'scrap-materials', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(126, 'scrap-materials.edit', 'scrap-materials', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(127, 'scrap-materials.update', 'scrap-materials', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(128, 'scrap-materials.destroy', 'scrap-materials', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(129, 'scrap-lists.index', 'scrap-lists', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(130, 'scrap-lists.create', 'scrap-lists', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(131, 'scrap-lists.store', 'scrap-lists', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(132, 'scrap-lists.show', 'scrap-lists', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(133, 'scrap-lists.edit', 'scrap-lists', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(134, 'scrap-lists.update', 'scrap-lists', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(135, 'scrap-lists.destroy', 'scrap-lists', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(136, 'site-material-requirements.getMaterialsByCategory', 'site-material-requirements', 'getMaterialsByCategory', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(137, 'site-material-requirements.getWorksByLocation', 'site-material-requirements', 'getWorksByLocation', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(138, 'site-material-requirements.index', 'site-material-requirements', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(139, 'site-material-requirements.create', 'site-material-requirements', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(140, 'site-material-requirements.store', 'site-material-requirements', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(141, 'site-material-requirements.show', 'site-material-requirements', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(142, 'site-material-requirements.edit', 'site-material-requirements', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(143, 'site-material-requirements.update', 'site-material-requirements', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(144, 'site-material-requirements.destroy', 'site-material-requirements', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(145, 'material-categories.index', 'material-categories', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(146, 'material-categories.create', 'material-categories', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(147, 'material-categories.store', 'material-categories', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(148, 'material-categories.show', 'material-categories', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(149, 'material-categories.edit', 'material-categories', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(150, 'material-categories.update', 'material-categories', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(151, 'material-categories.destroy', 'material-categories', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(152, 'material-lists.index', 'material-lists', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(153, 'material-lists.create', 'material-lists', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(154, 'material-lists.store', 'material-lists', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(155, 'material-lists.show', 'material-lists', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(156, 'material-lists.edit', 'material-lists', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(157, 'material-lists.update', 'material-lists', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(158, 'material-lists.destroy', 'material-lists', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(159, 'stages.index', 'stages', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(160, 'stages.create', 'stages', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(161, 'stages.store', 'stages', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(162, 'stages.show', 'stages', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(163, 'stages.edit', 'stages', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(164, 'stages.update', 'stages', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(165, 'stages.destroy', 'stages', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(166, 'material-inwards.getPartyDetails', 'material-inwards', 'getPartyDetails', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(167, 'material-inwards.getWorksByLocation', 'material-inwards', 'getWorksByLocation', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(168, 'material-inwards.getPartiesByLocation', 'material-inwards', 'getPartiesByLocation', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(169, 'material-inwards.getMaterialsByParty', 'material-inwards', 'getMaterialsByParty', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(170, 'material-inwards.index', 'material-inwards', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(171, 'material-inwards.create', 'material-inwards', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(172, 'material-inwards.store', 'material-inwards', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(173, 'material-inwards.show', 'material-inwards', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(174, 'material-inwards.edit', 'material-inwards', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(175, 'material-inwards.update', 'material-inwards', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(176, 'material-inwards.destroy', 'material-inwards', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(177, 'bill-inwards.getPartyDetails', 'bill-inwards', 'getPartyDetails', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(178, 'bill-inwards.getMaterialsByParty', 'bill-inwards', 'getMaterialsByParty', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(179, 'bill-inwards.index', 'bill-inwards', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(180, 'bill-inwards.create', 'bill-inwards', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(181, 'bill-inwards.store', 'bill-inwards', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(182, 'bill-inwards.show', 'bill-inwards', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(183, 'bill-inwards.edit', 'bill-inwards', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(184, 'bill-inwards.update', 'bill-inwards', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(185, 'bill-inwards.destroy', 'bill-inwards', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(186, 'bill-outwards.getPartyDetails', 'bill-outwards', 'getPartyDetails', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(187, 'bill-outwards.getMaterialsByParty', 'bill-outwards', 'getMaterialsByParty', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(188, 'bill-outwards.getWorksByParty', 'bill-outwards', 'getWorksByParty', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(189, 'bill-outwards.index', 'bill-outwards', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(190, 'bill-outwards.create', 'bill-outwards', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(191, 'bill-outwards.store', 'bill-outwards', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(192, 'bill-outwards.show', 'bill-outwards', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(193, 'bill-outwards.edit', 'bill-outwards', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(194, 'bill-outwards.update', 'bill-outwards', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(195, 'bill-outwards.destroy', 'bill-outwards', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(196, 'payments.getStaffPayable', 'payments', 'getStaffPayable', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(197, 'payments.getPartyBills', 'payments', 'getPartyBills', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(198, 'payments.getPartyMaterialInwards', 'payments', 'getPartyMaterialInwards', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(199, 'payments.getVendorBills', 'payments', 'getVendorBills', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(200, 'payments.index', 'payments', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(201, 'payments.create', 'payments', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(202, 'payments.store', 'payments', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(203, 'payments.show', 'payments', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(204, 'payments.edit', 'payments', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(205, 'payments.update', 'payments', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(206, 'payments.destroy', 'payments', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(207, 'work-orders.previewNumber', 'work-orders', 'previewNumber', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(208, 'work-orders.vendorAssignments', 'work-orders', 'vendorAssignments', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(209, 'work-orders.index', 'work-orders', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(210, 'work-orders.create', 'work-orders', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(211, 'work-orders.store', 'work-orders', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(212, 'work-orders.show', 'work-orders', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(213, 'work-orders.edit', 'work-orders', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(214, 'work-orders.update', 'work-orders', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(215, 'work-orders.destroy', 'work-orders', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(216, 'user.getProfile', 'profile', 'getProfile', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(217, 'user.editProfile', 'profile', 'editProfile', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(218, 'user.updateProfile', 'profile', 'updateProfile', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(219, 'user.changePassword', 'profile', 'changePassword', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(220, 'user.updatePassword', 'profile', 'updatePassword', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(221, 'gst-bill-lists.index', 'gst-bill-lists', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(222, 'gst-bill-lists.create', 'gst-bill-lists', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(223, 'gst-bill-lists.store', 'gst-bill-lists', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(224, 'gst-bill-lists.show', 'gst-bill-lists', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(225, 'gst-bill-lists.edit', 'gst-bill-lists', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(226, 'gst-bill-lists.update', 'gst-bill-lists', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(227, 'gst-bill-lists.destroy', 'gst-bill-lists', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(228, 'payment-slabs.index', 'payment-slabs', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(229, 'payment-slabs.create', 'payment-slabs', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(230, 'payment-slabs.store', 'payment-slabs', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(231, 'payment-slabs.show', 'payment-slabs', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(232, 'payment-slabs.edit', 'payment-slabs', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(233, 'payment-slabs.update', 'payment-slabs', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(234, 'payment-slabs.destroy', 'payment-slabs', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(235, 'roles.index', 'roles', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(236, 'roles.create', 'roles', 'create', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(237, 'roles.store', 'roles', 'store', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(238, 'roles.show', 'roles', 'show', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(239, 'roles.edit', 'roles', 'edit', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(240, 'roles.update', 'roles', 'update', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(241, 'roles.destroy', 'roles', 'destroy', '2026-05-09 18:25:05', '2026-05-09 18:25:05'),
(242, 'permissions.index', 'permissions', 'index', '2026-05-09 18:25:05', '2026-05-09 18:25:05');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-05-09 23:53:47', '2026-05-09 23:53:47'),
(2, 'staff', '2026-05-09 18:51:51', '2026-05-09 18:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=262 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 82, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(2, 1, 80, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(3, 1, 83, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(4, 1, 81, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(5, 1, 180, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(6, 1, 185, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(7, 1, 183, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(8, 1, 178, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(9, 1, 177, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(10, 1, 179, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(11, 1, 182, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(12, 1, 181, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(13, 1, 184, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(14, 1, 190, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(15, 1, 195, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(16, 1, 193, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(17, 1, 187, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(18, 1, 186, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(19, 1, 188, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(20, 1, 189, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(21, 1, 192, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(22, 1, 191, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(23, 1, 194, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(24, 1, 100, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(25, 1, 105, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(26, 1, 103, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(27, 1, 98, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(28, 1, 99, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(29, 1, 102, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(30, 1, 101, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(31, 1, 104, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(32, 1, 85, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(33, 1, 90, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(34, 1, 88, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(35, 1, 84, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(36, 1, 87, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(37, 1, 86, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(38, 1, 89, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(39, 1, 1, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(40, 1, 10, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(41, 1, 15, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(42, 1, 13, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(43, 1, 9, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(44, 1, 12, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(45, 1, 11, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(46, 1, 14, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(47, 1, 25, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(48, 1, 30, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(49, 1, 28, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(50, 1, 23, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(51, 1, 24, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(52, 1, 27, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(53, 1, 26, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(54, 1, 29, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(55, 1, 67, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(56, 1, 72, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(57, 1, 70, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(58, 1, 66, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(59, 1, 69, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(60, 1, 68, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(61, 1, 71, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(62, 1, 222, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(63, 1, 227, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(64, 1, 225, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(65, 1, 221, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(66, 1, 224, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(67, 1, 223, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(68, 1, 226, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(69, 1, 49, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(70, 1, 54, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(71, 1, 52, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(72, 1, 46, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(73, 1, 45, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(74, 1, 47, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(75, 1, 48, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(76, 1, 51, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(77, 1, 50, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(78, 1, 53, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(79, 1, 146, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(80, 1, 151, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(81, 1, 149, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(82, 1, 145, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(83, 1, 148, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(84, 1, 147, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(85, 1, 150, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(86, 1, 171, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(87, 1, 176, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(88, 1, 174, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(89, 1, 169, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(90, 1, 168, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(91, 1, 166, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(92, 1, 167, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(93, 1, 170, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(94, 1, 173, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(95, 1, 172, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(96, 1, 175, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(97, 1, 153, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(98, 1, 158, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(99, 1, 156, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(100, 1, 152, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(101, 1, 155, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(102, 1, 154, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(103, 1, 157, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(104, 1, 92, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(105, 1, 97, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(106, 1, 95, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(107, 1, 91, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(108, 1, 94, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(109, 1, 93, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(110, 1, 96, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(111, 1, 229, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(112, 1, 234, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(113, 1, 232, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(114, 1, 228, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(115, 1, 231, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(116, 1, 230, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(117, 1, 233, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(118, 1, 201, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(119, 1, 206, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(120, 1, 204, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(121, 1, 197, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(122, 1, 198, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(123, 1, 196, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(124, 1, 199, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(125, 1, 200, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(126, 1, 203, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(127, 1, 202, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(128, 1, 205, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(129, 1, 39, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(130, 1, 44, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(131, 1, 42, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(132, 1, 38, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(133, 1, 41, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(134, 1, 40, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(135, 1, 43, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(136, 1, 242, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(137, 1, 219, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(138, 1, 217, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(139, 1, 216, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(140, 1, 220, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(141, 1, 218, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(142, 1, 236, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(143, 1, 241, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(144, 1, 239, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(145, 1, 235, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(146, 1, 238, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(147, 1, 237, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(148, 1, 240, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(149, 1, 130, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(150, 1, 135, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(151, 1, 133, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(152, 1, 129, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(153, 1, 132, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(154, 1, 131, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(155, 1, 134, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(156, 1, 123, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(157, 1, 128, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(158, 1, 126, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(159, 1, 122, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(160, 1, 125, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(161, 1, 124, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(162, 1, 127, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(163, 1, 139, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(164, 1, 144, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(165, 1, 142, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(166, 1, 136, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(167, 1, 137, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(168, 1, 138, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(169, 1, 141, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(170, 1, 140, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(171, 1, 143, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(172, 1, 109, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(173, 1, 114, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(174, 1, 112, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(175, 1, 107, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(176, 1, 106, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(177, 1, 108, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(178, 1, 111, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(179, 1, 110, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(180, 1, 113, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(181, 1, 74, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(182, 1, 79, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(183, 1, 77, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(184, 1, 73, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(185, 1, 76, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(186, 1, 75, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(187, 1, 78, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(188, 1, 160, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(189, 1, 165, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(190, 1, 163, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(191, 1, 159, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(192, 1, 162, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(193, 1, 161, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(194, 1, 164, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(195, 1, 17, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(196, 1, 22, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(197, 1, 20, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(198, 1, 16, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(199, 1, 19, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(200, 1, 18, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(201, 1, 21, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(202, 1, 32, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(203, 1, 37, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(204, 1, 35, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(205, 1, 31, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(206, 1, 34, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(207, 1, 33, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(208, 1, 36, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(209, 1, 116, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(210, 1, 121, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(211, 1, 119, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(212, 1, 115, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(213, 1, 118, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(214, 1, 117, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(215, 1, 120, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(216, 1, 210, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(217, 1, 215, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(218, 1, 213, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(219, 1, 209, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(220, 1, 207, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(221, 1, 212, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(222, 1, 211, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(223, 1, 214, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(224, 1, 208, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(225, 1, 60, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(226, 1, 65, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(227, 1, 63, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(228, 1, 56, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(229, 1, 58, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(230, 1, 55, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(231, 1, 57, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(232, 1, 59, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(233, 1, 62, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(234, 1, 61, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(235, 1, 64, '2026-05-10 00:02:41', '2026-05-10 00:02:41'),
(236, 2, 82, NULL, NULL),
(237, 2, 80, NULL, NULL),
(238, 2, 83, NULL, NULL),
(239, 2, 81, NULL, NULL),
(240, 2, 1, NULL, NULL),
(241, 2, 116, NULL, NULL),
(242, 2, 121, NULL, NULL),
(243, 2, 119, NULL, NULL),
(244, 2, 115, NULL, NULL),
(245, 2, 118, NULL, NULL),
(246, 2, 117, NULL, NULL),
(247, 2, 120, NULL, NULL),
(248, 2, 85, NULL, NULL),
(249, 2, 90, NULL, NULL),
(250, 2, 88, NULL, NULL),
(251, 2, 84, NULL, NULL),
(252, 2, 87, NULL, NULL),
(253, 2, 86, NULL, NULL),
(254, 2, 89, NULL, NULL),
(255, 2, 74, NULL, NULL),
(256, 2, 79, NULL, NULL),
(257, 2, 77, NULL, NULL),
(258, 2, 73, NULL, NULL),
(259, 2, 76, NULL, NULL),
(260, 2, 75, NULL, NULL),
(261, 2, 78, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scrap_lists`
--

DROP TABLE IF EXISTS `scrap_lists`;
CREATE TABLE IF NOT EXISTS `scrap_lists` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `feriya` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `where_place` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `labour_of_scrape` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `material_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scrap_lists_material_id_foreign` (`material_id`),
  KEY `scrap_lists_created_by_foreign` (`created_by`),
  KEY `scrap_lists_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scrap_materials`
--

DROP TABLE IF EXISTS `scrap_materials`;
CREATE TABLE IF NOT EXISTS `scrap_materials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scrap_materials_created_by_foreign` (`created_by`),
  KEY `scrap_materials_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('TA5SLQwOOAjKNJO6wG8Br7AhuPgbWuE9anLsWQcg', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVXlEQnRGV3d0ZnZ1UDJOd044bllqWUxKTmZ0SzE1elVQbmpCNk9UdCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3N0YWZmIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yb2xlcyI7czo1OiJyb3V0ZSI7czoxMToicm9sZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1780412369),
('Vjp63AAu65mLKYJ042onn1ksLcin1OfENKWOYw9H', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZGVJOGZuVU01MXRDdXh0VE9Qajh6eVZ4cWgwMVhmb0RzcWp5WHhjeiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3dvcmtzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC93b3JrcyI7czo1OiJyb3V0ZSI7czoxMToid29ya3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1780584224);

-- --------------------------------------------------------

--
-- Table structure for table `site_materials`
--

DROP TABLE IF EXISTS `site_materials`;
CREATE TABLE IF NOT EXISTS `site_materials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `party_id` bigint UNSIGNED DEFAULT NULL,
  `gst` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_inward` tinyint(1) NOT NULL DEFAULT '0',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_materials_location_id_foreign` (`location_id`),
  KEY `site_materials_created_by_foreign` (`created_by`),
  KEY `site_materials_updated_by_foreign` (`updated_by`),
  KEY `site_materials_party_id_foreign` (`party_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_material_details`
--

DROP TABLE IF EXISTS `site_material_details`;
CREATE TABLE IF NOT EXISTS `site_material_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `site_material_id` bigint UNSIGNED NOT NULL,
  `material_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `gst` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_material_details_site_material_id_foreign` (`site_material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_material_requirements`
--

DROP TABLE IF EXISTS `site_material_requirements`;
CREATE TABLE IF NOT EXISTS `site_material_requirements` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `work_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_material_requirements_location_id_foreign` (`location_id`),
  KEY `site_material_requirements_created_by_foreign` (`created_by`),
  KEY `site_material_requirements_updated_by_foreign` (`updated_by`),
  KEY `site_material_requirements_work_id_foreign` (`work_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_material_requirements`
--

INSERT INTO `site_material_requirements` (`id`, `location_id`, `work_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 4, 4, 2, NULL, '2026-03-05 04:21:21', '2026-03-05 04:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `site_material_requirement_details`
--

DROP TABLE IF EXISTS `site_material_requirement_details`;
CREATE TABLE IF NOT EXISTS `site_material_requirement_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `site_material_requirement_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED DEFAULT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `time_within_days` int DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `smr_details_smr_id_fk` (`site_material_requirement_id`),
  KEY `site_material_requirement_details_material_id_foreign` (`material_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_material_requirement_details`
--

INSERT INTO `site_material_requirement_details` (`id`, `site_material_requirement_id`, `material_id`, `unit`, `quantity`, `date`, `time_within_days`, `remark`, `created_at`, `updated_at`) VALUES
(5, 4, 1, 'Bag', 50.00, '2026-03-05', 2, NULL, '2026-03-05 04:21:21', '2026-03-05 04:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `site_progress`
--

DROP TABLE IF EXISTS `site_progress`;
CREATE TABLE IF NOT EXISTS `site_progress` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `work_id` bigint UNSIGNED DEFAULT NULL,
  `work_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_site` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_stage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `stage_id` bigint UNSIGNED DEFAULT NULL,
  `stage_percentage` decimal(5,2) DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_progress_created_by_foreign` (`created_by`),
  KEY `site_progress_updated_by_foreign` (`updated_by`),
  KEY `site_progress_location_id_foreign` (`location_id`),
  KEY `site_progress_work_id_foreign` (`work_id`),
  KEY `site_progress_stage_id_foreign` (`stage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_progress`
--

INSERT INTO `site_progress` (`id`, `location_id`, `work_id`, `work_name`, `work_site`, `work_stage`, `stage_id`, `stage_percentage`, `remark`, `photo_url`, `date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 13, 3, 'RFO Office & Quarter', 'RFO Office & Quarter', 'Plaster, Tiles and Other Flooring, Upto Plith, Upto slab', 7, 95.00, NULL, NULL, '2026-04-07', 2, 2, '2026-04-07 08:56:56', '2026-04-25 16:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `second_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `designation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `present_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_contact_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relative_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relative_mobile_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced','Widowed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uan_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esic_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_leaving` date DEFAULT NULL,
  `no_of_years_service` int DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rate_per_day` decimal(10,2) DEFAULT NULL,
  `rate_per_month` decimal(10,2) DEFAULT NULL,
  `salary_date` date DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_code_unique` (`code`),
  KEY `staff_created_by_foreign` (`created_by`),
  KEY `staff_updated_by_foreign` (`updated_by`),
  KEY `staff_user_id_foreign` (`user_id`),
  KEY `staff_location_id_foreign` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `code`, `first_name`, `last_name`, `second_name`, `dob`, `doj`, `designation`, `location_id`, `photo`, `permanent_address`, `present_address`, `mobile_number`, `other_contact_number`, `relative_name`, `relation`, `relative_mobile_no`, `gender`, `marital_status`, `blood_group`, `aadhar_no`, `pan_no`, `uan_no`, `esic_no`, `bank_name`, `bank_account_no`, `ifsc_code`, `date_of_leaving`, `no_of_years_service`, `remark`, `rate_per_day`, `rate_per_month`, `salary_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, NULL, 'STF0001', 'Vallabh', 'Rathod', 'Arjanbhai', '1979-06-01', '2026-04-01', 'Supervisor', NULL, 'https://staging-demo.com/somnath/public/images/staff/1775320541.jpg', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', '7861845910', '9638744276', 'Santokben', 'Wife', '9712475915', 'Male', 'Married', NULL, '729024886439', 'FWFPR6154A', NULL, NULL, 'State Bank of India', '40862666277', 'SBIN0015325', NULL, NULL, 'NO', 500.00, 15000.00, '2026-04-01', 2, 2, '2026-04-04 11:05:41', '2026-04-04 17:48:19'),
(4, NULL, 'STF0002', 'Dilip', 'Sonagara', 'Nanjibhai', '2002-04-12', '2026-04-01', 'Supervisor', NULL, 'https://staging-demo.com/somnath/public/images/staff/1775342798.jpg', 'At-Udepur(Sidasara),Ta-Kalyanpur,Districts-Devbhumi Dwarka-361315', NULL, '9081972980', NULL, 'Nanjibhai Sonagara', 'Father', NULL, 'Male', 'Single', NULL, '948147989030', 'NFTPS6843Q', NULL, NULL, 'Bank of Baroda', '36958100002970', 'BARB0BHATIA', NULL, NULL, 'No', 800.00, 24000.00, '2026-04-01', 2, 2, '2026-04-04 17:16:38', '2026-04-05 21:31:46'),
(5, NULL, 'STF0003', 'Bhavesh', 'Kanzariya', 'Devrajbhai', '1995-03-25', '2026-04-01', 'Supervisor', NULL, 'https://staging-demo.com/somnath/public/images/staff/1775344143.jpg', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', '8160459138', NULL, 'Devrajbhai Kanzariya', 'Father', NULL, 'Male', 'Married', 'O+', '476002335628', 'DAQPK1904N', '101066397962', NULL, 'State Bank of India', '38408230827', 'SBIN0015325', NULL, NULL, 'No', 600.00, 18000.00, '2026-04-01', 2, 2, '2026-04-04 17:39:03', '2026-04-05 21:32:02'),
(6, NULL, 'STF0004', 'Savji', 'Parmar', 'Devshibhai', '1987-12-20', '2026-04-01', 'Supervisor', NULL, 'https://staging-demo.com/somnath/public/images/staff/1775344586.jpg', 'At. Haripar, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361320', 'At. Haripar, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361320', '9726961263', NULL, 'Kishorbhai Parmar', 'Brother', '9879767030', 'Male', 'Married', NULL, '813667558697', 'CPNPP3332J', NULL, NULL, 'State Bank of India', '20229750091', 'SBIN0060097', NULL, NULL, 'No', 1200.00, 36000.00, '2026-04-01', 2, 2, '2026-04-04 17:46:26', '2026-04-05 21:32:28'),
(7, 4, 'STF0005', 'Manishbhai', 'Nakum', 'Ladhabhai', '1998-06-18', '2026-04-01', 'Supervisor', NULL, 'https://staging-demo.com/somnath/public/images/staff/1775475744.jpeg', 'At. Nandana, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', NULL, '8238834326', NULL, 'Lalabhai Ladhabhai Nakum', 'Brother', '9714317750', 'Male', 'Single', NULL, '734522258050', 'CBGPN5411H', NULL, NULL, 'State Bank of India', '33396663734', 'SBIN0060346', NULL, NULL, 'No', 1000.00, 30000.00, '2026-04-01', 2, 2, '2026-04-04 17:54:17', '2026-05-09 18:41:54'),
(8, 3, 'STF0006', 'Hardik', 'Sonagara', 'Khimabhai', '2004-09-09', '2026-04-01', 'Supervisor', NULL, 'https://staging-demo.com/somnath/public/images/staff/1775345389.jpg', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', '6359850618', NULL, 'Khimabhai Sonagara', 'Father', '9687943812', 'Male', 'Single', NULL, '719504913124', 'OTYPK2545F', '102272319235', NULL, 'State Bank of India', '33559815797', 'SBIN0060093', NULL, NULL, 'NO', 500.00, 15000.00, '2026-04-01', 2, 2, '2026-04-04 17:59:49', '2026-04-25 15:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `staff_locations`
--

DROP TABLE IF EXISTS `staff_locations`;
CREATE TABLE IF NOT EXISTS `staff_locations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_locations_staff_id_location_id_unique` (`staff_id`,`location_id`),
  KEY `staff_locations_location_id_foreign` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_locations`
--

INSERT INTO `staff_locations` (`id`, `staff_id`, `location_id`, `created_at`, `updated_at`) VALUES
(1, 8, 18, '2026-04-25 15:19:59', '2026-04-25 15:19:59'),
(2, 8, 8, '2026-04-25 15:19:59', '2026-04-25 15:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

DROP TABLE IF EXISTS `stages`;
CREATE TABLE IF NOT EXISTS `stages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `work_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stages_location_id_foreign` (`location_id`),
  KEY `stages_work_id_foreign` (`work_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stages`
--

INSERT INTO `stages` (`id`, `name`, `percentage`, `location_id`, `work_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 'Upto Plith', 20.00, 13, 3, 2, 2, '2026-04-07 08:46:51', '2026-04-07 08:46:51'),
(6, 'Upto slab', 30.00, 13, 3, 2, 2, '2026-04-07 08:47:48', '2026-04-07 08:47:48'),
(7, 'Plaster', 20.00, 13, 3, 2, 2, '2026-04-07 08:54:05', '2026-04-07 08:54:05'),
(8, 'Tiles and Other Flooring', 25.00, 13, 3, 2, 2, '2026-04-07 08:54:37', '2026-04-07 08:54:37'),
(9, 'Work Fonal', 100.00, 13, 3, 2, 2, '2026-04-07 08:54:59', '2026-04-25 16:05:11'),
(10, 'adfsdf', 23.00, 18, 7, 2, 2, '2026-04-25 16:04:56', '2026-04-25 16:04:56'),
(11, '3asdf', 33.00, 18, 7, 2, 2, '2026-04-25 16:04:56', '2026-04-25 16:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `subdepartments`
--

DROP TABLE IF EXISTS `subdepartments`;
CREATE TABLE IF NOT EXISTS `subdepartments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subdepartments_department_id_foreign` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subdepartments`
--

INSERT INTO `subdepartments` (`id`, `name`, `department_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 'DCF, SOCIAL FORESTRY DIVISION', 3, 2, 2, '2026-04-05 21:35:53', '2026-04-05 21:35:53'),
(4, 'Sikka Thermal Power Station', 5, 2, 2, '2026-04-05 21:34:32', '2026-04-05 21:38:45'),
(6, 'Wild Ass Sanctuary-Dhangadhra', 3, 2, 2, '2026-04-05 21:37:19', '2026-04-05 21:37:19'),
(7, 'Panchayat Raod & Building', 4, 2, 2, '2026-04-05 21:39:58', '2026-04-05 21:39:58'),
(8, 'Samagra Shiksha-Gujarat Council of School Education', 6, 2, 2, '2026-04-09 05:28:51', '2026-04-09 05:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `sub_divisions`
--

DROP TABLE IF EXISTS `sub_divisions`;
CREATE TABLE IF NOT EXISTS `sub_divisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `head_of_sub_division` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name_of_sub_div_head` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_div_contact_person_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_divisions_division_id_foreign` (`division_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_divisions`
--

INSERT INTO `sub_divisions` (`id`, `name`, `division_id`, `head_of_sub_division`, `address`, `name_of_sub_div_head`, `head_mobile_number`, `sub_div_contact_person_name`, `contact_person_name`, `contact_person_mobile_number`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'RFO- Dhrol', 4, 'RFO', 'Range Forest Office, Nr. Chamunda Plot, Jodiya Road, Dhrol', 'Pradipshinh Jorubha Jadeja', NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:33:49', '2026-04-05 22:33:49'),
(2, 'RFO- Kalyanpur', 4, 'RFO', 'At. Kalyanpur, Raval Road, Nr. Mamalatdar Office-361320', 'Dangarsir', NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:36:01', '2026-04-05 22:36:01'),
(3, 'RFO- Dwarka', 4, 'RFO', 'Dwarka', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:36:38', '2026-04-05 22:36:38'),
(4, 'RFO- Kalavad', 4, 'RFO', 'Kalavad', 'Jadejasir', NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:38:03', '2026-04-05 22:38:03'),
(5, 'RFO- Jamnagar', 4, 'RFO', 'Van Sankul, Jamnagar', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:38:41', '2026-04-05 22:38:41'),
(6, 'RFO- Bhanvad', 4, 'RFO', 'Bhanvad', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:39:38', '2026-04-05 22:39:38'),
(7, 'Tankar- Sub Division', 1, 'Dy. Executive Engineer', 'Tankara', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:41:05', '2026-04-05 22:41:05'),
(8, 'Morbi-Sub Division', 1, 'Dy. Executive Engineer', 'Morbi', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:41:32', '2026-04-05 22:41:32'),
(9, 'Wankaner- Sub Division', 1, 'Dy. Executive Engineer', 'Wankaner', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:42:09', '2026-04-05 22:42:09'),
(10, 'Jamnagar- Sub Division', 2, 'Dy. Executive Engineer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:43:18', '2026-04-05 22:43:18'),
(11, 'Dhrol- Sub Division', 2, 'Dy. Executive Engineer', 'Jodiya na naka, Dhrol', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:43:55', '2026-04-05 22:43:55'),
(12, 'Kalyanpur- Sub Division', 3, 'Dy. Executive Engineer', 'Nr. Animal Hospital-Dwarka', 'Chopadabhai', NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:44:52', '2026-04-05 22:44:52'),
(13, 'Colony STPS', 6, 'Executive Engineer', NULL, 'Ramoliyasir', NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:46:02', '2026-04-05 22:46:02'),
(14, 'Plant STPS', 6, 'Executive Engineer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-05 22:46:30', '2026-04-05 22:46:30'),
(15, 'RFO- Halvad', 5, 'RFO', 'Halvad', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-06 06:33:48', '2026-04-06 06:33:48'),
(16, 'K R SAVANI', 7, 'PARTNER', 'K R SAVANI, 218-B/4, Supar Mall-I,Infocity, Gandhinagar-382007', 'GOKARBHAI DABHI', '9979896201', NULL, NULL, NULL, NULL, 2, 2, '2026-04-09 05:33:16', '2026-04-09 05:33:16'),
(17, 'RFO-Khambhaliya', 4, 'RFO', 'Khambhaliya', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-17 03:03:40', '2026-04-17 03:03:40'),
(18, 'RFO-JamJodhpur', 4, 'RFO', 'Jam Jodhpur', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2026-04-17 03:04:10', '2026-04-17 03:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `tool_lists`
--

DROP TABLE IF EXISTS `tool_lists`;
CREATE TABLE IF NOT EXISTS `tool_lists` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `shelf_location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `person_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tool_lists_created_by_foreign` (`created_by`),
  KEY `tool_lists_updated_by_foreign` (`updated_by`),
  KEY `tool_lists_location_id_foreign` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tool_lists`
--

INSERT INTO `tool_lists` (`id`, `location_id`, `shelf_location`, `name`, `quantity`, `person_name`, `date`, `price`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 'Grinder', 1.00, 'Vijay', '2026-03-04', 1500.00, NULL, 2, NULL, '2026-03-04 21:26:56', '2026-03-04 21:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_staff` bigint UNSIGNED NOT NULL DEFAULT '0',
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `e_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_staff`, `role_id`, `phone`, `dob`, `e_phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-12-29 00:41:04', '$2y$12$1mIBkDi.bmhDZPHGUoXpHOuGCamXt7fwF63sm8fGjhpH1XYmAi7MC', 1, NULL, NULL, NULL, NULL, NULL, '4WoNgT4jS0', '2025-12-29 00:41:06', '2026-06-06 13:47:40'),
(2, 'Super Admin', 'admin@gmail.com', '2026-05-05 09:26:12', '$2y$12$G6hyy5uRass/tgoGI8trpOCAZyF9YBHi0KynYNRIwX4LrU0nqP6X6', 0, 1, '1234567890', '1990-01-01', '7894561230', '123 Admin Street, City, Country', NULL, '2025-12-29 00:42:45', '2026-06-06 13:52:46'),
(3, 'Hardik Sonagara', 'hardik@gmail.com', NULL, '$2y$12$Qw8u/ACK/UNu8EmgVCTkZeIv.EL29p94s70SD3fiOchxwKGomCa7i', 1, 2, '6359850618', '2004-09-09', NULL, 'At. Kenedi, Ta. Kalyanpur, Dist. Devbhumi Dwarka-361315', NULL, '2026-04-25 15:19:59', '2026-05-09 18:52:02'),
(4, 'Manishbhai Nakum', 'manish@gmail.com', NULL, '$2y$12$b4WvHkfjgjErp3kqq.pwL.ewdyeynzD.oNH.sVdHHa92s/CulIcii', 1, 2, '8238834326', '1998-06-18', NULL, NULL, NULL, '2026-05-09 18:41:54', '2026-05-09 18:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
CREATE TABLE IF NOT EXISTS `works` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `firm_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `subdepartment_id` bigint UNSIGNED DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `sub_division_id` bigint UNSIGNED DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `name_of_work` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_of_work` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tender_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimate_cost` decimal(15,2) DEFAULT NULL,
  `equal_above_below_on_estimate` enum('0','+','-') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_amt_of_work` decimal(15,2) DEFAULT NULL,
  `add_18_percent_gst` decimal(15,2) DEFAULT NULL,
  `gst_amount` decimal(15,2) DEFAULT NULL,
  `our_final_work_amt` decimal(15,2) DEFAULT NULL,
  `time_limit_years_months` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_order_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wo_date` date DEFAULT NULL,
  `end_date_of_work` date DEFAULT NULL,
  `work_start_date` date DEFAULT NULL,
  `if_extend_date` tinyint(1) NOT NULL DEFAULT '0',
  `extended_date` date DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `works_firm_id_foreign` (`firm_id`),
  KEY `works_department_id_foreign` (`department_id`),
  KEY `works_subdepartment_id_foreign` (`subdepartment_id`),
  KEY `works_division_id_foreign` (`division_id`),
  KEY `works_sub_division_id_foreign` (`sub_division_id`),
  KEY `works_location_id_foreign` (`location_id`),
  KEY `works_created_by_foreign` (`created_by`),
  KEY `works_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `works`
--

INSERT INTO `works` (`id`, `firm_id`, `department_id`, `subdepartment_id`, `division_id`, `sub_division_id`, `location_id`, `name_of_work`, `description_of_work`, `tender_id`, `estimate_cost`, `equal_above_below_on_estimate`, `final_amt_of_work`, `add_18_percent_gst`, `gst_amount`, `our_final_work_amt`, `time_limit_years_months`, `work_order_no`, `wo_date`, `end_date_of_work`, `work_start_date`, `if_extend_date`, `extended_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 5, 4, 1, 5, 'Shed, Fogger Germination', NULL, NULL, NULL, NULL, 0.00, 18.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-06 06:45:09', '2026-04-06 06:45:09'),
(2, 2, 3, 5, 4, 2, 7, 'Canteen,Ocean Wave', NULL, NULL, NULL, NULL, 0.00, 18.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-07 07:56:30', '2026-04-07 07:56:30'),
(3, 2, 3, 6, 5, 15, 13, 'RFO Office & Quarter', NULL, NULL, NULL, NULL, 0.00, 18.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-07 07:57:25', '2026-04-07 07:57:25'),
(4, 2, 3, 6, 5, 15, 14, 'Forester Quarter', 'Con. of Forester Quarter At Sara Chokdi', '247724', 1636582.00, '-', 1610396.69, 18.00, 289871.40, 1900268.09, '0-6', '4475-79/2025-26', '2025-12-18', '2026-04-30', '2025-12-20', 0, NULL, 2, 2, '2026-04-07 08:02:15', '2026-04-07 08:02:15'),
(5, 3, 3, 5, 4, 5, 16, 'Jamnagar Guard Quarter', NULL, NULL, NULL, NULL, 0.00, 18.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-07 08:03:43', '2026-04-07 08:03:43'),
(6, 1, 4, 7, 1, 9, 17, 'Pipaliyaraj G.P.', NULL, NULL, 2078543.00, '0', 2078543.00, 18.00, 374137.74, 2452680.74, '0-6', 'DPMRB/0075/02/2026', '2026-02-05', '2026-11-04', '2026-03-01', 0, NULL, 2, 2, '2026-04-07 08:07:08', '2026-04-07 08:07:08'),
(7, 1, 4, 7, 1, 9, 18, 'Bhatia G.P.', NULL, NULL, 2078543.00, '0', 2078543.00, 18.00, 374137.74, 2452680.74, '0-9', 'DPMRB/0075/02/2026', '2026-02-05', '2026-11-04', '2026-03-01', 0, NULL, 2, 2, '2026-04-07 08:09:40', '2026-04-07 08:09:40'),
(8, 1, 4, 7, 1, 8, 20, 'Jepur G.P.', NULL, NULL, 2078543.00, '0', 2078543.00, 18.00, 374137.74, 2452680.74, '0-9', 'DPMRB/0325/01/2026', '2026-01-28', '2026-10-27', '2026-03-01', 0, NULL, 2, 2, '2026-04-07 08:14:01', '2026-04-07 08:14:01'),
(9, 1, 4, 7, 1, 8, 21, 'Panchasar G.P.', NULL, NULL, 2078543.00, '0', 2078543.00, 18.00, 374137.74, 2452680.74, NULL, 'DPMRB/0325/01/2026', '2026-01-28', '2026-10-27', '2026-03-01', 0, NULL, 2, 2, '2026-04-07 08:15:34', '2026-04-07 08:15:34'),
(10, 2, 6, 8, 7, 16, 24, 'KanyaShala & Kumarshala', NULL, NULL, 28359700.00, '0', 28359700.00, 18.00, 5104746.00, 33464446.00, NULL, 'SS/Civil/57640-641', '2024-12-06', NULL, NULL, 0, NULL, 2, 2, '2026-04-09 05:44:05', '2026-04-09 05:44:05'),
(11, 1, 3, 5, 4, 17, 26, 'Garden Work Salaya', 'Garden Work At Salaya', '249646', 11534345.00, '-', 10657734.78, 18.00, 1918392.26, 12576127.04, '0-6', NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-17 03:08:32', '2026-04-17 03:08:32'),
(12, 1, 3, 5, 4, 18, 27, 'JamJodhpur Garden Work', 'JamJodhpur Garden Work', '249681', 11033458.00, '-', 10194915.19, 18.00, 1835084.73, 12029999.93, '0-6', NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-17 03:10:08', '2026-04-17 03:10:08'),
(13, 2, 3, 5, 4, 2, 25, 'Raval Garden Work', 'Raval Garden Work', '249842', 5514614.00, '-', 5095503.34, 18.00, 917190.60, 6012693.94, '0-6', NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-17 03:11:11', '2026-04-17 03:11:11'),
(14, 1, 4, 7, 2, 11, 28, 'Dhrol All GramPanchayat', NULL, NULL, NULL, NULL, 0.00, 18.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, NULL, 2, 2, '2026-04-17 11:47:51', '2026-04-17 11:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `work_orders`
--

DROP TABLE IF EXISTS `work_orders`;
CREATE TABLE IF NOT EXISTS `work_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `work_order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_prefix` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'GP',
  `fiscal_year_label` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence_number` int UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `contractor_id` bigint UNSIGNED NOT NULL,
  `subject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `condition_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_order_value` decimal(15,2) NOT NULL DEFAULT '0.00',
  `vendor_paid_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `time_limit_for_work` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_condition` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `work_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `work_orders_work_order_number_unique` (`work_order_number`),
  KEY `work_orders_contractor_id_foreign` (`contractor_id`),
  KEY `work_orders_work_id_foreign` (`work_id`),
  KEY `work_orders_created_by_foreign` (`created_by`),
  KEY `work_orders_updated_by_foreign` (`updated_by`),
  KEY `work_orders_fiscal_year_label_sequence_number_index` (`fiscal_year_label`,`sequence_number`),
  KEY `work_orders_location_id_foreign` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_orders`
--

INSERT INTO `work_orders` (`id`, `work_order_number`, `number_prefix`, `fiscal_year_label`, `sequence_number`, `order_date`, `contractor_id`, `subject`, `condition_text`, `total_order_value`, `vendor_paid_total`, `time_limit_for_work`, `payment_condition`, `location_id`, `work_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'GP/001/2026-27', 'GP', '2026-27', 1, '2026-04-16', 10, 'Centring Work', 'All Centring Work', 192500.00, 40000.00, '3', 'As Per Work', 21, 9, 2, 2, '2026-04-16 04:20:07', '2026-04-16 04:22:24'),
(2, 'RNB/MRB/W.O./002/2026-27', 'RNB/MRB/W.O.', '2026-27', 2, '2026-04-25', 8, 'sdsdf', 'sdfsdf', 99.00, 0.00, 'asdfasdfa', 'asdfsadf', 7, NULL, 2, 2, '2026-04-25 16:20:35', '2026-04-25 16:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_details`
--

DROP TABLE IF EXISTS `work_order_details`;
CREATE TABLE IF NOT EXISTS `work_order_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `work_order_id` bigint UNSIGNED NOT NULL,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `work_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_order_details_work_order_id_foreign` (`work_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_order_details`
--

INSERT INTO `work_order_details` (`id`, `work_order_id`, `sort_order`, `work_details`, `quantity`, `unit`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
(2, 1, 0, 'Cement', 30.0000, '93', 393.00, 11790.00, '2026-04-01 22:10:50', '2026-04-01 22:10:50'),
(3, 2, 0, 'Labour All', 1.0000, 'Job', 11000.00, 11000.00, '2026-04-01 22:12:42', '2026-04-01 22:12:42'),
(4, 1, 0, 'Centring Work', 1375.0000, 'SqFt', 140.00, 192500.00, '2026-04-16 04:20:07', '2026-04-16 04:20:07'),
(5, 2, 0, 'sdfaf', 3.0000, '33', 33.00, 99.00, '2026-04-25 16:20:35', '2026-04-25 16:20:35');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
