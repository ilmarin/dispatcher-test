-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: dispatch
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'Заголовок',
  `date_start` date NOT NULL COMMENT 'Дата начала',
  `date_end` date NOT NULL COMMENT 'Дата окончания',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Акции для пользователей';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES (1,'First action','2017-08-28','2017-09-05'),(2,'Second action','2017-09-06','2017-12-31');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_source`
--

DROP TABLE IF EXISTS `login_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_source` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `source` enum('site','android','iphone') NOT NULL DEFAULT 'site',
  PRIMARY KEY (`id`),
  KEY `FK_login_source_users_id` (`user_id`),
  CONSTRAINT `FK_login_source_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='История авторизаций';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_source`
--

LOCK TABLES `login_source` WRITE;
/*!40000 ALTER TABLE `login_source` DISABLE KEYS */;
INSERT INTO `login_source` VALUES (1,1,'2017-01-01 00:00:00','site'),(2,2,'2017-01-01 00:00:00','site'),(3,3,'2017-01-01 00:00:00','site'),(4,4,'2017-01-01 00:00:00','site'),(5,5,'2017-11-02 00:00:00','site'),(6,6,'2017-01-01 00:00:00','site'),(7,7,'2017-11-20 00:00:00','site'),(8,8,'2017-01-01 00:00:00','site'),(9,1,'2017-11-01 00:00:00','site'),(10,1,'2017-11-02 00:00:00','site'),(11,1,'2017-11-03 00:00:00','site'),(12,2,'2017-11-01 00:00:00','site'),(13,2,'2017-11-02 00:00:00','site'),(14,2,'2017-11-30 23:59:59','site'),(15,2,'2017-08-29 00:00:00','site'),(16,5,'2017-11-03 00:00:00','site'),(17,2,'2017-12-01 00:00:00','site'),(18,1,'2017-08-29 00:10:12','site');
/*!40000 ALTER TABLE `login_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_actions`
--

DROP TABLE IF EXISTS `user_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_actions` (
  `user_id` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`action_id`),
  KEY `FK_user_actions_actions_id` (`action_id`),
  CONSTRAINT `FK_user_actions_actions_id` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `FK_user_actions_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Участие пользователя в акции';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_actions`
--

LOCK TABLES `user_actions` WRITE;
/*!40000 ALTER TABLE `user_actions` DISABLE KEYS */;
INSERT INTO `user_actions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2);
/*!40000 ALTER TABLE `user_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `second_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='Таблица пользователей';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Petrov','Vasily','Andreivich','petr@test.ru'),(2,'Smirnov','Arkadiy','Konstantinovich','smir76@test.ru'),(3,'Sidorov','Aleksei','Dmitievich','sidor@test.ru'),(4,'Shalimov','Sergei','Genadievich','shasega@test.ru'),(5,'Andreev','Alexandr','Pavlovich','andy@test.ru'),(6,'Pavlov','Ilya','Alekseivich','pia@test.ru'),(7,'Shakina','Evgenia','Maratovna','cat@test.ru'),(8,'Rebrov','Konstantin','Leonidovich','rebrov@test.ru'),(9,'Martynova','Lada','Dmitrievna','lada@test.ru'),(10,'Gor','Anna','Sergeevna','anya@test.ru'),(11,'Berezina','Darya','Pavlovna','beda@test.ru'),(12,'Soldatova','Mariya','Stepanovna','soma@test.ru');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-16 22:16:18
