-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: supermarche
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adherent`
--

DROP TABLE IF EXISTS `adherent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adherent` (
  `IdClient` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Adresse` varchar(255) DEFAULT NULL,
  `Ville` varchar(100) DEFAULT NULL,
  `CodePostal` varchar(10) DEFAULT NULL,
  `MotDePasse` varchar(100) DEFAULT NULL,
  `Date_naissance` date DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `MotMagique` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'client',
  PRIMARY KEY (`IdClient`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contenir` (
  `NumeroFacture` int(11) NOT NULL,
  `IdProduit` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL,
  PRIMARY KEY (`NumeroFacture`,`IdProduit`),
  KEY `IdProduit` (`IdProduit`),
  CONSTRAINT `contenir_ibfk_1` FOREIGN KEY (`NumeroFacture`) REFERENCES `facture` (`NumeroFacture`),
  CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`IdProduit`) REFERENCES `produit` (`IdProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `facture`
--

DROP TABLE IF EXISTS `facture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facture` (
  `NumeroFacture` int(11) NOT NULL AUTO_INCREMENT,
  `DateFacture` date NOT NULL,
  `IdClient` int(11) DEFAULT NULL,
  PRIMARY KEY (`NumeroFacture`),
  KEY `IdClient` (`IdClient`),
  CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`IdClient`) REFERENCES `adherent` (`IdClient`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `famille`
--

DROP TABLE IF EXISTS `famille`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `famille` (
  `IdFamille` int(11) NOT NULL AUTO_INCREMENT,
  `NomFamille` varchar(100) NOT NULL,
  PRIMARY KEY (`IdFamille`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produit` (
  `IdProduit` int(11) NOT NULL AUTO_INCREMENT,
  `NomProd` varchar(150) NOT NULL,
  `Prix` decimal(10,2) NOT NULL,
  `IdFamille` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT 'default.png',
  PRIMARY KEY (`IdProduit`),
  KEY `IdFamille` (`IdFamille`),
  CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`IdFamille`) REFERENCES `famille` (`IdFamille`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `vue_commandes_clients`
--

DROP TABLE IF EXISTS `vue_commandes_clients`;
/*!50001 DROP VIEW IF EXISTS `vue_commandes_clients`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vue_commandes_clients` AS SELECT 
 1 AS `Numero_Commande`,
 1 AS `Date_Commande`,
 1 AS `Nom_Client`,
 1 AS `Prenom_Client`,
 1 AS `Produit_Achete`,
 1 AS `Quantite`,
 1 AS `Prix_Unitaire`,
 1 AS `Total_Ligne`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'supermarche'
--

--
-- Final view structure for view `vue_commandes_clients`
--

/*!50001 DROP VIEW IF EXISTS `vue_commandes_clients`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vue_commandes_clients` AS select `f`.`NumeroFacture` AS `Numero_Commande`,`f`.`DateFacture` AS `Date_Commande`,`a`.`Nom` AS `Nom_Client`,`a`.`Prenom` AS `Prenom_Client`,`p`.`NomProd` AS `Produit_Achete`,`c`.`Quantite` AS `Quantite`,`p`.`Prix` AS `Prix_Unitaire`,`c`.`Quantite` * `p`.`Prix` AS `Total_Ligne` from (((`facture` `f` join `adherent` `a` on(`f`.`IdClient` = `a`.`IdClient`)) join `contenir` `c` on(`f`.`NumeroFacture` = `c`.`NumeroFacture`)) join `produit` `p` on(`c`.`IdProduit` = `p`.`IdProduit`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-15 11:21:28
