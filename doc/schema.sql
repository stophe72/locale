-- MariaDB dump 10.17  Distrib 10.4.13-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: guy
-- ------------------------------------------------------
-- Server version	10.4.13-MariaDB

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
-- Table structure for table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adresse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adresse1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codePostal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `agenceBancaire`
--

DROP TABLE IF EXISTS `agenceBancaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenceBancaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeBanque` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agenceBancaire_FK` (`groupeId`),
  CONSTRAINT `agenceBancaire_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bailleur`
--

DROP TABLE IF EXISTS `bailleur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bailleur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseId` int(11) NOT NULL,
  `contactId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notaire_FK` (`contactId`) USING BTREE,
  KEY `notaire_FK_1` (`adresseId`) USING BTREE,
  KEY `tribunal_FK` (`groupeId`) USING BTREE,
  CONSTRAINT `bailleur_FK` FOREIGN KEY (`adresseId`) REFERENCES `adresse` (`id`),
  CONSTRAINT `bailleur_FK_1` FOREIGN KEY (`contactId`) REFERENCES `contact` (`id`),
  CONSTRAINT `bailleur_FK_2` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `compteGestion`
--

DROP TABLE IF EXISTS `compteGestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compteGestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `donneeBancaireId` int(11) NOT NULL,
  `date` date NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typeOperationId` int(11) DEFAULT NULL,
  `nature` int(11) NOT NULL,
  `montant` double NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `compteGestion_FK_1` (`typeOperationId`),
  KEY `compteGestion_FK_3` (`donneeBancaireId`),
  CONSTRAINT `compteGestion_FK_1` FOREIGN KEY (`typeOperationId`) REFERENCES `typeOperation` (`id`),
  CONSTRAINT `compteGestion_FK_3` FOREIGN KEY (`donneeBancaireId`) REFERENCES `donneeBancaire` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `telephone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contactExterne`
--

DROP TABLE IF EXISTS `contactExterne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactExterne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactId` int(11) NOT NULL,
  `lien` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contactExterne_FK` (`contactId`),
  KEY `jugement_FK_majeur` (`majeurId`) USING BTREE,
  CONSTRAINT `contactExterne_FK` FOREIGN KEY (`contactId`) REFERENCES `contact` (`id`),
  CONSTRAINT `jugement_FK_majeur_copy` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `deces`
--

DROP TABLE IF EXISTS `deces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `pompeFunebreId` int(11) NOT NULL,
  `concession` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cimetiere` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referenceConcession` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `deces_FK` (`pompeFunebreId`),
  CONSTRAINT `deces_FK` FOREIGN KEY (`pompeFunebreId`) REFERENCES `pompeFunebre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `donneeBancaire`
--

DROP TABLE IF EXISTS `donneeBancaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `donneeBancaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `agenceBancaireId` int(11) NOT NULL,
  `typeCompteId` int(11) NOT NULL,
  `numeroCompte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soldeCourant` float DEFAULT 0,
  `soldePrecedent` float DEFAULT 0,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `donneeBancaire_FK` (`majeurId`),
  KEY `donneeBancaire_FK_1` (`agenceBancaireId`),
  KEY `donneeBancaire_FK_2` (`typeCompteId`),
  CONSTRAINT `donneeBancaire_FK` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`),
  CONSTRAINT `donneeBancaire_FK_1` FOREIGN KEY (`agenceBancaireId`) REFERENCES `agenceBancaire` (`id`),
  CONSTRAINT `donneeBancaire_FK_2` FOREIGN KEY (`typeCompteId`) REFERENCES `typeCompte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `familleCompte`
--

