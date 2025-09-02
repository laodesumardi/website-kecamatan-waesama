-- Database Migration SQL for Kantor Camat Waesama
-- Alternative solution for production deployment
-- Run this SQL file directly on your production database

-- =====================================================
-- KANTOR CAMAT WAESAMA - DATABASE MIGRATION
-- =====================================================

-- Set character set and collation
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- 1. CREATE DATABASE (if not exists)
-- =====================================================

CREATE DATABASE IF NOT EXISTS `kantor_camat_waesama` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `kantor_camat_waesama`;

-- =====================================================
-- 2. USERS TABLE
-- =====================================================

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nik_unique` (`nik`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. ROLES TABLE
-- =====================================================

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `permissions` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. PENDUDUK TABLE
-- =====================================================

DROP TABLE IF EXISTS `penduduk`;
CREATE TABLE `penduduk` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(50) NOT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `status_perkawinan` varchar(50) DEFAULT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(3) DEFAULT NULL,
  `rw` varchar(3) DEFAULT NULL,
  `desa_kelurahan` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kabupaten_kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penduduk_nik_unique` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. SURAT TABLE
-- =====================================================

DROP TABLE IF EXISTS `surat`;
CREATE TABLE `surat` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(255) NOT NULL,
  `jenis_surat` varchar(255) NOT NULL,
  `pemohon_id` bigint(20) UNSIGNED NOT NULL,
  `keperluan` text NOT NULL,
  `status` enum('pending','diproses','selesai','ditolak') NOT NULL DEFAULT 'pending',
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `file_surat` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surat_nomor_surat_unique` (`nomor_surat`),
  KEY `surat_pemohon_id_foreign` (`pemohon_id`),
  KEY `surat_created_by_foreign` (`created_by`),
  KEY `surat_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. ANTRIAN TABLE
-- =====================================================

DROP TABLE IF EXISTS `antrian`;
CREATE TABLE `antrian` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_antrian` varchar(255) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `jenis_layanan` varchar(255) NOT NULL,
  `tanggal_antrian` date NOT NULL,
  `jam_antrian` time NOT NULL,
  `status` enum('menunggu','dipanggil','selesai','batal') NOT NULL DEFAULT 'menunggu',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `antrian_nomor_antrian_unique` (`nomor_antrian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. BERITA TABLE
-- =====================================================

DROP TABLE IF EXISTS `berita`;
CREATE TABLE `berita` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `tanggal_publish` datetime DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_slug_unique` (`slug`),
  KEY `berita_author_id_foreign` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. PENGADUAN TABLE
-- =====================================================

DROP TABLE IF EXISTS `pengaduan`;
CREATE TABLE `pengaduan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_pengaduan` varchar(255) NOT NULL,
  `nama_pengadu` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `judul_pengaduan` varchar(255) NOT NULL,
  `isi_pengaduan` longtext NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `prioritas` enum('rendah','sedang','tinggi','urgent') NOT NULL DEFAULT 'sedang',
  `status` enum('baru','diproses','selesai','ditutup') NOT NULL DEFAULT 'baru',
  `tanggal_pengaduan` date NOT NULL,
  `tanggal_respon` date DEFAULT NULL,
  `respon` longtext DEFAULT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `petugas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengaduan_nomor_pengaduan_unique` (`nomor_pengaduan`),
  KEY `pengaduan_petugas_id_foreign` (`petugas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. NOTIFICATIONS TABLE
-- =====================================================

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` json NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  KEY `notifications_sender_id_foreign` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. BOOKMARKS TABLE
-- =====================================================

DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bookmarkable_type` varchar(255) NOT NULL,
  `bookmarkable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookmarks_user_id_bookmarkable_type_bookmarkable_id_unique` (`user_id`,`bookmarkable_type`,`bookmarkable_id`),
  KEY `bookmarks_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. CACHE TABLES
-- =====================================================

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. JOBS TABLE
-- =====================================================

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 13. ADD FOREIGN KEY CONSTRAINTS
-- =====================================================

ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

ALTER TABLE `surat`
  ADD CONSTRAINT `surat_pemohon_id_foreign` FOREIGN KEY (`pemohon_id`) REFERENCES `penduduk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `surat_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `berita`
  ADD CONSTRAINT `berita_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- =====================================================
-- 14. INSERT SAMPLE DATA
-- =====================================================

-- Insert Roles
INSERT INTO `roles` (`id`, `name`, `description`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator dengan akses penuh', '["all"]', NOW(), NOW()),
(2, 'pegawai', 'Pegawai kantor camat', '["surat", "antrian", "berita"]', NOW(), NOW()),
(3, 'warga', 'Warga yang dapat mengajukan surat', '["surat_request", "pengaduan"]', NOW(), NOW());

-- Insert Admin User
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `nik`, `phone`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@waesama.id', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1234567890123456', '081234567890', 'Kantor Camat Waesama', 1, NOW(), NOW());

-- Insert Sample Pegawai
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `nik`, `phone`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Pegawai Satu', 'pegawai1@waesama.id', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '1234567890123457', '081234567891', 'Waesama', 1, NOW(), NOW());

-- Insert Sample Penduduk
INSERT INTO `penduduk` (`id`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `pendidikan`, `pekerjaan`, `status_perkawinan`, `alamat`, `rt`, `rw`, `desa_kelurahan`, `kecamatan`, `kabupaten_kota`, `provinsi`, `kode_pos`, `created_at`, `updated_at`) VALUES
(1, '1234567890123456', 'Administrator', 'Waesama', '1990-01-01', 'L', 'Islam', 'S1', 'PNS', 'Menikah', 'Kantor Camat Waesama', '001', '001', 'Waesama', 'Waesama', 'Buru', 'Maluku', '97571', NOW(), NOW());

-- Insert Sample Berita
INSERT INTO `berita` (`id`, `judul`, `slug`, `konten`, `excerpt`, `kategori`, `status`, `tanggal_publish`, `views`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'Selamat Datang di Website Kantor Camat Waesama', 'selamat-datang-website-kantor-camat-waesama', '<p>Selamat datang di website resmi Kantor Camat Waesama. Website ini menyediakan berbagai layanan untuk masyarakat.</p>', 'Website resmi Kantor Camat Waesama telah diluncurkan', 'Pengumuman', 'published', NOW(), 0, 1, NOW(), NOW());

-- =====================================================
-- 15. ENABLE FOREIGN KEY CHECKS
-- =====================================================

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- MIGRATION COMPLETED
-- =====================================================

-- Verify tables created
SHOW TABLES;

-- Check user count
SELECT COUNT(*) as total_users FROM users;

-- Check roles
SELECT * FROM roles;

SELECT 'Database migration completed successfully!' as status;