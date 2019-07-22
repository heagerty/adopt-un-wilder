-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: adopt
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Table structure for table `skill`
--

DROP TABLE IF EXISTS `skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill`
--

LOCK TABLES `skill` WRITE;
/*!40000 ALTER TABLE `skill` DISABLE KEYS */;
INSERT INTO `skill` VALUES (1,'PHP','php'),(2,'SQL','sql'),(3,'JS','js'),(4,'Symfony','symfony'),(5,'Git','git'),(6,'HTML','html'),(7,'CSS','css'),(8,'Bootstrap','bootstrap'),(9,'TDD','tdd'),(10,'Scrum','scrum'),(11,'React','react'),(12,'React Native','react-native'),(13,'C#','c-sharp'),(14,'Java','java'),(15,'Python','python'),(16,'Ruby on Rails','ruby-on-rails'),(17,'Rest API','rest-api');
/*!40000 ALTER TABLE `skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills_to_learn`
--

DROP TABLE IF EXISTS `skills_to_learn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills_to_learn` (
  `student_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`skill_id`),
  KEY `IDX_4B62300FCB944F1A` (`student_id`),
  KEY `IDX_4B62300F5585C142` (`skill_id`),
  CONSTRAINT `FK_4B62300F5585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4B62300FCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills_to_learn`
--

LOCK TABLES `skills_to_learn` WRITE;
/*!40000 ALTER TABLE `skills_to_learn` DISABLE KEYS */;
INSERT INTO `skills_to_learn` VALUES (1,3),(1,9),(1,11),(1,12),(1,15),(2,13),(2,16),(3,15),(4,10),(5,13),(5,14),(5,16),(6,6),(7,9),(7,10),(7,11),(7,12),(7,15),(8,9),(8,10),(8,13),(8,14),(8,15),(8,16),(9,11),(9,12),(9,14),(9,17),(10,5),(10,9),(10,16),(11,10),(11,12),(12,4),(12,15),(12,17),(13,1),(13,4),(13,6),(13,7),(13,8);
/*!40000 ALTER TABLE `skills_to_learn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `linked_in_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagline` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` longtext COLLATE utf8mb4_unicode_ci,
  `roles` json NOT NULL,
  `codewars_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_looking_for_internship` tinyint(1) NOT NULL,
  `is_looking_for_job` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B723AF33F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'Casey','Heagerty','1981-01-01','https://www.linkedin.com/in/caseyheagerty/','https://media.licdn.com/dms/image/C5603AQEORVAjjf0Jng/profile-displayphoto-shrink_200_200/0?e=1568246400&v=beta&t=gUFimshwsN5q7HXqAf_x84TrZs4Bm_HPJG6_zfmFD2I','casey','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Lamotte-Beuvron','Développeur back-end qui s\'interesse à React Native','Titulaire de deux diplômes de niveau bac+4 et des expériences professionnelles importantes et variées, je\r\nsouhaite suivre mes passions et apporter mes compétences uniques à un domaine interessant et en plein\r\ncroissance : le développement web.\r\n\r\nLangues\r\n• Anglais : langue maternelle\r\n• Français : courant\r\n• Italien : intermédiaire\r\n• Allemand : intermédiaire','null','heagerty','heagerty',1,1),(2,'Jenny','Evans','1988-05-01','https://www.linkedin.com/in/caseyheagerty/','/images/portraits/5b75.jpg','jenny','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Paris','Développeur back-end à la recherche d\'un stage','Coucou c\'est moi Jenny.','null','heagerty','heagerty',1,1),(3,'Gabe','McKellen','1980-05-08','https://www.linkedin.com/in/gabemckellen/','/images/portraits/c305.jpg','gabe','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Orleans','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','heagerty','heagerty',1,1),(4,'Andy','Wu','1974-06-02','https://www.linkedin.com/in/andywu/','/images/portraits/f934.jpg','andy','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Olivet','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','heagerty','heagerty',1,1),(5,'Melissa','Peterson','1984-02-02','https://www.linkedin.com/in/melissa/','/images/portraits/c8fa.jpg','melissa','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Orleans','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','sblondeau','heagerty',1,1),(6,'Bernard','Brunello','1982-11-24','https://www.linkedin.com/in/caseyheagerty/','/images/portraits/e564.jpg','bernard','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Blois','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','sblondeau','heagerty',1,1),(7,'Erica','Dupont','1899-01-01','https://www.linkedin.com/in/caseyheagerty/','/images/portraits/4df2.jpg','erica','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Orleans','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','sblondeau','heagerty',1,1),(8,'Danielle','le Beuvron','1987-12-04','https://www.linkedin.com/in/daniellelebeuvron/','/images/portraits/f144.jpg','danielle','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Bourges','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','sblondeau','heagerty',1,1),(9,'Edouard','Pointu','1992-05-20','https://www.linkedin.com/in/caseyheagerty/','/images/portraits/b2ba.jpg','edouard','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Orleans','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','sblondeau','heagerty',1,1),(10,'Arnaud','Lopez','1981-11-04','https://www.linkedin.com/in/arnaudlopez/','/images/portraits/9812.jpg','arnaud','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Saint-Cyr-en-Val','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','xNousex','heagerty',1,1),(11,'Francesca','Domeni','1982-06-16','https://www.linkedin.com/in/francescadomeni/','/images/portraits/04a1.jpg','francesca','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Orleans','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','xNousex','heagerty',1,1),(12,'Sara','Cortez','1986-08-04','https://www.linkedin.com/in/saraminh/','/images/portraits/0478.jpg','sara','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Chartres','Développeur back-end à la recherche d\'un stage',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','null','xNousex','heagerty',1,1),(13,'Sara','Git','1988-08-08','https://www.linkedin.com/in/caseyheagerty/','https://static1.squarespace.com/static/52f1466be4b00a8e06e74ff5/t/597fa7e115d5dbed1724bf39/1501538276944/Square+profile+picture+1.jpg','sara1','$argon2i$v=19$m=1024,t=2,p=2$elBPRVNqdjlTTmNZL3E4Nw$xnSfWk0zMIBQLGeI2/2nu5vPtSJgswA7Kf2B9U26CJE','Olivet','Test student for search results.',' A la suite de ma formation à la Wild Code School, je cherche un stage en PHP/Symfony.   Since Media Temple began in 1998, we’ve been on a mission to help creative agencies, designers, web developers, run and scale their business. Technology trends come and go, but one thing has never changed: our commitment to our customers’ success. Started in 2006, the Media Temple Blog aims to further this commitment by providing educational, insightful and, hopefully, valuable content about design, WordPress, web development, and more. ','[]','xNousex','heagerty',1,1);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_skill`
--

DROP TABLE IF EXISTS `student_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_skill` (
  `student_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`skill_id`),
  KEY `IDX_D60A9DEACB944F1A` (`student_id`),
  KEY `IDX_D60A9DEA5585C142` (`skill_id`),
  CONSTRAINT `FK_D60A9DEA5585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D60A9DEACB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_skill`
--

LOCK TABLES `student_skill` WRITE;
/*!40000 ALTER TABLE `student_skill` DISABLE KEYS */;
INSERT INTO `student_skill` VALUES (1,1),(1,4),(1,6),(1,8),(2,2),(2,3),(2,5),(2,9),(2,10),(3,1),(3,2),(3,3),(3,8),(3,9),(3,10),(4,2),(4,5),(4,6),(4,7),(5,2),(5,3),(5,4),(5,10),(6,4),(6,5),(6,15),(6,16),(6,17),(7,3),(7,4),(7,5),(7,12),(8,3),(8,5),(8,6),(8,8),(8,10),(9,4),(9,5),(9,8),(9,9),(9,10),(10,2),(10,4),(10,8),(10,9),(10,10),(11,2),(11,3),(11,4),(11,5),(11,8),(12,1),(12,5),(12,9),(13,6),(13,9),(13,11),(13,12),(13,13),(13,14);
/*!40000 ALTER TABLE `student_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-22  9:55:50
