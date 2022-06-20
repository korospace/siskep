-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2022 at 02:42 AM
-- Server version: 8.0.13-4
-- PHP Version: 7.2.24-0ubuntu0.18.04.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `NjMOgkOZkN`
--

-- --------------------------------------------------------

--
-- Table structure for table `bagian`
--

CREATE TABLE `bagian` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bagian`
--

INSERT INTO `bagian` (`id`, `name`, `description`) VALUES
('B01', 'bagian 1', ''),
('B02', 'bagian 2', '');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(11) NOT NULL,
  `logo` longtext NOT NULL,
  `visi` longtext NOT NULL,
  `misi` longtext NOT NULL,
  `pengumuman` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `logo`, `visi`, `misi`, `pengumuman`) VALUES
(1, 'logo-kemendagri.webp', '<blockquote class=\"ql-align-center\"><strong style=\"color: rgb(255, 255, 0);\"><em><s><u>Mewujudkan Pemerintahan Desa yang Mampu Memberikan Pelayanan Prima Kepada Masyarakat</u></s></em></strong></blockquote>', '<ol><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan penyelenggaraan Pemerintahan Desa guna meningkatkan kualitas pelayanan pemerintah kepada masyarakat yang ditunjukkan dengan pemenuhan SPM Desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan peran perencanaan partisipatif dengan perlibatan aktif kelembagaan masyarakat desa dalam upaya pengentasan kemiskinan pada wilayah desa dan kawasan perdesaan;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan tata kelola aset dan keuangan desa berdasarkan prinsip transparansi, akuntabilitas, dan kemanfaatan;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kualitas kehidupan sosial budaya dan kerjasama masyarakat desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kualitas evaluasi penyelenggaraan pemerintahan desa dan penyusunan peringkat tingkat perkembangan desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kapasitas aparat dan lembaga masyarakat dalam pelaksanaan pembangunan desa lingkup regional.</span></li></ol>', '<p><em style=\"color: rgb(82, 82, 91);\">(kosongkan jika tidak ingin ditampilkan)</em></p>');

-- --------------------------------------------------------

--
-- Table structure for table `kedudukan`
--

CREATE TABLE `kedudukan` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kedudukan`
--

INSERT INTO `kedudukan` (`id`, `name`) VALUES
('K01', 'tenaga administrasi'),
('K02', 'tenaga akuntansi');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(273, '2022-05-03-010238', 'App\\Database\\Migrations\\UserType', 'default', 'App', 1655552855, 1),
(274, '2022-05-03-010338', 'App\\Database\\Migrations\\Bagian', 'default', 'App', 1655552856, 1),
(275, '2022-05-03-010438', 'App\\Database\\Migrations\\Subagian', 'default', 'App', 1655552857, 1),
(276, '2022-05-03-010538', 'App\\Database\\Migrations\\Kedudukan', 'default', 'App', 1655552858, 1),
(277, '2022-05-03-091809', 'App\\Database\\Migrations\\SK', 'default', 'App', 1655552861, 1),
(278, '2022-05-03-092809', 'App\\Database\\Migrations\\Users', 'default', 'App', 1655552862, 1),
(279, '2022-05-03-093809', 'App\\Database\\Migrations\\SKDetail', 'default', 'App', 1655552862, 1),
(280, '2022-05-03-094952', 'App\\Database\\Migrations\\UserToken', 'default', 'App', 1655552863, 1),
(281, '2022-05-03-095809', 'App\\Database\\Migrations\\UserDetail', 'default', 'App', 1655552866, 1),
(282, '2022-05-03-096809', 'App\\Database\\Migrations\\UserDetailBagian', 'default', 'App', 1655552866, 1),
(283, '2022-05-03-097809', 'App\\Database\\Migrations\\UserDetailSubagian', 'default', 'App', 1655552867, 1),
(284, '2022-05-23-125700', 'App\\Database\\Migrations\\Information', 'default', 'App', 1655552871, 1),
(285, '2022-06-17-222133', 'App\\Database\\Migrations\\Tugas', 'default', 'App', 1655552873, 1),
(286, '2022-06-17-222207', 'App\\Database\\Migrations\\TugasFile', 'default', 'App', 1655552874, 1);

-- --------------------------------------------------------

--
-- Table structure for table `SK`
--

