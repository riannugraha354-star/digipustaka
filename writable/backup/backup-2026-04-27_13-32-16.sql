-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: duyek
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(150) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `cover` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'Laskar Pelangi','Andrea Hirata','Bentangg',2005,91,'1776708785_edc7c472f7998a2a95e1.jpg'),(2,'Bumi','Tere Liye','Gramedia',2014,45,'1776710441_ce1407a7cb1e7eec44ce.jpg'),(3,'Negeri 5 Menara','Ahmad Fuadi','Gramedia',2009,38,'1776710521_9b605140e999c44ffc2d.jpg'),(4,'Atomic Habits','James Clear','Penguin',2018,61,'1776710606_647297eed17f5275c9c3.jpg'),(5,'Rich Dad Poor Dad','Robert Kiyosaki','Warner Books',1997,24,'1776710737_d872b2dcc6eaf0f395b3.jpg'),(10,'Sewu Dino','SimpleMan',' PT Bukune Kreatif Cipta',2023,20,'1776710797_6ccd424f84cb0a6fada8.jpg'),(11,'Sabtu Bersama Bapak','Adhitya Mulya',' GagasMedia',2014,32,'1776710847_e0d281ebe77b34bf2ec0.jpg');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denda`
--

DROP TABLE IF EXISTS `denda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denda` (
  `id_denda` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjam` int(11) NOT NULL,
  `denda` int(11) NOT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `status` enum('belum_bayar','menunggu_verifikasi','lunas','ditolak') DEFAULT 'belum_bayar',
  `bukti` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_denda`),
  KEY `id_pinjam` (`id_pinjam`),
  CONSTRAINT `denda_ibfk_1` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman` (`id_pinjam`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denda`
--

LOCK TABLES `denda` WRITE;
/*!40000 ALTER TABLE `denda` DISABLE KEYS */;
INSERT INTO `denda` VALUES (5,141,3000,'Transfer','lunas','1777045752_75779db6ede0972e5dbf.png','2026-04-24 22:48:26','2026-04-24 22:49:27'),(6,128,1000,'Transfer','lunas','1777107985_f3fc0ae0642b162d3de7.png','2026-04-25 16:05:47','2026-04-25 16:06:36'),(7,127,1000,'Transfer','lunas','1777131277_64544251075932f8a18b.png','2026-04-25 22:34:07','2026-04-25 22:34:53'),(8,129,24000,'Transfer','lunas','1777199648_0733e29a86274829280b.png','2026-04-26 17:33:35','2026-04-26 17:34:24'),(11,148,19000,'Transfer','lunas','1777296192_b0653e9bfba9f7b820be.png','2026-04-27 20:22:30','2026-04-27 20:23:21'),(12,149,50000,NULL,'belum_bayar',NULL,'2026-04-27 20:24:55','2026-04-27 20:24:55');
/*!40000 ALTER TABLE `denda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('pending','dipinjam','menunggu_kembali','kembali','terdenda','denda_dibayar') DEFAULT 'dipinjam',
  `denda` int(11) DEFAULT 0,
  PRIMARY KEY (`id_pinjam`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (1,2,6,'2026-04-09','2026-04-16','',0),(9,2,6,'2026-04-09','2026-04-02','dipinjam',0),(124,2,2,'2026-04-21','2026-04-21','terdenda',0),(127,2,2,'2026-04-21','2026-04-24','terdenda',0),(128,2,4,'2026-04-21','2026-04-24','terdenda',0),(129,2,10,'2026-04-21','2026-04-02','terdenda',0),(131,2,15,'2026-04-22','2026-04-29','dipinjam',0),(133,3,2,'2026-04-22','2026-04-29','kembali',0),(134,2,15,'2026-04-22','2026-04-29','kembali',0),(136,2,15,'2026-04-23','2026-04-06','dipinjam',0),(137,2,1,'2026-04-01','2026-04-17','terdenda',0),(141,2,1,'2026-04-24','2026-04-21','terdenda',0),(143,2,1,'2026-04-26','2026-05-03','kembali',0),(144,2,3,'2026-04-26','2026-04-19','terdenda',0),(145,2,1,'2026-04-27','2026-05-04','dipinjam',0),(146,2,1,'2026-04-27','2026-05-04','kembali',0),(147,2,1,'2026-04-27','2026-04-20','terdenda',0),(148,2,1,'2026-04-27','2026-04-08','terdenda',0),(149,2,1,'2026-04-27','2026-03-08','terdenda',0),(150,3,1,'2026-04-27','2026-05-04','dipinjam',0);
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `password` varchar(100) NOT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'duyekadmin','duyekadmin','admin','$2y$10$FMQRdH0ecCbZZVWtN2n7/u1YZN/gr7X98Er4NG4sqDAWCXlZwmB6S',NULL,'1777133032_f195bdf9ea890f82b150.png'),(2,'duyekuser','duyekuser','user','$2y$10$YZTlqRLsL6Sd47ghu8xdK.z2FkukMl70S/R98Tq4fwhTlLbx1SDom',NULL,'1777132848_30bbd0bf1a3eb5e80cb5.png'),(3,'rian nugraha','kayla','user','$2y$10$.M9WdIX4RgytGIJ4G.Kf4uojf0Nt8noauUJgw9PI/oaiLIXC7r8vS',NULL,'1776876337_986a9c6d8c31df9b7480.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-27 20:32:17
