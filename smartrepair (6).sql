-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 10 avr. 2019 à 22:07
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `smartrepair`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id_adresse` int(11) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id_adresse`, `adresse`, `type`, `lat`, `lng`) VALUES
(78, '114 Av. des Champs-Ã‰lysÃ©es, 75008 Paris, France', 'reparateur', 48.8722, 2.30132),
(77, '25 Rue de la Reynie, 75001 Paris, France', 'reparateur', 48.86, 2.34862),
(76, '2 Cour CarrÃ©e, 75001 Paris, France', 'reparateur', 48.8599, 2.33837),
(75, '97 Rue Ordener, 75018 Paris, France', 'reparateur', 48.8919, 2.3468),
(74, '11 Avenue du Maine, 75015 Paris, France', 'reparateur', 48.8442, 2.32045);

-- --------------------------------------------------------

--
-- Structure de la table `concordance_marque_reparateur`
--

CREATE TABLE `concordance_marque_reparateur` (
  `id_concordance_marque_reparateur` int(11) NOT NULL,
  `id_marque_ref` varchar(255) NOT NULL,
  `id_reparateur_ref` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `concordance_marque_reparateur`
--

INSERT INTO `concordance_marque_reparateur` (`id_concordance_marque_reparateur`, `id_marque_ref`, `id_reparateur_ref`) VALUES
(79, 'Apple', 61),
(78, 'Samsung', 60),
(77, 'LG', 60),
(76, 'Apple', 60),
(75, 'Wiko', 59),
(74, 'Sony', 59),
(73, 'Samsung', 59),
(72, 'LG', 59),
(71, 'Huawei', 59),
(70, 'Apple', 59),
(69, 'One Plus', 58),
(68, 'Huawei', 58),
(67, 'Apple', 58),
(66, 'Sony', 57),
(65, 'Samsung', 57),
(64, 'LG', 57),
(63, 'Huawei', 57);

-- --------------------------------------------------------

--
-- Structure de la table `concordance_note_reparateur_utilisateur`
--

CREATE TABLE `concordance_note_reparateur_utilisateur` (
  `id_concordance_note_reparateur_utilisateur` int(11) NOT NULL,
  `id_utilisateur_ref` int(11) NOT NULL,
  `id_reparateur_ref` int(11) NOT NULL,
  `id_note_ref` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `concordance_probleme_reparateur`
--

CREATE TABLE `concordance_probleme_reparateur` (
  `id_concordance_probleme_reparateur` int(11) NOT NULL,
  `id_probleme_ref` int(11) NOT NULL,
  `id_reparateur_ref` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `id_nom` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_nom`) VALUES
('Apple'),
('Huawei'),
('LG'),
('One Plus'),
('Oppo'),
('Samsung'),
('Sony'),
('Wiko'),
('Xiaomi');

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

CREATE TABLE `modele` (
  `id_modele` int(11) NOT NULL,
  `nom` char(255) DEFAULT NULL,
  `id_marque_ref` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `modele`
--

INSERT INTO `modele` (`id_modele`, `nom`, `id_marque_ref`) VALUES
(1, 'Iphone 6s', 'Apple');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(11) NOT NULL,
  `prix` int(11) DEFAULT NULL,
  `amabilite` int(11) DEFAULT NULL,
  `temps` int(11) DEFAULT NULL,
  `fiabilite` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_poster` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `probleme`
--

CREATE TABLE `probleme` (
  `id_probleme` int(11) NOT NULL,
  `nom` char(255) DEFAULT NULL,
  `description` char(255) DEFAULT NULL,
  `modele_ref` int(11) DEFAULT NULL,
  `prix` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reparateur`
--

CREATE TABLE `reparateur` (
  `id_reparateur` int(11) NOT NULL,
  `nom` char(255) DEFAULT NULL,
  `id_adresse_ref` int(11) DEFAULT NULL,
  `description` char(255) DEFAULT NULL,
  `moyen_paiement_cash` tinyint(1) DEFAULT NULL,
  `moyen_paiement_carte` tinyint(1) DEFAULT NULL,
  `moyen_paiement_cheque` tinyint(1) DEFAULT NULL,
  `note` float DEFAULT NULL,
  `site_internet` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `numero_telephone` varchar(255) NOT NULL,
  `heure_ouverture_semaine` varchar(255) NOT NULL,
  `heure_ouverture_samedi` varchar(255) NOT NULL,
  `heure_ouverture_dimanche` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `avatar2` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reparateur`
--

INSERT INTO `reparateur` (`id_reparateur`, `nom`, `id_adresse_ref`, `description`, `moyen_paiement_cash`, `moyen_paiement_carte`, `moyen_paiement_cheque`, `note`, `site_internet`, `mail`, `mot_de_passe`, `numero_telephone`, `heure_ouverture_semaine`, `heure_ouverture_samedi`, `heure_ouverture_dimanche`, `avatar`, `avatar2`) VALUES
(58, 'ClassMobile', 75, 'Service de rÃ©paration de matÃ©riel Ã©lectronique Ã  Paris 75018', 1, 1, 0, 0, 'https://www.classmobile.fr/', 'classmobile@outlook.fr', 'cca8aa7849b18cdfdb75ab3f0ee28bbe59e5d43d', '01 71 32 40 56', '09h00 - 19h30', '09h00 - 19h30', 'FermÃ©', '58.png', ''),
(60, 'SOS Smartphone', 77, 'Service de rÃ©paration de smartphone rapide', 1, 1, 0, 0, 'http://sos-reparation-smartphone.fr/', 'sos-reparation@outlook.fr', '2a816d1b9d8ce72a2468d163d6231af62cedcc19', '09 84 27 90 66', '11h00 - 20h00', '11h00 - 20h00', 'FermÃ©', '60.jpg', ''),
(61, 'Apple Champs-Ã‰lysÃ©es', 78, 'Service de rÃ©paration Apple Icare et vente de produit Apple', 1, 1, 1, 0, 'https://www.apple.com/fr/retail/champs-elysees/', 'apple@store.fr', 'd0be2dc421be4fcd0172e5afceea3970e2f3d940', '01 70 98 09 00', '10h00 - 21h00', '10h00 - 21h00', '10h00 - 20h00', '61.jpg', ''),
(59, 'Save', 76, 'Service de rÃ©paration de smartphone rapide sous 1h', 1, 1, 1, 0, 'https://www.save.co/fr/fr', 'save@outlook.fr', '13a4a11319d31c1b323d5774f44240a9ffc984d0', '01 76 34 01 19', '09h30 - 20h00', '09h30 - 20h00', 'FermÃ©', '59.png', ''),
(57, 'Point Service Mobiles Montparnasse', 74, 'Service de rÃ©paration de matÃ©riel Ã©lectronique Ã  Paris', 1, 1, 0, 0, 'https://www.allopsm.fr/', 'psm_montparnasse@psm.fr', 'c6c7807fe0254f6305d5d376d6d5295757e8005e', '01 45 44 39 11', '09h00 - 19h00', '09h00 - 19h00', 'FermÃ©', '57.jpg', '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `prenom`, `nom`, `mail`, `mot_de_passe`, `avatar`) VALUES
(17, 'Tiphaine', 'Plusquellec', 'tiphaine.plusquellec@edu.ece.fr', 'be03880fc2ef0f0cb86405d464b8558e80a622b0', '17.jpg'),
(16, 'Ethan', 'Guez', 'ethan.guez@edu.ece.fr', '0a27e12d062ad71673d57f9c2799b207af316885', '16.jpg'),
(15, 'Guillaume', 'Roumens', 'guillaume.roumens@edu.ece.fr', '2450ec3ccdf9492f0296810ab160876644aa9cff', '15.jpg'),
(14, 'Raphael', 'Lopes', 'raphael.lopes@edu.ece.fr', 'ec67638a84dca5d1ffa2be696be98fba4d39bfb8', '14.jpg'),
(13, 'Pirathap', 'Sivarajah', 'pirathap.sivarajah@edu.ece.fr', '88c1c6846a10780a63b1cca50e8d63e72e0dc202', '13.jpg'),
(12, 'Gautier', 'Mignot ', 'gautier.mignot@edu.ece.fr', '77c439947af01d10f1fa485ad4d8ebc7895ffe2a', '12.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id_adresse`);

--
-- Index pour la table `concordance_marque_reparateur`
--
ALTER TABLE `concordance_marque_reparateur`
  ADD PRIMARY KEY (`id_concordance_marque_reparateur`),
  ADD KEY `id_marque_ref` (`id_marque_ref`),
  ADD KEY `id_reparateur_ref` (`id_reparateur_ref`);

--
-- Index pour la table `concordance_note_reparateur_utilisateur`
--
ALTER TABLE `concordance_note_reparateur_utilisateur`
  ADD PRIMARY KEY (`id_concordance_note_reparateur_utilisateur`),
  ADD KEY `id_utilisateur_ref` (`id_utilisateur_ref`),
  ADD KEY `id_reparateur_ref` (`id_reparateur_ref`),
  ADD KEY `id_note_ref` (`id_note_ref`);

--
-- Index pour la table `concordance_probleme_reparateur`
--
ALTER TABLE `concordance_probleme_reparateur`
  ADD PRIMARY KEY (`id_concordance_probleme_reparateur`),
  ADD KEY `id_probleme_ref` (`id_probleme_ref`),
  ADD KEY `id_reparateur_ref` (`id_reparateur_ref`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id_nom`);

--
-- Index pour la table `modele`
--
ALTER TABLE `modele`
  ADD PRIMARY KEY (`id_modele`),
  ADD KEY `id_marque_ref` (`id_marque_ref`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`);

--
-- Index pour la table `probleme`
--
ALTER TABLE `probleme`
  ADD PRIMARY KEY (`id_probleme`),
  ADD KEY `modele_ref` (`modele_ref`);

--
-- Index pour la table `reparateur`
--
ALTER TABLE `reparateur`
  ADD PRIMARY KEY (`id_reparateur`),
  ADD KEY `id_adresse_ref` (`id_adresse_ref`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id_adresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT pour la table `concordance_marque_reparateur`
--
ALTER TABLE `concordance_marque_reparateur`
  MODIFY `id_concordance_marque_reparateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `concordance_note_reparateur_utilisateur`
--
ALTER TABLE `concordance_note_reparateur_utilisateur`
  MODIFY `id_concordance_note_reparateur_utilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `concordance_probleme_reparateur`
--
ALTER TABLE `concordance_probleme_reparateur`
  MODIFY `id_concordance_probleme_reparateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `modele`
--
ALTER TABLE `modele`
  MODIFY `id_modele` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `probleme`
--
ALTER TABLE `probleme`
  MODIFY `id_probleme` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reparateur`
--
ALTER TABLE `reparateur`
  MODIFY `id_reparateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
