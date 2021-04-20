-- MariaDB dump 10.19  Distrib 10.5.9-MariaDB, for osx10.16 (x86_64)
--
-- Host: localhost    Database: lanet
-- ------------------------------------------------------
-- Server version	10.5.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Lanet`
--

DROP TABLE IF EXISTS `Lanet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lanet` (
  `lanetSeq` int(11) NOT NULL AUTO_INCREMENT,
  `lanetName` varchar(30) NOT NULL COMMENT 'Channel''s Name',
  `lanetTabID` int(11) DEFAULT NULL COMMENT 'Tab''s ID',
  `lanetPenalty` int(11) DEFAULT 0 COMMENT 'count of penalty',
  `lanetMapping` int(11) DEFAULT NULL COMMENT 'connection of member - channel',
  `lanetMemberTotalCount` int(11) DEFAULT NULL COMMENT 'Total Count of members',
  `lanetDescription` varchar(100) DEFAULT NULL,
  `lanetHide` smallint(6) DEFAULT 0 COMMENT '0: show, 1: hide',
  `lanetDelete` smallint(6) DEFAULT 0 COMMENT '0: exist, 1: delete',
  `lanetOwner` int(11) NOT NULL COMMENT 'Channel''s Owner',
  `lanetCreate` datetime NOT NULL,
  PRIMARY KEY (`lanetSeq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lanet`
--

LOCK TABLES `Lanet` WRITE;
/*!40000 ALTER TABLE `Lanet` DISABLE KEYS */;
/*!40000 ALTER TABLE `Lanet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MembersJoin`
--

DROP TABLE IF EXISTS `MembersJoin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MembersJoin` (
  `memberJoinSeq` int(11) NOT NULL AUTO_INCREMENT,
  `memberJoinCategory` int(11) NOT NULL COMMENT '1: kakao, 2: naver',
  `memberJoinID` int(11) NOT NULL COMMENT 'Member''s ID',
  `memberJoinNick` varchar(50) NOT NULL COMMENT 'Member''s NickName',
  `memberJoinBirth` date DEFAULT NULL COMMENT 'birth y-m-d',
  `memberJoinSex` smallint(6) DEFAULT 1 COMMENT '1: F, 2: M',
  `memberJoinHide` smallint(6) DEFAULT 0 COMMENT '0: show, 1: hide',
  `memberJoinDelete` smallint(6) DEFAULT 0 COMMENT '0: exist, 1:delete',
  `memberJoinCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`memberJoinSeq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='멤버 회원가입 테이블';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MembersJoin`
--

LOCK TABLES `MembersJoin` WRITE;
/*!40000 ALTER TABLE `MembersJoin` DISABLE KEYS */;
/*!40000 ALTER TABLE `MembersJoin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PostReplies`
--

DROP TABLE IF EXISTS `PostReplies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PostReplies` (
  `postReplySeq` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`postReplySeq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PostReplies`
--

LOCK TABLES `PostReplies` WRITE;
/*!40000 ALTER TABLE `PostReplies` DISABLE KEYS */;
/*!40000 ALTER TABLE `PostReplies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Posts`
--

DROP TABLE IF EXISTS `Posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Posts` (
  `postSeq` int(11) NOT NULL AUTO_INCREMENT,
  `postTabID` int(11) DEFAULT NULL COMMENT 'Tab ID with Post',
  `postTitle` varchar(100) NOT NULL COMMENT 'Post''s title',
  `postContent` text NOT NULL COMMENT 'Post''s contents',
  `postMemberID` int(11) NOT NULL COMMENT 'Person who written',
  `postStampID` int(11) DEFAULT NULL COMMENT 'Connection of Stamp',
  `postUpbote` int(11) DEFAULT 0 COMMENT 'Count of upbote ',
  `postDownbote` int(11) DEFAULT 0 COMMENT 'Count of downbote',
  `postPenalty` int(11) DEFAULT 0 COMMENT 'Count of penalty',
  `postHide` smallint(6) DEFAULT 0 COMMENT '0: show, 1: hide',
  `postDelete` smallint(6) DEFAULT 0 COMMENT '0: exist, 1: delete',
  `postCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`postSeq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Posts`
--

LOCK TABLES `Posts` WRITE;
/*!40000 ALTER TABLE `Posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `Posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-12 20:02:12
