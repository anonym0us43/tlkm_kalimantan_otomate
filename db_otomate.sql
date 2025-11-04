-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.4.3 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.13.0.7147
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk db_otomate
CREATE DATABASE IF NOT EXISTS `db_otomate` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_otomate`;

-- membuang struktur untuk table db_otomate.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_otomate.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_otomate.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_otomate.job_batches
DROP TABLE IF EXISTS `job_batches`;
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

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_otomate.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_otomate.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_otomate.tb_source_mitratel
DROP TABLE IF EXISTS `tb_source_mitratel`;
CREATE TABLE IF NOT EXISTS `tb_source_mitratel` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `no_spmk` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_po` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workorder` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ring_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regional` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `witel` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_ne` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_site_ne` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_name_ne` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_owner_ne` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_type_ne` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_lat_ne` decimal(10,6) DEFAULT NULL,
  `site_long_ne` decimal(10,6) DEFAULT NULL,
  `site_fe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_site_fe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_name_fe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_owner_fe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_type_fe` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_lat_fe` decimal(10,6) DEFAULT NULL,
  `site_long_fe` decimal(10,6) DEFAULT NULL,
  `priority` enum('low','medium','high') COLLATE utf8mb4_unicode_ci DEFAULT 'low',
  `wo_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_day` int DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `rfs_type` tinyint DEFAULT '0',
  `panjang_kabel_bast` int DEFAULT '0',
  `kabel_eks` int DEFAULT '0',
  `plan_kabel` int DEFAULT '0',
  `plan_kabel_new` int DEFAULT '0',
  `real_kabel` int DEFAULT '0',
  `plan_tiang` int DEFAULT '0',
  `plan_tiang_ex` int DEFAULT '0',
  `plan_tiang_new` int DEFAULT '0',
  `real_tiang_new` int DEFAULT '0',
  `real_tiang` int DEFAULT '0',
  `rfs_plan` date DEFAULT NULL,
  `rfs_real` date DEFAULT NULL,
  `status_drm` date DEFAULT NULL,
  `anwizing` date DEFAULT NULL,
  `perijinan` date DEFAULT NULL,
  `testcomm` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uji_terima` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terminasi_odc_fe` date DEFAULT NULL,
  `terminasi_otb_fe` date DEFAULT NULL,
  `terminasi_odc_ne` date DEFAULT NULL,
  `terminasi_otb_ne` date DEFAULT NULL,
  `bast` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_ach_delivery` decimal(8,3) DEFAULT '0.000',
  `total_ach_progress` decimal(8,3) DEFAULT '0.000',
  `last_update` datetime DEFAULT CURRENT_TIMESTAMP,
  `overall` decimal(5,2) DEFAULT '0.00',
  `kendala_count` int DEFAULT '0',
  `evidence_count` int DEFAULT '0',
  `ach_kabel` decimal(5,2) DEFAULT '0.00',
  `ach_tiang` decimal(5,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11308 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
