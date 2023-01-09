/*
 Navicat Premium Data Transfer

 Source Server         : Localhost MySQL
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : habit_batulanteh

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 27/12/2022 08:17:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for baca_meter
-- ----------------------------
DROP TABLE IF EXISTS `baca_meter`;
CREATE TABLE `baca_meter`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `periode` date NOT NULL,
  `stand_ini` int(11) NULL DEFAULT NULL,
  `status_baca` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_baca` datetime NULL DEFAULT NULL,
  `foto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `longitude` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pelanggan_id` bigint(20) NULL DEFAULT NULL,
  `pembaca_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `id_pembaca`(`pembaca_id`) USING BTREE,
  INDEX `periode`(`periode`) USING BTREE,
  INDEX `id_pelanggan`(`pelanggan_id`) USING BTREE,
  INDEX `tanggal_baca`(`tanggal_baca`) USING BTREE,
  CONSTRAINT `baca_meter_ibfk_1` FOREIGN KEY (`pembaca_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of baca_meter
-- ----------------------------

-- ----------------------------
-- Table structure for diameter
-- ----------------------------
DROP TABLE IF EXISTS `diameter`;
CREATE TABLE `diameter`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ukuran` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `biaya_pemasangan` decimal(20, 2) NOT NULL,
  `biaya_ganti_meter` decimal(20, 2) NULL DEFAULT NULL,
  `biaya_pindah_meter` decimal(20, 2) NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `ukuran`(`ukuran`) USING BTREE,
  INDEX `pengguna_id`(`pengguna_id`) USING BTREE,
  CONSTRAINT `diameter_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of diameter
-- ----------------------------
INSERT INTO `diameter` VALUES (1, 'tes', 1234.00, 123.00, 12.00, 1, '2022-12-26 09:45:17', '2022-12-26 09:45:17', NULL);

-- ----------------------------
-- Table structure for dspl
-- ----------------------------
DROP TABLE IF EXISTS `dspl`;
CREATE TABLE `dspl`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `periode` date NULL DEFAULT NULL,
  `status_pelanggan` tinyint(1) NULL DEFAULT NULL,
  `pelanggan_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pelanggan_id`(`pelanggan_id`) USING BTREE,
  CONSTRAINT `dspl_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dspl
-- ----------------------------

-- ----------------------------
-- Table structure for golongan
-- ----------------------------
DROP TABLE IF EXISTS `golongan`;
CREATE TABLE `golongan`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_pengguna`(`pengguna_id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `id_2`(`id`) USING BTREE,
  INDEX `id_3`(`id`) USING BTREE,
  CONSTRAINT `golongan_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 230 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of golongan
-- ----------------------------
INSERT INTO `golongan` VALUES (229, 'Nama', 'Deskripsi', 1, '2022-12-26 12:08:38', '2022-12-26 12:08:38', NULL);

-- ----------------------------
-- Table structure for ira
-- ----------------------------
DROP TABLE IF EXISTS `ira`;
CREATE TABLE `ira`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_pelanggan` tinyint(1) NULL DEFAULT NULL,
  `periode` date NULL DEFAULT NULL,
  `stand_lalu` int(11) NULL DEFAULT NULL,
  `stand_ini` int(11) NULL DEFAULT NULL,
  `pakai` int(11) NULL DEFAULT NULL,
  `harga_air` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_retribusi` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_jasa_lingkungan` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_pemeliharaan` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_administrasi` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_materai` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_denda` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_ppn` decimal(15, 2) NULL DEFAULT 0.00,
  `diskon` decimal(15, 2) NULL DEFAULT NULL,
  `pelanggan_id` bigint(20) NOT NULL,
  `golongan_id` bigint(20) NULL DEFAULT NULL,
  `jalan_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_pelanggan`(`pelanggan_id`) USING BTREE,
  INDEX `id_golongan`(`golongan_id`) USING BTREE,
  INDEX `ira_ibfk_3`(`jalan_id`) USING BTREE,
  INDEX `periode`(`periode`) USING BTREE,
  CONSTRAINT `ira_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ira_ibfk_2` FOREIGN KEY (`golongan_id`) REFERENCES `golongan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ira_ibfk_3` FOREIGN KEY (`jalan_id`) REFERENCES `jalan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12841783 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ira
-- ----------------------------

-- ----------------------------
-- Table structure for jalan
-- ----------------------------
DROP TABLE IF EXISTS `jalan`;
CREATE TABLE `jalan`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kelurahan_id` bigint(20) NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `id_kelurahan`(`kelurahan_id`) USING BTREE,
  INDEX `nama`(`nama`) USING BTREE,
  INDEX `pengguna_id`(`pengguna_id`) USING BTREE,
  CONSTRAINT `jalan_ibfk_2` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jalan_ibfk_3` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2937 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jalan
-- ----------------------------
INSERT INTO `jalan` VALUES (2936, 'tsadsf', 173, 1, '2022-12-26 12:49:27', '2022-12-26 12:49:27', NULL);

-- ----------------------------
-- Table structure for kecamatan
-- ----------------------------
DROP TABLE IF EXISTS `kecamatan`;
CREATE TABLE `kecamatan`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  UNIQUE INDEX `kode`(`kode`) USING BTREE,
  INDEX `nama`(`nama`) USING BTREE,
  INDEX `pengguna_id`(`pengguna_id`) USING BTREE,
  CONSTRAINT `kecamatan_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kecamatan
-- ----------------------------
INSERT INTO `kecamatan` VALUES (17, '123', 'asd', 1, '2022-12-26 12:37:15', '2022-12-26 12:37:15', NULL);

-- ----------------------------
-- Table structure for kelurahan
-- ----------------------------
DROP TABLE IF EXISTS `kelurahan`;
CREATE TABLE `kelurahan`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kecamatan_id` bigint(20) NOT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  UNIQUE INDEX `kode`(`kode`) USING BTREE,
  INDEX `id_kecamatan`(`kecamatan_id`) USING BTREE,
  INDEX `nama`(`nama`) USING BTREE,
  INDEX `pengguna_id`(`pengguna_id`) USING BTREE,
  CONSTRAINT `kelurahan_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `kelurahan_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 174 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kelurahan
-- ----------------------------
INSERT INTO `kelurahan` VALUES (173, '123', 'ates', 17, 1, '2022-12-26 12:44:13', '2022-12-26 12:44:13', NULL);

-- ----------------------------
-- Table structure for kolektif
-- ----------------------------
DROP TABLE IF EXISTS `kolektif`;
CREATE TABLE `kolektif`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kolektif
-- ----------------------------

-- ----------------------------
-- Table structure for kolektif_detail
-- ----------------------------
DROP TABLE IF EXISTS `kolektif_detail`;
CREATE TABLE `kolektif_detail`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kolektif_id` bigint(20) NULL DEFAULT NULL,
  `pelanggan_id` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kolektif_id`(`kolektif_id`) USING BTREE,
  CONSTRAINT `kolektif_detail_ibfk_1` FOREIGN KEY (`kolektif_id`) REFERENCES `kolektif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kolektif_detail
-- ----------------------------

-- ----------------------------
-- Table structure for merk_water_meter
-- ----------------------------
DROP TABLE IF EXISTS `merk_water_meter`;
CREATE TABLE `merk_water_meter`  (
  `id` bigint(20) NOT NULL,
  `merk` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pengguna_id`(`pengguna_id`) USING BTREE,
  CONSTRAINT `merk_water_meter_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of merk_water_meter
-- ----------------------------
INSERT INTO `merk_water_meter` VALUES (1, 'Merk', 1, '2022-12-26 12:15:27', '2022-12-26 12:15:27', NULL);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) NOT NULL,
  `model_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `model_id` bigint(20) NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`) USING BTREE,
  INDEX `model_id`(`model_id`) USING BTREE,
  CONSTRAINT `model_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `model_has_permissions_ibfk_2` FOREIGN KEY (`model_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
INSERT INTO `model_has_permissions` VALUES (113, 'App\\Models\\Pengguna', 127);
INSERT INTO `model_has_permissions` VALUES (114, 'App\\Models\\Pengguna', 127);
INSERT INTO `model_has_permissions` VALUES (115, 'App\\Models\\Pengguna', 127);

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint(20) NOT NULL,
  `model_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `model_id` bigint(20) NOT NULL,
  PRIMARY KEY (`model_id`, `role_id`, `model_type`) USING BTREE,
  INDEX `role_id`(`role_id`) USING BTREE,
  CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `model_has_roles_ibfk_2` FOREIGN KEY (`model_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\Pengguna', 1);
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\Pengguna', 127);

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NULL DEFAULT 1,
  `no_langganan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ktp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telepon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_pasang` datetime NULL DEFAULT NULL,
  `no_body_water_meter` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `denah` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `latitude` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `golongan_id` bigint(20) NULL DEFAULT NULL,
  `jalan_id` bigint(20) NULL DEFAULT NULL,
  `water_meter_id` bigint(20) NULL DEFAULT NULL,
  `diameter_id` bigint(20) NULL DEFAULT NULL,
  `pembaca_id` bigint(20) NULL DEFAULT NULL,
  `tarfi_khusus_id` bigint(20) NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------

-- ----------------------------
-- Table structure for pengguna
-- ----------------------------
DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `uid` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `kata_sandi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 128 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengguna
-- ----------------------------
INSERT INTO `pengguna` VALUES (1, 'Administrator', 'admin', NULL, '$2y$10$..RnZcH.V3nf4T12yPeI8uAKZlurOyuiyNfWUP.aFN6p0Ab/pM5M.', NULL, '2022-11-10 00:00:00', '2022-11-10 00:00:00', NULL);
INSERT INTO `pengguna` VALUES (127, 'tes', 'tes', 'tes', '$2y$10$BfW41Qj3i5jq2417aDKUvON5dgiqHw4b3qhMeiXFY6mazVdCkUCJq', NULL, '2022-12-26 09:16:24', '2022-12-26 09:27:52', NULL);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 152 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (113, 'dashboard', 'web', '2022-12-26 09:15:40', '2022-12-26 09:15:40');
INSERT INTO `permissions` VALUES (114, 'bacameter', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (115, 'bacameterbuatdatabaru', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (116, 'bacameterdatatarget', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (117, 'bacameterpostingrekeningair', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (118, 'cetak', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (119, 'cetakdspl', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (120, 'cetakira', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (121, 'cetakkoreksirekeningair', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (122, 'cetaklpprekair', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (123, 'cetakprogresbacameter', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (124, 'datamaster', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (125, 'datamasterdiameter', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (126, 'datamastergolongan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (127, 'datamastermerkwatermeter', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (128, 'datamasterregional', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (129, 'datamasterregionaljalan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (130, 'datamasterregionalkecamatan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (131, 'datamasterregionalkelurahan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (132, 'datamasterstatusbaca', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (133, 'datamastertarif', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (134, 'datamastertarifdenda', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (135, 'datamastertarifkhusus', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (136, 'datamastertariflainnya', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (137, 'datamastertarifmaterai', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (138, 'datamastertarifmeterair', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (139, 'datamastertarifprogresif', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (140, 'informasipelanggan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (141, 'masterpelanggan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (142, 'pembayaran', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (143, 'pembayaranrekeningairkolektif', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (144, 'pembayaranrekeningairperpelanggan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (145, 'pengaturan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (146, 'pengaturankolektif', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (147, 'pengaturanpengguna', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (148, 'tagihanrekeningair', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (149, 'tagihanrekeningairkoreksi', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (150, 'tagihanrekeningairpenerbitan', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');
INSERT INTO `permissions` VALUES (151, 'tagihanrekeningairpostingira', 'web', '2022-12-26 09:16:15', '2022-12-26 09:16:15');

-- ----------------------------
-- Table structure for rekening_air
-- ----------------------------
DROP TABLE IF EXISTS `rekening_air`;
CREATE TABLE `rekening_air`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `periode` date NULL DEFAULT NULL,
  `stand_lalu` int(11) NULL DEFAULT NULL,
  `stand_ini` int(11) NULL DEFAULT NULL,
  `pakai` int(11) NULL DEFAULT NULL,
  `harga_air` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_retribusi` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_jasa_lingkungan` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_pemeliharaan` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_administrasi` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_materai` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_denda` decimal(15, 2) NULL DEFAULT 0.00,
  `biaya_ppn` decimal(15, 2) NULL DEFAULT 0.00,
  `diskon` decimal(15, 2) NULL DEFAULT 0.00,
  `status_baca` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `waktu_bayar` datetime NULL DEFAULT NULL,
  `keterangan` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `kasir_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pelanggan_id` bigint(20) NULL DEFAULT NULL,
  `golongan_id` bigint(20) NULL DEFAULT NULL,
  `jalan_id` bigint(20) NULL DEFAULT NULL,
  `tarif_denda_id` bigint(20) NULL DEFAULT NULL,
  `tarif_lainnya_id` bigint(20) NULL DEFAULT NULL,
  `tarif_meter_air_id` bigint(20) NULL DEFAULT NULL,
  `tarif_progresif_id` bigint(20) NULL DEFAULT NULL,
  `tarif_progresif_khusus_id` bigint(20) NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  UNIQUE INDEX `periode`(`periode`, `pelanggan_id`) USING BTREE,
  INDEX `kasir`(`kasir_id`) USING BTREE,
  INDEX `rekening_air_periode`(`periode`) USING BTREE,
  INDEX `waktu_bayar`(`waktu_bayar`) USING BTREE,
  INDEX `id_pelanggan`(`pelanggan_id`) USING BTREE,
  INDEX `id_golongan`(`golongan_id`) USING BTREE,
  INDEX `id_jalan`(`jalan_id`) USING BTREE,
  INDEX `deleted_at`(`deleted_at`) USING BTREE,
  CONSTRAINT `rekening_air_ibfk_2` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `rekening_air_ibfk_3` FOREIGN KEY (`golongan_id`) REFERENCES `golongan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `rekening_air_ibfk_4` FOREIGN KEY (`jalan_id`) REFERENCES `jalan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19962939 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rekening_air
-- ----------------------------

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  PRIMARY KEY (`role_id`, `permission_id`) USING BTREE,
  INDEX `permission_id`(`permission_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_has_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'super-admin', 'web', '2022-12-23 00:00:00', '2022-12-23 00:00:00');
INSERT INTO `roles` VALUES (2, 'supervisor', 'web', '2022-12-23 00:00:00', '2022-12-23 00:00:00');
INSERT INTO `roles` VALUES (3, 'operator', 'web', '2022-12-23 00:00:00', '2022-12-23 00:00:00');
INSERT INTO `roles` VALUES (4, 'guest', 'web', '2022-12-23 00:00:00', '2022-12-23 00:00:00');

-- ----------------------------
-- Table structure for status_baca
-- ----------------------------
DROP TABLE IF EXISTS `status_baca`;
CREATE TABLE `status_baca`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `input_angka` tinyint(4) NOT NULL COMMENT '0 taksir, 1 input angka',
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pengguna_id`(`pengguna_id`) USING BTREE,
  CONSTRAINT `status_baca_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_baca
-- ----------------------------
INSERT INTO `status_baca` VALUES (5, 'Keterangan', 1, 1, '2022-12-26 12:24:41', '2022-12-26 12:26:55', NULL);

-- ----------------------------
-- Table structure for tarif_denda
-- ----------------------------
DROP TABLE IF EXISTS `tarif_denda`;
CREATE TABLE `tarif_denda`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tanggal_berlaku` date NULL DEFAULT NULL,
  `sk` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `nilai` decimal(15, 2) NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_pengguna`(`nilai`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tarif_denda
-- ----------------------------
INSERT INTO `tarif_denda` VALUES (2, '2022-12-26', 'tes', 'tesa', 123123.00, 1, '2022-12-26 13:08:46', '2022-12-26 13:08:46', NULL);

-- ----------------------------
-- Table structure for tarif_progresif
-- ----------------------------
DROP TABLE IF EXISTS `tarif_progresif`;
CREATE TABLE `tarif_progresif`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tanggal_berlaku` date NULL DEFAULT NULL,
  `sk` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `golongan_id` bigint(20) NULL DEFAULT NULL,
  `pengguna_id` bigint(20) NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `golongan_id`(`golongan_id`) USING BTREE,
  INDEX `pengguna_id`(`pengguna_id`) USING BTREE,
  CONSTRAINT `tarif_progresif_ibfk_1` FOREIGN KEY (`golongan_id`) REFERENCES `golongan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tarif_progresif_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tarif_progresif
-- ----------------------------

-- ----------------------------
-- Table structure for tarif_progresif_detail
-- ----------------------------
DROP TABLE IF EXISTS `tarif_progresif_detail`;
CREATE TABLE `tarif_progresif_detail`  (
  `id` bigint(20) NOT NULL,
  `tarif_progresif_id` bigint(20) NULL DEFAULT NULL,
  `min_pakai` int(11) NULL DEFAULT NULL,
  `max_pakai` int(11) NULL DEFAULT NULL,
  `nilai` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tarif_progresif_id`(`tarif_progresif_id`) USING BTREE,
  CONSTRAINT `tarif_progresif_detail_ibfk_1` FOREIGN KEY (`tarif_progresif_id`) REFERENCES `tarif_progresif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tarif_progresif_detail
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
