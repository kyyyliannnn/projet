-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 03 mai 2023 à 00:45
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `aime`
--

CREATE TABLE `aime` (
  `id` int(11) NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `publication` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `aime`
--

INSERT INTO `aime` (`id`, `utilisateur`, `publication`) VALUES
(54, 1, 3),
(55, 2, 7),
(57, 1, 11),
(59, 1, 8),
(60, 1, 16),
(67, 16, 16),
(68, 16, 14),
(69, 25, 17),
(70, 16, 19),
(71, 16, 18),
(72, 16, 17);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `publication` int(11) NOT NULL,
  `texte` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `utilisateur`, `publication`, `texte`) VALUES
(9, 1, 2, 'Coucou !'),
(10, 1, 2, 'WOOOW '),
(11, 1, 2, 'Genial'),
(12, 1, 3, 'WOOOW'),
(14, 1, 3, 'wesh'),
(17, 2, 2, 'Stylé'),
(18, 2, 4, 'VOILA'),
(19, 2, 4, 'Genial !'),
(20, 1, 2, 'laura'),
(21, 1, 4, 'coucou'),
(22, 2, 7, 'sympa !'),
(23, 7, 10, 'je suis connecté !!!'),
(24, 8, 10, 'woua trop jolie !'),
(25, 1, 8, 'commentaire'),
(26, 1, 10, 'voila '),
(27, 1, 16, 'test'),
(28, 16, 16, 'Mon commentaire'),
(29, 25, 17, 'c joli'),
(30, 16, 18, 'moi vs toi'),
(31, 16, 14, 'waw');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `nom` int(11) NOT NULL,
  `pdp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `id` int(11) NOT NULL,
  `nblike` int(11) NOT NULL DEFAULT 0,
  `nbcom` int(11) NOT NULL DEFAULT 0,
  `texte` text NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id`, `nblike`, `nbcom`, `texte`, `utilisateur`, `numero`) VALUES
(14, 0, 1, 'ZOe', 1, 3),
(16, 0, 0, 'Dessin', 1, 5),
(17, 1, 0, 'Ma publication', 16, 0);

-- --------------------------------------------------------

--
-- Structure de la table `suivi`
--

CREATE TABLE `suivi` (
  `id` int(11) NOT NULL,
  `suiveur` int(11) NOT NULL,
  `suivi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `suivi`
--

INSERT INTO `suivi` (`id`, `suiveur`, `suivi`) VALUES
(1, 17, 2),
(3, 17, 8),
(5, 16, 2),
(6, 18, 13),
(7, 19, 13),
(8, 20, 2),
(10, 16, 8),
(11, 21, 18),
(12, 18, 21),
(13, 21, 19),
(14, 19, 21),
(15, 21, 20),
(16, 20, 21),
(17, 16, 1),
(18, 25, 16),
(19, 16, 25),
(20, 16, 21),
(21, 25, 21),
(22, 26, 16),
(23, 16, 26),
(24, 26, 25),
(25, 25, 26);

-- --------------------------------------------------------

--
-- Structure de la table `suivigroupe`
--

CREATE TABLE `suivigroupe` (
  `Suiveur` int(11) NOT NULL,
  `Suivi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `universite`
--

CREATE TABLE `universite` (
  `id` int(11) NOT NULL,
  `nom` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `universite`
--

INSERT INTO `universite` (`id`, `nom`) VALUES
(2, 'Panthéon-Sorbonne'),
(3, 'Panthéon-Assas'),
(4, 'Sorbonne Nouvelle'),
(5, 'Sorbonne Université'),
(6, 'Paris-Cité'),
(7, 'PSL'),
(8, 'Paris 8'),
(9, 'Paris Dauphine'),
(10, 'Paris Nanterre'),
(11, 'Paris-Saclay'),
(12, 'UPEC'),
(13, 'Sorbonne Paris Nord');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `pseudo` text DEFAULT NULL,
  `mail` text DEFAULT NULL,
  `mdp` text DEFAULT NULL,
  `pdp` int(11) NOT NULL DEFAULT 0,
  `nbpubli` int(11) NOT NULL DEFAULT 0,
  `administrateur` tinyint(1) NOT NULL DEFAULT 0,
  `story` int(11) NOT NULL DEFAULT 0,
  `universite` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `mail`, `mdp`, `pdp`, `nbpubli`, `administrateur`, `story`, `universite`) VALUES
(1, 'laura32', 'eva.herson@me.com', 'ae0fe50dad89c8200649f99ea4be9581', 1, 6, 1, 1, NULL),
(2, 'evairson', 'laura.32@gmail.com', '591711fd93bb840e3f22096178354625', 2, 3, 1, 0, NULL),
(8, 'Kikoolol42069', 'capy.mama@gmail.fr', '4a84f9df36ab8da4e59c48fb220b256f', 0, 1, 0, 0, NULL),
(11, 'lila\r\n', 'lilaoujade@gmail.com', '11b0c25d5353c1fd2faccaceaceec4c8', 0, 0, 0, 0, NULL),
(12, 'lila2', 'lila@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, 1681976533, NULL),
(13, 'Capybara', 'capy_bara@gmail.com', '55487324afde3db18d6c8013cf193e95', 0, 0, 0, 0, NULL),
(16, 'Etudiant', 'test6@gmail.com', '6bfffac0de6226ba24e7d0e37376db5b', 16, 1, 1, 0, 'Paris-Cité'),
(17, 'TEST', 'test10@gmail.com', '0ecb64e83b84558dad4c23f64aeb555d', 0, 0, 0, 0, 'Paris 8'),
(18, 'motdep', 'motdep@gamil.com', '4fc66ad8d3d65e9c06d04167daf279e3', 0, 0, 0, 0, 'Panthéon-Sorbonne'),
(19, 'infini', 'infini@hotmail.com', '1f900ececfb64a5f0a6db06aa24fc318', 0, 0, 0, 0, 'Panthéon-Sorbonne'),
(20, 'jpp', 'jpp@gmail.com', 'dcd261c4d2142a9eafe1dc4dcb161981', 0, 0, 0, 0, 'Panthéon-Sorbonne'),
(21, 'groupe', 'testgroupe@gmail.com', '6b0ada7d688effd40e16d5518da17aef', 0, 0, 0, 0, 'Panthéon-Sorbonne'),
(25, 'pariscite', 'pariscite@gamil.com', 'c57e59d697c2215f510cf358b776e59d', 0, 2, 0, 0, 'Paris-Cité'),
(26, 'nouveau', 'nouveau@gmail.com', 'b7ede464fdac97e896bb72c67369be17', 0, 1, 0, 0, 'Paris-Cité');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `aime`
--
ALTER TABLE `aime`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `suivi`
--
ALTER TABLE `suivi`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `universite`
--
ALTER TABLE `universite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `aime`
--
ALTER TABLE `aime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `suivi`
--
ALTER TABLE `suivi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `universite`
--
ALTER TABLE `universite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
