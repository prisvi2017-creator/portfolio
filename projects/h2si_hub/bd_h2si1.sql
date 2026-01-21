-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 jan. 2026 à 17:42
-- Version du serveur : 11.8.2-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_h2si1`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_admin`
--

CREATE TABLE `t_admin` (
  `id` int(10) NOT NULL,
  `nom_ad` varchar(100) NOT NULL,
  `prenom_ad` varchar(100) NOT NULL,
  `mail_ad` varchar(100) NOT NULL,
  `mdp_ad` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_admin`
--

INSERT INTO `t_admin` (`id`, `nom_ad`, `prenom_ad`, `mail_ad`, `mdp_ad`, `image`, `date`) VALUES
(11, 'Kouame', 'ange', 'ange123@gmail.com', '$2y$10$ed2Jh/SXX3dAncjz2MYuQeKCarzsmcPsn5qz5GDpabWJ63Y64POR2', 'Picsart_23-06-25_10-15-06-142.jpg', '0000-00-00'),
(12, 'Kouamé', 'Ange Priscille', 'prisvi2017@gmail.com', '$2y$10$TvKOWwfyCi8bf5FP.uZTBuvFVS5c.s1rj5kS.ni3mcc.3MKzQc6cq', '825156.png', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `t_archives`
--

CREATE TABLE `t_archives` (
  `id` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `nom_et` varchar(255) NOT NULL,
  `prenom_et` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `formation` varchar(255) NOT NULL,
  `statut_precedent` varchar(255) NOT NULL,
  `nouveau_statut` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_archives`
--

INSERT INTO `t_archives` (`id`, `id_etudiant`, `nom_et`, `prenom_et`, `image`, `formation`, `statut_precedent`, `nouveau_statut`, `date`) VALUES
(50, 69, 'kouame', 'ange', '112092.png', 'Délégués Biomédicaux', 'inscris', 'encours', '2024-06-26'),
(51, 69, 'kouame', 'ange', '112092.png', 'Délégués Biomédicaux', 'encours', 'inscris', '2024-06-26'),
(52, 71, 'koffi', 'assia blanche', '880329.jpg', 'Délégués Biomédicaux', 'initie', 'inscris', '2024-06-26'),
(53, 72, 'kouame', 'ange', '249493.jpg', 'Brigade des hôpitaux', 'initie', 'inscris', '2024-09-06'),
(54, 73, 'Art', 'Priske', '96621.jpg', 'Délégués Biomédicaux', 'initie', 'inscris', '2024-10-13'),
(55, 74, 'Anoh', 'otsem', '92700.png', 'Délégués Biomédicaux', 'initie', 'Validerpourpaiement', '2025-05-26'),
(56, 74, 'Anoh', 'otsem', '92700.png', 'Délégués Biomédicaux', 'Validerpou', 'Validerpourpaiement', '2025-05-26'),
(57, 74, 'Anoh', 'otsem', '92700.png', 'Délégués Biomédicaux', 'Validerpou', 'rejete', '2025-05-26'),
(58, 74, 'Anoh', 'otsem', '92700.png', 'Délégués Biomédicaux', 'rejete', 'inscris', '2025-05-26'),
(59, 74, 'Anoh', 'otsem', '92700.png', 'Délégués Biomédicaux', 'inscris', 'inscris', '2025-05-26'),
(60, 74, 'Anoh', 'otsem', '92700.png', 'Délégués Biomédicaux', 'inscris', 'inscris', '2025-05-26'),
(61, 76, 'Koffi', 'anne', '688e99f68882c_36.jpg', 'Brigade des hôpitaux', 'initie', 'inscris', '2025-08-02');

-- --------------------------------------------------------

--
-- Structure de la table `t_avis`
--

CREATE TABLE `t_avis` (
  `id` int(11) NOT NULL,
  `id_client` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL,
  `note` tinyint(4) NOT NULL CHECK (`note` between 1 and 5),
  `commentaire` text DEFAULT NULL,
  `date_avis` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Déchargement des données de la table `t_avis`
--

INSERT INTO `t_avis` (`id`, `id_client`, `id_produit`, `note`, `commentaire`, `date_avis`) VALUES
(1, 88, 2, 3, 'super et en bonne état !', '2025-08-24 14:22:59'),
(3, 91, 2, 4, 'bon', '2025-08-24 16:46:19'),
(4, 94, 3, 3, 'bon', '2025-08-31 20:19:28'),
(5, 95, 4, 5, 'très bon', '2025-09-01 15:16:16'),
(6, 96, 4, 4, 'bon', '2025-09-01 16:24:21'),
(7, 98, 3, 3, 'bon produit', '2025-09-04 21:44:17');

-- --------------------------------------------------------

--
-- Structure de la table `t_client`
--

CREATE TABLE `t_client` (
  `id` int(10) NOT NULL,
  `nom_client` varchar(500) NOT NULL,
  `prenom_client` varchar(500) NOT NULL,
  `mail_client` varchar(1000) NOT NULL,
  `mdp_client` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_client`
--

INSERT INTO `t_client` (`id`, `nom_client`, `prenom_client`, `mail_client`, `mdp_client`) VALUES
(104, 'kouamé', 'ange', 'ange123@gmail.com', '$2y$10$9KGN84xUxkn4CLdhpl6IIeoCQbZk6EREN1AoxgGPIVZml24yvCaQG'),
(105, 'Kouame', 'ange', 'angel123@gmail.com', '$2y$10$VblUyoJ24TvCYuDygF2p9Oy1Yj5YGhcs7CzajEnfnGPS9TeKc/XSq');

-- --------------------------------------------------------

--
-- Structure de la table `t_commande`
--

CREATE TABLE `t_commande` (
  `id` int(10) NOT NULL,
  `id_client` int(10) NOT NULL,
  `nom_client` varchar(1000) NOT NULL,
  `prenom_client` varchar(1000) NOT NULL,
  `mail_client` varchar(1000) NOT NULL,
  `numero` int(11) NOT NULL,
  `addresse` varchar(1000) NOT NULL,
  `methode` varchar(100) NOT NULL,
  `pid` int(10) NOT NULL,
  `produit` varchar(100) NOT NULL,
  `prix` float NOT NULL,
  `statut_cmde` varchar(100) NOT NULL DEFAULT 'en cours',
  `date` date NOT NULL DEFAULT current_timestamp(),
  `visible_client` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_commande`
--

INSERT INTO `t_commande` (`id`, `id_client`, `nom_client`, `prenom_client`, `mail_client`, `numero`, `addresse`, `methode`, `pid`, `produit`, `prix`, `statut_cmde`, `date`, `visible_client`) VALUES
(63, 104, 'kouamé', 'ange', 'ange123@gmail.com', 778582004, 'cocody', 'à la livraison', 3, 'Microscope Optique (200000Fcfa x 1) -    Analysateur hemato (100000Fcfa x 1)', 300000, 'Livré', '2025-09-10', 1),
(64, 105, 'Kouame', 'ange', 'angel123@gmail.com', 778582004, 'yopougon', 'à la livraison', 25, 'miroir dentaire (4000Fcfa x 1)', 4000, 'en cours', '2025-12-03', 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_commentaire`
--

CREATE TABLE `t_commentaire` (
  `id` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `commentaire` longtext NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_commentaire`
--

INSERT INTO `t_commentaire` (`id`, `id_enseignant`, `id_etudiant`, `id_cours`, `commentaire`, `date`) VALUES
(26, 6, 104, 12, 'super cours', '2025-09-10');

-- --------------------------------------------------------

--
-- Structure de la table `t_cours`
--

CREATE TABLE `t_cours` (
  `id` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `titre` text NOT NULL,
  `description` longtext NOT NULL,
  `id_playlist` int(11) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `video` longtext NOT NULL,
  `pdf` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_cours`
--

INSERT INTO `t_cours` (`id`, `id_enseignant`, `titre`, `description`, `id_playlist`, `image`, `video`, `pdf`, `date`) VALUES
(7, 3, 'cours 1', 'cours1', 1, '48392.jpg', '601381.mp4', '', '2023-10-23'),
(12, 6, 'le système immunitaire', 'cours sur le système immunitaire', 13, '440814.jpeg', '145219.mp4', '', '2025-08-22'),
(13, 6, 'Sciences Biomédicales', 'tout savoir sur les sciences biomédicales', 14, '53830.jpg', '', '559432.pdf', '2025-08-31');

-- --------------------------------------------------------

--
-- Structure de la table `t_devis`
--

CREATE TABLE `t_devis` (
  `id` int(10) NOT NULL,
  `id_client` int(10) NOT NULL,
  `nom_client` varchar(1000) NOT NULL,
  `mail_client` varchar(1000) NOT NULL,
  `numero` int(11) NOT NULL,
  `societe` varchar(100) NOT NULL,
  `type_pdt` varchar(100) NOT NULL,
  `details` longtext NOT NULL,
  `reponse` longtext NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_devis`
--

INSERT INTO `t_devis` (`id`, `id_client`, `nom_client`, `mail_client`, `numero`, `societe`, `type_pdt`, `details`, `reponse`, `date`) VALUES
(7, 100, 'ange kouamé', 'ange123@gmail.com', 778582004, 'h2si', 'microscope', 'details', 'ok', '2025-09-05');

-- --------------------------------------------------------

--
-- Structure de la table `t_enseignant`
--

CREATE TABLE `t_enseignant` (
  `id` int(10) NOT NULL,
  `nom_prof` varchar(100) NOT NULL,
  `prenom_prof` varchar(100) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `mail_prof` varchar(100) NOT NULL,
  `mdp_prof` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_enseignant`
--

INSERT INTO `t_enseignant` (`id`, `nom_prof`, `prenom_prof`, `image`, `mail_prof`, `mdp_prof`, `date`) VALUES
(3, 'Kouamé', 'Tiémélé', '815902.png', 'kouametiem23@gmail.com', '$2y$10$6mkX1LYgP/bWRc1tlKd1gu/NQybTENZByDcimlUAYjo8YqOOjY3Iy', '0000-00-00'),
(6, 'kouame', 'Tiémélé', 'ChatGPT Image 19 juil. 2025, 11_44_50.png', 'prisvi2017@gmail.com', '$2y$10$DRfaj1NbFIC23RadzUNCIOlU47Uu1SfzU5DdqcIrEtw95tbyV.wDi', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `t_etudiant`
--

CREATE TABLE `t_etudiant` (
  `id` int(100) NOT NULL,
  `nom_et` varchar(1000) NOT NULL,
  `prenom_et` varchar(1000) NOT NULL,
  `mail_et` varchar(1000) NOT NULL,
  `sexe` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `id_formation` int(11) NOT NULL,
  `nom_form` varchar(1000) NOT NULL,
  `tel_et` int(100) NOT NULL,
  `mdp_et` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `statut` varchar(10) NOT NULL DEFAULT 'inscris'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_etudiant`
--

INSERT INTO `t_etudiant` (`id`, `nom_et`, `prenom_et`, `mail_et`, `sexe`, `image`, `id_formation`, `nom_form`, `tel_et`, `mdp_et`, `date`, `statut`) VALUES
(105, 'Kouame', 'Ange', 'ange123@gmail.com', 'Femme', '692f27c8af34f_34.jpg', 4, 'Délégués Biomédicaux', 778582004, '$2y$10$eNJCWmEjHlyGdMw8FRXSkuzeao2dNQOYxviaY.35zdEunRGRz54sO', '2025-12-02', 'inscris');

-- --------------------------------------------------------

--
-- Structure de la table `t_formation`
--

CREATE TABLE `t_formation` (
  `id` int(100) NOT NULL,
  `type_form` varchar(255) NOT NULL,
  `nom_form` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_formation`
--

INSERT INTO `t_formation` (`id`, `type_form`, `nom_form`) VALUES
(2, '', 'Agents de salubrité & Inspecteurs de salubrité'),
(3, '', 'Brigade des hôpitaux'),
(4, '', 'Délégués Biomédicaux'),
(5, '', 'Gouvernante générale Gouvernante de maison'),
(6, '', 'Opérateurs biotechniques et Scientifiques');

-- --------------------------------------------------------

--
-- Structure de la table `t_info`
--

CREATE TABLE `t_info` (
  `id` int(20) NOT NULL,
  `titre` text NOT NULL,
  `info` longtext NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_message`
--

CREATE TABLE `t_message` (
  `id` int(10) NOT NULL,
  `id_client` int(10) DEFAULT NULL,
  `id_etudiant` int(10) DEFAULT NULL,
  `prenom` varchar(1000) NOT NULL,
  `nom` varchar(1000) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `message` longtext NOT NULL,
  `reponse` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_message`
--

INSERT INTO `t_message` (`id`, `id_client`, `id_etudiant`, `prenom`, `nom`, `mail`, `tel`, `message`, `reponse`) VALUES
(47, NULL, 103, 'ange', 'kouame', 'ange123@gmail.com', '0778582004', 'Bonjour admiin', 'Bonjour etudiant'),
(48, NULL, 104, 'ange', 'Kouame', 'ange123@gmail.com', '0778582004', 'Bonjour admin', 'Bonjour etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `t_notifications`
--

CREATE TABLE `t_notifications` (
  `id` int(11) NOT NULL,
  `id_etudiant` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `est_lue` tinyint(1) DEFAULT 0,
  `date_envoi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_notifications`
--

INSERT INTO `t_notifications` (`id`, `id_etudiant`, `id_client`, `titre`, `message`, `est_lue`, `date_envoi`) VALUES
(11, NULL, 88, 'Réponse à votre demande de devis', 'L\'administrateur vous a répondu : \"Bonjour, nous sommes actuellement en rupture de stock, veuillez nous recontatez dans 2 jours , merci de votre patiente ! bien a vous \"', 1, '2025-08-14 22:20:29'),
(12, NULL, 88, 'Commande confirmée', 'Votre commande n°29 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 1, '2025-08-14 22:26:00'),
(15, 72, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour Ange, bienvenue sur notre plateforme de cours en ligne !\"', 1, '2025-08-18 19:22:58'),
(19, NULL, 88, 'Livraison effectuée', 'Votre commande n°31 a été livrée avec succès. Merci de nous avoir fait confiance !', 1, '2025-08-22 12:24:53'),
(20, NULL, 88, 'Commande confirmée', 'Votre commande n°32 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 1, '2025-08-24 13:39:44'),
(21, NULL, 88, 'Livraison effectuée', 'Votre commande n°32 a été livrée avec succès. Merci de nous avoir fait confiance !', 1, '2025-08-24 13:40:46'),
(38, 80, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"bonjour \"', 1, '2025-08-31 19:09:16'),
(39, NULL, 92, 'Commande confirmée', 'Votre commande n°42 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 1, '2025-08-31 19:13:18'),
(40, NULL, 92, 'Livraison effectuée', 'Votre commande n°42 a été livrée avec succès. Merci de nous avoir fait confiance !', 1, '2025-08-31 19:13:44'),
(41, NULL, 94, 'Commande confirmée', 'Votre commande n°43 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 1, '2025-08-31 20:18:27'),
(42, NULL, 94, 'Livraison effectuée', 'Votre commande n°43 a été livrée avec succès. Merci de nous avoir fait confiance !', 1, '2025-08-31 20:18:53'),
(43, NULL, 92, 'Commande Annulée', 'Votre commande n°42 a été Annulée par l\'administrateur, Veuillez contactez le service client pour plus d\'info!', 0, '2025-09-01 11:33:11'),
(44, NULL, 94, 'Commande confirmée', 'Votre commande n°43 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 0, '2025-09-01 11:44:34'),
(47, NULL, 94, 'Commande confirmée', 'Votre commande n°43 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 0, '2025-09-01 11:56:25'),
(52, 87, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-01 15:01:53'),
(53, NULL, 95, 'Commande confirmée', 'Votre commande n°45 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 1, '2025-09-01 15:04:32'),
(54, NULL, 95, 'Livraison effectuée', 'Votre commande n°45 a été livrée avec succès. Merci de nous avoir fait confiance !', 1, '2025-09-01 15:04:52'),
(58, NULL, NULL, 'Commande confirmée', 'Votre commande n°48 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 0, '2025-09-01 16:01:04'),
(59, 88, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-01 16:17:39'),
(60, NULL, 96, 'Commande confirmée', 'Votre commande n°49 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 0, '2025-09-01 16:22:15'),
(62, 89, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-04 21:36:16'),
(67, 93, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour\"', 1, '2025-09-05 17:22:56'),
(68, NULL, 100, 'Réponse à votre demande de devis', 'L\'administrateur vous a répondu : \"ok\"', 1, '2025-09-05 17:26:18'),
(69, NULL, 100, 'Réponse à votre demande de devis', 'L\'administrateur vous a répondu : \"ok\"', 1, '2025-09-05 17:26:21'),
(70, NULL, 100, 'Commande confirmée', 'Votre commande n°53 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 0, '2025-09-05 17:27:51'),
(71, 94, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour\"', 1, '2025-09-06 09:48:29'),
(73, 95, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour\"', 1, '2025-09-07 10:40:07'),
(75, 96, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-07 19:25:30'),
(77, 98, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-08 20:40:45'),
(79, 99, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-09 11:11:19'),
(80, 100, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-09 11:24:44'),
(82, 101, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-09 18:31:23'),
(84, 102, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-10 09:37:30'),
(86, 103, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-10 15:15:21'),
(87, NULL, 103, 'Commande confirmée', 'Votre commande n°62 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 0, '2025-09-10 15:17:55'),
(88, 104, NULL, 'Réponse à votre message', 'L\'administrateur vous a répondu : \"Bonjour etudiant\"', 1, '2025-09-10 16:55:12'),
(89, NULL, 104, 'Commande confirmée', 'Votre commande n°63 a été confirmée par l\'administrateur, le processus de livraison est lancé!', 0, '2025-09-10 16:58:31');

-- --------------------------------------------------------

--
-- Structure de la table `t_panier`
--

CREATE TABLE `t_panier` (
  `id` int(10) NOT NULL,
  `id_client` int(10) NOT NULL,
  `id_pdt` int(10) NOT NULL,
  `nom` varchar(1000) NOT NULL,
  `prix` float NOT NULL,
  `quantite` int(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_panier`
--

INSERT INTO `t_panier` (`id`, `id_client`, `id_pdt`, `nom`, `prix`, `quantite`) VALUES
(145, 91, 5, 'becher en verre borosil', 5500, 1),
(143, 96, 2, '   Analysateur hemato', 100000, 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_playlist`
--

CREATE TABLE `t_playlist` (
  `id` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `titre` text NOT NULL,
  `description` longtext NOT NULL,
  `id_formation` int(11) NOT NULL,
  `nom_form` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_playlist`
--

INSERT INTO `t_playlist` (`id`, `id_enseignant`, `titre`, `description`, `id_formation`, `nom_form`, `image`, `date`) VALUES
(1, 3, 'biologie', 'Cours de Biologie ', 3, 'Brigade des hôpitaux', '176601.jpg', '2023-10-20'),
(13, 6, 'cours biochimie', 'cours de biochimie', 4, 'Délégués Biomédicaux', '260690.jpg', '2025-08-22'),
(14, 6, 'Biomedicaux', 'Biomedicaux', 4, 'Délégués Biomédicaux', '601086.jpg', '2025-08-31');

-- --------------------------------------------------------

--
-- Structure de la table `t_playlist_formation`
--

CREATE TABLE `t_playlist_formation` (
  `playlist_id` int(11) NOT NULL,
  `formation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_produit`
--

CREATE TABLE `t_produit` (
  `id` int(10) NOT NULL,
  `nom_pdt` varchar(1000) NOT NULL,
  `prix` float NOT NULL,
  `image` varchar(1000) NOT NULL,
  `detail_pdt` longtext NOT NULL,
  `categorie` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_produit`
--

INSERT INTO `t_produit` (`id`, `nom_pdt`, `prix`, `image`, `detail_pdt`, `categorie`) VALUES
(2, '   Analysateur hemato', 100000, 'analyseur hemato.jpg', '   abordable', 'Technicien de laboratoire'),
(3, 'Microscope Optique', 200000, '652286.jpg', 'Offrez à vos analyses une précision optimale avec ce microscope de laboratoire haute performance. Conçu pour les professionnels de la santé, de la recherche et de l’enseignement, il permet une observation claire et détaillée des échantillons biologiques et chimiques.\r\n\r\n✅ Caractéristiques :\r\n\r\nOptique de haute qualité avec lentilles achromatiques ou plan-achromatiques\r\n\r\nObjectifs multiples (4x, 10x, 40x, 100x) avec mise au point fine et grossière\r\n\r\nÉclairage LED réglable pour une luminosité constante\r\n\r\nPlatine mécanique double pour un déplacement précis des lames\r\n\r\nCorps robuste, ergonomique et facile à utiliser\r\n\r\nIdéal pour : laboratoires médicaux, établissements scolaires, centres de recherche et universités.', 'Technicien de laboratoire'),
(4, 'BOITE PETRI EN VERRE D.90 MM', 2500, '613549.jpg', 'disponible', 'Technicien de laboratoire'),
(5, 'becher en verre borosil', 5500, '7538.jpg', 'disponible', 'Technicien de laboratoire'),
(6, ' Tube de prélèvement ', 7000, '158834.jpg', ' disponible', 'Technicien de laboratoire'),
(25, 'miroir dentaire', 4000, '302430.png', 'Le miroir dentaire est un outil indispensable en cabinet dentaire, utilisé pour visualiser les zones difficiles d\'accès dans la bouche du patient. Il est généralement fabriqué en acier inoxydable stérilisable et doté d\'une surface réfléchissante de haute qualité qui offre une image nette sans distorsion. Léger, ergonomique et résistant à la chaleur, il peut être stérilisé à haute température. Ce miroir permet aux professionnels de la santé bucco-dentaire d\'examiner efficacement les dents, les gencives et les muqueuses.', 'Dentiste'),
(26, 'Coton tige', 1900, '221958.jpg', 'Offrez précision et confort avec notre coton-tige gynécologique stérile, idéal pour les prélèvements en toute sécurité. Doux, hygiénique et facile à manipuler, il garantit une utilisation professionnelle lors des examens gynécologiques.\r\n\r\n', 'Gynécologue'),
(27, 'gants en latex ', 6000, '145371.jpeg', '-paquet de 100 pièces\r\n\r\n-Composition : latex naturel non poudré\r\n\r\n-Usage : examen médical, hygiène, entretien\r\n\r\n-Caractéristiques : non stérile, sans poudre, bonne tolérance cutanée, manchette ourlée, surface micro-rugueuse pour une meilleure prise en main', 'Toutes specialites'),
(28, 'Seringue air-eau', 6000, '254828.jpg', 'Matériau : acier inoxydable, résistant à l’autoclavage\r\n\r\nFonctions : jets d’air, d’eau et spray combiné pour nettoyage et séchage rapides\r\n\r\nUsage professionnel : raccordée au fauteuil via tuyauterie, avec embouts amovibles autoclavables', 'Dentiste');

-- --------------------------------------------------------

--
-- Structure de la table `t_programme`
--

CREATE TABLE `t_programme` (
  `id` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `pdf` varchar(255) NOT NULL,
  `id_formation` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_programme`
--

INSERT INTO `t_programme` (`id`, `id_enseignant`, `pdf`, `id_formation`, `date`) VALUES
(3, 6, '892662.pdf', 3, '2024-09-06 13:28:28');

-- --------------------------------------------------------

--
-- Structure de la table `t_visioconference`
--

CREATE TABLE `t_visioconference` (
  `id` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `lien` text NOT NULL,
  `id_formation` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_whatsapp`
--

CREATE TABLE `t_whatsapp` (
  `id` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `lien` text NOT NULL,
  `id_formation` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `t_whatsapp`
--

INSERT INTO `t_whatsapp` (`id`, `id_enseignant`, `lien`, `id_formation`, `date_creation`) VALUES
(4, 6, 'hufjfjfjjdkjfokfd', 4, '2024-07-03 22:11:57'),
(5, 6, 'https://chat.whatsapp.com/FfoVlvWdLqwDo56IaNtzPq', 3, '2024-07-03 22:23:32'),
(6, 6, 'https://chat.whatsapp.com/JhIsA9U65jnLtmHBpArJIq', 6, '2024-07-03 22:23:40');

-- --------------------------------------------------------

--
-- Structure de la table `t_wishlist`
--

CREATE TABLE `t_wishlist` (
  `id` int(10) NOT NULL,
  `id_client` int(10) NOT NULL,
  `id_pdt` int(10) NOT NULL,
  `nom` varchar(1000) NOT NULL,
  `prix` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail_ad` (`mail_ad`);

--
-- Index pour la table `t_archives`
--
ALTER TABLE `t_archives`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_avis`
--
ALTER TABLE `t_avis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_client`
--
ALTER TABLE `t_client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail_client` (`mail_client`) USING HASH;

--
-- Index pour la table `t_commande`
--
ALTER TABLE `t_commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_commentaire`
--
ALTER TABLE `t_commentaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_cours`
--
ALTER TABLE `t_cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_devis`
--
ALTER TABLE `t_devis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_enseignant`
--
ALTER TABLE `t_enseignant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail_prof` (`mail_prof`);

--
-- Index pour la table `t_etudiant`
--
ALTER TABLE `t_etudiant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail_et` (`mail_et`);

--
-- Index pour la table `t_formation`
--
ALTER TABLE `t_formation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_info`
--
ALTER TABLE `t_info`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_message`
--
ALTER TABLE `t_message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_notifications`
--
ALTER TABLE `t_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_panier`
--
ALTER TABLE `t_panier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_playlist`
--
ALTER TABLE `t_playlist`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_playlist_formation`
--
ALTER TABLE `t_playlist_formation`
  ADD PRIMARY KEY (`playlist_id`,`formation_id`),
  ADD KEY `formation_id` (`formation_id`);

--
-- Index pour la table `t_produit`
--
ALTER TABLE `t_produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_programme`
--
ALTER TABLE `t_programme`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_visioconference`
--
ALTER TABLE `t_visioconference`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_whatsapp`
--
ALTER TABLE `t_whatsapp`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_wishlist`
--
ALTER TABLE `t_wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_admin`
--
ALTER TABLE `t_admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `t_archives`
--
ALTER TABLE `t_archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `t_avis`
--
ALTER TABLE `t_avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `t_client`
--
ALTER TABLE `t_client`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `t_commande`
--
ALTER TABLE `t_commande`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `t_commentaire`
--
ALTER TABLE `t_commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `t_cours`
--
ALTER TABLE `t_cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `t_devis`
--
ALTER TABLE `t_devis`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `t_enseignant`
--
ALTER TABLE `t_enseignant`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `t_etudiant`
--
ALTER TABLE `t_etudiant`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `t_formation`
--
ALTER TABLE `t_formation`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `t_info`
--
ALTER TABLE `t_info`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_message`
--
ALTER TABLE `t_message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `t_notifications`
--
ALTER TABLE `t_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `t_panier`
--
ALTER TABLE `t_panier`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT pour la table `t_playlist`
--
ALTER TABLE `t_playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `t_produit`
--
ALTER TABLE `t_produit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `t_programme`
--
ALTER TABLE `t_programme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `t_visioconference`
--
ALTER TABLE `t_visioconference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `t_whatsapp`
--
ALTER TABLE `t_whatsapp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `t_wishlist`
--
ALTER TABLE `t_wishlist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_playlist_formation`
--
ALTER TABLE `t_playlist_formation`
  ADD CONSTRAINT `t_playlist_formation_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `t_playlist` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_playlist_formation_ibfk_2` FOREIGN KEY (`formation_id`) REFERENCES `t_formation` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
