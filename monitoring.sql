/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 8.0.30 : Database - monitoring
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`monitoring` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `monitoring`;

/*Table structure for table `data_ip` */

DROP TABLE IF EXISTS `data_ip`;

CREATE TABLE `data_ip` (
  `id_ip` int NOT NULL AUTO_INCREMENT,
  `kd_ip` char(15) NOT NULL,
  `ip_address` varchar(30) NOT NULL,
  `nm_unit` varchar(50) NOT NULL,
  `kategori` varchar(100) NOT NULL DEFAULT 'Server',
  `pic_id` int DEFAULT NULL,
  `gps_x` char(30) DEFAULT NULL,
  `gps_y` char(30) DEFAULT NULL,
  PRIMARY KEY (`id_ip`),
  KEY `FK` (`pic_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `data_ip` */

insert  into `data_ip`(`id_ip`,`kd_ip`,`ip_address`,`nm_unit`,`kategori`,`pic_id`,`gps_x`,`gps_y`) values 
(1,'SRV001','192.168.1.84','Server 1','Server Application',1,'-6.2386491','106.8215035'),
(2,'SRV002','192.168.1.111','Server 2','Server Application',2,'-6.2386491','106.8215035'),
(3,'SRV003','tokopedia.com','Server Toko','Server Application',1,'-6.2386491','106.8215035'),
(4,'SRV004','127.0.0.1','Server NEW','Server Application',1,'-6.1656691','106.8168236');

/*Table structure for table `monitoring_rto` */

DROP TABLE IF EXISTS `monitoring_rto`;

CREATE TABLE `monitoring_rto` (
  `id_rto` int NOT NULL AUTO_INCREMENT,
  `ip_id` int NOT NULL,
  `tanggal_rto` datetime NOT NULL,
  `tanggal_reply` datetime DEFAULT NULL,
  `kirim_telegram` datetime DEFAULT NULL,
  `dipindai` tinyint(1) NOT NULL,
  `status` enum('online','offline') DEFAULT NULL,
  `durasi` varchar(100) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_rto`),
  KEY `FK` (`ip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `monitoring_rto` */

/*Table structure for table `pic` */

DROP TABLE IF EXISTS `pic`;

CREATE TABLE `pic` (
  `id_pic` int NOT NULL AUTO_INCREMENT,
  `nm_pic` varchar(50) NOT NULL,
  `chat_id` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `posisi` enum('Admin IT','Head IT','IT Support','Programmer') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `no_telp` bigint DEFAULT '0',
  `monitoring_aktif` tinyint(1) NOT NULL DEFAULT '0',
  `user_aktif` tinyint(1) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pic`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `pic` */

insert  into `pic`(`id_pic`,`nm_pic`,`chat_id`,`email`,`password`,`posisi`,`no_telp`,`monitoring_aktif`,`user_aktif`,`foto`) values 
(1,'Ahmad Juantoro','706694762','juan@root.com','21232f297a57a5a743894a0e4a801fc3','IT Support',0,0,1,'juan@root.com.png'),
(2,'Rahmat Hidayat','706694762','rahmat@root.com','21232f297a57a5a743894a0e4a801fc3','Programmer',0,0,1,'rahmat@root.com.');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
