-- Adminer 4.8.1 MySQL 8.0.32 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `laboratory_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `laboratory_system`;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `username` char(50) NOT NULL,
  `password` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1,	'batman',	'batman'),
(2,	'batman99',	'batman99');

DROP TABLE IF EXISTS `engineering_lab`;
CREATE TABLE `engineering_lab` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `branch` varchar(50) NOT NULL,
  `room` varchar(50) NOT NULL,
  `instrument` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `caretaker` varchar(50) NOT NULL,
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2023-02-22 13:56:19
