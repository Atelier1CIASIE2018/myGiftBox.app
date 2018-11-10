-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.23 - MySQL Community Server (GPL)
-- SE du serveur:                Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour mygiftbox
CREATE DATABASE IF NOT EXISTS `mygiftbox` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mygiftbox`;

-- Export de la structure de la table mygiftbox. box
CREATE TABLE IF NOT EXISTS `box` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `idUser` int(16) NOT NULL,
  `nom` varchar(256) DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT '1',
  `message` text,
  `date` date DEFAULT NULL,
  `url` varchar(256) NOT NULL DEFAULT '',
  `messageRetour` text,
  PRIMARY KEY (`id`),
  KEY `IdUser` (`idUser`),
  CONSTRAINT `Box_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Export de données de la table mygiftbox.box : ~8 rows (environ)
/*!40000 ALTER TABLE `box` DISABLE KEYS */;
INSERT INTO `box` (`id`, `idUser`, `nom`, `etat`, `message`, `date`, `url`, `messageRetour`) VALUES
	(2, 2, 'coffret état 1', 1, 'Ce coffret est à l\'état 1, il est toujours modifiable par l\'utilisateur.\r\nLes actions possibles sont: \r\nl\'aperçu du coffret, \r\nla modification (informations, ajout et suppression de prestations), \r\nla validation (vérification s\'il y a au moins 2 prestations de 2 catégories différentes et passe l\'état à 2),\r\nle paiement (vérification de la validation si elle n\'est pas faite et passage au paiement qui passera le coffret à l\'état 3)', '2018-11-14', '', NULL),
	(3, 2, 'coffret état 1 (validation impossible: pas assez de prestations)', 1, 'Ce coffre ne peut être validé car il n\'a pas au moins 2 prestations', '2018-11-11', '', NULL),
	(4, 2, 'coffret état 1 (validation impossible: pas 2 catégories différentes)', 1, 'Ce coffret ne peut être validé car il a au moins 2 prestations mais elles ne sont pas de 2 catégories différents', '2018-11-14', '', NULL),
	(5, 2, 'coffret état 1 (validation possible: 2 prestations de 2 catégories différentes)', 1, 'Ce coffret peut être validé car il a 2 prestations de 2 catégories différents', '2018-11-15', '', NULL),
	(6, 2, 'coffret état 1 (validation possible: au moins 2 prestations de 2 catégories différentes)', 1, 'Ce coffret peut être validé car il a au moins 2 prestations de 2 catégories différentes', '2018-11-10', '', NULL),
	(7, 2, 'coffret état 2', 2, 'Ce coffret a été validé, les actions possibles sont: \r\nl\'aperçu du coffret,\r\nle paiement (comme il est déjà validé, il affichera le récapitulatif)', '2018-11-10', '', NULL),
	(8, 2, 'coffret état 3', 3, 'Ce coffret a été payé, les actions possibles sont:\r\nl\'aperçu du coffret,', '2018-11-10', '', NULL),
	(9, 2, 'coffret état 4', 4, 'Le créateur du coffret a généré l\'url pour le destinataire, la seule action possible est l\'aperçu du coffret avec l\'url créé en bas', '2018-11-10', '/giftBox/main.php/box/receiver/?id=9', NULL),
	(10, 2, 'coffret état 5 (sans message de retour)', 4, 'Ce coffret a été ouvert une 1ère fois par le destinataire, la seule action possible est l\'aperçu mais le destinataire n\'a pas mis de message de retour', '2018-11-13', '/giftBox/main.php/box/receiver/?id=10', NULL),
	(13, 2, 'coffret état 5', 4, 'Ce coffret a été ouvert par le destinataire, la seule action possible est l\'aperçu et le destinataire a mis un message de retour', '2018-11-10', '/giftBox/main.php/box/receiver/?id=13', 'message de retour du destinataire');
/*!40000 ALTER TABLE `box` ENABLE KEYS */;

-- Export de la structure de la table mygiftbox. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Export de données de la table mygiftbox.categorie : ~4 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'Attention'),
	(2, 'Activité'),
	(3, 'Restauration'),
	(4, 'Hébergement');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Export de la structure de la table mygiftbox. composer
CREATE TABLE IF NOT EXISTS `composer` (
  `idBox` int(16) NOT NULL,
  `idPrestation` int(16) NOT NULL,
  PRIMARY KEY (`idBox`,`idPrestation`),
  KEY `FK_composer_prestation` (`idPrestation`),
  CONSTRAINT `FK_composer_box` FOREIGN KEY (`idBox`) REFERENCES `box` (`id`),
  CONSTRAINT `FK_composer_prestation` FOREIGN KEY (`idPrestation`) REFERENCES `prestation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table mygiftbox.composer : ~17 rows (environ)
/*!40000 ALTER TABLE `composer` DISABLE KEYS */;
INSERT INTO `composer` (`idBox`, `idPrestation`) VALUES
	(3, 1),
	(4, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(4, 2),
	(7, 3),
	(8, 3),
	(9, 3),
	(6, 5),
	(10, 6),
	(13, 8),
	(5, 9),
	(10, 10),
	(6, 16),
	(6, 17),
	(5, 19),
	(13, 21),
	(13, 22);
/*!40000 ALTER TABLE `composer` ENABLE KEYS */;

-- Export de la structure de la table mygiftbox. prestation
CREATE TABLE IF NOT EXISTS `prestation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  `prix` double NOT NULL,
  `img` varchar(128) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '1',
  `idCategorie` int(16) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IdCategorie` (`idCategorie`),
  CONSTRAINT `Prestation_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- Export de données de la table mygiftbox.prestation : ~27 rows (environ)
/*!40000 ALTER TABLE `prestation` DISABLE KEYS */;
INSERT INTO `prestation` (`id`, `nom`, `prix`, `img`, `etat`, `idCategorie`, `description`) VALUES
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
	(27, 'Fort Aventure', 25, 'fort.jpg', 1, 2, 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.'),
	(28, 'Resto', 30, '/', 1, 3, 'un resto');
/*!40000 ALTER TABLE `prestation` ENABLE KEYS */;

-- Export de la structure de la table mygiftbox. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Export de données de la table mygiftbox.user : ~2 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `mdp`, `level`) VALUES
	(2, 'user', 'user', 'user@mail.fr', '$2y$10$jeWlJ/FCUSmgw6Wbw5Sg7.pVKXSk/Xx1EzDI3uS5f90Vctw/xtq2a', 100),
	(3, 'admin', 'admin', 'admin@mail.fr', '$2y$10$qRtOA9nQowyeuHwMTHGqkeOjmF/kY1awIItELyH6PO0QUqVDq6/aG', 200);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
