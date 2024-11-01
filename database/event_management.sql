-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 01 nov. 2024 à 12:07
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `event_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `employees`
--

CREATE TABLE `employees` (
  `employeeID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `family_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employees`
--

INSERT INTO `employees` (`employeeID`, `name`, `family_name`, `email`, `password`) VALUES
(3, 'Jean', 'Dupont', 'jean.dupont@esportify.com', '$2y$10$D4JIAUkB0y5Xd90PorK/deSfr2mvbC.scB8fIF/TaHA4tqh/Jy1gK'),
(4, 'Claire', 'Martin', 'claire.martin@esportify.com', '$2y$10$vKfDtAypl77o7h/P9XmqCOLsLOPsTYsoberQ2B0zWxHBNlI/x0696'),
(5, 'Thomas', 'Lefevre', 'thomas.lefevre@esportify.com', '$2y$10$vVI2fm7ou3L2DqfDlZPFPOaRoHFrM5l3PAEJNASUCupmfqPQaQQGW'),
(6, 'Sophie', 'Dubois', 'sophie.dubois@esportify.com', '$2y$10$ZCMrTyIODcGML1Hngur6BeEGx4tWJEl/9gIOWRqcSKhcsBesmwfd2'),
(7, 'Lucas', 'Moreau', 'lucas.moreau@esportify.com', '$2y$10$Da0qhojv9bC8falfRUr2pejtfa/W7tsWZuYgBuTO3CLxqLuzE56n2'),
(8, 'Emma', 'Gauthier', 'emma.gauthier@esportify.com', '$2y$10$0HQa70oS2IkJYFEAFXPp7u/ymYOmOzwd8iFkvGslgUeBOQH9opKOq');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `eventID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `nb_of_participant` int(11) DEFAULT 0,
  `isVisible` tinyint(1) DEFAULT 0,
  `start_date` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `creatorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`eventID`, `name`, `description`, `nb_of_participant`, `isVisible`, `start_date`, `duration_minutes`, `image_path`, `creatorID`) VALUES
