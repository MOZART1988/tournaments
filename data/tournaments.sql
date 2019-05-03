# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: localhost (MySQL 5.7.24)
# Схема: tournaments
# Время создания: 2019-05-03 13:11:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы game
# ------------------------------------------------------------

DROP TABLE IF EXISTS `game`;

CREATE TABLE `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `stage_id` int(11) NOT NULL,
  `first_team_id` int(11) NOT NULL,
  `second_team_id` int(11) NOT NULL,
  `first_team_score` int(11) NOT NULL,
  `second_team_score` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;

INSERT INTO `game` (`id`, `title`, `created_at`, `stage_id`, `first_team_id`, `second_team_id`, `first_team_score`, `second_team_score`, `tournament_id`)
VALUES
	(1,'test','2019-01-01 00:00:00',0,0,0,0,0,0);

/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`version`, `executed_at`)
VALUES
	('20190502111444','2019-05-02 11:21:32'),
	('20190502112542','2019-05-02 11:29:53'),
	('20190502113031','2019-05-02 11:34:21'),
	('20190503052932','2019-05-03 05:31:21'),
	('20190503053831','2019-05-03 05:43:01'),
	('20190503105803','2019-05-03 11:06:45'),
	('20190503110757','2019-05-03 11:09:58'),
	('20190503113505','2019-05-03 11:46:06');

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы team
# ------------------------------------------------------------

DROP TABLE IF EXISTS `team`;

CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;

INSERT INTO `team` (`id`, `title`, `created_at`)
VALUES
	(1,'Team Secret','2019-05-03 00:00:00'),
	(2,'Team Liquid','2019-05-03 00:00:00'),
	(3,'Vega Squadron','2019-05-03 00:00:00'),
	(4,'Evil Geniuses','2019-05-03 00:00:00'),
	(5,'OG','2019-05-03 00:00:00'),
	(6,'Vici Gaming','2019-05-03 00:00:00'),
	(7,'Virtus Pro','2019-05-03 00:00:00'),
	(8,'Newbee','2019-05-03 00:00:00'),
	(9,'Gambit','2019-05-03 00:00:00'),
	(10,'Empire','2019-05-03 00:00:00'),
	(11,'Navi','2019-05-03 00:00:00'),
	(12,'LGD','2019-05-03 00:00:00'),
	(13,'LGD Young','2019-05-03 00:00:00'),
	(14,'Aliance','2019-05-03 00:00:00'),
	(15,'The Wings','2019-05-03 00:00:00'),
	(16,'DC','2019-05-03 00:00:00');

/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы team_tournament
# ------------------------------------------------------------

DROP TABLE IF EXISTS `team_tournament`;

CREATE TABLE `team_tournament` (
  `team_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `final_score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Дамп таблицы tournament
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tournament`;

CREATE TABLE `tournament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tournament` WRITE;
/*!40000 ALTER TABLE `tournament` DISABLE KEYS */;

INSERT INTO `tournament` (`id`, `title`, `created_at`)
VALUES
	(19,'International 2019','2019-05-03 13:08:28');

/*!40000 ALTER TABLE `tournament` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
