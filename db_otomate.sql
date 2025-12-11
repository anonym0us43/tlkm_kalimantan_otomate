-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2025 at 08:54 PM
-- Server version: 10.6.24-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_otomate`
--

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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_assign_orders`
--

CREATE TABLE `tb_assign_orders` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `order_code` varchar(100) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_headline` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_designator_khs`
--

CREATE TABLE `tb_designator_khs` (
  `id` int(11) NOT NULL,
  `item_designator` varchar(255) DEFAULT NULL,
  `item_description` text DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `material_price_mitra` int(11) DEFAULT NULL,
  `service_price_mitra` int(11) DEFAULT NULL,
  `material_price_mtel` int(11) DEFAULT NULL,
  `service_price_mtel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_designator_khs`
--

INSERT INTO `tb_designator_khs` (`id`, `item_designator`, `item_description`, `unit`, `package_id`, `material_price_mitra`, `service_price_mitra`, `material_price_mtel`, `service_price_mtel`) VALUES
(1, 'DC-OF-SM-12D', 'Pengadaan Dan Pemasangan Kabel Duct Fiber Optik Single Mode 12 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 6820, 3580, 10297, 3870),
(2, 'DC-OF-SM-24D', 'Pengadaan Dan Pemasangan Kabel Duct Fiber Optik Single Mode 24 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 8870, 3590, 13436, 3870),
(3, 'DC-OF-SM-48D', 'Pengadaan Dan Pemasangan Kabel Duct Fiber Optik Single Mode 48 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 13000, 3590, 19793, 3870),
(4, 'DC-OF-SM-96D', 'Pengadaan Dan Pemasangan Kabel Duct Fiber Optik Single Mode 96 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 25930, 3590, 35989, 3870),
(5, 'AC-OF-SM-12D', 'Pengadaan Dan Pemasangan Kabel Duct Fiber Optik Single Mode 96 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 12520, 5010, 14635, 5390),
(6, 'AC-OF-SM-24D', 'Pengadaan Dan Pemasangan Kabel Udara Fiber Optik Single Mode 24 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 15390, 4970, 17995, 5350),
(7, 'AC-OF-SM-48D', 'Pengadaan Dan Pemasangan Kabel Udara Fiber Optik Single Mode 48 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 21520, 4970, 25194, 5350),
(8, 'AC-OF-SM-96D', 'Pengadaan Dan Pemasangan Kabel Udara Fiber Optik Single Mode 96 Core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 30720, 4970, 38389, 5360),
(9, 'SC-OF-SM-24', 'Pengadaan Dan Pemasangan Alat Sambung (Cabang/ Lurus) Untuk Fiber Optik Kapasitas 12 – 24 Core untuk pekerjaan Mitratel', 'pcs', 7, 519700, 35920, 786312, 38213),
(10, 'SC-OF-SM-48', 'Pengadaan Dan Pemasangan Alat Sambung (Cabang/ Lurus) Untuk Fiber Optik Kapasitas 12 – 48 Core untuk pekerjaan Mitratel', 'pcs', 7, 577600, 35920, 888319, 38213),
(11, 'SC-OF-SM-96', 'Pengadaan Dan Pemasangan Alat Sambung (Cabang/ Lurus) Untuk Fiber Optik Kapasitas 12 – 96 Core untuk pekerjaan Mitratel', 'pcs', 7, 676800, 35380, 1014071, 38213),
(12, 'OS-SM-1', 'Penyambungan Kabel Optik Single Mode Kap 1 Core Dengan Cara Fusion Splice untuk pekerjaan Mitratel', 'core', 7, 0, 54010, 0, 65707),
(13, 'DC-OF-SM-2A', 'Pengadaan Dan Pemasangan Kabel Serat Optic Penanggal Single Mode 2 Core Dgn Pelindung Pipa G 657 A (Indoor) untuk pekerjaan Mitratel', 'meter', 7, 2090, 1600, 7713, 3293),
(14, 'DC-OF-SM-1B', 'Pengadaan Dan Pemasangan Kabel Serat Optic Penanggal Single Mode 1 Core G 657 B (Outdoor) untuk pekerjaan Mitratel', 'meter', 7, 3250, 3240, 3978, 3293),
(15, 'DC-OF-SM-2B', 'Pengadaan Dan Pemasangan Kabel Serat Optic Penanggal Single Mode 2 Core G 657 B (Outdoor) untuk pekerjaan Mitratel', 'meter', 7, 5690, 3240, 6941, 3293),
(16, 'AC-OF-SM-1B', 'Pengadaan Dan Pemasangan Kabel Serat Optic Penanggal Single Mode 1 Core Dgn Kawat Penggantung G.657 B (Outdoor) untuk pekerjaan Mitratel', 'meter', 7, 2300, 3240, 3978, 3293),
(17, 'AC-OF-SM-2B', 'Pengadaan Dan Pemasangan Kabel Serat Optic Penanggal Single Mode 2 Core Dgn Kawat Penggantung G.657 B (Outdoor) untuk pekerjaan Mitratel', 'meter', 7, 3510, 3240, 6941, 3293),
(18, 'PC-UPC-652-2', 'Pengadaan Dan Pemasangan Patch Cord 2 Meter, (Fc/Lc/Sc-Upc To Fc/Lc/Sc-Upc), G.652D untuk pekerjaan Mitratel', 'pcs', 7, 26310, 3190, 62989, 3396),
(19, 'PC-UPC-652-A1', 'Pengadaan Dan Pemasangan Patch Cord 2 Meter, (Fc/Lc/Sc-Upc To Fc/Lc/Sc-Upc), G.652D Additional Per 1 Meter untuk pekerjaan Mitratel', 'pcs', 7, 2190, 1580, 5495, 1681),
(20, 'ODC-C-48', 'Pengadaan Dan Pemasangan Odc-Pole (Outdoor) With Space For Passive Spliter, Adaptor Sc Kap 48 Core, Berikut Pelabelan untuk pekerjaan Mitratel', 'pcs', 7, 3432000, 4390000, 5085787, 4669867),
(21, 'ODP-A-16', 'Pengadaan Dan Pemasangan Odp Type Indoor/Wall Kap 16 Core Berikut Space 2 Pasive Spliter (1:8), Adapter Sc, Berikut Pelabelan untuk pekerjaan Mitratel', 'pcs', 7, 962800, 143700, 1229177, 152846),
(22, 'ODP-PL-16', 'Pengadaan Dan Pemasangan Odp ( Pilar ) Kap 16 Core Termasuk Pigtail, Berikut Space 2 Spliter (1:8), Pelabelan untuk pekerjaan Mitratel', 'pcs', 7, 1845000, 143700, 2654491, 152846),
(23, 'TC-SM-12', 'Pengadaan Dan Pemasangan Otb Termasuk Terminasi Dan Penyambungan Kabel Optik Single Mode Kap 12 Core Serta Adapter (Sc/Fc Connector), Pigtail Dan Protection Sleeve Pada Cassette/Box untuk pekerjaan Mitratel', 'pcs', 7, 684100, 330600, 1111626, 829991),
(24, 'TC-SM-24', 'Pengadaan Dan Pemasangan Otb Termasuk Terminasi Dan Penyambungan Kabel Optik Single Mode Kap 24 Core Serta Adapter (Sc/Fc Connector), Pigtail Dan Protection Sleeve Pada Cassette/Box untuk pekerjaan Mitratel', 'pcs', 7, 908600, 1044000, 1562802, 1659985),
(25, 'TC-SM-48', 'Pengadaan Dan Pemasangan Otb Termasuk Terminasi Dan Penyambungan Kabel Optik Single Mode Kap 48 Core Serta Adapter (Sc/Fc Connector), Pigtail Dan Protection Sleeve Pada Cassette/Box untuk pekerjaan Mitratel', 'pcs', 7, 1782000, 2088000, 3185468, 3319969),
(26, 'PU-S7.0-140', 'Pengadaan Dan Pemasangan Tiang Besi 7 Meter, Berikut Cat & Cor Pondasi dengan Kekuatan Tarik 140 Kg untuk pekerjaan Mitratel', 'unit', 7, 1479000, 248800, 1922097, 305693),
(27, 'PU-S9.0-140', 'Pengadaan Dan Pemasangan Tiang Besi 9 Meter, Berikut Cat & Cor dengan Kekuatan Tarik 140 Kg untuk pekerjaan Mitratel', 'unit', 7, 2029000, 249300, 3169350, 308634),
(28, 'GU-G', 'Pengadaan Dan Pemasangan Temberang Tarik untuk pekerjaan Mitratel', 'pcs', 7, 249600, 62860, 558909, 67899),
(29, 'PU-AS', 'Pengadaan Dan Pemasangan Asesories Tiang Eksisting untuk pekerjaan Mitratel', 'paket', 7, 27550, 42490, 35195, 45196),
(30, 'GB-G1', 'Pengadaan Dan Pemasangan Grounding 1 Titik Rod Pada Odp /Kotak Pembagi Dengan Tahanan Maks 3 Ohm untuk pekerjaan Mitratel', 'pcs', 7, 733100, 422500, 960142, 456386),
(31, 'GB-G3', 'Pengadaan Dan Pemasangan Grounding 3 Titik Rod Pada Odc Dengan Tahanan Maks 1 Ohm untuk pekerjaan Mitratel', 'pcs', 7, 2208000, 489800, 2892183, 529085),
(32, 'TC-02-ODC', 'Pengadaan Dan Pemasangan Riser Pipe Untuk Pengamanan Kabel Optik Ke Odc Pole / Titik Naik Ku Diameter 2 Inch Panjang 3 Meter untuk pekerjaan Mitratel', 'pcs', 7, 245500, 64110, 261334, 68193),
(33, 'PP-OF-IN', 'Pengadaan Dan Pemasangan Pipe Protection Indoor Cable (Pvc White) High Impact Conduit 20 Mm untuk pekerjaan Mitratel', 'meter', 7, 21900, 4180, 28680, 4520),
(34, 'PP-OF-OUT', 'Pengadaan Dan Pemasangan Pipe Protection Outdoor Cable (Pvc Black) High Impact Conduit 20 Mm untuk pekerjaan Mitratel', 'meter', 7, 21510, 4240, 28340, 4520),
(35, 'DD-S3-1', 'Pengadaan Dan Pemasangan Pipa Besi Diameter 100 Mm Dan Ketebalan Pipa 3,65 Mm Utuk Crossing 1 Pipa Bentang  ≤ 6 Meter untuk pekerjaan Mitratel', 'meter', 7, 276000, 62770, 361538, 67796),
(36, 'DD-V4-1', 'Pengadaan Dan Pemasangan Pipa Duct Pvc Diameter Dalam 100 Mm, Ketebalan 4 Mm, 1 Pipa Termasuk Pengecoran untuk pekerjaan Mitratel', 'meter', 7, 52520, 62770, 68790, 67796),
(37, 'DD-V5-1', 'Pemasngan Pipa Duct Dengan Selubung Pasir Diameter 100 Mm Dengan Ketebalan 5,5 Mm, 1 Pipa ( Crossing ) untuk pekerjaan Mitratel', 'meter', 7, 50780, 62770, 66514, 67796),
(38, 'DD-DA-S1', 'Pengadaan Dan Pemasangan Pipa Duct Menempel Pada Jembatan Existing Menggunakan Pipa Galvanis Diameter 100 Mm, Tebal 3,65 Mm, 1 Pipa untuk pekerjaan Mitratel', 'meter', 7, 274700, 254900, 361538, 271185),
(39, 'DD-BSS-S1', 'Pengadaan Dan Pemasangan Pipa Duct Pada Jembatan Dengan Self Support Berpenguat Menggunakan Pipa Besi Galvanis 1 Pipa, Bentang 6 – 12 Meter untuk pekerjaan Mitratel', 'meter', 7, 355600, 251000, 465762, 271185),
(40, 'DD-BTS-S1', 'Pengadaan Dan Pemasangan Pipa Duct Pada Jembatan Menggunakan Pipa Besi Galvanis 1 Pipa, Bentang 6 – 12 Meter untuk pekerjaan Mitratel', 'meter', 7, 354200, 251000, 463954, 271185),
(41, 'HB-PS-1', 'Pengadaan Dan Pemasangan Pipa Duct Dengan System Gantung 1 Tiang Besi, Bentang S/D 40 Meter untuk pekerjaan Mitratel', 'meter', 7, 123200, 40640, 162298, 43229),
(42, 'HB-PS-2', 'Pengadaan Dan Pemasangan Pipa Duct Dengan System Gantung 2 Tiang Besi, Bentang S/D 100 Meter untuk pekerjaan Mitratel', 'meter', 7, 255000, 48030, 334080, 51874),
(43, 'HB-PS-4', 'Pengadaan Dan Pemasangan Pipa Duct Dengan System Gantung 4 Tiang Besi, Bentang ≥ 100 Meter untuk pekerjaan Mitratel', 'meter', 7, 493700, 56030, 646645, 60520),
(44, 'DD-BMR-1', 'Pengadaan Dan Pemasangan Boring Pada Lintasan Kereta Api Menggunakan 1 Pipa Galvanis Diameter 100 Mm Tebal 3,65 Mm untuk pekerjaan Mitratel', 'track', 7, 828200, 23050000, 1084613, 24899764),
(45, 'DC-SD-28-1', 'Pengadaan Dan Pemasangan 1 Subduct 28/32 Mm Pada Polongan Route Duct untuk pekerjaan Mitratel', 'meter', 7, 7250, 1720, 10393, 1837),
(46, 'DD-BM-100-1', 'Pengadaan Dan Pemasangan Pipa Galvanis Dengan Ukuran Diameter 100 Mm Dan Ketebalan 3,65 Mm Dengan Cara Boring Manual / Mesin 1 Pipa Dengan Kedalaman Minimal 150 Cm untuk pekerjaan Mitratel', 'meter', 7, 276000, 72000, 361538, 87537),
(47, 'DD-BM-HDPE-40-1', 'Pekerjaan Boring Manual (Rojok) Hdpe 40/33 Mm 1 Pipa Dengan Kedalaman 1,5 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 35580, 0, 48793),
(48, 'DD-HDPE-40-1', 'Pengadaan Dan Pemasangan Pipa Hdpe 40/33 Mm 1 Pipa Dengan Kedalaman 1,5 Meter untuk pekerjaan Mitratel', 'meter', 7, 10500, 1450, 14042, 1750),
(49, 'BC-TR-0.4', 'Pekerjaan Galian, Pengurugan Kembali Dan Perbaikan Kembali, Pengisian Pasir, Warning Tape Dan Tanda Rute Kabel Serta Tempat Sambung Kedalaman 0,4 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 11640, 0, 22339),
(50, 'BC-TR-0.6', 'Pekerjaan Galian, Pengurugan Kembali Dan Perbaikan Kembali, Pengisian Pasir, Warning Tape Dan Tanda Rute Kabel Serta Tempat Sambung Kedalaman 0,6 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 15740, 0, 26513),
(51, 'BC-TR-1', 'Pekerjaan Galian, Pengurugan Kembali Dan Perbaikan Kembali, Pengisian Pasir, Warning Tape Dan Tanda Rute Kabel Serta Tempat Sambung Kedalaman 1 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 24990, 0, 36351),
(52, 'BC-TR-2', 'Pekerjaan Galian, Pengurugan Kembali Dan Perbaikan Kembali, Pengisian Pasir, Warning Tape Dan Tanda Rute Kabel Serta Tempat Sambung Kedalaman 1,2 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 29850, 0, 41518),
(53, 'BC-TR-3', 'Pekerjaan Galian, Pengurugan Kembali Dan Perbaikan Kembali, Pengisian Pasir, Warning Tape Dan Tanda Rute Kabel Serta Tempat Sambung Kedalaman 1,3 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 31930, 0, 43728),
(54, 'BC-TR-4', 'Pekerjaan Galian, Pengurugan Kembali Dan Perbaikan Kembali, Pengisian Pasir, Warning Tape Dan Tanda Rute Kabel Serta Tempat Sambung Kedalaman 1,4 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 34390, 0, 46348),
(55, 'BC-TR-5', 'Pekerjaan Galian, Pengurugan Kembali Dan Perbaikan Kembali, Pengisian Pasir, Warning Tape Dan Tanda Rute Kabel Serta Tempat Sambung Kedalaman 1,5 Meter untuk pekerjaan Mitratel', 'meter', 7, 0, 36690, 0, 48793),
(56, 'BCTR-ROCK', 'Pengadaan Galian Batu Masif Kedalaman 1,5 Meter, Panjang Minimum 5 M, Termasuk Pengadaan Marking Post untuk pekerjaan Mitratel', 'meter', 7, 0, 222900, 0, 246906),
(57, 'BD-SK', 'Pekerjaan Bobokan Dan Perbaikan Dinding Chamber / Bts / Sto Untuk Lubang Sparing Kabel untuk pekerjaan Mitratel', 'Titik', 7, 47020, 84990, 61891, 90396),
(58, 'MH-HH2', 'Pekerjaan Pembuatan Handhole Type Hh2 Ukuran Dimensi Dalam (P X L X T = 130X120X165) Cor Beton 1 : 2 : 3 untuk pekerjaan Mitratel', 'pcs', 7, 3718000, 2172000, 4890064, 2311006),
(59, 'HH-PIT-P-ODP', 'Pekerjaan Pembuatan Hh Pit Portable Odp Beserta Aksesorisnya untuk pekerjaan Mitratel', 'pcs', 7, 1635000, 283100, 3012691, 305766),
(60, 'ODP-KLEM-COOKER', 'Klem Coocker Odp Solid untuk pekerjaan Mitratel', 'pcs', 7, 21230, 27470, 27716, 28218),
(61, 'ODP-KLEM-KU', 'Klem Kabel Udara Odp Solid untuk pekerjaan Mitratel', 'pcs', 7, 21710, 27470, 27716, 28218),
(62, 'ODP-RISE', 'Rise Pipe (Coocker) Odp Solid untuk pekerjaan Mitratel', 'Mtr', 7, 11930, 1760, 15252, 1815),
(63, 'stainless-belt', 'Pengadaan Dan Pemasangan Aksesoris Tiang Besi Stainless Belt untuk pekerjaan Mitratel', 'pcs', 7, 9700, 6530, 0, 0),
(64, 'BUCKLE', 'Pengadaan Dan Pemasangan Aksesoris Tiang Besi Buckle untuk pekerjaan Mitratel', 'pcs', 7, 1160, 1150, 1988, 1182),
(65, 'SUSPENSION-AYUN', 'Pengadaan Dan Pemasangan Aksesoris Tiang Besi Suspension Ayun untuk pekerjaan Mitratel', 'pcs', 7, 24840, 15990, 0, 0),
(66, 'POLESTRAP SPIRAL', 'Pengadaan Dan Pemasangan Aksesoris Tiang Besi Polestrap Spiral untuk pekerjaan Mitratel', 'pcs', 7, 18310, 12440, 23198, 12782),
(67, 'ANCHORING', 'Pengadaan Dan Pemasangan Aksesoris Tiang Besi Anchoring untuk pekerjaan Mitratel', 'pcs', 7, 32370, 17300, 39767, 17773),
(68, 'TRIMBEL', 'Aksesoris Tiang Besi Trimbel untuk pekerjaan Mitratel', 'pcs', 7, 2030, 5150, 15666, 5291),
(69, 'SW-BG-3/8', 'Span  Wartel Dan Buldog Grip 3/8\"  untuk pekerjaan Mitratel', 'pcs', 7, 18870, 10340, 0, 0),
(70, 'SW-BG-5/8', 'Span  Wartel Dan Buldog Grip 5/8\" untuk pekerjaan Mitratel', 'pcs', 7, 32850, 16140, 0, 0),
(71, 'PL-TYPE-J', 'Pengadaan Dan Pemasangan Pole Strap Type J untuk pekerjaan Mitratel', 'pcs', 7, 29450, 13730, 42179, 14108),
(72, 'PL-RING', 'Pengadaan Dan Pemasangan Pole Strap Ring untuk pekerjaan Mitratel', 'pcs', 7, 21900, 13730, 38682, 14108),
(73, 'PL-POLOS', 'Pengadaan Dan Pemasangan Pole Strap Polos untuk pekerjaan Mitratel', 'pcs', 7, 25950, 13340, 26719, 14108),
(74, 'S-CLAMP', 'Pengadaan dan Pemasangan S-Clamp Pada Tiang untuk pekerjaan Mitratel', 'pcs', 7, 11380, 13730, 24704, 14108),
(75, 'CLAMP HOOK/BRACKET PELANGGAN SPIRAL', 'Pengadaan dan Pemasangan Clamp Hook/Bracket Pelanggan Spiral untuk pekerjaan Mitratel', 'pcs', 7, 8390, 13130, 24704, 14108),
(76, 'Klem-HDPE', 'Pengkleman Hdpe Di Dinding Beton Dengan Klem Ketebalan 2Mm Lebar 2,5 Cm Menggunakan Dynabolt Termasuk Rekondisi Atau Perbaikan Kerusakan untuk pekerjaan Mitratel', 'pcs', 7, 9190, 2230, 0, 0),
(77, 'HH-PIT-80', 'Pembuatan Handhole Pit Ukuran Dimensi Dalam (P X L X T = 80Cm X 80Cm X 80Cm) Cor Beton 1 : 2 : 3 untuk pekerjaan Mitratel', 'pcs', 7, 1260000, 707600, 1650954, 764232),
(78, 'SLACK-SUPP', 'Pengadaan Dan Pemasangan Slack Support untuk pekerjaan Mitratel', 'pcs', 7, 104300, 18310, 156659, 42620),
(79, 'Klem-Galvanise', 'Pengadaan & Pemasangan Klem Galvanise Untuk Airblown Pipe Dengan Ketebalan 2Mm, Lebar 2.5 Cm Menggunakan Dynabolt Termasuk Rekondisi Atau Perbaikan Kerusakan untuk pekerjaan Mitratel', 'pcs', 7, 11250, 2170, 0, 0),
(80, 'Perizinan Project', 'Biaya-Biaya Yang Timbul Dalam Rangka Untuk Perijinan, KompensasI (Yang Bersifat One Time Charge atau Bukan Sewa) untuk pekerjaan Mitratel', 'Lumpsum', 7, 0, 0, 0, 0),
(81, 'INVENTORY-SMALLWORLD', 'Inventory Abd Kabel Fiber Optik Di Smallworld , Termasuk Validasi Gambar untuk pekerjaan Mitratel', 'titik', 7, 0, 240, 0, 0),
(82, 'LABEL-ODP-OTB', 'Pelabelan ODP & OTB untuk pekerjaan Mitratel', 'ODP', 7, 0, 8400, 0, 12000),
(83, 'DRW-ABD-PROJ', 'Pembuatan As Build Drawing Dalam Ukuran A1 Meliputi Peta Lokasi & Skema Kabel  untuk pekerjaan Mitratel', 'titik', 7, 0, 440, 0, 639),
(84, 'DC-OF-SM-144D', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 144 core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 37270, 4370, 51083, 4990),
(85, 'SC-OF-SM-144', 'Pengadaan dan pemasangan alat sambung (cabang/ lurus) untuk Fiber Optik kapasitas 12 – 144 core untuk pekerjaan Mitratel', 'pcs', 7, 886800, 35380, 1412995, 40509),
(86, 'DD-ROD', 'Pekerjaan Pembersihan pada route Duct yang kosong / Rodding Duct Existing untuk pekerjaan Mitratel', 'meter', 7, 0, 2090, 0, 2254),
(87, 'MH-CA', 'Pekerjaan Peninggian Tutup Manhole/Handhole untuk pekerjaan Mitratel', 'pcs', 7, 746900, 740200, 975686, 797506),
(88, 'FTM-CR-19', 'Pengadaan & Pemasangan Optical Fiber High Density Cable, Close Rack 19 inch, Lengkap termasuk Fiber Management Maximum Capacity 7X 144 Core / 42U untuk pekerjaan Mitratel', 'pcs', 7, 13230000, 303300, 20508465, 450966),
(89, 'TC-SM-144', 'Pengadaan & Pemasangan OTB Single Mode kapasitas 144 core (tidak termasuk terminasi), Adapter (SC/FC Connector), Pigtail dan Protection Sleeve pada Cassette / box untuk pekerjaan Mitratel', 'pcs', 7, 7267000, 75840, 12656647, 112742),
(90, 'DD-RV-1', 'Pekerjaan Perbaikan Route Duct / HDPE, 1 pipa untuk pekerjaan Mitratel', 'meter', 7, 32240, 83690, 42130, 90169),
(91, 'ODC-C-96', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 96 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, pondasi berlapis keramik, lantai kerja keramik, patok pengaman (5 buah), berikut pelabelan untuk pekerjaan Mitratel', 'pcs', 7, 7071000, 4558000, 10914026, 5499138),
(92, 'ODC-C-144', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 144 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, pondasi berlapis keramik, lantai kerja keramik, patok pengaman (5 buah), berikut pelabelan untuk pekerjaan Mitratel', 'pcs', 7, 10180000, 5842000, 14132099, 6280884),
(93, 'ODC-C-288', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 288 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, pondasi berlapis keramik, lantai kerja keramik, patok pengaman (5 buah), berikut pelabelan untuk pekerjaan Mitratel', 'pcs', 7, 19350000, 5886000, 26671533, 6328281),
(94, 'ODC-C-576', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 576 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, pondasi berlapis keramik, lantai kerja keramik, patok pengaman (5 buah), berikut pelabelan untuk pekerjaan Mitratel', 'pcs', 7, 45300000, 5840000, 63401678, 6278665),
(95, 'ODC-C-144-PKU', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 144 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, ditempatkan pada 2 tiang besi 7m yang dilengkapi besi penyangga antar tiang dengan rangka besi ODC dan Bordes lantai kerja serta grounding 5m luas penampang minimal 25mm untuk penempatan kabel FO dan Grounding 1 titik menggunakan Anchoring, Span wartel dan slack support 2 buah untuk pekerjaan Mitratel', 'pcs', 7, 18380000, 8938000, 23579358, 9608816),
(96, 'ODC-C-288-PKU', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 288 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, ditempatkan pada 2 tiang besi 7m yang dilengkapi besi penyangga antar tiang dengan rangka besi ODC dan Bordes lantai kerja serta grounding 5m luas penampang minimal 25mm untuk penempatan kabel FO dan Grounding 1 titik, menggunakan Anchoring, Span wartel dan slack support 2 buah untuk pekerjaan Mitratel', 'pcs', 7, 28000000, 8982000, 36118793, 9656211),
(97, 'ODC-C-144-PKT', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 144 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, ditempatkan pada 2 tiang besi 7m yang dilengkapi besi penyangga antar tiang dengan rangka besi ODC dan Bordes lantai kerja serta grounding 5m luas penampang minimal 25mm untuk penempatan kabel FO dan Grounding 1 titik, menggunakan 1 buah Riser Pipe 2” panjang 3m termasuk Handhole ODC portable  untuk pekerjaan Mitratel', 'pcs', 7, 27120000, 9486000, 34983454, 10198122),
(98, 'ODC-C-288-PKT', 'Pengadaan dan pemasangan kabinet ODC (Outdoor) kap 288 core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, ditempatkan pada 2 tiang besi 7m yang dilengkapi besi penyangga antar tiang dengan rangka besi ODC dan Bordes lantai kerja serta grounding 5m luas penampang minimal 25mm untuk penempatan kabel FO dan Grounding 1 titik, menggunakan 1 buah Riser Pipe 2” panjang 3m termasuk Handhole ODC portable untuk pekerjaan Mitratel', 'pcs', 7, 36740000, 9530000, 47522889, 10245518),
(99, 'ODC-PROT-144', 'Pengaman ODC 144 (Besi siku 4cmx4cmx4mm, besi beton 10mm (jarak antar besi beton 10cm, engsel besar, baut ram set 14mm dan kunci gembok 50mm untuk pekerjaan Mitratel', 'unit', 7, 1482000, 679000, 2099082, 819195),
(100, 'ODC-PROT-288', 'Pengaman ODC 288 (Besi siku 4cmx4cmx4mm, besi beton 10mm (jarak antar besi beton 10cm, engsel besar, baut ram set 14mm dan kunci gembok 50mm untuk pekerjaan Mitratel', 'unit', 7, 1609000, 727500, 2279003, 877708),
(101, 'SITAC-ODC', 'Akuisisi Lahan SITAC ODC untuk pekerjaan Mitratel', 'Node', 7, 0, 7684000, 0, 0),
(102, 'Flexible-Metal-Conduit', 'Pengadaan dan Pemasangan Flexible Metal Conduit Ukuran 20mm atau 3/4\" untuk pekerjaan Mitratel', 'pcs', 7, 21510, 4240, 28547, 4498),
(103, 'PU-S7.0-400NM', 'Pengadaan dan Pemasangan Tiang Besi Telekomunikasi 7 Meter dengan 2 Segmen untuk Kabel Distlibusl berikut Cat & Car Pondasi (1 :2:3) dengan Kekuatan Tarik 400 Newton Meter untuk pekerjaan Mitratel', 'pcs', 7, 994300, 237600, 1389098, 251610),
(104, 'PIGTAIL', 'Pekerjaan Menyambungkan Kabel Optik Outdoor Ke Indoor) Pengadaan Dan Pemasangan  Pigtail (Sc/Fc) untuk pekerjaan Mitratel', 'pcs', 7, 11440, 63970, 19191, 65401),
(105, 'ODP-SOLID-PB-8', 'Pengadaan dan pemasangan ODP type SOLID Kap 8 core adaptor SC/UPC beserta Accessories untuk pekerjaan Mitratel', 'pcs', 7, 642000, 162800, 1439370, 175542),
(106, 'ODP-SOLID-PB-16', 'Pengadaan dan pemasangan ODP type SOLID Kap 16 core adaptor SC/UPC beserta Accessories untuk pekerjaan Mitratel', 'pcs', 7, 840700, 169100, 1865184, 175542),
(107, 'AC-OF-SM-ADSS-12D', 'Pengadaan dan Pemasangan Kabel Udara Fiber Optik All Dieletric Self Supporting Cable (ADSS) Single Mode 12 Core untuk pekerjaan Mitratel', 'meter', 7, 5690, 4240, 8949, 5350),
(108, 'AC-OF-SM-ADSS-24D', 'Pengadaan dan Pemasangan Kabel Udara Fiber Optik All Dieletric Self Supporting Cable (ADSS) Single Mode 24 Core untuk pekerjaan Mitratel', 'meter', 7, 6820, 4300, 10813, 5350),
(109, 'AC-OF-SM-ADSS-48D', 'Pengadaan dan Pemasangan Kabel Udara Fiber Optik All Dieletric Self Supporting Cable (ADSS) Single Mode 48 Core untuk pekerjaan Mitratel', 'meter', 7, 10350, 4320, 16403, 5350),
(110, 'AC-OF-SM-ADSS-96D', 'Pengadaan dan Pemasangan Kabel Udara Fiber Optik All Dieletric Self Supporting Cable (ADSS) Single Mode 96 Core untuk pekerjaan Mitratel', 'meter', 7, 17700, 4970, 24904, 5360),
(111, 'Helical-Dead-End', 'Pengadaan dan pemasangan Aksesoris tiang Helical Dead-End untuk pekerjaan Mitratel', 'pcs', 7, 16520, 8580, 0, 0),
(112, 'Suspense-On-Clamp(Corong)', 'Pengadaan dan pemasangan Aksesoris tiang Suspense on Clamp (corong) untuk pekerjaan Mitratel', 'pcs', 7, 16520, 8580, 0, 0),
(113, 'J-RGL-KU-FO-48-96', 'REGEL KABEL UDARA FIBER OPTIK KAPASITAS 48-96 CORE untuk pekerjaan Mitratel', 'meter', 7, 0, 630, 0, 0),
(114, 'J-RGL-KU-FO-6-24', 'REGEL KABEL UDARA FIBER OPTIK KAPASITAS 6-24 CORE untuk pekerjaan Mitratel', 'meter', 7, 0, 630, 0, 0),
(115, 'J-MTT-RL-7/9', 'MENEGAKKAN TIANG BESI MIRING RUTE LURUS untuk pekerjaan Mitratel', 'pcs', 7, 0, 23840, 0, 0),
(116, 'J-MTT-RS-7/9', 'MENEGAKKAN TIANG BESI MIRING RUTE SUDUT untuk pekerjaan Mitratel', 'pcs', 7, 0, 29840, 0, 0),
(117, 'BKR-KU', 'PEMBONGKARAN  KABEL UDARA untuk pekerjaan Mitratel', 'meter', 7, 0, 850, 0, 0),
(118, 'J-0PB-TT-7/9', 'PEMBONGKARAN DAN PENGGESERAN TIANG TELEPON TUNGGAL 7 M DAN 9 M untuk pekerjaan Mitratel', 'btg', 7, 0, 110900, 0, 0),
(119, 'ODC-ODP-ADAPT-STDR', 'PENGADAAN/PENGGANTIAN ADAPTER SC PADA ODC DAN ODP BAHAN PLASTIK untuk pekerjaan Mitratel', 'pcs', 7, 5180, 1410, 0, 0),
(120, 'PT-TT-7', 'PENGECATAN TIANG TELEPON TUNGGAL 7 M DAN 9 M untuk pekerjaan Mitratel', 'Btg', 7, 26900, 12860, 0, 0),
(121, 'PC-TT-7/9', 'PENGECORAN TIANG TELEPON TUNGGAL 7 M DAN 9M untuk pekerjaan Mitratel', 'Btg', 7, 123100, 59590, 0, 0),
(122, 'G-ODC-C-48', 'PENGGESERAN ODC-POLE (OUTDOOR)  KAP 48 CORE (PEMBONGKARAN DAN PEMASANGAN KEMBALI TANPA MERUBAH ATAU MENGGANTI ALPRO) tidak termasuk penyambungan kabel untuk pekerjaan Mitratel', 'unit', 7, 0, 8437000, 0, 0),
(123, 'M-RP-GM-2', 'RISER PIPA 2,00\" GALVANIS MEDIUM UTK KABEL TURUN/NAIK CATUAN KT/KU PADA TIANG/DINDING untuk pekerjaan Mitratel', 'Unit', 7, 278500, 51460, 0, 0),
(124, 'DROPCORE', 'Drop Core untuk pekerjaan Mitratel', 'meter', 7, 1630, 3190, 0, 0),
(125, 'PU-C7.0-150', 'PENGADAAN TIANG BETON 7 METER DENGAN KEKUATAN TARIK 150 KG untuk pekerjaan Mitratel', 'pcs', 7, 1581000, 578100, 0, 0),
(126, 'PU-C9.0-150', 'PENGADAAN TIANG BETON 9 METER DENGAN KEKUATAN TARIK 150 KG untuk pekerjaan Mitratel', 'pcs', 7, 2573000, 723600, 0, 0),
(127, 'BC-TR-S-0.8', 'PENGGALIAN DENGAN KONDISI TANAH PADAS/CADAS TERMASUK PENGURUGAN DAN PERBAIKAN KEMBALI BEKAS GALIAN DENGAN PERMUKAAN COR BETON 1:2:3 (LEBAR30CM, KETEBALAN 40CM) DENGAN KEDALAMAN MINIMAL 80 CM  untuk pekerjaan Mitratel', 'meter', 7, 149400, 120600, 0, 0),
(128, 'BC-TR-S-1', 'PENGGALIAN DENGAN KONDISI TANAH PADAS/CADAS TERMASUK PENGURUGAN DAN PERBAIKAN KEMBALI BEKAS GALIAN DENGAN KEDALAMAN MINIMAL 100 CM  untuk pekerjaan Mitratel', 'meter', 7, 0, 143200, 0, 0),
(129, 'BC-TR-S-2', 'PENGGALIAN DENGAN KONDISI TANAH PADAS/CADAS TERMASUK PENGURUGAN DAN PERBAIKAN KEMBALI BEKAS GALIAN DENGAN KEDALAMAN MINIMAL 120 CM  untuk pekerjaan Mitratel', 'meter', 7, 0, 163000, 0, 0),
(130, 'BC-TR-S-3', 'PENGGALIAN DENGAN KONDISI TANAH PADAS/CADAS TERMASUK PENGURUGAN DAN PERBAIKAN KEMBALI BEKAS GALIAN DENGAN KEDALAMAN MINIMAL 130 CM  untuk pekerjaan Mitratel', 'meter', 7, 0, 168700, 0, 0),
(131, 'BC-TR-S-4', 'PENGGALIAN DENGAN KONDISI TANAH PADAS/CADAS TERMASUK PENGURUGAN DAN PERBAIKAN KEMBALI BEKAS GALIAN DENGAN KEDALAMAN MINIMAL 140 CM  untuk pekerjaan Mitratel', 'meter', 7, 0, 174500, 0, 0),
(132, 'BC-TR-S-5', 'PENGGALIAN DENGAN KONDISI TANAH PADAS/CADAS TERMASUK PENGURUGAN DAN PERBAIKAN KEMBALI BEKAS GALIAN DENGAN KEDALAMAN MINIMAL 150 CM  untuk pekerjaan Mitratel', 'meter', 7, 0, 180300, 0, 0),
(133, 'BC-TR-A-0.4', 'PEKERJAAN GALIAN PADA PERMUKAAN JALAN ASPAL YANG BEBAS DARI UTILITAS PUBLIK DENGAN LEBAR GALIAN 8 CM DAN KEDALAMAN 40 CM, TERMASUK PERBAIKAN, PENGURUGAN (BACKFILLING) MENGGUNAKAN CONCRETE TYPE K225 DAN PENGASPALAN untuk pekerjaan Mitratel', 'meter', 7, 0, 194800, 0, 0),
(134, 'J-CO-OF', 'PEKERJAAN CUT OVER KABEL SERAT OPTIK untuk pekerjaan Mitratel', 'core', 7, 0, 52760, 0, 0),
(135, 'J-PROT-SLV', 'PENGADAAN DAN PEMASANGAN PROTECTION SLEEVE 6MM, PANJANG 6CM untuk pekerjaan Mitratel', 'Pcs', 7, 590, 560, 0, 0),
(136, 'BC-MTR-GALV.1-3.2', 'PENGADAAN ALUR KABEL MENGGUNAKAN PIPA GALVANIS DIAMETER 1 INCHI, DI DALAM GALIAN BETON/KERAMIK DENGAN KEDALAMAN 10CM, LEBAR 5CM DARI AREA DISPENSER MENUJU OFFICE TERMASUK PERBAIKAN KEMBALI JALUR GALIAN untuk pekerjaan Mitratel', 'meter', 7, 52090, 118700, 0, 0),
(137, 'BC-MTR-GALV.2-3.6', 'PENGADAAN ALUR KABEL MENGGUNAKAN PIPA GALVANIS DIAMETER 2 INCHI, DI DALAM GALIAN BETON / KERAMIK DENGAN KEDALAMAN 10CM, LEBAR 5CM DARI AREA DISPENSER MENUJU OFFICE TERMASUK PERBAIKAN KEMBALI JALUR GALIAN untuk pekerjaan Mitratel', 'Mtr', 7, 108400, 116900, 0, 0),
(138, 'DD-HDPE-40-1C', 'PENGADAAN DAN PEMASANGAN PIPA HDPE 40/33 MM 1 PIPA DENGAN KEDALAMAN 1,5 METER SUDAH TERMASUK CONNECTOR HDPE TIPE COMPRESSION FITTING untuk pekerjaan Mitratel', 'meter', 7, 11150, 1620, 0, 0),
(139, 'DD-HDPE-40-2', 'PENGADAAN DAN PEMASANGAN PIPA  HDPE  40/33 MM 2 PIPA DENGAN KEDALAMAN 1,5 METER untuk pekerjaan Mitratel', 'meter', 7, 21640, 1950, 0, 0),
(140, 'DD-HDPE-40-2C', 'PENGADAAN DAN PEMASANGAN PIPA HDPE 40/33 MM 2 PIPA DENGAN KEDALAMAN 1,5 METER SUDAH TERMASUK CONNECTOR HDPE TIPE COMPRESSION FITTING untuk pekerjaan Mitratel', 'meter', 7, 22160, 1950, 0, 0),
(141, 'DD-HDPE-50-1', 'PENGADAAN DAN PEMASANGAN PIPA HDPE  50/42 MM 1 PIPA DENGAN KEDALAMAN 1,5 METER untuk pekerjaan Mitratel', 'meter', 7, 18210, 1620, 0, 0),
(142, 'DD-HDPE-50-2', 'PENGADAAN DAN PEMASANGAN PIPA HDPE  50/42 MM 2 PIPA DENGAN KEDALAMAN 1,5 METER untuk pekerjaan Mitratel', 'meter', 7, 36440, 1950, 0, 0),
(143, 'DD-DS-COD1-M', 'PENGADAAN DUCT  BARU TYPE COD, DENGAN MESIN PENGEBORAN (BORRING) DIBAWAH PARIT, PADA KEDALAMAN 1,50 M DI BAWAH DASAR SELOKAN, TANPA PERLINDUNGAN PVC, 1 PIPA untuk pekerjaan Mitratel', 'meter', 7, 22020, 492800, 0, 0),
(144, 'DD-DS-S1', 'PENGADAAN DUCT BARU DENGAN CARA MELAKUKAN BORING DIBAWAH DASAR PARIT/SUNGAI DENGAN KEDALAMAN 1,5 M DENGAN MENGGUNAKAN PVC DIAMATER 100 MM DAN KETEBALAN 5,5 MM 1 PIPA untuk pekerjaan Mitratel', 'meter', 7, 228800, 175700, 0, 0),
(145, 'DD-S3-2', 'PENGADAAN DAN PEMASANGAN PIPA BESI DIAMETER 100 MM DAN KETEBALAN PIPA 3,65 MM UNTUK CROSSING 2 PIPA  BENTANG ≤ 6 METER untuk pekerjaan Mitratel', 'meter', 7, 552100, 83690, 0, 0),
(146, 'DD-S3-3', 'PENGADAAN DAN PEMASANGAN PIPA BESI DIAMETER 100 MM DAN KETEBALAN PIPA 3,65 MM UNTUK CROSSING 3 PIPA  BENTANG ≤ 6 METER untuk pekerjaan Mitratel', 'meter', 7, 828200, 125500, 0, 0),
(147, 'DD-V4-2', 'PENGADAN DAN PEMASANGAN PIPA DUCT PVC DIAMETER DALAM 100 MM, KETEBALAN 4 MM, 2 PIPA TERMASUK PENGECORAN untuk pekerjaan Mitratel', 'meter', 7, 105000, 83820, 0, 0),
(148, 'DD-V5-2', 'PEMASANGAN DAN PEMASANGAN PIPA DUCT DENGAN SELUBUNG PASIR DIA 100 MM DENGAN KETEBALAN 5,5 MM, 2 PIPA ( CROSSING ) untuk pekerjaan Mitratel', 'meter', 7, 102000, 83690, 0, 0),
(149, 'HB-PC-2', 'PENGADAAN DAN PEMASANGAN PIPA DUCT DENGAN SYSTEM GANTUNG 2 TIANG BETON, BENTANG S/D 100 METER untuk pekerjaan Mitratel', 'meter', 7, 430400, 50490, 0, 0),
(150, 'HB-PC-4', 'PENGADAAN DAN PEMASANGAN PIPA DUCT DENGAN SYSTEM GANTUNG 4 TIANG BETON, BENTANG ≥ 100 METER untuk pekerjaan Mitratel', 'meter', 7, 843400, 59820, 0, 0),
(151, 'PU-W7', 'PENGADAAN DAN PEMASANGAN TIANG KAYU KERAS 7 METER, BERIKUT CAT, COR PONDASI ATAU KLEM TUMPUAN KE DINDING TAMBATAN MENGGUNAKAN KAYU BESERTA MUR MAUT YANG SESUAI LENGKAP untuk pekerjaan Mitratel', 'Btg', 7, 1284000, 262200, 0, 0),
(152, 'PU-G6-2,5', 'PENGADAAN DAN PEMASANGAN TIANG BESI GALVANIZED MEDIUM DIAMETER 2,5 INCH PANJANG 6 METER, BERIKUT CAT, COR PONDASI ATAU KLEM TUMPUAN KE DINDING TAMBATAN BESERTA MUR MAUT YANG SESUAI LENGKAP  untuk pekerjaan Mitratel', 'Btg', 7, 1152000, 265100, 0, 0),
(153, 'PU-G6-3', 'PENGADAAN DAN PEMASANGAN TIANG BESI GALVANIZED MEDIUM DIAMETER 3 INCH PANJANG 6 METER, BERIKUT CAT, COR PONDASI ATAU KLEM TUMPUAN KE DINDING TAMBATAN BESERTA MUR MAUT YANG SESUAI LENGKAP  untuk pekerjaan Mitratel', 'Btg', 7, 1284000, 265100, 0, 0),
(154, 'RP-GJ-1,25', 'RISER PIPA 1,25\" GALVANIS MEDIUM  UTK KABEL TURUN/NAIK CATUAN KT/KU PADA TIANG/DINDING untuk pekerjaan Mitratel', 'unit', 7, 186200, 38600, 0, 0),
(155, 'RP-GJ-1,50', 'RISER PIPA 1,50\" GALVANIS MEDIUM  UTK KABEL TURUN/NAIK CATUAN KT/KU PADA TIANG/DINDING untuk pekerjaan Mitratel', 'unit', 7, 208700, 45030, 0, 0),
(156, 'M-KRP-2', 'KLEM RISER PIPE 2\"\" untuk pekerjaan Mitratel', 'pcs', 7, 7590, 0, 0, 0),
(157, 'SUS-CAP', 'SUSPENSION CAPIT  untuk pekerjaan Mitratel', 'pcs', 7, 30960, 16020, 0, 0),
(158, 'J-PT-TUNJANG', 'PEMASANGAN TEMBERANG TUNJANG untuk pekerjaan Mitratel', 'pcs', 7, 0, 122100, 0, 0),
(159, 'J-PT-LABRANG', 'PEMASANGAN TEMBERANG LABRANG untuk pekerjaan Mitratel', 'pcs', 7, 0, 287200, 0, 0),
(160, 'TC-IN', 'TRAY CABLE MAKSIMAL 10 X 5CM DI SISI OFFICE SESUAI SPACE RUANGAN  untuk pekerjaan Mitratel', 'meter', 7, 21210, 4120, 0, 0),
(161, 'GB-G-INTG', 'PENGADAAN DAN PEMASANGAN MATERIAL GROUNDING DI LOKASI GEDUNG EKSISTING DENGAN CARA INTEGRASI untuk pekerjaan Mitratel', 'pcs', 7, 221700, 170200, 0, 0),
(162, 'J-P-J-H1/H2', 'PEMBERSIHAN MANHOLE H1/H2 untuk pekerjaan Mitratel', 'Bh', 7, 0, 289300, 0, 0),
(163, 'J-P-J-H3/H4', 'PEMBERSIHAN MANHOLE H3/H4 untuk pekerjaan Mitratel', 'Bh', 7, 0, 398600, 0, 0),
(164, 'J-P-H-1', 'PEMBERSIHAN HANHOLE TYPE 1 (120 cm x 100 cm x 160 cm) untuk pekerjaan Mitratel', 'Bh', 7, 0, 51460, 0, 0),
(165, 'J-P-H-2', 'PEMBERSIHAN HANHOLE TYPE 2 (180 cm x 100 cm x 160 cm ) untuk pekerjaan Mitratel', 'Bh', 7, 0, 64350, 0, 0),
(166, 'TTP-MH', 'PENGGANTIAN TUTUP MH (95cm x 95 cm) BETON untuk pekerjaan Mitratel', 'Unit', 7, 1284000, 475000, 0, 0),
(167, 'LHR-MH', 'PENINGGIAN LEHER MH untuk pekerjaan Mitratel', 'Unit', 7, 766800, 778300, 0, 0),
(168, 'GT-HH1-TTP3', 'PENGGANTIAN TUTUP HH TYPE 1 TUTUP-3  untuk pekerjaan Mitratel', 'unit', 7, 1672000, 482300, 0, 0),
(169, 'GT-HH2-TTP2', 'PENGGANTIAN TUTUP HH TYPE 2 TUTUP-2 untuk pekerjaan Mitratel', 'Unit', 7, 2616000, 482300, 0, 0),
(170, 'HH-PIT-P-HA', 'PEKERJAAN PEMBUATAN HH PIT PORTABLE HOME ACCESS  BESERTA AKSESORISNYA UKURAN DIMENSI (PXLXT= 40 X 40 X 70) untuk pekerjaan Mitratel', 'Unit', 7, 669900, 189800, 0, 0),
(171, 'HH-PIT-P-ODC', 'PEKERJAAN PEMBUATAN HH PIT PORTABLE ODC BESERTA AKSESORISNYA UKURAN DIMENSI (PXLXT=100 X 100 X 120) untuk pekerjaan Mitratel', 'Unit', 7, 7740000, 534200, 0, 0),
(172, 'MH-HH1', 'PEKERJAAN PEMBUATAN HANDHOLE TYPE HH1 UKURAN DIMENSI DALAM (P X L X T = 170X150X165) COR BETON 1 : 2 : 3  untuk pekerjaan Mitratel', 'Unit', 7, 5341000, 2810000, 0, 0),
(173, 'J-ODC-LAB', 'PELABELAN CORE untuk pekerjaan Mitratel', 'Core', 7, 0, 2600, 0, 0),
(174, 'ODC-KEY', 'PENGGANTIAN KUNCI NODE UKURAN  70MM untuk pekerjaan Mitratel', 'pcs', 7, 336200, 25030, 0, 0),
(175, 'ODS-SAFE-144', 'PEMASANGAN KERANGKENG ODC 144 (TERMASUK KUNCI UKURAN  70MM) untuk pekerjaan Mitratel', 'pcs', 7, 1633000, 701100, 0, 0),
(176, 'ODS-SAFE-288', 'PEMASANGAN KERANGKENG ODC 288  (TERMASUK KUNCI  UKURAN  70MM) untuk pekerjaan Mitratel', 'pcs', 7, 1825000, 751200, 0, 0),
(177, 'J-ODC-VA-PORT', 'VALIDASI PORT ODC untuk pekerjaan Mitratel', 'Port', 7, 0, 10590, 0, 0),
(178, 'J-ODC-PP', 'PEMBONGKARAN ODC KAP 144-288 BERIKUT PATOK PENGAMAN  untuk pekerjaan Mitratel', 'unit', 7, 0, 3891000, 0, 0),
(179, 'ODC-CATKABINET', 'PENGECATAN ULANG KABINET untuk pekerjaan Mitratel', 'm2', 7, 283400, 31960, 0, 0),
(180, 'ODC-CATDDKKAB', 'PENGECATAN DUDUKAN KABINET untuk pekerjaan Mitratel', 'm2', 7, 72730, 31470, 0, 0),
(181, 'ODC-P-3-IN', 'PENGADAAN DAN PEMASANGAN RISER PIPE UNTUK PENGAMAN KABEL OPTIK KE ODC POLE / TITIK NAIK KU DIAMATER 3 INCH  PANJANG 3 METER untuk pekerjaan Mitratel', 'unit', 7, 122800, 66380, 0, 0),
(182, 'ODC-P-4-IN', 'PENGADAAN DAN PEMASANGAN RISER PIPE UNTUK PENGAMAN KABEL OPTIK KE ODC POLE / TITIK NAIK KU DIAMATER 4 INCH  PANJANG 3 METER untuk pekerjaan Mitratel', 'unit', 7, 188900, 66380, 0, 0),
(183, 'J-G-ODC-C-96', 'PENGGESERAN KABINET ODC (OUTDOOR) KAP 96 CORE (PEMBONGKARAN DAN PEMASANGAN KEMBALI TANPA MERUBAH ATAU MENGGANTI ALPRO) tidak termasuk penyambungan kabel untuk pekerjaan Mitratel', 'unit', 7, 0, 9413000, 0, 0),
(184, 'J-G-ODC-C-144', 'PENGGESERAN KABINET ODC (OUTDOOR) KAP 144 CORE (PEMBONGKARAN DAN PEMASANGAN KEMBALI TANPA MERUBAH ATAU MENGGANTI ALPRO) tidak termasuk penyambungan kabel untuk pekerjaan Mitratel', 'Pcs', 7, 0, 10030000, 0, 0),
(185, 'J-G-ODC-C-288', 'PENGGESERAN KABINET ODC (OUTDOOR) KAP 288 CORE (PEMBONGKARAN DAN PEMASANGAN KEMBALI TANPA MERUBAH ATAU MENGGANTI ALPRO) tidak termasuk penyambungan kabel untuk pekerjaan Mitratel', 'Pcs', 7, 0, 10080000, 0, 0),
(186, 'J-G-ODC-C-576', 'PENGGESERAN KABINET ODC (OUTDOOR) KAP 576 CORE (PEMBONGKARAN DAN PEMASANGAN KEMBALI TANPA MERUBAH ATAU MENGGANTI ALPRO) tidak termasuk penyambungan kabel untuk pekerjaan Mitratel', 'Pcs', 7, 0, 10180000, 0, 0),
(187, 'ODP-KEY', 'PENGGANTIAN KUNCI ODP untuk pekerjaan Mitratel', 'Bh', 7, 24000, 11830, 0, 0),
(188, 'ODP-TIANG', 'PENGECATAN BRANDING TIANG WARNA MERAH SILVER untuk pekerjaan Mitratel', 'Btg', 7, 0, 19730, 0, 0),
(189, 'J-ODP-KOORD', 'MENGUKUR KOORDINAT DAN MENYERAHKANNYA KE TELKOM untuk pekerjaan Mitratel', 'titik', 7, 0, 12900, 0, 0),
(190, 'J-ODP-VA-PORT', 'VALIDASI PORT ODP untuk pekerjaan Mitratel', 'Port', 7, 0, 10590, 0, 0),
(191, 'TC-SM-96', 'PENGADAAN DAN PEMASANGAN OTB 96 CORE TERMASUK ADAPTER (SC CONNECTOR), PIGTAIL DAN PROTECTION SLEEVE PADA CASSETTE/BOX  untuk pekerjaan Mitratel', 'pcs', 7, 4211000, 6147000, 0, 0),
(192, 'J-G-ODP-PB-8', 'PENGGESERAN ODP TYPE OUTDOOR/WALL DAN POLE KAP 8 CORE (TANPA MERUBAH ATAU MENGGANTI ALPRO) untuk pekerjaan Mitratel', 'Pcs', 7, 0, 297500, 0, 0),
(193, 'J-G-ODP-PB-16', 'PENGGESERAN ODP TYPE OUTDOOR/WALL DAN POLE KAP 16 CORE (TANPA MERUBAH ATAU MENGGANTI ALPRO) untuk pekerjaan Mitratel', 'Pcs', 7, 0, 297500, 0, 0),
(194, 'J-G-ODP-SOLID-PB-8', 'PENGGESERAN ODP TYPE SOLID KAP 8 CORE (TANPA MERUBAH ATAU MENGGANTI ALPRO) untuk pekerjaan Mitratel', 'Pcs', 7, 0, 297500, 0, 0),
(195, 'J-G-ODP-SOLID-PB-16', 'PENGGESERAN ODP TYPE SOLID KAP 16 CORE (TANPA MERUBAH ATAU MENGGANTI ALPRO) untuk pekerjaan Mitratel', 'Pcs', 7, 0, 297500, 0, 0),
(196, 'DC-SOC', 'PENGADAAN DAN PEMASANGAN ADAPTOR SPLICE ON CONNECTOR (SOC) untuk pekerjaan Mitratel', 'pcs', 7, 36910, 52070, 0, 0),
(197, 'TRAY-MESH-4', 'WIRE MESH CABLE TRAY 40 X 10 CM, DENGAN SUPPORTING MATERIAL untuk pekerjaan Mitratel', 'Mtr', 7, 141600, 48640, 0, 0),
(198, 'MPOS', 'MARKING POS  (SSI PPJF) untuk pekerjaan Mitratel', 'pcs', 7, 51950, 18130, 0, 0),
(199, 'PC-APC-652-2', 'PENGADAAN PATCH CORD  2 METER, (FC/LC/SC-APC TO FC/LC/SC-APC), G.652 D untuk pekerjaan Mitratel', 'pcs', 7, 28300, 3140, 0, 0),
(200, 'PC-APC-655-2', 'PENGADAAN PATCH CORD  2 METER, (FC/LC/SC-APC TO FC/LC/SC-APC), G.655C untuk pekerjaan Mitratel', 'pcs', 7, 26290, 3140, 0, 0),
(201, 'PC-APC-657-2', 'PENGADAAN PATCH CORD 2  METER, (FC/LC/SC-APC TO FC/LC/SC-APC), G.657 untuk pekerjaan Mitratel', 'pcs', 7, 29200, 3020, 0, 0),
(202, 'PC-UPC-655-2', 'PENGADAAN PATCH CORD 2 METER, (FC/LC/SC-UPC TO FC/LC/SC-UPC), G.655C untuk pekerjaan Mitratel', 'pcs', 7, 26290, 3140, 0, 0),
(203, 'PC-UPC-657-2', 'PENGADAAN PATCH CORD 2  METER, (FC/LC/SC-UPC TO FC/LC/SC-UPC), G.657 untuk pekerjaan Mitratel', 'pcs', 7, 26810, 3140, 0, 0),
(204, 'PC-APC/UPC-657-A1', 'ADDITIONAL PATCH CORD, G.657-655-652-A1 untuk pekerjaan Mitratel', 'meter', 7, 2450, 1510, 0, 0),
(205, 'DC-OF-SM-288D', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 288 core G 652 D untuk pekerjaan Mitratel', 'meter', 7, 68320, 4370, 0, 0),
(206, 'DC-OF-SM-12C', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 12 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 11110, 3590, 0, 0),
(207, 'DC-OF-SM-24C', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 24 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 15840, 3590, 0, 0),
(208, 'DC-OF-SM-48C', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 48 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 25300, 3590, 0, 0),
(209, 'DC-OF-SM-96C', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 96 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 49310, 3590, 0, 0),
(210, 'AC-OF-SM-12C', 'Pengadaan dan pemasangan Kabel Udara Fiber Optik Single Mode 12 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 15250, 4970, 0, 0),
(211, 'AC-OF-SM-24C', 'Pengadaan dan pemasangan Kabel Udara Fiber Optik Single Mode 24 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 20530, 4970, 0, 0),
(212, 'AC-OF-SM-48C', 'Pengadaan dan pemasangan Kabel Udara Fiber Optik Single Mode 48 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 31810, 4970, 0, 0),
(213, 'AC-OF-SM-96C', 'Pengadaan dan pemasangan Kabel Udara Fiber Optik Single Mode 96 core G 655 C untuk pekerjaan Mitratel', 'meter', 7, 52780, 4970, 0, 0),
(214, 'DC-OF-SM-12-SC', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 12 core G 652 D, \"Easy to split\" untuk pekerjaan Mitratel', 'meter', 7, 11720, 3590, 0, 0),
(215, 'DC-OF-SM-24-SC', 'Pengadaan dan pemasangan Kabel Duct Fiber Optik Single Mode 24 core G 652 D, \"Easy to split\" untuk pekerjaan Mitratel', 'meter', 7, 16300, 3590, 0, 0),
(216, 'AC-OF-SM-8-SC', 'Pengadaan dan pemasangan Kabel Udara Fiber Optik Single Mode 8 core G 652 D, \"Easy to split\" untuk pekerjaan Mitratel', 'meter', 7, 11320, 5050, 0, 0),
(217, 'AC-OF-SM-12-SC', 'Pengadaan dan pemasangan Kabel Udara Fiber Optik Single Mode 12 core G 652 D, \"Easy to split\" untuk pekerjaan Mitratel', 'meter', 7, 6230, 4390, 0, 0),
(218, 'AC-OF-SM-24-SC', 'Pengadaan dan pemasangan Kabel Udara Fiber Optik Single Mode 24 core G 652 D, \"Easy to split\" untuk pekerjaan Mitratel', 'meter', 7, 7100, 4390, 0, 0),
(219, 'SC-OF-SM-288', 'Pengadaan dan pemasangan alat sambung (cabang/ lurus) untuk Fiber Optik kapasitas 12 - 288 core untuk pekerjaan Mitratel', 'pcs', 7, 1639000, 35380, 0, 0),
(220, 'Base Tray ODC', 'Pengadaan dan Pemasangan OTB termasuk terminasi dan penyambungan kabel optik Single mode kap 12 core serta Adapter (SC Connector), pigtail dan protection sleeve pada cassette/box untuk pekerjaan Mitratel', 'pcs', 7, 201300, 762000, 0, 0),
(221, 'ODP-PL-8', 'Pengadaan dan pemasangan ODP ( Pilar ) kap 8 core termasuk pigtail, berikut space 1 splitter (1:8), pelabelan penempelan QR code (disediakan oleh Telkom) untuk pekerjaan Mitratel', 'pcs', 7, 1642000, 143700, 0, 0),
(222, 'PS-1-2-ODC', 'Pengadaan dan pemasangan Passive Splitter 1:2, type modular SC/UPC, for ODC, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 164700, 35200, 0, 0),
(223, 'PS-1-4-ODC', 'Pengadaan dan pemasangan Passive Splitter 1:4, type modular SC/UPC, for ODC, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 215300, 35750, 0, 0),
(224, 'PS-1-8-ODP', 'Pengadaan dan pemasangan Passive Splitter 1:8, type modular SC/UPC, for ODP, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 300100, 35750, 0, 0),
(225, 'PS-1-16-ODP', 'Pengadaan dan pemasangan Passive Splitter 1:16, type modular SC/UPC, for ODP, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 382200, 35200, 0, 0),
(226, 'PS-2-2-ODC', 'Pengadaan dan pemasangan Passive Splitter 2:2, type modular SC/UPC, for ODC, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 561300, 35460, 0, 0),
(227, 'PS-2-4-ODC', 'Pengadaan dan pemasangan Passive Splitter 2:4, type modular SC/UPC, for ODC, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 293300, 35460, 0, 0),
(228, 'PS-2-8-ODX', 'Pengadaan dan pemasangan Passive Splitter 2:8, type modular SC/UPC, for ODC, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 576000, 33950, 0, 0),
(229, 'PS-1-32-ODX', 'Pengadaan dan pemasangan Passive Splitter 1:32, type modular SC/UPC, for ODC/ODP, termasuk pigtail untuk pekerjaan Mitratel', 'pcs', 7, 599100, 33950, 0, 0),
(230, 'DD-DA-S2', 'Pengadaan dan pemasangan pipa Duct menempel pada jembatan existing menggunakan Pipa Galvanis diamenter 100 mm, tebal 3,65 mm, 2 pipa untuk pekerjaan Mitratel', 'meter', 7, 552100, 502100, 0, 0),
(231, 'DD-DA-S4', 'Pengadaan dan pemasangan pipa Duct menempel pada jembatan existing menggunakan Pipa Galvanis diamenter 100 mm, tebal 3,65 mm, 4 pipa untuk pekerjaan Mitratel', 'meter', 7, 1104000, 1004000, 0, 0),
(232, 'DD-BSS-S2', 'Pengadaan dan pemasangan pipa Duct pada jembatan dengan self support berpenguatan menggunakan Pipa besi Galv 2 pipa, bentang 6 - 12 meter untuk pekerjaan Mitratel', 'meter', 7, 711100, 502100, 0, 0),
(233, 'DD-BTS-S2', 'Pengadaan dan pemasangan pipa Duct pada jembatan menggunakan Pipa besi Galv 2 pipa, bentang 6 - 12 meter untuk pekerjaan Mitratel', 'meter', 7, 708500, 502100, 0, 0),
(234, 'DD-BTS-S4', 'Pengadaan dan pemasangan pipa Duct pada jembatan menggunakan Pipa besi Galv 4 pipa, bentang 6 - 12 meter untuk pekerjaan Mitratel', 'meter', 7, 1408000, 761200, 0, 0),
(235, 'DD-BMR-2', 'Pengadaan dan Pemasangan Boring pada Lintasan Kereta Api menggunakan 2 pipa Galvanis diameter 100 mm tebal 3,65 mm untuk pekerjaan Mitratel', 'track', 7, 1656000, 34580000, 0, 0),
(236, 'DD-BMR-4', 'Pengadaan dan Pemasangan Boring pada Lintasan Kereta Api menggunakan 4 pipa Galvanis diameter 100 mm tebal 3,65 mm untuk pekerjaan Mitratel', 'track', 7, 3312000, 46100000, 0, 0),
(237, 'DC-SD-28-3', 'Pengadaan dan Pemasangan 1 Subduct 28/32 mm pada polongan route Duct, 3 pipa untuk pekerjaan Mitratel', 'meter', 7, 22710, 2220, 0, 0),
(238, 'DC-SD-33-1', 'Pengadaan dan Pemasangan 1 Subduct 40/33 pada polongan route Duct untuk pekerjaan Mitratel', 'meter', 7, 10270, 1720, 0, 0),
(239, 'DC-SD-33-2', 'Pengadaan dan Pemasangan 1 Subduct 40/33 pada polongan route Duct, 2 pipa untuk pekerjaan Mitratel', 'meter', 7, 20780, 2210, 0, 0),
(240, 'DC-SD-43-1', 'Pengadaan dan Pemasangan 1 Subduct 50/42 pada polongan route Duct untuk pekerjaan Mitratel', 'meter', 7, 18850, 1700, 0, 0),
(241, 'DC-SD-43-2', 'engadaan dan Pemasangan 1 Subduct 50/42 pada polongan route Duct, 2 pipa untuk pekerjaan Mitratel', 'meter', 7, 37730, 2210, 0, 0),
(242, 'DCD-PVC-1', 'Pengadaan dan Pemasangan Duct Cable Penanggal diameter pipa PVC 2 inch (Class AW) 1 pipa untuk pekerjaan Mitratel', 'meter', 7, 11620, 1680, 0, 0),
(243, 'DD-BM-100-2', 'Pengadaan dan Pemasangan Pipa galvanis dengan ukuran diameter 100 mm dan ketebalan 3,65 mm dengan cara boring manual /mesin 1 pipa dengan kedalaman minimal 150 cm, 2 pipa untuk pekerjaan Mitratel', 'meter', 7, 552100, 74780, 0, 0),
(244, 'DD-BM-50-1', 'Pengadaan dan Pemasangan Pipa galvanis dengan ukuran diameter 50 mm dan ketebalan 2,7 mm cara boring manual /mesin 1 pipa dengan kedalaman minimal 150 cm untuk pekerjaan Mitratel', 'meter', 7, 160900, 35990, 0, 0),
(245, 'DD-BM-50-2', 'Pengadaan dan Pemasangan Pipa galvanis dengan ukuran diameter 50 mm dan ketebalan 2,7 mm cara boring manual /mesin 2 pipa dengan kedalaman minimal 150 cm untuk pekerjaan Mitratel', 'meter', 7, 319900, 35990, 0, 0),
(246, 'DD-BM-HDPE-40-2', 'Pekerjaan Boring manual (rojok) HDPE 40/33 mm 2 pipa dengan kedalaman 1,5 meter untuk pekerjaan Mitratel', 'meter', 7, 0, 35580, 0, 0),
(247, 'DD-BM-HDPE-50-1', 'Pekerjaan Boring manual (rojok) HDPE 50/42 mm 1 pipa dengan kedalaman 1,5 meter untuk pekerjaan Mitratel', 'meter', 7, 0, 35930, 0, 0),
(248, 'DD-BM-HDPE-50-2', 'Pekerjaan Boring manual (rojok) HDPE 50/42 mm 2 pipa dengan kedalaman 1,5 meter untuk pekerjaan Mitratel', 'meter', 7, 0, 35930, 0, 0),
(249, 'DD-RV-CONCRETE', 'Pekerjaan bobok dinding MH / HH termasuk perbaikan kembali untuk pekerjaan Mitratel', 'm3', 7, 945000, 753200, 0, 0),
(250, 'Slack Support HH', 'Pengadaan dan Pemasangan Slack include sabuk ukuran dimensi dalam (P x L = 80cm x 80cm) untuk pekerjaan Mitratel', 'pcs', 7, 120700, 16160, 0, 0),
(251, 'Slack Support Chamber', 'Pengadaan dan Pemasangan Slack include sabuk ukuran dimensi dalam (P x L = 120cm x 120cm) untuk pekerjaan Mitratel', 'pcs', 7, 286900, 39460, 0, 0),
(252, 'RS-IN-SC-1P', 'Pemasangan dan terminasi Roset/Indoor Optical Outlet with SC Adaptor - kap 1 port berikut pigtail untuk pekerjaan Mitratel', 'Set', 7, 35400, 28650, 0, 0),
(253, 'Close Rack 12U', '19\" Wallmounted Rack 12U Depth 450mm untuk pekerjaan Mitratel', 'Unit', 7, 2993000, 653100, 0, 0),
(254, 'FC-SC-DC', 'Pengadaan dan pemasangan SC/UPC Connector for Drop / Indoor Cable (Fusion) untuk pekerjaan Mitratel', 'pcs', 7, 40490, 63140, 0, 0),
(255, 'Coring', 'Pekerjaan bobokan tembok/coring Cor Beton di ruang Shaft untuk pekerjaan Mitratel', 'titik', 7, 0, 870900, 0, 0),
(256, 'Rak Pasif spliter 1:4', '19 inch 24 core Pull type optical fiber distribution frame 24 port Rack Mounted Indoor fiber patch panel, Include RS232 Passive Splitter Rackmount Chassis - 2U untuk pekerjaan Mitratel', 'pcs', 7, 1426000, 457200, 0, 0),
(257, 'Label Kabel Distribusi (KU FO)', 'Pengadaan dan Pemasangan label kabel distribusi fo dengan material akrilik warna (P x L = 5cm x 15cm, tebal = 5 mm) untuk pekerjaan Mitratel', 'pcs', 7, 15820, 5450, 0, 0),
(258, 'FTM-BC-8F-10', 'FO Cord Bundled cable 8F, dengan connector satu sisi SC/LC/FC (L=10m), dan splicing di sisi lainnya untuk pekerjaan Mitratel', 'pcs', 7, 326000, 435800, 0, 0),
(259, 'FTM-BC-8F-1', 'Tambahan panjang cord bundled cable 8F untuk pekerjaan Mitratel', 'meter', 7, 5670, 1140, 0, 0),
(260, 'FTM-VR-90-Cover', 'Vertical raise 90 dan cover (4x4\") untuk pekerjaan Mitratel', 'pcs', 7, 485300, 63220, 0, 0),
(261, 'FTM-VR-45-Cover', 'Vertical raise 45 dan cover (4x4\") untuk pekerjaan Mitratel', 'pcs', 7, 509600, 63920, 0, 0),
(262, 'FTM-TF', 'Trumpet flare dan kit (4x4\") untuk pekerjaan Mitratel', 'pcs', 7, 194400, 63080, 0, 0),
(263, 'FTM-Connector-44', 'Connector 4x4\" untuk pekerjaan Mitratel', 'meter', 7, 85690, 10280, 0, 0),
(264, 'FTM-Exit-4', '4\" Express exit untuk pekerjaan Mitratel', 'pcs', 7, 434400, 63280, 0, 0),
(265, 'FTM-PC-Cover', 'Pemasangan jalur Patchcord 4x12\" lengkap cover untuk pekerjaan Mitratel', 'pcs', 7, 2194000, 69840, 0, 0),
(266, 'Tray-Mesh-2', 'Wire mesh cable tray 20 x 10 cm, dengan supporting material untuk pekerjaan Mitratel', 'Mtr', 7, 68310, 48640, 0, 0),
(267, 'Tray-Mesh-3', 'Wire mesh cable tray 30 x 10 cm, dengan supporting material untuk pekerjaan Mitratel', 'Mtr', 7, 101400, 48640, 0, 0),
(268, 'VSS-90-2', 'Vertical Support Structure rod (2m) maksimal sepasang (kiri-kanan), dengan kit instalasi (tiap 90cm) untuk pekerjaan Mitratel', 'Set', 7, 82590, 43640, 0, 0),
(269, 'Tray-Bundled-Out-30', 'Tray cable FO Cord bundled Outdoor 30x10 cm lengkap dengan penguat untuk pekerjaan Mitratel', 'Mtr', 7, 153400, 46250, 0, 0),
(270, 'Tray-Feeder-30', 'Tray cable feeder outdoor 30x10 cm lengkap dengan penguat untuk pekerjaan Mitratel', 'Mtr', 7, 165200, 46250, 0, 0),
(271, 'GC-NYAF-16', 'Kabel Grounding NYAF 16 mm untuk pekerjaan Mitratel', 'meter', 7, 28760, 2150, 0, 0),
(272, 'FTM-VA-Port', 'Validasi port FTM (Revitalisasi) untuk pekerjaan Mitratel', 'port', 7, 0, 10590, 0, 0),
(273, 'FTM-Label', 'Pelabelan FTM (Revitalisasi) untuk pekerjaan Mitratel', 'pcs', 7, 0, 1180, 0, 0),
(274, 'FTM-Plafon', 'Pekerjaan Plafon untuk pekerjaan Mitratel', 'm2', 7, 152700, 90530, 0, 0),
(275, 'FTM-Lantai', 'Pekerjaan Lantai untuk pekerjaan Mitratel', 'm2', 7, 69800, 138300, 0, 0),
(276, 'FTM-Dinding', 'Pekerjaan Dinding untuk pekerjaan Mitratel', 'm2', 7, 187900, 140600, 0, 0),
(277, 'Slack Support pole', 'Pengadaan dan Pemasangan Slack include sabuk ukuran dimensi dalam (P x L = 80cm x 80cm) Pada Tiang untuk pekerjaan Mitratel', 'pcs', 7, 120700, 16160, 0, 0),
(278, 'AC-OF-SM-1-3SL', 'Pengadaan Dan Pemasangan Drop Cable FO 1 Core Single Mode G.657 dengan Penguat 3 Seling untuk pekerjaan Mitratel', 'meter', 7, 1250, 1690, 0, 0),
(279, 'BR-HDPE', 'Pengadaan dan Pemasangan sistem bracket penopang HDPE dengan bahan plat besi galvanized (elektro) tebal 2 mm ukuran 40x17x4,2 cm (PxTxL) dengan 2 dynabolt stainless steel M10x70mm dan 9 cable ties ukuran 14,5 inch. untuk pekerjaan Mitratel', 'set', 7, 154100, 78380, 0, 0),
(280, 'PU-G6.0-35kg', 'Pengadaen den Pemasangan Tieng Besl Galvanls 6m tanpa sambungan, berlkut cat dan cor pondesl (1:2:3) dengan kekuetan tank 35kg untuk pekerjaan Mitratel', 'unit', 7, 1149000, 188300, 0, 0),
(281, 'HS-PS-Exist', 'Pengadaan den Pemasangan Slstem Gantung pads tiang ekslsting menggunaken kewet sling baja den klem due lubang untuk pekerjaan Mitratel', 'meter', 7, 25040, 11050, 0, 0),
(282, 'Tray-Mesh-PVC', 'Pengadaan dan pemasangan tray PVC wiring duct 45x65mm yang digunakan untuk jalur penarikan kabel fiber optik untuk pekerjaan Mitratel', 'meter', 7, 26490, 46260, 0, 0),
(283, 'PU-AS-HL', 'Pengadaan dan Pemasangan Aksesoris Tiang Helical Performed Grip untuk Kabel ADSS untuk pekerjaan Mitratel', 'pcs', 7, 16520, 8580, 0, 0);
INSERT INTO `tb_designator_khs` (`id`, `item_designator`, `item_description`, `unit`, `package_id`, `material_price_mitra`, `service_price_mitra`, `material_price_mtel`, `service_price_mtel`) VALUES
(284, 'BR-MUT-TY-1', 'Pengadaan dan Pemasangan Bracket Multi Utility Tunnel (MUT) Tipe-1 Lengkap (Plat Galvanized tebal 3 mm, horizontal, 13 lubang, finishing hot dipped, max 12 kabel) termasuk 3 pcs dynabolt (M10 panjang 7 cm tipe stainless steel 304) untuk pekerjaan Mitratel', 'set', 7, 207500, 75840, 0, 0),
(285, 'BR-MUT-TY-2', 'Pengadaan dan Pemasangan Bracket Multi Utility Tunnel (MUT) Tipe-2 Lengkap (Plat Galvanized tebal 2 mm, horizontal, 7 lubang, finishing hot dipped, max 6 kabel) termasuk 2 pcs dynabolt (M10 panjang 7 cm tipe stainless steel 304) untuk pekerjaan Mitratel', 'set', 7, 145000, 71490, 0, 0),
(286, 'BR-MUT-TY-3', 'Pengadaan dan Pemasangan Bracket Multi Utility Tunnel (MUT) Tipe-3 Lengkap (Plat Galvanized tebal 2 mm, vertical, 13 lubang, finishing hot dipped, max 12 kabel) termasuk 3 pcs dynabolt (M10 panjang 7 cm tipe stainless steel 304) untuk pekerjaan Mitratel', 'set', 7, 295000, 75840, 0, 0),
(287, 'BR-MUT-TY-4', 'Pengadaan dan Pemasangan Bracket Multi Utility Tunnel (MUT) Tipe-4 Lengkap (Plat Galvanized tebal 2 mm, vertical, 7 lubang, finishing hot dipped, max 6 kabel) termasuk 2 pcs dynabolt (M10 panjang 7 cm tipe stainless steel 304) untuk pekerjaan Mitratel', 'set', 7, 170000, 71490, 0, 0),
(288, 'HH-PIT-P-HA Concrete (Cor Beton)', 'Pekerjaan Pembuatan HH Pit Home Access beserta aksesorisnya dengan ukuran 40 x 40 CM untuk pekerjaan Mitratel', 'unit', 7, 669900, 189800, 0, 0),
(289, 'HH-PIT-P-ODP Concrete (Cor Beton)', 'Pekerjaan Pembuatan HH Pit Concrete ODP beserta aksesorisnya dengan ukuran 40 x 60 CM untuk pekerjaan Mitratel', 'unit', 7, 1635000, 283100, 0, 0),
(290, 'ODP Solid-PB-8 AS', 'Pengadaan dan pemasangan ODP type SOLID Kap 8 core adaptor SC/UPC terdiri dari 1 Box Spliter (termasuk 1 spliter 1:8), 1 Box Dummy beserta Accessories, berikut pelabelan dan penempelan QR code (disediakan oleh Telkom). Pemasangan ODP Pole dilengkapi dengan aksesoris instalasi yang terdiri dari 1 buah cooker (PVC 2 inch tipe AW sepanjang 1 meter) dan 2 buah klem (untuk penjepit cooker dan kabel) untuk pekerjaan Mitratel', 'pcs', 7, 678600, 160100, 0, 0),
(291, 'ODP Solid-PB-16 AS', 'Pengadaan dan pemasangan ODP type SOLID Kap 16 core adaptor SC/UPC terdiri dari 2 Box Spliter (termasuk 2 spliter 1:8), beserta aksesoris ODP, berikut pelabelan dan penempelan QR code (disediakan oleh Telkom). Pemasangan ODP Pole dilengkapi dengan aksesoris instalasi yang terdiri dari 1 buah cooker (PVC 2 inch tipe AW sepanjang 1 meter) dan 2 buah klem (untuk penjepit cooker dan kabel) untuk pekerjaan Mitratel', 'pcs', 7, 857400, 163200, 0, 0),
(292, 'PU-S7-1Segmen', 'Pengadaan Dan Pemasangan Tiang Besi 7 Meter tanpa sambungan, Berikut Cat & Cor Pondasi (1:2:3) dengan Kekuatan Tarik 140 Kg untuk pekerjaan Mitratel', 'btg', 7, 955300, 237600, 0, 0),
(293, 'ODC-P-96', 'Pengadaan dan pemasangan ODC Tiang (Pole-Mounted tanpa bordes) kap 96core dengan space untuk spliter modular termasuk material adaptor SC, pigtail, 10 slot kabel masuk, berikut pelabelan untuk pekerjaan Mitratel', 'unit', 7, 8353000, 4681000, 0, 0),
(294, 'PU-S6-OS-2', 'Pengadaan Dan Pemasangan Tiang Besi 6 Meter tanpa sambungan, Diameter 2\" dan Tebal 2,5 mm untuk pekerjaan Mitratel', 'btg', 7, 557200, 264600, 0, 0),
(295, 'PU-S6-OS-3', 'Pengadaan Dan Pemasangan Tiang Besi 6 Meter tanpa sambungan, Diameter 3\" dan Tebal 2,8 mm untuk pekerjaan Mitratel', 'btg', 7, 766700, 264600, 0, 0),
(296, 'AC-OF-SM-ADSS-6D', 'Pengadaan dan Pemasangan Kabel Udara Fiber Optik All Dieletric Self Supporting Cable (ADSS) Single Mode 6 Core untuk pekerjaan Mitratel', 'Meter', 7, 5180, 4240, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_employee`
--

CREATE TABLE `tb_employee` (
  `id` int(11) NOT NULL,
  `regional_id` int(11) NOT NULL DEFAULT 0,
  `witel_id` int(11) NOT NULL DEFAULT 0,
  `partner_id` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `nik` int(11) NOT NULL DEFAULT 0,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `chat_id` varchar(50) DEFAULT NULL,
  `number_phone` bigint(20) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL COMMENT '''Laki-Laki'',''Perempuan''',
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(50) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `google2fa_secret` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL COMMENT 'passwd#321',
  `ip_address` varchar(50) DEFAULT NULL,
  `log_latitude` varchar(100) DEFAULT NULL,
  `log_longitude` varchar(100) DEFAULT NULL,
  `log_otp_telegram` varchar(6) DEFAULT NULL,
  `log_otp_telegram_expired` datetime DEFAULT NULL,
  `log_otp_google2fa` varchar(6) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0 COMMENT '0: deactive, 1: active, 2: unregistered, 3: suspended',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_partner`
--

CREATE TABLE `tb_partner` (
  `id` int(11) NOT NULL,
  `witel_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  `alias` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_partner`
--

INSERT INTO `tb_partner` (`id`, `witel_id`, `name`, `alias`) VALUES
(1, 1, 'PT TELKOM INDONESIA', 'TI'),
(2, 1, 'PT TELEKOMUNIKASI SELULER', 'TSEL'),
(3, 1, 'PT DAYAMITRA TELEKOMUNIKASI', 'MTEL'),
(4, 1, 'PT TELKOM AKSES', 'TA'),
(5, 2, 'PT TELKOM INDONESIA', 'TI'),
(6, 2, 'PT TELEKOMUNIKASI SELULER', 'TSEL'),
(7, 2, 'PT DAYAMITRA TELEKOMUNIKASI', 'MTEL'),
(8, 2, 'PT TELKOM AKSES', 'TA'),
(9, 2, 'PT CITRA UTAMI INSANI', 'CUI'),
(10, 2, 'PT UPAYA TEHNIK', 'UPATEK'),
(11, 2, 'PT TATA BERLIAN NUSANTARA', 'TBN'),
(12, 2, 'PT TRIPOLA PANATA', 'TRIPOLA'),
(13, 3, 'PT TELKOM INDONESIA', 'TI'),
(14, 3, 'PT TELEKOMUNIKASI SELULER', 'TSEL'),
(15, 3, 'PT DAYAMITRA TELEKOMUNIKASI', 'MTEL'),
(16, 3, 'PT TELKOM AKSES', 'TA'),
(17, 4, 'PT TELKOM INDONESIA', 'TI'),
(18, 4, 'PT TELEKOMUNIKASI SELULER', 'TSEL'),
(19, 4, 'PT DAYAMITRA TELEKOMUNIKASI', 'MTEL'),
(20, 4, 'PT TELKOM AKSES', 'TA'),
(21, 4, 'PT INFORMASI CITRA CARAKA', 'ICC'),
(22, 4, 'PT TRIPOLA PANATA', 'TRIPOLA'),
(23, 5, 'PT TELKOM INDONESIA', 'TI'),
(24, 5, 'PT TELEKOMUNIKASI SELULER', 'TSEL'),
(25, 5, 'PT DAYAMITRA TELEKOMUNIKASI', 'MTEL'),
(26, 5, 'PT TELKOM AKSES', 'TA'),
(27, 6, 'PT TELKOM INDONESIA', 'TI'),
(28, 6, 'PT TELEKOMUNIKASI SELULER', 'TSEL'),
(29, 6, 'PT DAYAMITRA TELEKOMUNIKASI', 'MTEL'),
(30, 6, 'PT TELKOM AKSES', 'TA'),
(31, 7, 'PT TELKOM INDONESIA', 'TI'),
(32, 7, 'PT TELEKOMUNIKASI SELULER', 'TSEL'),
(33, 7, 'PT DAYAMITRA TELEKOMUNIKASI', 'MTEL'),
(34, 7, 'PT TELKOM AKSES', 'TA');

-- --------------------------------------------------------

--
-- Table structure for table `tb_project`
--

CREATE TABLE `tb_project` (
  `id` int(11) NOT NULL,
  `id_project` varchar(255) DEFAULT NULL,
  `name_project` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_regional`
--

CREATE TABLE `tb_regional` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `alias2` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_regional`
--

INSERT INTO `tb_regional` (`id`, `name`, `alias`, `alias2`) VALUES
(1, 'REGIONAL 1', NULL, 'REG-1'),
(2, 'REGIONAL 2', NULL, 'REG-2'),
(3, 'REGIONAL 3', NULL, 'REG-3'),
(4, 'REGIONAL 4', 'KALIMANTAN', 'REG-4'),
(5, 'REGIONAL 5', NULL, 'REG-5');

-- --------------------------------------------------------

--
-- Table structure for table `tb_report_materials`
--

CREATE TABLE `tb_report_materials` (
  `id` int(11) NOT NULL,
  `assign_order_id` int(11) DEFAULT NULL,
  `designator_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `coordinates_material` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_report_orders`
--

CREATE TABLE `tb_report_orders` (
  `id` int(11) NOT NULL,
  `assign_order_id` int(11) DEFAULT NULL,
  `status_qc_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `coordinates_site` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Direktur'),
(3, 'OSM'),
(4, 'GM_VP_PM'),
(5, 'Manager'),
(6, 'Officer_1'),
(7, 'Assistant_Manager'),
(8, 'Officer_2'),
(9, 'Head_of_Service_Area'),
(10, 'Officer_3'),
(11, 'Team_Leader'),
(12, 'Kordinator_Lapangan'),
(13, 'Staff'),
(14, 'Drafter'),
(15, 'Helpdesk'),
(16, 'Technician'),
(17, 'Sales_Force');

-- --------------------------------------------------------

--
-- Table structure for table `tb_source_diginav_mtel`
--

CREATE TABLE `tb_source_diginav_mtel` (
  `id` int(10) UNSIGNED NOT NULL,
  `no_spmk` varchar(100) DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `workorder` int(11) DEFAULT NULL,
  `ring_id` varchar(100) DEFAULT NULL,
  `project_id` varchar(50) DEFAULT NULL,
  `span_id` varchar(100) DEFAULT NULL,
  `regional` varchar(20) DEFAULT NULL,
  `witel` varchar(50) DEFAULT NULL,
  `site_ne` varchar(100) DEFAULT NULL,
  `old_site_ne` varchar(100) DEFAULT NULL,
  `site_name_ne` varchar(100) DEFAULT NULL,
  `site_owner_ne` varchar(100) DEFAULT NULL,
  `site_type_ne` varchar(50) DEFAULT NULL,
  `site_lat_ne` decimal(10,6) DEFAULT NULL,
  `site_long_ne` decimal(10,6) DEFAULT NULL,
  `site_fe` varchar(100) DEFAULT NULL,
  `old_site_fe` varchar(100) DEFAULT NULL,
  `site_name_fe` varchar(100) DEFAULT NULL,
  `site_owner_fe` varchar(100) DEFAULT NULL,
  `site_type_fe` varchar(50) DEFAULT NULL,
  `site_lat_fe` decimal(10,6) DEFAULT NULL,
  `site_long_fe` decimal(10,6) DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT 'low',
  `wo_by` varchar(50) DEFAULT NULL,
  `mno` varchar(50) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `work_day` int(11) DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `rfs_type` tinyint(4) DEFAULT 0,
  `panjang_kabel_bast` int(11) DEFAULT 0,
  `kabel_eks` int(11) DEFAULT 0,
  `plan_kabel` int(11) DEFAULT 0,
  `plan_kabel_new` int(11) DEFAULT 0,
  `real_kabel` int(11) DEFAULT 0,
  `plan_tiang` int(11) DEFAULT 0,
  `plan_tiang_ex` int(11) DEFAULT 0,
  `plan_tiang_new` int(11) DEFAULT 0,
  `real_tiang_new` int(11) DEFAULT 0,
  `real_tiang` int(11) DEFAULT 0,
  `rfs_plan` date DEFAULT NULL,
  `rfs_real` date DEFAULT NULL,
  `status_drm` date DEFAULT NULL,
  `anwizing` date DEFAULT NULL,
  `perijinan` date DEFAULT NULL,
  `testcomm` varchar(50) DEFAULT NULL,
  `uji_terima` varchar(50) DEFAULT NULL,
  `terminasi_odc_fe` date DEFAULT NULL,
  `terminasi_otb_fe` date DEFAULT NULL,
  `terminasi_odc_ne` date DEFAULT NULL,
  `terminasi_otb_ne` date DEFAULT NULL,
  `bast` varchar(50) DEFAULT NULL,
  `total_ach_delivery` decimal(8,3) DEFAULT 0.000,
  `total_ach_progress` decimal(8,3) DEFAULT 0.000,
  `last_update` datetime DEFAULT current_timestamp(),
  `overall` decimal(5,2) DEFAULT 0.00,
  `kendala_count` int(11) DEFAULT 0,
  `evidence_count` int(11) DEFAULT 0,
  `ach_kabel` decimal(5,2) DEFAULT 0.00,
  `ach_tiang` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_source_tacc_ticket_alita`
--

CREATE TABLE `tb_source_tacc_ticket_alita` (
  `id` int(11) NOT NULL,
  `create_ticket` tinyint(4) DEFAULT 0,
  `ticket_info` tinyint(4) DEFAULT 0,
  `treg` int(11) DEFAULT NULL,
  `witel` varchar(50) DEFAULT NULL,
  `tenant` varchar(50) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tt_parent` varchar(100) DEFAULT NULL,
  `prioritas` varchar(50) DEFAULT NULL,
  `service_area` varchar(100) DEFAULT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `site_down` varchar(50) DEFAULT NULL,
  `unik_site_down` varchar(50) DEFAULT NULL,
  `site_name_down` varchar(100) DEFAULT NULL,
  `type_site_down` varchar(50) DEFAULT NULL,
  `latitude_site_down` decimal(10,7) DEFAULT NULL,
  `longitude_site_down` decimal(10,7) DEFAULT NULL,
  `route_case` varchar(100) DEFAULT NULL,
  `tt_site` varchar(100) DEFAULT NULL,
  `tt_site_id` bigint(20) DEFAULT NULL,
  `customer_id` varchar(100) DEFAULT NULL,
  `span_id_tenant` varchar(100) DEFAULT NULL,
  `span_id_fsi` varchar(100) DEFAULT NULL,
  `tt_fsi` varchar(100) DEFAULT NULL,
  `area_fsi` varchar(100) DEFAULT NULL,
  `ring_id` varchar(100) DEFAULT NULL,
  `spand_id` varchar(100) DEFAULT NULL,
  `pid` varchar(100) DEFAULT NULL,
  `site_detect` varchar(50) DEFAULT NULL,
  `unik_site_detect` varchar(50) DEFAULT NULL,
  `site_name_detect` varchar(100) DEFAULT NULL,
  `type_site_detect` varchar(50) DEFAULT NULL,
  `condition` varchar(100) DEFAULT NULL,
  `severity` varchar(50) DEFAULT NULL,
  `sfp_type` varchar(50) DEFAULT NULL,
  `wafelength` int(11) DEFAULT 0,
  `rx_level_min` int(11) DEFAULT 0,
  `rx_level_max` int(11) DEFAULT 0,
  `id_pesan` varchar(100) DEFAULT NULL,
  `user_id_alita` bigint(20) DEFAULT 0,
  `nik_alita` varchar(50) DEFAULT NULL,
  `nama_alita` varchar(100) DEFAULT NULL,
  `telp_alita` varchar(20) DEFAULT NULL,
  `user_id_tacc` bigint(20) DEFAULT NULL,
  `nik_tacc` varchar(50) DEFAULT NULL,
  `nama_tacc` varchar(100) DEFAULT NULL,
  `telp_tacc` varchar(20) DEFAULT NULL,
  `tacc_nik` varchar(50) DEFAULT NULL,
  `tacc_nama` varchar(100) DEFAULT NULL,
  `tacc_telp` varchar(20) DEFAULT NULL,
  `tacc_user_id` bigint(20) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `insera_openat` datetime DEFAULT NULL,
  `assign_at` datetime DEFAULT NULL,
  `respond` varchar(50) DEFAULT NULL,
  `respond_at` datetime DEFAULT NULL,
  `stop_clock_start` varchar(100) DEFAULT NULL,
  `stop_clock_end` varchar(100) DEFAULT NULL,
  `stop_clock_hist` text DEFAULT NULL,
  `stop_clock` int(11) DEFAULT 0,
  `exclude_time` int(11) DEFAULT 0,
  `tiket_terima` datetime DEFAULT NULL,
  `tiba_disite` datetime DEFAULT NULL,
  `site_tiba` varchar(100) DEFAULT NULL,
  `req_close` datetime DEFAULT NULL,
  `req_close_first` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `cancelled_code` int(11) DEFAULT 0,
  `tech_close` datetime DEFAULT NULL,
  `status_at` datetime DEFAULT NULL,
  `pending` int(11) DEFAULT 0,
  `pending_ket` text DEFAULT NULL,
  `text_create` text DEFAULT NULL,
  `text_close` text DEFAULT NULL,
  `gaul` int(11) DEFAULT NULL,
  `ttr_tiket` int(11) DEFAULT NULL,
  `tt_respond` int(11) DEFAULT NULL,
  `tt_kelokasi` int(11) DEFAULT NULL,
  `tt_perbaikan` int(11) DEFAULT NULL,
  `ttr_sc` int(11) DEFAULT 0,
  `time_confirm_to_input_rsl` int(11) DEFAULT 0,
  `time_req_close_to_input_rsl` int(11) DEFAULT 0,
  `status_sla` varchar(50) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `hca` varchar(255) DEFAULT NULL,
  `hca_detail` text DEFAULT NULL,
  `rca` varchar(255) DEFAULT NULL,
  `rca_detail` text DEFAULT NULL,
  `hasil_perbaikan` text DEFAULT NULL,
  `penyebab_gangguan` text DEFAULT NULL,
  `detail_perbaikan` text DEFAULT NULL,
  `penggantian_material` text DEFAULT NULL,
  `penggantian_core` text DEFAULT NULL,
  `jenis_perbaikan` varchar(100) DEFAULT NULL,
  `penggantian_core_v2` text DEFAULT NULL,
  `penambahan_closure` text DEFAULT NULL,
  `clear_ttr` varchar(100) DEFAULT NULL,
  `timely_report` text DEFAULT NULL,
  `list_kendala` text DEFAULT NULL,
  `history_sc` text DEFAULT NULL,
  `send_tr` datetime DEFAULT NULL,
  `rsl` varchar(255) DEFAULT NULL,
  `status_rsl` varchar(255) DEFAULT NULL,
  `development` tinyint(4) DEFAULT 0,
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `regional` varchar(100) DEFAULT NULL,
  `ttr_net_time` time DEFAULT NULL,
  `ttr_net_hour` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_source_tacc_ticket_alita_detail`
--

CREATE TABLE `tb_source_tacc_ticket_alita_detail` (
  `id_log` bigint(20) UNSIGNED NOT NULL,
  `id` bigint(20) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `attachment_2` text DEFAULT NULL,
  `from_site` varchar(255) DEFAULT NULL,
  `status_evidence` int(11) DEFAULT NULL,
  `nik_tacc` varchar(255) DEFAULT NULL,
  `nama_tacc` varchar(255) DEFAULT NULL,
  `telp_tacc` varchar(255) DEFAULT NULL,
  `who` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `wordding` text DEFAULT NULL,
  `wordding_at` datetime DEFAULT NULL,
  `log_show` tinyint(1) DEFAULT NULL,
  `inserted_at` datetime DEFAULT NULL,
  `data_before` text DEFAULT NULL,
  `data_after` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_status_qc`
--

CREATE TABLE `tb_status_qc` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_status_qc`
--

INSERT INTO `tb_status_qc` (`id`, `name`) VALUES
(1, 'Planning_Need_Approve_TA'),
(2, 'Planning_Reject_TA'),
(3, 'Planning_Need_Approve_MTEL'),
(4, 'Permanenisasi_Need_Approve_TA'),
(5, 'Permanenisasi_Reject_TA'),
(6, 'Permanenisasi_Need_Approve_MTEL'),
(7, 'Permaneninsasi_Rekon');

-- --------------------------------------------------------

--
-- Table structure for table `tb_witel`
--

CREATE TABLE `tb_witel` (
  `id` int(11) NOT NULL,
  `regional_id` int(11) NOT NULL DEFAULT 0,
  `package_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `alias2` varchar(50) DEFAULT NULL,
  `scope` varchar(50) DEFAULT NULL,
  `chat_id` varchar(50) DEFAULT NULL,
  `thread_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_witel`
--

INSERT INTO `tb_witel` (`id`, `regional_id`, `package_id`, `name`, `alias`, `alias2`, `scope`, `chat_id`, `thread_id`) VALUES
(1, 4, NULL, 'REGIONAL', 'REGIONAL', 'REGIONAL', 'REGIONAL', NULL, NULL),
(2, 4, NULL, 'BANJARMASIN', 'KALSEL', 'KALSEL (BANJARMASIN)', 'KALSELTENG', '-1003029091111', '197'),
(3, 4, NULL, 'BALIKPAPAN', 'BALIKPAPAN', 'KALTIMSEL (BALIKPAPAN)', 'KALTIMTARA', '-1003029091111', '199'),
(4, 4, NULL, 'PALANGKARAYA', 'KALTENG', 'KALTENG (PALANGKARAYA)', 'KALSELTENG', '-1003029091111', '201'),
(5, 4, NULL, 'PONTIANAK', 'KALBAR', 'KALBAR (PONTIANAK)', 'KALBAR', '-1003029091111', '203'),
(6, 4, NULL, 'SAMARINDA', 'SAMARINDA', 'KALTIMTENG (SAMARINDA)', 'KALTIMTARA', '-1003029091111', '206'),
(7, 4, NULL, 'TARAKAN', 'KALTARA', 'KALTARA (TARAKAN)', 'KALTIMTARA', '-1003029091111', '208');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_assign_orders`
--
ALTER TABLE `tb_assign_orders`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `created_by_2` (`created_by`);

--
-- Indexes for table `tb_designator_khs`
--
ALTER TABLE `tb_designator_khs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `tb_employee`
--
ALTER TABLE `tb_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `nik` (`nik`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `witel_id` (`witel_id`),
  ADD KEY `regional_id` (`regional_id`),
  ADD KEY `role_id` (`role_id`) USING BTREE;

--
-- Indexes for table `tb_partner`
--
ALTER TABLE `tb_partner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `witel_id` (`witel_id`);

--
-- Indexes for table `tb_project`
--
ALTER TABLE `tb_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_regional`
--
ALTER TABLE `tb_regional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_report_materials`
--
ALTER TABLE `tb_report_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `designator_id` (`designator_id`);

--
-- Indexes for table `tb_report_orders`
--
ALTER TABLE `tb_report_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_orders_id` (`assign_order_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `status_qc_id` (`status_qc_id`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_source_diginav_mtel`
--
ALTER TABLE `tb_source_diginav_mtel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_source_tacc_ticket_alita`
--
ALTER TABLE `tb_source_tacc_ticket_alita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_witel` (`witel`),
  ADD KEY `idx_tt_site` (`tt_site`),
  ADD KEY `treg` (`treg`),
  ADD KEY `tt_site_id` (`tt_site_id`);

--
-- Indexes for table `tb_source_tacc_ticket_alita_detail`
--
ALTER TABLE `tb_source_tacc_ticket_alita_detail`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `tb_source_ticket_alita_detail_id_index` (`id`);

--
-- Indexes for table `tb_status_qc`
--
ALTER TABLE `tb_status_qc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_witel`
--
ALTER TABLE `tb_witel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regional_id` (`regional_id`),
  ADD KEY `name` (`name`),
  ADD KEY `package_id` (`package_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_assign_orders`
--
ALTER TABLE `tb_assign_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_designator_khs`
--
ALTER TABLE `tb_designator_khs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `tb_employee`
--
ALTER TABLE `tb_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_partner`
--
ALTER TABLE `tb_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=780;

--
-- AUTO_INCREMENT for table `tb_regional`
--
ALTER TABLE `tb_regional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_report_materials`
--
ALTER TABLE `tb_report_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_report_orders`
--
ALTER TABLE `tb_report_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_source_diginav_mtel`
--
ALTER TABLE `tb_source_diginav_mtel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_source_tacc_ticket_alita_detail`
--
ALTER TABLE `tb_source_tacc_ticket_alita_detail`
  MODIFY `id_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_status_qc`
--
ALTER TABLE `tb_status_qc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_witel`
--
ALTER TABLE `tb_witel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
