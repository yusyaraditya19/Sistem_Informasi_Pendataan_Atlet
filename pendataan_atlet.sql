-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pendataan_atlet
CREATE DATABASE IF NOT EXISTS `pendataan_atlet` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pendataan_atlet`;

-- Dumping structure for table pendataan_atlet.atlet
CREATE TABLE IF NOT EXISTS `atlet` (
  `id_atlet` int NOT NULL AUTO_INCREMENT,
  `nama_atlet` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `cabang_olahraga` varchar(50) NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `kategori` varchar(30) NOT NULL,
  `tahun_bergabung` year NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id_atlet`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pendataan_atlet.atlet: ~0 rows (approximately)
INSERT INTO `atlet` (`id_atlet`, `nama_atlet`, `jenis_kelamin`, `tanggal_lahir`, `cabang_olahraga`, `nomor_telepon`, `kategori`, `tahun_bergabung`, `status`) VALUES
	(1, 'Yusya', 'Laki-laki', '2006-05-19', 'Taekwondo', '081367341087', 'Dewasa', '2024', 'Aktif'),
	(2, 'Raditya', 'Laki-laki', '2006-05-18', 'Basket', '081367341085', 'Dewasa', '2025', 'Aktif'),
	(3, 'Ujang', 'Laki-laki', '2022-12-07', 'Futsal', '081367341089', 'Dewasa', '2023', 'Tidak Aktif');

-- Dumping structure for table pendataan_atlet.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pendataan_atlet.users: ~0 rows (approximately)
INSERT INTO `users` (`id_user`, `username`, `password`) VALUES
	(1, 'admin', '$2y$12$9mu2sDPTHjiHtPQ1JEbOk.mtTVkUzwpqeJz0TL.8YdqyxySKhme9e');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