DROP TABLE IF EXISTS `familleCompte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `familleCompte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `familleCompte_FK` (`groupeId`),
  CONSTRAINT `familleCompte_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `familleTypeOperation`
--

DROP TABLE IF EXISTS `familleTypeOperation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `familleTypeOperation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelleRapport` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordreAffichage` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `familleTypeOperation_FK` (`groupeId`),
  CONSTRAINT `familleTypeOperation_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ficheFrais`
--

DROP TABLE IF EXISTS `ficheFrais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ficheFrais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mandataireId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ficheFrais_FK` (`mandataireId`),
  CONSTRAINT `ficheFrais_FK` FOREIGN KEY (`mandataireId`) REFERENCES `mandataire` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `periode_FK` (`userId`) USING BTREE,
  CONSTRAINT `periode_FK_user_groupe` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `immobilier`
--

DROP TABLE IF EXISTS `immobilier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `immobilier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `notaireId` int(11) DEFAULT NULL,
  `syndicId` int(11) DEFAULT NULL,
  `bailleurId` int(11) DEFAULT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mesure_FK` (`majeurId`) USING BTREE,
  KEY `immobilier_FK` (`bailleurId`),
  KEY `immobilier_FK_2` (`notaireId`),
  CONSTRAINT `immobilier_FK` FOREIGN KEY (`bailleurId`) REFERENCES `bailleur` (`id`),
  CONSTRAINT `immobilier_FK_1` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`),
  CONSTRAINT `immobilier_FK_2` FOREIGN KEY (`notaireId`) REFERENCES `notaire` (`id`),
  CONSTRAINT `immobilier_FK_3` FOREIGN KEY (`id`) REFERENCES `syndic` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `importOperation`
--

DROP TABLE IF EXISTS `importOperation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `importOperation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `majeurId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typeOperationId` int(11) NOT NULL,
  `nature` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `importOperation_FK` (`majeurId`),
  KEY `importOperation_FK_2` (`typeOperationId`),
  KEY `importOperation_FK_1` (`groupeId`),
  CONSTRAINT `importOperation_FK` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`),
  CONSTRAINT `importOperation_FK_1` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`),
  CONSTRAINT `importOperation_FK_2` FOREIGN KEY (`typeOperationId`) REFERENCES `typeOperation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jugement`
--

DROP TABLE IF EXISTS `jugement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jugement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `dateJugement` date NOT NULL,
  `tribunalId` int(11) NOT NULL,
  `numeroRG` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debutMesure` date NOT NULL,
  `finMesure` date NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jugement_FK_tribunal` (`tribunalId`),
  KEY `jugement_FK_majeur` (`majeurId`),
  CONSTRAINT `jugement_FK_majeur` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`),
  CONSTRAINT `jugement_FK_tribunal` FOREIGN KEY (`tribunalId`) REFERENCES `tribunal` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lieuVie`
--

DROP TABLE IF EXISTS `lieuVie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lieuVie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lieuVie_FK` (`groupeId`),
  CONSTRAINT `lieuVie_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `majeur`
--

DROP TABLE IF EXISTS `majeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `majeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `civilite` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomEtatCivil` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseId` int(11) NOT NULL,
  `contactId` int(11) NOT NULL,
  `dateNaissance` date NOT NULL,
  `lieuNaissance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationalite` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroSS` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdphId` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `majeur_FK_1` (`civilite`),
  KEY `majeur_FK_contact` (`contactId`),
  KEY `majeur_FK` (`groupeId`),
  KEY `majeur_FK_adresse` (`adresseId`),
  CONSTRAINT `majeur_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`),
  CONSTRAINT `majeur_FK_adresse` FOREIGN KEY (`adresseId`) REFERENCES `adresse` (`id`),
  CONSTRAINT `majeur_FK_contact` FOREIGN KEY (`contactId`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mandataire`
--

DROP TABLE IF EXISTS `mandataire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mandataire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `groupeId` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mandataire_FK` (`adresseId`),
  KEY `mandataire_FK_1` (`userId`),
  KEY `mandataire_FK_2` (`groupeId`),
  CONSTRAINT `mandataire_FK` FOREIGN KEY (`adresseId`) REFERENCES `adresse` (`id`),
  CONSTRAINT `mandataire_FK_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  CONSTRAINT `mandataire_FK_2` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mdph`
--

DROP TABLE IF EXISTS `mdph`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mdph` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateFinAah` date DEFAULT NULL COMMENT 'Allocation aux Adultes Handicapés',
  `dateFinCi` date DEFAULT NULL,
  `dateFinOrientationPro` date DEFAULT NULL,
  `dateFinOrientationFoyer` date DEFAULT NULL,
  `dateFinOrientationSavs` date DEFAULT NULL COMMENT 'Service d''Accompagnement à la Vie Sociale',
  `dateFinRqth` date DEFAULT NULL COMMENT 'Reconnaissance de la Qualité de Travailleur Handicapé',
  `dateFinPch` date DEFAULT NULL COMMENT 'Prestation de Compensation du Handicap',
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdph_FK_majeur` (`majeurId`),
  CONSTRAINT `mdph_FK_majeur` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maison Départementale des Personnes Handicapées';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mesure`
