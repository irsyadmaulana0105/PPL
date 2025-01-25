-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2024 at 10:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pecos_menu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_menu` int NOT NULL,
  `nama` varchar(25) NOT NULL,
  `category` varchar(20) NOT NULL,
  `price` int NOT NULL,
  `total` int NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_item`
--

CREATE TABLE `history_item` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_menu` int NOT NULL,
  `nama` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `price` int NOT NULL,
  `total` int NOT NULL,
  `stock` int NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `history_item`
--

INSERT INTO `history_item` (`id`, `id_user`, `id_menu`, `nama`, `category`, `price`, `total`, `stock`, `create_at`) VALUES
(46, 3, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-16 12:01:37'),
(47, 3, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-16 12:01:37'),
(48, 3, 20, 'Risoles', 'snack', 5000, 5000, 1, '2024-06-16 12:01:37'),
(49, 3, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-16 12:01:37'),
(53, 3, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-16 12:18:34'),
(54, 3, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-16 12:20:28'),
(55, 2, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-16 23:16:53'),
(56, 2, 9, 'Teh Manis', 'drink', 5000, 5000, 1, '2024-06-16 23:16:53'),
(57, 2, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-17 04:51:52'),
(58, 2, 11, 'Jus Jeruk', 'drink', 12000, 12000, 1, '2024-06-17 04:51:52'),
(60, 1, 11, 'Jus Jeruk', 'drink', 12000, 24000, 2, '2024-06-17 06:05:54'),
(61, 1, 12, 'Es Kelapa', 'drink', 10000, 10000, 1, '2024-06-17 06:05:54'),
(62, 1, 3, 'Ayam Bakar', 'food', 25000, 25000, 1, '2024-06-17 06:05:54'),
(63, 1, 5, 'Nasi Liwet', 'food', 30000, 30000, 1, '2024-06-17 06:05:54'),
(64, 1, 2, 'Mie Goreng', 'food', 18000, 18000, 1, '2024-06-17 06:05:54'),
(65, 1, 20, 'Risoles', 'snack', 5000, 5000, 1, '2024-06-17 06:05:54'),
(66, 1, 19, 'Martabak', 'snack', 15000, 15000, 1, '2024-06-17 06:05:54'),
(67, 1, 11, 'Jus Jeruk', 'drink', 12000, 12000, 1, '2024-06-17 10:29:20'),
(68, 1, 10, 'Kopi Hitam', 'drink', 8000, 8000, 1, '2024-06-17 10:31:04'),
(69, 1, 13, 'Air Mineral', 'drink', 3000, 3000, 1, '2024-06-17 10:33:18'),
(70, 1, 11, 'Jus Jeruk', 'drink', 12000, 12000, 1, '2024-06-17 10:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `category`, `price`, `image`, `stock`) VALUES
(1, 'Nasi Goreng', 'food', 20000.00, 'img/nasi_goreng.png', 10),
(2, 'Mie Goreng', 'food', 18000.00, 'img/mie_goreng.png', 9),
(3, 'Ayam Bakar', 'food', 25000.00, 'img/ayam_bakar.png', 9),
(4, 'Sate Ayam', 'food', 22000.00, 'img/sate_ayam.png', 10),
(5, 'Nasi Liwet', 'food', 30000.00, 'img/nasi_liwet.png', 9),
(6, 'Bakso', 'food', 15000.00, 'img/bakso.png', 10),
(7, 'Gado-Gado', 'food', 17000.00, 'img/gado_gado.png', 10),
(9, 'Teh Manis', 'drink', 5000.00, 'img/teh_manis.png', 2),
(10, 'Kopi Hitam', 'drink', 8000.00, 'img/kopi_hitam.png', 8),
(11, 'Jus Jeruk', 'drink', 12000.00, 'img/jus_jeruk.png', -2),
(12, 'Es Kelapa', 'drink', 10000.00, 'img/es_kelapa.png', 9),
(13, 'Air Mineral', 'drink', 3000.00, 'img/air_mineral.png', 8),
(14, 'Teh Botol', 'drink', 6000.00, 'img/teh_botol.png', 10),
(16, 'Jus Alpukat', 'drink', 15000.00, 'img/jus_alpukat.png', 10),
(17, 'Keripik Singkong', 'snack', 7000.00, 'img/keripik_singkong.png\r\n', 10),
(18, 'Pisang Goreng', 'snack', 8000.00, 'img/pisang_goreng.png', 10),
(19, 'Martabak', 'snack', 15000.00, 'img/martabak.png', 8),
(20, 'Risoles', 'snack', 5000.00, 'img/risoles.png', 8),
(21, 'Onde-Onde', 'snack', 6000.00, 'img/onde_onde.png', 10),
(23, 'Batagor', 'snack', 10000.00, 'img/batagor.png', 10),
(24, 'Kue Cubit', 'snack', 8000.00, 'img/kue_cubit.png', 10);

-- --------------------------------------------------------

--
-- Table structure for table `process_items`
--

CREATE TABLE `process_items` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_menu` int NOT NULL,
  `nama` varchar(25) NOT NULL,
  `category` varchar(20) NOT NULL,
  `price` int NOT NULL,
  `total` int NOT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `id_meja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `generated_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_meja`, `generated_code`, `role`) VALUES
(28, '1', 'zbNuAZ9RRX', 'user'),
(29, '2', '1k4qQw4pXz', 'user'),
(30, 'ADMIN', 'OgxMJolEUh', 'employee'),
(36, 'alya', 'zXPxPdhEEZ', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','pegawai','admin') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(4, 'miil', 'miil@gmail.com', 'miil0', 'user'),
(5, 'admin', 'admin@gmail.com', 'admin0', 'pegawai'),
(1, 'akbar', 'akbar@gmail.com', 'akbar0', 'pegawai'),
(2, 'alya', 'alya@gmail.com', 'alya0', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_item`
--
ALTER TABLE `history_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `process_items`
--
ALTER TABLE `process_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `history_item`
--
ALTER TABLE `history_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `process_items`
--
ALTER TABLE `process_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
