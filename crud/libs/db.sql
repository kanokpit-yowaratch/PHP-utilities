-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.21-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table inter-customer.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `cus_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cus_first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cus_last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cus_dob` date DEFAULT NULL,
  `cus_address` text COLLATE utf8_unicode_ci,
  `cus_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cus_tel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cus_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`cus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table inter-customer.customers: ~5 rows (approximately)
DELETE FROM `customers`;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`cus_id`, `cus_first_name`, `cus_last_name`, `cus_dob`, `cus_address`, `cus_email`, `cus_tel`, `created_at`, `updated_at`, `cus_status`) VALUES
	(1, 'Somchai', 'Jaidee', NULL, NULL, 'somchai@gmail.com', 'Marketting', NULL, '2018-08-05 23:26:53', 1),
	(2, 'Somying', 'Jaingam', NULL, NULL, 'somying@gmail.com', 'IT', NULL, '2018-08-05 23:26:53', 0),
	(3, 'Sommai', 'Deejai', NULL, NULL, 'sommai@gmail.com', 'Admin', NULL, '2018-08-05 23:26:53', 1),
	(4, 'Sunji', 'Vinsmoke', NULL, NULL, 'sunji@vins.com', 'Accounting', NULL, '2018-08-05 23:26:53', 0),
	(5, 'หน่อย', 'วินสโมค', NULL, NULL, 'noi@gmail.com', 'บัญชี', NULL, '2018-08-05 23:26:53', 1);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
