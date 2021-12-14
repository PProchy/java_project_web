-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `java_project`;
CREATE DATABASE `java_project` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `java_project`;

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(255) NOT NULL,
  `house_number` varchar(10) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `address` (`id`, `street`, `house_number`, `postal_code`, `city`, `state`) VALUES
(8,	'Suchdolská',	'56486',	'6858',	'Praha',	'CZ'),
(9,	'Uliční',	'101',	'27601',	'Praha',	'Česká republika'),
(12,	'Pražská',	'12345',	'11000',	'Praha',	'Česká republika'),
(14,	'U Skály',	'315888',	'276 01',	'Mělník',	'Česká republika');

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pages` int(4) NOT NULL,
  `is_borrowed` int(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `book_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `book` (`id`, `name`, `pages`, `is_borrowed`, `user_id`) VALUES
(16,	'Sněhulák',	666,	0,	NULL),
(18,	'Romeo a Julča',	555,	1,	13),
(23,	'Jolanda',	999,	1,	13),
(28,	'Test',	555,	1,	12);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `birth` date DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`id`, `name`, `surname`, `birth`, `address_id`) VALUES
(12,	'Jan',	'Novák',	'1910-10-10',	8),
(13,	'Pavel',	'Procházka',	'1994-12-12',	12),
(15,	'Jan',	'Cukrberg',	'1970-12-22',	9);

-- 2021-12-14 16:02:50
