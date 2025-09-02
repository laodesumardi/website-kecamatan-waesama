-- =====================================================
-- COMPLETE DATABASE MIGRATION FOR KANTOR CAMAT WAESAMA
-- =====================================================
-- This SQL file creates all necessary tables and data
-- for the Kantor Camat Waesama application
-- =====================================================

-- Set character set and collation
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- 1. USERS TABLE
-- =====================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default users
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@waesama.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '081234567890', 'Kantor Camat Waesama', 1, NOW(), NOW()),
(2, 'Staff Pelayanan', 'staff@waesama.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', '081234567891', 'Kantor Camat Waesama', 1, NOW(), NOW()),
(3, 'User Demo', 'user@waesama.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '081234567892', 'Desa Waesama', 1, NOW(), NOW());

-- =====================================================
-- 2. RESIDENTS TABLE (Data Penduduk)
-- =====================================================
DROP TABLE IF EXISTS `residents`;
CREATE TABLE `residents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` enum('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati') COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rt` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Waesama',
  `regency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Buru',
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Maluku',
  `postal_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `residents_nik_unique` (`nik`),
  KEY `residents_name_index` (`name`),
  KEY `residents_village_index` (`village`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample residents
INSERT INTO `residents` (`nik`, `name`, `birth_place`, `birth_date`, `gender`, `religion`, `education`, `occupation`, `marital_status`, `address`, `rt`, `rw`, `village`, `phone`, `father_name`, `mother_name`, `created_at`, `updated_at`) VALUES
('8171010101900001', 'Ahmad Suharto', 'Waesama', '1990-01-01', 'L', 'Islam', 'SMA', 'Petani', 'Kawin', 'Jl. Merdeka No. 1', '001', '001', 'Waesama', '081234567893', 'Budi Suharto', 'Siti Aminah', NOW(), NOW()),
('8171010101900002', 'Siti Nurhaliza', 'Waesama', '1992-05-15', 'P', 'Islam', 'SMA', 'Ibu Rumah Tangga', 'Kawin', 'Jl. Merdeka No. 1', '001', '001', 'Waesama', '081234567894', 'Ali Rahman', 'Fatimah', NOW(), NOW()),
('8171010101900003', 'Budi Santoso', 'Namlea', '1985-12-20', 'L', 'Kristen', 'S1', 'PNS', 'Kawin', 'Jl. Pemuda No. 5', '002', '001', 'Waesama', '081234567895', 'Santoso', 'Maria', NOW(), NOW());

-- =====================================================
-- 3. LETTERS TABLE (Surat-surat)
-- =====================================================
DROP TABLE IF EXISTS `letters`;
CREATE TABLE `letters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `letter_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_address` text COLLATE utf8mb4_unicode_ci,
  `purpose` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `processed_by` bigint(20) unsigned DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `letters_letter_number_unique` (`letter_number`),
  KEY `letters_letter_type_index` (`letter_type`),
  KEY `letters_status_index` (`status`),
  KEY `letters_processed_by_foreign` (`processed_by`),
  KEY `letters_created_by_foreign` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample letters
INSERT INTO `letters` (`letter_number`, `letter_type`, `title`, `content`, `applicant_name`, `applicant_nik`, `applicant_phone`, `applicant_address`, `purpose`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
('001/SKD/2024', 'Surat Keterangan Domisili', 'Surat Keterangan Domisili Ahmad Suharto', 'Surat keterangan domisili untuk Ahmad Suharto', 'Ahmad Suharto', '8171010101900001', '081234567893', 'Jl. Merdeka No. 1, Waesama', 'Keperluan administrasi bank', 'completed', 1, NOW(), NOW()),
('002/SKU/2024', 'Surat Keterangan Usaha', 'Surat Keterangan Usaha Budi Santoso', 'Surat keterangan usaha untuk Budi Santoso', 'Budi Santoso', '8171010101900003', '081234567895', 'Jl. Pemuda No. 5, Waesama', 'Pengajuan kredit usaha', 'pending', 1, NOW(), NOW());

-- =====================================================
-- 4. QUEUES TABLE (Antrian)
-- =====================================================
DROP TABLE IF EXISTS `queues`;
CREATE TABLE `queues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visitor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visitor_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci,
  `status` enum('waiting','serving','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `served_by` bigint(20) unsigned DEFAULT NULL,
  `served_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `queues_queue_number_unique` (`queue_number`),
  KEY `queues_service_type_index` (`service_type`),
  KEY `queues_status_index` (`status`),
  KEY `queues_served_by_foreign` (`served_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample queues
INSERT INTO `queues` (`queue_number`, `service_type`, `visitor_name`, `visitor_phone`, `purpose`, `status`, `created_at`, `updated_at`) VALUES
('A001', 'Surat Keterangan', 'Ahmad Suharto', '081234567893', 'Membuat surat keterangan domisili', 'completed', NOW(), NOW()),
('A002', 'Surat Pengantar', 'Siti Nurhaliza', '081234567894', 'Surat pengantar nikah', 'waiting', NOW(), NOW());

-- =====================================================
-- 5. NEWS TABLE (Berita)
-- =====================================================
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `author_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`),
  KEY `news_category_index` (`category`),
  KEY `news_is_published_index` (`is_published`),
  KEY `news_is_featured_index` (`is_featured`),
  KEY `news_author_id_foreign` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample news
INSERT INTO `news` (`title`, `slug`, `excerpt`, `content`, `category`, `is_published`, `is_featured`, `published_at`, `author_id`, `created_at`, `updated_at`) VALUES
('Pelayanan Digital Kecamatan Waesama Resmi Diluncurkan', 'pelayanan-digital-kecamatan-waesama-resmi-diluncurkan', 'Kecamatan Waesama meluncurkan sistem pelayanan digital untuk memudahkan masyarakat dalam mengurus berbagai keperluan administrasi.', 'Kecamatan Waesama dengan bangga mengumumkan peluncuran sistem pelayanan digital yang akan memudahkan masyarakat dalam mengurus berbagai keperluan administrasi. Sistem ini memungkinkan warga untuk mengajukan permohonan surat-surat secara online, melihat status antrian, dan mendapatkan informasi terkini tentang pelayanan kecamatan.', 'Pelayanan', 1, 1, NOW(), 1, NOW(), NOW()),
('Program Pemberdayaan Masyarakat Desa Tahun 2024', 'program-pemberdayaan-masyarakat-desa-tahun-2024', 'Kecamatan Waesama meluncurkan program pemberdayaan masyarakat desa untuk meningkatkan kesejahteraan warga.', 'Program pemberdayaan masyarakat desa tahun 2024 telah resmi diluncurkan dengan fokus pada peningkatan ekonomi kreatif, pertanian berkelanjutan, dan pengembangan UMKM. Program ini diharapkan dapat meningkatkan kesejahteraan masyarakat Waesama.', 'Program', 1, 0, NOW(), 1, NOW(), NOW());

-- =====================================================
-- 6. COMPLAINTS TABLE (Pengaduan)
-- =====================================================
DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `complaint_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complainant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complainant_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complainant_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complainant_address` text COLLATE utf8mb4_unicode_ci,
  `evidence_files` json DEFAULT NULL,
  `status` enum('submitted','reviewed','in_progress','resolved','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `response` longtext COLLATE utf8mb4_unicode_ci,
  `handled_by` bigint(20) unsigned DEFAULT NULL,
  `handled_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `complaints_complaint_number_unique` (`complaint_number`),
  KEY `complaints_category_index` (`category`),
  KEY `complaints_status_index` (`status`),
  KEY `complaints_priority_index` (`priority`),
  KEY `complaints_handled_by_foreign` (`handled_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample complaints
INSERT INTO `complaints` (`complaint_number`, `title`, `description`, `category`, `complainant_name`, `complainant_email`, `complainant_phone`, `complainant_address`, `status`, `priority`, `created_at`, `updated_at`) VALUES
('ADU001/2024', 'Jalan Rusak di Desa Waesama', 'Jalan utama di Desa Waesama mengalami kerusakan parah yang mengganggu aktivitas warga', 'Infrastruktur', 'Ahmad Suharto', 'ahmad@email.com', '081234567893', 'Jl. Merdeka No. 1, Waesama', 'submitted', 'high', NOW(), NOW()),
('ADU002/2024', 'Pelayanan Lambat di Kantor Camat', 'Pelayanan di kantor camat terlalu lambat, antrian sangat panjang', 'Pelayanan', 'Budi Santoso', 'budi@email.com', '081234567895', 'Jl. Pemuda No. 5, Waesama', 'reviewed', 'medium', NOW(), NOW());

-- =====================================================
-- 7. NOTIFICATIONS TABLE
-- =====================================================
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` json NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. CACHE TABLE
-- =====================================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. JOBS TABLE
-- =====================================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(10) unsigned DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `finished_at` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. SESSIONS TABLE
-- =====================================================
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. PASSWORD RESET TOKENS TABLE
-- =====================================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. PERSONAL ACCESS TOKENS TABLE
-- =====================================================
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- FOREIGN KEY CONSTRAINTS
-- =====================================================
ALTER TABLE `letters`
  ADD CONSTRAINT `letters_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `letters_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `queues`
  ADD CONSTRAINT `queues_served_by_foreign` FOREIGN KEY (`served_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `news`
  ADD CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_handled_by_foreign` FOREIGN KEY (`handled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- =====================================================
-- ENABLE FOREIGN KEY CHECKS
-- =====================================================
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- COMPLETION MESSAGE
-- =====================================================
-- Database migration completed successfully!
-- Default login credentials:
-- Email: admin@waesama.id
-- Password: password
-- 
-- Email: staff@waesama.id  
-- Password: password
-- 
-- Email: user@waesama.id
-- Password: password
-- =====================================================