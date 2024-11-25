-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 07:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`) VALUES
(3, 'yusuf@gmail.com', '$2y$10$QmTQZoaefVGKEMZJp6zPYu81lABzwsLamgiqtwgUisAg8A9OEfHzm'),
(4, 'admin@admin.com', '$2y$10$KhlsegRWvKyw0FUdwgiZA.IULhdeMVYKRHU/blgjGBgVQcBerm7wO');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `driver_option` enum('Dengan Sopir','Lepas Kunci') NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `return_location` varchar(255) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_konfirmasi` varchar(50) DEFAULT 'Belum Dikonfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `nama_lengkap`, `whatsapp`, `email`, `driver_option`, `pickup_location`, `return_location`, `pickup_date`, `return_date`, `created_at`, `status_konfirmasi`) VALUES
(47, 'jaki', '0812', 'yusuf@gmail.com', 'Dengan Sopir', 'cipedes', 'jakartas', '2024-11-18', '2024-11-20', '2024-11-18 08:00:39', 'Belum Dikonfirmasi'),
(48, 'jaki', '0812', 'yusuf@gmail.com', 'Dengan Sopir', 'cipedes', 'jakartas', '2024-11-18', '2024-11-20', '2024-11-18 08:06:52', 'Belum Dikonfirmasi'),
(49, 'jaki', '0812', 'yusuf@gmail.com', 'Dengan Sopir', 'cipedes', 'jakartas', '2024-11-18', '2024-11-20', '2024-11-18 08:07:19', 'Belum Dikonfirmasi'),
(50, 'jaki', '0812', 'yusuf@gmail.com', 'Dengan Sopir', 'cipedes', 'jakartas', '2024-11-18', '2024-11-20', '2024-11-18 08:07:44', 'Belum Dikonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `db_login_google`
--

CREATE TABLE `db_login_google` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `oauth_id` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_login_google`
--

INSERT INTO `db_login_google` (`userid`, `fullname`, `email`, `password`, `oauth_id`, `last_login`, `create_at`) VALUES
(1, 'Rifki Aditya Hariyanto', 'rifki10rpl1.2019@gmail.com', '', '103078445443165633090', '2024-11-19 17:48:10', '2024-11-19 10:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `kritiksaran`
--

CREATE TABLE `kritiksaran` (
  `id_kritik` int(10) NOT NULL,
  `namapengirim` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `kritiksaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kritiksaran`
--

INSERT INTO `kritiksaran` (`id_kritik`, `namapengirim`, `email`, `kritiksaran`) VALUES
(6, 'Ridwan Irwanda', 'ridwanirwandawangy@g', 'Kerja yang goblok');

-- --------------------------------------------------------

--
-- Table structure for table `login_admin`
--

CREATE TABLE `login_admin` (
  `id_admin` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_admin`
--

INSERT INTO `login_admin` (`id_admin`, `username`, `password`) VALUES
(1, 'rifki', '123');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `foto_mobil` varchar(255) NOT NULL,
  `nama_mobil` varchar(100) NOT NULL,
  `harga_per_hari` decimal(10,2) NOT NULL,
  `status` enum('tersedia','tidak tersedia') NOT NULL DEFAULT 'tersedia',
  `jumlah_unit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `foto_mobil`, `nama_mobil`, `harga_per_hari`, `status`, `jumlah_unit`) VALUES
(8, '673af7dc22214.png', 'Misubishi Xpander', 399000.00, 'tersedia', 2),
(11, '673af865d015e.png', 'Toyota Hilux', 459000.00, 'tersedia', 2),
(49, '673afa0d33fbb.png', 'Hyundai Palisade', 699000.00, 'tersedia', 1),
(50, '673afa4972a97.png', 'Toyota Pajero Sport', 699000.00, 'tersedia', 1),
(51, '673afa8ccd16d.png', 'Honda Jazz', 399000.00, 'tersedia', 4),
(52, '673afad0ba2ff.png', 'Suzuki Ertiga', 399000.00, 'tersedia', 2),
(53, '673afb3208f00.png', 'Toyota Agya', 299000.00, 'tersedia', 3),
(54, '673afb7156dac.png', 'Toyota Avanza', 399000.00, 'tersedia', 4),
(55, '673afba1aec24.png', 'Toyota Yaris', 399000.00, 'tersedia', 2),
(56, '673afbd55864a.png', 'Honda Brio', 299000.00, 'tersedia', 2),
(57, '673afc1d37229.png', 'Toyota Venturer', 599000.00, 'tersedia', 1),
(58, '673afc58e9038.png', 'Toyota Fortuner', 699000.00, 'tersedia', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_pesanan` enum('menunggu','diterima','ditolak') NOT NULL DEFAULT 'menunggu',
  `tagihan` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `id_mobil`, `tanggal_mulai`, `tanggal_selesai`, `status_pesanan`, `tagihan`) VALUES
