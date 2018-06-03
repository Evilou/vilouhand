SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

CREATE TABLE IF NOT EXISTS `actualites` (
  `actualite_ID` int(6) NOT NULL AUTO_INCREMENT,
  `actualite_type` int(3) NOT NULL,
  `actualite_date` int(11) NOT NULL,
  `actualite_titre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `actualite_contenu` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`actualite_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `c_ID` int(2) NOT NULL AUTO_INCREMENT,
  `c_nom` varchar(255) NOT NULL,
  `c_ref` varchar(60) NOT NULL,
  PRIMARY KEY (`c_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`c_ID`, `c_nom`, `c_ref`) VALUES
(1, '-13G', '-13G'),
(2, '-15G', '-15G'),
(3, 'SF', 'SF'),
(4, 'SG', 'SG'),
(5, '-18F', '-18F'),
(6, '-18G', '-18G');

-- --------------------------------------------------------

--
-- Structure de la table `clubs`
--

CREATE TABLE IF NOT EXISTS `clubs` (
  `club_ID` int(6) NOT NULL AUTO_INCREMENT,
  `club_nom` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `club_logo` int(6) DEFAULT '1',
  `club_court` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `c_ville` varchar(256) DEFAULT '',
  PRIMARY KEY (`club_ID`),
  KEY `club_logo` (`club_logo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Contenu de la table `clubs`
--
INSERT INTO `clubs` (`club_ID`, `club_nom`, `club_logo`, `club_court`, `c_ville`) VALUES
(1, 'Tarbes Pyrénées HB', 3, 'TPH', ''),
(4, 'HBC Albi', 6, 'Albi', ''),
(25, 'AL Valence d''Agen HB', 25, 'Valence d''Agen', ''),
(27, 'E.T Balma HB', 9, 'Balma', ''),
(28, 'C.I.C. Escalquens Labege 31', 11, 'Labege', ''),
(30, 'Pays des Nestes HB', 26, 'PNH', ''),
(31, 'Stade Cadurcien', 28, 'Castres', ''),
(32, 'HBC Pamiers', 36, 'Pamiers', ''),
(33, 'HBC Muret', 34, 'Muret', ''),
(34, 'Tournefeuille HB', 29, 'Tournefeuille', ''),
(35, 'HBC Espalion', 31, 'Espalion', ''),
(36, 'HBC Lombez Samatan', 18, 'Lombez Samatan', ''),
(37, 'Coteaux de Gascogne HB', 20, 'CGHB', ''),
(38, 'Stade Bagnérais HB', 21, 'Bagnères', ''),
(40, 'ASC Aureilhan HB', 27, 'ASCA', ''),
(113, 'HBC Lourdes', 4, 'HBCL', ''),
(116, 'Saint Gaudens HB', 43, 'Sain Gaudens', ''),
(117, 'Soues HB', 42, 'Soues', ''),
(118, 'Pyrene HB', 14, 'Pyrene HB', ''),
(119, 'US Rabastens HB', 1, 'USR', ''),
(120, 'Handball du Pays de Trie', 1, 'HB Trie', ''),
(123, 'Condom HBC', 40, 'Condom', ''),
(125, 'HBC L''Isle Jourdain', 50, 'L''Isle Jourdain', ''),
(126, 'Lions Auch Handball', 19, 'Lions Auch', ''),
(127, 'Handball du Pays de Trie', 49, 'Trie', ''),
(128, 'HBC Massylvain', 1, 'Masseube', ''),
(129, 'Saint Girons HBC', 48, 'Saint Girons', ''),
(130, 'UA Vicoise HB', 1, 'Vic Fezensac', ''),
(131, 'Pouyastruc Handball', 1, 'PH', '');

-- --------------------------------------------------------

--
-- Structure de la table `competitions`
--

CREATE TABLE IF NOT EXISTS `competitions` (
  `c_ID` int(6) NOT NULL AUTO_INCREMENT,
  `c_saison_ID` int(3) NOT NULL,
  `c_nom` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `c_url_ffhb` varchar(2048) CHARACTER SET utf8 NOT NULL,
  `c_categorie_ID` int(2) NOT NULL,
  `c_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`c_ID`),
  KEY `saison` (`c_saison_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------
--
-- Structure de la table `engagements`
--
CREATE TABLE IF NOT EXISTS `engagements` (
  `e_ID` int(6) NOT NULL AUTO_INCREMENT,
  `e_equipe` int(6) NOT NULL,
  `e_competition` int(6) NOT NULL,
  PRIMARY KEY (`e_ID`),
  KEY `engagement_equipe` (`e_equipe`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Structure de la table `entrainements`
--

CREATE TABLE IF NOT EXISTS `entrainements` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `equipe_ID` int(6) NOT NULL,
  `salle_ID` int(6) NOT NULL,
  `horaire` varchar(1024) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE IF NOT EXISTS `equipes` (
  `equipe_ID` int(6) NOT NULL AUTO_INCREMENT,
  `equipe_nom` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `equipe_categorie` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `equipe_club` int(6) NOT NULL,
  `equipe_photo` int(6) DEFAULT NULL,
  PRIMARY KEY (`equipe_ID`),
  KEY `equipe_club` (`equipe_club`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- Contenu de la table `equipes`
--

INSERT INTO `equipes` (`equipe_ID`, `equipe_nom`, `equipe_categorie`, `equipe_club`, `equipe_photo`) VALUES
(8, 'Tarbes Pyrénées HB 1', 'SG', 1, NULL),
(9, 'Tarbes Pyrénées HB 2', 'SG', 1, NULL),
(11, 'Tarbes Pyrénées HB', '-15G', 1, NULL),
(12, 'HBC Albi', 'SG', 4, NULL),
(13, 'AL Valence d''Agen HB', 'SG', 25, NULL),
(14, 'E.T Balma HB 2', 'SG', 27, NULL),
(15, 'Tarbes Pyrénées HB', '-13G', 1, NULL),
(16, 'C.I.C. Escalquens Labege 31', 'SG', 28, NULL),
(17, 'Pays des Nestes HB', 'SG', 30, NULL),
(18, 'Stade Cadurcien HB', 'SG', 31, NULL),
(19, 'HBC Pamiers', 'SG', 32, NULL),
(20, 'HBC Muret 1', 'SG', 33, NULL),
(21, 'Tournefeuille HB 2', 'SG', 34, NULL),
(23, 'HBC Espalion 2', 'SG', 35, NULL),
(24, 'HBC Lombez Samatan', 'SG', 36, NULL),
(26, 'Coteaux de Gascogne HB', 'SG', 37, NULL),
(27, 'Stade Bagnérais HB', 'SG', 38, NULL),
(31, 'Stade Bagnérais HB 1<br>', '-13G', 38, NULL),
(32, 'ASC Aureilhan', 'SG', 40, NULL),
(37, 'Tarbes Pyrénées HB', 'SF', 1, NULL),
(38, 'ASC Aureilhan', 'SF', 40, NULL),
(39, 'HBC Lourdes 2', 'SG', 113, NULL),
(40, 'Stade Bagnérais HB', 'SF', 38, NULL),
(41, 'Soues HB', 'SF', 117, NULL),
(42, 'Saint Gaudens HB', 'SF', 116, NULL),
(43, 'Pays de Nestes HB 2', '-15G', 30, NULL),
(44, 'Stade Bagnérais HB', '-15G', 38, NULL),
(45, 'HBC Lourdes', '-15G', 113, NULL),
(46, 'Pyrene HB', '-15G', 118, NULL),
(47, 'Soues HB', '-15G', 117, NULL),
(48, 'Pays de Nestes HB 1', '-13G', 30, NULL),
(49, 'US Rabastens HB', '-13G', 119, NULL),
(50, 'Habndball du Pays de Trie', '-13G', 120, NULL),
(51, 'Coteaux de Gascogne HB', '-15G', 37, NULL),
(52, 'Condom HBC', '-15G', 123, NULL),
(57, 'Pyrene HB', '-13G', 118, NULL),
(58, 'Stade Bagnérais HB 2', '-13G', 38, NULL),
(59, 'HBC Trie', '-13G', 127, NULL),
(60, 'Lions Auch Handball', '-13G', 126, NULL),
(61, 'HBC L''Isle Jourdain', '-13G', 125, NULL),
(62, 'Soues HB', 'SG', 117, NULL),
(63, 'HBC Trie', 'SG', 127, NULL),
(64, 'HBC Massylvain', 'SG', 128, NULL),
(65, 'Saint Girons HBC', 'SG', 129, NULL),
(66, 'HBC Lourdes', 'SF', 113, NULL),
(67, 'UA Vicoise HB', 'SG', 130, NULL),
(68, 'HBC Massylvain 1', 'SF', 128, NULL),
(69, 'Condom HBC 1', 'SF', 123, NULL),
(70, 'Coteaux de Gascogne HB', 'SF', 37, NULL),
(71, 'Pouyastruc Handball', 'SF', 131, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `image_ID` int(6) NOT NULL AUTO_INCREMENT,
  `image_type` int(3) NOT NULL,
  `image_nom` varchar(30) NOT NULL,
  `image_fichier` varchar(250) NOT NULL,
  `image_statut` int(2) DEFAULT '0',
  PRIMARY KEY (`image_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `images`
--

INSERT INTO `images` (`image_ID`, `image_type`, `image_nom`, `image_fichier`, `image_statut`) VALUES
(1, 1, 'pas de logo', '6f7d8a06c1e5dd440be37d17e716cd5a.png', 0),
(3, 1, 'Tarbes', 'f6a0a3063c480a76bbf0d4063b654615.jpg', 0),
(4, 1, 'Lourdes', '43586f030c8d251bc14ad4db49e8afc6.jpg', 0),
(5, 1, 'Castres', '58e45472b741019de9a81e2442175b54.png', 0),
(6, 1, 'Albi', '73b9e99c5d8f78391708f68bfbdcfeb9.png', 0),
(7, 1, 'Souillac', '3ca6ababacef14d8041f54cc2ff4d752.png', 0),
(8, 1, 'Lombez', '13d1adf0bf2c2916f0170ff6e926bec5.jpg', 0),
(9, 1, 'Balma', 'dbf8af4202333b63e2c2a34aac348ac6.png', 0),
(11, 1, 'Labege', '2ac45413bd5837c8afc9ba6f8ddda282.png', 0),
(12, 1, 'villefranche de rouergue', '4984b87f4bbdf21f563fd542f3f1921e.jpg', 0),
(13, 1, 'isle jourdain', '5b1af77731e51ef9dbd1031702614414.jpg', 0),
(14, 1, 'juillan', 'fb2fb169bb64a902d8692c6441995afd.png', 0),
(15, 1, 'Millau', '489ac18a2cd0d73c1612e620c266a6b3.jpg', 0),
(16, 1, 'Bruguieres', 'c0fa0e8e3e0f23dd72d6bcf99450d3fa.png', 0),
(18, 1, 'Salvetat', '3be807ac106d297d34c18ea96625718c.jpg', 0),
(19, 1, 'Auch', 'ae2324f500f7a38de9383ab612ee81cb.jpg', 0),
(20, 1, 'coteaux de gascogne', '5bd47fefc80e1929f0dbbfec1b6fd92c.jpg', 0),
(21, 1, 'Stade Bagnerais', '86f7a3ca11961466cb782d583f2d97a7.jpg', 0),
(25, 1, 'valence', '184170bce388dfc4e58cdf19cc84ae7d.jpg', 0),
(26, 1, 'PNH', 'c51b5f1d5927010e471be00a0d258de9.jpg', 0),
(27, 1, 'asca', '76f025a52f26cae9dcf21426e00e3de3.jpg', 0),
(28, 1, 'cahors', '283de1c529ce7c35fb82a5f6fb6980fd.jpg', 0),
(29, 1, 'tournefeuille', 'e671158b359924cc440a6bb2620bf013.jpg', 0),
(30, 1, 'cghb', '8f386c0a03fcaad4bd2acc84c406fde3.jpg', 0),
(31, 1, 'espalion', '12796a7ee978d68acb887dee92716ca8.jpg', 0),
(32, 1, 'espalion', 'efde4e5da0e2846a7e4f9c8c3d39d663.jpg', 0),
(33, 1, 'lombez', 'bc8ee57a6decaa9e803860f975c2b7ed.jpg', 0),
(34, 1, 'muret', '791f0df9bf2d57a0aa6b69945b70cfd3.jpg', 0),
(35, 1, 'tournefeuille', 'e561dbee7212a070ea25034c857a948a.jpg', 0),
(36, 1, 'pamier', '11c788ad187321e16adb79f99ab7118e.jpg', 0),
(40, 1, 'CONDOM', '25e4003392e542528d96cc0ecf08ca2e.jpg', 0),
(41, 1, 'CONDOM', '4419fa9951d684c86a72e9a02d607e54.jpg', 0),
(42, 1, 'SOUES', '4e64545f545fe407c6b33cd9020a6f5e.jpg', 0),
(43, 1, 'ST GAUDENS', 'bddc5121b2a8afbdb2bb6095f1b75daf.jpg', 0),
(47, 1, 'saint giron', 'c77b9640f5222c27a186f1afa79df15b.jpg', 0),
(48, 1, 'saint giron', 'e4f6d78480cde21cf9e4f26102de394b.jpg', 0),
(49, 1, 'trie', '1b1cff7b20a1e3c47e7bd4e19bf586b3.jpg', 0),
(50, 1, 'lisle jourdain', '7e2f795aab1854bf66253797a04e7b30.png', 0);

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE IF NOT EXISTS `matchs` (
  `match_ID` int(6) NOT NULL AUTO_INCREMENT,
  `match_home` int(6) NOT NULL,
  `match_visitors` int(6) NOT NULL,
  `match_score_home` int(3) DEFAULT '0',
  `match_score_visitors` int(3) DEFAULT '0',
  PRIMARY KEY (`match_ID`),
  KEY `match_home` (`match_home`),
  KEY `match_visitors` (`match_visitors`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Doublure de structure pour la vue `matchs_complets`
--
CREATE TABLE IF NOT EXISTS `matchs_complets` (
`match_ID` int(6)
,`match_score_home` int(3)
,`match_score_visitors` int(3)
,`equipe1_ID` int(6)
,`equipe1_nom` text
,`club1_ID` int(6)
,`club1_nom` varchar(50)
,`club1_logo` varchar(250)
,`equipe2_ID` int(6)
,`equipe2_nom` text
,`club2_ID` int(6)
,`club2_nom` varchar(50)
,`club2_logo` varchar(250)
,`p_ID` int(6)
,`p_date` int(11)
,`p_salle_ID` int(6)
,`c_ID` int(6)
,`c_saison_ID` int(3)
,`c_nom` varchar(100)
,`c_url_ffhb` varchar(2048)
,`c_categorie_ID` int(2)
,`c_type` int(11)
);
-- --------------------------------------------------------

--
-- Structure de la table `planifications`
--

CREATE TABLE IF NOT EXISTS `planifications` (
  `p_ID` int(6) NOT NULL AUTO_INCREMENT,
  `p_competition_ID` int(6) NOT NULL,
  `p_match_ID` int(6) NOT NULL,
  `p_date` int(11) DEFAULT NULL,
  `p_salle_ID` int(6) DEFAULT NULL,
  PRIMARY KEY (`p_ID`),
  UNIQUE KEY `salle` (`p_salle_ID`),
  KEY `competition` (`p_competition_ID`),
  KEY `match` (`p_match_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Structure de la table `saisons`
--

CREATE TABLE IF NOT EXISTS `saisons` (
  `saison_ID` int(3) NOT NULL AUTO_INCREMENT,
  `saison_designation` varchar(40) NOT NULL,
  PRIMARY KEY (`saison_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `saisons`
--

INSERT INTO `saisons` (`saison_ID`, `saison_designation`) VALUES
(1, '2015-2016'),(2, '2016-2017');

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE IF NOT EXISTS `salles` (
  `salle_ID` int(6) NOT NULL,
  `salle_nom` varchar(50) NOT NULL,
  `salle_adresse` varchar(200) NOT NULL,
  `salle_club` int(6) DEFAULT NULL,
  `maps` varchar(2056) DEFAULT '',
  PRIMARY KEY (`salle_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `salles`
--

INSERT INTO `salles` (`salle_ID`, `salle_nom`, `salle_adresse`, `salle_club`, `maps`) VALUES
(0, 'Salle inconnue', '', NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_ID` varchar(32) NOT NULL,
  `session_user` varchar(10) NOT NULL,
  `session_time` int(11) NOT NULL,
  `session_creation_time` int(11) NOT NULL,
  `session_action` varchar(32) NOT NULL,
  `session_IP` varchar(15) NOT NULL,
  PRIMARY KEY (`session_ID`,`session_user`),
  KEY `session_user` (`session_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sponsors`
--

CREATE TABLE IF NOT EXISTS `sponsors` (
  `sponsor_ID` int(6) NOT NULL,
  `sponsor_nom` varchar(30) NOT NULL,
  `sponsor_url` varchar(250) NOT NULL,
  `sponsor_image` int(6) NOT NULL,
  PRIMARY KEY (`sponsor_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la vue `matchs_complets`
--
DROP TABLE IF EXISTS `matchs_complets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `matchs_complets` AS select `matchs`.`match_ID` AS `match_ID`,
	       `matchs`.`match_score_home` AS `match_score_home`,
	       `matchs`.`match_score_visitors` AS `match_score_visitors`,
	       `equipe1`.`equipe_ID` AS `equipe1_ID`,
	       `equipe1`.`equipe_nom` AS `equipe1_nom`,
	       `club1`.`club_ID` AS `club1_ID`,
	       `club1`.`club_nom` AS `club1_nom`,
	       `images1`.`image_fichier` AS `club1_logo`,
	       `equipe2`.`equipe_ID` AS `equipe2_ID`,
	       `equipe2`.`equipe_nom` AS `equipe2_nom`,
	       `club2`.`club_ID` AS `club2_ID`,
	       `club2`.`club_nom` AS `club2_nom`,
	       `images1`.`image_fichier` AS `club2_logo`,
	       `planifications`.`p_ID` AS `p_ID`,
	       `planifications`.`p_date` AS `p_date`,
	       `planifications`.`p_salle_ID` AS `p_salle_ID`,
	       `competitions`.`c_ID` AS `c_ID`,
	       `competitions`.`c_saison_ID` AS `c_saison_ID`,
	       `competitions`.`c_nom` AS `c_nom`,
	       `competitions`.`c_url_ffhb` AS `c_url_ffhb`,
	       `competitions`.`c_categorie_ID` AS `c_categorie_ID`,
	       `competitions`.`c_type` AS `c_type` 
	       FROM `matchs` join `equipes` `equipe1` on (`matchs`.`match_home` = `equipe1`.`equipe_ID`)
	                     join `clubs` `club1` on (`equipe1`.`equipe_club` = `club1`.`club_ID`)
	                     left join `images` `images1` on (`club1`.`club_logo` = `images1`.`image_ID`)
	                     join `equipes` `equipe2` on (`matchs`.`match_visitors` = `equipe2`.`equipe_ID`)
	                     join `clubs` `club2` on (`equipe2`.`equipe_club` = `club2`.`club_ID`)
	                     left join `images` `images2` on (`club2`.`club_logo` = `images2`.`image_ID`)
	                     left join `planifications` on (`planifications`.`p_match_ID` = `matchs`.`match_ID`)
	                     join `competitions` on (`competitions`.`c_ID` = `planifications`.`p_competition_ID`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `clubs`
--
ALTER TABLE `clubs`
  ADD CONSTRAINT `clubs_ibfk_1` FOREIGN KEY (`club_logo`) REFERENCES `images` (`image_ID`) ON DELETE SET NULL;

--
-- Contraintes pour la table `competitions`
--
ALTER TABLE `competitions`
  ADD CONSTRAINT `competitions_ibfk_1` FOREIGN KEY (`c_saison_ID`) REFERENCES `saisons` (`saison_ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `equipes_ibfk_1` FOREIGN KEY (`equipe_club`) REFERENCES `clubs` (`club_ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD CONSTRAINT `matchs_ibfk_3` FOREIGN KEY (`match_home`) REFERENCES `equipes` (`equipe_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `matchs_ibfk_4` FOREIGN KEY (`match_visitors`) REFERENCES `equipes` (`equipe_ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `planifications`
--
ALTER TABLE `planifications`
  ADD CONSTRAINT `planifications_ibfk_2` FOREIGN KEY (`p_match_ID`) REFERENCES `matchs` (`match_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `planifications_ibfk_3` FOREIGN KEY (`p_salle_ID`) REFERENCES `salles` (`salle_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `planifications_ibfk_4` FOREIGN KEY (`p_competition_ID`) REFERENCES `competitions` (`c_ID`) ON DELETE CASCADE;
