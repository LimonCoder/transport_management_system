-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2022 at 08:50 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vehicle_apps`
--

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `org_code`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 369949, 'মেয়র', NULL, '2021-05-25 23:26:46', '2021-11-07 00:24:46'),
(2, 369949, 'নির্বাহী প্রকৌশলী', NULL, '2021-05-25 23:26:46', '2021-11-07 00:24:49'),
(3, 369949, 'সহকারী প্রকৌশলী', NULL, '2021-06-23 01:34:33', '2021-11-07 00:24:53'),
(4, 369949, 'কঞ্জারভেন্সি শাখা', NULL, '2021-07-15 03:03:26', '2021-11-07 00:24:56'),
(5, 369949, 'সচিব', NULL, '2021-07-15 12:30:23', '2021-11-07 00:25:00'),
(7, 369949, 'উপ-সহকারী প্রকৌশলী', NULL, '2021-07-15 12:37:04', '2021-11-07 00:25:04'),
(8, 369949, 'ইলেকট্রিক শাখা', NULL, '2021-07-18 05:22:18', '2021-11-07 00:25:07'),
(9, 369949, 'মেডিক্যাল অফিসার', NULL, '2021-07-18 05:25:51', '2021-11-07 00:25:10'),
(10, 369949, 'বস্তি উন্নয়ন কর্মকর্তা', NULL, '2021-08-17 06:01:30', '2021-11-07 00:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `driver_info`
--

CREATE TABLE `driver_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver_info`
--

INSERT INTO `driver_info` (`id`, `org_code`, `name`, `mobile_no`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 369949, 'মো:মঈনুল হোসেন মনু', NULL, 'default.png', '2021-07-13 03:56:12', '2021-07-13 03:56:12', NULL),
(7, 369949, 'মো:সেলিম', NULL, 'default.png', '2021-07-13 03:54:58', '2021-07-13 03:54:58', NULL),
(4, 34535, 'Md. Fauk', '01745652514', 'default.png', '2021-06-23 02:07:14', '2021-06-23 02:07:14', NULL),
(5, 1122003, 'Ohid', '01840210466', 'default.png', '2021-06-23 04:16:21', '2021-06-23 04:16:21', NULL),
(6, 1122003, 'Kasem', '01840210466', 'default.png', '2021-06-23 04:37:41', '2021-06-23 04:37:41', NULL),
(9, 369949, 'মো:রশীদ', NULL, 'default.png', '2021-07-15 11:04:57', '2021-07-15 11:04:57', NULL),
(10, 369949, 'মো:জাহাঙ্গীর', NULL, 'default.png', '2021-07-15 11:05:25', '2021-07-15 11:05:25', NULL),
(11, 369949, 'মোঃআব্দুল মান্নান', NULL, 'default.png', '2021-07-15 11:11:02', '2021-07-15 11:11:02', NULL),
(12, 369949, 'মো:আব্দুল মজীদ', NULL, 'default.png', '2021-07-15 11:14:04', '2021-07-15 11:14:04', NULL),
(13, 369949, 'মো:সফিউল আলম', NULL, 'default.png', '2021-07-15 11:56:41', '2021-07-15 11:56:41', NULL),
(14, 369949, 'মো:তোফাজ্জল হোসেন', NULL, 'default.png', '2021-07-15 11:57:19', '2021-07-15 11:57:19', NULL),
(15, 369949, 'মো:শহীদ', NULL, 'default.png', '2021-07-15 11:59:19', '2021-07-15 11:59:19', NULL),
(16, 369949, 'মো:মাসুদ রানা', NULL, 'default.png', '2021-07-15 12:00:22', '2021-07-15 12:00:22', NULL),
(17, 369949, 'মো:জসীম উদ্দীন ভূইয়া', NULL, 'default.png', '2021-07-15 12:02:12', '2021-07-15 12:02:12', NULL),
(18, 369949, 'মোঃ নুরআালম', NULL, 'default.png', '2021-07-15 12:02:48', '2021-07-15 12:02:48', NULL),
(19, 369949, 'মোঃ জাহাঙ্গীর আালম', NULL, 'default.png', '2021-07-15 12:03:14', '2021-07-15 12:03:14', NULL),
(20, 369949, 'মোঃ ইব্রাহীম', NULL, 'default.png', '2021-07-15 12:04:09', '2021-07-15 12:04:09', NULL),
(21, 369949, 'মোঃ মোরশেদ', NULL, 'default.png', '2021-07-15 12:06:44', '2021-07-15 12:06:44', NULL),
(22, 369949, 'মোঃ আজীজ', NULL, 'default.png', '2021-07-15 12:07:07', '2021-07-15 12:07:07', NULL),
(23, 369949, 'মোঃ ইসমাইল হোসেন', NULL, 'default.png', '2021-07-15 12:08:02', '2021-07-15 12:08:02', NULL),
(24, 369949, 'মোঃ আনোয়ার হোসেন', NULL, 'default.png', '2021-07-15 12:08:26', '2021-07-15 12:08:26', NULL),
(25, 369949, 'কিরন চন্দ্র দেব', NULL, 'default.png', '2021-07-15 12:09:35', '2021-07-15 12:09:35', NULL),
(26, 369949, 'মোঃ আনোয়ার', NULL, 'default.png', '2021-07-15 12:10:01', '2021-07-15 12:10:01', NULL),
(27, 369949, 'গনেশ', NULL, 'default.png', '2021-07-15 12:10:16', '2021-07-15 12:10:16', NULL),
(28, 369949, 'অপু হরিজন', NULL, 'default.png', '2021-07-15 12:10:37', '2021-07-15 12:10:37', NULL),
(29, 369949, 'মোঃ নুরুল আাবসার হোনা', NULL, 'default.png', '2021-07-15 12:11:20', '2021-07-15 12:11:20', NULL),
(30, 369949, 'মোঃ নুর মোহাম্মদ', NULL, 'default.png', '2021-07-15 12:11:42', '2021-07-15 12:11:42', NULL),
(31, 369949, 'মোঃ জসীম', NULL, 'default.png', '2021-07-15 12:11:58', '2021-07-15 12:11:58', NULL),
(32, 369949, 'মো:হেলাল', NULL, 'default.png', '2021-07-27 00:04:15', '2021-07-27 00:04:15', NULL),
(33, 369949, 'মো:আকবর হোসেন', NULL, 'default.png', '2021-07-27 00:19:44', '2021-07-27 00:19:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `designation_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `org_code`, `designation_id`, `name`, `mobile_no`, `email`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(43, 369949, 7, 'মাহমুদুল হাসান', '01673757383', NULL, 'default.png', '2021-07-26 23:58:01', NULL, NULL),
(41, 369949, 5, 'মোঃ আবুজর গিফারী', NULL, NULL, 'default.png', '2021-07-15 12:32:15', NULL, NULL),
(40, 369949, 2, 'মোঃ আজীজুল হক', NULL, NULL, 'default.png', '2021-07-15 12:28:04', NULL, NULL),
(44, 369949, 10, 'মো:নবী পাটয়ারী', NULL, NULL, 'default.png', '2021-08-17 06:02:36', NULL, NULL),
(32, 100001, 1, 'মিঃ ফারুক', '01918765432', NULL, NULL, '2021-05-31 23:56:45', '2021-06-27 03:34:43', NULL),
(33, 34535, 1, 'Omar Faruk', '01615573252', NULL, NULL, '2021-05-31 23:58:37', '2021-06-13 22:14:13', NULL),
(34, 1212312, 1, 'limon', '01878469345', NULL, NULL, '2021-06-02 03:46:35', '2021-06-13 22:14:20', '2021-06-13 22:14:20'),
(42, 369949, 9, 'কৃষ্ণপদ সাহা', NULL, NULL, 'default.png', '2021-07-18 05:27:03', NULL, NULL),
(39, 369949, 1, 'ফেনী পৌরসভা', NULL, NULL, NULL, '2021-07-15 12:25:35', '2021-08-05 08:59:08', NULL),
(36, 1122003, 2, 'IIT', '01840210463', NULL, NULL, '2021-06-23 01:31:46', '2021-06-29 05:33:52', NULL),
(37, 1122003, 3, 'Anam', '01821343544', 'admi@gmail.com', 'default.png', '2021-06-23 01:36:20', NULL, NULL),
(38, 34535, 1, 'মোহাম্মদ কামরুল হাসান', '01733354900', 'dccomilla@mopa.gov.bd', 'default.png', '2021-06-23 02:06:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fuel_oil`
--

CREATE TABLE `fuel_oil` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `log_book_id` int(10) UNSIGNED DEFAULT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1 = practol, 2 = digal, 3 = octen',
  `previous_stock` mediumint(8) UNSIGNED DEFAULT NULL,
  `in` mediumint(8) UNSIGNED NOT NULL,
  `out` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `payment` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_oil`
--

INSERT INTO `fuel_oil` (`id`, `org_code`, `vehicle_id`, `log_book_id`, `type`, `previous_stock`, `in`, `out`, `payment`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 369949, 28, 13, 1, NULL, 2580, 88855, '6000.00', '2021-07-28 23:06:02', '2021-07-28 23:07:01', '2021-07-28 23:07:01'),
(8, 369949, 28, 12, 1, NULL, 2500, 250, '500.00', '2021-07-28 22:30:49', '2021-07-28 22:31:26', '2021-07-28 22:31:26'),
(3, 34535, 14, 9, 1, NULL, 12, 11, '12000.00', '2021-06-23 02:17:30', NULL, NULL),
(4, 34535, 14, 10, 2, 1, 15, 10, '1500.00', '2021-06-23 02:21:19', NULL, NULL),
(5, 1122003, 15, 11, 1, NULL, 5, 3, '500.00', '2021-06-23 04:27:07', NULL, NULL),
(6, 1122003, 15, NULL, 4, NULL, 12, 0, '12000.00', '2021-07-03 03:37:52', NULL, NULL),
(7, 1122003, 15, NULL, 5, NULL, 10, 0, '1000.00', '2021-07-03 03:38:57', NULL, NULL),
(10, 369949, 28, NULL, 2, NULL, 0, 0, '0.00', '2021-07-29 03:48:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log_books`
--

CREATE TABLE `log_books` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `driver_id` int(10) UNSIGNED NOT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `employee_id` mediumint(8) UNSIGNED NOT NULL,
  `from` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `out_time` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `journey_time` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `journey_cause` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insert_date` date NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1 = complete, 0 = incomplete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_books`
--

INSERT INTO `log_books` (`id`, `org_code`, `driver_id`, `vehicle_id`, `employee_id`, `from`, `out_time`, `destination`, `journey_time`, `journey_cause`, `insert_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 369949, 8, 28, 43, 'hhh', '11:02 AM', 'bb', '6', 'ghbb', '2021-07-29', 1, '2021-07-28 23:06:02', '2021-07-28 23:07:01', '2021-07-28 23:07:01'),
(12, 369949, 8, 28, 43, 'feni', '10:24 AM', 'dhaka', '5', 'test', '2021-07-29', 1, '2021-07-28 22:30:49', '2021-07-28 22:31:26', '2021-07-28 22:31:26'),
(3, 34535, 4, 14, 38, 'dc office', '2:15 PM', 'sadar union', '2', 'vissit', '2021-06-23', 1, '2021-06-23 02:09:49', NULL, NULL),
(4, 34535, 4, 14, 38, 'dc office', '2:15 PM', 'sadar union', '2', 'vissit', '2021-06-23', 1, '2021-06-23 02:09:58', NULL, NULL),
(5, 34535, 4, 14, 38, 'dc office', '2:15 PM', 'sadar union', '2', 'vissit', '2021-06-23', 1, '2021-06-23 02:10:13', NULL, NULL),
(6, 34535, 4, 14, 38, 'dc office', '2:15 PM', 'sadar union', '2', 'vissit', '2021-06-23', 1, '2021-06-23 02:11:33', NULL, NULL),
(7, 34535, 4, 14, 38, 'cumilla', '2:15 PM', 'Dhaka', '05:00', 'official work', '2021-06-23', 1, '2021-06-23 02:15:19', NULL, NULL),
(8, 34535, 4, 14, 38, 'cumilla', '2:15 PM', 'Dhaka', '05:00', 'official work', '2021-06-23', 1, '2021-06-23 02:15:36', NULL, NULL),
(9, 34535, 4, 14, 38, 'cumilla', '2:15 PM', 'Dhaka', '05:00', 'official work', '2021-06-23', 1, '2021-06-23 02:17:30', NULL, NULL),
(10, 34535, 4, 14, 38, 'dc office', '2:30 PM', 'sadar union', '2', 'vissit', '2021-06-23', 1, '2021-06-23 02:21:19', NULL, NULL),
(11, 1122003, 5, 15, 36, 'Comilla', '9:30 AM', 'Dhaka', '06:00', 'Office Management', '2021-06-23', 1, '2021-06-23 04:27:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meter`
--

CREATE TABLE `meter` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `log_book_id` int(10) UNSIGNED NOT NULL,
  `out_km` int(10) UNSIGNED NOT NULL,
  `in_km` int(10) UNSIGNED NOT NULL,
  `in_time` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meter`
--

INSERT INTO `meter` (`id`, `org_code`, `vehicle_id`, `log_book_id`, `out_km`, `in_km`, `in_time`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 369949, 28, 13, 250, 555, '11:05 AM', '2021-07-28 23:06:02', '2021-07-28 23:07:01', '2021-07-28 23:07:01'),
(12, 369949, 28, 12, 250, 200, '10:24 AM', '2021-07-28 22:30:49', '2021-07-28 22:31:26', '2021-07-28 22:31:26'),
(3, 34535, 14, 3, 20, 30, '3:15 PM', '2021-06-23 02:09:49', NULL, NULL),
(4, 34535, 14, 4, 20, 30, '3:15 PM', '2021-06-23 02:09:58', NULL, NULL),
(5, 34535, 14, 5, 20, 30, '3:15 PM', '2021-06-23 02:10:13', NULL, NULL),
(6, 34535, 14, 6, 20, 30, NULL, '2021-06-23 02:11:33', NULL, NULL),
(7, 34535, 14, 7, 100, 50, '1:15 PM', '2021-06-23 02:15:19', NULL, NULL),
(8, 34535, 14, 8, 100, 50, '1:15 PM', '2021-06-23 02:15:36', NULL, NULL),
(9, 34535, 14, 9, 100, 50, '1:15 PM', '2021-06-23 02:17:30', NULL, NULL),
(10, 34535, 14, 10, 20, 30, '3:30 PM', '2021-06-23 02:21:19', NULL, NULL),
(11, 1122003, 15, 11, 3560, 3720, '4:30 PM', '2021-06-23 04:27:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_04_15_080206_create_driver_info_table', 1),
(2, '2021_04_15_080206_create_employees_table', 1),
(3, '2021_04_15_080206_create_fuel_oil_table', 1),
(4, '2021_04_15_080206_create_log_books_table', 1),
(5, '2021_04_15_080206_create_meter_table', 1),
(6, '2021_04_15_080206_create_organization_info_table', 1),
(7, '2021_04_15_080206_create_repairs_table', 1),
(8, '2021_04_15_080206_create_users_table', 1),
(9, '2021_04_15_080206_create_vehicle_setup_table', 1),
(10, '2021_04_18_040931_create_designations_table', 1),
(11, '2021_06_06_092150_create_rental_car_table', 2),
(12, '2021_08_05_093331_add__new__column__repairs__table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `organization_info`
--

CREATE TABLE `organization_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(9) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_type` mediumint(9) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_info`
--

INSERT INTO `organization_info` (`id`, `org_code`, `name`, `address`, `org_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 369949, 'ফেনী পৌরসভা কার্যালয়', 'কলেজ রোড, ফেনী', 1, '2021-05-25 23:26:46', '2021-08-05 08:59:08', NULL),
(2, 100001, 'চট্টগ্রাম জেলা প্রশাসক কার্যালয়', 'চট্টগ্রাম জেলা প্রশাসক কার্যালয়', 1, '2021-05-31 23:56:45', '2021-06-27 03:34:43', NULL),
(3, 34535, 'কুমিল্লা জেলা প্রশাসক কার্যালয়', 'কুমিল্লা জেলা প্রশাসক কার্যালয়', 1, '2021-05-31 23:58:37', '2021-06-13 22:14:13', NULL),
(4, 1212312, 'কাকলি ফার্নিচার', 'dhaka', 3, '2021-06-02 03:46:35', '2021-06-13 22:14:20', '2021-06-13 22:14:20'),
(5, 1122003, 'Innovavtion It', 'Comilla', 3, '2021-06-23 01:31:46', '2021-06-29 05:33:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rental_car`
--

CREATE TABLE `rental_car` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(9) DEFAULT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `total_day` mediumint(9) DEFAULT NULL,
  `amount` decimal(10,2) UNSIGNED NOT NULL,
  `vat` decimal(10,2) UNSIGNED NOT NULL,
  `income_tax` decimal(10,2) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) UNSIGNED NOT NULL,
  `contractor_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insert_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rental_car`
--

INSERT INTO `rental_car` (`id`, `org_code`, `vehicle_id`, `from_date`, `to_date`, `total_day`, `amount`, `vat`, `income_tax`, `total_amount`, `contractor_name`, `address`, `insert_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 34535, 14, '2021-06-01', '2021-06-23', 23, '15000.00', '2250.00', '375.00', '17625.00', NULL, NULL, '2021-06-23', '2021-06-23 02:17:43', NULL, NULL),
(12, 1122003, 15, '2021-06-23', '2021-06-24', 2, '5000.00', '750.00', '125.00', '5875.00', NULL, NULL, '2021-06-23', '2021-06-23 04:28:21', NULL, NULL),
(14, 369949, 28, '2022-01-23', '2022-01-24', 2, '200.00', '30.00', '10.00', '240.00', 'hamid', 'dhaka', '2022-01-23', '2022-01-22 22:11:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `damage_parts` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_parts` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `cause_of_problems` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insert_date` date NOT NULL,
  `repairs_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repairs`
--

INSERT INTO `repairs` (`id`, `org_code`, `vehicle_id`, `employee_id`, `damage_parts`, `new_parts`, `shop_name`, `total_cost`, `cause_of_problems`, `insert_date`, `repairs_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 34535, 14, 38, 'engine', 'new engine engaged', NULL, '50000.00', 'engine damage', '2021-06-23', NULL, '2021-06-23 02:15:53', NULL, NULL),
(3, 34535, 14, 38, 'Gear', 'new Gear engaged', NULL, '5000.00', 'gear Damage', '2021-06-23', NULL, '2021-06-23 02:16:41', NULL, NULL),
(4, 1122003, 15, 36, 'Engine Damage', 'New Engine', NULL, '20000.00', 'Accident', '2021-06-23', NULL, '2021-06-23 04:30:05', NULL, NULL),
(6, 369949, 24, 43, 'টায়ার', 'পাংচার মেরামত', NULL, '800.00', 'টায়ার পাংচার', '2021-07-18', NULL, '2021-07-27 00:13:58', NULL, NULL),
(7, 369949, 22, 43, 'টায়ার', 'পাংচার মেরামত', NULL, '960.00', 'টায়ার পাংচার', '2021-07-18', NULL, '2021-07-27 00:32:09', NULL, NULL),
(8, 369949, 23, 43, 'টায়ার', 'পাংচার মেরামত', NULL, '1060.00', 'টায়ার পাংচার', '2021-07-18', NULL, '2021-07-27 00:37:00', NULL, NULL),
(9, 369949, 25, 43, 'টায়ার', 'পাংচার মেরামত', NULL, '570.00', 'টায়ার পাংচার', '2021-07-18', NULL, '2021-07-27 00:39:00', NULL, NULL),
(10, 369949, 23, 43, 'টায়ার', 'পাংচার মেরামত', NULL, '510.00', 'টায়ার পাংচার', '2021-07-18', NULL, '2021-07-27 00:41:39', NULL, NULL),
(11, 369949, 38, 43, 'টায়ার', 'পাংচার মেরামত', NULL, '590.00', 'টায়র পাংচার', '2021-07-18', NULL, '2021-07-27 00:58:58', NULL, NULL),
(12, 369949, 25, 43, 'ডিফেন্সেল,লক', 'মেরামত করা হয়েছে', NULL, '1700.00', 'ডিফেন্সেল ও বডির লক নষ্ট', '2021-07-10', NULL, '2021-07-27 01:11:23', NULL, NULL),
(13, 369949, 39, 43, 'ইঞ্জিন সুইচ ও হর্ণ', 'ইঞ্জিন সুইচ-01টি,হর্ণ-01টি মেরামত করা হয়েছে', NULL, '970.00', 'ইঞ্জিন সুইচ ও হর্ণ নষ্ট', '2021-07-21', NULL, '2021-07-27 01:19:33', '2021-07-27 01:34:15', NULL),
(14, 369949, 22, 43, 'কন্ট্রাক্ট সুইচ ও ওয়রিং', 'কন্ট্রাক্ট সুইচ মেরামত ও ওয়রিং করা হয়েছে', NULL, '1000.00', 'কন্ট্রাক্ট সুইচ ও ওয়রিং এ সমস্যা', '2021-07-11', NULL, '2021-07-27 01:36:12', NULL, NULL),
(15, 369949, 26, 43, 'হাইড্রলীক হোস পাইপ', 'হাইড্রলীক হোস পাইপ-01টি', NULL, '1690.00', 'হাইড্রলীক পাইপ ফেটে যায়', '2021-07-21', NULL, '2021-07-27 01:40:34', NULL, NULL),
(16, 369949, 32, 43, 'নিপল', 'নিপল-01টি,গ্রিজ-01কৌটা', NULL, '450.00', 'নিপল নষ্ট', '2021-07-10', NULL, '2021-07-27 01:43:01', NULL, NULL),
(17, 369949, 25, 43, 'ডিজেল ফিল্টার,মবিল ফিল্টার', 'ডিজেল ফিল্টার-02,মবিল ফিল্টার-01টি', NULL, '580.00', 'ইঞ্জিন অয়েলের ঘনত্ব কমে যায়', '2021-07-05', NULL, '2021-07-27 01:46:41', NULL, NULL),
(18, 369949, 28, 43, 'test', 'test', NULL, '0.00', 'test', '2021-08-04', NULL, '2021-08-04 07:39:08', '2021-08-04 07:40:42', '2021-08-04 07:40:42'),
(19, 369949, 28, 43, 'test', 'test', NULL, '0.00', 'test', '2021-08-04', NULL, '2021-08-04 07:41:25', '2021-08-04 07:41:46', '2021-08-04 07:41:46'),
(20, 369949, 28, 43, 'test', 'test', NULL, '0.00', 'test', '2021-08-04', NULL, '2021-08-04 07:42:30', '2021-08-04 07:42:49', '2021-08-04 07:42:49'),
(21, 369949, 26, 43, 'টায়ার', 'পাংচার মেরামত', NULL, '800.00', 'টায়ার পাংচার', '2021-07-18', NULL, '2021-08-05 00:02:47', NULL, NULL),
(22, 369949, 37, 43, 'পিটিও সুইচ,কার্বন,কন্ট্রাক্ট প্লেইট', 'পিটিও সুইচ-1টি,কার্বন-1সেট,কন্ট্রাক্ট প্লেইট-01টি', NULL, '5755.00', 'সেল্ফ,পিটিও কন্ট্রোলার', '2021-07-27', NULL, '2021-08-05 00:17:49', NULL, NULL),
(23, 369949, 25, 43, 'চাকার রিং ক্ষয়,টিউব,লেঙ্গুট', 'চাকার রিং -01টি,টিউব-01টি,লেঙ্গুট-01টি', NULL, '11193.00', 'চাকার রিং ক্ষয়,টিউব ব্রাস্ট', '2021-08-05', NULL, '2021-08-05 00:29:17', NULL, NULL),
(24, 369949, 22, 43, 'ব্যাটারী', 'ব্যাটারী(এন এক্স-120/7)', NULL, '7653.00', 'ব্যাটারীর সেল নষ্ট', '2021-08-04', NULL, '2021-08-05 00:35:00', NULL, NULL),
(25, 369949, 40, 43, 'টায়ার,টিউব,তেলের লাইন', 'টায়ার (195আর15)-02টি,টিউব-01টি,গ্যাস ও তেলের লাইন টিওনিং', NULL, '26900.00', 'টায়র ব্রাস্ট', '2021-02-26', NULL, '2021-08-05 00:50:39', NULL, NULL),
(26, 369949, 38, 43, 'গিয়ার ক্যাবল,ক্লাস সিলিন্ডার,ফিল্টার,ক্লাস কিট', 'গিয়ার ক্যাবল-01টি,ক্লাস সিলিন্ডার-01টি,ফিল্টার-03টি,ক্লাস কিট-01টি(উপরের)', NULL, '10879.00', 'গিয়ার ক্যাবল,ক্লাস সিলিন্ডার,ফিল্টার', '2021-07-04', NULL, '2021-08-05 00:54:50', NULL, NULL),
(27, 369949, 28, 43, 'যবযভ, দঢরভভ, দঢদভভ।', 'ভথভথব, রবভরভ, রববব, রবরড।', NULL, '45566.00', 'যভতভথ জঢজণজণ জনভজণজম দমথভলভ', '2021-08-05', NULL, '2021-08-05 01:53:18', '2021-08-05 01:53:56', '2021-08-05 01:53:56'),
(28, 369949, 28, 43, 'test', 'tedt', 'test', '0.00', 'test', '2021-08-05', NULL, '2021-08-05 04:29:41', '2021-08-05 04:42:14', '2021-08-05 04:42:14'),
(29, 369949, 28, 43, 'test', 'test', 'test', '0.00', 'test', '2021-08-05', NULL, '2021-08-05 04:44:03', '2021-08-05 04:44:53', '2021-08-05 04:44:53'),
(30, 369949, 28, 43, 'test', 'test', 'test', '0.00', 'test', '2021-08-05', NULL, '2021-08-05 04:46:19', '2021-08-05 04:46:57', '2021-08-05 04:46:57'),
(31, 369949, 28, 43, 'test', 'test', 'test', '0.00', 'test', '2021-08-05', NULL, '2021-08-05 04:47:38', '2021-08-05 04:48:21', '2021-08-05 04:48:21'),
(32, 369949, 28, 43, 'যফযবত, থঠযডরড, রডলবল, দডলডলড, লঠরডলড।', 'যবরডয, লপধঠধ, লঠলবয, লঠরডলড, লঠৃডয, রডলডর।', NULL, '1234548.00', 'যডতড, যডরডর, রডলডল, তডলডল, থডলডশ।', '2021-08-05', NULL, '2021-08-05 04:55:01', '2021-08-05 04:55:59', '2021-08-05 04:55:59'),
(33, 369949, 28, 43, 'test', 'test', 'test', '0.00', 'test', '2021-08-05', NULL, '2021-08-05 04:58:34', '2021-08-05 04:58:51', '2021-08-05 04:58:51'),
(34, 369949, 17, 43, 'ব্রেক পেইড-2সেট,রেক এন্ড বোট কভার-2টি,স্টেব্লেজার বুশ-2টি,ম্যাগনেটিক ব্যায়ারিং-2সেট,বল জয়েন্ট-1সেট,রেক এন্ড-1সেট,লিংক রড-1সেট,টায়ার-2টি,টাই রড-1সেট।', 'ব্রেক পেইড-2সেট,রেক এন্ড বোট কভার-2টি,স্টেব্লেজার বুশ-2টি,ম্যাগনেটিক ব্যায়ারিং-2সেট,বল জয়েন্ট-1সেট,রেক এন্ড-1সেট,লিংক রড-1সেট,টায়ার-2টি,টাই রড-1সেট,প্লোর মেট-1সেট,ডাস্টার-1টি,ব্রাস-1টি, সেম্পু-4টি,সপ্টওয়ার ইন্সটল,লেদের কাজ,ওয়ার্কসপ চার্জ।', 'মেসার্স এস.এম মোটর্স।', '213364.00', 'ব্রেক পেইড, সাসপেনশন', '2021-08-03', NULL, '2021-08-05 05:26:27', '2021-08-23 23:01:05', NULL),
(35, 369949, 25, 43, 'টায়ার', 'পাংচার মেরামত', 'ফেনী ভল্কেনাইজিং সপ', '550.00', 'টায়ার পাংচার', '2021-08-09', NULL, '2021-08-08 23:45:29', NULL, NULL),
(36, 369949, 22, 43, 'টায়ার', 'পাংচার মেরামত', 'মায়ের দোয়া ভল্কেনাইজিং সপ', '700.00', 'টায়ার পাংচার', '2021-08-09', NULL, '2021-08-09 00:50:44', NULL, NULL),
(37, 369949, 30, 43, 'টায়ার', 'পাংচার মেরামত', '1.মায়ের দোয়া ভল্কেনাইজিং সপ । 02.আজমীর ভল্কেনাইজিং সপ', '850.00', 'টায়ার পাংচার', '2021-08-09', NULL, '2021-08-09 00:58:06', NULL, NULL),
(38, 369949, 23, 43, 'টায়ার', 'পাংচার মেরামত', 'মায়ের দোয়া ভল্কেনাইজিং সপ', '340.00', 'টায়ার পাংচার', '2021-08-09', NULL, '2021-08-09 01:03:33', NULL, NULL),
(39, 369949, 40, 43, 'টায়ার', 'পাংচার মেরামত', 'তাহের ভল্কেনাইজিং সপ', '600.00', 'টায়ার পাংচার', '2021-08-09', NULL, '2021-08-09 01:07:57', NULL, NULL),
(40, 369949, 29, 43, 'টায়ার', 'পাংচার মেরামত', 'মায়ের দোয়া ভল্কেনাইজিং সপ', '540.00', 'টায়ার পাংচার', '2021-08-09', NULL, '2021-08-09 01:24:30', NULL, NULL),
(41, 369949, 30, 43, 'টায়ার', 'পাংচার মেরামত', 'মায়ের দোয়া ভল্কেনাইজিং সপ', '920.00', 'টায়ার পাংচার', '2021-08-09', NULL, '2021-08-09 01:29:25', NULL, NULL),
(42, 369949, 41, 44, 'চেইন পিনিয়াম,ক্লাস প্লেইট,ডাবল স্টেন্ড,সাইড স্টেন্ড,সিগনাল লাইট,লুকিং গ্লাস,সামনের মার্টগার্ড,রোকার,পিষ্টন,রিং,বাল্ব,সিল,গ্যাসকেট,প্লাগ,পুশ রড,কিক আর্ম', 'চেইন পিনিয়াম,ক্লাস প্লেইট,ডাবল স্টেন্ড,সাইড স্টেন্ড,সিগনাল লাইট,লুকিং গ্লাস,সামনের মার্টগার্ড,রোকার,পিষ্টন,রিং,বাল্ব,সিল,গ্যাসকেট,প্লাগ,পুশ রড,কিক আর্ম,হেলমেট,রেইন কোর্ট,বেক চেইন ওয়েল্ডিং,হেড ও সিলিন্ডারের কাজ,মিস্ত্রির মজুরী।', 'মেসার্স ইসলামিয়া অটো হাউজ/নজরুল মেকানিক্যাল ইঞ্জিনিয়ারিং/আলম অটো হোন্ডা সার্ভিসিং সেন্টার', '14105.00', 'ইঞ্জিন', '2021-08-17', NULL, '2021-08-17 06:16:28', NULL, NULL),
(43, 369949, 31, 43, 'টায়ার', 'পাংচার মেরামত', 'মায়ের দোয়া ভল্কেনাইজিং সপ/ভাই ভাই ভল্কেনাইজিং সপ', '550.00', 'টায়ার পাংচার', '2021-08-24', NULL, '2021-08-23 22:29:24', NULL, NULL),
(44, 369949, 29, 43, 'টায়ার', 'পাংচার মেরামত', 'মায়ের দোয়া ভল্কেনাইজিং সপ', '300.00', 'টায়ার পাংচার', '2021-08-24', NULL, '2021-08-23 22:33:36', NULL, NULL),
(45, 369949, 24, 43, 'টায়ার', 'পাংচার মেরামত', 'ভাই ভাই ভল্কেনাইজিং সপ', '800.00', 'টায়ার পাংচার', '2021-08-17', NULL, '2021-08-23 22:39:23', NULL, NULL),
(46, 369949, 30, 43, 'কন্ট্রাক্ট প্লেইট,তার,ইঞ্জিন সুইচ,হেড লাইট সুইচ,হর্ণ সুইচ,কিট,হাইড্রলীক হোস পাইপ', 'কন্ট্রাক্ট প্লেইট-1টি,তার,ইঞ্জিন সুইচ-1াট,হেড লাইট সুইচ-1টি,হর্ণ সুইচ-1টি,কিট-1সেট,হাইড্রলীক হোস পাইপ-1টি', 'মেসার্স এস.এম মোটর্স।', '9130.00', 'ওয়ারিং সাইড', '2021-07-10', NULL, '2021-08-23 23:21:32', NULL, NULL),
(47, 369949, 26, 43, 'রিং,মেইন বিগেন ব্যায়ারিং,ওবার হুলিং কিট,বেইল,সিল,গাইড,লাইনার,ফিল্টার,ক্রেন,ইঞ্জিন পুলী,কানেক্টিং বুস,থ্রাস্ট ওয়াসার,মেইন অয়েল সীল,টাইমিং অয়েল সিল', 'রিং-1সেট,মেইন বিগেন ব্যায়ারিং-1সেট,ওবার হুলিং কিট-1সেট,বেইল-1সেট,সিল-1টি,গাইড-1সেট,লাইনার-1সেট,ফিল্টার-1সেট,ক্রেন মেরামত,ইঞ্জিন পুলী মেরামত,কানেক্টিং বুস-1সেট,থ্রাস্ট ওয়াসার-1সেট,মেইন অয়েল সীল-1টি,টাইমিং অয়েল সিল-1টি,লেদের মজুরী,এ্যাঙ্গেল-33কেজি,চ্যানেল-35কেজি,বুস পাইপ-6কেজি,সিট-58কেজি,বডি মিস্ত্রির মজুরী।', 'মেসার্স এম.এম মোটর্স।', '64295.00', 'ইঞ্জীন', '2021-07-19', NULL, '2021-08-23 23:37:28', NULL, NULL),
(48, 369949, 27, 43, 'টিফিং ট্রেইলরের প্লোর,টায়ার।', 'প্লেইন শিট-205 কেজি,চ্যানেল-27কেজি,বুস পাইপ-16টি,বডির হোক-01টি,রং-1গ্যালন,তারফিন-6লি:,ইঞ্জিন হোক-01টি,এঙ্গেল-50কেজি,বডির আস্তর রং-01গ্যালন,বডি মিস্ত্রির মজুরী,টায়ার(6.00-16),গজ কাপর।', 'মেসার্স এস.এম মোটর্স।', '86490.00', 'বডি,টায়ার,রং', '2021-07-10', NULL, '2021-08-23 23:43:37', NULL, NULL),
(49, 369949, 22, 43, 'টায়ার', 'পাংচার মেরামত', 'মায়ের দোয়া ভল্কেনাইজিং সপ', '260.00', 'টায়ার পাংচার', '2021-08-24', NULL, '2021-08-24 00:40:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(9) DEFAULT NULL,
  `employee_id` mediumint(9) DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1 = super_admin, 2 = admin, 3 = others',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `org_code`, `employee_id`, `username`, `password`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 369949, 39, 'pouro_admin', '$2y$10$CRafjmQizz0W5xKMc7eQ8OASAiyw6QVAIHfyvQ6P/V9cX4dac62eO', 2, '2021-05-25 23:26:46', '2021-08-05 08:59:08', NULL),
(2, NULL, NULL, 'super_admin', '$2y$10$34HtuN1FoS/VrdHmdNS/ju6.y5BvxhUykY/7SeIx0u6LvmtKmbZRu', 1, '2021-05-25 23:26:46', '2021-05-25 23:26:46', NULL),
(21, 369949, 39, 'admin', '$2y$10$uicl0o0vnFwn0m/gJ.w96ulm9pofr/hUI.wo6bX6OyP8k.FuYB0YC', 3, NULL, '2021-07-15 12:25:35', NULL),
(22, 369949, 40, 'a', '$2y$10$krhfclHgDpOv3PCBruElGONOZ9A9TWyHOyDZnoyoJ5Svg.zh4F.8m', 3, NULL, '2021-07-15 12:28:04', NULL),
(23, 369949, 41, 'b', '$2y$10$WKmAfILSvpMz0tFu1zpn3OYCP0REE.qItL17vtJ.jbVp5I2J6E7Su', 3, NULL, '2021-07-15 12:32:15', NULL),
(24, 369949, 42, 'c', '$2y$10$vGQ6zhnPwxBdsJ/EHQ95leVc/VPjWIE9xXuV95bS7Z5Du27ZRpdLm', 3, NULL, '2021-07-18 05:27:03', NULL),
(25, 369949, 43, '1', '$2y$10$YrKCcN9CGxRqRJYQhLFm8OHo4lJJDLTnQHqzKjJ.z1kCmPOq7aZ/a', 3, NULL, '2021-07-26 23:58:01', NULL),
(26, 369949, 44, '3', '$2y$10$tiJ26lBLK55ftxK6J2dXpeXsvTmHqg5Ule.qbWl0titZsavznOhRy', 3, NULL, '2021-08-17 06:02:36', NULL),
(14, 100001, 32, 'admin_ctg', '$2y$10$w4NuoZpvwx4quTaZCBkvj.d7A8.sGiXBgI5tQl.hS6kSP0pI/5eEW', 2, '2021-05-31 23:56:45', '2021-06-27 03:34:43', NULL),
(15, 34535, 33, 'faruk', '$2y$10$8IcQxUIOgse.bzI5y7v8w.iwiQPADGwJGoVrwgRQ2pWSPqMAwlNE.', 2, '2021-05-31 23:58:37', '2021-06-13 22:14:14', NULL),
(16, 1212312, 34, 'superadmin', '$2y$10$NPABf4AhrJoBw6tbxnOcAesj8Bg5ct2MmR93GWnRqQzRX6cRbjA26', 2, '2021-06-02 03:46:35', '2021-06-13 22:14:20', '2021-06-13 22:14:20'),
(18, 1122003, 36, 'admin_admin', '$2y$10$LILRJ5U0cnVIv0ece/c7K.0eUff3jod2EMs9OYMDNN8zHagPUEvvK', 2, '2021-06-23 01:31:46', '2021-06-29 05:33:52', NULL),
(19, 1122003, 37, 'Anam', '$2y$10$js6vEC47BILNIQhKgeUJNeLC5x2YMlqBMxN6ffajoX3zWTCSFvhB.', 3, NULL, '2021-06-23 01:36:20', NULL),
(20, 34535, 38, 'dc_comilla', '$2y$10$B2bDW2XQxwFher/zehDvjuPUB8f39/CngPNGRMDnw89kfypayisu2', 3, NULL, '2021-06-23 02:06:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_setup`
--

CREATE TABLE `vehicle_setup` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_code` mediumint(8) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `driver_id` int(10) UNSIGNED NOT NULL,
  `vehicle_reg_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chassis_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `engine_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `develop_year` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fitness_duration` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_token_duration` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_date` date DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `useless_date` date DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '1 = running, 0 = useless',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_setup`
--

INSERT INTO `vehicle_setup` (`id`, `org_code`, `employee_id`, `driver_id`, `vehicle_reg_no`, `body_type`, `chassis_no`, `engine_no`, `develop_year`, `fitness_duration`, `tax_token_duration`, `assignment_date`, `images`, `useless_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(28, 369949, 43, 33, 'ট্রাক্টর-ডি 45/06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:20:20', '2021-07-28 14:14:51', NULL),
(27, 369949, 43, 12, 'ট্রাক্টর-ডি 45/05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:18:13', '2021-07-28 14:15:01', NULL),
(26, 369949, 43, 23, 'ট্রাক্টর ডি 45/04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:17:38', '2021-07-28 14:15:11', NULL),
(25, 369949, 43, 13, 'ট্রাক্টর-ডি 45/03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:15:41', '2021-07-28 14:15:24', NULL),
(24, 369949, 43, 32, 'আইচ-আর-000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:05:11', NULL, NULL),
(23, 369949, 43, 11, 'ডংফি-0002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-26 23:59:48', NULL, NULL),
(22, 369949, 43, 10, 'পেলোডার-002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-26 23:58:51', '2021-07-27 01:24:21', NULL),
(20, 369949, 42, 21, 'ঠ-11-0016', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-18 05:28:20', NULL, NULL),
(21, 369949, 42, 8, 'Vehicle', 'Bolder', 'Ttr', 'Gg', '1234', '234', '134', '2021-07-02', 'default.png', NULL, 1, '2021-07-18 06:01:06', NULL, NULL),
(19, 369949, 41, 26, 'gha-05-0007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-18 05:18:55', NULL, NULL),
(18, 369949, 40, 17, 'Tha-11-0022', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-18 05:17:32', NULL, NULL),
(17, 369949, 39, 7, 'ফেনী ঘ - ১১ - ০০৩০', NULL, NULL, NULL, '২০১১', NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-15 12:36:16', NULL, NULL),
(14, 34535, 38, 4, '1236547889', 'Prado', '258369147', '654321', '2021', '1', '22', '2021-01-01', 'default.png', NULL, 1, '2021-06-23 02:08:08', NULL, NULL),
(15, 1122003, 36, 5, '1122', 'Car', '123', '231', '2020', '10 years', '30 day', '2021-06-30', 'default.png', NULL, 1, '2021-06-23 04:20:27', NULL, NULL),
(16, 1122003, 37, 6, '1234', 'Car 2', '3421', '2319', '2015', '12 years', '20 day', '2021-06-30', 'default.png', '2021-06-23', 0, '2021-06-23 04:39:02', '2021-06-23 04:39:21', NULL),
(29, 369949, 43, 15, 'নোয়াখালী-ই-11-0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:21:02', NULL, NULL),
(30, 369949, 43, 24, 'নোয়াখালী-ই-11-0353', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:21:45', NULL, NULL),
(31, 369949, 43, 28, 'ট্রাক্টর-ডি 45/07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:22:19', '2021-07-28 14:15:43', NULL),
(32, 369949, 43, 16, 'এক্সেভেটার-0001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:23:10', NULL, NULL),
(33, 369949, 43, 16, 'এক্সেভেটার-0002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:23:36', NULL, NULL),
(34, 369949, 43, 30, 'ফেনী-শ-11-0005', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:24:40', NULL, NULL),
(35, 369949, 43, 31, 'ফেনী-শ-11-0040', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:25:55', NULL, NULL),
(36, 369949, 43, 25, 'ওয়াটার ট্যাংক-002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:29:43', NULL, NULL),
(37, 369949, 43, 25, 'ট-11-0866', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:30:17', NULL, NULL),
(38, 369949, 43, 20, 'ফেনী - শ - ১১ - ০০৩৮', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 00:56:28', NULL, NULL),
(39, 369949, 43, 19, 'রোড রোলার নং-009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-07-27 01:12:50', NULL, NULL),
(40, 369949, 43, 22, 'ছ-71-1826', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-08-05 00:47:30', NULL, NULL),
(41, 369949, 44, 32, 'ফেনী-হ-11-1489', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', NULL, 1, '2021-08-17 06:04:25', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_info`
--
ALTER TABLE `driver_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuel_oil`
--
ALTER TABLE `fuel_oil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_books`
--
ALTER TABLE `log_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meter`
--
ALTER TABLE `meter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_info`
--
ALTER TABLE `organization_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organization_info_org_code_unique` (`org_code`);

--
-- Indexes for table `rental_car`
--
ALTER TABLE `rental_car`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `vehicle_setup`
--
ALTER TABLE `vehicle_setup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_setup_vehicle_reg_no_unique` (`vehicle_reg_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `driver_info`
--
ALTER TABLE `driver_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `fuel_oil`
--
ALTER TABLE `fuel_oil`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `log_books`
--
ALTER TABLE `log_books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `meter`
--
ALTER TABLE `meter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `organization_info`
--
ALTER TABLE `organization_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rental_car`
--
ALTER TABLE `rental_car`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vehicle_setup`
--
ALTER TABLE `vehicle_setup`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
