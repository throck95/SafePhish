CREATE DATABASE  IF NOT EXISTS `safephish_test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `safephish_test`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: safephish_test
-- ------------------------------------------------------
-- Server version	5.6.35

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
-- Table structure for table `default_emailsettings`
--

DROP TABLE IF EXISTS `default_emailsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_emailsettings` (
  `UserId` int(11) NOT NULL,
  `MailServer` text COLLATE utf8_unicode_ci NOT NULL,
  `MailPort` text COLLATE utf8_unicode_ci NOT NULL,
  `Username` text COLLATE utf8_unicode_ci NOT NULL,
  `CompanyName` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_emailsettings`
--

LOCK TABLES `default_emailsettings` WRITE;
/*!40000 ALTER TABLE `default_emailsettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_emailsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templates` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmailType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FileName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PublicName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_tracking`
--

DROP TABLE IF EXISTS `email_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_tracking` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `UserId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CampaignId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_tracking`
--

LOCK TABLES `email_tracking` WRITE;
/*!40000 ALTER TABLE `email_tracking` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_tracking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailing_list`
--

DROP TABLE IF EXISTS `mailing_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailing_list` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FirstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Department` int(11) NOT NULL,
  `UniqueURLId` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailing_list`
--

LOCK TABLES `mailing_list` WRITE;
/*!40000 ALTER TABLE `mailing_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailing_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailing_list_departments`
--

DROP TABLE IF EXISTS `mailing_list_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailing_list_departments` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailing_list_departments`
--

LOCK TABLES `mailing_list_departments` WRITE;
/*!40000 ALTER TABLE `mailing_list_departments` DISABLE KEYS */;
INSERT INTO `mailing_list_departments` VALUES (1,'Test'),(2,'Weird Al');
/*!40000 ALTER TABLE `mailing_list_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2016_05_31_153422_create_email_tracking_table',1),('2016_06_03_160929_create_website_tracking_table',1),('2016_06_09_161813_create_reports_table',1),('2016_06_09_162133_create_projects_table',1),('2016_06_20_193214_create_email_settings_table',1),('2016_07_12_133012_create_sent_email_table',1),('2016_07_27_142131_create_mailing_list_table',1),('2016_07_27_142642_create_user_perms_table',1),('2016_07_27_142813_create_perms_type_table',1),('2014_10_12_100000_create_password_resets_table',2),('2016_09_17_033505_create_mailing_list_departments_table',2),('2016_09_17_033535_create_email_templates_table',2),('2016_09_17_184623_create_mailing_list_table',3),('2016_11_26_225156_create_templates_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_types`
--

DROP TABLE IF EXISTS `permission_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_types` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_types`
--

LOCK TABLES `permission_types` WRITE;
/*!40000 ALTER TABLE `permission_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaigns` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Assignee` int(11) COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaigns`
--

LOCK TABLES `campaigns` WRITE;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
INSERT INTO `campaigns` VALUES (1,'test1','test',1,'active','2016-07-30 04:00:00','2016-07-30 04:00:00'),(2,'test2','test',1,'active','2016-07-31 04:00:00','2016-07-31 04:00:00'),(3,'test3','test',1,'active','2016-08-01 04:00:00','2016-08-01 04:00:00'),(4,'test4','test',1,'active','2016-08-02 04:00:00','2016-08-02 04:00:00');
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmailSubject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `UserEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OriginalFrom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CreateDate` date NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sent_email`
--

DROP TABLE IF EXISTS `sent_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sent_email` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `CampaignId` int(11) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sent_email`
--

LOCK TABLES `sent_email` WRITE;
/*!40000 ALTER TABLE `sent_email` DISABLE KEYS */;
INSERT INTO `sent_email` VALUES (1,1,1,'2016-07-30 00:00:00'),(2,1,2,'2016-07-31 00:00:00'),(3,1,3,'2016-08-01 00:00:00'),(4,1,3,'2016-08-01 00:00:00');
/*!40000 ALTER TABLE `sent_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `PermissionType` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FirstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MiddleInitial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `users_usr_username_unique` (`Username`),
  UNIQUE KEY `users_usr_email_unique` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'tthrockmorton','tthrockmorton@gaig.com','Tyler','Throckmorton','M','$2y$10$CKdwY9iiK4T0e.ko.56q4.PyUbrljwPTlJjS.eo38QTwg1FluW1nC'),(2,'throck95','tylerthrock95@gmail.com','Tyler','Throckmorton','M','$2y$10$Z/iI1QWM4pfNAIK0rcUxMeBF/jVcK6nOH7L2fD1SqyfOIgPhv.h4e'),(3,'admin','admin@safephish.com','admin','admin','','$2y$10$JBgB01a5jAAAmyoywW/nz.eOP8cAUufpxkTv6J2YtJ8F4.OJIkX8y');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website_tracking`
--

DROP TABLE IF EXISTS `website_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `website_tracking` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BrowserAgent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ReqPath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `UserId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CampaignId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_tracking`
--

LOCK TABLES `website_tracking` WRITE;
/*!40000 ALTER TABLE `website_tracking` DISABLE KEYS */;
/*!40000 ALTER TABLE `website_tracking` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-20 20:59:54
