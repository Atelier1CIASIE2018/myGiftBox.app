-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 05 nov. 2018 à 14:34
-- Version du serveur :  5.7.24-0ubuntu0.16.04.1
-- Version de PHP :  7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `MyGiftBox`
--

-- --------------------------------------------------------

--
-- Structure de la table `Box`
--

CREATE TABLE `Box` (
  `Id` int(16) NOT NULL,
  `IdUser` int(16) NOT NULL,
  `Etat` int(11) NOT NULL,
  `Message` text NOT NULL,
  `Url` varchar(256) NOT NULL,
  `MessageRetour` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Catalogue`
--

CREATE TABLE `Catalogue` (
  `Id` int(11) NOT NULL,
  `Etat` tinyint(1) NOT NULL DEFAULT '1',
  `LIbelle` varchar(32) NOT NULL,
  `Type` varchar(32) NOT NULL,
  `Description` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Photo`
--

CREATE TABLE `Photo` (
  `Id` int(16) NOT NULL,
  `IdCatalogue` int(16) NOT NULL,
  `Url` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Prestation`
--

CREATE TABLE `Prestation` (
  `IdBox` int(16) NOT NULL,
  `IdCatalogue` int(16) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `Id` int(16) NOT NULL,
  `Nom` varchar(32) NOT NULL,
  `Prenom` varchar(32) NOT NULL,
  `Email` varchar(32) NOT NULL,
  `Login` varchar(32) NOT NULL,
  `Mdp` varchar(32) NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Box`
--
ALTER TABLE `Box`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Index pour la table `Catalogue`
--
ALTER TABLE `Catalogue`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Photo`
--
ALTER TABLE `Photo`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdCatalogue` (`IdCatalogue`);

--
-- Index pour la table `Prestation`
--
ALTER TABLE `Prestation`
  ADD KEY `IdPrestation` (`IdBox`,`IdCatalogue`),
  ADD KEY `IdCatalogue` (`IdCatalogue`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Box`
--
ALTER TABLE `Box`
  MODIFY `Id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Catalogue`
--
ALTER TABLE `Catalogue`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Photo`
--
ALTER TABLE `Photo`
  MODIFY `Id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `Id` int(16) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Box`
--
ALTER TABLE `Box`
  ADD CONSTRAINT `Box_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `User` (`Id`);

--
-- Contraintes pour la table `Photo`
--
ALTER TABLE `Photo`
  ADD CONSTRAINT `Photo_ibfk_1` FOREIGN KEY (`IdCatalogue`) REFERENCES `Catalogue` (`Id`);

--
-- Contraintes pour la table `Prestation`
--
ALTER TABLE `Prestation`
  ADD CONSTRAINT `Prestation_ibfk_1` FOREIGN KEY (`IdBox`) REFERENCES `Box` (`Id`),
  ADD CONSTRAINT `Prestation_ibfk_2` FOREIGN KEY (`IdCatalogue`) REFERENCES `Catalogue` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
