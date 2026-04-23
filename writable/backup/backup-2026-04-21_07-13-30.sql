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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'Laskar Pelangi','Andrea Hirata','Bentangg',2005,94,'1776708785_edc7c472f7998a2a95e1.jpg'),(2,'Bumi','Tere Liye','Gramedia',2014,44,'1776710441_ce1407a7cb1e7eec44ce.jpg'),(3,'Negeri 5 Menara','Ahmad Fuadi','Gramedia',2009,37,'1776710521_9b605140e999c44ffc2d.jpg'),(4,'Atomic Habits','James Clear','Penguin',2018,61,'1776710606_647297eed17f5275c9c3.jpg'),(5,'Rich Dad Poor Dad','Robert Kiyosaki','Warner Books',1997,24,'1776710737_d872b2dcc6eaf0f395b3.jpg'),(10,'Sewu Dino','SimpleMan',' PT Bukune Kreatif Cipta',2023,20,'1776710797_6ccd424f84cb0a6fada8.jpg'),(11,'Sabtu Bersama Bapak','Adhitya Mulya',' GagasMedia',2014,32,'1776710847_e0d281ebe77b34bf2ec0.jpg');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
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
  `status` enum('pending','dipinjam','menunggu_kembali','kembali') DEFAULT 'dipinjam',
  `denda` int(11) DEFAULT 0,
  PRIMARY KEY (`id_pinjam`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (1,2,6,'2026-04-09','2026-04-16','',0),(9,2,6,'2026-04-09','2026-04-16','dipinjam',0),(110,2,1,'2026-04-20','2026-04-27','kembali',0),(111,2,1,'2026-04-20','2026-04-27','kembali',0),(114,2,1,'2026-04-20','2026-04-27','kembali',0),(115,2,1,'2026-04-20','2026-04-27','kembali',0),(117,2,1,'2026-04-20','2026-04-27','kembali',0),(123,2,3,'2026-04-20','2026-04-20','dipinjam',0),(124,2,2,'2026-04-21','2026-04-21','dipinjam',0),(125,2,4,'2026-04-21','2026-04-21','dipinjam',0);
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
  `foto` text NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'duyekadmin','duyekadmin','admin','$2y$10$FMQRdH0ecCbZZVWtN2n7/u1YZN/gr7X98Er4NG4sqDAWCXlZwmB6S','1763183432_c1f3bcfa48ff13338f21.png'),(2,'duyekuser','duyekuser','user','$2y$10$YZTlqRLsL6Sd47ghu8xdK.z2FkukMl70S/R98Tq4fwhTlLbx1SDom','1763182481_54d719f62b0a58a7f100.png');
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

-- Dump completed on 2026-04-21 14:13:31
