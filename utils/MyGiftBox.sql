-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 06 nov. 2018 à 14:34
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
  `Nom` varchar(256) NOT NULL,
  `Etat` int(11) DEFAULT 1,
  `Message` text NOT NULL,
  `Url` varchar(256) NOT NULL,
  `MessageRetour` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `Id` int(16) NOT NULL,
  `Nom` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Categorie`
--

INSERT INTO `Categorie` (`Id`, `Nom`) VALUES
(1, 'Attention'),
(2, 'Activité'),
(3, 'Restauration'),
(4, 'Hébergement');

-- --------------------------------------------------------

--
-- Structure de la table `Composer`
--

CREATE TABLE `Composer` (
  `IdBox` int(16) NOT NULL,
  `IdPrestation` int(16) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Prestation`
--

CREATE TABLE `Prestation` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(64) NOT NULL,
  `Prix` double NOT NULL,
  `Img` varchar(128) NOT NULL,
  `Etat` tinyint(1) NOT NULL DEFAULT '1',
  `IdCategorie` int(16) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Prestation`
--

INSERT INTO `Prestation` (`Id`, `Nom`, `Prix`, `Img`, `Etat`, `IdCategorie`, `Description`) VALUES
(1, 'Champagne', 20, 'champagne.jpg', 1, 1, 'Bouteille de champagne + flutes + jeux à gratter'),
(2, 'Musique', 25, 'musique.jpg', 1, 1, 'Partitions de piano à 4 mains'),
(3, 'Exposition', 14, 'poirelregarder.jpg', 1, 2, 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel'),
(4, 'Goûter', 20, 'gouter.jpg', 1, 3, 'Goûter au FIFNL'),
(5, 'Projection', 10, 'film.jpg', 1, 2, 'Projection courts-métrages au FIFNL'),
(6, 'Bouquet', 16, 'rose.jpg', 1, 1, 'Bouquet de roses et Mots de Marion Renaud'),
(7, 'Diner Stanislas', 60, 'bonroi.jpg', 1, 3, 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)'),
(8, 'Origami', 12, 'origami.jpg', 1, 3, 'Baguettes magiques en Origami en buvant un thé'),
(9, 'Livres', 24, 'bricolage.jpg', 1, 1, 'Livre bricolage avec petits-enfants + Roman'),
(10, 'Diner  Grand Rue ', 59, 'grandrue.jpg', 1, 3, 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)'),
(11, 'Visite guidée', 11, 'place.jpg', 1, 2, 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas'),
(12, 'Bijoux', 29, 'bijoux.jpg', 1, 1, 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil'),
(13, 'Opéra', 15, 'opera.jpg', 1, 2, 'Concert commenté à l’Opéra'),
(14, 'Thé Hotel de la reine', 5, 'hotelreine.gif', 1, 3, 'Thé de debriefing au bar de l’Hotel de la reine'),
(15, 'Jeu connaissance', 6, 'connaissance.jpg', 1, 2, 'Jeu pour faire connaissance'),
(16, 'Diner', 40, 'diner.jpg', 1, 3, 'Diner (Apéritif / Plat / Vin / Dessert / Café)'),
(17, 'Cadeaux individuels', 13, 'cadeaux.jpg', 1, 1, 'Cadeaux individuels sur le thème de la soirée'),
(18, 'Animation', 9, 'animateur.jpg', 1, 2, 'Activité animée par un intervenant extérieur'),
(19, 'Jeu contacts', 5, 'contact.png', 1, 2, 'Jeu pour échange de contacts'),
(20, 'Cocktail', 12, 'cocktail.jpg', 1, 3, 'Cocktail de fin de soirée'),
(21, 'Star Wars', 12, 'starwars.jpg', 1, 2, 'Star Wars - Le Réveil de la Force. Séance cinéma 3D'),
(22, 'Concert', 17, 'concert.jpg', 1, 2, 'Un concert à Nancy'),
(23, 'Appart Hotel', 56, 'apparthotel.jpg', 1, 4, 'Appart’hôtel Coeur de Ville, en plein centre-ville'),
(24, 'Hôtel d\'Haussonville', 169, 'hotel_haussonville_logo.jpg', 1, 4, 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas'),
(25, 'Boite de nuit', 32, 'boitedenuit.jpg', 1, 2, 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités'),
(26, 'Planètes Laser', 15, 'laser.jpg', 1, 2, 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.'),
(27, 'Fort Aventure', 25, 'fort.jpg', 1, 2, 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.');

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
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Composer`
--
ALTER TABLE `Composer`
  ADD KEY `IdPrestation` (`IdBox`,`IdCatalogue`),
  ADD KEY `IdCatalogue` (`IdCatalogue`);

--
-- Index pour la table `Prestation`
--
ALTER TABLE `Prestation`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdCategorie` (`IdCategorie`);

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
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `Id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Prestation`
--
ALTER TABLE `Prestation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
-- Contraintes pour la table `Composer`
--
ALTER TABLE `Composer`
  ADD CONSTRAINT `Composer_ibfk_1` FOREIGN KEY (`IdBox`) REFERENCES `Box` (`Id`),
  ADD CONSTRAINT `Composer_ibfk_2` FOREIGN KEY (`IdCatalogue`) REFERENCES `Prestation` (`Id`);

--
-- Contraintes pour la table `Prestation`
--
ALTER TABLE `Prestation`
  ADD CONSTRAINT `Prestation_ibfk_1` FOREIGN KEY (`IdCategorie`) REFERENCES `Categorie` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
