-- Adminer 4.8.1 MySQL 8.0.37-0ubuntu0.23.10.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `buyers`;
CREATE TABLE `buyers` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `amount` int DEFAULT NULL,
  `buyer` varchar(255) DEFAULT NULL,
  `receipt_id` varchar(20) DEFAULT NULL,
  `items` varchar(255) DEFAULT NULL,
  `buyer_email` varchar(50) DEFAULT NULL,
  `buyer_ip` varchar(20) DEFAULT NULL,
  `note` text,
  `city` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `hash_key` varchar(255) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  `entry_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2024-07-26 07:00:15
