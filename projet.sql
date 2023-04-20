-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 20 avr. 2023 à 08:21
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `aime`
--

INSERT INTO `aime` (`id`, `utilisateur`, `publication`) VALUES
(54, 1, 3),
(55, 2, 7),
(57, 1, 11),
(59, 1, 8),
(60, 1, 16);

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE `Commentaire` (
  `id` int(11) NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `publication` int(11) NOT NULL,
  `texte` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Commentaire`
--

INSERT INTO `Commentaire` (`id`, `utilisateur`, `publication`, `texte`) VALUES
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
(27, 1, 16, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `Groupe`
--

CREATE TABLE `Groupe` (
  `id` int(11) NOT NULL,
  `nom` int(11) NOT NULL,
  `pdp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Publication`
--

CREATE TABLE `Publication` (
  `id` int(11) NOT NULL,
  `nblike` int(11) NOT NULL DEFAULT '0',
  `nbcom` int(11) NOT NULL DEFAULT '0',
  `texte` text NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Publication`
--

INSERT INTO `Publication` (`id`, `nblike`, `nbcom`, `texte`, `utilisateur`, `numero`) VALUES
(14, 0, 0, 'ZOe', 1, 3),
(16, 0, 0, 'Dessin', 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `suivi`
--

CREATE TABLE `suivi` (
  `Suiveur` int(11) NOT NULL,
  `Suivi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `SuiviGroupe`
--

CREATE TABLE `SuiviGroupe` (
  `Suiveur` int(11) NOT NULL,
  `Suivi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int(11) NOT NULL,
  `pseudo` text,
  `mail` text,
  `mdp` text,
  `pdp` int(11) NOT NULL DEFAULT '0',
  `nbpubli` int(11) NOT NULL DEFAULT '0',
  `administrateur` tinyint(1) NOT NULL DEFAULT '0',
  `story` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `pseudo`, `mail`, `mdp`, `pdp`, `nbpubli`, `administrateur`, `story`) VALUES
(1, 'laura32', 'eva.herson@me.com', 'ae0fe50dad89c8200649f99ea4be9581', 1, 6, 1, 1),
(2, 'evairson', 'laura.32@gmail.com', '591711fd93bb840e3f22096178354625', 2, 3, 1, 0),
(8, 'Kikoolol42069', 'capy.mama@gmail.fr', '4a84f9df36ab8da4e59c48fb220b256f', 0, 1, 0, 0),
(11, 'lila\r\n', 'lilaoujade@gmail.com', '11b0c25d5353c1fd2faccaceaceec4c8', 0, 0, 0, 0),
(12, 'lila2', 'lila@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, 1681976533);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `aime`
--
ALTER TABLE `aime`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Groupe`
--
ALTER TABLE `Groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Publication`
--
ALTER TABLE `Publication`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `aime`
--
ALTER TABLE `aime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `Groupe`
--
ALTER TABLE `Groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Publication`
--
ALTER TABLE `Publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
