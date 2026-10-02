-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2026 at 12:11 PM
-- Server version: 9.6.0
-- PHP Version: 8.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `01_module_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `block_field_values`
--

CREATE TABLE `block_field_values` (
  `id` bigint UNSIGNED NOT NULL,
  `itinerary_block_id` bigint UNSIGNED NOT NULL,
  `template_field_id` bigint UNSIGNED NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `block_field_values`
--

INSERT INTO `block_field_values` (`id`, `itinerary_block_id`, `template_field_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kyoto & Tokyo, Japan', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(2, 1, 2, 'April 10 - April 17, 2026', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(3, 1, 3, 'http://localhost:8000/api/images/japan/cover_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(4, 2, 4, 'Day 1: Arrival & Temple Exploration', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(5, 2, 5, 'Arrive at Tokyo and check local historic temples.', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(6, 2, 6, 'http://localhost:8000/api/images/japan/day_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(7, 3, 7, 'Top Activities of the Day', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(8, 3, 8, 'Shibuya Crossing Walk', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(9, 3, 9, 'http://localhost:8000/api/images/japan/activity_1_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(10, 3, 10, 'Traditional Ramen Tasting', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(11, 3, 11, 'http://localhost:8000/api/images/japan/activity_2_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(12, 4, 12, 'Grand Hyatt Tokyo', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(13, 4, 13, '6-10-3 Roppongi, Minato City, Tokyo', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(14, 4, 14, '15:00 PM', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(15, 4, 15, 'http://localhost:8000/api/images/japan/hotel_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(16, 5, 16, 'Shinkansen Bullet Train', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(17, 5, 17, '08:30 AM', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(18, 5, 18, 'http://localhost:8000/api/images/japan/route_map.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(19, 6, 19, '150000', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(20, 6, 20, 'http://localhost:8000/api/images/japan/chart_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(21, 6, 21, 'Includes all bullet train passes and resort bookings.', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(22, 6, 22, 'JPY', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(23, 7, 1, 'Bali, Indonesia', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(24, 7, 2, 'July 15 - July 22, 2026', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(25, 7, 3, 'http://localhost:8000/api/images/bali/cover_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(26, 8, 4, 'Day 1: Arrival & Ubud Exploration', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(27, 8, 5, 'Arrive in Bali and head to Ubud to explore rice terraces and ancient temples.', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(28, 8, 6, 'http://localhost:8000/api/images/bali/day_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(29, 9, 7, 'Best Activities in Bali', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(30, 9, 8, 'Tanah Lot Temple Visit', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(31, 9, 9, 'http://localhost:8000/api/images/bali/activity_1_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(32, 9, 10, 'Tegalalang Rice Terrace Trek', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(33, 9, 11, 'http://localhost:8000/api/images/bali/activity_2_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(34, 10, 12, 'The Mulia Bali', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(35, 10, 13, 'Jl. Raya Nusa Dua Selatan, Sawangan, Nusa Dua, Bali', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(36, 10, 14, '14:00 PM', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(37, 10, 15, 'http://localhost:8000/api/images/bali/hotel_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(38, 11, 16, 'Private Shuttle Bus', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(39, 11, 17, '10:00 AM', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(40, 11, 18, 'http://localhost:8000/api/images/bali/route_map.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(41, 12, 19, '12000000', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(42, 12, 20, 'http://localhost:8000/api/images/bali/chart_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(43, 12, 21, 'Includes all villa bookings and guided tours.', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(44, 12, 22, 'IDR', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(45, 13, 1, 'Paris, France', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(46, 13, 2, 'December 20 - December 27, 2026', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(47, 13, 3, 'http://localhost:8000/api/images/paris/cover_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(48, 14, 4, 'Day 1: Arrival & Eiffel Tower', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(49, 14, 5, 'Arrive in Paris and enjoy the iconic Eiffel Tower at night.', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(50, 14, 6, 'http://localhost:8000/api/images/paris/day_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(51, 15, 7, 'Top Paris Activities', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(52, 15, 8, 'Louvre Museum Tour', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(53, 15, 9, 'http://localhost:8000/api/images/paris/activity_1_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(54, 15, 10, 'Seine River Cruise', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(55, 15, 11, 'http://localhost:8000/api/images/paris/activity_2_photo.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(56, 16, 12, 'Le Meurice', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(57, 16, 13, '228 Rue de Rivoli, 75001 Paris, France', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(58, 16, 14, '15:00 PM', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(59, 16, 15, 'http://localhost:8000/api/images/paris/hotel_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(60, 17, 16, 'Eurostar Train', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(61, 17, 17, '09:00 AM', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(62, 17, 18, 'http://localhost:8000/api/images/paris/route_map.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(63, 18, 19, '5000', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(64, 18, 20, 'http://localhost:8000/api/images/paris/chart_image.jpeg', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(65, 18, 21, 'Includes museum passes and guided city tour.', '2026-04-08 01:45:30', '2026-04-08 01:45:30'),
(66, 18, 22, 'EUR', '2026-04-08 01:45:30', '2026-04-08 01:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itineraries`
--

CREATE TABLE `itineraries` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `itineraries`
--

INSERT INTO `itineraries` (`id`, `title`, `summary`, `slug`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Japan Summer Trip', 'A beautiful summer journey through Tokyo and Kyoto.', 'japan-summer-trip', 1, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(2, 'Bali Summer Escape', 'A relaxing summer retreat through Ubud and Nusa Dua.', 'bali-summer-escape', 2, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(3, 'Paris Winter Getaway', 'A romantic winter trip to the City of Light.', 'paris-winter-getaway', 3, '2026-04-08 01:45:28', '2026-04-08 01:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `itinerary_blocks`
--

CREATE TABLE `itinerary_blocks` (
  `id` bigint UNSIGNED NOT NULL,
  `itinerary_id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `position` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `itinerary_blocks`
--

INSERT INTO `itinerary_blocks` (`id`, `itinerary_id`, `template_id`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(2, 1, 2, 2, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(3, 1, 3, 3, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(4, 1, 4, 4, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(5, 1, 5, 5, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(6, 1, 6, 6, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(7, 2, 1, 1, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(8, 2, 2, 2, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(9, 2, 3, 3, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(10, 2, 4, 4, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(11, 2, 5, 5, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(12, 2, 6, 6, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(13, 3, 1, 1, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(14, 3, 2, 2, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(15, 3, 3, 3, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(16, 3, 4, 4, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(17, 3, 5, 5, '2026-04-08 01:45:29', '2026-04-08 01:45:29'),
(18, 3, 6, 6, '2026-04-08 01:45:29', '2026-04-08 01:45:29');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_08_000001_create_itineraries_table', 1),
(5, '2026_04_08_000002_create_templates_table', 1),
(6, '2026_04_08_000003_create_template_fields_table', 1),
(7, '2026_04_08_000004_create_itinerary_blocks_table', 1),
(8, '2026_04_08_000005_create_block_field_values_table', 1),
(9, '2026_06_04_032703_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Trip Overview Block', 'overview', '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(2, 'Day Plan Block', 'day-plan', '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(3, 'Activity List Block', 'activities', '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(4, 'Accommodation Block', 'accommodation', '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(5, 'Transport Block', 'transport', '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(6, 'Budget Summary Block', 'budget', '2026-04-08 01:45:28', '2026-04-08 01:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `template_fields`
--

CREATE TABLE `template_fields` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','text') COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `template_fields`
--

INSERT INTO `template_fields` (`id`, `name`, `type`, `template_id`, `created_at`, `updated_at`) VALUES
(1, 'destination', 'text', 1, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(2, 'trip_dates', 'text', 1, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(3, 'cover_image', 'image', 1, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(4, 'day_title', 'text', 2, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(5, 'day_description', 'text', 2, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(6, 'day_photo', 'image', 2, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(7, 'title', 'text', 3, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(8, 'activity_1_name', 'text', 3, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(9, 'activity_1_photo', 'image', 3, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(10, 'activity_2_name', 'text', 3, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(11, 'activity_2_photo', 'image', 3, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(12, 'hotel_name', 'text', 4, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(13, 'address', 'text', 4, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(14, 'check_in', 'text', 4, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(15, 'hotel_image', 'image', 4, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(16, 'mode', 'text', 5, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(17, 'departure_time', 'text', 5, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(18, 'route_map', 'image', 5, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(19, 'total_cost', 'text', 6, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(20, 'chart_image', 'image', 6, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(21, 'notes', 'text', 6, '2026-04-08 01:45:28', '2026-04-08 01:45:28'),
(22, 'currency', 'text', 6, '2026-04-08 01:45:28', '2026-04-08 01:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john.doe@gmail.com', '$2y$12$G/K5dUxGe6D6dEVXC.Wx2OYTKfnCIZDEgkBfMFJnVGhVUP/wHQqPu', '2026-04-08 01:45:27', '2026-04-08 01:45:27'),
(2, 'Richard Roe', 'richard.roe@gmail.com', '$2y$12$MrjeaqVsf8MQNU2LSsYXceVUAEjqtIp6XGwVA4htEsOBCdpqvAdGm', '2026-04-08 01:45:27', '2026-04-08 01:45:27'),
(3, 'Jane Poe', 'jane.poe@gmail.com', '$2y$12$TA3Ke0LkipiTlRWEYOD/Cebn0s7kTiamXzbbyLhCsLuMxjy7wXNG6', '2026-04-08 01:45:28', '2026-04-08 01:45:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block_field_values`
--
ALTER TABLE `block_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_field_values_itinerary_block_id_foreign` (`itinerary_block_id`),
  ADD KEY `block_field_values_template_field_id_foreign` (`template_field_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `itineraries`
--
ALTER TABLE `itineraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itineraries_user_id_foreign` (`user_id`);

--
-- Indexes for table `itinerary_blocks`
--
ALTER TABLE `itinerary_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itinerary_blocks_itinerary_id_foreign` (`itinerary_id`),
  ADD KEY `itinerary_blocks_template_id_foreign` (`template_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_fields`
--
ALTER TABLE `template_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_fields_template_id_foreign` (`template_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block_field_values`
--
ALTER TABLE `block_field_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itineraries`
--
ALTER TABLE `itineraries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `itinerary_blocks`
--
ALTER TABLE `itinerary_blocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `template_fields`
--
ALTER TABLE `template_fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `block_field_values`
--
ALTER TABLE `block_field_values`
  ADD CONSTRAINT `block_field_values_itinerary_block_id_foreign` FOREIGN KEY (`itinerary_block_id`) REFERENCES `itinerary_blocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `block_field_values_template_field_id_foreign` FOREIGN KEY (`template_field_id`) REFERENCES `template_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `itineraries`
--
ALTER TABLE `itineraries`
  ADD CONSTRAINT `itineraries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `itinerary_blocks`
--
ALTER TABLE `itinerary_blocks`
  ADD CONSTRAINT `itinerary_blocks_itinerary_id_foreign` FOREIGN KEY (`itinerary_id`) REFERENCES `itineraries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itinerary_blocks_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template_fields`
--
ALTER TABLE `template_fields`
  ADD CONSTRAINT `template_fields_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
