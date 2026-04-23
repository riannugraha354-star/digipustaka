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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'Laskar Pelangi','Andrea Hirata','Bentangg',2005,91,'1776708785_edc7c472f7998a2a95e1.jpg'),(2,'Bumi','Tere Liye','Gramedia',2014,42,'1776710441_ce1407a7cb1e7eec44ce.jpg'),(3,'Negeri 5 Menara','Ahmad Fuadi','Gramedia',2009,38,'1776710521_9b605140e999c44ffc2d.jpg'),(4,'Atomic Habits','James Clear','Penguin',2018,60,'1776710606_647297eed17f5275c9c3.jpg'),(5,'Rich Dad Poor Dad','Robert Kiyosaki','Warner Books',1997,24,'1776710737_d872b2dcc6eaf0f395b3.jpg'),(10,'Sewu Dino','SimpleMan',' PT Bukune Kreatif Cipta',2023,19,'1776710797_6ccd424f84cb0a6fada8.jpg'),(11,'Sabtu Bersama Bapak','Adhitya Mulya',' GagasMedia',2014,32,'1776710847_e0d281ebe77b34bf2ec0.jpg'),(15,'Love You More','Keyla Azni','Rian nugraha',2025,8,'1776841037_da69621a264ddda98d7f.png');
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
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (1,2,6,'2026-04-09','2026-04-16','',0),(9,2,6,'2026-04-09','2026-04-16','dipinjam',0),(115,2,1,'2026-04-20','2026-04-27','kembali',0),(117,2,1,'2026-04-20','2026-04-27','kembali',0),(123,2,3,'2026-04-20','2026-04-20','kembali',0),(124,2,2,'2026-04-21','2026-04-21','dipinjam',0),(125,2,4,'2026-04-21','2026-04-21','dipinjam',0),(126,2,1,'2026-04-21','2026-04-21','dipinjam',0),(127,2,2,'2026-04-21','2026-04-24','dipinjam',0),(128,2,4,'2026-04-21','2026-04-24','dipinjam',0),(129,2,10,'2026-04-21','2026-04-28','dipinjam',0),(130,2,1,'2026-04-22','2026-04-29','dipinjam',0),(131,2,15,'2026-04-22','2026-04-29','dipinjam',0),(132,3,1,'2026-04-22','2026-04-29','dipinjam',0),(133,3,2,'2026-04-22','2026-04-29','dipinjam',0),(134,2,15,'2026-04-22','2026-04-29','dipinjam',0);
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
INSERT INTO `users` VALUES (1,'duyekadmin','duyekadmin','admin','$2y$10$FMQRdH0ecCbZZVWtN2n7/u1YZN/gr7X98Er4NG4sqDAWCXlZwmB6S',NULL,'1776838997_45e3afa3c320c008b270.png'),(2,'duyekuser','duyekuser','user','$2y$10$YZTlqRLsL6Sd47ghu8xdK.z2FkukMl70S/R98Tq4fwhTlLbx1SDom',NULL,'1776839036_0f9df167a4bae98e3316.png'),(3,'rian','rian','user','$2y$10$.M9WdIX4RgytGIJ4G.Kf4uojf0Nt8noauUJgw9PI/oaiLIXC7r8vS',NULL,'1776876337_986a9c6d8c31df9b7480.png'),(4,'nugraha','nugraha123','user','$2y$10$LFzIgPwBC5c0z8RUR85yAOqFWzYRB/ol./oV/Q7qZsqa2mpnCC.vK',NULL,'1776959732_63c691296114bb2b7e85.jpg'),(5,'achole','achole','user','$2y$10$FzwAsaa4mCbHcJAhOY63juG4FSHe2w3zysaaytnK6cLMoXRTO5qVe',NULL,NULL);
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

-- Dump completed on 2026-04-23 22:58:35
