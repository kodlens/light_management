/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 10.4.24-MariaDB : Database - lightsystem
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lightsystem` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `lightsystem`;

/*Table structure for table `buildings` */

DROP TABLE IF EXISTS `buildings`;

CREATE TABLE `buildings` (
  `building_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `buildings` */

insert  into `buildings`(`building_id`,`building_name`,`created_at`,`updated_at`) values 
(1,'ANNEX BUILDING',NULL,'2022-12-27 09:30:17'),
(3,'MAIN BUILDING','2022-12-27 09:30:24','2022-12-27 09:30:24');

/*Table structure for table `device_accesses` */

DROP TABLE IF EXISTS `device_accesses`;

CREATE TABLE `device_accesses` (
  `device_access_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` bigint(20) unsigned NOT NULL,
  `group_role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`device_access_id`),
  KEY `device_accesses_device_id_foreign` (`device_id`),
  KEY `device_accesses_group_role_id_foreign` (`group_role_id`),
  CONSTRAINT `device_accesses_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`device_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `device_accesses_group_role_id_foreign` FOREIGN KEY (`group_role_id`) REFERENCES `group_roles` (`group_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `device_accesses` */

insert  into `device_accesses`(`device_access_id`,`device_id`,`group_role_id`,`created_at`,`updated_at`) values 
(4,7,1,'2022-12-27 09:21:47','2022-12-27 09:21:47'),
(5,8,1,'2022-12-27 09:21:52','2022-12-27 09:21:52');

/*Table structure for table `devices` */

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `device_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) unsigned NOT NULL,
  `device_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token_on` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token_off` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ntuser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`device_id`),
  KEY `devices_room_id_foreign` (`room_id`),
  CONSTRAINT `devices_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `devices` */

insert  into `devices`(`device_id`,`room_id`,`device_name`,`device_ip`,`device_token_on`,`device_token_off`,`ntuser`,`created_at`,`updated_at`) values 
(7,1,'DEVICE 01','192.168.1.55','f2315ab8261c9a91721ecdb8b8bc4850','d5d733853d59b050de02bf09f4c9697a',NULL,'2022-12-27 09:13:23','2022-12-27 09:13:23'),
(8,3,'DEVICE 02','192.168.1.56','13be72506a5f2251c42a0623239aaca7','13be72506a5f2251c42a0623239aaca7',NULL,'2022-12-27 09:13:52','2022-12-27 09:29:18');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `floors` */

DROP TABLE IF EXISTS `floors`;

CREATE TABLE `floors` (
  `floor_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `floor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`floor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `floors` */

insert  into `floors`(`floor_id`,`floor_name`,`created_at`,`updated_at`) values 
(1,'1ST FLOOR',NULL,NULL),
(2,'2ND FLOOR',NULL,NULL);

/*Table structure for table `group_roles` */

DROP TABLE IF EXISTS `group_roles`;

