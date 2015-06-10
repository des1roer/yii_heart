# SQL Manager Lite for MySQL 5.5.0.45357
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : localdb


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `localdb`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `localdb`;

#
# Структура для таблицы `template`: 
#

CREATE TABLE `template` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Структура для таблицы `analiz`: 
#

CREATE TABLE `analiz` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) COLLATE utf8_general_ci DEFAULT NULL,
  `template_id` INTEGER(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_analiz_template1_idx` (`template_id`) USING BTREE,
  CONSTRAINT `fk_analiz_template1` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Структура для таблицы `element`: 
#

CREATE TABLE `element` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB
AUTO_INCREMENT=3 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Структура для таблицы `analiz_has_element`: 
#

CREATE TABLE `analiz_has_element` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `analiz_id` INTEGER(11) NOT NULL,
  `element_id` INTEGER(11) NOT NULL,
  `value` VARCHAR(45) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_analiz_has_element_element1_idx` (`element_id`) USING BTREE,
  KEY `fk_analiz_has_element_analiz1_idx` (`analiz_id`) USING BTREE,
  CONSTRAINT `fk_analiz_has_element_analiz1` FOREIGN KEY (`analiz_id`) REFERENCES `analiz` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_analiz_has_element_element1` FOREIGN KEY (`element_id`) REFERENCES `element` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Структура для таблицы `template_has_element`: 
#

CREATE TABLE `template_has_element` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `template_id` INTEGER(11) NOT NULL,
  `element_id` INTEGER(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `fk_template_has_element_element1_idx` (`element_id`) USING BTREE,
  KEY `fk_template_has_element_template_idx` (`template_id`) USING BTREE,
  CONSTRAINT `fk_template_has_element_element1` FOREIGN KEY (`element_id`) REFERENCES `element` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_template_has_element_template` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Data for the `element` table  (LIMIT 0,500)
#

INSERT INTO `element` (`id`, `name`) VALUES
  (1,'1 элемент'),
  (2,'2 элемент');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;