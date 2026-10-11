-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for equipment_rental
CREATE DATABASE IF NOT EXISTS `equipment_rental` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `equipment_rental`;

-- Dumping structure for table equipment_rental.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.cache: ~4 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-customer@example.com|127.0.0.1', 'i:3;', 1782357308),
	('laravel-cache-customer@example.com|127.0.0.1:timer', 'i:1782357308;', 1782357308),
	('laravel-cache-sdad1@gmail.com|127.0.0.1', 'i:1;', 1782325816),
	('laravel-cache-sdad1@gmail.com|127.0.0.1:timer', 'i:1782325816;', 1782325816);

-- Dumping structure for table equipment_rental.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.cache_locks: ~0 rows (approximately)

-- Dumping structure for table equipment_rental.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.categories: ~5 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Cameras', 'Photography and video equipment', NULL, NULL),
	(2, 'Power Tools', 'Construction and DIY tools', NULL, NULL),
	(3, 'Power Tools', NULL, NULL, NULL),
	(4, 'Electronics', NULL, NULL, NULL),
	(5, 'Safety Gear', NULL, NULL, NULL);

-- Dumping structure for table equipment_rental.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table equipment_rental.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_category_id_foreign` (`category_id`),
  CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.items: ~3 rows (approximately)
INSERT INTO `items` (`id`, `category_id`, `name`, `stock`, `price_per_day`, `created_at`, `updated_at`) VALUES
	(5, 2, 'impact erench', 11, 101.00, '2026-06-22 22:22:20', '2026-06-25 10:34:41'),
	(6, 1, 'camera', 5, 200.00, '2026-06-23 15:52:46', '2026-06-23 15:52:46'),
	(7, 2, 'hex nut', 5, 10.00, '2026-06-25 01:28:34', '2026-06-25 01:28:34');

-- Dumping structure for table equipment_rental.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.jobs: ~0 rows (approximately)

-- Dumping structure for table equipment_rental.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.job_batches: ~0 rows (approximately)

-- Dumping structure for table equipment_rental.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.migrations: ~9 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_06_21_165613_create_roles_table', 2),
	(5, '2026_06_21_165619_create_categories_table', 2),
	(6, '2026_06_21_165624_create_items_table', 2),
	(7, '2026_06_21_165628_create_rentals_table', 2),
	(8, '2026_06_21_165632_add_role_id_to_users_table', 2),
	(9, '2026_06_23_070529_add_is_admin_to_users_table', 3);

-- Dumping structure for table equipment_rental.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table equipment_rental.rentals
CREATE TABLE IF NOT EXISTS `rentals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rentals_user_id_foreign` (`user_id`),
  CONSTRAINT `rentals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.rentals: ~42 rows (approximately)