(45, 2, 8, '2024-10-26', '2024-10-27', 'diterima', 300000.00),
(46, 2, 8, '2024-10-26', '2024-10-27', 'diterima', 300000.00),
(47, 2, 11, '2024-10-26', '2024-10-27', 'diterima', 250000.00),
(48, 4, 8, '2024-10-08', '2024-10-23', 'diterima', 4500000.00),
(49, 4, 8, '2024-10-30', '2024-11-09', 'menunggu', 3000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `sopir`
--

CREATE TABLE `sopir` (
  `id_sopir` int(11) NOT NULL,
  `nama_sopir` varchar(50) NOT NULL,
  `alamat_sopir` varchar(50) NOT NULL,
  `sim_sopir` varchar(255) NOT NULL,
  `status_sopir` enum('tersedia','tidak tersedia','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sopir`
--

INSERT INTO `sopir` (`id_sopir`, `nama_sopir`, `alamat_sopir`, `sim_sopir`, `status_sopir`) VALUES
(1, 'agus rahman', 'Bantar gerbang RT 10, RW 3', '', 'tersedia'),
(2, 'Sujiwo tejo', 'gedung waluh', '', 'tersedia'),
(3, 'siji telo', 'jagun rebus', '673a26679725e.png', 'tersedia'),
(4, 'Rodri Kusuma Khitman', 'Bojong Gede JL soedirman RT 01 RW 02', '673afcbe51702.png', 'tersedia'),
(5, 'Rosidin Purwanto', 'Dukuwaluh RT 10 RW 10', '673afd000135f.png', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `user1`
--

CREATE TABLE `user1` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(50) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user1`
--

INSERT INTO `user1` (`id`, `nama_depan`, `nama_belakang`, `email`, `password`) VALUES
(0, 'jaki', 'kuwuk', 'kuwuk@gmail.com', '$2y$10$BCRZLnxM6KeBFB68XKCbV.s./wdz0q8QGDzJn/Rpa4RBpulzivLqO'),
(0, 'jaki', 'kuwuk', 'kuwuk@gmail.com', '$2y$10$llzyBrc5qvM5TzELIVBd1OTFi03iqobs04dHC03SWseougUy2Wlpy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `db_login_google`
--
ALTER TABLE `db_login_google`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `kritiksaran`
--
ALTER TABLE `kritiksaran`
  ADD PRIMARY KEY (`id_kritik`);

--
-- Indexes for table `login_admin`
--
ALTER TABLE `login_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_mobil` (`id_mobil`);

--
-- Indexes for table `sopir`
--
ALTER TABLE `sopir`
  ADD PRIMARY KEY (`id_sopir`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `db_login_google`
--
ALTER TABLE `db_login_google`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kritiksaran`
--
ALTER TABLE `kritiksaran`
  MODIFY `id_kritik` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login_admin`
--
ALTER TABLE `login_admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sopir`
--
ALTER TABLE `sopir`
  MODIFY `id_sopir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
