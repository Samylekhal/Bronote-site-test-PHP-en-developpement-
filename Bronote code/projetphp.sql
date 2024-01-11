-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 25, 2023 at 08:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetphp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreerCles` ()   BEGIN
INSERT INTO cles(Type, Clé) VALUES ('PROF', SUBSTRING(MD5(RAND()) FROM 1 FOR 8));
INSERT INTO cles(Type, Clé) VALUES ('ADMIN', SUBSTRING(MD5(RAND()) FROM 1 FOR 8));
INSERT INTO cles(Type, Clé) VALUES ('ELEVE', SUBSTRING(MD5(RAND()) FROM 1 FOR 8));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cles`
--

CREATE TABLE `cles` (
  `Type` varchar(20) DEFAULT NULL,
  `Clé` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cles`
--

INSERT INTO `cles` (`Type`, `Clé`) VALUES
('ADMIN', '9d1a3917'),
('PROF', 'bdec2968'),
('ADMIN', '562460a5'),
('ELEVE', 'b9d5da75'),
('PROF', 'a0d8e7a5'),
('ADMIN', 'fd72c34e'),
('PROF', '103cbca5'),
('ADMIN', 'fb965089'),
('ELEVE', '6b64adf5'),
('PROF', '651364b5'),
('ADMIN', 'b640f9c8'),
('ELEVE', '6e0d3545'),
('PROF', '6d3dfc5f'),
('ADMIN', '3cedfede'),
('ELEVE', '534a9d64'),
('PROF', 'bfe6559b'),
('ADMIN', 'c0be2101'),
('ELEVE', '735595f7'),
('PROF', '77f5e229'),
('ADMIN', 'af2f8948'),
('ELEVE', '5e10fca1'),
('PROF', '10f72a53'),
('ADMIN', '4ff91e53'),
('ELEVE', '4adca430');

-- --------------------------------------------------------

--
-- Table structure for table `elevenote`
--

CREATE TABLE `elevenote` (
  `ID_noteleve` int NOT NULL,
  `id_eleve` int DEFAULT NULL,
  `id_note` int DEFAULT NULL,
  `noteleve` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `elevenote`
--

INSERT INTO `elevenote` (`ID_noteleve`, `id_eleve`, `id_note`, `noteleve`) VALUES
(3, 5, 2, '7.00'),
(12, 5, 9, '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `infoeleve`
--

CREATE TABLE `infoeleve` (
  `ID_info` int NOT NULL,
  `Id_eleve` int DEFAULT NULL,
  `Classe` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `infoeleve`
--

INSERT INTO `infoeleve` (`ID_info`, `Id_eleve`, `Classe`) VALUES
(1, 2, '5a'),
(5, 29, '5a');

-- --------------------------------------------------------

--
-- Table structure for table `infoprof`
--

CREATE TABLE `infoprof` (
  `ID` int NOT NULL,
  `Id_prof` int DEFAULT NULL,
  `Enseigne` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `infoprof`
--

INSERT INTO `infoprof` (`ID`, `Id_prof`, `Enseigne`) VALUES
(1, 3, 'Anglais'),
(7, 24, 'Français'),
(11, 33, 'Histoire-géographie');

-- --------------------------------------------------------

--
-- Table structure for table `inscrit`
--

CREATE TABLE `inscrit` (
  `Id_inscrit` int NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Statut` varchar(20) DEFAULT NULL,
  `Mdp` varchar(12) DEFAULT NULL,
  `Identifiant` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inscrit`
--

INSERT INTO `inscrit` (`Id_inscrit`, `Nom`, `Prenom`, `Statut`, `Mdp`, `Identifiant`) VALUES
(2, 'Leve', 'Joey', 'ELEVE', 'eleve', 'Jleve'),
(3, 'Esseur', 'Rudolph', 'PROF', 'prof', 'Resseur'),
(24, 'Patre', 'Jean-sol', 'PROF', 'test', 'test'),
(28, 'Demine', 'Joshua', 'ADMIN', 'admin', 'admin'),
(29, 'test', 'test', 'ELEVE', 'test1', 'test1'),
(33, 'z', 'z', 'PROF', 'z', 'z');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `Id_note` int NOT NULL,
  `Matiere` varchar(50) DEFAULT NULL,
  `Intitule` varchar(50) DEFAULT NULL,
  `note` smallint DEFAULT NULL,
  `Coeff` decimal(10,2) DEFAULT NULL,
  `Classe` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`Id_note`, `Matiere`, `Intitule`, `note`, `Coeff`, `Classe`) VALUES
(2, 'Histoire-géographie', 'Interro', 10, '1.00', '5a'),
(6, 'SVT', 'Interro 1', 10, '1.00', '5a'),
(8, 'Français', 'ds 1', 40, '3.00', '3b'),
(9, 'Anglais', 'TEST', 10, '1.00', '5a'),
(10, 'Mathématiques', 'TEST', 10, '1.00', '5a'),
(11, 'Français', 'TEST', 10, '1.00', '5a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `elevenote`
--
ALTER TABLE `elevenote`
  ADD PRIMARY KEY (`ID_noteleve`),
  ADD KEY `id_eleve` (`id_eleve`),
  ADD KEY `elevenote_ibfk_1` (`id_note`);

--
-- Indexes for table `infoeleve`
--
ALTER TABLE `infoeleve`
  ADD PRIMARY KEY (`ID_info`),
  ADD KEY `Id_eleve` (`Id_eleve`);

--
-- Indexes for table `infoprof`
--
ALTER TABLE `infoprof`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Id_prof` (`Id_prof`);

--
-- Indexes for table `inscrit`
--
ALTER TABLE `inscrit`
  ADD PRIMARY KEY (`Id_inscrit`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`Id_note`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `elevenote`
--
ALTER TABLE `elevenote`
  MODIFY `ID_noteleve` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `infoeleve`
--
ALTER TABLE `infoeleve`
  MODIFY `ID_info` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `infoprof`
--
ALTER TABLE `infoprof`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inscrit`
--
ALTER TABLE `inscrit`
  MODIFY `Id_inscrit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `Id_note` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `elevenote`
--
ALTER TABLE `elevenote`
  ADD CONSTRAINT `elevenote_ibfk_1` FOREIGN KEY (`id_note`) REFERENCES `note` (`Id_note`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `elevenote_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `infoeleve` (`ID_info`);

--
-- Constraints for table `infoeleve`
--
ALTER TABLE `infoeleve`
  ADD CONSTRAINT `infoeleve_ibfk_1` FOREIGN KEY (`Id_eleve`) REFERENCES `inscrit` (`Id_inscrit`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `infoprof`
--
ALTER TABLE `infoprof`
  ADD CONSTRAINT `infoprof_ibfk_1` FOREIGN KEY (`Id_prof`) REFERENCES `inscrit` (`Id_inscrit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