INSERT INTO `rentals` (`id`, `user_id`, `start_date`, `end_date`, `total_price`, `status`, `created_at`, `updated_at`, `item_id`) VALUES
	(1, 1, '2026-06-21', '1996-10-09', 2000.00, 'returned', NULL, '2026-06-25 00:52:45', 4),
	(2, 1, '2026-06-21', '2026-06-24', 900.00, 'returned', NULL, '2026-06-22 21:44:59', 4),
	(3, 1, '2026-06-21', '2026-06-24', 900.00, 'returned', NULL, '2026-06-22 21:45:06', 4),
	(4, 1, '2026-06-21', '2026-06-24', 900.00, 'returned', NULL, '2026-06-22 22:22:24', 4),
	(5, 1, '2026-06-21', '2026-06-24', 900.00, 'returned', NULL, '2026-06-23 02:55:15', 4),
	(6, 1, '2026-06-21', '2026-06-24', 900.00, 'pending', NULL, NULL, 4),
	(7, 1, '2026-06-21', '2026-06-24', 900.00, 'pending', NULL, NULL, 4),
	(8, 1, '2026-06-21', '2026-06-24', 900.00, 'pending', NULL, NULL, 4),
	(9, 1, '2026-06-21', '2026-06-24', 900.00, 'pending', NULL, NULL, 4),
	(10, 1, '2026-06-21', '2026-06-24', 900.00, 'pending', NULL, NULL, 4),
	(11, 1, '2026-06-21', '2026-06-24', 900.00, 'pending', NULL, NULL, 4),
	(12, 1, '2026-06-21', '2026-06-24', 900.00, 'pending', NULL, NULL, 4),
	(13, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', NULL, NULL, 4),
	(14, 1, '2026-06-22', '2026-06-25', 300.00, 'returned', '2026-06-22 22:22:30', '2026-06-25 10:24:06', 5),
	(15, 1, '2026-06-22', '2026-06-25', 300.00, 'returned', '2026-06-22 22:22:31', '2026-06-25 10:24:10', 5),
	(16, 1, '2026-06-22', '2026-06-25', 300.00, 'returned', '2026-06-22 22:22:32', '2026-06-25 10:24:11', 5),
	(17, 1, '2026-06-22', '2026-06-25', 300.00, 'returned', '2026-06-22 22:22:32', '2026-06-25 10:24:12', 5),
	(18, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:33', '2026-06-22 22:22:33', 4),
	(19, 1, '2026-06-22', '2026-06-25', 900.00, 'returned', '2026-06-22 22:22:34', '2026-06-23 02:55:12', 4),
	(20, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:34', '2026-06-22 22:22:34', 4),
	(21, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:35', '2026-06-22 22:22:35', 4),
	(22, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:35', '2026-06-22 22:22:35', 4),
	(23, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:35', '2026-06-22 22:22:35', 4),
	(24, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:36', '2026-06-22 22:22:36', 4),
	(25, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:36', '2026-06-22 22:22:36', 4),
	(26, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:37', '2026-06-22 22:22:37', 4),
	(27, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:37', '2026-06-22 22:22:37', 4),
	(28, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:37', '2026-06-22 22:22:37', 4),
	(29, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:37', '2026-06-22 22:22:37', 4),
	(30, 1, '2026-06-22', '2026-06-25', 900.00, 'pending', '2026-06-22 22:22:37', '2026-06-22 22:22:37', 4),
	(31, 1, '2026-06-23', '2026-06-25', 200.00, 'returned', '2026-06-23 15:47:07', '2026-06-25 10:24:12', 5),
	(32, 2, '2026-06-24', '2026-06-27', 300.00, 'returned', '2026-06-25 01:12:19', '2026-06-25 01:20:49', 5),
	(33, 2, '2026-06-24', '2026-06-27', 300.00, 'returned', '2026-06-25 01:29:49', '2026-06-25 01:30:28', 5),
	(34, 2, '2026-06-24', '2026-06-25', 100.00, 'returned', '2026-06-25 05:47:35', '2026-06-25 10:19:03', 5),
	(35, 2, '2026-06-24', '2026-06-25', 100.00, 'returned', '2026-06-25 05:47:41', '2026-06-25 10:19:04', 5),
	(36, 2, '2026-06-24', '2026-06-25', 100.00, 'returned', '2026-06-25 06:04:02', '2026-06-25 10:19:05', 5),
	(37, 2, '2026-06-24', '2026-06-25', 200.00, 'returned', '2026-06-25 06:04:03', '2026-06-25 10:19:06', 6),
	(38, 2, '2026-06-24', '2026-06-25', 200.00, 'returned', '2026-06-25 06:06:35', '2026-06-25 10:19:07', 6),
	(39, 2, '2026-06-25', '2026-06-25', 0.00, 'returned', '2026-06-25 10:16:57', '2026-06-25 10:19:09', 5),
	(40, 2, '2026-06-25', '2026-06-25', 0.00, 'returned', '2026-06-25 10:17:27', '2026-06-25 10:19:11', 5),
	(41, 3, '2026-06-29', '2026-06-25', -400.00, 'returned', '2026-06-25 10:24:25', '2026-06-25 10:24:57', 5),
	(42, 3, '2026-06-29', '2026-06-25', -400.00, 'returned', '2026-06-25 10:25:25', '2026-06-25 10:25:51', 5);

-- Dumping structure for table equipment_rental.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', NULL, NULL),
	(2, 'Staff', NULL, NULL),
	(3, 'Customer', NULL, NULL);

-- Dumping structure for table equipment_rental.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('JTdvw3XVXgjTjZpKM9kv7DdiD2USCMIxvBhipuQK', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJERE9NaTVUNEpnYlpVMVVSakgwZmdoZ0JZVDdRbnBBcDhET3lnMWhRIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2l0ZW1zIiwicm91dGUiOm51bGx9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6M30=', 1782358482);

-- Dumping structure for table equipment_rental.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table equipment_rental.users: ~6 rows (approximately)
INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
	(1, NULL, 'arnold', 'sdad@gmail.com', 1, NULL, '$2y$12$DGme4ySkYGZ2TL7BcGxmu.H/AdPWxc4twmyalSjXwrj1YRHCy80n6', 'DYg4LScISajdj1IeVQlDyzqIarTUwO4fUgNtR0od0WxXdoCMAIHkQPz2cWC6', '2026-06-22 00:39:20', '2026-06-22 00:39:20', 'admin'),
	(2, NULL, 'a', 'ad@gmail.com', 0, NULL, '$2y$12$RkE4mGspmpZrL9TBsv4zLO2kDULj7a9k9Aqk3YDRkMLa1KPfN.d12', NULL, '2026-06-25 01:11:44', '2026-06-25 01:11:44', 'customer'),
	(3, NULL, 'ad', 's@gmail.com', 0, NULL, '$2y$12$k6bK4ZdGxNLkTPtyIv0mjOz9YxirSoJmoXr0Raae5SoI8ArrKe7Ji', NULL, '2026-06-25 01:21:11', '2026-06-25 01:25:40', 'staff'),
	(4, NULL, 'Administrator Account', 'admin@example.com', 1, NULL, '$2y$12$clZ8BszlYshZskx4rSle1eH6o9qVbsh2L02WzYgPymk1M18GZzX0G', NULL, '2026-06-24 19:13:34', NULL, 'admin'),
	(5, NULL, 'Staff Account', 'staff@example.com', 0, NULL, '$2y$12$clZ8BszlYshZskx4rSle1eH6o9qVbsh2L02WzYgPymk1M18GZzX0G', NULL, '2026-06-24 19:13:34', NULL, 'staff'),
	(6, NULL, 'Customer Account', 'customer@example.com', 0, NULL, '$2y$12$clZ8BszlYshZskx4rSle1eH6o9qVbsh2L02WzYgPymk1M18GZzX0G', NULL, '2026-06-24 19:13:34', NULL, 'customer');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
