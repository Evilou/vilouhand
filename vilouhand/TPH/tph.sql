-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 16 Mars 2016 à 17:47
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `tph`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `actualites`
--

INSERT INTO `actualites` (`actualite_ID`, `actualite_type`, `actualite_date`, `actualite_titre`, `actualite_contenu`) VALUES
(1, 1, 1419204975, 'VICTOIRE!!! Le TPH s''impose 32-36 à Castre', 'Après une première mi-temps canon avec 1-7 au bout de 10 minutes et un score de 11-17 à la mi-temps, nos Tarbais se sont relâchés en 2ème avec des Castrais qui reviennent même à 2 points... La "fin de match a été contrôlée pour finir sur un score de'),
(2, 0, 1443610840, 'Recrutement Saison 2015-2016', 'Afin de renforcer ses &eacute;quipes et notamment notre &eacute;quipe R&eacute;gion Excellence, notre club, le Tarbes Pyr&eacute;n&eacute;e HandBall recrute des joueurs et des joueuses pour sa nouvelle saison. Si tu veux t''&eacute;panouir dans un club convivial viens avec nous pour jouer au Handball, que tu sois aguerri ou d&eacute;butant, une place t''attend au sein de nos &eacute;quipes... Pour nous contacter : Section contact du notre site.'),
(3, 1, 1419204975, 'Victoire des Seniors Région 32-28 face à Auch...', 'Le TPH termine donc l''année 2014 invaincu avec 9 victoires en autant de matchs... Reprise le 10 janvier avec LE CHOC face à Albi!!! Vive le TPH'),
(4, 1, 1450005568, 'Belle victoire des moins de 15 à Condom', '<p>Aujourd''hui, très belle victoire des moins de 15 à l’extérieur (Condom), une équipe très motivée et agréable à regarder jouer.\r\n</p>\r\n<br/>\r\n<p>\r\nBravo à Jérôme et à toute son équipe.\r\n30 à 36, le boulot est fait et avec la manière.\r\n</p>');

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
(4, 'SG', 'SG');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `competitions`
--

