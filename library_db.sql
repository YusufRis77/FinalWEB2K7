-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 05:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publication_year` year(4) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `total_copies` int(11) NOT NULL DEFAULT 0,
  `available_copies` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `publisher`, `publication_year`, `category`, `cover_image`, `total_copies`, `available_copies`, `created_at`, `updated_at`) VALUES
(1, 'Dilan 1990', 'Susanto', '9786027870410', 'Gramedia Pustaka', '2014', 'Remaja / Romantis', 'covers/HrwaYA8grxI8O5hPucbQYX8i6jyNoPPu3CwTTfTR.png', 5, 4, '2025-07-06 03:53:56', '2025-07-06 07:19:37'),
(2, 'Laskar Pelangi', 'Andrea Hirata', '9789791227201', 'Bentang Pustaka', '2005', 'Drama / Inspiratif', 'covers/1bf3Sp2My1AUhoN8wlLlZF6KR527rKr92rsokXPK.png', 4, 4, '2025-07-06 07:08:57', '2025-07-06 21:49:06'),
(3, 'Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', '9789793608053', 'Republika', '2004', 'Religi / Romantis', 'covers/w91wmpKk3i9lYFd6h9FgvjYoqwkBTHkC5Du6uR0c.png', 6, 6, '2025-07-06 07:11:31', '2025-07-06 21:51:12'),
(4, 'Bumi', 'Tere Liye', '9786020300228', 'Gramedia Pustaka', '2014', 'Fantasi / Petualangan', 'covers/HzLqwkp1MIr68K5QUSWvs3ZsMNd7RuU1MSA10od4.png', 7, 7, '2025-07-06 07:13:20', '2025-07-06 21:52:37'),
(5, 'Perahu Kertas', 'Dee Lestari', '9786028811047', 'Bentang Pustaka', '2009', 'Fiksi / Romantis', 'covers/K4mqe7roC2Jv1zMA5FUVOGni4av9nL4nuUmDhbtM.png', 5, 5, '2025-07-06 07:14:55', '2025-07-06 21:53:37'),
(6, 'Negeri 5 Menara', 'Ahmad Fuadi', '9789791227591', 'Gramedia Pustaka', '2009', 'Pendidikan / Motivasi', 'covers/QfDKaCI7R6eDMGa1lXG9eFN5uaSuauoq2gxifca7.png', 7, 7, '2025-07-06 07:16:01', '2025-07-06 21:54:37'),
(7, 'Aroma Karsa', 'Dee Lestari', '9786022914706', 'Bentang Pustaka', '2018', 'Misteri / Fantasi', 'covers/KzZtHmjUDm4iE0Qa8AvK0jYatSuvzC7dfuAmf1WG.png', 3, 3, '2025-07-06 07:16:46', '2025-07-06 21:56:55'),
(8, '5 cm', 'Donny Dhirgantoro', '9789790258664', 'Grasindo', '2005', 'Persahabatan / Petualangan', 'covers/XYpCaeolWl9RaJg2kf6MmmDeOQYzwhAahUGJ8inS.png', 2, 2, '2025-07-06 07:17:27', '2025-07-06 21:58:36'),
(9, 'Sang Pemimpi', 'Andrea Hirata', '9789791227218', 'Bentang Pustaka', '2006', 'Drama / Inspiratif', 'covers/Lr1gsmpQRzgn9SjwEyocFYvxcBtkgvmRM4WzR4SZ.png', 4, 4, '2025-07-06 07:25:13', '2025-07-06 22:02:31'),
(10, 'Hujan', 'Tere Liye', '9786020332953', 'Gramedia Pustaka', '2016', 'Fiksi / Romantis', 'covers/39zR7u1y2Zuin3ijz2ERuMNfdd7NbqWY7ESnaQqA.png', 5, 5, '2025-07-06 07:26:56', '2025-07-06 22:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'borrowed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-07-06', '2025-07-13', NULL, 'borrowed', '2025-07-06 03:59:48', '2025-07-06 03:59:48');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `returned_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_06_052124_create_books_table', 1),
(5, '2025_07_06_052133_create_loans_table', 1),
(6, '2025_07_06_052140_add_roles_and_details_to_users_table', 1),
(7, '2025_07_06_065746_add_cover_image_to_books_table', 1),
(8, '2025_07_06_075813_create_borrowings_table', 1);

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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GqKrmej5huSHftJ7NFkw6w1jXEPWnvpc0cLI5YYb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGU4ZXhobzA3d21nY1VKa253bGNKWHlSUk9CNXdzblBoMHVNeG1TMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rcyI7fX0=', 1751900940),
('n092z55VP3w89aNbd1Jn0TgrJhnNvQImBpOYryvh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakhyMzVrRjZTNWFBcm9qYXRhSlRpdGxadUtLaEVqdGd3TzNxZmxtRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rcyI7fX0=', 1751815633),
('yhb7kJb4ALlzG6LVe7FQu9oY4JtEdnQa4R7Vi3NV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2ltNWdES3FEbnhOZkg1WjhEanUzWEVVcUVZQjNHbTRhczN3c3ZMRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rcyI7fX0=', 1751868274);

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
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `phone_number` varchar(255) DEFAULT NULL,
  `member_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone_number`, `member_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Warda Khairah', 'khairahwarda@gmail.com', NULL, '$2y$12$GJROPhLsA2hqEbbWhARGPO7YIe.Iga45mK1kobv0kyGbaH.ZVHKCy', 'admin', '082156798989', NULL, NULL, '2025-07-06 02:27:44', '2025-07-06 02:27:44'),
(2, 'warda', 'giandaniel141@gmail.com', NULL, '$2y$12$8GhHjmlANJjs2ZKEW.zKGucW2iF2z5NdzL1Ypd0nilJbxf7tLmQbe', 'member', '089531053163', NULL, NULL, '2025-07-06 03:49:41', '2025-07-06 03:49:41'),
(3, 'oneoftaa', 'kallykykallyky@gmail.com', NULL, '$2y$12$0tyg.PPmoGQdauxaGuHF..SAxArhlfxNOhji5IzgVv5cr9UWE0b/i', 'member', NULL, NULL, NULL, '2025-07-06 03:57:26', '2025-07-06 03:57:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_isbn_unique` (`isbn`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowings_user_id_foreign` (`user_id`),
  ADD KEY `borrowings_book_id_foreign` (`book_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_user_id_foreign` (`user_id`),
  ADD KEY `loans_book_id_foreign` (`book_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_member_id_unique` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