--

DROP TABLE IF EXISTS `mesure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mesure_FK` (`groupeId`),
  CONSTRAINT `mesure_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `natureOperation`
--

DROP TABLE IF EXISTS `natureOperation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `natureOperation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `natureOperation_FK` (`groupeId`),
  CONSTRAINT `natureOperation_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notaire`
--

DROP TABLE IF EXISTS `notaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseId` int(11) NOT NULL,
  `contactId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tribunal_FK` (`groupeId`) USING BTREE,
  KEY `notaire_FK` (`contactId`),
  KEY `notaire_FK_1` (`adresseId`),
  CONSTRAINT `notaire_FK` FOREIGN KEY (`id`) REFERENCES `groupe` (`id`),
  CONSTRAINT `notaire_FK_1` FOREIGN KEY (`adresseId`) REFERENCES `adresse` (`id`),
  CONSTRAINT `notaire_FK_2` FOREIGN KEY (`id`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `noteDeFrais`
--

DROP TABLE IF EXISTS `noteDeFrais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noteDeFrais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `lieu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `typeFraisId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` double NOT NULL,
  `ficheFraisId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `noteDeFrais_FK_ficheFrais` (`ficheFraisId`),
  KEY `noteDeFrais_FK_typeFrais` (`typeFraisId`),
  CONSTRAINT `noteDeFrais_FK_ficheFrais` FOREIGN KEY (`ficheFraisId`) REFERENCES `ficheFrais` (`id`),
  CONSTRAINT `noteDeFrais_FK_typeFrais` FOREIGN KEY (`typeFraisId`) REFERENCES `typeFrais` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organismeProtection`
--

DROP TABLE IF EXISTS `organismeProtection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organismeProtection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseId` int(11) NOT NULL,
  `contactId` int(11) NOT NULL,
  `typeOrganismeId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `organismeProtection_FK` (`adresseId`),
  KEY `organismeProtection_FK_1` (`contactId`),
  KEY `organismeProtection_FK_2` (`typeOrganismeId`),
  KEY `organismeProtection_FK_3` (`majeurId`),
  CONSTRAINT `organismeProtection_FK` FOREIGN KEY (`adresseId`) REFERENCES `adresse` (`id`),
  CONSTRAINT `organismeProtection_FK_1` FOREIGN KEY (`contactId`) REFERENCES `contact` (`id`),
  CONSTRAINT `organismeProtection_FK_2` FOREIGN KEY (`typeOrganismeId`) REFERENCES `typeOrganisme` (`id`),
  CONSTRAINT `organismeProtection_FK_3` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parametreMission`
--

DROP TABLE IF EXISTS `parametreMission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametreMission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `mesureId` int(11) NOT NULL,
  `protectionId` int(11) NOT NULL,
  `lieuVieId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parametreMission_FK_2` (`lieuVieId`),
  KEY `parametreMission_FK` (`protectionId`),
  KEY `parametreMission_FK_1` (`mesureId`),
  KEY `parametreMission_FK_majeur` (`majeurId`),
  CONSTRAINT `parametreMission_FK` FOREIGN KEY (`protectionId`) REFERENCES `protection` (`id`),
  CONSTRAINT `parametreMission_FK_1` FOREIGN KEY (`mesureId`) REFERENCES `mesure` (`id`),
  CONSTRAINT `parametreMission_FK_2` FOREIGN KEY (`lieuVieId`) REFERENCES `lieuVie` (`id`),
  CONSTRAINT `parametreMission_FK_majeur` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pompeFunebre`
--

DROP TABLE IF EXISTS `pompeFunebre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pompeFunebre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseId` int(11) NOT NULL,
  `contactId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notaire_FK` (`contactId`) USING BTREE,
  KEY `notaire_FK_1` (`adresseId`) USING BTREE,
  KEY `tribunal_FK` (`groupeId`) USING BTREE,
  CONSTRAINT `pompeFunebre_FK` FOREIGN KEY (`id`) REFERENCES `groupe` (`id`),
  CONSTRAINT `pompeFunebre_FK_1` FOREIGN KEY (`adresseId`) REFERENCES `adresse` (`id`),
  CONSTRAINT `pompeFunebre_FK_2` FOREIGN KEY (`contactId`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prestationSociale`
