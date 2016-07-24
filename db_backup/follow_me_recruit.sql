CREATE DATABASE  IF NOT EXISTS `follow_me` /*!40100 DEFAULT CHARACTER SET gbk */;
USE `follow_me`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: follow_me
-- ------------------------------------------------------
-- Server version	5.5.47

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
-- Table structure for table `recruit`
--

DROP TABLE IF EXISTS `recruit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recruit` (
  `id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL COMMENT '招聘信息id',
  `r_time` time NOT NULL COMMENT '发布时间',
  `r_status` int(11) NOT NULL COMMENT '招聘状态',
  `m_number` int(11) NOT NULL,
  `m_had_number` int(11) NOT NULL COMMENT '已经招聘了的人数',
  `r_pos` int(11) NOT NULL COMMENT '招聘的职位类型',
  `r_min_salary` float NOT NULL COMMENT '职位最低薪资',
  `r_max_salary` float NOT NULL COMMENT '职位最高薪资',
  `r_pos_instro` varchar(255) NOT NULL DEFAULT '' COMMENT '职位的工作简介',
  `r_pos_req` varchar(255) NOT NULL COMMENT '职位的能力要求',
  `r_ohter_welfare` varchar(255) NOT NULL COMMENT '公司福利',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`r_id`,`r_status`),
  KEY `fk_recruit_recruit_status1_idx` (`r_status`),
  KEY `fk_recruit_user1_idx` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recruit`
--

LOCK TABLES `recruit` WRITE;
/*!40000 ALTER TABLE `recruit` DISABLE KEYS */;
/*!40000 ALTER TABLE `recruit` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-16 17:39:54
