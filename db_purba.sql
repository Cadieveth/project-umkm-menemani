-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 12:13 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_purba`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_bakus`
--

CREATE TABLE `bahan_bakus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahan_bakus`
--

INSERT INTO `bahan_bakus` (`id`, `kode_barang`, `name`, `satuan`, `harga`, `created_at`, `updated_at`, `deleted_at`) VALUES
(91, 'PRDAWAL50541', 'Jeruk', 'Gram', 10, '2024-09-18 21:45:11', '2024-09-18 21:45:11', NULL),
(92, 'PRDAWAL93697', 'Botol', 'Unit', 500, '2024-09-18 21:45:36', '2024-09-18 21:45:36', NULL),
(93, 'PRDGram84201909', 'Jeruk', 'Gram', 20, '2024-09-18 21:46:11', '2024-09-18 21:46:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `harga` float NOT NULL,
  `jumlah_stok` int(25) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `ket` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `name`, `kode`, `harga`, `jumlah_stok`, `satuan`, `ket`, `created_at`, `updated_at`) VALUES
(57, 'Jeruk ABC', 'PRDAWAL10553', 7000, 5, 'PCS', 'Persediaan Produk Jadi', '2024-09-19', '2024-09-19'),
(58, 'Apel GG', 'PRDAWAL30688', 5000, 5, 'PCS', 'Persediaan Produk Jadi', '2024-09-19', '2024-09-19'),
(59, 'Jeruk', 'PRDAWAL50541', 10000, 5, 'Gram', 'Persediaan Bahan Baku', '2024-09-19', '2024-09-19'),
(60, 'Botol', 'PRDAWAL93697', 500, 20, 'Unit', 'Persediaan Bahan Baku', '2024-09-19', '2024-09-19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_keluar`
--

CREATE TABLE `kas_keluar` (
  `id` bigint(20) NOT NULL,
  `created_at` date NOT NULL,
  `akun` varchar(255) NOT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kas_keluars`
--

CREATE TABLE `kas_keluars` (
  `id` bigint(20) NOT NULL,
  `created_at` date NOT NULL,
  `akun` varchar(255) NOT NULL,
  `nominal` float NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_jurnal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akun_debet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` float NOT NULL,
  `hpp` float DEFAULT NULL,
  `akun_hpp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akun_kredit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kredit` float NOT NULL,
  `persediaan` float DEFAULT NULL,
  `akun_persediaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporans`
--

INSERT INTO `laporans` (`id`, `no_jurnal`, `ket`, `akun_debet`, `debit`, `hpp`, `akun_hpp`, `akun_kredit`, `kredit`, `persediaan`, `akun_persediaan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(229, 'JU855', 'TRS092024975154', 'Kas', 22050, 21000, 'HPP', 'Penjualan', 22050, 21000, 'Persediaan Barang Jadi', '2024-09-18 21:34:43', '2024-09-18 21:34:43', NULL),
(230, 'JU406', 'TRS092024685720', 'Kas', 23100, 22000, 'HPP', 'Penjualan', 23100, 22000, 'Persediaan Barang Jadi', '2024-09-18 21:34:56', '2024-09-18 21:34:56', NULL),
(231, 'JU169', 'TRS092024515772', 'Kas', 7350, 7000, 'HPP', 'Penjualan', 7350, 7000, 'Persediaan Barang Jadi', '2024-09-18 21:35:03', '2024-09-18 21:35:03', NULL),
(232, 'JU746', 'TRS092024284708', 'Kas', 10500, 10000, 'HPP', 'Penjualan', 10500, 10000, 'Persediaan Barang Jadi', '2024-09-18 21:35:09', '2024-09-18 21:35:09', NULL),
(233, 'JU446', 'Pembelian Bahan Baku (BM-01)', 'Persediaan Bahan Baku', 100000, NULL, NULL, 'Kas', 100000, NULL, NULL, '2024-09-18 21:46:11', '2024-09-18 21:46:11', NULL),
(234, 'JU530', 'Produksi Jeruk Peras A1 (SLL58591909)', 'Persediaan Barang Jadi (Jeruk, Botol)', 30000, NULL, NULL, 'Persediaan Bahan Baku', 30000, NULL, NULL, '2024-09-18 21:52:16', '2024-09-18 21:52:16', NULL),
(235, 'JU530', 'Produksi Jeruk Peras A1 (SLL58591909)', 'Persediaan Barang Jadi (Jeruk, Botol)', 20000, NULL, NULL, 'Hutang Gaji', 20000, NULL, NULL, '2024-09-18 21:52:16', '2024-09-18 21:52:16', NULL),
(236, 'JU637', 'TRS092024534066', 'Kas', 10500, 10000, 'HPP', 'Penjualan', 10500, 10000, 'Persediaan Barang Jadi', '2024-09-18 21:54:35', '2024-09-18 21:54:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `margin`
--

CREATE TABLE `margin` (
  `id` bigint(20) NOT NULL,
  `margin` int(25) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `margin`
--

INSERT INTO `margin` (`id`, `margin`, `created_at`, `updated_at`) VALUES
(3, 5, '2024-09-19', '2024-09-19');

-- --------------------------------------------------------

--
-- Table structure for table `masters`
--

CREATE TABLE `masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_16_064155_create_permission_tables', 1),
(6, '2024_05_18_102156_create_suppliers_table', 1),
(7, '2024_05_19_070207_create_stok_masuks_table', 1),
(8, '2024_05_19_074646_create_stok_keluars_table', 1),
(9, '2024_05_20_100252_create_order_stoks_table', 1),
(10, '2024_05_20_222010_create_reseps_table', 1),
(11, '2024_05_21_150539_create_transaksis_table', 1),
(12, '2024_06_19_190525_create_product_sells_table', 1),
(13, '2024_06_25_151641_create_settings_table', 1),
(14, '2024_07_23_075642_create_bahan_bakus_table', 1),
(15, '2024_07_23_103026_add_baku_id_to_stok_masuks_table', 1),
(16, '2024_07_23_103939_add_baku_id_to_stok_keluars_table', 1),
(17, '2024_07_23_125647_add_hpp_to_product_sells_table', 1),
(18, '2024_07_23_133758_create_laporans_table', 1),
(19, '2024_07_23_154647_create_masters_table', 1),
(20, '2024_08_08_221406_add_hppper_to_laporans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `neraca_awals`
--

CREATE TABLE `neraca_awals` (
  `id` bigint(20) NOT NULL,
  `akun_debet` varchar(255) DEFAULT NULL,
  `debit` float DEFAULT NULL,
  `akun_kredit` varchar(255) DEFAULT NULL,
  `kredit` float DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `neraca_awals`
--

INSERT INTO `neraca_awals` (`id`, `akun_debet`, `debit`, `akun_kredit`, `kredit`, `created_at`, `updated_at`) VALUES
(98, 'Kas', 1000000, NULL, NULL, '2024-09-19', '2024-09-19'),
(99, NULL, NULL, 'Modal', 1000000, '2024-09-19', '2024-09-19'),
(100, 'Persediaan Produk Jadi', 60000, NULL, 0, '2024-09-19', '2024-09-19'),
(101, NULL, 0, 'Laba/Rugi', -60000, '2024-09-19', '2024-09-19'),
(102, 'Persediaan Bahan Baku', 60000, NULL, 0, '2024-09-19', '2024-09-19');

-- --------------------------------------------------------

--
-- Table structure for table `order_stoks`
--

CREATE TABLE `order_stoks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baku_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `parent`, `created_at`, `updated_at`) VALUES
(1, 'dashboards', 'web', 1, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(2, 'users-list', 'web', 2, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(3, 'users-create', 'web', 2, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(4, 'users-edit', 'web', 2, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(5, 'users-delete', 'web', 2, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(6, 'product-list', 'web', 3, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(7, 'product-create', 'web', 3, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(8, 'product-edit', 'web', 3, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(9, 'product-delete', 'web', 3, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(10, 'order-list', 'web', 4, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(11, 'order-create', 'web', 4, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(12, 'order-edit', 'web', 4, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(13, 'order-delete', 'web', 4, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(14, 'transaksi-list', 'web', 5, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(15, 'transaksi-create', 'web', 5, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(16, 'transaksi-edit', 'web', 5, '2024-08-26 12:52:51', '2024-08-26 12:52:51'),
(17, 'transaksi-delete', 'web', 5, '2024-08-26 12:52:51', '2024-08-26 12:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sells`
--

CREATE TABLE `product_sells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_resep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hpp` float NOT NULL,
  `overhead` double DEFAULT NULL,
  `bb_keluar` double DEFAULT NULL,
  `qty_in` int(20) NOT NULL,
  `qty_out` int(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sells`
--

INSERT INTO `product_sells` (`id`, `no_resep`, `kode_product`, `nama_product`, `hpp`, `overhead`, `bb_keluar`, `qty_in`, `qty_out`, `created_at`, `updated_at`, `deleted_at`) VALUES
(79, 'RESA092024544953', 'PRDAWAL10553', 'Jeruk ABC', 7000, NULL, NULL, 5, 5, '2024-09-18 21:33:39', '2024-09-18 21:35:03', NULL),
(80, 'RESA092024491915', 'PRDAWAL30688', 'Apel GG', 5000, NULL, NULL, 5, 5, '2024-09-18 21:34:17', '2024-09-18 21:35:09', NULL),
(81, 'RES092024464180', 'SLL58591909', 'Jeruk Peras A1', 10000, 5000, 25000, 5, 1, '2024-09-18 21:52:16', '2024-09-18 21:54:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reseps`
--

CREATE TABLE `reseps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `baku_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_resep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(20) NOT NULL,
  `nama_resep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instruksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reseps`
--

INSERT INTO `reseps` (`id`, `baku_id`, `no_resep`, `qty`, `nama_resep`, `keterangan`, `instruksi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(60, '91', 'RES092024464180', 300, 'Jeruk Peras A', '-', '<p>-</p>', '2024-09-18 21:52:04', '2024-09-18 21:52:04', NULL),
(61, '92', 'RES092024464180', 1, 'Jeruk Peras A', '-', '<p>-</p>', '2024-09-18 21:52:04', '2024-09-18 21:52:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'web', '2024-08-26 12:52:50', '2024-08-26 12:52:50'),
(2, 'gudang', 'web', '2024-08-26 12:52:50', '2024-08-26 12:52:50'),
(3, 'produksi', 'web', '2024-08-26 12:52:50', '2024-08-26 12:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pimpinan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `company_name`, `image`, `alamat`, `pimpinan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'UMKM Menemani', 'UMKM Menemani Rempah Buah Kering', 'Screenshot_2024-08-22_103053.png_1724676876.png', 'Yogyakarta', 'Ibu Nana', '2024-08-26 12:52:52', '2024-08-26 12:54:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluars`
--

CREATE TABLE `stok_keluars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `baku_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_keluar` int(20) NOT NULL,
  `no_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_keluars`
--

INSERT INTO `stok_keluars` (`id`, `baku_id`, `stok_keluar`, `no_dokumen`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(106, '91', 1500, 'RES092024464180', 'Bahan Baku Produksi Resep', '2024-09-18 21:52:16', '2024-09-18 21:52:16', NULL),
(107, '92', 5, 'RES092024464180', 'Bahan Baku Produksi Resep', '2024-09-18 21:52:16', '2024-09-18 21:52:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuks`
--

CREATE TABLE `stok_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `baku_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_masuk` int(20) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_masuks`
--

INSERT INTO `stok_masuks` (`id`, `baku_id`, `supplier_id`, `invoice`, `stok_masuk`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(89, '91', '4', 'SA89', 5000, 'Saldo Awal', '2024-09-18 21:45:11', '2024-09-18 21:45:11', NULL),
(90, '92', '4', 'SA31', 20, 'Saldo Awal', '2024-09-18 21:45:36', '2024-09-18 21:45:36', NULL),
(91, '91', '4', 'BM-01', 5000, '-', '2024-09-18 21:46:11', '2024-09-18 21:46:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `alamat`, `email`, `kontak`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Ade', 'Kost Rumah Putih', 'adechris212@gmail.com', '0812312312412', '2024-08-29 16:18:10', '2024-08-29 16:18:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk_sell_id` bigint(20) NOT NULL,
  `no_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_barang` float NOT NULL,
  `qty` int(20) NOT NULL,
  `sub_total` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `produk_sell_id`, `no_transaksi`, `harga_barang`, `qty`, `sub_total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(32, '1', 79, 'TRS092024975154', 7350, 3, 22050, '2024-09-18 21:34:43', '2024-09-18 21:34:43', NULL),
(33, '1', 79, 'TRS092024685720', 7350, 1, 7350, '2024-09-18 21:34:56', '2024-09-18 21:34:56', NULL),
(34, '1', 80, 'TRS092024685720', 5250, 3, 15750, '2024-09-18 21:34:56', '2024-09-18 21:34:56', NULL),
(35, '1', 79, 'TRS092024515772', 7350, 1, 7350, '2024-09-18 21:35:03', '2024-09-18 21:35:03', NULL),
(36, '1', 80, 'TRS092024284708', 5250, 2, 10500, '2024-09-18 21:35:09', '2024-09-18 21:35:09', NULL),
(37, '1', 81, 'TRS092024534066', 10500, 1, 10500, '2024-09-18 21:54:35', '2024-09-18 21:54:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `gender`, `email_verified_at`, `password`, `role`, `profile`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '1', NULL, '$2y$12$vUyIEMR.1vHv7e0kNrbUIe7ESGbFVr4QYGK0RTuTZ0bbMjSvUlMou', '1', NULL, NULL, '2024-08-26 12:52:52', '2024-08-26 12:52:52', NULL),
(2, 'Gudangman', 'gudang@gmail.com', '1', NULL, '$2y$12$IlLVDSEWQHC4Rwl0Lva03.bwe4s4MDa.eAvS3Za6Wz.o1s6FGX6b6', '2', NULL, NULL, '2024-08-26 12:52:52', '2024-08-26 12:52:52', NULL),
(3, 'Produksi', 'produksi@gmail.com', '2', NULL, '$2y$12$Tdy6M1wtQ3jxWWBoYnZXrOuBKj9MxYYYzxXU/e/PWBsX9unBiQiBK', '3', NULL, NULL, '2024-08-26 12:52:52', '2024-08-26 12:52:52', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_bakus`
--
ALTER TABLE `bahan_bakus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_keluars`
--
ALTER TABLE `kas_keluars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `margin`
--
ALTER TABLE `margin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `neraca_awals`
--
ALTER TABLE `neraca_awals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_stoks`
--
ALTER TABLE `order_stoks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product_sells`
--
ALTER TABLE `product_sells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reseps`
--
ALTER TABLE `reseps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_keluars`
--
ALTER TABLE `stok_keluars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_masuks`
--
ALTER TABLE `stok_masuks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `bahan_bakus`
--
ALTER TABLE `bahan_bakus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_keluars`
--
ALTER TABLE `kas_keluars`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `margin`
--
ALTER TABLE `margin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `masters`
--
ALTER TABLE `masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `neraca_awals`
--
ALTER TABLE `neraca_awals`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `order_stoks`
--
ALTER TABLE `order_stoks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sells`
--
ALTER TABLE `product_sells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `reseps`
--
ALTER TABLE `reseps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stok_keluars`
--
ALTER TABLE `stok_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `stok_masuks`
--
ALTER TABLE `stok_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
