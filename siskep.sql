-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: db_siskep
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `SK`
--

DROP TABLE IF EXISTS `SK`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SK` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_sk` varchar(255) NOT NULL,
  `title` varchar(230) NOT NULL,
  `tgl_sk` varchar(10) NOT NULL,
  `file_sk` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_sk` (`no_sk`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SK`
--

LOCK TABLES `SK` WRITE;
/*!40000 ALTER TABLE `SK` DISABLE KEYS */;
INSERT INTO `SK` VALUES (1,'1111-2022','ini sk 1','18-07-2022','ini_sk_1_1111-2022.pdf');
/*!40000 ALTER TABLE `SK` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SK_detail`
--

DROP TABLE IF EXISTS `SK_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SK_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_sk` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `id_kedudukan` varchar(255) NOT NULL,
  `masa_kerja` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `id_bagian` varchar(255) NOT NULL,
  `id_subagian` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `SK_detail_no_sk_foreign` (`no_sk`),
  KEY `SK_detail_user_id_foreign` (`user_id`),
  KEY `SK_detail_id_kedudukan_foreign` (`id_kedudukan`),
  KEY `SK_detail_id_bagian_foreign` (`id_bagian`),
  KEY `SK_detail_id_subagian_foreign` (`id_subagian`),
  CONSTRAINT `SK_detail_id_bagian_foreign` FOREIGN KEY (`id_bagian`) REFERENCES `bagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SK_detail_id_kedudukan_foreign` FOREIGN KEY (`id_kedudukan`) REFERENCES `kedudukan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SK_detail_id_subagian_foreign` FOREIGN KEY (`id_subagian`) REFERENCES `subagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SK_detail_no_sk_foreign` FOREIGN KEY (`no_sk`) REFERENCES `SK` (`no_sk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SK_detail_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SK_detail`
--

LOCK TABLES `SK_detail` WRITE;
/*!40000 ALTER TABLE `SK_detail` DISABLE KEYS */;
INSERT INTO `SK_detail` VALUES (1,'1111-2022','11223344','K01',2,2100000,'B01','SB01');
/*!40000 ALTER TABLE `SK_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bagian`
--

DROP TABLE IF EXISTS `bagian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bagian` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bagian`
--

LOCK TABLES `bagian` WRITE;
/*!40000 ALTER TABLE `bagian` DISABLE KEYS */;
INSERT INTO `bagian` VALUES ('B01','bagian 1',''),('B02','bagian 2',''),('B03','bagian 3','<p>-</p>');
/*!40000 ALTER TABLE `bagian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` longtext NOT NULL,
  `visi` longtext NOT NULL,
  `misi` longtext NOT NULL,
  `pengumuman` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `information`
--

LOCK TABLES `information` WRITE;
/*!40000 ALTER TABLE `information` DISABLE KEYS */;
INSERT INTO `information` VALUES (1,'logo-kemendagri.webp','<blockquote class=\"ql-align-center\"><strong style=\"color: rgb(255, 255, 0);\"><em><s><u>Mewujudkan Pemerintahan Desa yang Mampu Memberikan Pelayanan Prima Kepada Masyarakat</u></s></em></strong></blockquote>','<ol><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan penyelenggaraan Pemerintahan Desa guna meningkatkan kualitas pelayanan pemerintah kepada masyarakat yang ditunjukkan dengan pemenuhan SPM Desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan peran perencanaan partisipatif dengan perlibatan aktif kelembagaan masyarakat desa dalam upaya pengentasan kemiskinan pada wilayah desa dan kawasan perdesaan;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan tata kelola aset dan keuangan desa berdasarkan prinsip transparansi, akuntabilitas, dan kemanfaatan;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kualitas kehidupan sosial budaya dan kerjasama masyarakat desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kualitas evaluasi penyelenggaraan pemerintahan desa dan penyusunan peringkat tingkat perkembangan desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kapasitas aparat dan lembaga masyarakat dalam pelaksanaan pembangunan desa lingkup regional.</span></li></ol>','<p><em style=\"color: rgb(82, 82, 91);\">(kosongkan jika tidak ingin ditampilkan)</em></p>');
/*!40000 ALTER TABLE `information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kedudukan`
--

DROP TABLE IF EXISTS `kedudukan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kedudukan` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kedudukan`
--

LOCK TABLES `kedudukan` WRITE;
/*!40000 ALTER TABLE `kedudukan` DISABLE KEYS */;
INSERT INTO `kedudukan` VALUES ('K01','tenaga administrasi'),('K02','tenaga akuntansi');
/*!40000 ALTER TABLE `kedudukan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (29,'2022-05-03-010238','App\\Database\\Migrations\\UserType','default','App',1658105879,1),(30,'2022-05-03-010338','App\\Database\\Migrations\\Bagian','default','App',1658105879,1),(31,'2022-05-03-010438','App\\Database\\Migrations\\Subagian','default','App',1658105879,1),(32,'2022-05-03-010538','App\\Database\\Migrations\\Kedudukan','default','App',1658105879,1),(33,'2022-05-03-091809','App\\Database\\Migrations\\SK','default','App',1658105879,1),(34,'2022-05-03-092809','App\\Database\\Migrations\\Users','default','App',1658105879,1),(35,'2022-05-03-093809','App\\Database\\Migrations\\SKDetail','default','App',1658105879,1),(36,'2022-05-03-094952','App\\Database\\Migrations\\UserToken','default','App',1658105879,1),(37,'2022-05-03-095809','App\\Database\\Migrations\\UserDetail','default','App',1658105879,1),(38,'2022-05-03-096809','App\\Database\\Migrations\\UserDetailBagian','default','App',1658105879,1),(39,'2022-05-03-097809','App\\Database\\Migrations\\UserDetailSubagian','default','App',1658105879,1),(40,'2022-05-23-125700','App\\Database\\Migrations\\Information','default','App',1658105879,1),(41,'2022-06-17-222133','App\\Database\\Migrations\\Tugas','default','App',1658105879,1),(42,'2022-06-17-222207','App\\Database\\Migrations\\TugasFile','default','App',1658105879,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subagian`
--

DROP TABLE IF EXISTS `subagian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subagian` (
  `id` varchar(255) NOT NULL,
  `id_bagian` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `subagian_id_bagian_foreign` (`id_bagian`),
  CONSTRAINT `subagian_id_bagian_foreign` FOREIGN KEY (`id_bagian`) REFERENCES `bagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subagian`
--

LOCK TABLES `subagian` WRITE;
/*!40000 ALTER TABLE `subagian` DISABLE KEYS */;
INSERT INTO `subagian` VALUES ('SB01','B01','subagian 1',''),('SB02','B01','subagian 2',''),('SB03','B01','subagian 3',''),('SB04','B02','subagian 2.1',''),('SB05','B02','subagian 2.2',''),('SB06','B02','subagian 2.3','');
/*!40000 ALTER TABLE `subagian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tugas`
--

DROP TABLE IF EXISTS `tugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tugas` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('tugas baru','pengecekan','diterima','revisi') NOT NULL,
  `komentar` longtext DEFAULT NULL,
  `created_at` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tugas_user_id_foreign` (`user_id`),
  CONSTRAINT `tugas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tugas`
--

LOCK TABLES `tugas` WRITE;
/*!40000 ALTER TABLE `tugas` DISABLE KEYS */;
INSERT INTO `tugas` VALUES ('62e114aa0ffe7','11223344','tugas staf 1','tugas baru','<p>hai</p>',1658918058);
/*!40000 ALTER TABLE `tugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tugas_file`
--

DROP TABLE IF EXISTS `tugas_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tugas_file` (
  `id` varchar(255) NOT NULL,
  `id_tugas` varchar(255) NOT NULL,
  `file_tugas` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tugas_file_id_tugas_foreign` (`id_tugas`),
  CONSTRAINT `tugas_file_id_tugas_foreign` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tugas_file`
--

LOCK TABLES `tugas_file` WRITE;
/*!40000 ALTER TABLE `tugas_file` DISABLE KEYS */;
INSERT INTO `tugas_file` VALUES ('62e114aa10598','62e114aa0ffe7','62e114aa10598_surat rekomendasi.pdf'),('62e114aa10c25','62e114aa0ffe7','62e114aa10c25_transaksi#TSS133185814.pdf');
/*!40000 ALTER TABLE `tugas_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_detail`
--

DROP TABLE IF EXISTS `user_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_detail` (
  `user_id` varchar(255) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `npwp` varchar(40) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notelp` varchar(20) DEFAULT NULL,
  `no_sk` varchar(255) DEFAULT NULL,
  `id_bagian` varchar(255) DEFAULT NULL,
  `id_subagian` varchar(255) DEFAULT NULL,
  `id_kedudukan` varchar(255) DEFAULT NULL,
  `masa_kerja` int(11) DEFAULT NULL,
  `income` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tgl_lahir` varchar(10) DEFAULT NULL,
  `kelamin` enum('laki-laki','perempuan') DEFAULT NULL,
  `agama` enum('islam','protestan','katolik','budha','hindu','khonghucu') DEFAULT NULL,
  `pendidikan` varchar(10) DEFAULT NULL,
  `status` enum('active','nonactive') DEFAULT NULL,
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `nik` (`nik`),
  UNIQUE KEY `npwp` (`npwp`),
  UNIQUE KEY `notelp` (`notelp`),
  KEY `user_detail_no_sk_foreign` (`no_sk`),
  KEY `user_detail_id_bagian_foreign` (`id_bagian`),
  KEY `user_detail_id_subagian_foreign` (`id_subagian`),
  KEY `user_detail_id_kedudukan_foreign` (`id_kedudukan`),
  CONSTRAINT `user_detail_id_bagian_foreign` FOREIGN KEY (`id_bagian`) REFERENCES `bagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_detail_id_kedudukan_foreign` FOREIGN KEY (`id_kedudukan`) REFERENCES `kedudukan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_detail_id_subagian_foreign` FOREIGN KEY (`id_subagian`) REFERENCES `subagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_detail_no_sk_foreign` FOREIGN KEY (`no_sk`) REFERENCES `SK` (`no_sk`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `user_detail_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_detail`
--

LOCK TABLES `user_detail` WRITE;
/*!40000 ALTER TABLE `user_detail` DISABLE KEYS */;
INSERT INTO `user_detail` VALUES ('11223344',NULL,NULL,NULL,'085155352499','1111-2022','B01','SB01','K01',2,2100000,'ini staf 1',NULL,NULL,NULL,NULL,NULL,NULL),('62d4b38e66830',NULL,NULL,NULL,NULL,NULL,'B01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'active');
/*!40000 ALTER TABLE `user_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type`
--

LOCK TABLES `user_type` WRITE;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` VALUES (1,'admin'),(2,'kabag'),(3,'kasubag'),(4,'nonasn');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `id_previlege` int(11) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id_previlege_foreign` (`id_previlege`),
  CONSTRAINT `users_id_previlege_foreign` FOREIGN KEY (`id_previlege`) REFERENCES `user_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('11223344','inistaf1','$2y$10$iJLrYJuJVdvMhj9MHwT0duk9P2zcewV3cAsPANWyv3aGDSSJaGc9C',4,1658105953),('62d4b061a2a99','superadmin','$2y$10$Fp2B1SX65sHFw9ARglD58uBM5imaETPhiTmEBXcRkdJGCKBo5903y',1,1658105953),('62d4b38e66830','inikabag1','$2y$10$KG/oUdiWyGHuXl7pqlwEv.uXAqw27FCGEMQH4CeRL93RIckNYl18e',2,1658106766);
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

-- Dump completed on 2022-07-27 18:43:25
