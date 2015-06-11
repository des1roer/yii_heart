# SQL Manager Lite for MySQL 5.5.1.45563
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
AUTO_INCREMENT=12 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Структура для таблицы `analiz`: 
#

CREATE TABLE `analiz` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) COLLATE utf8_general_ci DEFAULT NULL,
  `template_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_analiz_template1_idx` (`template_id`) USING BTREE,
  CONSTRAINT `fk_analiz_template1` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB
AUTO_INCREMENT=10 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
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
  KEY `fk_analiz_has_element_analiz1_idx` (`analiz_id`) USING BTREE
) ENGINE=InnoDB
AUTO_INCREMENT=14 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Структура для таблицы `element`: 
#

CREATE TABLE `element` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB
AUTO_INCREMENT=3 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
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
  CONSTRAINT `template_has_element_fk1` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE,
  CONSTRAINT `template_has_element_fk2` FOREIGN KEY (`element_id`) REFERENCES `element` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
AUTO_INCREMENT=11 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

#
# Data for the `template` table  (LIMIT 0,500)
#

INSERT INTO `template` (`id`, `name`) VALUES
  (11,'1 анализ');
COMMIT;

#
# Data for the `analiz` table  (LIMIT 0,500)
#

INSERT INTO `analiz` (`id`, `name`, `template_id`) VALUES
  (6,'1',11),
  (7,'23',11),
  (8,'434',11),
  (9,'12',11);
COMMIT;

#
# Data for the `analiz_has_element` table  (LIMIT 0,500)
#

INSERT INTO `analiz_has_element` (`id`, `analiz_id`, `element_id`, `value`) VALUES
  (9,6,2,'123'),
  (10,7,1,'3452'),
  (11,7,2,'111'),
  (12,8,2,'324'),
  (13,9,1,'34');
COMMIT;

#
# Data for the `element` table  (LIMIT 0,500)
#

INSERT INTO `element` (`id`, `name`) VALUES
  (1,'1 элемент'),
  (2,'2 элемент');
COMMIT;

#
# Data for the `template_has_element` table  (LIMIT 0,500)
#

INSERT INTO `template_has_element` (`id`, `template_id`, `element_id`) VALUES
  (9,11,1),
  (10,11,2);
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;