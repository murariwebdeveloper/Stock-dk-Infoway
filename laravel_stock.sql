-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2025 at 05:44 AM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_03_09_050104_create_stores_table', 1),
(6, '2025_03_09_050419_create_stock_entries_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_entries`
--

DROP TABLE IF EXISTS `stock_entries`;
CREATE TABLE IF NOT EXISTS `stock_entries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` bigint UNSIGNED NOT NULL,
  `in_stock_date` date NOT NULL,
  `status` enum('Pending','In-Stock','Out-Of-Stock') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_entries_stock_no_unique` (`stock_no`),
  KEY `stock_entries_store_id_foreign` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_entries`
--

INSERT INTO `stock_entries` (`id`, `stock_no`, `item_code`, `item_name`, `quantity`, `location`, `store_id`, `in_stock_date`, `status`, `created_at`, `updated_at`) VALUES
(1, '1000001', 'KJJXZ', 'mollitia', 59, 'BB', 13, '2025-03-27', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(2, '1000002', 'UZRUN', 'deserunt', 54, 'MA', 27, '2025-03-03', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(3, '1000003', 'AOEKB', 'mollitia', 3, 'ZN', 15, '2025-02-15', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(4, '1000004', 'ACUEC', 'hic', 58, 'MX', 2, '2025-02-15', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(5, '1000005', 'DASUG', 'et', 64, 'BV', 20, '2025-04-12', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(6, '1000006', 'BTRJF', 'aut', 85, 'TP', 25, '2025-04-01', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(7, '1000007', 'FBLBJ', 'voluptatum', 74, 'GT', 30, '2025-02-14', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(8, '1000008', 'HJKNO', 'placeat', 72, 'IO', 14, '2025-02-26', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(9, '1000009', 'HDNLM', 'quisquam', 17, 'WM', 15, '2025-03-11', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(10, '1000010', 'FOKQH', 'consequatur', 27, 'BF', 29, '2025-03-16', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(11, '1000011', 'MAHQO', 'numquam', 92, 'ZQ', 2, '2025-03-25', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(12, '1000012', 'FGBNC', 'aut', 67, 'BN', 5, '2025-03-24', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(13, '1000013', 'QFTQP', 'et', 97, 'GB', 19, '2025-03-09', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(14, '1000014', 'JGCGR', 'maxime', 94, 'QA', 2, '2025-03-23', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(15, '1000015', 'UGUNZ', 'molestiae', 42, 'JX', 15, '2025-02-15', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(16, '1000016', 'KBPKF', 'reiciendis', 62, 'FG', 2, '2025-02-21', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(17, '1000017', 'DSTHV', 'hic', 39, 'DK', 26, '2025-04-12', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(18, '1000018', 'EXRKD', 'earum', 66, 'TI', 21, '2025-03-26', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(19, '1000019', 'ARDKD', 'eos', 21, 'YK', 18, '2025-03-27', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(20, '1000020', 'ILTEG', 'veniam', 25, 'UE', 12, '2025-04-07', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(21, '1000021', 'PSNPJ', 'blanditiis', 49, 'KX', 1, '2025-04-10', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(22, '1000022', 'GHVNM', 'quae', 100, 'FF', 3, '2025-02-24', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(23, '1000023', 'WSGUF', 'vel', 99, 'HP', 3, '2025-03-09', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(24, '1000024', 'MXYNL', 'veritatis', 12, 'CD', 7, '2025-04-09', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(25, '1000025', 'LEIEN', 'repudiandae', 40, 'HI', 16, '2025-02-25', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(26, '1000026', 'GVYLN', 'ad', 35, 'AV', 14, '2025-04-05', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(27, '1000027', 'AIWDI', 'laudantium', 1, 'QI', 27, '2025-03-09', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(28, '1000028', 'UZVXW', 'eum', 68, 'JL', 27, '2025-03-11', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(29, '1000029', 'CHKMC', 'earum', 27, 'DI', 11, '2025-02-22', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(30, '1000030', 'MGTHW', 'fugit', 37, 'TI', 23, '2025-03-19', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(31, '1000031', 'YYIVJ', 'aspernatur', 94, 'CN', 29, '2025-03-08', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(32, '1000032', 'JUUAE', 'ipsum', 72, 'ZQ', 30, '2025-03-30', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(33, '1000033', 'GAGTA', 'aspernatur', 24, 'WC', 6, '2025-03-28', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(34, '1000034', 'LGWEX', 'omnis', 50, 'WU', 28, '2025-03-18', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(35, '1000035', 'GTIOX', 'debitis', 90, 'LT', 15, '2025-02-25', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(36, '1000036', 'FULEO', 'est', 6, 'AU', 30, '2025-03-11', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(37, '1000037', 'OTVKT', 'et', 42, 'KU', 2, '2025-03-30', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(38, '1000038', 'TOQUP', 'doloremque', 2, 'EJ', 6, '2025-04-03', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(39, '1000039', 'ZORZF', 'eaque', 1, 'KE', 8, '2025-03-13', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(40, '1000040', 'IEGYG', 'veritatis', 61, 'UJ', 3, '2025-02-18', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(41, '1000041', 'MVMBK', 'quia', 96, 'VI', 26, '2025-03-13', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(42, '1000042', 'GBXOX', 'provident', 81, 'HF', 28, '2025-02-23', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(43, '1000043', 'AJXHW', 'a', 58, 'MS', 28, '2025-03-29', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(44, '1000044', 'NCRMJ', 'beatae', 88, 'AD', 27, '2025-03-21', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(45, '1000045', 'NMOCZ', 'aut', 79, 'TW', 19, '2025-02-26', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(46, '1000046', 'GQIIU', 'unde', 13, 'IP', 21, '2025-04-11', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(47, '1000047', 'RRREF', 'aut', 27, 'DS', 4, '2025-03-22', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(48, '1000048', 'MKMER', 'laudantium', 10, 'CF', 8, '2025-04-03', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(49, '1000049', 'MEEVS', 'suscipit', 39, 'GN', 22, '2025-03-23', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(50, '1000050', 'EAAWK', 'nam', 21, 'OC', 12, '2025-03-31', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(51, '1000051', 'DLEGH', 'sunt', 27, 'RW', 17, '2025-04-02', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(52, '1000052', 'GQZCX', 'eaque', 42, 'LS', 30, '2025-02-26', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(53, '1000053', 'UGJQM', 'molestias', 61, 'PI', 29, '2025-03-05', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(54, '1000054', 'BXBER', 'voluptas', 50, 'EJ', 17, '2025-02-26', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(55, '1000055', 'JHACA', 'sit', 16, 'QU', 22, '2025-02-24', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(56, '1000056', 'ORJPG', 'labore', 27, 'CV', 9, '2025-04-01', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(57, '1000057', 'KSTOG', 'sed', 36, 'BA', 21, '2025-03-21', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(58, '1000058', 'LFRKQ', 'et', 62, 'RQ', 11, '2025-03-31', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(59, '1000059', 'NMNBH', 'laudantium', 32, 'MC', 26, '2025-03-22', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(60, '1000060', 'GZVFH', 'qui', 28, 'YL', 25, '2025-02-19', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(61, '1000061', 'OZPPE', 'fugit', 83, 'YG', 16, '2025-02-20', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(62, '1000062', 'IJXVU', 'vel', 22, 'XI', 5, '2025-03-15', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(63, '1000063', 'SAHOJ', 'dolores', 23, 'ZU', 21, '2025-02-18', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(64, '1000064', 'OJKZA', 'doloribus', 62, 'ES', 18, '2025-02-19', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(65, '1000065', 'HIPAE', 'sit', 42, 'LF', 18, '2025-03-12', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(66, '1000066', 'BOOBY', 'tenetur', 65, 'MG', 8, '2025-03-28', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(67, '1000067', 'XUVDD', 'inventore', 82, 'OU', 22, '2025-03-06', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(68, '1000068', 'ZEHWL', 'voluptatibus', 1, 'JB', 5, '2025-02-22', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(69, '1000069', 'EKIMI', 'similique', 18, 'VE', 15, '2025-03-17', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(70, '1000070', 'FXTYH', 'enim', 68, 'PS', 27, '2025-02-16', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(71, '1000071', 'BGVBR', 'cupiditate', 96, 'XG', 12, '2025-02-25', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(72, '1000072', 'KMEML', 'consequatur', 68, 'TH', 12, '2025-03-15', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(73, '1000073', 'VDSKI', 'doloremque', 84, 'XC', 25, '2025-04-08', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(74, '1000074', 'XNLRE', 'omnis', 44, 'AB', 3, '2025-04-10', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(75, '1000075', 'VAISS', 'aliquid', 2, 'MB', 5, '2025-04-08', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(76, '1000076', 'MXMTR', 'suscipit', 8, 'FG', 7, '2025-04-09', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(77, '1000077', 'NNCFY', 'porro', 95, 'QE', 8, '2025-03-04', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(78, '1000078', 'TFWQW', 'doloremque', 48, 'IZ', 22, '2025-03-22', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(79, '1000079', 'PGQMQ', 'occaecati', 28, 'WV', 25, '2025-03-01', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(80, '1000080', 'XJPRG', 'beatae', 100, 'KX', 13, '2025-03-29', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(81, '1000081', 'ARHNL', 'rerum', 33, 'OK', 8, '2025-02-13', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(82, '1000082', 'WGHFB', 'consequatur', 54, 'TP', 24, '2025-02-13', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(83, '1000083', 'YCXWT', 'vero', 100, 'ZD', 10, '2025-02-23', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(84, '1000084', 'NDLTP', 'dolore', 48, 'SG', 15, '2025-02-19', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(85, '1000085', 'SOWLM', 'qui', 11, 'MN', 30, '2025-02-12', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(86, '1000086', 'JCIGO', 'rerum', 40, 'LS', 7, '2025-03-28', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(87, '1000087', 'LIHGC', 'tempora', 31, 'NB', 28, '2025-02-15', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(88, '1000088', 'CWMZA', 'officia', 38, 'VC', 11, '2025-03-11', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(89, '1000089', 'RUKXG', 'commodi', 29, 'WD', 12, '2025-03-25', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(90, '1000090', 'WBARX', 'ut', 40, 'UQ', 19, '2025-03-26', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(91, '1000091', 'AHOXH', 'ut', 100, 'ZZ', 9, '2025-04-04', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(92, '1000092', 'NFMBO', 'quia', 27, 'NZ', 14, '2025-02-15', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(93, '1000093', 'NMOEA', 'voluptatem', 4, 'HO', 1, '2025-02-24', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(94, '1000094', 'LUHSC', 'pariatur', 37, 'CB', 6, '2025-03-03', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(95, '1000095', 'KYMFQ', 'cupiditate', 77, 'VQ', 8, '2025-03-03', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(96, '1000096', 'ACVSR', 'facilis', 17, 'GO', 16, '2025-02-20', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(97, '1000097', 'UCHOG', 'voluptate', 61, 'QW', 22, '2025-04-10', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(98, '1000098', 'ZHGSY', 'tenetur', 45, 'QN', 1, '2025-04-02', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(99, '1000099', 'CZBTF', 'molestias', 22, 'GX', 28, '2025-04-08', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(100, '1000100', 'JMNVW', 'cumque', 73, 'VG', 9, '2025-04-11', 'Pending', '2025-03-12 11:17:05', '2025-03-12 11:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
CREATE TABLE IF NOT EXISTS `stores` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stores_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Collins, Haley and Romaguera', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(2, 'Goodwin Ltd', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(3, 'Schowalter PLC', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(4, 'Harber Ltd', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(5, 'Gleason Inc', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(6, 'Cronin Ltd', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(7, 'Dach-Veum', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(8, 'Simonis, Becker and Cruickshank', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(9, 'Feil, Beier and Wilderman', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(10, 'Denesik-Pollich', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(11, 'Cruickshank, Rau and Gleason', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(12, 'Barrows Group', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(13, 'Shields, Wintheiser and Hettinger', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(14, 'Little-Hill', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(15, 'Gislason-Baumbach', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(16, 'Kiehn, Robel and Prohaska', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(17, 'Swift-Dare', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(18, 'Homenick-Jaskolski', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(19, 'Harber, Swaniawski and Hansen', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(20, 'Lindgren LLC', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(21, 'Runte, Bartoletti and Bergnaum', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(22, 'Walker-Swift', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(23, 'Tillman and Sons', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(24, 'Marvin-Hills', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(25, 'Hauck-Rowe', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(26, 'Wyman, Franecki and Daniel', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(27, 'Fadel, Grimes and Macejkovic', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(28, 'Grady Group', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(29, 'Morar, Doyle and Murazik', '2025-03-12 11:17:05', '2025-03-12 11:17:05'),
(30, 'Monahan and Sons', '2025-03-12 11:17:05', '2025-03-12 11:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', '2025-03-12 11:17:04', '$2y$10$CVyRiNXhl.G.UNFKrZSr1ePXwGGk23qYI.7PkDhq4E4uMtyWQzdGK', '9h6qZs4NJx', '2025-03-12 11:17:04', '2025-03-12 11:17:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
