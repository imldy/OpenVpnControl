-- MySQL dump 10.14  Distrib 5.5.56-MariaDB, for CentOS7 (x86_64)
--
-- 主机: localhost    数据库: vpndata
-- ------------------------------------------------------
-- 服务器版本	5.5.56-MariaDB
-- 
-- by_何以潇   QQ：1744744000  大佬装逼交流群：541349340  欢迎你的加入！
-- 
-- 请勿非法修改本文件！
-- 

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
-- Table structure for table `app_admin`
--

DROP TABLE IF EXISTS `app_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_admin` (
  `id` int(11) NOT NULL,
  `op` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_admin`
--

LOCK TABLES `app_admin` WRITE;
/*!40000 ALTER TABLE `app_admin` DISABLE KEYS */;
INSERT INTO `app_admin` VALUES (1,'0','julifasadmin','julifaspass');
/*!40000 ALTER TABLE `app_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_bbs`
--

DROP TABLE IF EXISTS `app_bbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_bbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `time` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `username` text NOT NULL,
  `to` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_bbs`
--

LOCK TABLES `app_bbs` WRITE;
/*!40000 ALTER TABLE `app_bbs` DISABLE KEYS */;
INSERT INTO `app_bbs` VALUES (1,'','啦啦啦啦啦啦啦','1486670176','18233360137','0');
/*!40000 ALTER TABLE `app_bbs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_config`
--

DROP TABLE IF EXISTS `app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system` text NOT NULL,
  `qq` text NOT NULL,
  `top_content` text NOT NULL,
  `no_limit` text NOT NULL,
  `reg` int(11) NOT NULL,
  `col1` text NOT NULL,
  `col2` text NOT NULL,
  `col3` text NOT NULL,
  `col4` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_config`
--

LOCK TABLES `app_config` WRITE;
/*!40000 ALTER TABLE `app_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_daili`
--

DROP TABLE IF EXISTS `app_daili`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_daili` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qq` text NOT NULL COMMENT 'qq',
  `content` text,
  `type` int(11) DEFAULT '1' COMMENT '代理等级',
  `balance` text NOT NULL COMMENT '（元）',
  `name` text NOT NULL,
  `pass` text NOT NULL,
  `lock` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `time` int(22) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_daili`
--

LOCK TABLES `app_daili` WRITE;
/*!40000 ALTER TABLE `app_daili` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_daili` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_daili_type`
--

DROP TABLE IF EXISTS `app_daili_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_daili_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `per` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_daili_type`
--

LOCK TABLES `app_daili_type` WRITE;
/*!40000 ALTER TABLE `app_daili_type` DISABLE KEYS */;
INSERT INTO `app_daili_type` VALUES (1,'VIP1',80),(2,'VIP2',75);
/*!40000 ALTER TABLE `app_daili_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_data`
--

DROP TABLE IF EXISTS `app_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` char(255) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `key` (`key`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_data`
--

LOCK TABLES `app_data` WRITE;
/*!40000 ALTER TABLE `app_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_feedback`
--

DROP TABLE IF EXISTS `app_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_feedback`
--

LOCK TABLES `app_feedback` WRITE;
/*!40000 ALTER TABLE `app_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_gg`
--

DROP TABLE IF EXISTS `app_gg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_gg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `daili` int(11) DEFAULT '0',
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `time` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_gg`
--

LOCK TABLES `app_gg` WRITE;
/*!40000 ALTER TABLE `app_gg` DISABLE KEYS */;
INSERT INTO `app_gg` VALUES (1,0,'欢迎使用猪梦FAS流控','猪梦FAS流控由何以潇破解，欢迎您的使用，此公告管理员请自行更改或删除！','1528041043');
/*!40000 ALTER TABLE `app_gg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_kms`
--

DROP TABLE IF EXISTS `app_kms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_kms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `daili` int(11) DEFAULT '0',
  `km` varchar(64) DEFAULT NULL,
  `isuse` tinyint(1) DEFAULT '0',
  `user_id` int(50) DEFAULT NULL,
  `usetime` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `km` (`km`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1206 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_kms`
--

LOCK TABLES `app_kms` WRITE;
/*!40000 ALTER TABLE `app_kms` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_kms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_note`
--

DROP TABLE IF EXISTS `app_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `ipport` varchar(64) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `count` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_note`
--

LOCK TABLES `app_note` WRITE;
/*!40000 ALTER TABLE `app_note` DISABLE KEYS */;
INSERT INTO `app_note` VALUES (1,'默认节点','服务器IP','2017-05-03 12:58:32','不限速/看视频/聊天/刷网页',140,1);
/*!40000 ALTER TABLE `app_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_order`
--

DROP TABLE IF EXISTS `app_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payid` varchar(32) COLLATE utf8mb4_bin NOT NULL,
  `order` varchar(22) COLLATE utf8mb4_bin NOT NULL,
  `pay` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `status_time` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_order`
--

LOCK TABLES `app_order` WRITE;
/*!40000 ALTER TABLE `app_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_read`
--

DROP TABLE IF EXISTS `app_read`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_read` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `readid` text NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_read`
--

LOCK TABLES `app_read` WRITE;
/*!40000 ALTER TABLE `app_read` DISABLE KEYS */;
INSERT INTO `app_read` VALUES (1,'123456','2','1486721103'),(2,'18233360137','2','1487559081');
/*!40000 ALTER TABLE `app_read` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_tc`
--

DROP TABLE IF EXISTS `app_tc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_tc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `time` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `jg` text NOT NULL,
  `limit` text NOT NULL,
  `rate` text NOT NULL COMMENT '（单位M）',
  `url` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_tc`
--

LOCK TABLES `app_tc` WRITE;
/*!40000 ALTER TABLE `app_tc` DISABLE KEYS */;
INSERT INTO `app_tc` VALUES (3,'30day','【套餐内容】\r\n30天不限流量包月套餐\r\n【价格】\r\n30元/月','1488272300','30','30','102400','http://www.daloradius.cn');
/*!40000 ALTER TABLE `app_tc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_fwq`
--

DROP TABLE IF EXISTS `auth_fwq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_fwq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `ipport` varchar(64) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_fwq`
--

LOCK TABLES `auth_fwq` WRITE;
/*!40000 ALTER TABLE `auth_fwq` DISABLE KEYS */;
INSERT INTO `auth_fwq` VALUES (4,'默认服务器','服务器IP:1024','2018-06-03 15:49:55');
/*!40000 ALTER TABLE `auth_fwq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `line`
--

DROP TABLE IF EXISTS `line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `type` text NOT NULL,
  `group` text NOT NULL,
  `show` int(11) NOT NULL,
  `label` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `time` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `line`
--

LOCK TABLES `line` WRITE;
/*!40000 ALTER TABLE `line` DISABLE KEYS */;
INSERT INTO `line` VALUES (2,'UDP 线路 示例','#全国必免不存在的\r\n#欢迎使用猪梦FAS破解流控\r\n#本流控由何以潇破解\r\n#QQ：943756780\r\n#大佬装逼交流群：541349340    欢迎你的加入！\r\nclient\r\ndev tun\r\nproto udp\r\nremote  [domain] 53\r\nresolv-retry infinite\r\nnobind\r\npersist-key\r\npersist-tun\r\nsetenv IV_GUI_VER &quot;de.blinkt.openvpn 0.6.17&quot;\r\npush route 114.114.114.144 114.114.115.115\r\nmachine-readable-output\r\nconnect-retry-max 5\r\nconnect-retry 5\r\nresolv-retry 60\r\nauth-user-pass\r\nns-cert-type server\r\ncomp-lzo\r\nverb 3\r\n\r\n## 证书\r\n&lt;ca&gt;\r\n-----BEGIN PRIVATE KEY-----\r\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDFKE9O7qhOYeqb\r\nWm++f+prJnxgXboAURy3UE/zAUEg9M3Ec/rpzmMio4RmNxozCIqWeB8/5xLcDy3j\r\ntxbxlmpwOC5I5KKI5qD7PLaJMfkfHIdpiIjakCnnmtiXHdA5fCvKsGJzTp50PslI\r\nY1h5efuQ47xWImhyU5NIIJBNMkG+o2GJ8jLfmrFy54PTvlHP/90AlSGv5Bf2LG0r\r\nzXlpJ4fb43KpjBiFreXpnsq0WBvy94p1j1MADimNVf0jaJWmf57NA8PF0EMc3gFz\r\nwya4gSsTNU4hTErdPNfGRLK4JIqm8MU0oQhNwijYBmI/LD07FjN9JtPeKUDOgrIQ\r\nWD9YJeXHAgMBAAECggEAVINkA8TgFsF4bOHGdtWkagwUUsa6nbonYhkmPFe0UGk/\r\n7098Jk9XRZjsf1htfaTSq4+Qbbci6XwEQtHQHv1IYRRkGtEPLzoVlby/zm3CiWiU\r\nT1O8vlv/6o0A/T5FbO7iYr9bZGw2FkR3yfT0DxaQFNrad93GAgP7ZXa4BK9faVUk\r\n/+frPO9OjCDJ3CkSOJ/8bhSDjAWyerTU347hTs6Mv9l7NNV9hLIO2Wbz+SXaHNFk\r\nD9ZUIN1BXWjh9IIPODw4uigBfK/8jqQjefGi2GlGrTVhjSU38lL6T3b5emmcAlKm\r\n8AbkKJuETKQ6ixZl8x11fQsZBFx8G1+mPzZ2+i/9qQKBgQDrbFuGPE6sqh9ExMW8\r\nE024tPcZJjj8ByTqdzDNRT+fxX0xbLPpJEtWDrbas/89we6EfZvIRv8O9IlXXcmX\r\n38CmGHyfLSz76iEWqbh8MjomR924wqFr78Hw3z9730zNzPPlup+uvCSwZeuR6zBr\r\n0330OGK2TURRwVRJxT1NnisaKwKBgQDWY79FB3B5SOlJ5yZO9AjkpLGCppSWW5EK\r\npxdWlcKH4dqolv0t0gno4YOyEj7ws8Tcu2UFcxIgjz9FgMQlVNf8ZHCVW7Tq+RqF\r\nRjMeawLtvCtMaNuA/Xku2fWdL+BTuF2LyhtDr1fljvWh+oH2zqLbmYIAyxnWVI/6\r\ntzqQLetg1QKBgGVPtTdYPpcpgtlKQLnGKN1C609kVoOG44kPD+5WTaIJD+40FFxR\r\nZSY8oM4PRdki2u0jTOXsP5kE/RGe58E25iXURdUOUNx8Dg89rImt575PkQgQofzc\r\nKb7po90/5EJwX8lN/afpiXRr9+tMpgLQ+dQea8R+DdeM9iPlAJOlbHEPAoGAbISe\r\n630BhJLQazUSogJKghmPNJfHPHhq6V58pLo3dnpvKMkMrGXV2EhWVguASmxkaGp+\r\njwyZD1wS5cZxAoh4r2vTxPZflFS1BOLsuyflmpqVvB6ThS5IaduvxHnYbegzia+q\r\nr08RCcScNvpLULd1nfyM3oPvtxqkqn6WqSZlL2UCgYAV/xUn7XgDOr4gAwLqJjHN\r\nnR+GJQ97/avj9rqI0cj4wsVE2TLz3hQ0WynjVSDU7fPhObYHlfFuQeaHjAWhwiSm\r\ngq6iq1xC++FHtLIiX+u8rFTJ5eG7ey4NgkF00pTd2YlIIETRKwuFCboHhH6k+Ht5\r\nOug1gG4RGZcwY3YzAa3/zQ==\r\n-----END PRIVATE KEY-----\r\n&lt;/ca&gt;\r\nkey-direction 1\r\n&lt;tls-auth&gt;\r\n-----BEGIN OpenVPN Static key V1-----\r\n07a0c4fdc79e45b6d7d69abee82a3dca\r\n7026125b063bb19d79ff443ec144dfcd\r\n6df565ad2449cb928a89f2959e32305e\r\n86cc150c1c6e1d24e25bbdbd716b0b34\r\nce5d92f5c8133812759ca8b10295d624\r\n5e6659dafbbe31fd20971b3287fc3762\r\n555cc9cd10eaf1b2570339295ded9e61\r\ncbce6d29bd8e5c7d4aea86027beb8d3c\r\n323a5dc803ef5d574b8d5c08a981ca8d\r\n3754d34a7d60896b295823cde4bb6ab7\r\n57757ab750b06352b7a218d6814ae433\r\n4a6b1570cb680cd854aad74196cda45b\r\nb69acb97de87f1ec6cc01a2034bd7e8c\r\n3e0ffea1cccf722716bcf387e56baf04\r\n369dde778a5544ada640c15c65ec5389\r\n2ba0834a78302fab9b214bfc3dddd80e\r\n-----END OpenVPN Static key V1-----\r\n&lt;/tls-auth&gt;\r\n','更新时间：2018.06.03','1',1,'全国必免',0,'1486721267'),(3,'TCP 线路 示例','#全国必免不存在的\r\n#欢迎使用猪梦FAS破解流控\r\n#本流控由何以潇破解\r\n#QQ：943756780\r\n#大佬装逼交流群：541349340    欢迎你的加入！\r\nclient\r\ndev tun\r\nproto tcp\r\nremote [domain] 80\r\nhttp-proxy [domain] 8080\r\nresolv-retry infinite\r\nnobind\r\npersist-key\r\npersist-tun\r\nsetenv IV_GUI_VER &quot;de.blinkt.openvpn 0.6.17&quot;\r\npush route 114.114.114.144 114.114.115.115\r\nmachine-readable-output\r\nconnect-retry-max 5\r\nconnect-retry 5\r\nresolv-retry 60\r\nauth-user-pass\r\nns-cert-type server\r\ncomp-lzo\r\nverb 3\r\n\r\n## 证书\r\n&lt;ca&gt;\r\n[证书]\r\n&lt;/ca&gt;\r\nkey-direction 1\r\n&lt;tls-auth&gt;\r\n[证书]\r\n&lt;/tls-auth&gt;','更新时间：2018.06.03','1',1,'全国必免',0,'1486721267');
/*!40000 ALTER TABLE `line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `line_grop`
--

DROP TABLE IF EXISTS `line_grop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `line_grop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `show` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `line_grop`
--

LOCK TABLES `line_grop` WRITE;
/*!40000 ALTER TABLE `line_grop` DISABLE KEYS */;
INSERT INTO `line_grop` VALUES (1,'中国移动',1,1),(2,'中国电信',1,1),(3,'中国联通',1,1);
/*!40000 ALTER TABLE `line_grop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map`
--

DROP TABLE IF EXISTS `map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map`
--

LOCK TABLES `map` WRITE;
/*!40000 ALTER TABLE `map` DISABLE KEYS */;
INSERT INTO `map` VALUES (1,'versionCode','100','cfg_sj'),(2,'url','http://abc.com/a.apk','cfg_sj'),(3,'content','测试','cfg_sj'),(4,'opens','success','cfg_sj'),(5,'spic','','cfg_sj'),(6,'reg_type','default','cfg_app'),(7,'content','欢迎使用猪梦FAS流控破解产品','cfg_app'),(8,'max_limit','100','cfg_app'),(9,'SMS_T','0','cfg_app'),(10,'SMS_L','0','cfg_app'),(11,'SMS_I','0','cfg_app'),(12,'Auth_Token','cee182005162750e23855d63ed92188d','cfg_app'),(13,'Account_Sid','3b7004e5f782a6e4f1f195bc52990b','cfg_app'),(14,'APP_ID','fff126cf55e545439dfd1c16aa63d95a','cfg_app'),(15,'Template_ID','29317','cfg_app'),(16,'APP_NAME','叮咚云','cfg_app'),(17,'ca','&lt;ca&gt;\r\n-----BEGIN CERTIFICATE-----\r\nMIIE7jCCA9agAwIBAgIJAJLzuFmEowyMMA0GCSqGSIb3DQEBCwUAMIGqMQswCQYD\r\nVQQGEwJDTjELMAkGA1UECBMCQ0ExFTATBgNVBAcTDFNhbkZyYW5jaXNjbzEVMBMG\r\nA1UEChMMRm9ydC1GdW5zdG9uMRUwEwYDVQQLEwx3d3cuZGluZ2QuY24xGDAWBgNV\r\nBAMTD0ZvcnQtRnVuc3RvbiBDQTEQMA4GA1UEKRMHRWFzeVJTQTEdMBsGCSqGSIb3\r\nDQEJARYOYWRtaW5AZGluZ2QuY24wHhcNMTcwMjIxMDMzNzE4WhcNMjcwMjE5MDMz\r\nNzE4WjCBqjELMAkGA1UEBhMCQ04xCzAJBgNVBAgTAkNBMRUwEwYDVQQHEwxTYW5G\r\ncmFuY2lzY28xFTATBgNVBAoTDEZvcnQtRnVuc3RvbjEVMBMGA1UECxMMd3d3LmRp\r\nbmdkLmNuMRgwFgYDVQQDEw9Gb3J0LUZ1bnN0b24gQ0ExEDAOBgNVBCkTB0Vhc3lS\r\nU0ExHTAbBgkqhkiG9w0BCQEWDmFkbWluQGRpbmdkLmNuMIIBIjANBgkqhkiG9w0B\r\nAQEFAAOCAQ8AMIIBCgKCAQEAxShPTu6oTmHqm1pvvn/qayZ8YF26AFEct1BP8wFB\r\nIPTNxHP66c5jIqOEZjcaMwiKlngfP+cS3A8t47cW8ZZqcDguSOSiiOag+zy2iTH5\r\nHxyHaYiI2pAp55rYlx3QOXwryrBic06edD7JSGNYeXn7kOO8ViJoclOTSCCQTTJB\r\nvqNhifIy35qxcueD075Rz//dAJUhr+QX9ixtK815aSeH2+NyqYwYha3l6Z7KtFgb\r\n8veKdY9TAA4pjVX9I2iVpn+ezQPDxdBDHN4Bc8MmuIErEzVOIUxK3TzXxkSyuCSK\r\npvDFNKEITcIo2AZiPyw9OxYzfSbT3ilAzoKyEFg/WCXlxwIDAQABo4IBEzCCAQ8w\r\nHQYDVR0OBBYEFCBcOM8ljbd8B+J6Xjwj13iK7fBxMIHfBgNVHSMEgdcwgdSAFCBc\r\nOM8ljbd8B+J6Xjwj13iK7fBxoYGwpIGtMIGqMQswCQYDVQQGEwJDTjELMAkGA1UE\r\nCBMCQ0ExFTATBgNVBAcTDFNhbkZyYW5jaXNjbzEVMBMGA1UEChMMRm9ydC1GdW5z\r\ndG9uMRUwEwYDVQQLEwx3d3cuZGluZ2QuY24xGDAWBgNVBAMTD0ZvcnQtRnVuc3Rv\r\nbiBDQTEQMA4GA1UEKRMHRWFzeVJTQTEdMBsGCSqGSIb3DQEJARYOYWRtaW5AZGlu\r\nZ2QuY26CCQCS87hZhKMMjDAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IB\r\nAQBwZvIQU4d7XD1dySjCHej+i5QhK1y2BTrmYSemLnMQp9PT/wQ7bwzZjoO9jTeJ\r\nx2sMfhp0EVQCZvBFGqArNu1Ysh00mMQfWWb8K3LWbmThEkNpwoGniHBgDkPJOITM\r\nrA2HSIh53mkQt5u9H4/vmVWElhGakgEzgfNrzxj6goX5klXxRL/JqAjAJhjS06sS\r\nJPNVSZv0tdE+XaO02sPjK7/KWbwAGf4mO2v71Q+oYJdoRmAcge+gbBMg2s6rPCfv\r\nBp2g84FhG04f5KyJIVzzQ+0sCx94XE7P5HN/zjO+3QPDd7dxGZ6ia1Z5nnSRSJVa\r\nyBNWh3h8PAaAQQi7qkuJB+iF\r\n-----END CERTIFICATE-----\r\n&lt;/ca&gt;','cfg_zs'),(18,'tls','&lt;tls-auth&gt;\r\n-----BEGIN OpenVPN Static key V1-----\r\n07a0c4fdc79e45b6d7d69abee82a3dca\r\n7026125b063bb19d79ff443ec144dfcd\r\n6df565ad2449cb928a89f2959e32305e\r\n86cc150c1c6e1d24e25bbdbd716b0b34\r\nce5d92f5c8133812759ca8b10295d624\r\n5e6659dafbbe31fd20971b3287fc3762\r\n555cc9cd10eaf1b2570339295ded9e61\r\ncbce6d29bd8e5c7d4aea86027beb8d3c\r\n323a5dc803ef5d574b8d5c08a981ca8d\r\n3754d34a7d60896b295823cde4bb6ab7\r\n57757ab750b06352b7a218d6814ae433\r\n4a6b1570cb680cd854aad74196cda45b\r\nb69acb97de87f1ec6cc01a2034bd7e8c\r\n3e0ffea1cccf722716bcf387e56baf04\r\n369dde778a5544ada640c15c65ec5389\r\n2ba0834a78302fab9b214bfc3dddd80e\r\n-----END OpenVPN Static key V1-----\r\n&lt;/tls-auth&gt;','cfg_zs'),(19,'onoff','1','cfg_zs'),(21,'domain','服务器IP','cfg_zs'),(22,'LINE','abs','cfg_app'),(23,'noteoff','1','cfg_app'),(24,'connect_unlock','1','cfg_app');
/*!40000 ALTER TABLE `map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `openvpn`
--

DROP TABLE IF EXISTS `openvpn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `openvpn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iuser` varchar(16) NOT NULL,
  `isent` bigint(128) DEFAULT '0',
  `irecv` bigint(128) DEFAULT '0',
  `maxll` bigint(128) NOT NULL,
  `pass` varchar(18) NOT NULL,
  `i` int(1) NOT NULL,
  `starttime` varchar(30) DEFAULT NULL,
  `endtime` int(11) DEFAULT '0',
  `daili` int(11) DEFAULT '0',
  `online` int(11) DEFAULT '0',
  `old` int(11) DEFAULT '0',
  `last_ip` text,
  `proto` text,
  `login_time` int(11) NOT NULL DEFAULT '0',
  `remote_port` int(11) DEFAULT NULL,
  `note_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `iuser` (`iuser`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `openvpn`
--

LOCK TABLES `openvpn` WRITE;
/*!40000 ALTER TABLE `openvpn` DISABLE KEYS */;
/*!40000 ALTER TABLE `openvpn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `top`
--

DROP TABLE IF EXISTS `top`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `data` bigint(20) NOT NULL,
  `time` text NOT NULL,
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `top`
--

LOCK TABLES `top` WRITE;
/*!40000 ALTER TABLE `top` DISABLE KEYS */;
INSERT INTO `top` VALUES (5,'18233360137',289780379,'2017-02-20');
/*!40000 ALTER TABLE `top` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-03 23:52:45
