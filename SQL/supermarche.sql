-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 05 déc. 2025 à 10:40
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `supermarche`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

CREATE TABLE `adherent` (
  `IdClient` int(11) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Adresse` varchar(255) DEFAULT NULL,
  `Ville` varchar(100) DEFAULT NULL,
  `CodePostal` varchar(10) DEFAULT NULL,
  `MotDePasse` varchar(100) DEFAULT NULL,
  `Date_naissance` date DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `MotMagique` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`IdClient`, `Nom`, `Prenom`, `Adresse`, `Ville`, `CodePostal`, `MotDePasse`, `Date_naissance`, `point`, `MotMagique`, `role`) VALUES
(1, 'toto', 'tata', '11 rue lecourbe', 'paris', NULL, 'azerty1', '2005-03-17', 300, NULL, 'client'),
(2, 'lola', 'marko', '12 rue lecourbe', 'paris', NULL, 'azerty2', '2005-06-21', 240, NULL, 'admin_produits'),
(3, 'lola', 'marko', '12 rue lecourbe', 'paris', NULL, 'azerty2', '2005-06-21', 240, NULL, 'admin_prix'),
(4, 'bombe', 'yanis', '13 rue lecourbe', 'paris', NULL, 'azerty3', '2002-04-12', 29, NULL, 'admin_comptes'),
(5, 'ONEPIECE', 'Tina', '10 truc much', 'PARIS', '75015', '1234AZER', '2020-12-03', 0, 'MARKO', 'super_admin');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `NumeroFacture` int(11) NOT NULL,
  `IdProduit` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`NumeroFacture`, `IdProduit`, `Quantite`) VALUES
(1, 1, 10),
(2, 2, 25),
(3, 3, 56),
(4, 4, 75);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `NumeroFacture` int(11) NOT NULL,
  `DateFacture` date NOT NULL,
  `IdClient` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`NumeroFacture`, `DateFacture`, `IdClient`) VALUES
(1, '2025-09-10', 1),
(2, '2025-09-12', 2),
(3, '2025-09-08', 3),
(4, '2025-09-16', 4);

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE `famille` (
  `IdFamille` int(11) NOT NULL,
  `NomFamille` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `famille`
--

INSERT INTO `famille` (`IdFamille`, `NomFamille`) VALUES
(1, 'boissons'),
(2, 'legumes'),
(3, 'fruits'),
(4, 'boulangerie');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `IdProduit` int(11) NOT NULL,
  `NomProd` varchar(150) NOT NULL,
  `Prix` decimal(10,2) NOT NULL,
  `IdFamille` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`IdProduit`, `NomProd`, `Prix`, `IdFamille`, `Image`) VALUES
(1, 'pepsi', 4.50, 1, 'pepsi.jpg'),
(2, 'carottes', 9.00, 2, 'carottes.jpg'),
(3, 'fraise', 3.40, 3, 'fraise.jpg'),
(4, 'pain', 1.70, 4, 'pain.jpg'),
(5, 'Coca-Cola Zéro 1.5L', 1.95, 1, 'cocacola_zero.jpg'),
(6, 'Fanta Orange 1.5L', 1.80, 1, 'fanta_orange.jpg'),
(7, 'Sprite 1.5L', 1.80, 1, 'sprite.jpg'),
(8, 'Oasis Tropical 2L', 2.40, 1, 'oasis_tropical.jpg'),
(9, 'Schweppes Agrumes 1.5L', 2.10, 1, 'schweppes_agrumes.jpg'),
(10, 'Orangina 1.5L', 2.05, 1, 'orangina.jpg'),
(11, 'Ice Tea Pêche 1.5L', 1.99, 1, 'ice_tea_peche.jpg'),
(12, 'Ice Tea Citron 1.5L', 1.99, 1, 'ice_tea_citron.jpg'),
(13, 'Red Bull 25cl', 1.50, 1, 'red_bull.jpg'),
(14, 'Monster Energy 50cl', 1.80, 1, 'monster_energy.jpg'),
(15, 'Eau Evian 1.5L', 0.70, 1, 'eau_evian.jpg'),
(16, 'Eau Volvic 1.5L', 0.65, 1, 'eau_volvic.jpg'),
(17, 'Eau Hépar 1L', 0.80, 1, 'eau_hepar.jpg'),
(18, 'Perrier 1L', 0.95, 1, 'default.png'),
(19, 'San Pellegrino 1L', 1.10, 1, 'default.png'),
(20, 'Badoit Rouge 1L', 1.05, 1, 'default.png'),
(21, 'Jus de Pomme Artisanal', 3.50, 1, 'default.png'),
(22, 'Jus de Raisin', 2.20, 1, 'default.png'),
(23, 'Nectar d\'Abricot', 1.90, 1, 'default.png'),
(24, 'Jus de Tomate épicé', 2.10, 1, 'default.png'),
(25, 'Sirop de Menthe', 3.10, 1, 'default.png'),
(26, 'Sirop de Citron', 3.10, 1, 'default.png'),
(27, 'Sirop de Fraise', 3.25, 1, 'default.png'),
(28, 'Bière Brune 33cl', 1.60, 1, 'default.png'),
(29, 'Bière Blanche 33cl', 1.50, 1, 'default.png'),
(30, 'Pack Bière Lager (x6)', 4.50, 1, 'default.png'),
(31, 'Cidre Doux 75cl', 2.80, 1, 'default.png'),
(32, 'Cidre Brut 75cl', 2.80, 1, 'default.png'),
(33, 'Vin Rouge Bordeaux', 6.50, 1, 'default.png'),
(34, 'Vin Blanc Chardonnay', 5.90, 1, 'default.png'),
(35, 'Vin Rosé de Provence', 7.20, 1, 'default.png'),
(36, 'Champagne Brut', 24.90, 1, 'default.png'),
(37, 'Courgettes (1kg)', 2.50, 2, 'default.png'),
(38, 'Aubergines (1kg)', 3.20, 2, 'default.png'),
(39, 'Poivron Rouge (l\'unité)', 0.90, 2, 'default.png'),
(40, 'Poivron Vert (l\'unité)', 0.80, 2, 'default.png'),
(41, 'Poivron Jaune (l\'unité)', 0.95, 2, 'default.png'),
(42, 'Oignons Jaunes (Filet 1kg)', 1.50, 2, 'default.png'),
(43, 'Oignons Rouges (Filet 500g)', 1.80, 2, 'default.png'),
(44, 'Ail (Tresse)', 2.50, 2, 'default.png'),
(45, 'Échalotes (Filet)', 2.10, 2, 'default.png'),
(46, 'Pommes de Terre Vapeur (2.5kg)', 4.20, 2, 'default.png'),
(47, 'Pommes de Terre Frites (2.5kg)', 3.90, 2, 'default.png'),
(48, 'Patate Douce (1kg)', 3.50, 2, 'default.png'),
(49, 'Radis (la botte)', 1.20, 2, 'default.png'),
(50, 'Navets (1kg)', 1.80, 2, 'default.png'),
(51, 'Poireaux (la botte)', 2.20, 2, 'default.png'),
(52, 'Céleri Branche', 1.90, 2, 'default.png'),
(53, 'Fenouil (l\'unité)', 1.50, 2, 'default.png'),
(54, 'Chou-fleur (l\'unité)', 2.80, 2, 'default.png'),
(55, 'Brocoli (500g)', 1.60, 2, 'default.png'),
(56, 'Chou Rouge (l\'unité)', 1.90, 2, 'default.png'),
(57, 'Chou Vert (l\'unité)', 2.10, 2, 'default.png'),
(58, 'Epinards Frais (sachet)', 2.50, 2, 'default.png'),
(59, 'Mâche Nantaise', 1.90, 2, 'default.png'),
(60, 'Roquette (sachet)', 1.80, 2, 'default.png'),
(61, 'Haricots Verts (500g)', 2.90, 2, 'default.png'),
(62, 'Petits Pois (500g)', 3.10, 2, 'default.png'),
(63, 'Champignons de Paris (barquette)', 2.20, 2, 'default.png'),
(64, 'Champignons Bruns', 2.50, 2, 'default.png'),
(65, 'Endives (1kg)', 3.50, 2, 'default.png'),
(66, 'Potimarron (l\'unité)', 3.00, 2, 'default.png'),
(67, 'Courge Butternut', 2.80, 2, 'default.png'),
(68, 'Pommes Pink Lady (1kg)', 3.20, 3, 'default.png'),
(69, 'Pommes Granny Smith (1kg)', 2.80, 3, 'default.png'),
(70, 'Poires William (1kg)', 2.90, 3, 'default.png'),
(71, 'Bananes Bio (1kg)', 1.99, 3, 'default.png'),
(72, 'Oranges à jus (Filet 2kg)', 3.90, 3, 'default.png'),
(73, 'Pamplemousse Rose', 0.90, 3, 'default.png'),
(74, 'Citron Vert (l\'unité)', 0.50, 3, 'default.png'),
(75, 'Mandarines (Filet)', 2.50, 3, 'default.png'),
(76, 'Raisin Blanc (500g)', 2.80, 3, 'default.png'),
(77, 'Raisin Noir (500g)', 2.90, 3, 'default.png'),
(78, 'Fraises (Barquette 250g)', 3.50, 3, 'default.png'),
(79, 'Framboises (Barquette 125g)', 2.90, 3, 'default.png'),
(80, 'Myrtilles (Barquette 125g)', 2.50, 3, 'default.png'),
(81, 'Groseilles (Barquette)', 2.20, 3, 'default.png'),
(82, 'Ananas Victoria', 3.90, 3, 'default.png'),
(83, 'Mangue Avion', 4.50, 3, 'default.png'),
(84, 'Fruit de la Passion (x2)', 2.50, 3, 'default.png'),
(85, 'Noix de Coco', 1.80, 3, 'default.png'),
(86, 'Litchis (500g)', 4.20, 3, 'default.png'),
(87, 'Kiwi Gold (l\'unité)', 0.60, 3, 'default.png'),
(88, 'Melon Charentais', 2.50, 3, 'default.png'),
(89, 'Pastèque (quart)', 3.00, 3, 'default.png'),
(90, 'Pêches Jaunes (1kg)', 3.50, 3, 'default.png'),
(91, 'Nectarines (1kg)', 3.60, 3, 'default.png'),
(92, 'Abricots (1kg)', 4.20, 3, 'default.png'),
(93, 'Prunes Reine-Claude', 3.80, 3, 'default.png'),
(94, 'Cerises (500g)', 6.50, 3, 'default.png'),
(95, 'Figues Violettes (x4)', 2.80, 3, 'default.png'),
(96, 'Dattes (boîte)', 3.20, 3, 'default.png'),
(97, 'Grenade (l\'unité)', 1.90, 3, 'default.png'),
(98, 'Baguette Moulée', 0.95, 4, 'default.png'),
(99, 'Baguette Céréales', 1.30, 4, 'default.png'),
(100, 'Baguette Pavot', 1.30, 4, 'default.png'),
(101, 'Pain Complet', 2.10, 4, 'default.png'),
(102, 'Pain de Seigle', 2.20, 4, 'default.png'),
(103, 'Pain aux Noix', 2.80, 4, 'default.png'),
(104, 'Pain de Mie Nature', 1.50, 4, 'default.png'),
(105, 'Pain Burger (x4)', 2.50, 4, 'default.png'),
(106, 'Pain Kebab (x4)', 2.20, 4, 'default.png'),
(107, 'Croissant Ordinaire', 0.90, 4, 'default.png'),
(108, 'Pain aux Raisins', 1.40, 4, 'default.png'),
(109, 'Chausson aux Pommes', 1.50, 4, 'default.png'),
(110, 'Pain Suisse', 1.60, 4, 'default.png'),
(111, 'Brioche Tressée', 3.50, 4, 'default.png'),
(112, 'Brioche Pépites Choco', 3.80, 4, 'default.png'),
(113, 'Chouquettes (x10)', 2.50, 4, 'default.png'),
(114, 'Madeleines (sachet)', 2.80, 4, 'default.png'),
(115, 'Donut Sucre', 1.20, 4, 'default.png'),
(116, 'Donut Chocolat', 1.40, 4, 'default.png'),
(117, 'Muffin Myrtille', 2.10, 4, 'default.png'),
(118, 'Muffin Tout Choco', 2.10, 4, 'default.png'),
(119, 'Cookie Maxi', 1.80, 4, 'default.png'),
(120, 'Éclair au Chocolat', 2.20, 4, 'default.png'),
(121, 'Éclair au Café', 2.20, 4, 'default.png'),
(122, 'Religieuse', 2.50, 4, 'default.png'),
(123, 'Mille-Feuille', 2.80, 4, 'default.png'),
(124, 'Tartelette Citron', 2.60, 4, 'default.png'),
(125, 'Tartelette Fraise', 2.90, 4, 'default.png'),
(126, 'Flan Pâtissier (part)', 2.00, 4, 'default.png'),
(127, 'Sandwich Jambon-Beurre', 3.50, 4, 'default.png'),
(128, 'Sandwich Poulet-Crudités', 3.90, 4, 'default.png'),
(129, 'Fougasse Olives', 2.80, 4, 'default.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`IdClient`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`NumeroFacture`,`IdProduit`),
  ADD KEY `IdProduit` (`IdProduit`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`NumeroFacture`),
  ADD KEY `IdClient` (`IdClient`);

--
-- Index pour la table `famille`
--
ALTER TABLE `famille`
  ADD PRIMARY KEY (`IdFamille`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`IdProduit`),
  ADD KEY `IdFamille` (`IdFamille`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adherent`
--
ALTER TABLE `adherent`
  MODIFY `IdClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `NumeroFacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `famille`
--
ALTER TABLE `famille`
  MODIFY `IdFamille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `IdProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_ibfk_1` FOREIGN KEY (`NumeroFacture`) REFERENCES `facture` (`NumeroFacture`),
  ADD CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`IdProduit`) REFERENCES `produit` (`IdProduit`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`IdClient`) REFERENCES `adherent` (`IdClient`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`IdFamille`) REFERENCES `famille` (`IdFamille`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