--

DROP TABLE IF EXISTS `prestationSociale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestationSociale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prestationSociale_FK` (`groupeId`),
  CONSTRAINT `prestationSociale_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `priseEnCharge`
--

DROP TABLE IF EXISTS `priseEnCharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `priseEnCharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `typePriseEnChargeId` int(11) NOT NULL,
  `dateFin` date DEFAULT NULL,
  `traite` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `priseEnCharge_FK_majeur` (`majeurId`),
  KEY `priseEnCharge_FK_typePriseEnCharge` (`typePriseEnChargeId`),
  CONSTRAINT `priseEnCharge_FK_majeur` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`),
  CONSTRAINT `priseEnCharge_FK_typePriseEnCharge` FOREIGN KEY (`typePriseEnChargeId`) REFERENCES `typePriseEnCharge` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `protection`
--

DROP TABLE IF EXISTS `protection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `protection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `protection_FK` (`groupeId`),
  CONSTRAINT `protection_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rapport`
--

DROP TABLE IF EXISTS `rapport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `commentaire` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rapport_FK` (`majeurId`),
  CONSTRAINT `rapport_FK` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syndic`
--

DROP TABLE IF EXISTS `syndic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syndic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseId` int(11) NOT NULL,
  `contactId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notaire_FK` (`contactId`) USING BTREE,
  KEY `notaire_FK_1` (`adresseId`) USING BTREE,
  KEY `tribunal_FK` (`groupeId`) USING BTREE,
  CONSTRAINT `syndic_FK` FOREIGN KEY (`adresseId`) REFERENCES `adresse` (`id`),
  CONSTRAINT `syndic_FK_1` FOREIGN KEY (`contactId`) REFERENCES `contact` (`id`),
  CONSTRAINT `syndic_FK_2` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tribunal`
--

DROP TABLE IF EXISTS `tribunal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tribunal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tribunal_FK` (`groupeId`),
  CONSTRAINT `tribunal_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `typeCompte`
--

DROP TABLE IF EXISTS `typeCompte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeCompte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `familleCompteId` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typeCompte_FK_1` (`familleCompteId`),
  KEY `typeCompte_FK` (`groupeId`),
  CONSTRAINT `typeCompte_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`),
  CONSTRAINT `typeCompte_FK_1` FOREIGN KEY (`familleCompteId`) REFERENCES `familleCompte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `typeFrais`
--

DROP TABLE IF EXISTS `typeFrais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeFrais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typeFrais_FK` (`groupeId`),
  CONSTRAINT `typeFrais_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `typeOperation`
--

DROP TABLE IF EXISTS `typeOperation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeOperation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelleRapport` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familleTypeOperationId` int(11) DEFAULT NULL,
  `checkable` tinyint(4) NOT NULL DEFAULT 0,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typeOperation_FK_1` (`familleTypeOperationId`),
  KEY `typeOperation_FK` (`groupeId`),
  CONSTRAINT `typeOperation_FK` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`),
  CONSTRAINT `typeOperation_FK_1` FOREIGN KEY (`familleTypeOperationId`) REFERENCES `familleTypeOperation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `typeOrganisme`
--

DROP TABLE IF EXISTS `typeOrganisme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeOrganisme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mesure_FK` (`groupeId`) USING BTREE,
  CONSTRAINT `mesure_FK_copy` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `typePriseEnCharge`
--

DROP TABLE IF EXISTS `typePriseEnCharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typePriseEnCharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupeId` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alertable` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tribunal_FK` (`groupeId`) USING BTREE,
  CONSTRAINT `tribunal_FK_copy` FOREIGN KEY (`groupeId`) REFERENCES `groupe` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visite`
--

DROP TABLE IF EXISTS `visite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majeurId` int(11) NOT NULL,
  `date` date NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visite_FK` (`majeurId`),
  KEY `visite_date_IDX` (`date`) USING BTREE,
  CONSTRAINT `visite_FK` FOREIGN KEY (`majeurId`) REFERENCES `majeur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'guy'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-31 22:41:41
