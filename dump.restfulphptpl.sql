-- MySQL dump 10.13  Distrib 5.7.24-27, for Linux (x86_64)
--
-- Host: localhost    Database: u0857234_sale
-- ------------------------------------------------------
-- Server version	5.7.24-27

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
/*!50717 SELECT COUNT(*) INTO @rocksdb_has_p_s_session_variables FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'performance_schema' AND TABLE_NAME = 'session_variables' */;
/*!50717 SET @rocksdb_get_is_supported = IF (@rocksdb_has_p_s_session_variables, 'SELECT COUNT(*) INTO @rocksdb_is_supported FROM performance_schema.session_variables WHERE VARIABLE_NAME=\'rocksdb_bulk_load\'', 'SELECT 0') */;
/*!50717 PREPARE s FROM @rocksdb_get_is_supported */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;
/*!50717 SET @rocksdb_enable_bulk_load = IF (@rocksdb_is_supported, 'SET SESSION rocksdb_bulk_load = 1', 'SET @rocksdb_dummy_bulk_load = 0') */;
/*!50717 PREPARE s FROM @rocksdb_enable_bulk_load */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;

--
-- Table structure for table `test_taxonomy_category`
--

DROP TABLE IF EXISTS `test_taxonomy_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_taxonomy_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `level` int(10) NOT NULL DEFAULT '1',
  `tleft` int(10) NOT NULL DEFAULT '0',
  `tright` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_taxonomy_category`
--

LOCK TABLES `test_taxonomy_category` WRITE;
/*!40000 ALTER TABLE `test_taxonomy_category` DISABLE KEYS */;
INSERT INTO `test_taxonomy_category` VALUES (1,'Устройства',0,1,14),(2,'Проекторы',1,2,7),(3,'Проекторы панель 2D',2,3,4),(4,'Проекторы панель 3D',2,5,6),(5,'Сенсорная панель',1,8,13),(6,'Сенсорная панель 3G',2,9,10),(7,'Сенсорная панель 4G',2,11,12);
/*!40000 ALTER TABLE `test_taxonomy_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_taxonomy_product`
--

DROP TABLE IF EXISTS `test_taxonomy_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_taxonomy_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'product name',
  `present` tinyint(1) NOT NULL DEFAULT '1',
  `price` int(10) NOT NULL DEFAULT '0',
  `manuf` varchar(255) DEFAULT NULL COMMENT 'manuf name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_taxonomy_product`
--

LOCK TABLES `test_taxonomy_product` WRITE;
/*!40000 ALTER TABLE `test_taxonomy_product` DISABLE KEYS */;
INSERT INTO `test_taxonomy_product` VALUES (1,'Телевизор 24',1,10000,'SONY'),(2,'Телевизор 24',1,10000,'SONY'),(3,'Транзистор',1,11000,'ONLY'),(4,'Силовый кабель',1,12000,'SAMSUNG'),(5,'WiFi пульт',1,13000,'DLINK'),(6,'Чехол',1,14000,'SONY'),(7,'Коробка',1,15000,'ONLY'),(8,'Батарейки',1,16000,'SAMSUNG'),(9,'Проектор 13HVG',1,17000,'SONY');
/*!40000 ALTER TABLE `test_taxonomy_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_taxonomy_xref`
--

DROP TABLE IF EXISTS `test_taxonomy_xref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_taxonomy_xref` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idp` bigint(20) NOT NULL,
  `idc` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idp` (`idp`),
  KEY `idc` (`idc`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_taxonomy_xref`
--

LOCK TABLES `test_taxonomy_xref` WRITE;
/*!40000 ALTER TABLE `test_taxonomy_xref` DISABLE KEYS */;
INSERT INTO `test_taxonomy_xref` VALUES (1,1,1),(2,1,1),(3,1,6),(4,2,7),(5,2,3),(6,3,4),(7,4,4),(8,5,1),(9,5,5),(10,6,5),(11,6,6),(12,7,2),(13,7,7),(14,7,2),(15,8,7),(16,9,3),(17,1,1),(18,1,6),(19,2,7),(20,2,3),(21,3,4),(22,4,4),(23,5,1),(24,5,5),(25,6,5),(26,6,6),(27,7,2),(28,7,7),(29,7,2),(30,8,7),(31,9,3),(32,1,1),(33,1,6),(34,2,7),(35,2,3),(36,3,4),(37,4,4),(38,5,1),(39,5,5),(40,6,5),(41,6,6),(42,7,2),(43,7,7),(44,7,2),(45,8,7),(46,9,3);
/*!40000 ALTER TABLE `test_taxonomy_xref` ENABLE KEYS */;
UNLOCK TABLES;
/*!50112 SET @disable_bulk_load = IF (@is_rocksdb_supported, 'SET SESSION rocksdb_bulk_load = @old_rocksdb_bulk_load', 'SET @dummy_rocksdb_bulk_load = 0') */;
/*!50112 PREPARE s FROM @disable_bulk_load */;
/*!50112 EXECUTE s */;
/*!50112 DEALLOCATE PREPARE s */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-20 16:16:31
