-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 23 mars 2023 à 18:23
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
(55, 2, 7);

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
(13, 1, 4, "Je t'aime"),
(14, 1, 3, 'wesh'),
(17, 2, 2, 'Stylé'),
(18, 2, 4, 'VOILA'),
(19, 2, 4, 'Genial !'),
(20, 1, 2, 'laura'),
(21, 1, 4, 'coucou'),
(22, 2, 7, 'sympa !');

-- --------------------------------------------------------

--
-- Structure de la table `Publication`
--

CREATE TABLE `Publication` (
  `id` int(11) NOT NULL,
  `nblike` int(11) NOT NULL DEFAULT '0',
  `nbcom` int(11) NOT NULL DEFAULT '0',
  `Texte` text NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Publication`
--

INSERT INTO `Publication` (`id`, `nblike`, `nbcom`, `Texte`, `utilisateur`, `numero`) VALUES
(6, 0, 0, 'jhv', 1, 1),
(7, 0, 0, 'kughb', 1, 0),
(8, 0, 0, 'voila', 1, 1),
(9, 0, 0, 'Ma nouvelle déco !', 2, 0),
(10, 0, 0, 'lpb', 2, 1);

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
  `nbpubli` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `pseudo`, `mail`, `mdp`, `pdp`, `nbpubli`) VALUES
(1, 'Laura_32', 'eva.herson@me.com', 'EvaH100504', 1, 2),
(2, 'Eva', 'eva.herson@gmail.com', 'EvaH100504#', 2, 2),
(3, NULL, 'nina.herson@me.com', 'Ehfazuife', 0, 0),
(4, NULL, NULL, NULL, 0, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `Publication`
--
ALTER TABLE `Publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