(1, 'projetalpha', 'venez, on vas s\'amuser', 12, 1, '2024-11-06 00:00:00', 120, 'uploads/event_671bb65a3a9f47.71316970.png', 2),
(2, 'bonjour', 'j\'ai besoin de personne pour jouer à minecraft', 5, 1, '2024-11-30 15:00:00', 300, 'uploads/event_6720b1021502e4.02353174.png', 1),
(6, 'dennis', 'event sur dennis.io', 10, 1, '2024-11-09 19:45:00', 45, 'uploads/event_67228af6a2eaf4.92081886.png', 4),
(7, 'Esport Event 1', 'Description de l\'événement 1', 60, 1, '2024-11-01 00:00:00', 91, 'uploads/place_holder.png', 5),
(8, 'Esport Event 2', 'Description de l\'événement 2', 94, 1, '2024-11-02 00:00:00', 144, 'uploads/place_holder.png', 6),
(9, 'Esport Event 3', 'Description de l\'événement 3', 38, 1, '2024-11-03 00:00:00', 208, 'uploads/place_holder.png', 7),
(10, 'Esport Event 4', 'Description de l\'événement 4', 82, 1, '2024-11-04 00:00:00', 48, 'uploads/place_holder.png', 8),
(11, 'Esport Event 5', 'Description de l\'événement 5', 7, 1, '2024-11-05 00:00:00', 33, 'uploads/place_holder.png', 9),
(12, 'Esport Event 6', 'Description de l\'événement 6', 91, 1, '2024-11-06 00:00:00', 116, 'uploads/place_holder.png', 10),
(13, 'Esport Event 7', 'Description de l\'événement 7', 69, 1, '2024-11-07 00:00:00', 206, 'uploads/place_holder.png', 11),
(14, 'Esport Event 8', 'Description de l\'événement 8', 86, 1, '2024-11-08 00:00:00', 87, 'uploads/place_holder.png', 12),
(15, 'Esport Event 9', 'Description de l\'événement 9', 3, 1, '2024-11-09 00:00:00', 64, 'uploads/place_holder.png', 13),
(16, 'Esport Event 10', 'Description de l\'événement 10', 88, 1, '2024-11-10 00:00:00', 177, 'uploads/place_holder.png', 14),
(17, 'Esport Event 11', 'Description de l\'événement 11', 45, 1, '2024-11-11 00:00:00', 171, 'uploads/place_holder.png', 15),
(18, 'Esport Event 12', 'Description de l\'événement 12', 60, 0, '2024-11-12 00:00:00', 138, 'uploads/place_holder.png', 16),
(19, 'Esport Event 13', 'Description de l\'événement 13', 25, 1, '2024-11-13 00:00:00', 103, 'uploads/place_holder.png', 17),
(20, 'Esport Event 14', 'Description de l\'événement 14', 32, 1, '2024-11-14 00:00:00', 93, 'uploads/place_holder.png', 18),
(21, 'Esport Event 15', 'Description de l\'événement 15', 82, 1, '2024-11-15 00:00:00', 35, 'uploads/place_holder.png', 19),
(22, 'Esport Event 16', 'Description de l\'événement 16', 71, 1, '2024-11-16 00:00:00', 104, 'uploads/place_holder.png', 20),
(23, 'Esport Event 17', 'Description de l\'événement 17', 96, 1, '2024-11-17 00:00:00', 126, 'uploads/place_holder.png', 21),
(24, 'Esport Event 18', 'Description de l\'événement 18', 82, 1, '2024-11-18 00:00:00', 112, 'uploads/place_holder.png', 22),
(25, 'Esport Event 19', 'Description de l\'événement 19', 85, 0, '2024-11-19 00:00:00', 183, 'uploads/place_holder.png', 23),
(26, 'Esport Event 20', 'Description de l\'événement 20', 73, 1, '2024-11-20 00:00:00', 45, 'uploads/place_holder.png', 24),
(27, 'Esport Event 21', 'Description de l\'événement 21', 25, 1, '2024-11-01 00:00:00', 203, 'uploads/place_holder.png', 5),
(28, 'Esport Event 22', 'Description de l\'événement 22', 8, 1, '2024-11-02 00:00:00', 121, 'uploads/place_holder.png', 6),
(29, 'Esport Event 23', 'Description de l\'événement 23', 30, 1, '2024-11-03 00:00:00', 203, 'uploads/place_holder.png', 7),
(30, 'Esport Event 24', 'Description de l\'événement 24', 93, 1, '2024-11-04 00:00:00', 160, 'uploads/place_holder.png', 8),
(31, 'Esport Event 25', 'Description de l\'événement 25', 87, 1, '2024-11-05 00:00:00', 56, 'uploads/place_holder.png', 9),
(32, 'Esport Event 26', 'Description de l\'événement 26', 15, 1, '2024-11-06 00:00:00', 81, 'uploads/place_holder.png', 10),
(33, 'Esport Event 27', 'Description de l\'événement 27', 99, 1, '2024-11-07 00:00:00', 42, 'uploads/place_holder.png', 11),
(34, 'Esport Event 28', 'Description de l\'événement 28', 40, 1, '2024-11-08 00:00:00', 170, 'uploads/place_holder.png', 12),
(35, 'Esport Event 29', 'Description de l\'événement 29', 71, 1, '2024-11-09 00:00:00', 66, 'uploads/place_holder.png', 13),
(36, 'Esport Event 30', 'Description de l\'événement 30', 89, 1, '2024-11-10 00:00:00', 174, 'uploads/place_holder.png', 14),
(37, 'Esport Event 31', 'Description de l\'événement 31', 37, 1, '2024-11-11 00:00:00', 108, 'uploads/place_holder.png', 15),
(38, 'Esport Event 32', 'Description de l\'événement 32', 7, 0, '2024-11-12 00:00:00', 35, 'uploads/place_holder.png', 16),
(39, 'Esport Event 33', 'Description de l\'événement 33', 97, 1, '2024-11-13 00:00:00', 159, 'uploads/place_holder.png', 17),
(40, 'Esport Event 34', 'Description de l\'événement 34', 72, 1, '2024-11-14 00:00:00', 101, 'uploads/place_holder.png', 18),
(41, 'Esport Event 35', 'Description de l\'événement 35', 86, 1, '2024-11-15 00:00:00', 41, 'uploads/place_holder.png', 19),
(42, 'Esport Event 36', 'Description de l\'événement 36', 77, 1, '2024-11-16 00:00:00', 146, 'uploads/place_holder.png', 20),
(43, 'Esport Event 37', 'Description de l\'événement 37', 94, 1, '2024-11-17 00:00:00', 161, 'uploads/place_holder.png', 21),
(44, 'Esport Event 38', 'Description de l\'événement 38', 85, 1, '2024-11-18 00:00:00', 35, 'uploads/place_holder.png', 22),
(45, 'Esport Event 39', 'Description de l\'événement 39', 62, 1, '2024-11-19 00:00:00', 206, 'uploads/place_holder.png', 23),
(46, 'Esport Event 40', 'Description de l\'événement 40', 7, 1, '2024-11-20 00:00:00', 97, 'uploads/place_holder.png', 24);

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

