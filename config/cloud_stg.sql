/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.30 : Database - cloud_storage
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cloud_storage` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `cloud_storage`;

/*Table structure for table `directory` */

DROP TABLE IF EXISTS `directory`;

CREATE TABLE `directory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dirName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  UNIQUE KEY `uniq name` (`dirName`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `directory` */

insert  into `directory`(`id`,`dirName`,`parent_id`,`status`) values 
(1,'files',0,1),
(2,'doc',1,0),
(3,'pdf',1,0),
(4,'folder5',2,0),
(5,'folder55',2,0),
(6,'FolderForRemove',2,0),
(8,'trash',6,NULL),
(10,'musur',6,NULL);

/*Table structure for table `fileAccess` */

DROP TABLE IF EXISTS `fileAccess`;

CREATE TABLE `fileAccess` (
  `id_file` int DEFAULT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fileAccess` */

insert  into `fileAccess`(`id_file`,`id_user`) values 
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(1,6),
(1,7),
(1,8),
(1,9),
(2,5),
(2,3);

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_dir` int DEFAULT NULL,
  `realFileName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fileName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `extension` varbinary(10) DEFAULT NULL,
  `status` int DEFAULT NULL,
  UNIQUE KEY `unical` (`realFileName`,`id_dir`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `files` */

insert  into `files`(`id`,`id_dir`,`realFileName`,`fileName`,`extension`,`status`) values 
(1,3,'trueUpdate.docx','file_64799d2263860.docx','docx',NULL);

/*Table structure for table `reset_password` */

DROP TABLE IF EXISTS `reset_password`;

CREATE TABLE `reset_password` (
  `email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `reset_password` */

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `status` */

insert  into `status`(`id`,`name`) values 
(1,'administrator'),
(2,'user '),
(3,'removed user'),
(4,'reseted password');

/*Table structure for table `User` */

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  KEY `uid` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `User` */

insert  into `User`(`id`,`email`,`password`,`fullName`,`age`,`gender`,`status`) values 
(1,'raufjonaliboev77@gmail.com','2023-05-30736475b2134ecbc','Rauf Aliboev',25,'male',1),
(2,'art@gmail.com','934b535800b1cba8f96a5d72f72f1611','The second user',22,'male',2),
(3,'posted email','33331111text','Full Name',21,'male',2),
(4,'posted email','33331111text','Full Name',21,'male',2),
(5,'posted email','33331111text','Full Name',21,'male',2),
(6,'posted email','the password','The 6th user',21,'female',2),
(7,'posted email','the password','The 7th user',21,'female',2),
(8,'posted email','33331111text','last Test',21,'female',3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
