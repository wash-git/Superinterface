-- MySQL dump 10.19  Distrib 10.3.29-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: baseportlet
-- ------------------------------------------------------
-- Server version	10.3.29-MariaDB-0+deb10u1

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
-- Table structure for table `instituicoes`
--

DROP TABLE IF EXISTS `instituicoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instituicoes` (
  `id_chave_instituicao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_instituicao` varchar(1000) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_chave_instituicao`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci COMMENT='Contém o registro das instituições com interesse na Lei Aldir Blanc. Pode incluir governos, organizações sociais, empresas, secretarias, etc.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instituicoes`
--

LOCK TABLES `instituicoes` WRITE;
/*!40000 ALTER TABLE `instituicoes` DISABLE KEYS */;
INSERT INTO `instituicoes` VALUES (1,'Instituição Indefinida','2021-04-18 05:10:14'),(2,'Cemaden','2021-04-18 05:22:52'),(3,'Presidência da República','2021-04-18 12:07:48'),(5,'Secretaria Especial da Cultura','2021-04-20 22:02:30'),(6,'Secretária de Cultura e Economia Criativa do Estado de São Paulo','2021-04-20 22:24:35'),(7,'Secretaria de Cultura e Economia Criativa do Estado de São Paulo','2021-04-20 22:25:25'),(8,'Senado Federal','2021-04-20 22:45:49'),(9,'Movimento Artigo 5º','2021-04-20 23:09:57'),(10,'SESC RJ','2021-04-20 23:16:25'),(11,'Forum Paulista Aldir Blanc','2021-04-21 04:46:26'),(12,'Comitê Gestor Estadual SP','2021-04-21 14:14:19'),(13,'Ministério Público do Estado de São Paulo','2021-04-21 14:16:44'),(14,'Confederação Nacional de Municípios','2021-04-21 14:19:21'),(15,'Ministério da Cultura','2021-04-21 15:13:13'),(16,'Fórum Municipal de Emergência Cultural','2021-04-21 15:41:49'),(17,'SENAC RJ','2021-04-21 16:09:27'),(18,'Escola de Políticas Culturais','2021-04-21 16:10:07'),(19,'Prefeitura de Birigui','2021-04-21 16:57:20'),(20,'Câmara dos Deputados','2021-04-21 21:23:05'),(21,'Governo do Estado de São Paulo','2021-04-21 23:15:20'),(22,'PREFEITURA MUNICIPAL DE SÃO LEOPOLDO','2021-04-21 23:31:24'),(23,'Estado do Rio Grande do Sul','2021-04-21 23:31:47'),(24,'teste de adição','2021-04-22 17:10:48'),(25,'Prefitura de Taubaté','2021-04-22 17:30:50'),(26,'Prefeitura de Taubaté','2021-04-22 17:31:13'),(27,'Governo do Estado do Mato Grosso do Sul','2021-04-26 13:41:01'),(28,'Prefeitura de Ipuaçu','2021-04-26 14:03:03'),(29,'Prefeitura Municipal de Taubaté','2021-04-26 16:05:21'),(30,'Conferência Popular de Cultura','2021-04-29 11:43:53'),(31,'Fundação de Cultura de Mato Grosso do Sul – FCMS/MS','2021-04-29 12:18:42'),(32,'SECRETARIA NACIONAL DA ECONOMIA CRIATIVA E DIVERSIDADE CULTURAL','2021-04-29 12:40:45'),(33,'SECRETARIA NACIONAL DA ECONOMIA CRIATIVA E DIVERSIDADE CULTURAL','2021-04-29 14:38:01'),(34,'SECRETARIA NACIONAL DA ECONOMIA CRIATIVA E DIVERSIDADE CULTURAL','2021-04-29 14:38:39'),(35,'COORDENAÇÃO-GERAL DA POLÍTICA NACIONAL DE CULTURA VIVA','2021-04-29 14:52:57'),(36,'SECRETARIA NACIONAL DA ECONOMIA CRIATIVA E DIVERSIDADE CULTURAL','2021-04-29 14:53:38'),(37,'DEPARTAMENTO DE PROMOÇÃO DA DIVERSIDADE CULTURAL','2021-04-29 14:54:10'),(38,'SECRETARIA NACIONAL DA ECONOMIA CRIATIVA E DIVERSIDADE CULTURAL','2021-04-29 14:58:47'),(39,'Fundação de Cultura de Mato Grosso do Sul','2021-04-29 17:33:29'),(40,'Secretaria de Cultura do Estado do Ceará','2021-05-02 17:08:39'),(41,'Fundação de Cultura de Mato Grosso do Sul','2021-05-02 17:11:04'),(42,'ProAc Expresso LAB','2021-05-02 17:31:02'),(43,'Receita Federal','2021-05-20 18:29:09'),(44,'Secretaria Municipal de Cultura','2021-05-22 14:10:18'),(45,'Prefeitura Municipal de Campinas','2021-05-28 18:52:26'),(46,'Prefeitura Municipal de Costa Rica','2021-05-28 19:10:15'),(47,'Procuradoria-Geral do Município','2021-05-28 19:10:32'),(48,'Subsecretaria de Assuntos Legislativos','2021-05-28 19:10:46'),(49,'Estado de Mato Grosso do Sul','2021-05-28 19:11:03'),(50,'Prefeitura Municipal de Rondonópolis','2021-05-28 19:11:19'),(51,'Secretaria Municipal de Governo','2021-05-28 19:11:32');
/*!40000 ALTER TABLE `instituicoes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-02 18:29:18