CREATE TABLE `group_roles` (
  `group_role_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_role_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`group_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `group_roles` */

insert  into `group_roles`(`group_role_id`,`group_role_name`,`created_at`,`updated_at`) values 
(1,'ADMINISTRATOR',NULL,NULL),
(2,'GUARD',NULL,NULL),
(3,'IT',NULL,NULL),
(4,'VILMA  UG GERLIZA SIGAG MATA','2022-10-08 09:30:51','2022-10-08 09:31:18');

/*Table structure for table `group_schedule_devices` */

DROP TABLE IF EXISTS `group_schedule_devices`;

CREATE TABLE `group_schedule_devices` (
  `group_schedule_device_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_schedule_id` bigint(20) unsigned NOT NULL,
  `device_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_schedule_device_id`),
  KEY `group_schedule_id` (`group_schedule_id`),
  CONSTRAINT `group_schedule_devices_ibfk_1` FOREIGN KEY (`group_schedule_id`) REFERENCES `group_schedules` (`group_schedule_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `group_schedule_devices` */

insert  into `group_schedule_devices`(`group_schedule_device_id`,`group_schedule_id`,`device_id`,`created_at`,`updated_at`) values 
(3,12,7,'2023-01-10 21:34:16','2023-01-10 21:34:16'),
(9,12,8,'2023-01-10 23:07:53','2023-01-10 23:07:53'),
(10,13,7,'2023-01-10 23:08:51','2023-01-10 23:08:51'),
(11,13,8,'2023-01-10 23:08:51','2023-01-10 23:08:51'),
(12,14,7,'2023-01-10 23:19:45','2023-01-10 23:19:45');

/*Table structure for table `group_schedules` */

DROP TABLE IF EXISTS `group_schedules`;

CREATE TABLE `group_schedules` (
  `group_schedule_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_name` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `system_action` varchar(255) DEFAULT NULL,
  `action_type` varchar(255) DEFAULT NULL,
  `schedule_on` time DEFAULT NULL,
  `schedule_off` time DEFAULT NULL,
  `mon` tinyint(4) DEFAULT 0,
  `tue` tinyint(4) DEFAULT 0,
  `wed` tinyint(4) DEFAULT 0,
  `thu` tinyint(4) DEFAULT 0,
  `fri` tinyint(4) DEFAULT 0,
  `sat` tinyint(4) DEFAULT 0,
  `sun` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `group_schedules` */

insert  into `group_schedules`(`group_schedule_id`,`schedule_name`,`date_time`,`system_action`,`action_type`,`schedule_on`,`schedule_off`,`mon`,`tue`,`wed`,`thu`,`fri`,`sat`,`sun`,`created_at`,`updated_at`) values 
(12,'sample sched','2023-01-10 21:34:06','ON','0',NULL,NULL,0,0,0,NULL,0,0,0,'2023-01-10 21:34:16','2023-01-10 23:08:07'),
(13,'sample 2 schedule',NULL,NULL,'1','08:00:00','10:00:00',1,0,1,NULL,1,0,0,'2023-01-10 23:08:51','2023-01-10 23:08:51'),
(14,'asdaw','2023-01-10 23:19:31','ON','0',NULL,NULL,0,0,0,0,0,0,0,'2023-01-10 23:19:45','2023-01-10 23:20:06');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(157,'2014_06_06_233223_create_group_roles_table',1),
(158,'2014_10_12_000000_create_users_table',1),
(159,'2014_10_12_100000_create_password_resets_table',1),
(160,'2019_08_19_000000_create_failed_jobs_table',1),
(161,'2019_12_14_000001_create_personal_access_tokens_table',1),
(162,'2020_05_26_135614_create_buildings_table',1),
(163,'2020_05_27_135625_create_floors_table',1),
(164,'2020_05_27_135626_create_rooms_table',1),
(165,'2020_05_29_194511_create_devices_table',1),
(166,'2022_05_29_161610_create_schedules_table',1),
(167,'2022_05_30_095843_create_syslogs_table',1),
(168,'2022_06_09_102542_create_device_accesses_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `rooms` */

DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
  `room_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint(20) unsigned NOT NULL,
  `floor_id` bigint(20) unsigned NOT NULL,
  `room` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  KEY `rooms_building_id_foreign` (`building_id`),
  KEY `rooms_floor_id_foreign` (`floor_id`),
  CONSTRAINT `rooms_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `rooms` */

insert  into `rooms`(`room_id`,`building_id`,`floor_id`,`room`,`created_at`,`updated_at`) values 
(1,3,1,'ROOM 101',NULL,'2022-12-27 09:31:48'),
(2,3,1,'ROOM 102',NULL,'2022-12-27 09:31:42'),
(3,1,2,'ROOM 201',NULL,NULL),
(4,1,2,'ROOM 202',NULL,NULL);

/*Table structure for table `schedules` */

DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
  `schedule_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` bigint(20) unsigned NOT NULL,
  `schedule_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `system_action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_on` time DEFAULT NULL,
  `schedule_off` time DEFAULT NULL,
  `mon` tinyint(4) NOT NULL DEFAULT 0,
  `tue` tinyint(4) NOT NULL DEFAULT 0,
  `wed` tinyint(4) NOT NULL DEFAULT 0,
  `thu` tinyint(4) NOT NULL DEFAULT 0,
  `fri` tinyint(4) NOT NULL DEFAULT 0,
  `sat` tinyint(4) NOT NULL DEFAULT 0,
  `sun` tinyint(4) NOT NULL DEFAULT 0,
  `ntuser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`schedule_id`),
  KEY `schedules_device_id_foreign` (`device_id`),
  CONSTRAINT `schedules_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`device_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `schedules` */

insert  into `schedules`(`schedule_id`,`device_id`,`schedule_name`,`date_time`,`system_action`,`action_type`,`schedule_on`,`schedule_off`,`mon`,`tue`,`wed`,`thu`,`fri`,`sat`,`sun`,`ntuser`,`created_at`,`updated_at`) values 
(17,7,'ADW','2023-01-10 23:15:59','ON','0',NULL,NULL,0,0,0,0,0,0,0,'admin','2023-01-10 23:18:56','2023-01-10 23:18:56'),
(18,7,'XZC','2023-01-10 23:19:05',NULL,'0',NULL,NULL,0,0,0,0,0,0,0,'admin','2023-01-10 23:19:13','2023-01-10 23:19:13');

/*Table structure for table `syslogs` */

DROP TABLE IF EXISTS `syslogs`;

CREATE TABLE `syslogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `syslog` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `syslogs` */

insert  into `syslogs`(`id`,`syslog`,`username`,`action_type`,`created_at`,`updated_at`) values 
(1,'Login on the system.','admin',NULL,'2022-10-08 09:24:39','2022-10-08 09:24:39'),
(2,'Logout on the system.','admin',NULL,'2022-10-08 09:25:36','2022-10-08 09:25:36'),
(3,'Login on the system.','admin',NULL,'2022-10-08 09:27:22','2022-10-08 09:27:22'),
(4,'Logout on the system.','admin',NULL,'2022-10-08 09:32:05','2022-10-08 09:32:05'),
(5,'Login on the system.','admin',NULL,'2022-12-25 22:09:58','2022-12-25 22:09:58'),
(6,'Device turned ON. URL is 192.168.0.81.','admin','ON','2022-12-25 22:10:43','2022-12-25 22:10:43'),
(7,'Device turned OFF. URL is 192.168.0.81.','admin','OFF','2022-12-25 22:10:48','2022-12-25 22:10:48'),
(8,'Logout on the system.','admin',NULL,'2022-12-25 23:05:10','2022-12-25 23:05:10'),
(9,'Login on the system.','admin',NULL,'2022-12-25 23:10:47','2022-12-25 23:10:47'),
(10,'Login on the system.','admin',NULL,'2022-12-26 14:32:49','2022-12-26 14:32:49'),
(11,'Device 2(ESP002) updated.','admin','UPDATE','2022-12-26 14:37:21','2022-12-26 14:37:21'),
(12,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:37:30','2022-12-26 14:37:30'),
(13,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:37:36','2022-12-26 14:37:36'),
(14,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:37:41','2022-12-26 14:37:41'),
(15,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:37:44','2022-12-26 14:37:44'),
(16,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:37:49','2022-12-26 14:37:49'),
(17,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:37:55','2022-12-26 14:37:55'),
(18,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:38:09','2022-12-26 14:38:09'),
(19,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:38:11','2022-12-26 14:38:11'),
(20,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:38:18','2022-12-26 14:38:18'),
(21,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:40:12','2022-12-26 14:40:12'),
(22,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:40:15','2022-12-26 14:40:15'),
(23,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:40:17','2022-12-26 14:40:17'),
(24,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:40:23','2022-12-26 14:40:23'),
(25,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:40:26','2022-12-26 14:40:26'),
(26,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:41:48','2022-12-26 14:41:48'),
(27,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:41:49','2022-12-26 14:41:49'),
(28,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:41:51','2022-12-26 14:41:51'),
(29,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:41:54','2022-12-26 14:41:54'),
(30,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:42:13','2022-12-26 14:42:13'),
(31,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:42:16','2022-12-26 14:42:16'),
(32,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:42:18','2022-12-26 14:42:18'),
(33,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:42:20','2022-12-26 14:42:20'),
(34,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:42:46','2022-12-26 14:42:46'),
(35,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:42:55','2022-12-26 14:42:55'),
(36,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:43:00','2022-12-26 14:43:00'),
(37,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:43:04','2022-12-26 14:43:04'),
(38,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:43:08','2022-12-26 14:43:08'),
(39,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:43:11','2022-12-26 14:43:11'),
(40,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:43:36','2022-12-26 14:43:36'),
(41,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:43:42','2022-12-26 14:43:42'),
(42,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:43:46','2022-12-26 14:43:46'),
(43,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:43:47','2022-12-26 14:43:47'),
(44,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:44:13','2022-12-26 14:44:13'),
(45,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:44:15','2022-12-26 14:44:15'),
(46,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:44:16','2022-12-26 14:44:16'),
(47,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:44:17','2022-12-26 14:44:17'),
(48,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:45:25','2022-12-26 14:45:25'),
(49,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:45:27','2022-12-26 14:45:27'),
(50,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:45:33','2022-12-26 14:45:33'),
(51,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:45:34','2022-12-26 14:45:34'),
(52,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:45:35','2022-12-26 14:45:35'),
(53,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:45:37','2022-12-26 14:45:37'),
(54,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:45:44','2022-12-26 14:45:44'),
(55,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:45:47','2022-12-26 14:45:47'),
(56,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:45:54','2022-12-26 14:45:54'),
(57,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:45:55','2022-12-26 14:45:55'),
(58,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:46:33','2022-12-26 14:46:33'),
(59,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:46:36','2022-12-26 14:46:36'),
(60,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:46:38','2022-12-26 14:46:38'),
(61,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:46:40','2022-12-26 14:46:40'),
(62,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:46:45','2022-12-26 14:46:45'),
(63,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:46:50','2022-12-26 14:46:50'),
(64,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:47:01','2022-12-26 14:47:01'),
(65,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:47:07','2022-12-26 14:47:07'),
(66,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:47:12','2022-12-26 14:47:12'),
(67,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:47:16','2022-12-26 14:47:16'),
(68,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:47:20','2022-12-26 14:47:20'),
(69,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:47:23','2022-12-26 14:47:23'),
(70,'Login on the system.','admin',NULL,'2022-12-26 14:47:54','2022-12-26 14:47:54'),
(71,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:47:59','2022-12-26 14:47:59'),
(72,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:48:02','2022-12-26 14:48:02'),
(73,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:48:06','2022-12-26 14:48:06'),
(74,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:48:10','2022-12-26 14:48:10'),
(75,'Device turned ON. URL is 192.168.0.80.','admin','ON','2022-12-26 14:48:11','2022-12-26 14:48:11'),
(76,'Device turned OFF. URL is 192.168.0.80.','admin','OFF','2022-12-26 14:48:11','2022-12-26 14:48:11'),
(77,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:48:13','2022-12-26 14:48:13'),
(78,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:48:14','2022-12-26 14:48:14'),
(79,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:48:59','2022-12-26 14:48:59'),
(80,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:49:01','2022-12-26 14:49:01'),
(81,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:49:03','2022-12-26 14:49:03'),
(82,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:49:05','2022-12-26 14:49:05'),
(83,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:50:15','2022-12-26 14:50:15'),
(84,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:50:16','2022-12-26 14:50:16'),
(85,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:50:44','2022-12-26 14:50:44'),
(86,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:50:47','2022-12-26 14:50:47'),
(87,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:50:51','2022-12-26 14:50:51'),
(88,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:50:53','2022-12-26 14:50:53'),
(89,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:51:01','2022-12-26 14:51:01'),
(90,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:51:05','2022-12-26 14:51:05'),
(91,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:51:11','2022-12-26 14:51:11'),
(92,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:51:14','2022-12-26 14:51:14'),
(93,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:51:27','2022-12-26 14:51:27'),
(94,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:51:31','2022-12-26 14:51:31'),
(95,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:51:40','2022-12-26 14:51:40'),
(96,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:51:44','2022-12-26 14:51:44'),
(97,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:52:00','2022-12-26 14:52:00'),
(98,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:52:02','2022-12-26 14:52:02'),
(99,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:52:42','2022-12-26 14:52:42'),
(100,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:52:46','2022-12-26 14:52:46'),
(101,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-26 14:53:03','2022-12-26 14:53:03'),
(102,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-26 14:53:06','2022-12-26 14:53:06'),
(103,'Login on the system.','admin',NULL,'2022-12-26 21:56:47','2022-12-26 21:56:47'),
(104,'Device 2(ESP002) updated.','admin','UPDATE','2022-12-26 21:57:15','2022-12-26 21:57:15'),
(105,'Device 2(ESP002) updated.','admin','UPDATE','2022-12-26 21:57:35','2022-12-26 21:57:35'),
(106,'Device 1(ESP001) updated.','admin','UPDATE','2022-12-26 21:58:31','2022-12-26 21:58:31'),
(107,'Device 3(ESP003) deleted.','admin','DELETE','2022-12-26 21:58:46','2022-12-26 21:58:46'),
(108,'Device 4(ESP004) deleted.','admin','DELETE','2022-12-26 21:58:48','2022-12-26 21:58:48'),
(109,'Device turned ON. URL is 192.168.1.51.','admin','ON','2022-12-26 22:44:39','2022-12-26 22:44:39'),
(110,'Device turned OFF. URL is 192.168.1.51.','admin','OFF','2022-12-26 22:44:44','2022-12-26 22:44:44'),
(111,'Device turned ON. URL is 192.168.1.51.','admin','ON','2022-12-26 22:44:48','2022-12-26 22:44:48'),
(112,'Device turned OFF. URL is 192.168.1.51.','admin','OFF','2022-12-26 22:45:01','2022-12-26 22:45:01'),
(113,'Device turned ON. URL is 192.168.1.51.','admin','ON','2022-12-26 22:45:06','2022-12-26 22:45:06'),
(114,'Device turned OFF. URL is 192.168.1.51.','admin','OFF','2022-12-26 22:45:14','2022-12-26 22:45:14'),
(115,'Device turned ON. URL is 192.168.1.51.','admin','ON','2022-12-26 22:45:18','2022-12-26 22:45:18'),
(116,'Device turned OFF. URL is 192.168.1.51.','admin','OFF','2022-12-26 22:45:20','2022-12-26 22:45:20'),
(117,'Device turned ON. URL is 192.168.0.80.','admin','ON','2022-12-26 22:45:33','2022-12-26 22:45:33'),
(118,'Device turned OFF. URL is 192.168.0.80.','admin','OFF','2022-12-26 22:45:35','2022-12-26 22:45:35'),
(119,'Device turned ON. URL is 192.168.1.51.','admin','ON','2022-12-26 22:45:39','2022-12-26 22:45:39'),
(120,'Device turned OFF. URL is 192.168.1.51.','admin','OFF','2022-12-26 22:45:41','2022-12-26 22:45:41'),
(121,'Device turned ON. URL is 192.168.1.51.','admin','ON','2022-12-26 22:45:51','2022-12-26 22:45:51'),
(122,'Device turned OFF. URL is 192.168.1.51.','admin','OFF','2022-12-26 22:46:12','2022-12-26 22:46:12'),
(123,'Login on the system.','admin',NULL,'2022-12-27 06:13:23','2022-12-27 06:13:23'),
(124,'Schedule 3(SAMPLE SCHED) created.','admin',NULL,'2022-12-27 06:13:54','2022-12-27 06:13:54'),
(125,'Schedule 3(SAMPLE SCHED) deleted.','admin',NULL,'2022-12-27 06:16:56','2022-12-27 06:16:56'),
(126,'Schedule 2(TEST SCHEDULE 2) deleted.','admin',NULL,'2022-12-27 06:16:57','2022-12-27 06:16:57'),
(127,'Schedule 1(TEST SCHEDULE 1) deleted.','admin',NULL,'2022-12-27 06:16:59','2022-12-27 06:16:59'),
(128,'Schedule 4(TEST 1) created.','admin',NULL,'2022-12-27 06:17:07','2022-12-27 06:17:07'),
(129,'Schedule 4(TEST 1) deleted.','admin',NULL,'2022-12-27 06:18:43','2022-12-27 06:18:43'),
(130,'Schedule 5(TEST 1) created.','admin',NULL,'2022-12-27 06:19:37','2022-12-27 06:19:37'),
(131,'Schedule 6(TEST 2 DAYTS) created.','admin',NULL,'2022-12-27 06:20:22','2022-12-27 06:20:22'),
(132,'Schedule 7(TEST 3) created.','admin',NULL,'2022-12-27 06:22:08','2022-12-27 06:22:08'),
(133,'Schedule 6(TEST 2 DAYTS) deleted.','admin',NULL,'2022-12-27 06:22:16','2022-12-27 06:22:16'),
(134,'Schedule 7(TEST 3) updated.','admin',NULL,'2022-12-27 06:22:35','2022-12-27 06:22:35'),
(135,'Device turned ON. URL is 192.168.0.51.','admin','ON','2022-12-27 06:27:35','2022-12-27 06:27:35'),
(136,'Device turned OFF. URL is 192.168.0.51.','admin','OFF','2022-12-27 06:27:41','2022-12-27 06:27:41'),
(137,'Device turned ON. URL is 192.168.0.51.','admin','ON','2022-12-27 06:28:01','2022-12-27 06:28:01'),
(138,'Device turned OFF. URL is 192.168.0.51.','admin','OFF','2022-12-27 06:28:04','2022-12-27 06:28:04'),
(139,'Device turned ON. URL is 192.168.0.51.','admin','ON','2022-12-27 06:29:29','2022-12-27 06:29:29'),
(140,'Device turned OFF. URL is 192.168.0.51.','admin','OFF','2022-12-27 06:29:32','2022-12-27 06:29:32'),
(141,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-27 06:29:35','2022-12-27 06:29:35'),
(142,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-27 06:29:37','2022-12-27 06:29:37'),
(143,'Schedule 5(TEST 1) deleted.','admin',NULL,'2022-12-27 06:29:50','2022-12-27 06:29:50'),
(144,'Schedule 7(TEST 3) deleted.','admin',NULL,'2022-12-27 06:29:52','2022-12-27 06:29:52'),
(145,'Schedule 8(TEST DEVICE 2) created.','admin',NULL,'2022-12-27 06:30:11','2022-12-27 06:30:11'),
(146,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-27 06:44:20','2022-12-27 06:44:20'),
(147,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-27 06:44:57','2022-12-27 06:44:57'),
(148,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-27 06:45:12','2022-12-27 06:45:12'),
(149,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-27 06:45:19','2022-12-27 06:45:19'),
(150,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-27 06:46:35','2022-12-27 06:46:35'),
(151,'Device turned OFF. URL is 192.168.1.50.','admin','OFF','2022-12-27 06:46:48','2022-12-27 06:46:48'),
(152,'Device turned ON. URL is 192.168.1.50.','admin','ON','2022-12-27 06:47:18','2022-12-27 06:47:18'),
(153,'Device 2(ESP002) updated.','admin','UPDATE','2022-12-27 06:48:10','2022-12-27 06:48:10'),
(154,'Device turned ON. URL is 192.168.1.40.','admin','ON','2022-12-27 06:48:36','2022-12-27 06:48:36'),
(155,'Device turned OFF. URL is 192.168.1.40.','admin','OFF','2022-12-27 06:49:05','2022-12-27 06:49:05'),
(156,'Device turned ON. URL is 192.168.1.40.','admin','ON','2022-12-27 06:49:07','2022-12-27 06:49:07'),
(157,'Device turned OFF. URL is 192.168.1.40.','admin','OFF','2022-12-27 06:50:07','2022-12-27 06:50:07'),
(158,'Device turned ON. URL is 192.168.1.40.','admin','ON','2022-12-27 06:50:13','2022-12-27 06:50:13'),
(159,'Device turned OFF. URL is 192.168.1.40.','admin','OFF','2022-12-27 06:50:27','2022-12-27 06:50:27'),
(160,'Device turned ON. URL is 192.168.1.40.','admin','ON','2022-12-27 06:50:32','2022-12-27 06:50:32'),
(161,'Device turned OFF. URL is 192.168.1.40.','admin','OFF','2022-12-27 06:50:40','2022-12-27 06:50:40'),
(162,'Device 2(ESP002) updated.','admin','UPDATE','2022-12-27 06:52:05','2022-12-27 06:52:05'),
(163,'Device turned ON. URL is 192.168.1.40.','admin','ON','2022-12-27 06:52:49','2022-12-27 06:52:49'),
(164,'Device turned OFF. URL is 192.168.1.40.','admin','OFF','2022-12-27 06:52:52','2022-12-27 06:52:52'),
(165,'Schedule 8(TEST DEVICE 2) updated.','admin',NULL,'2022-12-27 06:53:47','2022-12-27 06:53:47'),
(166,'Schedule 9(TEST OFF) created.','admin',NULL,'2022-12-27 06:54:22','2022-12-27 06:54:22'),
(167,'Schedule 10(TEST OPTION DAY) created.','admin',NULL,'2022-12-27 06:56:56','2022-12-27 06:56:56'),
(168,'Schedule 11(TEST) created.','admin',NULL,'2022-12-27 07:25:50','2022-12-27 07:25:50'),
(169,'Schedule 12(TEST) created.','admin',NULL,'2022-12-27 07:33:36','2022-12-27 07:33:36'),
(170,'Schedule 12(TEST) deleted.','admin',NULL,'2022-12-27 07:35:11','2022-12-27 07:35:11'),
(171,'Schedule 13(TEST) created.','admin',NULL,'2022-12-27 07:36:56','2022-12-27 07:36:56'),
(172,'Schedule 14(TEST) created.','admin',NULL,'2022-12-27 07:40:42','2022-12-27 07:40:42'),
(173,'Login on the system.','admin',NULL,'2022-12-27 09:12:20','2022-12-27 09:12:20'),
(174,'Device 2(ESP002) deleted.','admin','DELETE','2022-12-27 09:12:29','2022-12-27 09:12:29'),
(175,'Device 1(ESP001) deleted.','admin','DELETE','2022-12-27 09:12:31','2022-12-27 09:12:31'),
(176,'Device 7(DEVICE 01) created.','admin','INSERT','2022-12-27 09:13:23','2022-12-27 09:13:23'),
(177,'Device 8(DEVICE 02) created.','admin','INSERT','2022-12-27 09:13:52','2022-12-27 09:13:52'),
(178,'Data 4 created.','admin','INSERT','2022-12-27 09:21:47','2022-12-27 09:21:47'),
(179,'Data 5 created.','admin','INSERT','2022-12-27 09:21:52','2022-12-27 09:21:52'),
(180,'Device 8(DEVICE 02) updated.','admin','UPDATE','2022-12-27 09:29:18','2022-12-27 09:29:18'),
(181,'Logout on the system.','admin',NULL,'2022-12-27 10:32:07','2022-12-27 10:32:07'),
(182,'Login on the system.','admin',NULL,'2023-01-10 06:28:29','2023-01-10 06:28:29'),
(183,'Logout on the system.','admin',NULL,'2023-01-10 09:22:56','2023-01-10 09:22:56'),
(184,'Login on the system.','admin',NULL,'2023-01-10 09:23:20','2023-01-10 09:23:20'),
(185,'Login on the system.','admin',NULL,'2023-01-10 13:34:21','2023-01-10 13:34:21'),
(186,'Schedule 17(ADW) created.','admin',NULL,'2023-01-10 23:18:56','2023-01-10 23:18:56'),
(187,'Schedule 18(XZC) created.','admin',NULL,'2023-01-10 23:19:13','2023-01-10 23:19:13');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_role_id` bigint(20) unsigned NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_group_role_id_foreign` (`group_role_id`),
  CONSTRAINT `users_group_role_id_foreign` FOREIGN KEY (`group_role_id`) REFERENCES `group_roles` (`group_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`lname`,`fname`,`mname`,`suffix`,`sex`,`email`,`contact_no`,`role`,`group_role_id`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin','Pradia','Gerliza','P',NULL,'FEMALE','Gerliza@light.com','09164578599','ADMINISTRATOR',1,NULL,'$2y$10$4kcHwqFua208k5yPSWrRweJYPHxCSrdaPZtXRLJg9mh2ebXZoO4gq',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