CREATE TABLE `SK` (
  `id` int(11) NOT NULL,
  `no_sk` varchar(255) NOT NULL,
  `title` varchar(230) NOT NULL,
  `tgl_sk` varchar(10) NOT NULL,
  `file_sk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SK`
--

INSERT INTO `SK` (`id`, `no_sk`, `title`, `tgl_sk`, `file_sk`) VALUES
(1, 'sk-002', 'ini sk 2', '19-06-2022', 'ini_sk_2_sk-002.pdf'),
(2, 'sk-001', 'ini sk 1', '19-06-2022', 'ini_sk_1_sk-001.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `SK_detail`
--

CREATE TABLE `SK_detail` (
  `id` int(11) NOT NULL,
  `no_sk` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `id_kedudukan` varchar(255) NOT NULL,
  `masa_kerja` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `id_bagian` varchar(255) NOT NULL,
  `id_subagian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SK_detail`
--

INSERT INTO `SK_detail` (`id`, `no_sk`, `user_id`, `id_kedudukan`, `masa_kerja`, `income`, `id_bagian`, `id_subagian`) VALUES
(1, 'sk-002', '62ae54548ec77', 'K01', 4, 4000000, 'B02', 'SB04'),
(2, 'sk-001', '62adbb7b99a9f', 'K02', 2, 2000000, 'B01', 'SB01');

-- --------------------------------------------------------

--
-- Table structure for table `subagian`
--

CREATE TABLE `subagian` (
  `id` varchar(255) NOT NULL,
  `id_bagian` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subagian`
--

INSERT INTO `subagian` (`id`, `id_bagian`, `name`, `description`) VALUES
('SB01', 'B01', 'subagian 1', ''),
('SB02', 'B01', 'subagian 2', ''),
('SB03', 'B01', 'subagian 3', ''),
('SB04', 'B02', 'subagian 2.1', ''),
('SB05', 'B02', 'subagian 2.2', ''),
('SB06', 'B02', 'subagian 2.3', '');

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('tugas baru','pengecekan','diterima','revisi') NOT NULL,
  `komentar` longtext,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id`, `user_id`, `title`, `status`, `komentar`, `created_at`) VALUES
('62afaf7025652', '62adbb7b99a9f', 'tugas 1 untuk staf 1', 'tugas baru', '<p>kerjain tolong</p>', 1655680879),
('62afafae7e270', '62adbb7b99a9f', 'tugas 2 untuk staf 1 edit', 'tugas baru', '<p>kerjain tolong bray</p>', 1655680941),
('62afb80cafdc7', '62ae54548ec77', 'tugas yy untuk staf2', 'tugas baru', '<p>yy</p>', 1655683082);

-- --------------------------------------------------------

--
-- Table structure for table `tugas_file`
--

CREATE TABLE `tugas_file` (
  `id` varchar(255) NOT NULL,
  `id_tugas` varchar(255) NOT NULL,
  `file_tugas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `id_previlege` int(11) NOT NULL,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `id_previlege`, `created_at`) VALUES
('62adbb7b84cf1', 'superadmin', '$2y$10$VUe2mMB3W5/4Z4oJ21jxfOOu6QDlQL7hmdKWoWkeaCBewKZIWJv4y', 1, 1655552891),
('62adbb7b99a9f', 'inistaf1', '$2y$10$1JBFX/.1mkwezffYH4dq4..93SeN.JpAg4XJr2By6G/hLPL47GeRO', 4, 1655552891),
('62ae533e25a77', 'inikabag1', '$2y$10$6B09eTvJflldaEjjVrwfcOaBWpxmVP1X3q9BnNGM5HUayX2Y1kPvi', 2, 1655591742),
('62ae536437b26', 'inikabag2', '$2y$10$tSkWDwOBrbtit60zduA.beBIVHpyccBFCTzzzqEHEDnYRXKE.sfEy', 2, 1655591780),
('62ae5394eb9f6', 'kasubag1.1', '$2y$10$Ez2TCNqPqrvJDu760kkrIeN408y9dlFHTL4upnqKLQzTjFDMvfAiS', 3, 1655591829),
('62ae53b6beadd', 'kasubag1.2', '$2y$10$uWbIptyI7CW/TOPRIljxWutTXoqdXmV5AvUezGtW5HyPFz1x7MFD.', 3, 1655591862),
('62ae540c8ad2e', 'kasubag2.1', '$2y$10$Pt9Omj7K9eC66IJiVhKc8.vkQXPGvT0ZNJ9NFlENUuY6eg8nKIWBm', 3, 1655591948),
('62ae54548ec77', 'inistaf2', '$2y$10$y4z07bwpcQHGTwHWXcvoTef/eI3BRYlCJbPiAKZR0QkYfpp.Eoxd6', 4, 1655592020);

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

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
  `status` enum('active','nonactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`user_id`, `nik`, `npwp`, `email`, `notelp`, `no_sk`, `id_bagian`, `id_subagian`, `id_kedudukan`, `masa_kerja`, `income`, `nama_lengkap`, `alamat`, `tgl_lahir`, `kelamin`, `agama`, `pendidikan`, `status`) VALUES
('62adbb7b99a9f', NULL, NULL, NULL, NULL, 'sk-001', 'B01', 'SB01', 'K02', 2, 2000000, 'ini staf 1', NULL, NULL, NULL, NULL, NULL, NULL),
('62ae533e25a77', NULL, NULL, NULL, NULL, NULL, 'B01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('62ae536437b26', NULL, NULL, NULL, NULL, NULL, 'B02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('62ae5394eb9f6', NULL, NULL, NULL, NULL, NULL, 'B01', 'SB01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('62ae53b6beadd', NULL, NULL, NULL, NULL, NULL, 'B01', 'SB02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('62ae540c8ad2e', NULL, NULL, NULL, NULL, NULL, 'B02', 'SB04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
('62ae54548ec77', NULL, NULL, NULL, NULL, 'sk-002', 'B02', 'SB04', 'K01', 4, 4000000, 'ini staf 2', NULL, NULL, NULL, NULL, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type`) VALUES
(1, 'admin'),
(2, 'kabag'),
(3, 'kasubag'),
(4, 'nonasn');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kedudukan`
--
ALTER TABLE `kedudukan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `SK`
--
ALTER TABLE `SK`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_sk` (`no_sk`);

--
-- Indexes for table `SK_detail`
--
ALTER TABLE `SK_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `SK_detail_no_sk_foreign` (`no_sk`),
  ADD KEY `SK_detail_user_id_foreign` (`user_id`),
  ADD KEY `SK_detail_id_kedudukan_foreign` (`id_kedudukan`),
  ADD KEY `SK_detail_id_bagian_foreign` (`id_bagian`),
  ADD KEY `SK_detail_id_subagian_foreign` (`id_subagian`);

--
-- Indexes for table `subagian`
--
ALTER TABLE `subagian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `subagian_id_bagian_foreign` (`id_bagian`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_user_id_foreign` (`user_id`);

--
-- Indexes for table `tugas_file`
--
ALTER TABLE `tugas_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_file_id_tugas_foreign` (`id_tugas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id_previlege_foreign` (`id_previlege`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `npwp` (`npwp`),
  ADD UNIQUE KEY `notelp` (`notelp`),
  ADD KEY `user_detail_no_sk_foreign` (`no_sk`),
  ADD KEY `user_detail_id_bagian_foreign` (`id_bagian`),
  ADD KEY `user_detail_id_subagian_foreign` (`id_subagian`),
  ADD KEY `user_detail_id_kedudukan_foreign` (`id_kedudukan`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `SK`
--
ALTER TABLE `SK`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `SK_detail`
--
ALTER TABLE `SK_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `SK_detail`
--
ALTER TABLE `SK_detail`
  ADD CONSTRAINT `SK_detail_id_bagian_foreign` FOREIGN KEY (`id_bagian`) REFERENCES `bagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SK_detail_id_kedudukan_foreign` FOREIGN KEY (`id_kedudukan`) REFERENCES `kedudukan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SK_detail_id_subagian_foreign` FOREIGN KEY (`id_subagian`) REFERENCES `subagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SK_detail_no_sk_foreign` FOREIGN KEY (`no_sk`) REFERENCES `SK` (`no_sk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SK_detail_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subagian`
--
ALTER TABLE `subagian`
  ADD CONSTRAINT `subagian_id_bagian_foreign` FOREIGN KEY (`id_bagian`) REFERENCES `bagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tugas_file`
--
ALTER TABLE `tugas_file`
  ADD CONSTRAINT `tugas_file_id_tugas_foreign` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_previlege_foreign` FOREIGN KEY (`id_previlege`) REFERENCES `user_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `user_detail_id_bagian_foreign` FOREIGN KEY (`id_bagian`) REFERENCES `bagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_detail_id_kedudukan_foreign` FOREIGN KEY (`id_kedudukan`) REFERENCES `kedudukan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_detail_id_subagian_foreign` FOREIGN KEY (`id_subagian`) REFERENCES `subagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_detail_no_sk_foreign` FOREIGN KEY (`no_sk`) REFERENCES `SK` (`no_sk`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `user_detail_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
