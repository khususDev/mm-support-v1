-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mmdocs
CREATE DATABASE IF NOT EXISTS `mmdocs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mmdocs`;

-- Dumping structure for table mmdocs.application
CREATE TABLE IF NOT EXISTS `application` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `alamat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `manual_mutu` int NOT NULL DEFAULT '0',
  `backup` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.application: ~0 rows (approximately)

-- Dumping structure for table mmdocs.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.categories: ~0 rows (approximately)

-- Dumping structure for table mmdocs.department
CREATE TABLE IF NOT EXISTS `department` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.department: ~12 rows (approximately)
INSERT INTO `department` (`id`, `name`, `code`, `created_id`, `created_at`, `updated_at`) VALUES
	(9, 'Accounting', 'AC', '1', '2025-04-10 19:24:45', '2025-04-10 19:24:45'),
	(10, 'Finance', 'AR', '1', '2025-04-10 19:25:01', '2025-04-10 19:25:01'),
	(11, 'Administrasi', 'AD', '1', '2025-04-10 19:25:19', '2025-04-10 19:25:19'),
	(12, 'Sales Marketing', 'SM', '1', '2025-04-10 19:25:34', '2025-04-10 19:25:34'),
	(13, 'Sales Support Service', 'SS', '1', '2025-04-10 19:26:03', '2025-04-10 19:26:03'),
	(14, 'Quality Control', 'QC', '1', '2025-04-10 19:26:16', '2025-04-10 19:26:16'),
	(15, 'Quality Assurance', 'QA', '1', '2025-04-10 19:26:44', '2025-04-10 19:26:44'),
	(16, 'General Affairs', 'GA', '1', '2025-04-10 19:27:00', '2025-04-10 19:27:00'),
	(17, 'Technical Support', 'TS', '1', '2025-04-10 19:27:18', '2025-04-10 19:27:18'),
	(18, 'Operasional', 'OP', '1', '2025-04-10 19:27:29', '2025-04-10 19:27:29'),
	(19, 'Procurement', 'PC', '1', '2025-04-10 19:27:40', '2025-04-10 19:27:40'),
	(21, 'IT', 'IT', '1', '2025-04-19 05:33:32', '2025-04-19 05:33:32');

-- Dumping structure for table mmdocs.distribution
CREATE TABLE IF NOT EXISTS `distribution` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nodocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distribution_user_id_foreign` (`user_id`,`nodocument`) USING BTREE,
  CONSTRAINT `distribution_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=862 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.distribution: ~118 rows (approximately)
INSERT INTO `distribution` (`id`, `nodocument`, `user_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(38, 'PM-QA-2024010001', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(39, 'PM-QA-202412010001', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(40, 'PM-QA-202412010002', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(41, 'PM-QA-202412010003', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(42, 'PM-QA-202412010004', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(43, 'PM-QA-202412010005', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(44, 'PM-QA-202412010006', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(45, 'PM-QA-202412010007', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(46, 'PM-QA-202412010008', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(47, 'PM-QA-202412010009', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(48, 'PM-QA-202412010010', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(49, 'PM-QA-202412010011', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(50, 'PM-QA-202412010012', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(51, 'PM-QA-202412010013', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(52, 'PM-QA-202412010014', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(53, 'PM-QA-202412010015', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(54, 'PM-QA-202412010016', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(55, 'PM-QA-202412010017', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(56, 'PM-QA-202412010018', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(57, 'PM-QA-202412010019', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(58, 'PM-QA-202412010020', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(59, 'PM-QA-202412010021', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(60, 'PM-QA-202412010022', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(61, 'PM-QA-202412010023', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(62, 'PM-QA-202412010024', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(63, 'PM-QA-202412010025', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(64, 'PM-QA-202412010026', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(65, 'PM-QA-202412010027', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(66, 'PM-QA-202412010028', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(67, 'PM-QA-202412010029', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(68, 'PM-QA-202412010030', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(69, 'PM-QA-202412010031', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(70, 'PM-QA-202412010032', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(71, 'PM-QA-202412010033', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(72, 'PM-QA-202412010034', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(73, 'PM-QA-202412010035', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(74, 'PM-QA-202412010036', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(75, 'PM-QA-202412010037', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(76, 'PM-QA-202412010038', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(77, 'PM-QA-202412010039', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(78, 'PM-QA-202412010040', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(79, 'PM-QA-202412010041', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(80, 'PM-QA-202412010042', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(81, 'PM-QA-202412010043', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(82, 'PM-QA-202412010044', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(83, 'PM-QA-202412010045', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(84, 'PM-QA-202412010046', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(85, 'PM-QA-202412010047', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(86, 'PM-QA-202412010048', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(87, 'PM-QA-202412010049', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(88, 'PM-QA-202412010050', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(89, 'PM-QA-202412010051', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(90, 'PM-QA-202412010052', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(91, 'PM-QA-202412010053', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(92, 'PM-QA-202412010054', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(93, 'PM-QA-202412010055', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(94, 'PM-QA-202412010056', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(95, 'PM-QA-202412010057', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(96, 'PM-QA-202412010058', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(97, 'PM-QA-202412010059', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(98, 'PM-QA-202412010060', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(99, 'PM-QA-202412010061', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(100, 'PM-QA-202412010062', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(101, 'PM-QA-202412010063', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(102, 'PM-QA-202412010064', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(103, 'PM-QA-202412010065', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(104, 'PM-QA-202412010066', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(105, 'PM-QA-202412010067', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(106, 'PM-QA-202412010068', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(107, 'PM-QA-202412010069', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(108, 'PM-QA-202412010070', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(109, 'PM-QA-202412010071', 1, 1, '2024-12-30 09:29:52', '2024-12-30 09:29:54'),
	(770, 'QAT-AC-4235', 96, 1, '2025-05-11 04:55:56', '2025-05-11 04:55:56'),
	(771, 'QAT-AC-4235', 84, 1, '2025-05-11 04:55:56', '2025-05-11 04:55:56'),
	(778, 'QAT-OP-2310', 1, 1, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(779, 'QAT-OP-2310', 83, 1, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(780, 'QAT-OP-2310', 97, 1, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(781, 'QAT-OP-2310', 98, 1, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(782, 'QAT-OP-2310', 96, 1, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(783, 'QAT-OP-2310', 84, 1, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(784, 'QAT-QA-112333', 1, 1, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(785, 'QAT-QA-112333', 83, 1, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(786, 'QAT-QA-112333', 97, 1, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(787, 'QAT-QA-112333', 98, 1, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(788, 'QAT-QA-112333', 96, 1, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(789, 'QAT-QA-112333', 84, 1, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(822, 'QAT-QC-1233', 1, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(823, 'QAT-QC-1233', 83, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(824, 'QAT-QC-1233', 84, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(825, 'QAT-QC-1233', 102, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(826, 'QAT-QC-1233', 97, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(827, 'QAT-QC-1233', 98, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(828, 'QAT-QC-1233', 99, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(829, 'QAT-QC-1233', 96, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(830, 'NT-OP-7877', 1, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(831, 'NT-OP-7877', 83, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(832, 'NT-OP-7877', 84, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(833, 'NT-OP-7877', 102, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(834, 'NT-OP-7877', 97, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(835, 'NT-OP-7877', 98, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(836, 'NT-OP-7877', 99, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(837, 'NT-OP-7877', 96, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(838, 'NT-IT-9580', 1, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(839, 'NT-IT-9580', 83, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(840, 'NT-IT-9580', 84, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(841, 'NT-IT-9580', 102, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(842, 'NT-IT-9580', 97, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(843, 'NT-IT-9580', 98, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(844, 'NT-IT-9580', 99, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(845, 'NT-IT-9580', 96, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(846, 'QAT-SM-9988', 102, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(847, 'QAT-SM-9988', 1, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(848, 'QAT-SM-9988', 83, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(849, 'QAT-SM-9988', 84, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(850, 'QAT-SM-9988', 97, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(851, 'QAT-SM-9988', 98, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(852, 'QAT-SM-9988', 99, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(853, 'QAT-SM-9988', 96, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(854, 'MM-QA-01', 102, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	(855, 'MM-QA-01', 1, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	(856, 'MM-QA-01', 83, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	(857, 'MM-QA-01', 84, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	(858, 'MM-QA-01', 97, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	(859, 'MM-QA-01', 98, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	(860, 'MM-QA-01', 99, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	(861, 'MM-QA-01', 96, 1, '2025-06-28 08:04:54', '2025-06-28 08:04:54');

-- Dumping structure for table mmdocs.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenis_document_id` bigint unsigned NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `nodocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `namadocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mark_dokumen` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_berlaku` date NOT NULL,
  `tanggal_review` date DEFAULT NULL,
  `statusdocument` bigint NOT NULL DEFAULT '0',
  `revisidocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0.0',
  `otorisasi` int DEFAULT '0',
  `created_by` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `documents_nodocument_unique` (`nodocument`),
  KEY `documents_jenis_document_id_foreign` (`jenis_document_id`),
  KEY `documents_department_id_foreign` (`department_id`),
  CONSTRAINT `documents_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_jenis_document_id_foreign` FOREIGN KEY (`jenis_document_id`) REFERENCES `master_docs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20247826 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.documents: ~14 rows (approximately)
INSERT INTO `documents` (`id`, `jenis_document_id`, `department_id`, `nodocument`, `namadocument`, `deskripsi`, `mark_dokumen`, `tanggal_berlaku`, `tanggal_review`, `statusdocument`, `revisidocument`, `otorisasi`, `created_by`, `created_at`, `updated_at`) VALUES
	(20247805, 28, 13, 'QAT-SS-123123', 'TESTEST', 'Testestest', 'QAT-SS-123123', '2025-04-30', '2026-04-30', 2, '0.0', 0, 0, '2025-04-29 20:24:44', '2025-05-19 01:47:45'),
	(20247806, 27, 13, 'TS-SS-7787', 'TESTING NEW', 'Jfjgvnhbjbhbmjbm Ghvjgvh', 'TS-SS-7787', '2025-05-02', '2026-05-02', 3, '0.0', 0, 0, '2025-05-01 03:17:22', '2025-05-01 03:17:22'),
	(20247808, 28, 10, 'QAT-AR-4115', 'UPLOAD TEST NAMA', 'Asd', 'Restricted', '2025-05-12', '2026-05-12', 3, '0.0', 0, 1, '2025-05-10 19:25:51', '2025-05-10 19:25:51'),
	(20247809, 28, 11, 'QAT-AD-4115', 'UPLOAD TEST NAMA', 'Sdfsd', 'Confidential', '2025-05-12', '2026-05-12', 3, '0.0', 0, 1, '2025-05-10 19:29:29', '2025-05-10 19:29:29'),
	(20247810, 28, 12, 'QAT-SM-4115', 'UPLOAD TEST NAMA', 'Sd', 'Confidential', '2025-05-12', '2026-05-12', 3, '0.0', 0, 1, '2025-05-10 19:37:20', '2025-05-10 19:37:20'),
	(20247812, 28, 9, 'QAT-AC-4235', 'UPLOAD TEST NAMA', 'Dd', 'Confidential', '2025-05-12', '2026-05-12', 2, '0.0', 0, 1, '2025-05-11 04:55:56', '2025-05-19 03:17:22'),
	(20247813, 28, 19, 'QAT-PC-2130', 'TESTING NEW DETAIL', 'New Detail Testing', 'Confidential', '2025-05-16', '2026-05-16', 3, '0.0', 0, 1, '2025-05-16 02:53:03', '2025-05-16 02:53:03'),
	(20247814, 28, 18, 'QAT-OP-2310', 'TESTING NEW APPROVAL', 'Testing New With Approval', 'Confidential', '2025-05-31', '2026-05-31', 3, '0.0', 0, 1, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(20247815, 28, 15, 'QAT-QA-112333', 'TESTING NEW APPROVAL', 'Asdsa', 'Confidential', '2025-06-07', '2027-06-07', 5, '0.0', 0, 1, '2025-05-16 03:02:01', '2025-05-19 03:19:12'),
	(20247816, 28, 12, 'QAT-SM-2514', 'PENJUALAN', 'Penjualan', 'Confidential', '2025-06-16', '2026-06-16', 3, '0.0', 0, 1, '2025-06-15 00:59:30', '2025-06-15 00:59:30'),
	(20247822, 28, 14, 'QAT-QC-1233', 'PENJUALAN', 'Sadsadasdas', 'Confidential', '2025-06-17', '2026-06-17', 3, '0.0', 0, 1, '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(20247823, 29, 18, 'NT-OP-7877', 'TEST', 'Test', 'Confidential', '2025-06-20', '2026-06-20', 3, '0.0', 0, 1, '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(20247824, 29, 21, 'NT-IT-9580', 'TEST', 'Test', 'Confidential', '2025-06-25', '2026-06-25', 3, '0.0', 0, 1, '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(20247825, 28, 12, 'QAT-SM-9988', 'TEST SM', 'Test', 'Confidential', '2025-06-18', '2026-06-18', 3, '0.0', 0, 102, '2025-06-16 03:09:25', '2025-06-16 03:09:25');

-- Dumping structure for table mmdocs.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table mmdocs.file_external
CREATE TABLE IF NOT EXISTS `file_external` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_folder_id_foreign` (`folder_id`),
  KEY `file_created_by_foreign` (`created_by`),
  CONSTRAINT `file_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folder` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.file_external: ~0 rows (approximately)
INSERT INTO `file_external` (`id`, `name`, `path`, `folder_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(11, 'DO CORINT.jpg', 'external/1bJopttsWSRLJxruZFoy40PJr0M9HcGFl7ZEdvUz.jpg', 3, 1, '2025-07-04 00:02:59', '2025-07-04 00:02:59');

-- Dumping structure for table mmdocs.folder
CREATE TABLE IF NOT EXISTS `folder` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `folder_parent_id_foreign` (`parent_id`),
  KEY `folder_created_by_foreign` (`created_by`),
  CONSTRAINT `folder_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `folder_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `folder` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.folder: ~19 rows (approximately)
INSERT INTO `folder` (`id`, `name`, `parent_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(2, 'Formulir & Diagram', NULL, 1, '2025-06-25 03:41:34', '2025-06-25 03:41:34'),
	(3, 'gtgt', NULL, 1, '2025-06-25 03:44:33', '2025-06-25 03:44:33'),
	(6, 'Formulir & Diagram', 2, 1, '2025-06-25 03:41:34', '2025-06-25 03:41:34'),
	(8, 'A', NULL, 1, '2025-06-26 23:08:50', '2025-06-26 23:08:50'),
	(9, 'B', NULL, 1, '2025-06-26 23:08:58', '2025-06-26 23:08:58'),
	(10, 'D', NULL, 1, '2025-06-26 23:09:05', '2025-06-26 23:09:05'),
	(17, 'Super Admin', 8, 1, '2025-06-27 11:32:25', '2025-06-27 11:32:25'),
	(18, 'mm', 8, 1, '2025-06-27 11:34:14', '2025-06-27 11:34:14'),
	(19, 'ZZ', 8, 1, '2025-06-27 11:36:37', '2025-06-27 11:36:37'),
	(20, 'xx', 8, 1, '2025-06-27 11:36:43', '2025-06-27 11:36:43'),
	(21, 'vv', 8, 1, '2025-06-27 11:36:51', '2025-06-27 11:36:51'),
	(22, 'cc', 8, 1, '2025-06-27 11:37:03', '2025-06-27 11:37:03'),
	(23, 'bb', 8, 1, '2025-06-27 11:37:09', '2025-06-27 11:37:09'),
	(24, 'nn', 8, 1, '2025-06-27 11:37:17', '2025-06-27 11:37:17'),
	(25, 'mm', 8, 1, '2025-06-27 11:37:25', '2025-06-27 11:37:25'),
	(26, 'qq', 8, 1, '2025-06-27 11:37:33', '2025-06-27 11:37:33'),
	(27, 'ee', 8, 1, '2025-06-27 11:37:40', '2025-06-27 11:37:40'),
	(28, 'ww', 8, 1, '2025-06-27 11:37:46', '2025-06-27 11:37:46'),
	(29, 'rr', 8, 1, '2025-06-27 11:37:52', '2025-06-27 11:37:52');

-- Dumping structure for table mmdocs.folder_user
CREATE TABLE IF NOT EXISTS `folder_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.folder_user: ~187 rows (approximately)
INSERT INTO `folder_user` (`id`, `folder_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, NULL),
	(2, 1, 83, NULL, NULL),
	(3, 1, 84, NULL, NULL),
	(4, 1, 96, NULL, NULL),
	(5, 1, 97, NULL, NULL),
	(6, 1, 98, NULL, NULL),
	(7, 1, 99, NULL, NULL),
	(8, 1, 102, NULL, NULL),
	(9, 2, 97, NULL, NULL),
	(10, 2, 98, NULL, NULL),
	(11, 2, 99, NULL, NULL),
	(12, 2, 102, NULL, NULL),
	(13, 3, 1, NULL, NULL),
	(14, 3, 97, NULL, NULL),
	(15, 3, 98, NULL, NULL),
	(16, 3, 99, NULL, NULL),
	(17, 3, 102, NULL, NULL),
	(18, 4, 1, NULL, NULL),
	(19, 5, 1, NULL, NULL),
	(20, 6, 1, NULL, NULL),
	(21, 7, 1, NULL, NULL),
	(22, 8, 1, NULL, NULL),
	(23, 8, 83, NULL, NULL),
	(24, 8, 84, NULL, NULL),
	(25, 8, 96, NULL, NULL),
	(26, 8, 97, NULL, NULL),
	(27, 8, 98, NULL, NULL),
	(28, 8, 99, NULL, NULL),
	(29, 8, 102, NULL, NULL),
	(30, 9, 1, NULL, NULL),
	(31, 9, 83, NULL, NULL),
	(32, 9, 84, NULL, NULL),
	(33, 9, 96, NULL, NULL),
	(34, 9, 97, NULL, NULL),
	(35, 9, 98, NULL, NULL),
	(36, 9, 99, NULL, NULL),
	(37, 9, 102, NULL, NULL),
	(38, 10, 1, NULL, NULL),
	(39, 10, 83, NULL, NULL),
	(40, 10, 84, NULL, NULL),
	(41, 10, 96, NULL, NULL),
	(42, 10, 97, NULL, NULL),
	(43, 10, 98, NULL, NULL),
	(44, 10, 99, NULL, NULL),
	(45, 10, 102, NULL, NULL),
	(46, 11, 1, NULL, NULL),
	(47, 11, 83, NULL, NULL),
	(48, 11, 84, NULL, NULL),
	(49, 11, 96, NULL, NULL),
	(50, 11, 97, NULL, NULL),
	(51, 11, 98, NULL, NULL),
	(52, 11, 99, NULL, NULL),
	(53, 11, 102, NULL, NULL),
	(54, 15, 1, NULL, NULL),
	(55, 15, 83, NULL, NULL),
	(56, 15, 84, NULL, NULL),
	(57, 15, 96, NULL, NULL),
	(58, 15, 97, NULL, NULL),
	(59, 15, 98, NULL, NULL),
	(60, 15, 99, NULL, NULL),
	(61, 15, 102, NULL, NULL),
	(62, 16, 1, NULL, NULL),
	(63, 16, 83, NULL, NULL),
	(64, 16, 84, NULL, NULL),
	(65, 16, 96, NULL, NULL),
	(66, 16, 97, NULL, NULL),
	(67, 16, 98, NULL, NULL),
	(68, 16, 99, NULL, NULL),
	(69, 16, 102, NULL, NULL),
	(70, 17, 1, NULL, NULL),
	(71, 17, 83, NULL, NULL),
	(72, 17, 84, NULL, NULL),
	(73, 17, 96, NULL, NULL),
	(74, 17, 97, NULL, NULL),
	(75, 17, 98, NULL, NULL),
	(76, 17, 99, NULL, NULL),
	(77, 17, 102, NULL, NULL),
	(78, 18, 1, NULL, NULL),
	(79, 18, 83, NULL, NULL),
	(80, 18, 84, NULL, NULL),
	(81, 18, 96, NULL, NULL),
	(82, 18, 97, NULL, NULL),
	(83, 18, 98, NULL, NULL),
	(84, 18, 99, NULL, NULL),
	(85, 18, 102, NULL, NULL),
	(86, 19, 1, NULL, NULL),
	(87, 19, 83, NULL, NULL),
	(88, 19, 84, NULL, NULL),
	(89, 19, 96, NULL, NULL),
	(90, 19, 97, NULL, NULL),
	(91, 19, 98, NULL, NULL),
	(92, 19, 99, NULL, NULL),
	(93, 19, 102, NULL, NULL),
	(94, 20, 1, NULL, NULL),
	(95, 20, 83, NULL, NULL),
	(96, 20, 84, NULL, NULL),
	(97, 20, 96, NULL, NULL),
	(98, 20, 97, NULL, NULL),
	(99, 20, 98, NULL, NULL),
	(100, 20, 99, NULL, NULL),
	(101, 20, 102, NULL, NULL),
	(102, 21, 1, NULL, NULL),
	(103, 21, 83, NULL, NULL),
	(104, 21, 84, NULL, NULL),
	(105, 21, 96, NULL, NULL),
	(106, 21, 97, NULL, NULL),
	(107, 21, 98, NULL, NULL),
	(108, 21, 99, NULL, NULL),
	(109, 21, 102, NULL, NULL),
	(110, 22, 1, NULL, NULL),
	(111, 22, 83, NULL, NULL),
	(112, 22, 84, NULL, NULL),
	(113, 22, 96, NULL, NULL),
	(114, 22, 97, NULL, NULL),
	(115, 22, 98, NULL, NULL),
	(116, 22, 99, NULL, NULL),
	(117, 22, 102, NULL, NULL),
	(118, 23, 1, NULL, NULL),
	(119, 23, 83, NULL, NULL),
	(120, 23, 84, NULL, NULL),
	(121, 23, 96, NULL, NULL),
	(122, 23, 97, NULL, NULL),
	(123, 23, 98, NULL, NULL),
	(124, 23, 99, NULL, NULL),
	(125, 23, 102, NULL, NULL),
	(126, 24, 1, NULL, NULL),
	(127, 24, 83, NULL, NULL),
	(128, 24, 84, NULL, NULL),
	(129, 24, 96, NULL, NULL),
	(130, 24, 97, NULL, NULL),
	(131, 24, 98, NULL, NULL),
	(132, 24, 99, NULL, NULL),
	(133, 24, 102, NULL, NULL),
	(134, 25, 1, NULL, NULL),
	(135, 25, 83, NULL, NULL),
	(136, 25, 84, NULL, NULL),
	(137, 25, 96, NULL, NULL),
	(138, 25, 97, NULL, NULL),
	(139, 25, 98, NULL, NULL),
	(140, 25, 99, NULL, NULL),
	(141, 25, 102, NULL, NULL),
	(142, 26, 1, NULL, NULL),
	(143, 26, 83, NULL, NULL),
	(144, 26, 84, NULL, NULL),
	(145, 26, 96, NULL, NULL),
	(146, 26, 97, NULL, NULL),
	(147, 26, 98, NULL, NULL),
	(148, 26, 99, NULL, NULL),
	(149, 26, 102, NULL, NULL),
	(150, 27, 1, NULL, NULL),
	(151, 27, 83, NULL, NULL),
	(152, 27, 84, NULL, NULL),
	(153, 27, 96, NULL, NULL),
	(154, 27, 97, NULL, NULL),
	(155, 27, 98, NULL, NULL),
	(156, 27, 99, NULL, NULL),
	(157, 27, 102, NULL, NULL),
	(158, 28, 1, NULL, NULL),
	(159, 28, 83, NULL, NULL),
	(160, 28, 84, NULL, NULL),
	(161, 28, 96, NULL, NULL),
	(162, 28, 97, NULL, NULL),
	(163, 28, 98, NULL, NULL),
	(164, 28, 99, NULL, NULL),
	(165, 28, 102, NULL, NULL),
	(166, 29, 1, NULL, NULL),
	(167, 29, 83, NULL, NULL),
	(168, 29, 84, NULL, NULL),
	(169, 29, 96, NULL, NULL),
	(170, 29, 97, NULL, NULL),
	(171, 29, 98, NULL, NULL),
	(172, 29, 99, NULL, NULL),
	(173, 29, 102, NULL, NULL),
	(174, 30, 1, NULL, NULL),
	(175, 30, 83, NULL, NULL),
	(176, 30, 84, NULL, NULL),
	(177, 30, 96, NULL, NULL),
	(178, 30, 97, NULL, NULL),
	(179, 30, 98, NULL, NULL),
	(180, 30, 99, NULL, NULL),
	(181, 30, 102, NULL, NULL),
	(182, 31, 1, NULL, NULL),
	(183, 31, 83, NULL, NULL),
	(184, 31, 84, NULL, NULL),
	(185, 31, 96, NULL, NULL),
	(186, 31, 97, NULL, NULL),
	(187, 31, 98, NULL, NULL),
	(188, 31, 99, NULL, NULL),
	(189, 31, 102, NULL, NULL),
	(190, 32, 1, NULL, NULL),
	(191, 32, 83, NULL, NULL),
	(192, 32, 84, NULL, NULL),
	(193, 32, 96, NULL, NULL),
	(194, 32, 97, NULL, NULL),
	(195, 32, 98, NULL, NULL),
	(196, 32, 99, NULL, NULL),
	(197, 32, 102, NULL, NULL),
	(198, 33, 1, NULL, NULL),
	(199, 33, 83, NULL, NULL),
	(200, 33, 84, NULL, NULL),
	(201, 33, 96, NULL, NULL),
	(202, 33, 97, NULL, NULL),
	(203, 33, 98, NULL, NULL),
	(204, 33, 99, NULL, NULL),
	(205, 33, 102, NULL, NULL);

-- Dumping structure for table mmdocs.jabatan
CREATE TABLE IF NOT EXISTS `jabatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.jabatan: ~0 rows (approximately)

-- Dumping structure for table mmdocs.log_activities
CREATE TABLE IF NOT EXISTS `log_activities` (
  `log_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='protected $fillable = [\r\n        ''log_id'',\r\n        ''user_id'',\r\n        ''modul'',\r\n        ''action'',\r\n        ''resource_id'',\r\n        ''description'',\r\n    ];';

-- Dumping data for table mmdocs.log_activities: ~99 rows (approximately)
INSERT INTO `log_activities` (`log_id`, `user_id`, `modul`, `action`, `resource_id`, `description`, `created_at`, `updated_at`) VALUES
	('log-0000001', '1', 'Prosedur Mutu', 'Delete', 'QAT-AC-4115', 'Menghapus Document', '2025-05-20 23:49:17', '2025-05-20 23:49:17'),
	('log-0000002', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/Invoice _ Tokopedia_new.pdf', 'File dihapus', '2025-05-26 01:49:56', '2025-05-26 01:49:56'),
	('log-0000003', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/SEPTIAN RACHMAT PUTRA-OKE.pdf', 'File dihapus', '2025-05-26 01:50:32', '2025-05-26 01:50:32'),
	('log-2025004', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/NEO-202412-1817569.pdf', 'File dihapus', '2025-05-26 20:22:59', '2025-05-26 20:22:59'),
	('log-2025005', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/Application Form PT. NATURAL PERSADAN MANDIRI .docx', 'File dihapus', '2025-05-26 20:26:58', '2025-05-26 20:26:58'),
	('log-2025006', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/MMQA-DOCS.xlsx', 'File Sasaran dihapus', '2025-05-26 20:59:58', '2025-05-26 20:59:58'),
	('log-2025007', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/cv_compressed.pdf', 'File Organisasi dihapus', '2025-05-27 00:15:51', '2025-05-27 00:15:51'),
	('log-2025008', '1', 'Prosedur Mutu', 'Viewed', 'QAT-AR-4115', 'Document dilihat', '2025-05-27 03:04:09', '2025-05-27 03:04:09'),
	('log-2025009', '1', 'Prosedur Mutu', 'Viewed', 'QAT-AD-4115', 'Document dilihat', '2025-06-03 02:58:27', '2025-06-03 02:58:27'),
	('log-2025010', '1', 'Prosedur Mutu', 'Viewed', 'QAT-OP-2310', 'Document dilihat', '2025-06-03 02:58:34', '2025-06-03 02:58:34'),
	('log-2025011', '1', 'Prosedur Mutu', 'Viewed', 'QAT-OP-2310', 'Document dilihat', '2025-06-03 02:58:45', '2025-06-03 02:58:45'),
	('log-2025012', '1', 'Prosedur Mutu', 'Viewed', 'QAT-AD-4115', 'Document dilihat', '2025-06-03 19:42:53', '2025-06-03 19:42:53'),
	('log-2025013', '1', 'Prosedur Mutu', 'Viewed', 'QAT-AD-4115', 'Document dilihat', '2025-06-03 20:34:56', '2025-06-03 20:34:56'),
	('log-2025014', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/Menu Quality Management Sistem.docx', 'File Kebijakan dihapus', '2025-06-04 00:16:54', '2025-06-04 00:16:54'),
	('log-2025015', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-12 01:04:26', '2025-06-12 01:04:26'),
	('log-2025016', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-12 01:07:48', '2025-06-12 01:07:48'),
	('log-2025017', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-12 01:10:42', '2025-06-12 01:10:42'),
	('log-2025018', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-12 08:11:00', '2025-06-12 08:11:00'),
	('log-2025019', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-12 08:11:21', '2025-06-12 08:11:21'),
	('log-2025020', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-12 08:12:13', '2025-06-12 08:12:13'),
	('log-2025021', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-12 08:12:27', '2025-06-12 08:12:27'),
	('log-2025022', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:33:02', '2025-06-14 02:33:02'),
	('log-2025023', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:33:43', '2025-06-14 02:33:43'),
	('log-2025024', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:34:39', '2025-06-14 02:34:39'),
	('log-2025025', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:35:45', '2025-06-14 02:35:45'),
	('log-2025026', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:43:25', '2025-06-14 02:43:25'),
	('log-2025027', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:43:37', '2025-06-14 02:43:37'),
	('log-2025028', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:45:15', '2025-06-14 02:45:15'),
	('log-2025029', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:57:08', '2025-06-14 02:57:08'),
	('log-2025030', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 02:58:40', '2025-06-14 02:58:40'),
	('log-2025031', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 03:12:45', '2025-06-14 03:12:45'),
	('log-2025032', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-14 04:26:34', '2025-06-14 04:26:34'),
	('log-2025033', '1', 'Manual Mutu File', 'Deleted', 'quality_manual/Inv Renolit.pdf', 'File Organisasi dihapus', '2025-06-14 11:12:54', '2025-06-14 11:12:54'),
	('log-2025034', '1', 'Master User', 'Created', 'superadmin@merindo.co.id', 'Menambahkan Master User.', '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	('log-2025035', '1', 'Master User', 'Updated', 'gesang@merindo.co.id', 'Perubahan Master User.', '2025-06-15 00:08:56', '2025-06-15 00:08:56'),
	('log-2025036', '1', 'Master User', 'Updated', 'gesang@merindo.co.id', 'Perubahan Master User.', '2025-06-15 00:09:11', '2025-06-15 00:09:11'),
	('log-2025037', '1', 'Master User', 'Updated', 'gesang@merindo.co.id', 'Perubahan Master User.', '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	('log-2025038', '1', 'Master Menu', 'Deleted', '96', 'Master menu dihapus', '2025-06-15 00:20:25', '2025-06-15 00:20:25'),
	('log-2025039', '1', 'Prosedur Mutu', 'Created', 'QAT-SM-2514', 'Document ditambahkan', '2025-06-15 00:59:30', '2025-06-15 00:59:30'),
	('log-2025040', '1', 'Prosedur Mutu', 'Viewed', 'QAT-SM-2514', 'Document dilihat', '2025-06-15 00:59:45', '2025-06-15 00:59:45'),
	('log-2025041', '1', 'Prosedur Mutu', 'Viewed', 'QAT-SM-2514', 'Document dilihat', '2025-06-15 01:00:05', '2025-06-15 01:00:05'),
	('log-2025042', '1', 'Prosedur Mutu', 'Created', 'QAT-QC-1233', 'Document ditambahkan', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	('log-2025043', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:00:53', '2025-06-15 09:00:53'),
	('log-2025044', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:09:14', '2025-06-15 09:09:14'),
	('log-2025045', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:09:15', '2025-06-15 09:09:15'),
	('log-2025046', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:09:59', '2025-06-15 09:09:59'),
	('log-2025047', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:10:06', '2025-06-15 09:10:06'),
	('log-2025048', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:10:18', '2025-06-15 09:10:18'),
	('log-2025049', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:10:38', '2025-06-15 09:10:38'),
	('log-2025050', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:11:02', '2025-06-15 09:11:02'),
	('log-2025051', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:11:12', '2025-06-15 09:11:12'),
	('log-2025052', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:11:12', '2025-06-15 09:11:12'),
	('log-2025053', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:11:26', '2025-06-15 09:11:26'),
	('log-2025054', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:11:47', '2025-06-15 09:11:47'),
	('log-2025055', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:12:00', '2025-06-15 09:12:00'),
	('log-2025056', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:12:01', '2025-06-15 09:12:01'),
	('log-2025057', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:12:14', '2025-06-15 09:12:14'),
	('log-2025058', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:12:23', '2025-06-15 09:12:23'),
	('log-2025059', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:12:33', '2025-06-15 09:12:33'),
	('log-2025060', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:12:57', '2025-06-15 09:12:57'),
	('log-2025061', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:13:18', '2025-06-15 09:13:18'),
	('log-2025062', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:13:19', '2025-06-15 09:13:19'),
	('log-2025063', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:14:02', '2025-06-15 09:14:02'),
	('log-2025064', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-15 09:14:04', '2025-06-15 09:14:04'),
	('log-2025065', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QC-1233', 'Document dilihat', '2025-06-16 00:31:05', '2025-06-16 00:31:05'),
	('log-2025066', '1', 'Prosedur Mutu', 'Created', 'NT-OP-7877', 'Document ditambahkan', '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	('log-2025067', '1', 'Prosedur Mutu', 'Viewed', 'NT-OP-7877', 'Document dilihat', '2025-06-16 01:43:20', '2025-06-16 01:43:20'),
	('log-2025068', '1', 'Prosedur Mutu', 'Created', 'NT-IT-9580', 'Document ditambahkan', '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	('log-2025069', '102', 'Prosedur Mutu', 'Created', 'QAT-SM-9988', 'Document ditambahkan', '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	('log-2025070', '102', 'Prosedur Mutu', 'Viewed', 'QAT-SM-9988', 'Document dilihat', '2025-06-16 03:09:36', '2025-06-16 03:09:36'),
	('log-2025071', '1', 'Master Menu', 'Updated', '76', 'Master menu diperbaharui', '2025-06-19 00:08:55', '2025-06-19 00:08:55'),
	('log-2025072', '102', 'Prosedur Mutu', 'Viewed', 'NT-IT-9580', 'Document dilihat', '2025-06-19 18:51:31', '2025-06-19 18:51:31'),
	('log-2025073', '102', 'Prosedur Mutu', 'Viewed', 'QAT-SM-9988', 'Document dilihat', '2025-06-19 18:51:39', '2025-06-19 18:51:39'),
	('log-2025074', '1', 'External Document', 'Created', 'Formulir & Diagram', 'Membuat folder', '2025-06-24 20:11:54', '2025-06-24 20:11:54'),
	('log-2025075', '1', 'External Document', 'Created', 'Binder', 'Membuat folder', '2025-06-25 00:00:13', '2025-06-25 00:00:13'),
	('log-2025076', '1', 'External Document', 'Created', 'Test New', 'Membuat folder', '2025-06-25 03:37:49', '2025-06-25 03:37:49'),
	('log-2025077', '1', 'External Document', 'Created', 'Formulir & Diagram', 'Membuat folder', '2025-06-25 03:41:34', '2025-06-25 03:41:34'),
	('log-2025078', '1', 'External Document', 'Created', 'gtgt', 'Membuat folder', '2025-06-25 03:44:33', '2025-06-25 03:44:33'),
	('log-2025079', '1', 'External Document', 'Created', 'A', 'Membuat folder', '2025-06-26 23:08:50', '2025-06-26 23:08:50'),
	('log-2025080', '1', 'External Document', 'Created', 'B', 'Membuat folder', '2025-06-26 23:08:58', '2025-06-26 23:08:58'),
	('log-2025081', '1', 'External Document', 'Created', 'D', 'Membuat folder', '2025-06-26 23:09:05', '2025-06-26 23:09:05'),
	('log-2025082', '1', 'External Document', 'Created', 'kk', 'Membuat folder', '2025-06-27 04:13:45', '2025-06-27 04:13:45'),
	('log-2025083', '1', 'External Document', 'Created', 'mm', 'Membuat folder', '2025-06-27 04:21:06', '2025-06-27 04:21:06'),
	('log-2025084', '1', 'External Document', 'Created', 'nn', 'Membuat folder', '2025-06-27 04:22:34', '2025-06-27 04:22:34'),
	('log-2025085', '1', 'External Document', 'Created', 'Super Admin', 'Membuat folder', '2025-06-27 11:32:25', '2025-06-27 11:32:25'),
	('log-2025086', '1', 'External Document', 'Created', 'mm', 'Membuat folder', '2025-06-27 11:34:14', '2025-06-27 11:34:14'),
	('log-2025087', '1', 'External Document', 'Created', 'ZZ', 'Membuat folder', '2025-06-27 11:36:37', '2025-06-27 11:36:37'),
	('log-2025088', '1', 'External Document', 'Created', 'xx', 'Membuat folder', '2025-06-27 11:36:43', '2025-06-27 11:36:43'),
	('log-2025089', '1', 'External Document', 'Created', 'vv', 'Membuat folder', '2025-06-27 11:36:51', '2025-06-27 11:36:51'),
	('log-2025090', '1', 'External Document', 'Created', 'cc', 'Membuat folder', '2025-06-27 11:37:03', '2025-06-27 11:37:03'),
	('log-2025091', '1', 'External Document', 'Created', 'bb', 'Membuat folder', '2025-06-27 11:37:09', '2025-06-27 11:37:09'),
	('log-2025092', '1', 'External Document', 'Created', 'nn', 'Membuat folder', '2025-06-27 11:37:17', '2025-06-27 11:37:17'),
	('log-2025093', '1', 'External Document', 'Created', 'mm', 'Membuat folder', '2025-06-27 11:37:25', '2025-06-27 11:37:25'),
	('log-2025094', '1', 'External Document', 'Created', 'qq', 'Membuat folder', '2025-06-27 11:37:33', '2025-06-27 11:37:33'),
	('log-2025095', '1', 'External Document', 'Created', 'ee', 'Membuat folder', '2025-06-27 11:37:40', '2025-06-27 11:37:40'),
	('log-2025096', '1', 'External Document', 'Created', 'ww', 'Membuat folder', '2025-06-27 11:37:46', '2025-06-27 11:37:46'),
	('log-2025097', '1', 'External Document', 'Created', 'rr', 'Membuat folder', '2025-06-27 11:37:52', '2025-06-27 11:37:52'),
	('log-2025098', '1', 'External Document', 'Created', 'mm', 'Membuat folder', '2025-06-27 11:39:20', '2025-06-27 11:39:20'),
	('log-2025099', '1', 'External Document', 'Created', 'Super Admin', 'Membuat folder', '2025-06-27 11:50:11', '2025-06-27 11:50:11'),
	('log-2025100', '1', 'External Document', 'Created', 'Super Admin', 'Membuat folder', '2025-06-27 11:52:41', '2025-06-27 11:52:41'),
	('log-2025101', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-28 08:04:54', '2025-06-28 08:04:54'),
	('log-2025102', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-28 10:01:09', '2025-06-28 10:01:09'),
	('log-2025103', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-28 10:04:56', '2025-06-28 10:04:56'),
	('log-2025104', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-28 10:38:39', '2025-06-28 10:38:39'),
	('log-2025105', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-28 10:51:47', '2025-06-28 10:51:47'),
	('log-2025106', '1', 'Manual Mutu', 'Updated', 'MM-QA-01', 'Document diperbaharui', '2025-06-28 11:33:59', '2025-06-28 11:33:59'),
	('log-2025107', '1', 'External Document', 'Created', 'ZZ', 'Membuat folder', '2025-07-03 23:44:04', '2025-07-03 23:44:04'),
	('log-2025108', '1', 'Prosedur Mutu', 'Viewed', 'TS-SS-7787', 'Document dilihat', '2025-08-12 23:42:30', '2025-08-12 23:42:30'),
	('log-2025109', '1', 'Prosedur Mutu', 'Viewed', 'TS-SS-7787', 'Document dilihat', '2025-08-12 23:43:04', '2025-08-12 23:43:04'),
	('log-2025110', '1', 'Prosedur Mutu', 'Viewed', 'QAT-QA-112333', 'Document dilihat', '2025-08-12 23:43:15', '2025-08-12 23:43:15'),
	('log-2025111', '1', 'Prosedur Mutu', 'Viewed', 'QAT-SM-2514', 'Document dilihat', '2025-08-12 23:43:32', '2025-08-12 23:43:32');

-- Dumping structure for table mmdocs.master_docs
CREATE TABLE IF NOT EXISTS `master_docs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.master_docs: ~4 rows (approximately)
INSERT INTO `master_docs` (`id`, `name`, `kode`, `created_id`, `created_at`, `updated_at`) VALUES
	(25, 'test', 't', '83', '2025-04-10 19:48:33', '2025-04-10 19:48:33'),
	(27, 'TESTTTTT', 'TS', '83', '2025-04-10 20:03:38', '2025-04-10 20:03:38'),
	(28, 'Quality Assurance Test', 'QAT', '1', '2025-04-14 19:42:45', '2025-04-14 19:42:45'),
	(29, 'New Test', 'NT', '1', '2025-05-02 04:08:36', '2025-05-02 04:08:36');

-- Dumping structure for table mmdocs.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_urut` int DEFAULT NULL,
  `category_id` bigint DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_parent_id_foreign` (`parent_id`),
  CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.menus: ~37 rows (approximately)
INSERT INTO `menus` (`id`, `name`, `url`, `icon`, `no_urut`, `category_id`, `parent_id`, `created`, `created_at`, `updated_at`) VALUES
	(1, 'Dashboard', '/dashboard', 'fas fa-chart-line', 1, 2, NULL, 1, '2024-11-14 21:24:27', '2025-03-28 20:12:11'),
	(2, 'Master Data', '#', 'fas fa-tasks', 1, 3, NULL, 1, '2024-11-14 21:24:28', '2024-12-30 17:34:22'),
	(3, 'Jenis Dokumen', '/mst_docs', 'fas fa-circle', 1, NULL, 2, 1, '2024-11-14 21:24:29', '2025-04-02 17:42:57'),
	(4, 'Departmen', '/mst_dept', 'fas fa-circle', 3, NULL, 2, 1, '2024-11-14 21:24:30', '2025-04-02 17:43:42'),
	(5, 'Role User', '/mng_role', 'fas fa-circle', NULL, NULL, 20, 1, '2024-11-14 21:24:31', '2025-02-10 20:12:40'),
	(6, 'Menu Setting', '/sys_menu', NULL, 1, NULL, 25, 1, '2024-11-14 14:24:29', '2025-02-10 13:18:54'),
	(10, 'Manual Mutu', '/docs_qualitymanual', 'fas fa-landmark', 2, 4, NULL, 1, '2024-11-14 21:24:32', '2025-03-28 19:31:14'),
	(12, 'Prosedur Mutu', '/docs_qualityprocedure', 'fas fa-book-open', 3, 4, NULL, 1, '2024-11-14 20:12:39', '2025-03-28 19:40:08'),
	(13, 'Instruksi Kerja', '/docs_workinstruction', 'fas fa-chalkboard-teacher', 4, 4, NULL, 1, '2024-11-14 20:15:29', '2025-03-28 20:09:47'),
	(20, 'Pengelolaan User', '#', 'fas fa-users-cog', 2, 3, NULL, 1, '2024-11-14 21:24:33', '2025-02-10 20:04:35'),
	(25, 'Pengaturan', '#', 'fas fa-cogs', 1, 6, NULL, 1, '2024-11-14 14:24:33', '2025-03-28 13:30:46'),
	(26, 'Aplikasi', '/sys_app', 'fas fa-circle', 2, NULL, 25, 1, '2024-11-14 14:24:33', '2025-02-24 05:36:35'),
	(74, 'Dokumen Eksternal', '/docs_external', 'far fa-file-alt', 6, 4, NULL, 1, '2024-12-30 17:16:44', '2025-03-28 20:27:03'),
	(76, 'Formulir & Diagram', '/docs_formulir', 'fas fa-file-archive', 5, 4, NULL, 1, '2024-12-30 17:37:37', '2025-06-19 00:08:55'),
	(79, 'User Akun', '/mng_user', 'fas fa-circle', NULL, NULL, 20, 1, '2025-01-12 20:31:59', '2025-01-12 20:37:20'),
	(80, 'Akses Kontrol', '/mng_access', 'fas fa-circle', NULL, NULL, 20, 1, '2025-01-12 20:33:21', '2025-01-14 13:31:21'),
	(91, 'Internal Dokumen', '/docs_official', 'fas fa-bullhorn', 7, 4, NULL, 1, NULL, '2025-04-05 02:29:21'),
	(94, 'Sistem Log', '/sys_logs', 'fas fa-exchange-alt', 2, 6, NULL, 1, '2025-04-17 20:21:43', '2025-05-02 17:07:40'),
	(97, 'Kategori Aset', '/mst_cat_asset', 'fas fa-circle', NULL, NULL, 2, 1, '2025-05-02 04:40:07', '2025-05-02 04:40:07'),
	(98, 'Lokasi Aset', '/mst_lok_asset', 'fas fa-circle', NULL, NULL, 2, 1, '2025-05-02 04:41:19', '2025-05-02 04:41:19'),
	(99, 'Vendor', '/mst_vendor_asset', 'fas fa-circle', NULL, NULL, 2, 1, '2025-05-02 04:45:56', '2025-05-02 04:45:56'),
	(103, 'Manajemen Aset', '#', 'fas fa-tasks', NULL, 5, NULL, 1, '2025-05-02 05:17:15', '2025-05-02 05:17:15'),
	(104, 'Daftar Aset', '/aset_daftar_aset', 'fas fa-circle', NULL, NULL, 103, 1, '2025-05-02 05:18:08', '2025-05-02 05:18:08'),
	(105, 'Pelacakan Aset', '/aset_pelacakan_aset', 'fas fa-circle', NULL, NULL, 103, 1, '2025-05-02 05:18:55', '2025-05-02 05:18:55'),
	(106, 'Penyusutan Aset', '/aset_penyusutan_aset', 'fas fa-circle', NULL, NULL, 103, 1, '2025-05-02 05:19:24', '2025-05-02 05:19:24'),
	(107, 'Pemeliharaan Aset', '#', 'fas fa-cogs', NULL, 5, NULL, 1, '2025-05-02 05:20:06', '2025-05-02 05:20:06'),
	(108, 'Request Perbaikan', '/aset_req_pembaharuan', 'fas fa-circle', NULL, NULL, 107, 1, '2025-05-02 05:21:08', '2025-05-02 05:21:08'),
	(109, 'Jadwal Perbaikan', '/aset_jadwal_perbaikan', 'fas fa-circle', NULL, NULL, 107, 1, '2025-05-02 05:22:04', '2025-05-02 05:22:04'),
	(110, 'Riwayat Perbaikan', '/aset_riwayat_perbaikan', 'fas fa-circle', NULL, NULL, 107, 1, '2025-05-02 05:22:39', '2025-05-02 05:22:39'),
	(111, 'Peminjaman Aset', '#', 'fas fa-tasks', NULL, 5, NULL, 1, '2025-05-02 05:23:39', '2025-05-02 05:23:39'),
	(112, 'Form Peminjaman', '/aset_form_peminjaman', 'fas fa-circle', NULL, NULL, 111, 1, '2025-05-02 05:24:15', '2025-05-02 05:24:15'),
	(113, 'Approval Peminjaman', '/aset_approval', 'fas fa-circle', NULL, NULL, 111, 1, '2025-05-02 05:26:06', '2025-05-02 05:26:06'),
	(114, 'Pengembalian Aset', '/aset_pengembalian', 'fas fa-circle', NULL, NULL, 111, 1, '2025-05-02 05:27:42', '2025-05-02 05:27:42'),
	(115, 'Laporan', '#', 'fas fa-file-pdf', NULL, 5, NULL, 1, '2025-05-02 05:28:39', '2025-05-02 05:28:39'),
	(116, 'Laporan Aset', '/aset_laporan_aset', 'fas fa-circle', NULL, NULL, NULL, 1, '2025-05-02 05:29:33', '2025-05-02 05:29:33'),
	(117, 'Laporan Perbaikan', '/aset_laporan_perbaikan', 'fas fa-circle', NULL, NULL, 115, 1, '2025-05-02 05:30:09', '2025-05-02 05:30:09'),
	(118, 'Laporan Penyusutan', '/aset_laporan_penyusutan', 'fas fa-circle', NULL, NULL, 115, 1, '2025-05-02 05:30:43', '2025-05-02 05:30:43');

-- Dumping structure for table mmdocs.menu_categories
CREATE TABLE IF NOT EXISTS `menu_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_urut` int NOT NULL DEFAULT '0',
  `status` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.menu_categories: ~5 rows (approximately)
INSERT INTO `menu_categories` (`id`, `name`, `no_urut`, `status`, `created_at`, `updated_at`) VALUES
	(2, 'Dashboard', 1, 1, '2024-12-26 07:30:13', '2024-12-26 07:34:46'),
	(3, 'Manajemen', 2, 1, '2024-12-26 07:30:29', '2024-12-26 07:30:29'),
	(4, 'Document Quality', 3, 1, '2024-12-26 07:30:29', '2024-12-26 07:30:29'),
	(5, 'Asset Manajemen', 4, 1, '2025-05-02 22:59:01', '2025-05-02 22:59:02'),
	(6, 'Sistem', 5, 1, '2024-12-26 07:30:39', '2024-12-26 07:30:39');

-- Dumping structure for table mmdocs.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.migrations: ~38 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_11_04_063708_create_menus_table', 1),
	(6, '2024_11_04_063708_create_roles_table', 1),
	(8, '2014_10_12_100000_create_password_resets_table', 2),
	(9, '2024_11_05_102208_create_master_docs_table', 3),
	(10, '2024_11_05_102252_create_departments_table', 3),
	(13, '2024_11_07_045043_user_permission_table', 3),
	(14, '2024_11_05_102652_create_applications_table', 4),
	(15, '2024_11_08_041829_create_log_activities_table', 5),
	(17, '2024_11_18_042839_create_categories_table', 6),
	(20, '2024_11_15_102409_create_qa_docs_table', 8),
	(22, '2024_11_18_085029_create_distributions_table', 9),
	(24, '2024_11_19_092514_status_table_migration', 10),
	(25, '2024_11_05_102608_create_permissions_table', 11),
	(29, '2024_11_04_063709_create_role_menu_table', 12),
	(31, '2024_11_29_090338_role_default_table', 13),
	(32, '2024_12_27_035226_create_menu_categories_table', 14),
	(33, '2025_01_13_044432_create_risk_management_table', 15),
	(34, '2025_01_31_095806_create_instruksi_kerjas_table', 15),
	(35, '2025_01_31_095848_create_surat_edarans_table', 15),
	(36, '2025_01_31_095908_create_sop_internals_table', 15),
	(37, '2025_01_31_095928_create_document_records_table', 15),
	(38, '2025_01_31_095941_create_external_documents_table', 15),
	(42, '2025_02_25_094414_path_document_table', 16),
	(43, '2025_03_13_101244_path_form_table', 16),
	(44, '2025_03_24_041818_create_quality_documents_table', 17),
	(45, '2025_03_29_185730_create_quality_manuals_table', 17),
	(46, '2025_04_03_074524_create_master_category_docs_table', 17),
	(47, '2025_04_05_173536_path_diagram_table', 17),
	(48, '2025_04_11_011604_docs_kebijakan_mutu', 18),
	(49, '2025_04_11_011656_docs_sasaran_mutu', 18),
	(50, '2025_04_11_011729_docs_organisasi', 18),
	(51, '2025_04_18_162045_create_jabatans_table', 18),
	(52, '2025_06_25_075615_create_folder_table', 19),
	(54, '2025_06_25_075632_create_file_table', 20);

-- Dumping structure for table mmdocs.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.password_resets: ~0 rows (approximately)

-- Dumping structure for table mmdocs.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table mmdocs.path_diagram
CREATE TABLE IF NOT EXISTS `path_diagram` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nodocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_code` (`file_code`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.path_diagram: ~6 rows (approximately)
INSERT INTO `path_diagram` (`id`, `nodocument`, `file_code`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(20, 'QAT-QC-1233', 'DA-QC-001', 'Inv Renolit.pdf', 'QAT-QC-1233-DA-QC-001.pdf', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(21, 'QAT-QC-1233', 'DA-QC-002', 'Inv Vetaphone 6756984574395734985734985649356934856439865493857439573.pdf', 'QAT-QC-1233-DA-QC-002.pdf', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(22, 'NT-OP-7877', 'DA-OP-001', 'Timbermate Water Based Woodfiller SDS 2021.pdf', 'NT-OP-7877-DA-OP-001.pdf', '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(23, 'NT-IT-9580', 'DA-IT-001', 'Timbermate Water Based Woodfiller SDS 2021.pdf', 'NT-IT-9580-DA-IT-001.pdf', '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(24, 'QAT-SM-9988', 'DA-SM-001', 'sdEngl#3035ME#UN.pdf', 'QAT-SM-9988-DA-SM-001.pdf', '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(25, 'QAT-SM-9988', 'DA-SM-002', 'Timbermate Water Based Woodfiller SDS 2021.pdf', 'QAT-SM-9988-DA-SM-002.pdf', '2025-06-16 03:09:25', '2025-06-16 03:09:25');

-- Dumping structure for table mmdocs.path_document
CREATE TABLE IF NOT EXISTS `path_document` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nodocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_code` (`file_code`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.path_document: ~2 rows (approximately)
INSERT INTO `path_document` (`id`, `nodocument`, `file_code`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(83, 'QAT-SM-2514', 'IK-QC-002', 'Corinthian Bogor 070125.pdf', 'QAT-QC-1233-IK-QC-001.pdf', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(86, 'QAT-SM-9988', 'IK-SM-001', 'dbe3030_SIN.pdf', 'QAT-SM-9988-IK-SM-001.pdf', '2025-06-16 03:09:25', '2025-06-16 03:09:25');

-- Dumping structure for table mmdocs.path_form
CREATE TABLE IF NOT EXISTS `path_form` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nodocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_code` (`file_code`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.path_form: ~13 rows (approximately)
INSERT INTO `path_form` (`id`, `nodocument`, `file_code`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(77, 'QAT-QC-1233', 'FM-QC-001', 'Inv Vetaphone 6756984574395734985734985649356934856439865493857439573.pdf', 'QAT-QC-1233-FM-QC-001.pdf', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(78, 'QAT-QC-1233', 'FM-QC-002', 'Corinthian Bogor 070125.pdf', 'QAT-QC-1233-FM-QC-002.pdf', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(79, 'QAT-QC-1233', 'FM-QC-003', 'Draft Astari 22 Jan 2520250121_14053359.pdf', 'QAT-QC-1233-FM-QC-003.pdf', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(80, 'QAT-QC-1233', 'FM-QC-004', 'Inv Renolit.pdf', 'QAT-QC-1233-FM-QC-004.pdf', '2025-06-15 04:28:20', '2025-06-15 04:28:20'),
	(81, 'NT-OP-7877', 'FM-OP-001', 'dbe8715_SIN.pdf', 'NT-OP-7877-FM-OP-001.pdf', '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(82, 'NT-OP-7877', 'FM-OP-002', 'sdEngl#3030#UN.pdf', 'NT-OP-7877-FM-OP-002.pdf', '2025-06-16 01:43:11', '2025-06-16 01:43:11'),
	(83, 'NT-IT-9580', 'FM-IT-001', 'dbe3035ME_SIN.pdf', 'NT-IT-9580-FM-IT-001.pdf', '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(84, 'NT-IT-9580', 'FM-IT-002', 'dbe8715_SIN.pdf', 'NT-IT-9580-FM-IT-002.pdf', '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(85, 'NT-IT-9580', 'FM-IT-003', 'sdEngl#3030#UN.pdf', 'NT-IT-9580-FM-IT-003.pdf', '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(86, 'NT-IT-9580', 'FM-IT-004', 'sdEngl#3035ME#UN.pdf', 'NT-IT-9580-FM-IT-004.pdf', '2025-06-16 01:46:19', '2025-06-16 01:46:19'),
	(87, 'QAT-SM-9988', 'FM-SM-001', 'dbe3035ME_SIN.pdf', 'QAT-SM-9988-FM-SM-001.pdf', '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(88, 'QAT-SM-9988', 'FM-SM-002', 'dbe8715_SIN.pdf', 'QAT-SM-9988-FM-SM-002.pdf', '2025-06-16 03:09:25', '2025-06-16 03:09:25'),
	(89, 'QAT-SM-9988', 'FM-SM-003', 'sdEngl#3030#UN.pdf', 'QAT-SM-9988-FM-SM-003.pdf', '2025-06-16 03:09:25', '2025-06-16 03:09:25');

-- Dumping structure for table mmdocs.path_qualitymanual
CREATE TABLE IF NOT EXISTS `path_qualitymanual` (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_document` varchar(50) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table mmdocs.path_qualitymanual: ~3 rows (approximately)
INSERT INTO `path_qualitymanual` (`id`, `no_document`, `jenis`, `title`, `url`, `created_by`, `created_at`, `updated_at`) VALUES
	(22, 'MM-QA-01', 'Kebijakan', 'Corinthian Bogor 070125.pdf', 'quality_manual/Corinthian Bogor 070125.pdf', 1, '2025-06-28 11:33:59', '2025-06-28 11:33:59'),
	(23, 'MM-QA-01', 'Sasaran', 'Draft Astari 22 Jan 2520250121_14053359.pdf-0.pdf', 'quality_manual/Draft Astari 22 Jan 2520250121_14053359.pdf', 1, '2025-06-28 11:33:59', '2025-06-28 11:33:59'),
	(24, 'MM-QA-01', 'Organisasi', 'Inv Vetaphone 6756984574395734985734985649356934856439865493857439573.pdf-0.pdf', 'quality_manual/Inv Vetaphone 6756984574395734985734985649356934856439865493857439573.pdf', 1, '2025-06-28 11:33:59', '2025-06-28 11:33:59');

-- Dumping structure for table mmdocs.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `resource_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `requested_by` int NOT NULL,
  `approved_by` int DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.permissions: ~10 rows (approximately)
INSERT INTO `permissions` (`id`, `resource_type`, `resource_id`, `requested_by`, `approved_by`, `comments`, `created_at`, `updated_at`) VALUES
	(8, 'document', 'IK-QA-77285', 82, 1, NULL, '2025-03-12 20:30:53', '2025-03-12 20:30:53'),
	(9, 'document', 'SM-GA-77285', 1, 80, NULL, '2025-03-12 20:37:19', '2025-03-12 20:37:19'),
	(10, 'document', 'PM-TS-7210', 1, 80, NULL, '2025-03-12 20:48:15', '2025-03-12 20:48:15'),
	(11, 'document', 'PM-IT-12345', 1, 80, NULL, '2025-03-13 12:27:24', '2025-03-13 12:27:24'),
	(12, 'document', 'QAT-AC-4235', 1, 97, NULL, '2025-05-11 04:55:56', '2025-05-11 04:55:56'),
	(13, 'document', 'QAT-OP-2310', 1, 97, NULL, '2025-05-16 02:54:17', '2025-05-16 02:54:17'),
	(14, 'document', 'QAT-QA-112333', 1, 97, NULL, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(15, 'document', 'MM-QA-01', 1, 97, NULL, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(18, 'document', 'MM-QA-01', 1, 98, NULL, '2025-05-16 03:02:01', '2025-05-16 03:02:01'),
	(19, 'document', 'MM-QA-01', 1, 99, NULL, '2025-05-16 03:02:01', '2025-05-16 03:02:01');

-- Dumping structure for table mmdocs.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table mmdocs.quality_manuals
CREATE TABLE IF NOT EXISTS `quality_manuals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_document` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `revisi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '00',
  `tanggal` date DEFAULT NULL,
  `nama_document` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `perusahaan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_by` bigint DEFAULT '0',
  `checker` bigint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.quality_manuals: ~0 rows (approximately)
INSERT INTO `quality_manuals` (`id`, `no_document`, `revisi`, `tanggal`, `nama_document`, `perusahaan`, `alamat`, `created_by`, `checker`, `created_at`, `updated_at`) VALUES
	(1, 'MM-QA-01', '04', '2025-06-29', 'MANUAL MUTU', 'PT MERINDO MAKMUR', 'Kencna Niaga', 1, 83, '2025-06-28 17:03:37', '2025-06-28 11:33:59');

-- Dumping structure for table mmdocs.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.roles: ~5 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `created`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 1, '2024-11-13 02:37:54', NULL),
	(2, 'Direktur', 1, '2024-11-13 14:19:50', '2024-11-13 14:19:50'),
	(3, 'Manager', 1, '2024-11-13 14:14:05', '2024-11-13 14:19:37'),
	(4, 'User', 1, '2025-04-21 20:11:48', '2025-04-21 20:11:48'),
	(5, 'SuperAdmin', 1, '2025-04-21 20:11:48', '2025-04-21 20:11:48');

-- Dumping structure for table mmdocs.role_default
CREATE TABLE IF NOT EXISTS `role_default` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `menu_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_default_role_id_foreign` (`role_id`),
  KEY `role_default_menu_id_foreign` (`menu_id`),
  CONSTRAINT `role_default_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_default_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.role_default: ~22 rows (approximately)
INSERT INTO `role_default` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, NULL),
	(2, 1, 2, NULL, NULL),
	(3, 1, 3, NULL, NULL),
	(4, 1, 4, NULL, NULL),
	(5, 1, 5, NULL, NULL),
	(8, 1, 10, NULL, NULL),
	(10, 1, 12, NULL, NULL),
	(11, 1, 13, NULL, NULL),
	(31, 2, 1, NULL, NULL),
	(32, 2, 2, NULL, NULL),
	(33, 2, 3, NULL, NULL),
	(34, 2, 4, NULL, NULL),
	(35, 2, 5, NULL, NULL),
	(38, 2, 10, NULL, NULL),
	(40, 2, 12, NULL, NULL),
	(41, 2, 13, NULL, NULL),
	(45, 3, 1, NULL, NULL),
	(46, 3, 10, NULL, NULL),
	(48, 3, 13, NULL, NULL),
	(49, 3, 2, NULL, NULL),
	(50, 3, 3, NULL, NULL),
	(51, 3, 4, NULL, NULL);

-- Dumping structure for table mmdocs.role_menu
CREATE TABLE IF NOT EXISTS `role_menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `menu_id` bigint unsigned NOT NULL,
  `status` bigint NOT NULL DEFAULT '10',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_menu_user_id_foreign` (`user_id`),
  KEY `fk_role_menu_menu_id` (`menu_id`),
  CONSTRAINT `fk_role_menu_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_menu_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=642 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.role_menu: ~95 rows (approximately)
INSERT INTO `role_menu` (`id`, `user_id`, `menu_id`, `status`, `created_at`, `updated_at`) VALUES
	(368, 83, 1, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(369, 83, 2, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(370, 83, 3, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(371, 83, 4, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(372, 83, 5, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(374, 83, 10, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(375, 83, 12, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(376, 83, 13, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(377, 83, 20, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(380, 83, 74, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(381, 83, 76, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(382, 83, 79, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(383, 83, 80, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(384, 83, 91, 10, '2025-04-10 20:27:50', '2025-04-10 20:27:50'),
	(448, 96, 1, 10, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(449, 96, 10, 10, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(450, 96, 12, 10, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(451, 96, 13, 10, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(453, 96, 74, 10, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(454, 96, 76, 10, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(455, 96, 91, 10, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(457, 97, 1, 10, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(458, 97, 10, 10, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(459, 97, 12, 10, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(460, 97, 13, 10, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(461, 97, 74, 10, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(462, 97, 76, 10, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(463, 97, 91, 10, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(499, 1, 1, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(500, 1, 2, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(501, 1, 3, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(502, 1, 4, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(503, 1, 5, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(504, 1, 6, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(505, 1, 10, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(506, 1, 12, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(507, 1, 13, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(508, 1, 20, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(509, 1, 25, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(510, 1, 26, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(511, 1, 74, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(512, 1, 76, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(513, 1, 79, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(514, 1, 80, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(515, 1, 91, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(516, 1, 94, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(518, 1, 97, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(519, 1, 98, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(520, 1, 99, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(521, 1, 103, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(522, 1, 104, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(523, 1, 105, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(524, 1, 106, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(525, 1, 107, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(526, 1, 108, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(527, 1, 109, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(528, 1, 110, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(529, 1, 111, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(530, 1, 112, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(531, 1, 113, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(532, 1, 114, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(533, 1, 115, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(534, 1, 116, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(535, 1, 117, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(536, 1, 118, 10, '2025-05-02 16:26:44', '2025-05-02 16:26:44'),
	(567, 102, 1, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(568, 102, 2, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(569, 102, 20, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(570, 102, 10, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(571, 102, 12, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(572, 102, 13, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(573, 102, 76, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(574, 102, 74, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(575, 102, 91, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(576, 102, 103, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(577, 102, 107, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(578, 102, 111, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(579, 102, 115, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(580, 102, 25, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(581, 102, 94, 10, '2025-06-14 23:39:08', '2025-06-14 23:39:08'),
	(627, 84, 1, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(628, 84, 2, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(629, 84, 20, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(630, 84, 10, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(631, 84, 12, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(632, 84, 13, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(633, 84, 76, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(634, 84, 74, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(635, 84, 91, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(636, 84, 103, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(637, 84, 107, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(638, 84, 111, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(639, 84, 115, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(640, 84, 25, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54'),
	(641, 84, 94, 10, '2025-06-15 00:10:54', '2025-06-15 00:10:54');

-- Dumping structure for table mmdocs.root_folder
CREATE TABLE IF NOT EXISTS `root_folder` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table mmdocs.root_folder: ~12 rows (approximately)
INSERT INTO `root_folder` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
	(8, 'Others', 1, '2025-06-23 04:19:24', '2025-06-23 04:19:25'),
	(9, 'test', NULL, '2025-06-24 03:25:02', '2025-06-24 03:25:02'),
	(10, 'Formulir & Diagram', NULL, '2025-06-24 19:40:56', '2025-06-24 19:40:56'),
	(11, 'Test New', NULL, '2025-06-24 19:43:52', '2025-06-24 19:43:52'),
	(12, 'tessssss', NULL, '2025-06-24 19:45:20', '2025-06-24 19:45:20'),
	(13, 'Formulir & Diagram', NULL, '2025-06-24 19:46:29', '2025-06-24 19:46:29'),
	(14, 'gtgt', NULL, '2025-06-24 19:48:10', '2025-06-24 19:48:10'),
	(15, 'asds', 1, '2025-06-24 19:49:28', '2025-06-24 19:49:28'),
	(16, 'Formulir & Diagram', 1, '2025-06-24 19:53:59', '2025-06-24 19:53:59'),
	(17, 'Formulir & Diagram', 1, '2025-06-24 19:54:54', '2025-06-24 19:54:54'),
	(18, 'Formulir & Diagram', 1, '2025-06-24 20:11:54', '2025-06-24 20:11:54'),
	(19, 'Binder', 1, '2025-06-25 00:00:13', '2025-06-25 00:00:13');

-- Dumping structure for table mmdocs.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.status: ~6 rows (approximately)
INSERT INTO `status` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Waiting', 'Menunggu persetujuan.', '2024-11-19 02:33:36', NULL),
	(2, 'Approved', 'Dokumen telah disetujui.', '2024-11-19 02:33:36', NULL),
	(3, 'Published', 'Dokumen siap digunakan.', '2024-11-19 02:33:36', NULL),
	(4, 'Obsolete', 'Dokumen tidak lagi berlaku.', '2024-11-19 02:33:36', NULL),
	(5, 'Archived', 'Dokumen tidak lagi berlaku.', '2024-11-19 02:33:36', NULL),
	(6, 'Rejected', 'Dokumen tidak disetujui.', '2024-11-19 02:33:36', NULL);

-- Dumping structure for table mmdocs.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int NOT NULL DEFAULT '0',
  `department_id` int NOT NULL DEFAULT '0',
  `avatar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` bigint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mmdocs.users: ~8 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role_id`, `department_id`, `avatar`, `created`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Septian', 'septian@merindo.co.id', '082123230606', NULL, '$2y$12$HbTINn3szbEojQEklWtxuO3LN4gQKzteYqqHj3gZd9rJWMQT5uQqy', 1, 21, 'pria5.svg', 1, NULL, '2024-11-13 07:41:20', '2025-04-18 03:27:03'),
	(83, 'Yuli Sawitri', 'yuli.sawitri@merindo.co.id', '081234567890', NULL, '$2y$12$ZjYpGRYBzaibJjZHeOpZsOE/89YGdw.z9nGtsiqwyvhHQM5.ITKGu', 1, 15, 'cw1.svg', 1, NULL, '2025-04-10 19:30:48', '2025-04-10 19:30:48'),
	(84, 'Gesang Seto Aji', 'gesang@merindo.co.id', '082123345566', NULL, '$2y$12$TEeJj764ZcvLVtpe4s2wReTwY.EqtVBICgJpmcG44DUGjqBlkU.fq', 1, 21, 'pria2.svg', 1, NULL, '2025-04-10 20:13:07', '2025-06-15 00:10:54'),
	(96, 'Wijaya Lim', 'wijaya@merindo.co.id', '082122334455', NULL, '$2y$12$lhbzIEOF7.6UPgTFRIOfj.KH8tzp5T6vj0DMn9kyBLk7pUMzUsln2', 3, 21, 'pria3.svg', 1, NULL, '2025-04-21 20:13:31', '2025-04-21 20:13:31'),
	(97, 'Johhanness Setiono', 'johannes@merindo.co.id', '082122334455', NULL, '$2y$12$xYiy52y6i2/Xa68lpnNk6.OA11WpC96g2G.xRgKmH9XjEZun2pwgK', 2, 18, 'pria1.svg', 1, NULL, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(98, 'Tedy Lim', 'tedy.lim@merindo.co.id', '082122334455', NULL, '$2y$12$xYiy52y6i2/Xa68lpnNk6.OA11WpC96g2G.xRgKmH9XjEZun2pwgK', 2, 18, 'pria2.svg', 1, NULL, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(99, 'Ferianto', 'ferianto@merindo.co.id', '082122334455', NULL, '$2y$12$xYiy52y6i2/Xa68lpnNk6.OA11WpC96g2G.xRgKmH9XjEZun2pwgK', 2, 18, 'pria2.svg', 1, NULL, '2025-04-21 20:30:08', '2025-04-21 20:30:08'),
	(102, 'Super Admin', 'superadmin@merindo.co.id', '082123456789', NULL, '$2y$12$hydJ9nNKoYEwdoenRwsjeeBkdW2OR0/Z7q/G5br6g/AC.wJhxVxkO', 5, 18, 'pria6.svg', 1, NULL, '2025-06-14 23:39:08', '2025-06-14 23:39:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