INSERT INTO `competitions` (`c_ID`, `c_saison_ID`, `c_nom`, `c_url_ffhb`, `c_categorie_ID`, `c_type`) VALUES
(8, 1, 'Territorial Sénior Masculin Phase 2', 'http://www.ff-handball.org/competitions/championnats-departementaux/65-comite-des-hautes-pyrenees.html?tx_obladygesthand_pi1%5Bsaison_id%5D=11&tx_obladygesthand_pi1%5Bcompetition_id%5D=2084&tx_obladygesthand_pi1%5Bphase_id%5D=2292&tx_obladygesthand_pi1%5Bgroupe_id%5D=3128&tx_obladygesthand_pi1%5Bmode%5D=single_phase&cHash=4e6209074043d00b3ddc969617fbd6d1', 4, 0),
(9, 1, 'Région Excellence Masculin ', 'http://www.ff-handball.org/competitions/championnats-regionaux/midi-pyrenees.html?tx_obladygesthand_pi1%5Bcompetition_id%5D=1284&cHash=59177141f6243987ae3f14ee1a2e3482', 4, 0),
(10, 1, 'Territorial Sénior Féminin', 'http://www.ff-handball.org/competitions/championnats-departementaux/32-comite-du-gers.html?tx_obladygesthand_pi1%5Bsaison_id%5D=11&tx_obladygesthand_pi1%5Bcompetition_id%5D=2033&tx_obladygesthand_pi1%5Bphase_id%5D=2220&tx_obladygesthand_pi1%5Bgroupe_id%5D=2915&tx_obladygesthand_pi1%5Bmode%5D=single_phase&cHash=6b2886edf7bfb6696cd0e36fe87dbb34', 3, 0),
(14, 1, 'Région Honneur -15 Garçons', 'http://www.ff-handball.org/competitions/championnats-regionaux/midi-pyrenees.html?tx_obladygesthand_pi1%5Bsaison_id%5D=11&tx_obladygesthand_pi1%5Bcompetition_id%5D=1494&tx_obladygesthand_pi1%5Bphase_id%5D=3511&tx_obladygesthand_pi1%5Bgroupe_id%5D=7222&tx_obladygesthand_pi1%5Bmode%5D=single_phase&cHash=771144ef661293cfe25e44d04680a790', 2, 0),
(18, 1, 'Coupe Metton Féminine ', '', 3, 1),
(19, 1, 'Coupe Metton Masculine', '', 4, 1),
(20, 1, 'Territorial -13 Mixtes Phase 2 ', '', 1, 0),
(21, 1, 'Championnat Territorial SF', '', 3, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=147 ;

--
-- Contenu de la table `engagements`
--

INSERT INTO `engagements` (`e_ID`, `e_equipe`, `e_competition`) VALUES
(19, 8, 1),
(27, 12, 1),
(28, 14, 1),
(29, 13, 1),
(30, 16, 1),
(31, 17, 1),
(32, 18, 1),
(33, 19, 1),
(34, 20, 1),
(35, 21, 1),
(36, 23, 1),
(37, 24, 1),
(38, 9, 2),
(39, 10, 4),
(40, 25, 4),
(41, 26, 4),
(42, 27, 4),
(43, 28, 4),
(44, 15, 5),
(45, 30, 5),
(46, 29, 5),
(47, 31, 5),
(48, 32, 5),
(49, 9, 6),
(50, 34, 6),
(51, 33, 6),
(53, 36, 6),
(54, 35, 6),
(70, 64, 8),
(71, 63, 8),
(72, 62, 8),
(73, 65, 8),
(74, 39, 8),
(75, 24, 9),
(76, 23, 9),
(77, 21, 9),
(78, 20, 9),
(79, 19, 9),
(80, 18, 9),
(81, 17, 9),
(82, 16, 9),
(83, 14, 9),
(84, 13, 9),
(85, 12, 9),
(86, 8, 9),
(87, 38, 10),
(88, 40, 10),
(89, 42, 10),
(90, 41, 10),
(91, 50, 11),
(92, 57, 11),
(93, 60, 11),
(94, 58, 11),
(95, 51, 12),
(96, 47, 12),
(97, 52, 12),
(98, 44, 12),
(99, 43, 12),
(100, 11, 12),
(101, 61, 11),
(102, 37, 10),
(103, 52, 13),
(104, 47, 13),
(105, 44, 13),
(106, 51, 13),
(107, 11, 13),
(108, 43, 13),
(109, 11, 14),
(110, 51, 14),
(111, 44, 14),
(112, 47, 14),
(113, 52, 14),
(114, 43, 14),
(115, 11, 15),
(116, 52, 15),
(117, 43, 15),
(118, 47, 15),
(119, 44, 15),
(120, 51, 15),
(123, 37, 17),
(125, 67, 16),
(126, 66, 17),
(127, 9, 16),
(128, 31, 11),
(129, 9, 8),
(130, 66, 18),
(131, 67, 19),
(132, 9, 19),
(133, 61, 20),
(134, 60, 20),
(135, 58, 20),
(136, 57, 20),
(137, 48, 20),
(138, 59, 20),
(139, 31, 20),
(140, 37, 18),
(141, 37, 21),
(142, 41, 21),
(143, 70, 21),
(144, 69, 21),
(145, 71, 21),
(146, 68, 21);

-- --------------------------------------------------------

--
-- Structure de la table `entrainements`
--

CREATE TABLE IF NOT EXISTS `entrainements` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `equipe_ID` int(6) NOT NULL,
  `salle_ID` int(6) NOT NULL,
  `horaire` varchar(1024) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Contenu de la table `equipes`
--

INSERT INTO `equipes` (`equipe_ID`, `equipe_nom`, `equipe_categorie`, `equipe_club`, `equipe_photo`) VALUES
(8, 'Tarbes Pyrénées HB 1', 'SG', 1, 37),
(9, 'Tarbes Pyrénées HB 2', 'SG', 1, 38),
(11, 'Tarbes Pyrénées HB', '-15G', 1, 45),
(12, 'HBC Albi', 'SG', 4, NULL),
(13, 'AL Valence d''Agen HB', 'SG', 25, NULL),
(14, 'E.T Balma HB 2', 'SG', 27, NULL),
(15, 'Tarbes Pyrénées HB', '-13G', 1, 46),
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
(37, 'Tarbes Pyrénées HB', 'SF', 1, 51),
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
(66, '<span style="color: rgb(51, 51, 51); background-color: rgb(250, 250, 250);">HBC Lourdes</span>', 'SF', 113, NULL),
(67, 'UA Vicoise HB', 'SG', 130, NULL),
(68, '<span style="color: rgb(51, 51, 51); background-color: rgb(250, 250, 250);">HBC Massylvain 1</span>', 'SF', 128, NULL),
(69, '<span style="color: rgb(51, 51, 51); background-color: rgb(250, 250, 250);">Condom HBC 1</span>', 'SF', 123, NULL),
(70, '<span style="color: rgb(51, 51, 51); background-color: rgb(250, 250, 250);">Coteaux de Gascogne HB</span>', 'SF', 37, NULL),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

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
(37, 2, 'SG1', '116ce7f92a0237777755a87b2571aba4.jpg', 0),
(38, 2, 'SG2', '1a4d60a243052a19691b8cacc0bc8770.jpg', 0),
(40, 1, 'CONDOM', '25e4003392e542528d96cc0ecf08ca2e.jpg', 0),
(41, 1, 'CONDOM', '4419fa9951d684c86a72e9a02d607e54.jpg', 0),
(42, 1, 'SOUES', '4e64545f545fe407c6b33cd9020a6f5e.jpg', 0),
(43, 1, 'ST GAUDENS', 'bddc5121b2a8afbdb2bb6095f1b75daf.jpg', 0),
(44, 2, 'SF', '57bee025a453df3a7eb61a8e553dc1c1.jpg', 0),
(45, 2, '-15G', '9042b5f8c87146452f9a1c1ae09a2d3a.jpg', 0),
(46, 2, '-13G', '965f81c1f6ba41b9fb04e513b358eb99.jpg', 0),
(47, 1, 'saint giron', 'c77b9640f5222c27a186f1afa79df15b.jpg', 0),
(48, 1, 'saint giron', 'e4f6d78480cde21cf9e4f26102de394b.jpg', 0),
(49, 1, 'trie', '1b1cff7b20a1e3c47e7bd4e19bf586b3.jpg', 0),
(50, 1, 'lisle jourdain', '7e2f795aab1854bf66253797a04e7b30.png', 0),
(51, 2, 'SF_nouvelle', '3a6e374a0d997df81cab8f7bf1476d34.jpg', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=729 ;

--
-- Contenu de la table `matchs`
--

INSERT INTO `matchs` (`match_ID`, `match_home`, `match_visitors`, `match_score_home`, `match_score_visitors`) VALUES
(216, 27, 32, 0, 0),
(217, 32, 27, 0, 0),
(220, 26, 27, 0, 0),
(221, 27, 26, 0, 0),
(222, 26, 32, 0, 0),
(223, 32, 26, 0, 0),
(224, 24, 12, 0, 0),
(225, 12, 24, 0, 0),
(226, 23, 12, 0, 0),
(227, 12, 23, 0, 0),
(228, 23, 24, 0, 0),
(229, 24, 23, 0, 0),
(230, 21, 12, 0, 0),
(231, 12, 21, 0, 0),
(232, 21, 23, 0, 0),
(233, 23, 21, 0, 0),
(234, 21, 24, 0, 0),
(235, 24, 21, 0, 0),
(236, 18, 12, 0, 0),
(237, 12, 18, 0, 0),
(238, 18, 21, 0, 0),
(239, 21, 18, 0, 0),
(240, 18, 23, 0, 0),
(241, 23, 18, 0, 0),
(242, 18, 24, 0, 0),
(243, 24, 18, 0, 0),
(252, 20, 12, 0, 0),
(253, 12, 20, 0, 0),
(256, 20, 18, 0, 0),
(257, 18, 20, 0, 0),
(258, 20, 21, 0, 0),
(259, 21, 20, 0, 0),
(260, 20, 23, 0, 0),
(261, 23, 20, 0, 0),
(262, 20, 24, 0, 0),
(263, 24, 20, 0, 0),
(264, 17, 12, 0, 0),
(265, 12, 17, 0, 0),
(266, 17, 18, 0, 0),
(267, 18, 17, 0, 0),
(268, 17, 19, 0, 0),
(269, 19, 17, 0, 0),
(270, 17, 20, 0, 0),
(271, 20, 17, 0, 0),
(272, 17, 21, 0, 0),
(273, 21, 17, 0, 0),
(274, 17, 23, 0, 0),
(275, 23, 17, 0, 0),
(276, 17, 24, 0, 0),
(277, 24, 17, 0, 0),
(278, 16, 12, 0, 0),
(279, 12, 16, 0, 0),
(280, 16, 17, 0, 0),
(281, 17, 16, 0, 0),
(282, 16, 18, 0, 0),
(283, 18, 16, 0, 0),
(284, 16, 19, 0, 0),
(285, 19, 16, 0, 0),
(286, 16, 20, 0, 0),
(287, 20, 16, 0, 0),
(288, 16, 21, 0, 0),
(289, 21, 16, 0, 0),
(290, 16, 23, 0, 0),
(291, 23, 16, 0, 0),
(292, 16, 24, 0, 0),
(293, 24, 16, 0, 0),
(294, 14, 12, 0, 0),
(295, 12, 14, 0, 0),
(296, 14, 16, 0, 0),
(297, 16, 14, 0, 0),
(298, 14, 17, 0, 0),
(299, 17, 14, 0, 0),
(300, 14, 18, 0, 0),
(301, 18, 14, 0, 0),
(302, 14, 19, 0, 0),
(303, 19, 14, 0, 0),
(304, 14, 20, 0, 0),
(305, 20, 14, 0, 0),
(306, 14, 21, 0, 0),
(307, 21, 14, 0, 0),
(308, 14, 23, 0, 0),
(309, 23, 14, 0, 0),
(310, 14, 24, 0, 0),
(311, 24, 14, 0, 0),
(312, 13, 12, 0, 0),
(313, 12, 13, 0, 0),
(314, 13, 14, 0, 0),
(315, 14, 13, 0, 0),
(316, 13, 16, 0, 0),
(317, 16, 13, 0, 0),
(318, 13, 17, 0, 0),
(319, 17, 13, 0, 0),
(320, 13, 18, 0, 0),
(321, 18, 13, 0, 0),
(322, 13, 19, 0, 0),
(323, 19, 13, 0, 0),
(324, 13, 20, 0, 0),
(325, 20, 13, 0, 0),
(326, 13, 21, 0, 0),
(327, 21, 13, 0, 0),
(328, 13, 23, 0, 0),
(329, 23, 13, 0, 0),
(330, 13, 24, 0, 0),
(331, 24, 13, 0, 0),
(338, 39, 26, 0, 0),
(339, 26, 39, 0, 0),
(340, 39, 27, 0, 0),
(341, 27, 39, 0, 0),
(342, 39, 32, 0, 0),
(343, 32, 39, 0, 0),
(364, 19, 20, 0, 0),
(365, 20, 19, 0, 0),
(366, 19, 21, 0, 0),
(367, 21, 19, 0, 0),
(368, 19, 23, 0, 0),
(369, 23, 19, 0, 0),
(370, 19, 24, 0, 0),
(371, 24, 19, 0, 0),
(372, 18, 19, 0, 0),
(373, 19, 18, 0, 0),
(452, 12, 19, 0, 0),
(453, 19, 12, 0, 0),
(462, 8, 12, 29, 31),
(463, 12, 8, 0, 0),
(464, 8, 13, 0, 0),
(465, 13, 8, 37, 31),
(466, 8, 14, 0, 0),
(467, 14, 8, 28, 25),
(468, 8, 16, 34, 26),
(469, 16, 8, 0, 0),
(470, 8, 17, 0, 0),
(471, 17, 8, 26, 25),
(472, 8, 18, 0, 0),
(473, 18, 8, 31, 28),
(474, 8, 19, 0, 0),
(475, 19, 8, 0, 0),
(476, 8, 20, 0, 0),
(477, 20, 8, 0, 0),
(478, 8, 21, 0, 0),
(479, 21, 8, 30, 30),
(480, 8, 23, 0, 0),
(481, 23, 8, 27, 27),
(482, 8, 24, 25, 35),
(483, 24, 8, 0, 0),
(484, 40, 38, 0, 0),
(485, 38, 40, 0, 0),
(486, 42, 38, 0, 0),
(487, 38, 42, 0, 0),
(488, 42, 40, 0, 0),
(489, 40, 42, 0, 0),
(490, 41, 38, 0, 0),
(491, 38, 41, 0, 0),
(492, 41, 40, 0, 0),
(493, 40, 41, 0, 0),
(494, 41, 42, 0, 0),
(495, 42, 41, 0, 0),
(546, 37, 38, 11, 35),
(547, 38, 37, 25, 11),
(548, 37, 40, 16, 37),
(549, 40, 37, 45, 4),
(550, 37, 41, 10, 21),
(551, 41, 37, 42, 17),
(552, 37, 42, 14, 30),
(553, 42, 37, 39, 13),
(582, 51, 43, 0, 0),
(583, 43, 51, 0, 0),
(584, 44, 11, 0, 0),
(585, 11, 44, 0, 0),
(586, 44, 51, 0, 0),
(587, 51, 44, 0, 0),
(588, 47, 11, 0, 0),
(589, 11, 47, 0, 0),
(590, 47, 44, 0, 0),
(591, 44, 47, 0, 0),
(592, 47, 51, 0, 0),
(593, 51, 47, 0, 0),
(594, 52, 11, 30, 36),
(595, 11, 52, 0, 0),
(596, 52, 44, 0, 0),
(597, 44, 52, 0, 0),
(598, 52, 47, 0, 0),
(599, 47, 52, 0, 0),
(600, 52, 51, 0, 0),
(601, 51, 52, 0, 0),
(602, 43, 11, 0, 0),
(603, 11, 43, 28, 42),
(604, 43, 44, 0, 0),
(605, 44, 43, 0, 0),
(606, 43, 47, 0, 0),
(607, 47, 43, 0, 0),
(610, 43, 52, 0, 0),
(611, 52, 43, 0, 0),
(612, 11, 51, 0, 0),
(613, 51, 11, 0, 0),
(661, 9, 64, 0, 0),
(662, 64, 9, 0, 0),
(663, 9, 63, 0, 0),
(664, 63, 9, 0, 0),
(665, 9, 62, 0, 0),
(666, 62, 9, 0, 0),
(667, 9, 65, 0, 0),
(668, 65, 9, 0, 0),
(672, 67, 9, 0, 0),
(673, 60, 61, 0, 0),
(674, 61, 60, 0, 0),
(675, 58, 61, 0, 0),
(676, 61, 58, 0, 0),
(677, 58, 60, 0, 0),
(678, 60, 58, 0, 0),
(679, 57, 61, 0, 0),
(680, 61, 57, 0, 0),
(681, 57, 60, 0, 0),
(682, 60, 57, 0, 0),
(683, 57, 58, 0, 0),
(684, 58, 57, 0, 0),
(685, 48, 61, 0, 0),
(686, 61, 48, 0, 0),
(687, 48, 60, 0, 0),
(688, 60, 48, 0, 0),
(689, 48, 58, 0, 0),
(690, 58, 48, 0, 0),
(691, 48, 57, 0, 0),
(692, 57, 48, 0, 0),
(693, 59, 61, 0, 0),
(694, 61, 59, 0, 0),
(695, 59, 60, 0, 0),
(696, 60, 59, 0, 0),
(697, 59, 58, 0, 0),
(698, 58, 59, 0, 0),
(699, 59, 57, 0, 0),
(700, 57, 59, 0, 0),
(701, 59, 48, 0, 0),
(702, 48, 59, 0, 0),
(703, 31, 61, 0, 0),
(704, 61, 31, 0, 0),
(705, 31, 60, 0, 0),
(706, 60, 31, 0, 0),
(707, 31, 58, 0, 0),
(708, 58, 31, 0, 0),
(709, 31, 57, 0, 0),
(710, 57, 31, 0, 0),
(711, 31, 48, 0, 0),
(712, 48, 31, 0, 0),
(713, 31, 59, 0, 0),
(714, 59, 31, 0, 0),
(715, 37, 66, 0, 0),
(716, 66, 37, 0, 0),
(717, 9, 39, 0, 0),
(718, 39, 9, 0, 0),
(719, 37, 41, 0, 0),
(720, 41, 37, 0, 0),
(721, 37, 68, 0, 0),
(722, 68, 37, 0, 0),
(723, 37, 69, 0, 0),
(724, 69, 37, 0, 0),
(725, 37, 70, 0, 0),
(726, 70, 37, 0, 0),
(727, 37, 71, 0, 0),
(728, 71, 37, 0, 0);

-- --------------------------------------------------------

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=260 ;

--
-- Contenu de la table `planifications`
--

INSERT INTO `planifications` (`p_ID`, `p_competition_ID`, `p_match_ID`, `p_date`, `p_salle_ID`) VALUES
(1, 8, 216, NULL, NULL),
(2, 8, 217, NULL, NULL),
(3, 8, 220, NULL, NULL),
(4, 8, 221, NULL, NULL),
(5, 8, 222, NULL, NULL),
(6, 8, 223, NULL, NULL),
(7, 9, 224, NULL, NULL),
(8, 9, 225, NULL, NULL),
(9, 9, 226, NULL, NULL),
(10, 9, 227, NULL, NULL),
(11, 9, 228, NULL, NULL),
(12, 9, 229, NULL, NULL),
(13, 9, 230, NULL, NULL),
(14, 9, 231, NULL, NULL),
(15, 9, 232, NULL, NULL),
(16, 9, 233, NULL, NULL),
(17, 9, 234, NULL, NULL),
(18, 9, 235, NULL, NULL),
(19, 9, 236, NULL, NULL),
(20, 9, 237, NULL, NULL),
(21, 9, 238, NULL, NULL),
(22, 9, 239, NULL, NULL),
(23, 9, 240, NULL, NULL),
(24, 9, 241, NULL, NULL),
(25, 9, 242, NULL, NULL),
(26, 9, 243, NULL, NULL),
(27, 9, 252, NULL, NULL),
(28, 9, 253, NULL, NULL),
(29, 9, 256, NULL, NULL),
(30, 9, 257, NULL, NULL),
(31, 9, 258, NULL, NULL),
(32, 9, 259, NULL, NULL),
(33, 9, 260, NULL, NULL),
(34, 9, 261, NULL, NULL),
(35, 9, 262, NULL, NULL),
(36, 9, 263, NULL, NULL),
(37, 9, 264, NULL, NULL),
(38, 9, 265, NULL, NULL),
(39, 9, 266, NULL, NULL),
(40, 9, 267, NULL, NULL),
(41, 9, 268, NULL, NULL),
(42, 9, 269, NULL, NULL),
(43, 9, 270, NULL, NULL),
(44, 9, 271, NULL, NULL),
(45, 9, 272, NULL, NULL),
(46, 9, 273, NULL, NULL),
(47, 9, 274, NULL, NULL),
(48, 9, 275, NULL, NULL),
(49, 9, 276, NULL, NULL),
(50, 9, 277, NULL, NULL),
(51, 9, 278, NULL, NULL),
(52, 9, 279, NULL, NULL),
(53, 9, 280, NULL, NULL),
(54, 9, 281, NULL, NULL),
(55, 9, 282, NULL, NULL),
(56, 9, 283, NULL, NULL),
(57, 9, 284, NULL, NULL),
(58, 9, 285, NULL, NULL),
(59, 9, 286, NULL, NULL),
(60, 9, 287, NULL, NULL),
(61, 9, 288, NULL, NULL),
(62, 9, 289, NULL, NULL),
(63, 9, 290, NULL, NULL),
(64, 9, 291, NULL, NULL),
(65, 9, 292, NULL, NULL),
(66, 9, 293, NULL, NULL),
(67, 9, 294, NULL, NULL),
(68, 9, 295, NULL, NULL),
(69, 9, 296, NULL, NULL),
(70, 9, 297, NULL, NULL),
(71, 9, 298, NULL, NULL),
(72, 9, 299, NULL, NULL),
(73, 9, 300, NULL, NULL),
(74, 9, 301, NULL, NULL),
(75, 9, 302, NULL, NULL),
(76, 9, 303, NULL, NULL),
(77, 9, 304, NULL, NULL),
(78, 9, 305, NULL, NULL),
(79, 9, 306, NULL, NULL),
(80, 9, 307, NULL, NULL),
(81, 9, 308, NULL, NULL),
(82, 9, 309, NULL, NULL),
(83, 9, 310, NULL, NULL),
(84, 9, 311, NULL, NULL),
(85, 9, 312, NULL, NULL),
(86, 9, 313, NULL, NULL),
(87, 9, 314, NULL, NULL),
(88, 9, 315, NULL, NULL),
(89, 9, 316, NULL, NULL),
(90, 9, 317, NULL, NULL),
(91, 9, 318, NULL, NULL),
(92, 9, 319, NULL, NULL),
(93, 9, 320, NULL, NULL),
(94, 9, 321, NULL, NULL),
(95, 9, 322, NULL, NULL),
(96, 9, 323, NULL, NULL),
(97, 9, 324, NULL, NULL),
(98, 9, 325, NULL, NULL),
(99, 9, 326, NULL, NULL),
(100, 9, 327, NULL, NULL),
(101, 9, 328, NULL, NULL),
(102, 9, 329, NULL, NULL),
(103, 9, 330, NULL, NULL),
(104, 9, 331, NULL, NULL),
(105, 8, 338, NULL, NULL),
(106, 8, 339, NULL, NULL),
(107, 8, 340, NULL, NULL),
(108, 8, 341, NULL, NULL),
(109, 8, 342, NULL, NULL),
(110, 8, 343, NULL, NULL),
(111, 9, 364, NULL, NULL),
(112, 9, 365, NULL, NULL),
(113, 9, 366, NULL, NULL),
(114, 9, 367, NULL, NULL),
(115, 9, 368, NULL, NULL),
(116, 9, 369, NULL, NULL),
(117, 9, 370, NULL, NULL),
(118, 9, 371, NULL, NULL),
(119, 9, 372, NULL, NULL),
(120, 9, 373, NULL, NULL),
(121, 9, 452, NULL, NULL),
(122, 9, 453, NULL, NULL),
(123, 9, 462, 1450018800, NULL),
(124, 9, 463, NULL, NULL),
(125, 9, 464, 1460296800, NULL),
(126, 9, 465, 1448132400, NULL),
(127, 9, 466, 1459692000, NULL),
(128, 9, 467, 1447531200, NULL),
(129, 9, 468, 1443967200, NULL),
(130, 9, 469, 1454785200, NULL),
(131, 9, 470, 1455462000, NULL),
(132, 9, 471, 1444500000, NULL),
(133, 9, 472, 1460901600, NULL),
(134, 9, 473, 1449338400, NULL),
(135, 9, 474, 1453042800, NULL),
(136, 9, 475, NULL, NULL),
(137, 9, 476, 1463320800, NULL),
(138, 9, 477, 1452369600, NULL),
(139, 9, 478, 1454252400, NULL),
(140, 9, 479, 1442682000, NULL),
(141, 9, 480, 1457881200, NULL),
(142, 9, 481, 1445099400, NULL),
(143, 9, 482, 1446994800, NULL),
(144, 9, 483, NULL, NULL),
(145, 10, 484, NULL, NULL),
(146, 10, 485, NULL, NULL),
(147, 10, 486, NULL, NULL),
(148, 10, 487, NULL, NULL),
(149, 10, 488, NULL, NULL),
(150, 10, 489, NULL, NULL),
(151, 10, 490, NULL, NULL),
(152, 10, 491, NULL, NULL),
(153, 10, 492, NULL, NULL),
(154, 10, 493, NULL, NULL),
(155, 10, 494, NULL, NULL),
(156, 10, 495, NULL, NULL),
(157, 10, 546, 1444572000, NULL),
(158, 10, 547, 1448197200, NULL),
(159, 10, 548, 1450000800, NULL),
(160, 10, 549, 1448733600, NULL),
(161, 10, 550, 1445176800, NULL),
(162, 10, 551, 1449342000, NULL),
(163, 10, 552, 1447599600, NULL),
(164, 10, 553, 1443960000, NULL),
(165, 14, 582, NULL, NULL),
(166, 14, 583, NULL, NULL),
(167, 14, 584, NULL, NULL),
(168, 14, 585, 1452429000, NULL),
(169, 14, 586, NULL, NULL),
(170, 14, 587, NULL, NULL),
(171, 14, 588, NULL, NULL),
(172, 14, 589, 1449406800, NULL),
(173, 14, 590, NULL, NULL),
(174, 14, 591, NULL, NULL),
(175, 14, 592, NULL, NULL),
(176, 14, 593, NULL, NULL),
(177, 14, 594, 1449932400, NULL),
(178, 14, 595, 1459674000, NULL),
(179, 14, 596, NULL, NULL),
(180, 14, 597, NULL, NULL),
(181, 14, 598, NULL, NULL),
(182, 14, 599, NULL, NULL),
(183, 14, 600, NULL, NULL),
(184, 14, 601, NULL, NULL),
(185, 14, 602, NULL, NULL),
(186, 14, 603, 1448195400, NULL),
(187, 14, 604, NULL, NULL),
(188, 14, 605, NULL, NULL),
(189, 14, 606, NULL, NULL),
(190, 14, 607, NULL, NULL),
(191, 14, 610, NULL, NULL),
(192, 14, 611, NULL, NULL),
(193, 14, 612, 1453638600, NULL),
(194, 14, 613, 1454164200, NULL),
(195, 8, 661, NULL, NULL),
(196, 8, 662, NULL, NULL),
(197, 8, 663, NULL, NULL),
(198, 8, 664, 1452362400, NULL),
(199, 8, 665, NULL, NULL),
(200, 8, 666, NULL, NULL),
(201, 8, 667, NULL, NULL),
(202, 8, 668, NULL, NULL),
(203, 19, 672, NULL, NULL),
(204, 20, 673, NULL, NULL),
(205, 20, 674, NULL, NULL),
(206, 20, 675, NULL, NULL),
(207, 20, 676, NULL, NULL),
(208, 20, 677, NULL, NULL),
(209, 20, 678, NULL, NULL),
(210, 20, 679, NULL, NULL),
(211, 20, 680, NULL, NULL),
(212, 20, 681, NULL, NULL),
(213, 20, 682, NULL, NULL),
(214, 20, 683, NULL, NULL),
(215, 20, 684, NULL, NULL),
(216, 20, 685, NULL, NULL),
(217, 20, 686, NULL, NULL),
(218, 20, 687, NULL, NULL),
(219, 20, 688, NULL, NULL),
(220, 20, 689, NULL, NULL),
(221, 20, 690, NULL, NULL),
(222, 20, 691, NULL, NULL),
(223, 20, 692, NULL, NULL),
(224, 20, 693, NULL, NULL),
(225, 20, 694, NULL, NULL),
(226, 20, 695, NULL, NULL),
(227, 20, 696, NULL, NULL),
(228, 20, 697, NULL, NULL),
(229, 20, 698, NULL, NULL),
(230, 20, 699, NULL, NULL),
(231, 20, 700, NULL, NULL),
(232, 20, 701, NULL, NULL),
(233, 20, 702, NULL, NULL),
(234, 20, 703, NULL, NULL),
(235, 20, 704, NULL, NULL),
(236, 20, 705, NULL, NULL),
(237, 20, 706, NULL, NULL),
(238, 20, 707, NULL, NULL),
(239, 20, 708, NULL, NULL),
(240, 20, 709, NULL, NULL),
(241, 20, 710, NULL, NULL),
(242, 20, 711, NULL, NULL),
(243, 20, 712, NULL, NULL),
(244, 20, 713, NULL, NULL),
(245, 20, 714, NULL, NULL),
(246, 18, 715, NULL, NULL),
(247, 18, 716, NULL, NULL),
(248, 8, 717, NULL, NULL),
(249, 8, 718, 1454176800, NULL),
(250, 21, 719, 1454243400, NULL),
(251, 21, 720, NULL, NULL),
(252, 21, 721, NULL, NULL),
(253, 21, 722, NULL, NULL),
(254, 21, 723, NULL, NULL),
(255, 21, 724, NULL, NULL),
(256, 21, 725, NULL, NULL),
(257, 21, 726, NULL, NULL),
(258, 21, 727, NULL, NULL),
(259, 21, 728, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `saisons`
--

CREATE TABLE IF NOT EXISTS `saisons` (
  `saison_ID` int(3) NOT NULL AUTO_INCREMENT,
  `saison_designation` varchar(40) NOT NULL,
  PRIMARY KEY (`saison_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `saisons`
--

INSERT INTO `saisons` (`saison_ID`, `saison_designation`) VALUES
(1, '2015-2016');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la vue `matchs_complets`
--
DROP TABLE IF EXISTS `matchs_complets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `matchs_complets` AS select `matchs`.`match_ID` AS `match_ID`,`matchs`.`match_score_home` AS `match_score_home`,`matchs`.`match_score_visitors` AS `match_score_visitors`,`equipe1`.`equipe_ID` AS `equipe1_ID`,`equipe1`.`equipe_nom` AS `equipe1_nom`,`club1`.`club_ID` AS `club1_ID`,`club1`.`club_nom` AS `club1_nom`,`images1`.`image_fichier` AS `club1_logo`,`equipe2`.`equipe_ID` AS `equipe2_ID`,`equipe2`.`equipe_nom` AS `equipe2_nom`,`club2`.`club_ID` AS `club2_ID`,`club2`.`club_nom` AS `club2_nom`,`images1`.`image_fichier` AS `club2_logo`,`planifications`.`p_ID` AS `p_ID`,`planifications`.`p_date` AS `p_date`,`planifications`.`p_salle_ID` AS `p_salle_ID`,`competitions`.`c_ID` AS `c_ID`,`competitions`.`c_saison_ID` AS `c_saison_ID`,`competitions`.`c_nom` AS `c_nom`,`competitions`.`c_url_ffhb` AS `c_url_ffhb`,`competitions`.`c_categorie_ID` AS `c_categorie_ID`,`competitions`.`c_type` AS `c_type` from ((((((((`matchs` join `equipes` `equipe1` on((`matchs`.`match_home` = `equipe1`.`equipe_ID`))) join `clubs` `club1` on((`equipe1`.`equipe_club` = `club1`.`club_ID`))) left join `images` `images1` on((`club1`.`club_logo` = `images1`.`image_ID`))) join `equipes` `equipe2` on((`matchs`.`match_visitors` = `equipe2`.`equipe_ID`))) join `clubs` `club2` on((`equipe2`.`equipe_club` = `club2`.`club_ID`))) left join `images` `images2` on((`club2`.`club_logo` = `images2`.`image_ID`))) left join `planifications` on((`planifications`.`p_match_ID` = `matchs`.`match_ID`))) join `competitions` on((`competitions`.`c_ID` = `planifications`.`p_competition_ID`)));

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
