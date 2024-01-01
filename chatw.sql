-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 01, 2024 at 08:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT '',
  `share_level_id` int(11) NOT NULL,
  `karizma_level_id` int(11) NOT NULL,
  `charging_level_id` int(11) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isChargingAgent` int(11) NOT NULL DEFAULT 0,
  `isHostingAgent` int(11) NOT NULL DEFAULT 0,
  `registered_at` date NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `birth_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `enable` int(11) NOT NULL DEFAULT 1,
  `ipAddress` text NOT NULL,
  `macAddress` text NOT NULL,
  `deviceId` text NOT NULL,
  `isOnline` int(11) NOT NULL DEFAULT 0,
  `isInRoom` int(11) NOT NULL DEFAULT 0,
  `country` int(11) NOT NULL,
  `register_with` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`id`, `tag`, `name`, `img`, `share_level_id`, `karizma_level_id`, `charging_level_id`, `phone`, `email`, `password`, `isChargingAgent`, `isHostingAgent`, `registered_at`, `last_login`, `birth_date`, `enable`, `ipAddress`, `macAddress`, `deviceId`, `isOnline`, `isInRoom`, `country`, `register_with`, `created_at`, `updated_at`) VALUES
(1, '120045', 'kareem shaban', '1703704981.jpg', 1, 5, 6, '01014974471', 'shabankareem577@gmail.com', 'Kareem2012@95', 0, 0, '2023-12-29', '2023-12-30 16:37:11', '2013-12-31 08:06:12', 1, '127.0.0.1', 'vdsfvdsfsdfdsf1541ds1fsd', 'ada415415d1asd1as51da', 1, 0, 1, 'PHONE', '2023-12-30 08:06:12', '2023-12-30 13:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `name`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', '1703571896.png', 'ddddd', '2023-12-26 04:24:56', '2023-12-26 04:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `action` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `type`, `name`, `order`, `img`, `action`, `url`, `user_id`, `room_id`, `created_at`, `updated_at`) VALUES
(2, 2, 'landing page 1', 1, '1703617343.jpg', 0, 'https://www.w3schools.com/jsref/event_onchange.asp', 0, 0, '2023-12-26 17:02:23', '2023-12-26 17:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `enable` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `order`, `enable`, `created_at`, `updated_at`) VALUES
(3, 'تأثيرات الدخول', 2, 1, '2023-12-27 06:58:46', '2023-12-27 06:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `talkers_count` int(11) NOT NULL,
  `starred` int(11) NOT NULL,
  `isBlocked` int(11) NOT NULL,
  `blockedDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `blockedUntil` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `isTrend` int(11) NOT NULL,
  `details` text NOT NULL,
  `micCount` int(11) NOT NULL,
  `enableMessages` int(11) NOT NULL,
  `reportCount` int(11) NOT NULL,
  `themeId` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `dial_code` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `enable` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `order`, `dial_code`, `icon`, `enable`, `created_at`, `updated_at`) VALUES
(1, 'egypt', 'eg', 1, '+2', '1703574641.png', 1, '2023-12-26 05:10:41', '2023-12-26 05:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_store` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `gift_category_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `days` int(11) NOT NULL,
  `behaviour` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `motion_icon` varchar(255) NOT NULL,
  `dark_icon` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `vip_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `design_purchases`
--

CREATE TABLE `design_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `design_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isAvailable` int(11) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `available_until` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emossions`
--

CREATE TABLE `emossions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emossions`
--

INSERT INTO `emossions` (`id`, `img`, `created_at`, `updated_at`) VALUES
(1, '1703744872.gif', '2023-12-28 04:27:52', '2023-12-28 04:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `festival_banners`
--

CREATE TABLE `festival_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration_in_hour` decimal(8,2) NOT NULL,
  `enable` int(11) NOT NULL,
  `accepted` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gift_categories`
--

CREATE TABLE `gift_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `enable` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gift_categories`
--

INSERT INTO `gift_categories` (`id`, `name`, `order`, `enable`, `created_at`, `updated_at`) VALUES
(1, 'رومانسي', 1, 1, '2023-12-27 04:28:15', '2023-12-27 04:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `gift_transactions`
--

CREATE TABLE `gift_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `frame_id` varchar(255) NOT NULL,
  `enter_id` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `order`, `points`, `icon`, `frame_id`, `enter_id`, `type`, `created_at`, `updated_at`) VALUES
(1, '1', 500, '1703923809.webp', '0', '0', 0, '2023-12-30 06:10:09', '2023-12-30 06:10:09'),
(5, '1', 500, '1703954196.png', '0', '0', 1, '2023-12-30 14:36:36', '2023-12-30 14:36:36'),
(6, '1', 1000, '1703954208.png', '0', '0', 2, '2023-12-30 14:36:48', '2023-12-30 14:36:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_12_25_192830_create_levels_table', 2),
(7, '2023_12_26_060739_create_badges_table', 3),
(8, '2023_12_26_063818_create_countries_table', 4),
(9, '2023_12_26_072808_create_banners_table', 5),
(11, '2023_12_26_193953_create_vips_table', 6),
(12, '2023_12_26_202816_create_categories_table', 7),
(13, '2023_12_26_202828_create_gift_categories_table', 7),
(14, '2023_12_26_204203_create_designs_table', 8),
(15, '2023_12_27_182659_create_roles_table', 9),
(16, '2023_12_27_194542_create_app_users_table', 10),
(17, '2023_12_27_195438_create_wallets_table', 10),
(18, '2023_12_27_211249_create_themes_table', 11),
(19, '2023_12_27_211301_create_emossions_table', 11),
(20, '2023_12_28_065337_create_special_i_d_s_table', 12),
(21, '2023_12_29_215608_create_design_purchases_table', 13),
(22, '2023_12_30_064141_create_notifications_table', 14),
(23, '2023_12_30_053326_create_gift_transactions_table', 15),
(24, '2023_12_30_053333_create_chat_rooms_table', 16),
(25, '2023_12_30_195120_create_festival_banners_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `user_id` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `img`, `link`, `type`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'dddd', 'dddd', '1703939229.png', 'dddd', 1, '', '2023-12-30 10:27:09', '2023-12-30 10:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Access all pages and routes and all actions', '2023-12-27 17:08:25', '2023-12-27 17:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `special_i_d_s`
--

CREATE TABLE `special_i_d_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `isAvailable` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `special_i_d_s`
--

INSERT INTO `special_i_d_s` (`id`, `uid`, `img`, `price`, `isAvailable`, `created_at`, `updated_at`) VALUES
(1, '88888888', '1703748131.png', 80000.00, 1, '2023-12-28 05:22:11', '2023-12-29 19:50:21');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `isMain` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `img`, `isMain`, `created_at`, `updated_at`) VALUES
(1, 'Theme1', '1703714838.png', 0, '2023-12-27 20:07:18', '2023-12-27 20:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(191) NOT NULL DEFAULT '',
  `role` int(20) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `img`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@chat.com', NULL, '$2y$12$O/09KokZE/IPaY7XH9Us9epCo6o11gG7rPXIREpS8Y5h3B0BJizF2', '1703705275.png', 1, 'NDMFaQf3hIykX3ALiDeX0GnniZpyxBFZyqojxNpRivRkKZ4f7rDdVmxygVi9', '2023-12-25 16:08:40', '2023-12-27 17:29:28'),
(3, 'FFF', '0001@restaurant.com', NULL, '$2y$12$gl6.e5WImaJ9A1PvGddnROSDM4E3kpFg4NVymrehLmIirMi10WTna', '1703938142.png', 1, NULL, '2023-12-30 10:09:03', '2023-12-30 10:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `vips`
--

CREATE TABLE `vips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `motion_icon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vips`
--

INSERT INTO `vips` (`id`, `name`, `tag`, `price`, `icon`, `motion_icon`, `created_at`, `updated_at`) VALUES
(1, 'البارون', 'VIP1', 1000.00, '1703622039.png', '1703712938motion.png', NULL, '2023-12-27 19:35:38'),
(2, 'الوزير', 'VIP2', 2000.00, '1703622052.png', '', NULL, '2023-12-26 18:20:52'),
(3, 'البرنس', 'VIP3', 3000.00, '1703622067.png', '', NULL, '2023-12-26 18:21:07'),
(4, 'القائد', 'VIP4', 4000.00, '1703622083.png', '', NULL, '2023-12-26 18:21:23'),
(5, 'الملك', 'VIP5', 5000.00, '1703622094.png', '', NULL, '2023-12-26 18:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `gold` decimal(8,2) NOT NULL,
  `diamond` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `gold`, `diamond`, `created_at`, `updated_at`) VALUES
(1, 1, 200.00, 110.00, NULL, '2023-12-30 08:36:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_users_tag_unique` (`tag`),
  ADD UNIQUE KEY `app_users_phone_unique` (`phone`),
  ADD UNIQUE KEY `app_users_email_unique` (`email`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `design_purchases`
--
ALTER TABLE `design_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emossions`
--
ALTER TABLE `emossions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `festival_banners`
--
ALTER TABLE `festival_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_categories`
--
ALTER TABLE `gift_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_transactions`
--
ALTER TABLE `gift_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_i_d_s`
--
ALTER TABLE `special_i_d_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vips`
--
ALTER TABLE `vips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `design_purchases`
--
ALTER TABLE `design_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emossions`
--
ALTER TABLE `emossions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `festival_banners`
--
ALTER TABLE `festival_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_categories`
--
ALTER TABLE `gift_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gift_transactions`
--
ALTER TABLE `gift_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `special_i_d_s`
--
ALTER TABLE `special_i_d_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vips`
--
ALTER TABLE `vips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
