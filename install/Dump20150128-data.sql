CREATE DATABASE  IF NOT EXISTS `tss` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tss`;
-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: 127.0.0.1    Database: tss
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `campus`
--

DROP TABLE IF EXISTS `campus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campusName` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campus`
--

LOCK TABLES `campus` WRITE;
/*!40000 ALTER TABLE `campus` DISABLE KEYS */;
INSERT INTO `campus` VALUES (1,'Lille'),(2,'Paris'),(3,'Sophia Antipolis'),(4,'Suzhou'),(5,'Raleigh');
/*!40000 ALTER TABLE `campus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discipline`
--

DROP TABLE IF EXISTS `discipline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discipline` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `discipline` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discipline`
--

LOCK TABLES `discipline` WRITE;
/*!40000 ALTER TABLE `discipline` DISABLE KEYS */;
INSERT INTO `discipline` VALUES (1,'Finance'),(2,'Marketing'),(3,'HR'),(4,'IS');
/*!40000 ALTER TABLE `discipline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `market`
--

DROP TABLE IF EXISTS `market`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `market` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` char(20) DEFAULT NULL,
  `titre` varchar(80) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1719 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `market`
--

LOCK TABLES `market` WRITE;
/*!40000 ALTER TABLE `market` DISABLE KEYS */;
INSERT INTO `market` VALUES (1702,231,'Proposer','Micro SHURE SM-58','C&#039;est LE micro dynamique de chant le plus utilis&eacute; en Live, une r&eacute;f&eacute;rence dans le monde de la musique.\r\nPratique d&#039;utilisation, on le pr&ecirc;te avec son cable xlr et adaptateur pour que vous puissiez le brancher directement &agrave; l&#039;ordinateur','2014-09-25 12:41:21'),(1703,231,'Proposer','INTERFACE AUDIO Focusrite Scarlett 2i4','Pour une qualit&eacute; de son optimale, l&#039;interface audio interviens entre le micro et l&#039;ordinateur pour traiter le son au moment de sa prise. L&#039;interface audio est compatible avec le Mirco SHURE SM-58 ou n&#039;importe quel instrument ou appareil via une entr&eacute;e gros jack ou xlr','2014-09-25 12:46:18'),(1704,232,'Proposer','Formation Wiki','Nous vous offrons la possibilit&eacute; d&#039;une formation sur le &quot;codage&quot; wiki, qui sera tr&egrave;s utile aux jardiniers.','2014-09-25 15:43:21'),(1705,234,'Proposer','Formation Wiki','N&#039;h&eacute;sitez pas si vous avez des difficult&eacute;s &agrave; coder sur Wiki.\r\nJ&#039;&eacute;tais en &eacute;cole d&#039;ing&eacute;nieur avant.','2014-09-25 19:06:01'),(1707,246,'Proposer','Formation wiki &amp; code','Vous rencontrez des probl&egrave;mes relatifs aux consignes demand&eacute;es ? Vous souhaitez d&eacute;marrer ou vous voulez mettre en avant votre page wiki et vous d&eacute;marquer des autres ? \r\n\r\nJe vous propose mes services! Je suis webdesigneuse, campus Sophia :)','2014-09-27 14:32:40'),(1708,224,'Proposer','le ellearning pour les nuls','testt','2015-01-28 16:11:41'),(1710,224,'Proposer','elearning pour les nuls','essai','2015-01-28 16:12:06'),(1712,224,'Proposer','encore un','sujet super top','2015-01-28 16:48:59');
/*!40000 ALTER TABLE `market` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program`
--

DROP TABLE IF EXISTS `program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `programName` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program`
--

LOCK TABLES `program` WRITE;
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
INSERT INTO `program` VALUES (1,'BC & ISM'),(2,'IB'),(3,'LFM'),(5,'GD');
/*!40000 ALTER TABLE `program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sk_configuration`
--

DROP TABLE IF EXISTS `sk_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sk_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sk_configuration`
--

LOCK TABLES `sk_configuration` WRITE;
/*!40000 ALTER TABLE `sk_configuration` DISABLE KEYS */;
INSERT INTO `sk_configuration` VALUES (1,'website_name','Thesis Selection System'),(2,'website_url','localhost/~marc/tss'),(3,'email','marc.augier@skema.edu'),(4,'activation','false'),(5,'resend_activation_threshold','0'),(6,'language','models/languages/en.php'),(7,'template','models/site-templates/six.css'),(8,'ldap','false'),(9,'ldap_host',''),(10,'ldap_port',''),(11,'ldap_basedn',''),(12,'ldap_search_dn',''),(13,'ldap_version',''),(14,'ldap_rdn',''),(15,'ldap_pass',''),(16,'ldap_pass_placeholder','');
/*!40000 ALTER TABLE `sk_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sk_pages`
--

DROP TABLE IF EXISTS `sk_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sk_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sk_pages`
--

LOCK TABLES `sk_pages` WRITE;
/*!40000 ALTER TABLE `sk_pages` DISABLE KEYS */;
INSERT INTO `sk_pages` VALUES (1,'account.php',1),(2,'activate-account.php',0),(3,'admin_configuration.php',3),(4,'admin_page.php',3),(5,'admin_pages.php',3),(6,'admin_permission.php',3),(7,'admin_permissions.php',3),(8,'admin_user.php',3),(9,'admin_users.php',3),(10,'forgot-password.php',0),(11,'index.php',0),(14,'logout.php',1),(15,'register.php',0),(16,'resend-activation.php',0),(17,'user_settings.php',1),(18,'admin_init.php',0),(19,'market.php',0),(20,'pay.php',0),(21,'wok.php',0);
/*!40000 ALTER TABLE `sk_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sk_permission_page_matches`
--

DROP TABLE IF EXISTS `sk_permission_page_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sk_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sk_permission_page_matches`
--

LOCK TABLES `sk_permission_page_matches` WRITE;
/*!40000 ALTER TABLE `sk_permission_page_matches` DISABLE KEYS */;
INSERT INTO `sk_permission_page_matches` VALUES (1,1,1),(2,1,14),(3,1,17),(4,2,1),(5,2,3),(6,3,4),(7,3,5),(8,3,6),(9,3,7),(10,3,8),(11,3,9),(12,2,14),(13,2,17),(14,3,14),(15,3,1),(16,2,1),(17,1,16),(18,2,16),(19,3,17);
/*!40000 ALTER TABLE `sk_permission_page_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sk_permissions`
--

DROP TABLE IF EXISTS `sk_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sk_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sk_permissions`
--

LOCK TABLES `sk_permissions` WRITE;
/*!40000 ALTER TABLE `sk_permissions` DISABLE KEYS */;
INSERT INTO `sk_permissions` VALUES (1,'Student'),(2,'Professor'),(3,'Administrator');
/*!40000 ALTER TABLE `sk_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sk_user_permission_matches`
--

DROP TABLE IF EXISTS `sk_user_permission_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sk_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1980 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sk_user_permission_matches`
--

LOCK TABLES `sk_user_permission_matches` WRITE;
/*!40000 ALTER TABLE `sk_user_permission_matches` DISABLE KEYS */;
INSERT INTO `sk_user_permission_matches` VALUES (1845,222,1),(1846,223,2),(1847,224,2),(1848,225,1),(1849,226,3),(1850,227,1),(1851,228,1),(1852,229,1),(1853,230,1),(1854,231,1),(1855,232,1),(1856,233,1),(1857,234,1),(1858,235,1),(1859,236,1),(1860,237,1),(1861,238,1),(1862,239,1),(1863,240,1),(1864,241,1),(1865,242,1),(1866,243,1),(1867,244,1),(1868,245,1),(1869,246,1),(1870,247,1),(1871,248,1),(1872,249,1),(1873,250,1),(1874,251,1),(1875,252,1),(1876,253,1),(1877,254,1),(1878,255,1),(1879,256,1),(1880,257,1),(1881,258,1),(1882,259,1),(1883,260,1),(1884,261,1),(1885,262,1),(1886,263,1),(1887,264,1),(1888,265,1),(1889,266,1),(1890,267,1),(1891,268,1),(1892,269,1),(1893,270,1),(1894,271,1),(1895,272,1),(1896,273,1),(1897,274,1),(1898,275,1),(1899,276,1),(1900,277,1),(1901,278,1),(1902,279,1),(1903,280,1),(1904,281,1),(1905,282,1),(1906,283,1),(1907,284,1),(1908,285,1),(1909,286,1),(1910,287,1),(1911,288,1),(1912,289,1),(1913,290,1),(1914,291,1),(1915,292,1),(1916,293,1),(1917,294,1),(1918,295,1),(1919,296,1),(1920,297,1),(1921,298,1),(1922,299,1),(1923,300,1),(1924,301,1),(1925,302,1),(1926,303,1),(1927,304,1),(1928,305,1),(1929,306,1),(1930,307,1),(1931,308,1),(1932,309,1),(1933,310,1),(1934,311,1),(1935,312,1),(1936,313,1),(1937,314,1),(1938,315,1),(1939,316,1),(1940,317,1),(1941,318,1),(1942,319,1),(1943,320,1),(1944,321,1),(1945,322,1),(1946,323,1),(1947,324,1),(1948,325,1),(1949,326,1),(1950,327,1),(1951,328,1),(1952,329,1),(1953,330,1),(1954,331,1),(1955,332,1),(1956,333,1),(1957,334,1),(1958,335,1),(1959,336,1),(1960,337,1),(1961,338,1),(1962,339,1),(1963,340,1),(1964,341,1),(1965,342,1),(1966,343,1),(1967,344,1),(1968,345,1),(1969,346,1),(1970,347,1),(1971,348,1),(1972,349,1),(1973,350,1),(1974,351,1),(1975,352,1),(1976,353,1),(1977,354,1),(1978,0,1),(1979,0,1);
/*!40000 ALTER TABLE `sk_user_permission_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sk_users`
--

DROP TABLE IF EXISTS `sk_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `disciplineId` int(11) unsigned NOT NULL,
  `campusId` int(11) unsigned NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campusId` (`campusId`),
  CONSTRAINT `sk_users_ibfk_1` FOREIGN KEY (`campusId`) REFERENCES `campus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sk_users`
--

LOCK TABLES `sk_users` WRITE;
/*!40000 ALTER TABLE `sk_users` DISABLE KEYS */;
INSERT INTO `sk_users` VALUES (224,'prof','MÃ©lanie CIUSSI','9051a509f95691159c7ed617fd884f29af9213d747b13b6c7860fff6fb40cb24d','melanie.ciussi@skema.edu','d9fa9cf7c6b6e75745b00501d5ae64d6',1409911793,0,1,'New Member',1,3,1409911793,1422481795),(226,'augier','Marc Augier','9051a509f95691159c7ed617fd884f29af9213d747b13b6c7860fff6fb40cb24d','marc.augier@ceram.fr','7aced716cf2be504db66150bf0d0e0f0',1410376902,0,1,'New Member',3,3,1410376902,1422395095),(228,'stud','John CHUA','9051a509f95691159c7ed617fd884f29af9213d747b13b6c7860fff6fb40cb24d','john.chua@skema.edu','0cf0ce73183c44103bc8c8c6b311a2f4',1411389319,0,1,'John CHUA',2,2,1411389319,1422480447);
/*!40000 ALTER TABLE `sk_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_program`
--

DROP TABLE IF EXISTS `user_program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_program` (
  `idUser` int(11) NOT NULL,
  `idProgram` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idProgram`),
  KEY `idProgram` (`idProgram`),
  CONSTRAINT `user_program_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `sk_users` (`id`),
  CONSTRAINT `user_program_ibfk_2` FOREIGN KEY (`idProgram`) REFERENCES `program` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_program`
--

LOCK TABLES `user_program` WRITE;
/*!40000 ALTER TABLE `user_program` DISABLE KEYS */;
INSERT INTO `user_program` VALUES (228,2),(224,3);
/*!40000 ALTER TABLE `user_program` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-28 22:56:43