CREATE TABLE `favorites` (
  `favoriteID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `eventID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favorites`
--

INSERT INTO `favorites` (`favoriteID`, `userID`, `eventID`) VALUES
(9, 1, 2),
(14, 4, 1),
(12, 4, 6),
(15, 5, 1),
(16, 6, 1),
(17, 7, 1),
(18, 8, 1),
(19, 9, 1),
(20, 10, 1),
(21, 11, 1),
(22, 12, 1),
(23, 13, 1),
(24, 14, 1),
(25, 15, 1),
(26, 16, 1),
(27, 17, 1),
(28, 18, 1),
(29, 19, 1),
(30, 20, 1),
(31, 21, 1),
(32, 22, 1),
(33, 23, 1),
(34, 24, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password`) VALUES
(1, 'Rokylevi', 'Rokylevi00@gmail.com', '$2y$10$gWWPNpgg.NfAMflLyylr3.8s0m/IPUaAb2XKfDPtsmD2cPymUrfDq'),
(2, 'MrPichon', 'cachouPichon-18@wanadoo.fr', '$2y$10$B9oPP3FUh/rEx1HflGn3ReG0U44MawERKk/IoCReX/efFXbYezg2.'),
(4, 'xxdestroynoobxx', 'lucasfoingeau@gmail.com', '$2y$10$FMRmJWQFT8BAdVHFatgxDO8twGmbsLR5hXTSm0PGmLof8XOrsaUY6'),
(5, 'user1', 'user1@gmail.com', '$2y$10$QcRm22bs.2NYDgvhs99Fz.VUPDVyrUfK12hqmH1uc.k37Fp/dly36'),
(6, 'user2', 'user2@gmail.com', '$2y$10$Vl2Mi0V5x3XOX4Up.kdihO9QwyRRqvd0oTS3cc/24xYiGdYxvRx0.'),
(7, 'user3', 'user3@gmail.com', '$2y$10$H81t2cz5DouGC84nci8Fxe/K75.cVUbNcw0gOP/SkSgntOUzGDYXa'),
(8, 'user4', 'user4@gmail.com', '$2y$10$tQO6Zf09M6cebAgKdKsqKe91YfSpnrxX9jN832cvLOauPr.Fu7HzC'),
(9, 'user5', 'user5@gmail.com', '$2y$10$ykJo4edthYiRXaUZ0LjHiuuf7q3x77dHdLqidlL4wWKTHO.QJdau6'),
(10, 'user6', 'user6@gmail.com', '$2y$10$JR8kzPMpIT/ozUg9MJxh8uIrT1YnMAhu5xjmEN1/P3k9QlP4DH4jO'),
(11, 'user7', 'user7@gmail.com', '$2y$10$v93s3DUvChk2DWYceC.Yv.NaqGwv4VrBZ.FRZ34oLemM2mzwLRyqC'),
(12, 'user8', 'user8@gmail.com', '$2y$10$dtrA9lRwux2ogQlRewjQoOOqgvcms12yTf81kYTdbksBfi8lvYjMW'),
(13, 'user9', 'user9@gmail.com', '$2y$10$SbEUclaFUjmzQHejoDBANetuiWPuZPOfBxljPnqRXlnhwrT5/isxy'),
(14, 'user10', 'user10@gmail.com', '$2y$10$f3LnJSIf.AJDolOUvwW4Tu1kQ97xJISOThUwP1kzJ9JUyR5QCNsku'),
(15, 'user11', 'user11@gmail.com', '$2y$10$nFSvpEw5W3Vcf4m66sHcJOSvlbAYEL.WuCcl9rqQI0e46G3u5kl5O'),
(16, 'user12', 'user12@gmail.com', '$2y$10$3yBYi7M6s0hVrTpGQW2SA.WcaObYNc3fLqM94ZrjQzxlmOW6JvMIO'),
(17, 'user13', 'user13@gmail.com', '$2y$10$8c.2FmuJM/dMBd5OIC2HzOnYUOwBiJkONhjd9N/jpUmhZ9IJt.pPm'),
(18, 'user14', 'user14@gmail.com', '$2y$10$3bLo/JLiFqd3zfKEYyBC6.USZKmz.tM1cg.Ly.IzjbGH4If..wjl2'),
(19, 'user15', 'user15@gmail.com', '$2y$10$OuXaeabUvQ70hsGymDhMQexoNDeuZE/4uh//ctTYM9Dxzc0HSCxHu'),
(20, 'user16', 'user16@gmail.com', '$2y$10$oRLHC3NSx/K6/smfz7dhGel9qb3IOmPC6wZOyjCOpjNi7Fa9SfqEu'),
(21, 'user17', 'user17@gmail.com', '$2y$10$EIr2S5G21HBBSObltippueHC84QJQMXcSQEzPwHkIfXB3BuH7LHoe'),
(22, 'user18', 'user18@gmail.com', '$2y$10$.DomEUS5I1VBdGWM7akAq.jwtHCLfwMt9b0Y6q.UZDRSG8KhFj2WG'),
(23, 'user19', 'user19@gmail.com', '$2y$10$v6FcTpr/hZeepBkbZwN6ieSmpc9gP/7t4P1TazfnRFhtXdW1f1Kpe'),
(24, 'user20', 'user20@gmail.com', '$2y$10$fQAItlx5Skng6UaQX4ct9OHm1XtQGsYYzf/Tm9/9BeaC1jPUYVGMS');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `creatorID` (`creatorID`);

--
-- Index pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favoriteID`),
  ADD UNIQUE KEY `userID` (`userID`,`eventID`),
  ADD KEY `eventID` (`eventID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `employees`
--
ALTER TABLE `employees`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favoriteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`creatorID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
