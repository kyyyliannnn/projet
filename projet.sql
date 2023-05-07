
--Création des tables--

CREATE TABLE utilisateur (
  id int(11) NOT NULL,
  pseudo text DEFAULT NULL,
  mail text DEFAULT NULL,
  mdp text DEFAULT NULL,
  pdp int(11) NOT NULL DEFAULT 0,
  nbpubli int(11) NOT NULL DEFAULT 0,
  administrateur tinyint(1) NOT NULL DEFAULT 0,
  story int(11) NOT NULL DEFAULT 0,
  universite text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE universite (
  id int(11) NOT NULL,
  nom text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE publication (
  id int(11) NOT NULL,
  nblike int(11) NOT NULL DEFAULT 0,
  nbcom int(11) NOT NULL DEFAULT 0,
  texte text NOT NULL,
  utilisateur int(11) NOT NULL,
  numero int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE suivi (
  id int(11) NOT NULL,
  suiveur int(11) NOT NULL,
  suivi int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE aime (
  id int(11) NOT NULL,
  utilisateur int(11) NOT NULL,
  publication int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE commentaire (
  id int(11) NOT NULL,
  utilisateur int(11) NOT NULL,
  publication int(11) NOT NULL,
  texte text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--On donne les priorités de l'id pour chaque table

ALTER TABLE utilisateur
  ADD PRIMARY KEY (id);

ALTER TABLE universite
  ADD PRIMARY KEY (id);

ALTER TABLE publication
  ADD PRIMARY KEY (id);

ALTER TABLE suivi
  ADD PRIMARY KEY (id);

ALTER TABLE aime
  ADD PRIMARY KEY (id);

ALTER TABLE commentaire
  ADD PRIMARY KEY (id);

ALTER TABLE utilisateur
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE universite
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE publication
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

ALTER TABLE suivi
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE aime
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE commentaire
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--On remplit la table des universités, nous conseillons de conserver cette table

INSERT INTO universite (id, nom) VALUES
(1, 'Panthéon-Sorbonne'),
(2, 'Panthéon-Assas'),
(3, 'Sorbonne Nouvelle'),
(4, 'Sorbonne Université'),
(5, 'Paris-Cité'),
(6, 'PSL'),
(7, 'Paris 8'),
(8, 'Paris Dauphine'),
(9, 'Paris Nanterre'),
(10, 'Paris-Saclay'),
(11, 'UPEC'),
(12, 'Sorbonne Paris Nord');

--On remplit ces tables pour avoir des exemples d'utilisateurs, on peut les vider pour rénitialiser le site

INSERT INTO utilisateur (id, pseudo, mail, mdp, pdp, nbpubli, administrateur, story, universite) VALUES
(1, 'Corentin', 'Corentin@gmail.com', 'b3e35be7522c9afb0046332492b34833', 1, 3, 0, 0, 'Panthéon-Sorbonne'),
(2, 'Louise', 'Louise@gmail.com', 'beabe6c3951b36ed582e4320b122ec4f', 2, 0, 0, 0, 'Panthéon-Sorbonne'),
(3, 'Joshua', 'Joshua@gmail.com', '85b103482a20682da703aa388933a6d8', 3, 1, 0, 0, 'Panthéon-Assas'),
(4, 'Olivia', 'Olivia@gmail.com', 'ba546f8d6d55634ce9106423ee4c5275', 0, 2, 0, 0, 'Panthéon-Assas'),
(5, 'Hannah', 'Hannah@gmail.com', '02741b0009c596be71a2fbeda099af97', 5, 1, 0, 0, 'Sorbonne Nouvelle'),
(6, 'Julian', 'Julian@gmail.com', '60659cfda992013e610f285c46692d28', 6, 3, 0, 0, 'Sorbonne Nouvelle'),
(7, 'Fatima', 'Fatima@gmail.com', '2c68c7155ea84c0a056bb40d405dcb26', 7, 2, 0, 0, 'Sorbonne Université'),
(8, 'Thomas', 'Thomas@gmail.com', '2042101ac1f6e7741bfe43f3672e6d7c', 8, 1, 0, 0, 'Sorbonne Université'),
(9, 'Stella', 'Stella@gmail.com', 'e64a40ce1e9c2e3bd4bea3d33cd4bfb3', 0, 1, 0, 0, 'Paris-Cité'),
(10, 'Alexis', 'Alexis@gmail.com', '79162b02a4adef009a7d8214aaaafec5', 10, 0, 0, 0, 'Paris-Cité'),
(11, 'Margot', 'Margot@gmail.com', '7cbc46f5ab966ebba0537a123fea1e7a', 11, 0, 0, 0, 'PSL'),
(12, 'Hubert', 'Hubert@gmail.com', '8f29971e57bcead61420c7da8eff93de', 0, 2, 0, 0, 'PSL'),
(13, 'Peyton', 'Peyton@gmail.com', '43505c695989e96ee804d02d5e615035', 0, 1, 0, 0, 'Paris 8'),
(14, 'Jayden', 'Jayden@gmail.com', '9d8c6fc9a53e9672d9c798e237f5386f', 14, 0, 0, 0, 'Paris 8'),
(15, 'Andrew', 'Andrew@gmail.com', '8aae3a73a9a43ee6b04dfd986fe9d136', 0, 0, 0, 0, 'Paris Dauphine'),
(16, 'Alyssa', 'Alyssa@gmail.com', 'ce464052284612a2f064cbe8234e9621', 16, 1, 0, 0, 'Paris Dauphine'),
(17, 'Damien', 'Damien@gmail.com', '86ed8f9ff7cd264dd2080ff10ead0320', 17, 2, 0, 0, 'Paris Nanterre'),
(18, 'Flavie', 'Flavie@gmail.com', 'd59161da8659fa4935d2fb6ba78c1ce2', 18, 0, 0, 0, 'Paris Nanterre'),
(19, 'Jordan', 'Jordan@gmail.com', '6ea1e24d60afddf388b06f8243c45b70', 0, 1, 0, 0, 'Paris-Saclay'),
(20, 'Sophia', 'Sophia@gmail.com', 'ba15a18cd3a8fb567e39053022515eb6', 20, 0, 0, 0, 'Paris-Saclay'),
(21, 'Justin', 'Justin@gmail.com', '06475174d922e7dcbb3ed34c0236dbdf', 21, 2, 0, 0, 'UPEC'),
(22, 'Audrey', 'Audrey@gmail.com', 'cc2f410031aea40769918b7adb73a696', 22, 0, 0, 0, 'UPEC'),
(23, 'Joseph', 'Joseph@gmail.com', '6a1a376d8169cfc1835f59ac934edbb7', 0, 1, 0, 0, 'Sorbonne Paris Nord'),
(24, 'Agathe', 'Agathe@gmail.com', 'ff627ce7f5f88b7b6c65a39db41225d2', 24, 2, 0, 0, 'Sorbonne Paris Nord');



INSERT INTO publication (id, nblike, nbcom, texte, utilisateur, numero) VALUES
(1, 0, 0, "Pas mal le quartier", 1, 0),
(2, 0, 0, "Petite balade en forêt", 9, 0),
(3, 0, 0, "Important de se reposer après les partiels", 3, 0),
(4, 0, 0, "En plein dans les révisions", 4, 0),
(5, 0, 0, "Journée tennis", 21, 0),
(6, 0, 0, "", 21, 1),
(7, 0, 0, "Les répétitions !!!", 5, 0),
(8, 0, 0, "J'adore la tour Eiffel", 17, 0),
(9, 0, 0, "Encore mieux sur cette photo", 17, 1),
(10, 0, 0, "", 6, 0),
(11, 0, 0, "", 6, 1),
(12, 0, 0, "Des vacances bien méritées !", 12, 0),
(13, 0, 0, "C'est mieux à deux...", 16, 0),
(14, 0, 0, "Trop cool le concert !", 13, 0),
(15, 0, 0, ":)", 24, 0),
(16, 0, 0, "Merci pour la soirée, c'était cool", 8, 0),
(17, 0, 0, "", 1, 2),
(18, 0, 0, "", 1, 3),
(19, 0, 0, "Je suis allée au Louvre !", 7, 0),
(20, 0, 0, "", 6, 2),
(21, 0, 0, "Avec les copains ", 19, 0),
(22, 0, 0, "week-end", 23, 0),
(23, 0, 0, "", 24, 1),
(24, 0, 0, "", 7, 1),
(25, 0, 0, "Petit festival", 12, 1),
(26, 0, 0, "miam", 4, 1);

INSERT INTO suivi (id, suiveur, suivi) VALUES
(1, 2, 1),
(2, 1, 2),
(3, 4, 3),
(4, 3, 4),
(5, 6, 5),
(6, 5, 6),
(7, 8, 7),
(8, 7, 8),
(9, 10, 9),
(10, 9, 10),
(11, 12, 11),
(12, 11, 12),
(13, 14, 13),
(14, 13, 14),
(15, 16, 15),
(16, 15, 16),
(17, 18, 17),
(18, 17, 18),
(19, 20, 19),
(20, 19, 20),
(21, 22, 21),
(22, 21, 22),
(23, 24, 23),
(24, 23, 24);
