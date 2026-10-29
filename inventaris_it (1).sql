-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 27, 2026 at 01:47 PM
-- Server version: 5.7.39
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT '0',
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Tersedia','Dipinjam','Maintenance','Nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `foto`, `stok`, `kondisi`, `lokasi`, `status`, `created_at`, `updated_at`) VALUES
(1, '24323', 'Keyboard', '1786424474_Screenshot 2026-08-11 120100.png', 5, 'Baik', 'ROOM IT', 'Tersedia', '2026-07-28 05:20:58', '2026-10-12 03:39:43'),
(2, '39573', 'Mouse', '1786424405_Screenshot 2026-08-11 115931.png', 6, 'Baik', 'ROOM IT', 'Tersedia', '2026-07-28 18:14:46', '2026-10-15 03:54:51'),
(4, '26365', 'Monitor', '1785846286_MSI MP23SX White LED Monitor 24 Inch IPS 100Hz 1ms.jpe', 8, 'Baik', 'ROOM IT', 'Tersedia', '2026-07-29 20:48:04', '2026-10-12 03:39:43'),
(5, '23778', 'PC', '1785846352_Y70 X3D Ghost — RTX 5080, Ryzen 7 9800X3D, 32GB DDR5, 2TB SSD.jpe', 10, 'Baik', 'ROOM IT', 'Tersedia', '2026-08-03 06:23:47', '2026-10-12 03:41:30'),
(6, '123123', 'Headphone', '1788935612_Screenshot 2026-09-09 133244.png', 10, 'Baik', 'ROOM IT', 'Tersedia', '2026-08-11 06:37:48', '2026-10-12 02:03:06'),
(7, 'BRG-0007', 'Deskmate', '1788935466_Screenshot 2026-09-09 133046.png', 10, 'Baik', 'ROOM IT', 'Tersedia', '2026-08-12 06:07:08', '2026-10-12 03:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `peminjaman_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id`, `peminjaman_id`, `barang_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 31, 1, 1, '2026-08-03 06:34:36', '2026-08-03 06:34:36'),
(2, 31, 5, 1, '2026-08-03 06:34:36', '2026-08-03 06:34:36'),
(3, 32, 1, 1, '2026-08-03 06:38:07', '2026-08-03 06:38:07'),
(4, 32, 5, 1, '2026-08-03 06:38:07', '2026-08-03 06:38:07'),
(5, 33, 4, 1, '2026-08-03 07:06:16', '2026-08-03 07:06:16'),
(6, 34, 1, 1, '2026-08-03 18:47:41', '2026-08-03 18:47:41'),
(7, 34, 4, 1, '2026-08-03 18:47:41', '2026-08-03 18:47:41'),
(12, 37, 1, 1, '2026-08-03 19:57:38', '2026-08-03 19:57:38'),
(13, 37, 2, 1, '2026-08-03 19:57:38', '2026-08-03 19:57:38'),
(20, 41, 1, 1, '2026-08-03 23:59:57', '2026-08-03 23:59:57'),
(21, 41, 2, 1, '2026-08-03 23:59:57', '2026-08-03 23:59:57'),
(24, 43, 1, 1, '2026-08-04 08:15:31', '2026-08-04 08:15:31'),
(25, 43, 5, 1, '2026-08-04 08:15:31', '2026-08-04 08:15:31'),
(26, 44, 1, 1, '2026-08-05 01:24:19', '2026-08-05 01:24:19'),
(27, 44, 2, 2, '2026-08-05 01:24:19', '2026-08-05 01:24:19'),
(28, 45, 1, 3, '2026-08-05 03:23:30', '2026-08-05 03:23:30'),
(29, 45, 2, 1, '2026-08-05 03:23:30', '2026-08-05 03:23:30'),
(30, 45, 4, 1, '2026-08-05 03:23:30', '2026-08-05 03:23:30'),
(31, 45, 5, 1, '2026-08-05 03:23:30', '2026-08-05 03:23:30'),
(32, 46, 1, 1, '2026-08-06 04:52:09', '2026-08-06 04:52:09'),
(33, 46, 4, 1, '2026-08-06 04:52:09', '2026-08-06 04:52:09'),
(34, 47, 1, 1, '2026-08-10 03:19:02', '2026-08-10 03:19:02'),
(35, 47, 2, 1, '2026-08-10 03:19:02', '2026-08-10 03:19:02'),
(36, 48, 1, 1, '2026-08-11 06:27:25', '2026-08-11 06:27:25'),
(37, 48, 2, 1, '2026-08-11 06:27:25', '2026-08-11 06:27:25'),
(38, 49, 4, 1, '2026-08-11 06:31:22', '2026-08-11 06:31:22'),
(39, 50, 4, 1, '2026-08-11 06:40:38', '2026-08-11 06:40:38'),
(40, 51, 5, 1, '2026-08-11 06:41:15', '2026-08-11 06:41:15'),
(41, 52, 1, 1, '2026-08-12 03:21:23', '2026-08-12 03:21:23'),
(42, 53, 2, 3, '2026-08-12 04:15:05', '2026-08-12 04:15:05'),
(43, 53, 1, 3, '2026-08-12 04:15:05', '2026-08-12 04:15:05'),
(44, 54, 1, 1, '2026-08-12 04:23:37', '2026-08-12 04:23:37'),
(45, 55, 4, 1, '2026-08-19 11:58:14', '2026-08-19 11:58:14'),
(46, 56, 4, 1, '2026-08-19 12:37:46', '2026-08-19 12:37:46'),
(47, 57, 2, 1, '2026-08-19 12:49:10', '2026-08-19 12:49:10'),
(48, 58, 4, 1, '2026-08-19 12:57:12', '2026-08-19 12:57:12'),
(49, 59, 7, 1, '2026-08-20 02:38:46', '2026-08-20 02:38:46'),
(50, 60, 6, 2, '2026-08-22 04:55:28', '2026-08-22 04:55:28'),
(51, 61, 2, 1, '2026-08-24 02:17:36', '2026-08-24 02:17:36'),
(52, 62, 5, 3, '2026-09-08 06:53:15', '2026-09-08 06:53:15'),
(53, 63, 6, 2, '2026-09-09 06:52:04', '2026-09-09 06:52:04'),
(54, 63, 2, 1, '2026-09-09 06:52:04', '2026-09-09 06:52:04'),
(55, 64, 6, 1, '2026-09-24 01:39:55', '2026-09-24 01:39:55'),
(56, 64, 7, 1, '2026-09-24 01:39:55', '2026-09-24 01:39:55'),
(57, 64, 2, 1, '2026-09-24 01:39:55', '2026-09-24 01:39:55'),
(58, 65, 2, 1, '2026-09-24 02:13:58', '2026-09-24 02:13:58'),
(59, 65, 6, 1, '2026-09-24 02:13:58', '2026-09-24 02:13:58'),
(60, 66, 5, 1, '2026-09-24 02:29:49', '2026-09-24 02:29:49'),
(61, 66, 4, 1, '2026-09-24 02:29:49', '2026-09-24 02:29:49'),
(62, 67, 1, 1, '2026-09-24 02:41:08', '2026-09-24 02:41:08'),
(63, 67, 2, 1, '2026-09-24 02:41:08', '2026-09-24 02:41:08'),
(64, 68, 2, 1, '2026-09-24 04:11:54', '2026-09-24 04:11:54'),
(65, 68, 5, 1, '2026-09-24 04:11:54', '2026-09-24 04:11:54'),
(66, 69, 2, 1, '2026-09-30 03:58:26', '2026-09-30 03:58:26'),
(67, 69, 5, 1, '2026-09-30 03:58:26', '2026-09-30 03:58:26'),
(68, 69, 7, 1, '2026-09-30 03:58:26', '2026-09-30 03:58:26'),
(69, 69, 4, 1, '2026-09-30 03:58:26', '2026-09-30 03:58:26'),
(70, 69, 1, 1, '2026-09-30 03:58:26', '2026-09-30 03:58:26'),
(71, 70, 4, 1, '2026-09-30 04:10:35', '2026-09-30 04:10:35'),
(72, 71, 4, 1, '2026-09-30 04:18:40', '2026-09-30 04:18:40'),
(73, 72, 2, 1, '2026-09-30 04:47:03', '2026-09-30 04:47:03'),
(74, 73, 2, 1, '2026-09-30 05:01:28', '2026-09-30 05:01:28'),
(75, 74, 2, 1, '2026-09-30 06:05:44', '2026-09-30 06:05:44'),
(76, 75, 4, 1, '2026-09-30 06:34:58', '2026-09-30 06:34:58'),
(77, 76, 5, 1, '2026-09-30 06:41:41', '2026-09-30 06:41:41'),
(78, 77, 2, 1, '2026-09-30 07:43:36', '2026-09-30 07:43:36'),
(79, 78, 4, 1, '2026-09-30 08:27:41', '2026-09-30 08:27:41'),
(80, 79, 4, 1, '2026-09-30 08:30:23', '2026-09-30 08:30:23'),
(81, 80, 4, 1, '2026-09-30 08:30:28', '2026-09-30 08:30:28'),
(82, 81, 7, 1, '2026-09-30 08:32:45', '2026-09-30 08:32:45'),
(83, 82, 4, 1, '2026-10-02 06:54:02', '2026-10-02 06:54:02'),
(84, 82, 1, 1, '2026-10-02 06:54:02', '2026-10-02 06:54:02'),
(85, 83, 7, 1, '2026-10-02 07:08:47', '2026-10-02 07:08:47'),
(86, 83, 6, 1, '2026-10-02 07:08:47', '2026-10-02 07:08:47'),
(87, 84, 4, 1, '2026-10-12 03:38:31', '2026-10-12 03:38:31'),
(88, 84, 1, 1, '2026-10-12 03:38:31', '2026-10-12 03:38:31'),
(89, 85, 7, 1, '2026-10-12 03:40:56', '2026-10-12 03:40:56'),
(90, 85, 5, 1, '2026-10-12 03:40:56', '2026-10-12 03:40:56'),
(91, 86, 2, 2, '2026-10-14 02:10:25', '2026-10-14 02:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_28_063707_create_barangs_table', 1),
(5, '2026_07_28_065157_create_peminjaman_table', 1),
(6, '2026_07_28_065207_create_pengembalian_table', 1),
(7, '2026_07_28_072404_add_status_to_barang_table', 1),
(8, '2026_07_30_050317_create_notifikasis_table', 2),
(9, '2026_08_03_084637_create_detail_peminjamen_table', 3),
(10, '2026_08_04_070305_add_jumlah_to_detail_peminjaman_table', 4),
(11, '2026_08_04_155312_add_foto_to_barang_table', 5),
(12, '2026_08_11_134406_create_stok_masuk_table', 6),
(13, '2026_08_19_141310_add_nonaktif_status_to_barang_table', 7),
(14, '2026_08_19_142700_add_approved_by_to_peminjaman_table', 8),
(15, '2026_08_19_143051_add_processed_by_to_peminjaman_table', 9),
(16, '2026_08_19_193049_add_tanggal_kembali_jam_kembali_to_peminjaman_table', 10),
(17, '2026_08_20_090735_add_email_to_users_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `judul`, `pesan`, `dibaca`, `created_at`, `updated_at`) VALUES
(1, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor\" telah disetujui oleh Admin.', 1, '2026-07-29 23:12:18', '2026-07-29 23:55:21'),
(2, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui oleh Admin.', 1, '2026-07-29 23:17:04', '2026-07-29 23:55:21'),
(9, 2, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-07-30 19:16:21', '2026-07-30 19:16:40'),
(12, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-01 06:06:54', '2026-08-01 06:07:03'),
(13, 2, 'Pengembalian Disetujui', 'Pengembalian barang \"Mouse\" telah diterima Admin.', 1, '2026-08-01 06:38:29', '2026-08-01 06:45:57'),
(14, 4, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard\" telah disetujui.', 1, '2026-08-02 23:55:57', '2026-08-02 23:56:06'),
(15, 4, 'Pengembalian Disetujui', 'Pengembalian barang \"Keyboard\" telah diterima Admin.', 0, '2026-08-02 23:56:32', '2026-08-02 23:56:32'),
(16, 2, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-08-03 00:05:23', '2026-08-03 00:21:25'),
(17, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-03 01:08:09', '2026-08-03 01:08:52'),
(18, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-03 01:08:43', '2026-08-03 01:08:52'),
(19, 2, 'Pengembalian Disetujui', 'Pengembalian barang \"Mouse\" telah diterima Admin.', 1, '2026-08-03 01:09:35', '2026-08-03 01:33:36'),
(20, 2, 'Pengembalian Disetujui', 'Pengembalian barang \"Mouse\" telah diterima Admin.', 1, '2026-08-03 01:13:13', '2026-08-03 01:33:36'),
(21, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-03 01:34:09', '2026-08-03 01:36:21'),
(22, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-03 01:36:48', '2026-08-03 04:10:08'),
(24, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard\" telah disetujui.', 1, '2026-08-03 04:10:59', '2026-08-03 04:19:07'),
(25, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-03 04:11:03', '2026-08-03 04:19:07'),
(28, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, CPU\" telah disetujui.', 1, '2026-08-03 06:40:14', '2026-08-03 06:40:33'),
(29, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, CPU\" telah disetujui.', 1, '2026-08-03 06:40:18', '2026-08-03 06:40:33'),
(30, 2, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-08-03 07:07:08', '2026-08-03 07:08:52'),
(31, 2, 'Barang Dikembalikan', 'Barang \"Keyboard, CPU\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-03 07:23:10', '2026-08-03 07:25:46'),
(32, 2, 'Barang Dikembalikan', 'Barang \"Keyboard, CPU\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-03 07:23:22', '2026-08-03 07:25:46'),
(33, 2, 'Barang Dikembalikan', 'Barang \"\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-03 07:23:24', '2026-08-03 07:25:46'),
(34, 2, 'Barang Dikembalikan', 'Barang \"\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-03 07:23:27', '2026-08-03 07:25:46'),
(36, 2, 'Barang Dikembalikan', 'Barang \"\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-03 07:23:32', '2026-08-03 07:25:46'),
(37, 2, 'Barang Dikembalikan', 'Barang \"\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-03 07:23:35', '2026-08-03 07:25:46'),
(38, 2, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Keyboard, Monitor\" ditolak oleh Admin.', 1, '2026-08-03 19:36:16', '2026-08-03 19:36:44'),
(40, 2, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Keyboard, Mouse\" ditolak oleh Admin.', 1, '2026-08-03 20:04:04', '2026-08-03 20:36:58'),
(45, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, Mouse\" telah disetujui.', 1, '2026-08-04 00:00:42', '2026-08-04 00:49:16'),
(47, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, CPU\" telah disetujui.', 1, '2026-08-04 08:17:00', '2026-08-04 08:21:52'),
(49, 2, 'Barang Dikembalikan', 'Barang \"Keyboard, CPU\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-04 08:17:45', '2026-08-04 08:21:52'),
(50, 2, 'Barang Dikembalikan', 'Barang \"Keyboard, Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-04 08:17:47', '2026-08-04 08:21:52'),
(51, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, Mouse\" telah disetujui.', 1, '2026-08-05 01:25:52', '2026-08-05 01:26:22'),
(52, 2, 'Barang Dikembalikan', 'Barang \"Keyboard, Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-05 03:36:03', '2026-08-05 04:06:30'),
(53, 2, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Keyboard, Mouse, Monitor, PC\" ditolak oleh Admin.', 1, '2026-08-05 08:11:01', '2026-08-05 08:11:47'),
(54, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, Monitor\" telah disetujui.', 1, '2026-08-06 04:53:57', '2026-08-06 04:54:12'),
(55, 5, 'Barang Dikembalikan', 'Barang \"Keyboard, Monitor\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-06 04:55:58', '2026-08-06 06:39:01'),
(56, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, Mouse\" telah disetujui.', 1, '2026-08-10 03:20:00', '2026-08-10 03:47:46'),
(57, 5, 'Barang Dikembalikan', 'Barang \"Keyboard, Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-10 03:23:12', '2026-08-10 03:47:46'),
(58, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, Mouse\" telah disetujui.', 1, '2026-08-11 06:28:37', '2026-08-11 06:29:39'),
(59, 5, 'Barang Dikembalikan', 'Barang \"Keyboard, Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-11 06:31:12', '2026-08-12 03:21:17'),
(60, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-08-11 06:31:46', '2026-08-12 03:21:17'),
(61, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor\" telah disetujui.', 1, '2026-08-11 06:41:23', '2026-08-12 03:21:17'),
(62, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"PC\" telah disetujui.', 1, '2026-08-11 06:41:29', '2026-08-12 03:21:17'),
(63, 5, 'Barang Dikembalikan', 'Barang \"PC\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-11 06:55:44', '2026-08-12 03:21:17'),
(64, 5, 'Barang Dikembalikan', 'Barang \"Monitor\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-11 06:56:02', '2026-08-12 03:21:17'),
(65, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard\" telah disetujui.', 1, '2026-08-12 03:22:43', '2026-08-12 03:23:25'),
(66, 5, 'Barang Dikembalikan', 'Barang \"Keyboard\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-12 03:23:51', '2026-08-12 03:24:19'),
(67, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse, Keyboard\" telah disetujui.', 1, '2026-08-12 04:19:06', '2026-08-12 04:23:32'),
(68, 5, 'Barang Dikembalikan', 'Barang \"Mouse, Keyboard\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-12 04:22:13', '2026-08-12 04:23:32'),
(69, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Keyboard\" ditolak oleh Admin.', 1, '2026-08-12 04:23:57', '2026-08-12 04:41:15'),
(70, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor\" telah disetujui.', 1, '2026-08-19 11:59:53', '2026-08-19 12:29:05'),
(71, 5, 'Barang Dikembalikan', 'Barang \"Monitor\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-19 12:17:44', '2026-08-19 12:29:05'),
(72, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor\" telah disetujui.', 1, '2026-08-19 12:47:21', '2026-08-19 12:47:57'),
(73, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-19 12:49:49', '2026-08-19 12:57:18'),
(74, 5, 'Barang Dikembalikan', 'Barang \"Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-19 12:50:06', '2026-08-19 12:57:18'),
(75, 5, 'Barang Dikembalikan', 'Barang \"Monitor\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-19 12:50:12', '2026-08-19 12:57:18'),
(76, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-08-19 12:57:51', '2026-08-20 02:38:11'),
(77, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Deskmate\" telah disetujui.', 1, '2026-08-20 02:39:56', '2026-08-22 04:11:59'),
(78, 5, 'Barang Dikembalikan', 'Barang \"Deskmate\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-20 02:41:01', '2026-08-22 04:11:59'),
(79, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"yoyo\" ditolak oleh Admin.', 1, '2026-08-22 04:57:31', '2026-08-22 05:00:35'),
(80, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-08-24 02:19:09', '2026-08-24 02:21:47'),
(81, 5, 'Barang Dikembalikan', 'Barang \"Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-08-24 04:19:22', '2026-08-24 04:24:11'),
(82, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"PC\" telah disetujui.', 1, '2026-09-08 07:03:27', '2026-09-08 12:59:42'),
(83, 5, 'Barang Dikembalikan', 'Barang \"PC\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-09 06:37:14', '2026-09-09 06:59:51'),
(84, 8, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Headphone, Mouse\" telah disetujui.', 1, '2026-09-09 06:52:43', '2026-09-09 06:57:58'),
(85, 8, 'Barang Dikembalikan', 'Barang \"Headphone, Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-09 06:53:09', '2026-09-09 06:57:58'),
(86, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Headphone, Deskmate, Mouse\" ditolak oleh Admin.', 1, '2026-09-24 01:40:22', '2026-09-24 01:46:02'),
(87, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Mouse, Headphone\" ditolak oleh Admin.', 1, '2026-09-24 02:28:28', '2026-09-24 02:29:05'),
(88, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"PC, Monitor\" telah disetujui.', 1, '2026-09-24 02:35:14', '2026-09-24 02:40:38'),
(89, 5, 'Barang Dikembalikan', 'Barang \"PC, Monitor\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-24 02:40:23', '2026-09-24 02:40:38'),
(90, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Keyboard, Mouse\" telah disetujui.', 1, '2026-09-24 02:42:31', '2026-09-24 03:45:05'),
(91, 5, 'Barang Dikembalikan', 'Barang \"Keyboard, Mouse\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-24 03:15:59', '2026-09-24 03:45:05'),
(92, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse, PC\" telah disetujui.', 1, '2026-09-24 04:12:19', '2026-09-30 04:18:02'),
(93, 5, 'Barang Dikembalikan', 'Barang \"Mouse, PC\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-24 04:13:02', '2026-09-30 04:18:02'),
(94, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse, PC, Deskmate, Monitor, Keyboard\" telah disetujui.', 1, '2026-09-30 04:00:19', '2026-09-30 04:00:43'),
(95, 2, 'Barang Dikembalikan', 'Barang \"Mouse, PC, Deskmate, Monitor, Keyboard\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 04:03:13', '2026-09-30 04:10:21'),
(96, 2, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor\" telah disetujui.', 0, '2026-09-30 04:11:30', '2026-09-30 04:11:30'),
(97, 2, 'Barang Dikembalikan', 'Barang \"Monitor\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 0, '2026-09-30 04:11:42', '2026-09-30 04:11:42'),
(98, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor\" telah disetujui.', 1, '2026-09-30 04:20:26', '2026-09-30 04:46:53'),
(99, 5, 'Barang Dikembalikan', 'Barang \"Monitor x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 04:45:11', '2026-09-30 04:46:53'),
(100, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-09-30 04:47:43', '2026-09-30 04:48:25'),
(101, 5, 'Barang Dikembalikan', 'Barang \"Mouse x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 05:00:45', '2026-09-30 05:01:06'),
(102, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-09-30 05:01:56', '2026-09-30 06:05:24'),
(103, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-09-30 06:07:24', '2026-09-30 06:34:46'),
(104, 5, 'Barang Dikembalikan', 'Barang \"Mouse x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 06:08:11', '2026-09-30 06:34:46'),
(105, 5, 'Barang Dikembalikan', 'Barang \"Mouse x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 06:14:00', '2026-09-30 06:34:46'),
(106, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor\" telah disetujui.', 1, '2026-09-30 06:35:36', '2026-09-30 06:41:28'),
(107, 5, 'Barang Dikembalikan', 'Barang \"Monitor x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 06:41:16', '2026-09-30 06:41:28'),
(108, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"PC\" telah disetujui.', 1, '2026-09-30 06:42:04', '2026-09-30 06:45:37'),
(109, 5, 'Barang Dikembalikan', 'Barang \"PC x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 07:41:42', '2026-09-30 07:43:20'),
(110, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-09-30 07:43:54', '2026-09-30 08:27:30'),
(111, 5, 'Barang Dikembalikan', 'Barang \"Mouse x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 07:59:35', '2026-09-30 08:27:30'),
(112, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-09-30 08:29:34', '2026-09-30 08:30:10'),
(113, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-09-30 08:31:09', '2026-09-30 08:32:23'),
(114, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor\" ditolak oleh Admin.', 1, '2026-09-30 08:31:34', '2026-09-30 08:32:23'),
(115, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Deskmate\" telah disetujui.', 1, '2026-09-30 08:33:47', '2026-09-30 08:40:53'),
(116, 5, 'Barang Dikembalikan', 'Barang \"Deskmate x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-09-30 08:40:09', '2026-09-30 08:40:53'),
(117, 5, 'Peminjaman Ditolak', 'Pengajuan peminjaman barang \"Monitor, Keyboard\" ditolak oleh Admin.', 1, '2026-10-02 08:11:47', '2026-10-14 02:43:19'),
(118, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Deskmate, Headphone\" telah disetujui.', 1, '2026-10-02 08:11:56', '2026-10-14 02:43:19'),
(119, 5, 'Barang Dikembalikan', 'Barang \"Deskmate x1, Headphone x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-10-12 02:03:06', '2026-10-14 02:43:19'),
(120, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Monitor, Keyboard\" telah disetujui.', 1, '2026-10-12 03:38:54', '2026-10-14 02:43:19'),
(121, 5, 'Barang Dikembalikan', 'Barang \"Monitor x1, Keyboard x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-10-12 03:39:43', '2026-10-14 02:43:19'),
(122, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Deskmate, PC\" telah disetujui.', 1, '2026-10-12 03:41:13', '2026-10-14 02:43:19'),
(123, 5, 'Barang Dikembalikan', 'Barang \"Deskmate x1, PC x1\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 1, '2026-10-12 03:41:30', '2026-10-14 02:43:19'),
(124, 5, 'Peminjaman Disetujui', 'Pengajuan peminjaman barang \"Mouse\" telah disetujui.', 1, '2026-10-14 02:42:31', '2026-10-14 02:43:19'),
(125, 5, 'Barang Dikembalikan', 'Barang \"Mouse x2\" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.', 0, '2026-10-15 03:54:51', '2026-10-15 03:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `jam` time NOT NULL,
  `jam_kembali` time DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user_id`, `tanggal`, `tanggal_kembali`, `jam`, `jam_kembali`, `status`, `processed_by`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-07-28', NULL, '19:21:00', NULL, 'approved', NULL, NULL, '2026-07-28 05:21:24', '2026-07-28 05:21:49'),
(2, 2, '2026-07-28', NULL, '20:20:00', NULL, 'approved', NULL, NULL, '2026-07-28 06:20:38', '2026-07-28 06:21:06'),
(3, 2, '2026-07-29', NULL, '08:15:00', NULL, 'rejected', NULL, NULL, '2026-07-28 18:15:44', '2026-07-28 18:16:16'),
(6, 2, '2026-07-29', NULL, '11:01:00', NULL, 'approved', NULL, NULL, '2026-07-28 21:02:21', '2026-07-28 21:47:56'),
(8, 2, '2026-07-30', NULL, '10:26:00', NULL, 'approved', NULL, NULL, '2026-07-29 20:27:09', '2026-07-29 20:28:28'),
(9, 2, '2026-07-30', NULL, '10:29:00', NULL, 'approved', NULL, NULL, '2026-07-29 20:29:04', '2026-07-29 20:29:45'),
(12, 2, '2026-07-30', NULL, '13:10:00', NULL, 'approved', NULL, NULL, '2026-07-29 23:10:18', '2026-07-29 23:12:18'),
(13, 2, '2026-07-30', NULL, '13:15:00', NULL, 'approved', NULL, NULL, '2026-07-29 23:15:45', '2026-07-29 23:17:04'),
(17, 2, '2026-07-31', NULL, '09:16:00', NULL, 'rejected', NULL, NULL, '2026-07-30 19:16:08', '2026-07-30 19:16:21'),
(19, 2, '2026-08-01', NULL, '20:04:00', NULL, 'approved', NULL, NULL, '2026-08-01 06:05:06', '2026-08-01 06:06:54'),
(20, 2, '2026-08-03', NULL, '13:44:00', NULL, 'rejected', NULL, NULL, '2026-08-02 23:44:15', '2026-08-03 00:05:23'),
(21, 4, '2026-08-03', NULL, '18:00:00', NULL, 'approved', NULL, NULL, '2026-08-02 23:55:34', '2026-08-02 23:55:57'),
(22, 2, '2026-08-03', NULL, '15:07:00', NULL, 'approved', NULL, NULL, '2026-08-03 01:07:19', '2026-08-03 01:08:09'),
(23, 2, '2026-08-03', NULL, '15:08:00', NULL, 'approved', NULL, NULL, '2026-08-03 01:08:30', '2026-08-03 01:08:43'),
(24, 2, '2026-08-03', NULL, '15:33:00', NULL, 'approved', NULL, NULL, '2026-08-03 01:33:46', '2026-08-03 01:34:09'),
(25, 2, '2026-08-03', NULL, '15:36:00', NULL, 'approved', NULL, NULL, '2026-08-03 01:36:30', '2026-08-03 01:36:48'),
(27, 2, '2026-08-03', NULL, '18:10:00', NULL, 'approved', NULL, NULL, '2026-08-03 04:10:25', '2026-08-03 04:10:59'),
(28, 2, '2026-08-03', NULL, '18:10:00', NULL, 'approved', NULL, NULL, '2026-08-03 04:10:25', '2026-08-03 04:11:03'),
(31, 2, '2026-08-03', NULL, '20:34:00', NULL, 'approved', NULL, NULL, '2026-08-03 06:34:36', '2026-08-03 06:40:18'),
(32, 2, '2026-08-03', NULL, '20:38:00', NULL, 'approved', NULL, NULL, '2026-08-03 06:38:07', '2026-08-03 06:40:14'),
(33, 2, '2026-08-03', NULL, '21:06:00', NULL, 'rejected', NULL, NULL, '2026-08-03 07:06:16', '2026-08-03 07:07:08'),
(34, 2, '2026-08-04', NULL, '08:47:00', NULL, 'rejected', NULL, NULL, '2026-08-03 18:47:41', '2026-08-03 19:36:16'),
(37, 2, '2026-08-04', NULL, '09:57:00', NULL, 'rejected', NULL, NULL, '2026-08-03 19:57:38', '2026-08-03 20:04:04'),
(41, 2, '2026-08-04', NULL, '13:59:00', NULL, 'approved', NULL, NULL, '2026-08-03 23:59:57', '2026-08-04 00:00:42'),
(43, 2, '2026-08-04', NULL, '15:15:00', NULL, 'approved', NULL, NULL, '2026-08-04 08:15:31', '2026-08-04 08:17:00'),
(44, 2, '2026-08-05', NULL, '08:24:00', NULL, 'approved', NULL, NULL, '2026-08-05 01:24:19', '2026-08-05 01:25:52'),
(45, 2, '2026-08-05', NULL, '10:23:00', NULL, 'rejected', NULL, NULL, '2026-08-05 03:23:29', '2026-08-05 08:11:01'),
(46, 5, '2026-08-06', NULL, '11:50:00', NULL, 'approved', NULL, NULL, '2026-08-06 04:52:09', '2026-08-06 04:53:57'),
(47, 5, '2026-08-10', NULL, '10:18:00', NULL, 'approved', NULL, NULL, '2026-08-10 03:19:02', '2026-08-10 03:20:00'),
(48, 5, '2026-08-11', NULL, '13:24:00', NULL, 'approved', NULL, NULL, '2026-08-11 06:27:25', '2026-08-11 06:28:37'),
(49, 5, '2026-08-11', NULL, '13:31:00', NULL, 'rejected', NULL, NULL, '2026-08-11 06:31:22', '2026-08-11 06:31:46'),
(50, 5, '2026-08-11', NULL, '13:31:00', NULL, 'approved', NULL, NULL, '2026-08-11 06:40:38', '2026-08-11 06:41:23'),
(51, 5, '2026-08-11', NULL, '13:40:00', NULL, 'approved', NULL, NULL, '2026-08-11 06:41:15', '2026-08-11 06:41:29'),
(52, 5, '2026-08-12', NULL, '10:21:00', NULL, 'approved', NULL, NULL, '2026-08-12 03:21:23', '2026-08-12 03:22:43'),
(53, 5, '2026-08-12', NULL, '11:14:00', NULL, 'approved', NULL, NULL, '2026-08-12 04:15:05', '2026-08-12 04:19:06'),
(54, 5, '2026-08-12', NULL, '11:23:00', NULL, 'rejected', NULL, NULL, '2026-08-12 04:23:37', '2026-08-12 04:23:57'),
(55, 5, '2026-08-19', NULL, '18:56:00', NULL, 'approved', NULL, 1, '2026-08-19 11:58:14', '2026-08-19 11:59:53'),
(56, 5, '2026-08-19', '2026-08-26', '19:36:00', '11:30:00', 'approved', NULL, 1, '2026-08-19 12:37:46', '2026-08-19 12:47:21'),
(57, 5, '2026-08-20', '2026-09-02', '08:00:00', '10:00:00', 'approved', NULL, 1, '2026-08-19 12:49:10', '2026-08-19 12:49:49'),
(58, 5, '2026-08-19', '2026-08-19', '19:56:00', '22:03:00', 'rejected', NULL, 1, '2026-08-19 12:57:12', '2026-08-19 12:57:51'),
(59, 5, '2026-08-20', '2026-08-20', '09:38:00', '13:00:00', 'approved', NULL, 1, '2026-08-20 02:38:46', '2026-08-20 02:39:56'),
(60, 5, '2026-08-22', '2026-08-22', '11:54:00', '17:00:00', 'rejected', NULL, 1, '2026-08-22 04:55:28', '2026-08-22 04:57:31'),
(61, 5, '2026-08-24', '2026-08-24', '09:17:00', '13:00:00', 'approved', NULL, 1, '2026-08-24 02:17:36', '2026-08-24 02:19:09'),
(62, 5, '2026-09-08', '2026-09-08', '13:52:00', '16:00:00', 'approved', NULL, 1, '2026-09-08 06:53:15', '2026-09-08 07:03:27'),
(63, 8, '2026-09-09', '2026-09-09', '14:00:00', '16:00:00', 'approved', NULL, 1, '2026-09-09 06:52:04', '2026-09-09 06:52:43'),
(64, 5, '2026-09-24', '2026-09-24', '08:38:00', '12:00:00', 'rejected', NULL, 1, '2026-09-24 01:39:55', '2026-09-24 01:40:22'),
(65, 5, '2026-09-24', '2026-09-24', '09:13:00', '15:30:00', 'rejected', NULL, 1, '2026-09-24 02:13:58', '2026-09-24 02:28:28'),
(66, 5, '2026-09-24', '2026-09-24', '09:29:00', '12:30:00', 'approved', NULL, 1, '2026-09-24 02:29:49', '2026-09-24 02:35:14'),
(67, 5, '2026-09-24', '2026-09-24', '09:40:00', '15:00:00', 'approved', NULL, 1, '2026-09-24 02:41:08', '2026-09-24 02:42:31'),
(68, 5, '2026-09-24', '2026-09-24', '11:00:00', '13:00:00', 'approved', NULL, 1, '2026-09-24 04:11:54', '2026-09-24 04:12:19'),
(69, 2, '2026-09-30', '2026-09-30', '10:57:00', '17:00:00', 'approved', NULL, 7, '2026-09-30 03:58:26', '2026-09-30 04:00:19'),
(70, 2, '2026-09-30', '2026-09-30', '11:10:00', '11:13:00', 'approved', NULL, 7, '2026-09-30 04:10:35', '2026-09-30 04:11:30'),
(71, 5, '2026-09-30', '2026-09-30', '11:18:00', '11:20:00', 'approved', NULL, 1, '2026-09-30 04:18:40', '2026-09-30 04:20:26'),
(72, 5, '2026-09-30', '2026-09-30', '11:46:00', '11:50:00', 'approved', NULL, 1, '2026-09-30 04:47:03', '2026-09-30 04:47:43'),
(73, 5, '2026-09-30', '2026-09-30', '12:01:00', '12:05:00', 'approved', NULL, 1, '2026-09-30 05:01:28', '2026-09-30 05:01:56'),
(74, 5, '2026-09-30', '2026-09-30', '13:05:00', '13:10:00', 'approved', NULL, 1, '2026-09-30 06:05:44', '2026-09-30 06:07:24'),
(75, 5, '2026-09-30', '2026-09-30', '13:34:00', '13:40:00', 'approved', NULL, 7, '2026-09-30 06:34:58', '2026-09-30 06:35:36'),
(76, 5, '2026-09-30', '2026-09-30', '13:41:00', '13:45:00', 'approved', NULL, 1, '2026-09-30 06:41:41', '2026-09-30 06:42:04'),
(77, 5, '2026-09-30', '2026-09-30', '14:43:00', '14:45:00', 'approved', NULL, 1, '2026-09-30 07:43:36', '2026-09-30 07:43:54'),
(78, 5, '2026-09-30', '2026-09-30', '15:27:00', '15:30:00', 'rejected', NULL, 1, '2026-09-30 08:27:41', '2026-09-30 08:29:34'),
(79, 5, '2026-09-30', '2026-09-30', '15:30:00', '15:38:00', 'rejected', NULL, 1, '2026-09-30 08:30:23', '2026-09-30 08:31:09'),
(80, 5, '2026-09-30', '2026-09-30', '15:30:00', '15:38:00', 'rejected', NULL, 1, '2026-09-30 08:30:28', '2026-09-30 08:31:34'),
(81, 5, '2026-09-30', '2026-09-30', '15:32:00', '15:38:00', 'approved', NULL, 1, '2026-09-30 08:32:45', '2026-09-30 08:33:47'),
(82, 5, '2026-10-02', '2026-10-03', '14:00:00', '12:00:00', 'rejected', NULL, 1, '2026-10-02 06:54:02', '2026-10-02 08:11:47'),
(83, 5, '2026-10-02', '2026-10-02', '14:15:00', '18:00:00', 'approved', NULL, 1, '2026-10-02 07:08:47', '2026-10-02 08:11:56'),
(84, 5, '2026-10-12', '2026-10-13', '11:00:00', '00:00:00', 'approved', NULL, 1, '2026-10-12 03:38:31', '2026-10-12 03:38:54'),
(85, 5, '2026-10-12', '2026-10-13', '11:00:00', '11:00:00', 'approved', NULL, 1, '2026-10-12 03:40:56', '2026-10-12 03:41:13'),
(86, 5, '2026-10-14', '2026-10-14', '13:00:00', '18:00:00', 'approved', NULL, 1, '2026-10-14 02:10:25', '2026-10-14 02:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `peminjaman_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `nama_penerima` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `peminjaman_id`, `tanggal`, `jam`, `nama_penerima`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-07-28', '19:46:00', 'Pak Andi', 'approved', '2026-07-28 05:46:47', '2026-07-28 05:47:38'),
(2, 2, '2026-07-28', '20:21:00', 'Pak Yono', 'approved', '2026-07-28 06:21:49', '2026-07-28 06:22:22'),
(5, 6, '2026-07-29', '13:59:00', 'Pak Yono', 'approved', '2026-07-29 00:00:05', '2026-07-29 00:01:15'),
(7, 8, '2026-07-30', '10:30:00', 'Pak Yono', 'approved', '2026-07-29 20:30:33', '2026-07-29 20:30:53'),
(8, 9, '2026-07-30', '10:34:00', 'Pak Yono', 'approved', '2026-07-29 20:34:04', '2026-07-29 20:34:15'),
(9, 12, '2026-07-30', '13:35:00', 'Pak Yono', 'approved', '2026-07-29 23:35:55', '2026-07-29 23:36:33'),
(10, 13, '2026-07-30', '13:36:00', 'Pak Yono', 'approved', '2026-07-29 23:36:08', '2026-07-29 23:36:27'),
(15, 19, '2026-08-01', '20:07:00', 'Pak Hendro', 'approved', '2026-08-01 06:07:28', '2026-08-01 06:38:29'),
(16, 21, '2026-08-03', '13:56:00', 'Nata', 'approved', '2026-08-02 23:56:20', '2026-08-02 23:56:32'),
(17, 22, '2026-08-03', '15:09:00', 'Pak Adi', 'approved', '2026-08-03 01:09:20', '2026-08-03 01:09:35'),
(18, 23, '2026-08-03', '15:11:00', 'Pak Adi', 'approved', '2026-08-03 01:11:08', '2026-08-03 01:13:13'),
(19, 32, '2026-08-03', '14:23:00', 'Admin IT', 'approved', '2026-08-03 07:23:10', '2026-08-03 07:23:10'),
(20, 31, '2026-08-03', '14:23:00', 'Admin IT', 'approved', '2026-08-03 07:23:22', '2026-08-03 07:23:22'),
(21, 27, '2026-08-03', '14:23:00', 'Admin IT', 'approved', '2026-08-03 07:23:24', '2026-08-03 07:23:24'),
(22, 28, '2026-08-03', '14:23:00', 'Admin IT', 'approved', '2026-08-03 07:23:27', '2026-08-03 07:23:27'),
(24, 25, '2026-08-03', '14:23:00', 'Admin IT', 'approved', '2026-08-03 07:23:32', '2026-08-03 07:23:32'),
(25, 24, '2026-08-03', '14:23:00', 'Admin IT', 'approved', '2026-08-03 07:23:35', '2026-08-03 07:23:35'),
(27, 43, '2026-08-04', '15:17:00', 'Admin IT', 'approved', '2026-08-04 08:17:45', '2026-08-04 08:17:45'),
(28, 41, '2026-08-04', '15:17:00', 'Admin IT', 'approved', '2026-08-04 08:17:47', '2026-08-04 08:17:47'),
(29, 44, '2026-08-05', '10:36:00', 'Admin IT', 'approved', '2026-08-05 03:36:03', '2026-08-05 03:36:03'),
(30, 46, '2026-08-06', '11:55:00', 'Admin IT', 'approved', '2026-08-06 04:55:58', '2026-08-06 04:55:58'),
(31, 47, '2026-08-10', '10:23:00', 'Admin IT', 'approved', '2026-08-10 03:23:12', '2026-08-10 03:23:12'),
(32, 48, '2026-08-11', '13:31:00', 'Admin IT', 'approved', '2026-08-11 06:31:12', '2026-08-11 06:31:12'),
(33, 51, '2026-08-11', '13:55:00', 'Admin IT', 'approved', '2026-08-11 06:55:44', '2026-08-11 06:55:44'),
(34, 50, '2026-08-11', '13:56:00', 'Admin IT', 'approved', '2026-08-11 06:56:02', '2026-08-11 06:56:02'),
(35, 52, '2026-08-12', '10:23:00', 'Admin IT', 'approved', '2026-08-12 03:23:51', '2026-08-12 03:23:51'),
(36, 53, '2026-08-12', '11:22:00', 'Admin IT', 'approved', '2026-08-12 04:22:13', '2026-08-12 04:22:13'),
(37, 55, '2026-08-19', '19:17:00', 'Admin IT', 'approved', '2026-08-19 12:17:44', '2026-08-19 12:17:44'),
(38, 57, '2026-08-19', '19:50:00', 'Admin IT', 'approved', '2026-08-19 12:50:06', '2026-08-19 12:50:06'),
(39, 56, '2026-08-19', '19:50:00', 'Admin IT', 'approved', '2026-08-19 12:50:12', '2026-08-19 12:50:12'),
(40, 59, '2026-08-20', '09:41:00', 'Admin IT', 'approved', '2026-08-20 02:41:01', '2026-08-20 02:41:01'),
(41, 61, '2026-08-24', '11:19:00', 'Admin IT', 'approved', '2026-08-24 04:19:22', '2026-08-24 04:19:22'),
(42, 62, '2026-09-09', '13:37:00', 'Admin IT', 'approved', '2026-09-09 06:37:14', '2026-09-09 06:37:14'),
(43, 63, '2026-09-09', '13:53:00', 'Admin IT', 'approved', '2026-09-09 06:53:09', '2026-09-09 06:53:09'),
(44, 66, '2026-09-24', '09:40:00', 'Admin IT', 'approved', '2026-09-24 02:40:23', '2026-09-24 02:40:23'),
(45, 67, '2026-09-24', '10:15:00', 'Admin IT', 'approved', '2026-09-24 03:15:59', '2026-09-24 03:15:59'),
(46, 68, '2026-09-24', '11:13:00', 'Admin IT', 'approved', '2026-09-24 04:13:02', '2026-09-24 04:13:02'),
(47, 69, '2026-09-30', '11:03:00', 'Naufal Hanan Prihantoro', 'approved', '2026-09-30 04:03:13', '2026-09-30 04:03:13'),
(48, 70, '2026-09-30', '11:11:00', 'Naufal Hanan Prihantoro', 'approved', '2026-09-30 04:11:42', '2026-09-30 04:11:42'),
(49, 71, '2026-09-30', '11:45:00', 'Admin IT', 'approved', '2026-09-30 04:45:11', '2026-09-30 04:45:11'),
(50, 72, '2026-09-30', '12:00:00', 'Admin IT', 'approved', '2026-09-30 05:00:45', '2026-09-30 05:00:45'),
(51, 73, '2026-09-30', '13:08:00', 'Admin IT', 'approved', '2026-09-30 06:08:11', '2026-09-30 06:08:11'),
(52, 74, '2026-09-30', '13:14:00', 'Admin IT', 'approved', '2026-09-30 06:14:00', '2026-09-30 06:14:00'),
(53, 75, '2026-09-30', '13:41:00', 'Naufal Hanan Prihantoro', 'approved', '2026-09-30 06:41:16', '2026-09-30 06:41:16'),
(54, 76, '2026-09-30', '14:41:00', 'Admin IT', 'approved', '2026-09-30 07:41:42', '2026-09-30 07:41:42'),
(55, 77, '2026-09-30', '14:59:00', 'Admin IT', 'approved', '2026-09-30 07:59:35', '2026-09-30 07:59:35'),
(56, 81, '2026-09-30', '15:40:00', 'Admin IT', 'approved', '2026-09-30 08:40:09', '2026-09-30 08:40:09'),
(57, 83, '2026-10-12', '09:03:00', 'Admin IT', 'approved', '2026-10-12 02:03:06', '2026-10-12 02:03:06'),
(58, 84, '2026-10-12', '10:39:00', 'Admin IT', 'approved', '2026-10-12 03:39:43', '2026-10-12 03:39:43'),
(59, 85, '2026-10-12', '10:41:00', 'Admin IT', 'approved', '2026-10-12 03:41:30', '2026-10-12 03:41:30'),
(60, 86, '2026-10-15', '10:54:00', 'Admin IT', 'approved', '2026-10-15 03:54:51', '2026-10-15 03:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`id`, `barang_id`, `admin_id`, `jumlah`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 3, NULL, '2026-08-11 07:31:04', '2026-08-11 07:31:04'),
(2, 7, NULL, 1, NULL, '2026-09-08 02:32:15', '2026-09-08 02:32:15'),
(3, 4, NULL, 1, NULL, '2026-09-09 06:55:03', '2026-09-09 06:55:03'),
(4, 6, NULL, 9, NULL, '2026-09-24 03:35:45', '2026-09-24 03:35:45'),
(5, 5, NULL, 7, NULL, '2026-09-24 03:35:57', '2026-09-24 03:35:57'),
(6, 4, NULL, 6, NULL, '2026-09-24 03:36:10', '2026-09-24 03:36:10'),
(7, 2, NULL, 5, NULL, '2026-09-24 03:36:32', '2026-09-24 03:36:32'),
(8, 1, NULL, 3, NULL, '2026-09-24 03:36:49', '2026-09-24 03:36:49'),
(9, 7, NULL, 1, NULL, '2026-09-24 03:39:20', '2026-09-24 03:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `email`, `departemen`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin IT', 'Admin', NULL, 'IT', '$2y$12$tZ8T4W8WynFsXk/aAcX/5.yky12BfO.Y.YyPbK3RjuAacHCZA/rla', 'admin', NULL, '2026-07-28 05:18:00', '2026-08-11 05:02:45'),
(2, 'Andi', 'andi', NULL, 'Produksi', '$2y$12$1e3QQXMBblqthoZPFS577.MotzZnMkJFERNvLzSM96HPgmBEwnSau', 'user', NULL, '2026-07-28 05:18:00', '2026-08-19 04:05:39'),
(4, 'Aditya Nataprawira', 'nata', NULL, 'IT', '$2y$12$Y8iPjr2w/ZRm3iRJe0w9VOtHp.hW3TnFNzlbVxjRudXb2itROKFNe', 'user', NULL, '2026-08-02 23:54:31', '2026-08-02 23:54:31'),
(5, 'Morren Bangkit Alfatih', 'Morren', 'fatihmorren@gmail.com', 'IT', '$2y$12$Wj8FlXYnhn8MvdTrwYwOHuwjO0WSsEASN2qjHzkiiE40keffLVn92', 'user', NULL, '2026-08-06 04:49:52', '2026-08-20 02:37:47'),
(6, 'lala', 'yeye', NULL, 'PPIC', '$2y$12$MS.3XSucZMzBmODuDjHB4uzsOGd8q.SS6SetUhkl8AC6yJ0dkpx8G', 'user', NULL, '2026-08-11 06:35:03', '2026-08-11 06:35:03'),
(7, 'Naufal Hanan Prihantoro', 'Hanan', NULL, 'IT', '$2y$12$/TpwHbDwcr8.hZwrJpMMoOq441JZDl1UAyByPeSPxnX1cRub5TzOe', 'admin', NULL, '2026-08-12 04:53:13', '2026-08-19 04:03:03'),
(8, 'Dimas Fauzi Fardhan', 'Dimas', 'dimas123@gmail.com', 'Marketing', '$2y$12$SiucDLRAb8O3egZ0xlSOEOCgJKHSQQf.YUs3vclprC2yDXxBHLyI6', 'user', NULL, '2026-09-09 06:39:41', '2026-09-09 06:39:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barang_kode_barang_unique` (`kode_barang`);

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
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_peminjaman_peminjaman_id_foreign` (`peminjaman_id`),
  ADD KEY `detail_peminjaman_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

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
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasi_user_id_foreign` (`user_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_user_id_foreign` (`user_id`),
  ADD KEY `peminjaman_approved_by_foreign` (`approved_by`),
  ADD KEY `peminjaman_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengembalian_peminjaman_id_foreign` (`peminjaman_id`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stok_masuk_barang_id_foreign` (`barang_id`),
  ADD KEY `stok_masuk_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_peminjaman_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peminjaman_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD CONSTRAINT `stok_masuk_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stok_masuk_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
