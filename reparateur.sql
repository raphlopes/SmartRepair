-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 07 mars 2019 à 10:26
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
-- Base de données :  `reparateur`
--

-- --------------------------------------------------------

--
-- Structure de la table `boutiques`
--

CREATE TABLE `boutiques` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `type` varchar(20) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `boutiques`
--

INSERT INTO `boutiques` (`id`, `name`, `address`, `type`, `lat`, `lng`) VALUES
(1, 'La Boutique De Reparation\r\n', '59 Rue Lamarck, 75018 Paris', 'reparateur', 48.889191, 2.342422),
(2, 'Street Phone', '2 Rue Lecourbe, 75015 Paris', 'reparateur', 48.845001, 2.310430),
(3, 'iPhone Casse', '136 Rue Montmartre, 75002 Paris', 'reparateur', 48.868500, 2.343570),
(4, 'Mister Phony', '75 Rue de Turenne, 75003 Paris', 'reparateur', 48.859798, 2.364440),
(5, 'pathe beaugrenelle', '12 Rue Linois, 75015 Paris, France', 'reparateur', 48.848553, 2.282243),
(6, 'Raphael ', '52 Avenue Vergniaud, 94100 Saint-Maur-des-FossÃ©s, France', 'reparateur', 48.792576, 2.474554),
(7, 'mignot', '43 Rue de Grenelle, 75007 Paris, France', 'reparateur', 48.854321, 2.326158),
(8, 'Ethan', '175 Avenue de Flandre, 75019 Paris, France', 'reparateur', 48.894657, 2.381637),
(9, 'Ethan', '4 Avenue Jean JaurÃ¨s, 75019 Paris, France', 'reparateur', 48.882690, 2.370519),
(10, 'Ethan', '4 Avenue Jean JaurÃ¨s, 78440 Gargenville, France', 'reparateur', 48.975292, 1.806235);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `boutiques`
--
ALTER TABLE `boutiques`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `boutiques`
--
ALTER TABLE `boutiques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
