# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Database: symfonyRestApi
# Generation Time: 2019-11-09 12:54:06 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table group
# ------------------------------------------------------------

# Error: Table 'symfonyrestapi.group' doesn't exist


# Dump of table migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration_versions`;

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;

INSERT INTO `migration_versions` (`version`, `executed_at`)
VALUES
	('20191108103941','2019-11-08 10:39:46'),
	('20191108201203','2019-11-08 20:12:18'),
	('20191108202050','2019-11-08 20:20:58'),
	('20191108203030','2019-11-08 20:30:38'),
	('20191108205755','2019-11-08 20:58:05'),
	('20191108211025','2019-11-08 21:10:38'),
	('20191108213016','2019-11-08 21:30:27'),
	('20191108213646','2019-11-08 21:36:54');

/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `products_group_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `charged_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_845CA2C14584665A` (`product_id`),
  KEY `IDX_845CA2C1EB55C9F4` (`products_group_id`),
  CONSTRAINT `FK_845CA2C14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_845CA2C1EB55C9F4` FOREIGN KEY (`products_group_id`) REFERENCES `pgroup` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;

INSERT INTO `order_details` (`id`, `product_id`, `products_group_id`, `quantity`, `total_price`, `discount`, `created_at`, `updated_at`, `status`, `charged_price`)
VALUES
	(1,2,NULL,3,'90',0.00,'2019-11-09 11:08:30','2019-11-09 11:08:30',0,90.00),
	(4,2,NULL,2,'3200',0.20,'2019-11-09 10:06:12','2019-11-09 10:06:12',0,4000.00),
	(8,2,NULL,2,'3200',0.20,'2019-11-09 10:43:21','2019-11-09 10:43:21',0,4000.00);

/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pgroup
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pgroup`;

CREATE TABLE `pgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `pgroup` WRITE;
/*!40000 ALTER TABLE `pgroup` DISABLE KEYS */;

INSERT INTO `pgroup` (`id`, `name`, `description`, `price`)
VALUES
	(2,'ssss','ssss',1900.00),
	(3,'Test Group','This is test description',3000.00),
	(4,'Test Group','This is test description',30.00),
	(5,'Test Group','This is test description',30.00),
	(6,'Test Group','This is test description',30.00);

/*!40000 ALTER TABLE `pgroup` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pgroup_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pgroup_product`;

CREATE TABLE `pgroup_product` (
  `pgroup_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`pgroup_id`,`product_id`),
  KEY `IDX_61EADCA18DDCD155` (`pgroup_id`),
  KEY `IDX_61EADCA14584665A` (`product_id`),
  CONSTRAINT `FK_61EADCA14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_61EADCA18DDCD155` FOREIGN KEY (`pgroup_id`) REFERENCES `pgroup` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `pgroup_product` WRITE;
/*!40000 ALTER TABLE `pgroup_product` DISABLE KEYS */;

INSERT INTO `pgroup_product` (`pgroup_id`, `product_id`)
VALUES
	(3,5),
	(3,6),
	(3,7);

/*!40000 ALTER TABLE `pgroup_product` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_discount_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04ADE053FF00` (`product_discount_id`),
  CONSTRAINT `FK_D34A04ADE053FF00` FOREIGN KEY (`product_discount_id`) REFERENCES `product_discount` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;

INSERT INTO `product` (`id`, `product_discount_id`, `name`, `description`, `price`, `created_at`, `updated_at`, `quantity`)
VALUES
	(1,NULL,'Iphone','Test Desc',2000,'2019-11-07 13:03:59','2019-11-07 13:03:59',2000),
	(2,1,'Iphone','Test Desc',2000,'2019-11-07 13:07:13','2019-11-07 13:07:13',2000),
	(4,1,'Iphone','Test Desc',2000,'2019-11-07 15:11:54','2019-11-07 15:11:54',2000),
	(5,1,'Iphone','Test Desc',2000,'2019-11-07 15:11:55','2019-11-07 15:11:55',2000),
	(6,1,'Test P','Test Product description',200,'2019-11-07 15:19:05','2019-11-07 15:19:05',200),
	(7,1,'Iphone','Test Desc',2000,'2019-11-07 15:14:56','2019-11-07 15:14:56',2000);

/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_discount
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_discount`;

CREATE TABLE `product_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_value` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `discount_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `product_discount` WRITE;
/*!40000 ALTER TABLE `product_discount` DISABLE KEYS */;

INSERT INTO `product_discount` (`id`, `discount_value`, `created_at`, `updated_at`, `discount_name`)
VALUES
	(1,0.20,'2019-11-07 13:02:57','2019-11-07 13:02:57','10% off'),
	(2,0.20,'2019-11-07 13:03:40','2019-11-07 13:03:40','10% off'),
	(3,0.20,'2019-11-07 13:03:41','2019-11-07 13:03:41','10% off'),
	(4,0.20,'2019-11-07 13:03:42','2019-11-07 13:03:42','10% off'),
	(5,0.20,'2019-11-07 15:19:20','2019-11-07 15:19:20','10% off'),
	(6,0.20,'2019-11-07 15:19:21','2019-11-07 15:19:21','10% off');

/*!40000 ALTER TABLE `product_discount` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_group`;

CREATE TABLE `product_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table regenerate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `regenerate`;

CREATE TABLE `regenerate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
