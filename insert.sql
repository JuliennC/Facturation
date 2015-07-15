-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 15 Juillet 2015 à 11:27
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `Activite`
--

DROP TABLE IF EXISTS `Activite`;
CREATE TABLE IF NOT EXISTS `Activite` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cleRepartition_id` int(11) NOT NULL,
  `Est_Ancienne_Activite` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Activite`
--

TRUNCATE TABLE `Activite`;
--
-- Contenu de la table `Activite`
--

INSERT INTO `Activite` (`id`, `Nom`, `cleRepartition_id`, `Est_Ancienne_Activite`) VALUES
(1, 'Gérer les postes Adm', 7, 0),
(2, 'Gérer les smartphone/tablettes', 5, 0),
(3, 'Gérer les postes Ecole', 8, 0),
(4, 'Gérer les postes internet publiques', 6, 0),
(5, 'Gérer les télécoms', 4, 0),
(6, 'Gérer l''infrastructure', 7, 0),
(7, 'Intervenir sur demande - Bureautique', 9, 0),
(8, 'Intervenir sur demande - Infra', 9, 0),
(9, 'Intervenir sur demande - Etude', 9, 0),
(10, 'Gérer FI', 3, 0),
(11, 'Gérer POP', 1, 0),
(12, 'Gérer RH', 2, 0),
(13, 'Gérer GEST', 9, 0),
(14, 'Gérer TECH', 9, 0),
(15, 'Gérer WEB', 9, 0),
(16, 'Gérer SIG', 9, 0),
(17, 'Gérer SOC', 9, 0),
(18, 'Gérer CULT', 9, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Application`
--

DROP TABLE IF EXISTS `Application`;
CREATE TABLE IF NOT EXISTS `Application` (
  `id` int(11) NOT NULL,
  `fournisseur_id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Application`
--

TRUNCATE TABLE `Application`;
--
-- Contenu de la table `Application`
--

INSERT INTO `Application` (`id`, `fournisseur_id`, `Nom`, `Libelle`) VALUES
(10, 1, 'SIG Développement Durable', ''),
(11, 1, 'GEST Aide au complétage des imprimés "CERFA"', 'Aide docs "CERFA"'),
(12, 1, 'SOC Aides résidants foyers "maisons de retraite"', 'Prest. pers. âgées'),
(13, 1, 'TECH Gestion du patrimoine', 'GIMA'),
(14, 1, 'Divers CyberBases', 'gestion interne'),
(15, 1, 'TECH Application : Visioconférence', 'Visioconférence'),
(16, 1, 'TECH Logiciel Schemelect', 'Logiciel : Schemelect , budget 02'),
(17, 1, 'Divers Etudes', 'gestion interne'),
(18, 1, 'Divers Infrastuctures', 'gestion interne'),
(19, 1, 'Divers Bureautiques', 'gestion interne'),
(20, 1, 'Divers Telephonies', 'gestion interne'),
(21, 1, 'Divers SIG', 'gestion interne'),
(22, 1, 'SOC Aide facultative, légale et du RMI', 'Gestion aide RMI'),
(23, 1, 'RH Allocations pour perte d''emploi', 'Alloc. perte d''emploi'),
(24, 1, 'SIG Divers', ''),
(25, 1, 'RH Gestion temps travail - ARTT', 'Gestion temps travail'),
(26, 1, 'CULT Billetterie des musées', 'Caisses et billetterie musées'),
(27, 1, 'CULT Billetterie Opéra Théâtre de Nancy - Poirel', 'RODRIGUE'),
(28, 1, 'SIG Accessibilité', ''),
(29, 1, 'GEST Cartes de transport', 'Attrib. cartes transp.'),
(30, 1, 'SIG System', ''),
(31, 1, 'SOC Chèques d''accompagnement personnalisés', 'Gestion des bons sociaux'),
(32, 1, 'CULT Collection des musées', 'MOBYDOC'),
(33, 1, 'POP LOGITUD Gestion des cimetières', 'Eternité de LOGITUD'),
(34, 1, 'TECH SISTEC Gestion des cimetières', 'Améthyste de SISTEC'),
(35, 1, 'CULT 4D Graines - Jardin Botanique', 'ODSI'),
(36, 1, 'CULT Ecole de musique de Vandoeuvre', 'Axel de TEGELOG'),
(37, 1, 'SOC Petite enfance', 'Nancy, Vandoeuvre, Seichamps'),
(38, 1, 'GEST D.I.C.T. d''hydraulique urbaine', 'Appli interne VB'),
(39, 1, 'GEST Dématérialisation des marchés publics', 'LOCALTRUST-MPE'),
(40, 1, 'GEST Multi-Facturation droits de voirie', 'Multi-Facturation'),
(41, 1, 'GEST Edition des codes barre courrier', 'Edit. codes barre'),
(42, 1, 'SIG Arcpole', ''),
(43, 1, 'CULT Edition Partitions', 'Edit. Partitions'),
(44, 1, 'TECH Elaboration cahier des charges bâti', 'Patrimoine/info bâti'),
(45, 1, 'POP Dépouillement Résultats Electoraux pour Nancy', 'Election : résultats'),
(46, 1, 'POP LOGITUD Gestion des électeurs', 'Election : électeurs'),
(47, 1, 'POP LOGITUD Gestion des actes état-civil', 'Etat civil'),
(48, 1, 'GEST Facturation Eau', 'Gest./Factur. Eau'),
(49, 1, 'SOC Facturation Scolarité Jeunesse Sports', 'Factur. Scolarité/Sports'),
(50, 1, 'FI fiscalités locale', 'fiscalité'),
(51, 1, 'POP LOGITUD Fourrière Véhicules', 'Fourrière'),
(52, 1, 'SIG Application', ''),
(53, 1, 'BUR Gestion bureautique - parc et incidents -', 'produit de la société Isilog'),
(54, 1, 'SOC Gestion CLSH Vandoeuvre', 'CLSH Vand.'),
(55, 1, 'GEST Gestion de l''immobilier locatif', 'Gestion parc locatif'),
(56, 1, 'TECH Gestion des accès', 'Gestion accès parkings'),
(57, 1, 'RH Gestion des arrets maladie', 'LEA'),
(58, 1, 'GEST Gestion des associations', 'Gestion des assoc.'),
(59, 1, 'CULT Gestion des badges au muséum acquarium', 'gestion des badges'),
(60, 1, 'GEST Gestion des délibérations', 'Gestion délibs'),
(61, 1, 'FI Gestion de la dette', 'Gestion de la dette'),
(62, 1, 'SIG Veille', ''),
(63, 1, 'GEST Gestion des macarons', 'Macarons résidants'),
(64, 1, 'GEST Gestion des parkings', 'Gestion des parkings'),
(65, 1, 'GEST Gestion des personnalités', 'Gestion personnalités'),
(66, 1, 'SIG Matériel', ''),
(67, 1, 'SIG Data', ''),
(68, 1, 'RH Gestion des prélévements mutuelle', 'MNT'),
(69, 1, 'RH Gestion Ressources Humaines', 'Gestion RH'),
(70, 1, 'TECH SISTEC Gestion des services techniques', 'interv. Serv. Tech.'),
(71, 1, 'TECH Services techniques, patrimoine, courrier', 'Infotech'),
(72, 1, 'GEST Gestion du courrier', 'Appli interne gestion courrier Lotus'),
(73, 1, 'SIG Urbanisme', ''),
(74, 1, 'TECH Gestion du patrimoine Vandoeuvre', 'AFI Patrimoine'),
(75, 1, 'FI Gestion financière, stocks, marchés, biens', 'CORIOLIS'),
(76, 1, 'GEST Gestion Propreté Déchets', 'COGIT'),
(77, 1, 'SIG Patrimoine Foncier', ''),
(78, 1, 'TECH Giration et Girabse', 'GIRA'),
(79, 1, 'RH Infocentre GRH', 'Tableaux bord GRH'),
(80, 1, 'GEST Intégration des loyers', 'Intégration loyers'),
(81, 1, 'GEST Intégration des titres de la fourrière', 'Intégr. titres fourrière'),
(82, 1, 'SIG Réseau', ''),
(83, 1, 'TECH Intervention Pôle Services Urbains', 'CUGN'),
(84, 1, 'GEST Messageries Agendas', 'Messageries Lotus'),
(85, 1, 'GEST Observatoire du stationnement', 'Stats stationnement'),
(86, 1, 'RH Paie des artistes du théâtre', 'Paie intermittents'),
(87, 1, 'RH Paie - compta ISI2 Parc des sports Vandoeuvre', 'paie compta ISI2'),
(88, 1, 'TECH Parc-Auto - Gestion carburants', 'Gestion parc auto Essence'),
(89, 1, 'TECH Parc-Auto - Véhicules', 'Gestion parc auto'),
(90, 1, 'GEST Permis de construire', 'Permis de construire'),
(91, 1, 'POP LOGITUD Formalités administratives', 'Fomalités administratives'),
(92, 1, 'POP LOGITUD Police municipale : Gestion de la PM', 'Police municipale'),
(93, 1, 'WEB Portail des élus Grand Nancy', 'Portail des élus'),
(94, 1, 'POP LOGITUD Recensement citoyen', 'Recensement citoyen'),
(95, 1, 'RH Archivage bulletins de salaire', 'Salaires sur CD'),
(96, 1, 'GEST Securité', 'Securité des ERP'),
(97, 1, 'WEB Sites CU internet et intranet', 'CUGN'),
(98, 1, 'FI Suivi de la ligne de trésorerie', 'Suivi ligne trésorerie'),
(99, 1, 'FI Suivi de la taxe professionnelle du Grand Nancy', 'Suivi TP CUGN'),
(100, 1, 'FI Suivi de trésorerie', 'Suivi trésorerie'),
(101, 1, 'SIG Espaces Verts', ''),
(102, 1, 'GEST Gestion de la demande', 'Suivi demandes voirie transport etc...'),
(103, 1, 'SOC Suivi des nuisances et des vaccinations', 'Nancy uniquement'),
(104, 1, 'FI Observatoire Fiscal', 'Gestion TH TB TNB'),
(105, 1, 'RH Tableaux de bord destinés à la DRH', 'Stats DRH'),
(106, 1, 'TECH Urbanisme', 'Instruct. urbanisme'),
(107, 1, 'SOC Personnes agées / tickets jeunes', 'base ACCESS'),
(108, 1, 'GEST Gestion des archives', 'Gestion des archives ARKHEIA'),
(109, 1, 'FI Gestion de la dette et immobilisations', 'Gestion des emprunts'),
(110, 1, 'POP Gestion des administés (Magora-1000 Feuil)', 'Gestion des adnimistrés ( Magora - Milles feuilles'),
(111, 1, 'SOC Gestion de l''aide sociale', 'Gestion de l''aide sociale'),
(112, 1, 'GEST Gestion d''alerte -Service urbain', 'Gestion alerte'),
(113, 1, 'CULT Conservatoire Régional du Grand Nancy', 'Cugn'),
(114, 1, 'POP LOGITUD Cartographie des cimetieres', 'Cartographie des cimetières uniquement Jarville'),
(115, 1, 'SOC Creche-petite enfance -nouvelle etude', 'Creche-petite enfance -nouvelle etude -Ccas Ncy'),
(116, 1, 'SOC Gestion des soins médicalisés', 'Gestion des soins médicalisés'),
(117, 1, 'CULT Inscription des écoles aux visites musées', 'Inscription des écoles aux visites musées'),
(118, 1, 'TECH Modélisation des réseaux d''assainissement', 'Assainissement infoworks'),
(119, 1, 'GEST Application de facturation ABC', 'application Access'),
(120, 1, 'RH Gestion des frais de mission', 'GFI'),
(121, 1, 'FI dématérialisation des finances', 'dématérialisation des finances'),
(122, 1, 'RH XEMELIOS', ''),
(123, 1, 'SOC Prestations scolaires periscolaires et portail', 'Scolaire périscolaire et Portail Famille en SAAS'),
(124, 1, 'SIG Voirie', ''),
(125, 1, 'SIG Circulation', ''),
(126, 1, 'POP LOGITUD Gestion des actes numérisés', 'Gestion actes numérisés uniquement pour Essey'),
(127, 1, 'POP LOGITUD Gestion des chiens dangereux', 'Chiens dangereux uniquement Malz et Nancy'),
(128, 1, 'TECH SISTEC Gestion de l''urbanisme', ''),
(129, 1, 'POP LOGITUD Scrutin - Résutat électoraux', 'Gestion des soirées électorales'),
(130, 1, 'FIRH Berger Levrault - SI Finances et RH', 'SI Fi RH des CMVM'),
(131, 1, 'GEST Dématérialisation ACTES et plateforme IXBUS', 'Dématérialisation contrôle de légalité'),
(132, 1, 'GEST Achat Public', 'Aide à la rédac des marchés'),
(133, 1, 'CULT BIBS Colibris année 2014', 'Système Informatisé de Gestion de Bibs'),
(134, 1, 'POP Mairiestem - Elections Saint-Max', ''),
(135, 1, 'CULT Piscines', 'Billetteries et Controle accés'),
(136, 1, 'GEST Taxe Locale sur Publicités Extérieures', 'TLPE'),
(137, 1, 'WEB Sites internet et intranet Nancy', 'Ville de NANCY'),
(138, 1, 'CULT BIBS Ressources Numériques', 'Ressources mutualisées pour les médiathèques'),
(139, 1, 'CULT BIBS Communication', 'Projet Colibris'),
(140, 1, 'GEST Gestion de ressources - planning', 'Logiciel Rooming IT'),
(141, 1, 'TECH Gestion accès AEIM', 'Logiciel SIPASS de l''AEIM'),
(142, 1, 'TECH Gestion des alarmes des FPA', 'Alarmes des Foyers de Pers Agées - Eiffage'),
(143, 1, 'TECH Gestion Technique Centralisée - Sauter', 'GTC Sauter'),
(144, 1, 'RH Paie des artistes de l''Opéra Théatre', 'Paie intermittents'),
(145, 1, 'RH Gestion des dotations vestimentaires', 'Habillement et gestion des stocks'),
(146, 1, 'RH Médecine Préventive', 'CUGN Nancy et CCAS'),
(147, 1, 'Salle Machine 2 VAND', 'Salle Morlot à Vandoeuvre'),
(148, 1, 'Sillon Lorrain', 'Sillon Lorrain'),
(149, 1, 'TECH Gestion des aires de Nomades', 'Compétence communautaire'),
(150, 1, 'SOC Facturation des FPA et EHPAD', ''),
(151, 1, 'SOC Facturation portage repas FAMU', 'Uniquement pour St Max'),
(152, 1, 'TECH Armoire à clés CT Brot', 'CT Brot'),
(153, 1, 'TECH Contrôle d''accès PC Circulation', 'Security Services'),
(154, 1, 'TECH Pesage bac à sel CTM', 'CTM'),
(155, 1, 'TECH Suivi des demandes usagers', 'Main courante'),
(156, 1, 'SIG Domaine Public', ''),
(157, 1, 'TECH Contrôle accès CT Brot', 'CT Brot'),
(158, 1, 'TECH Gestion centralisée supervision de l''eau', ''),
(159, 1, 'TECH Panneau lumineux siège', ''),
(160, 1, 'TECH Gestion Clés Pool Véhicules', 'marché en cours d''attribution'),
(161, 1, 'SIG Déplacement', ''),
(162, 1, 'SIG Propreté Déchêts', ''),
(163, 1, 'POP Agenda MDE', ''),
(164, 1, 'RH Bodet - gestion temps travail', '50% Pulnoy - 50 % Malzéville'),
(165, 1, 'RH Lambert Alcyon', '100 % Laxou'),
(166, 1, 'POP Winaf - Ministère de l''Intérieur', ''),
(167, 1, 'WEB Développements spécifiques et commun', ''),
(168, 1, 'WEB Logiciel Phraseanet', 'CUGN'),
(169, 1, 'WEB Confluence', 'CUGN'),
(170, 1, 'WEB Livre sur la Place', ''),
(171, 1, 'WEB Mercure - Portail AGILEO', 'Intradoc'),
(172, 1, 'WEB BDEL - Laxou', ''),
(173, 1, 'AGGLONUM Maintenance', 'Agglomération Numérique'),
(174, 1, 'AGGLONUM MOE & développement', 'Agglomération Numérique'),
(175, 1, 'GEST Lotus développements spécifiques', ''),
(176, 1, 'POP COMEST CIM EST', ''),
(177, 1, 'POP INSEE - SCRP ASARP', ''),
(178, 1, 'POP LAMBDA - LOGIPOL', ''),
(179, 1, 'POP SEDI - Recensement militaire', ''),
(180, 1, 'GEST Sondage et enquete', 'Ville de NANCY');

-- --------------------------------------------------------

--
-- Structure de la table `Budget`
--

DROP TABLE IF EXISTS `Budget`;
CREATE TABLE IF NOT EXISTS `Budget` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `Montant` int(11) NOT NULL,
  `Annee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Budget`
--

TRUNCATE TABLE `Budget`;
-- --------------------------------------------------------

--
-- Structure de la table `CleRepartition`
--

DROP TABLE IF EXISTS `CleRepartition`;
CREATE TABLE IF NOT EXISTS `CleRepartition` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `CleRepartition`
--

TRUNCATE TABLE `CleRepartition`;
--
-- Contenu de la table `CleRepartition`
--

INSERT INTO `CleRepartition` (`id`, `Nom`) VALUES
(1, 'Nombre d''habitants'),
(2, 'Nombre de bulletins de salaire'),
(3, 'Nombre de mouvements comptables'),
(4, 'Nombre de téléphones'),
(5, 'Nombre de smart/tab'),
(6, 'Nombre de postes Epn'),
(7, 'Nombre de postes Adm'),
(8, 'Nombre de postes Ecole'),
(9, 'Participation');

-- --------------------------------------------------------

--
-- Structure de la table `Collectivite`
--

DROP TABLE IF EXISTS `Collectivite`;
CREATE TABLE IF NOT EXISTS `Collectivite` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date_Debut_Mutualisation` date DEFAULT NULL,
  `Date_Fin_Mutualisation` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Collectivite`
--

TRUNCATE TABLE `Collectivite`;
--
-- Contenu de la table `Collectivite`
--

INSERT INTO `Collectivite` (`id`, `Nom`, `Date_Debut_Mutualisation`, `Date_Fin_Mutualisation`) VALUES
(1, 'Opéra National de Lorraine', '2010-01-01', '2050-01-01'),
(2, 'Mairie de Nancy', '2010-01-01', '2050-01-01'),
(3, 'Mairie de Vandoeuvre', '2010-01-01', '2050-01-01'),
(4, 'Mairie d''Art-sur-meurthe', '2010-01-01', '2050-01-01'),
(5, 'Mairie d''Essey-lès-Nancy', '2010-01-01', '2050-01-01'),
(6, 'Mairie de Jarville', '2010-01-01', '2050-01-01'),
(7, 'Mairie de Laxou', '2010-01-01', '2050-01-01'),
(8, 'Mairie de Malzéville', '2010-01-01', '2050-01-01'),
(9, 'Mairie de Saint-Max', '2010-01-01', '2050-01-01'),
(10, 'Mairie de Seichamps', '2010-01-01', '2050-01-01'),
(11, 'Mairie de Laneuveville', '2010-01-01', '2050-01-01'),
(12, 'Mairie de Ludres', '2010-01-01', '2050-01-01'),
(13, 'Mairie de Maxeville', '2010-01-01', '2050-01-01'),
(14, 'Mairie de Pulnoy', '2010-01-01', '2050-01-01'),
(15, 'Mairie de Saulxures', '2010-01-01', '2050-01-01'),
(16, 'CCAS de Nancy', '2010-01-01', '2050-01-01'),
(17, 'SIS', '2010-01-01', '2050-01-01'),
(18, 'Communauté Urbaine du Grand Nancy', '2010-01-01', '2050-01-01'),
(19, 'Mairie de Viller-lès-Nancy', '2010-01-01', '2050-01-01'),
(20, 'Budget annexe hydraulique', '2010-01-01', '2050-01-01'),
(21, 'SIVU', '2010-01-01', '2050-01-01'),
(22, 'Sillon Lorrain', '2010-01-01', '2050-01-01'),
(23, 'Mairie de Fléville', '2010-01-01', '2050-01-01'),
(24, 'Mairie d''Houdemont', '2010-01-01', '2050-01-01'),
(25, 'Mairie d''Heillecourt', '2010-01-01', '2050-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

DROP TABLE IF EXISTS `Commande`;
CREATE TABLE IF NOT EXISTS `Commande` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `fournisseur_id` int(11) NOT NULL,
  `livraison_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `imputation_id` int(11) NOT NULL,
  `Reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date_Livraison` datetime DEFAULT NULL,
  `Ventilation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Engagement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Libelle_Facturation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Total_TTC` decimal(10,2) NOT NULL,
  `Utilisateur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NomFournisseur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `AdresseFournisseur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Complement_Adresse_Fournisseur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Code_Postal_Fournisseur` int(11) NOT NULL,
  `VilleFournisseur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TelephoneFournisseur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NomLivraison` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `AdresseLivraison` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Complement_Adresse_Livraison` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Code_Postal_Livraison` int(11) NOT NULL,
  `VilleLivraison` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TelephoneLivraison` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Commande`
--

TRUNCATE TABLE `Commande`;
-- --------------------------------------------------------

--
-- Structure de la table `CommandeConcerneCollectivite`
--

DROP TABLE IF EXISTS `CommandeConcerneCollectivite`;
CREATE TABLE IF NOT EXISTS `CommandeConcerneCollectivite` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `collectivite_id` int(11) NOT NULL,
  `Repartion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `CommandeConcerneCollectivite`
--

TRUNCATE TABLE `CommandeConcerneCollectivite`;
-- --------------------------------------------------------

--
-- Structure de la table `CommandePasseEtat`
--

DROP TABLE IF EXISTS `CommandePasseEtat`;
CREATE TABLE IF NOT EXISTS `CommandePasseEtat` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `etat_id` int(11) NOT NULL,
  `datePassage` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `CommandePasseEtat`
--

TRUNCATE TABLE `CommandePasseEtat`;
-- --------------------------------------------------------

--
-- Structure de la table `EtatCommande`
--

DROP TABLE IF EXISTS `EtatCommande`;
CREATE TABLE IF NOT EXISTS `EtatCommande` (
  `id` int(11) NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `EtatCommande`
--

TRUNCATE TABLE `EtatCommande`;
--
-- Contenu de la table `EtatCommande`
--

INSERT INTO `EtatCommande` (`id`, `Libelle`) VALUES
(1, 'Creee'),
(2, 'Enregistree'),
(3, 'Envoyee'),
(4, 'Payee');

-- --------------------------------------------------------

--
-- Structure de la table `Fournisseur`
--

DROP TABLE IF EXISTS `Fournisseur`;
CREATE TABLE IF NOT EXISTS `Fournisseur` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Complement_Adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Code_Postal` int(11) NOT NULL,
  `Ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Fournisseur`
--

TRUNCATE TABLE `Fournisseur`;
--
-- Contenu de la table `Fournisseur`
--

INSERT INTO `Fournisseur` (`id`, `Nom`, `Adresse`, `Complement_Adresse`, `Code_Postal`, `Ville`, `Telephone`, `Fax`) VALUES
(1, 'Fournisseur test', '10 Rue du Pont', '2ème étage', 5400, 'Nancy', '0383090909', '0383080808');

-- --------------------------------------------------------

--
-- Structure de la table `Imputation`
--

DROP TABLE IF EXISTS `Imputation`;
CREATE TABLE IF NOT EXISTS `Imputation` (
  `id` int(11) NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Sous_fonction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Article` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Section` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Imputation`
--

TRUNCATE TABLE `Imputation`;
--
-- Contenu de la table `Imputation`
--

INSERT INTO `Imputation` (`id`, `Libelle`, `Sous_fonction`, `Article`, `Section`) VALUES
(1, 'Cotisation ville-internet', '90.14', '6281,63', 'Fonctionnement'),
(2, 'Cotisation mission Ecoter', '90.14', '6281.57', 'Fonctionnement'),
(3, 'Cotisation Avicca', '90.14', '6281.56', 'Fonctionnement'),
(4, 'Divers Travaux', '90.14', '2318-360', 'Investissement'),
(5, 'Divers Travaux', '90.14', '2318-496', 'Investissement'),
(6, 'Logiciels-  Piscines', '413', '205', 'Investissement'),
(7, 'Matériels -Piscines', '413', '2183', 'Investissement'),
(8, 'Eau : Participations (HT)', '01', '13918', 'Investissement'),
(9, 'Eau : Logiciels (HT)', '01', '205', 'Investissement'),
(10, 'Eau : Matériels (HT)', '01', '2183', 'Investissement'),
(11, 'Eau : Instal.,outillages tech.et travaux  (HT)', '01', '2315', 'Investissement'),
(12, 'Eau : Prestations de service (HT)', '01', '618.8', 'Fonctionnement'),
(13, 'Eau : Maintenance (HT)', '01', '6156', 'Fonctionnement'),
(14, 'Eau : Frais de telecom (HT)', '01', '6262', 'Fonctionnement'),
(15, 'Ass. : Participations (HT)', '02', '13918', 'Investissement'),
(16, 'Ass : Logiciels (HT)', '02', '205', 'Investissement'),
(17, 'Ass : Matériels (HT)', '02', '2183', 'Investissement'),
(18, 'Ass : Instal.,outillages tech.et travaux  (HT)', '02', '2315', 'Investissement'),
(19, 'Ass : Prestations de service (HT)', '02', '618.8', 'Fonctionnement'),
(20, 'Ass : Maintenance (HT)', '02', '6156', 'Fonctionnement'),
(21, 'Ass : Frais de telecom (HT)', '02', '6262', 'Fonctionnement'),
(22, 'Maintenance logiciels piscines', '413', '6156', 'Fonctionnement'),
(23, 'Maintenance des logiciels', '020.3', '6156', 'Fonctionnement'),
(24, 'Formations', '020.3', '6184', 'Fonctionnement'),
(25, 'Prestations de service', '020.3', '6188', 'Fonctionnement'),
(26, 'Annonces et insertions', '020.3', '6231', 'Fonctionnement'),
(27, 'Frais de Telecommunication', '020.3', '6262', 'Fonctionnement'),
(28, 'Autres fournitures- Achat de billet', '020.3', '60228', 'Fonctionnement'),
(29, 'Fournitures petit équipement', '020.3', '60632', 'Fonctionnement'),
(30, 'Cotisation "club utilisateur Coriolis"', '020.3', '6281.58', 'Fonctionnement'),
(31, 'Remboursement de frais au Ciril', '020.3', '62878.3', 'Fonctionnement'),
(32, 'Frais de telecommunication', '020.5', '6262', 'Fonctionnement'),
(33, 'Maintenance des logiciels ( SIG)', '820.1', '6156', 'Fonctionnement'),
(34, 'formations (SIG)', '820.1', '6184', 'Fonctionnement'),
(35, 'Prestations de service (SIG)', '820.1', '6188', 'Fonctionnement'),
(36, 'Maintenance Cyberbases - Abonnement', '90.16', '6156', 'Fonctionnement'),
(37, 'Formations (Cyberbases)', '90.16', '6184', 'Fonctionnement'),
(38, 'Prestations de service', '90.16', '6188', 'Fonctionnement'),
(39, 'Frais de telecommunication', '90.16', '6262', 'Fonctionnement'),
(40, 'Remboursement de frais de location', '90.16', '62878', 'Fonctionnement'),
(41, 'Logiciels', '020.3', '2051', 'Investissement'),
(42, 'Matériels', '020.3', '2183', 'Investissement'),
(43, 'Travaux de cablages', '020.3', '2315', 'Investissement'),
(44, 'Sub. d''équipement au Ciril', '020.3', '20418.22', 'Investissement'),
(45, 'Divers Travaux -SIG-', '820.1', '2318', 'Investissement'),
(46, 'logiciels', '90.14', '2051-308', 'Investissement'),
(47, 'Matériels', '90.14', '2183-308', 'Investissement'),
(48, 'Matériels', '90.14', '2183-360', 'Investissement'),
(49, 'Mobiliers er autres', '90.14', '2184-308', 'Investissement'),
(50, 'Cotisation ADULLACT', '90.14', '6281,59', 'Fonctionnement'),
(51, 'locations mobiliers et immobiliers', '90.16', '6132', 'Fonctionnement'),
(52, 'ImpSpécifique pour Nancy - report 2007', '020.2', '2183-Ncy', 'Investissement'),
(53, 'Documentation générale et technique', '020.3', '6182-300', 'Fonctionnement'),
(54, 'Documentation générale et technique', '020.3', '6182', 'Fonctionnement'),
(55, 'Cotisation au club utilisateurs Droits de Cités', '020.3', '6281.75', 'Fonctionnement'),
(56, 'Autres fournitures non stockées', '020.3', '60628', 'Fonctionnement'),
(57, 'Etudes et recherches', '020.3', '617-300', 'Fonctionnement'),
(58, 'Catalogues et imprimés', '020.3', '6236', 'Fonctionnement'),
(59, 'Etudes Préopérationnelles', '020.3', '2031', 'Investissement'),
(60, 'Travaux de réseau et voirie', '020.3', '2315', 'Investissement'),
(61, 'Club Utilisateur', '020.3', '6281.91', 'Fonctionnement'),
(62, 'Maintenance G-NY (PDU)', '820.3', '6156', 'Fonctionnement'),
(63, 'Installations générales', '020.3', '2135', 'Investissement'),
(64, 'entretien et réparations sur biens mobiliers', '020.3', '61558.300', 'Fonctionnement');

-- --------------------------------------------------------

--
-- Structure de la table `InformationCollectivite`
--

DROP TABLE IF EXISTS `InformationCollectivite`;
CREATE TABLE IF NOT EXISTS `InformationCollectivite` (
  `id` int(11) NOT NULL,
  `collectivite_id` int(11) NOT NULL,
  `Nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Annee` int(11) NOT NULL,
  `cleRepartition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `InformationCollectivite`
--

TRUNCATE TABLE `InformationCollectivite`;
-- --------------------------------------------------------

--
-- Structure de la table `InformationsCollectiviteListe`
--

DROP TABLE IF EXISTS `InformationsCollectiviteListe`;
CREATE TABLE IF NOT EXISTS `InformationsCollectiviteListe` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `InformationsCollectiviteListe`
--

TRUNCATE TABLE `InformationsCollectiviteListe`;
-- --------------------------------------------------------

--
-- Structure de la table `LigneCommande`
--

DROP TABLE IF EXISTS `LigneCommande`;
CREATE TABLE IF NOT EXISTS `LigneCommande` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `tva_id` int(11) NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Quantite` int(11) NOT NULL,
  `Prix_Unitaire` decimal(10,2) NOT NULL,
  `Total_TTC` decimal(10,2) NOT NULL,
  `Commentaire` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `LigneCommande`
--

TRUNCATE TABLE `LigneCommande`;
-- --------------------------------------------------------

--
-- Structure de la table `Livraison`
--

DROP TABLE IF EXISTS `Livraison`;
CREATE TABLE IF NOT EXISTS `Livraison` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Complement_Adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Code_Postal` int(11) NOT NULL,
  `Ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Livraison`
--

TRUNCATE TABLE `Livraison`;
-- --------------------------------------------------------

--
-- Structure de la table `MasseSalariale`
--

DROP TABLE IF EXISTS `MasseSalariale`;
CREATE TABLE IF NOT EXISTS `MasseSalariale` (
  `id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `Montant` int(11) NOT NULL,
  `Annee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `MasseSalariale`
--

TRUNCATE TABLE `MasseSalariale`;
-- --------------------------------------------------------

--
-- Structure de la table `Service`
--

DROP TABLE IF EXISTS `Service`;
CREATE TABLE IF NOT EXISTS `Service` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Est_Ancien_Service` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Service`
--

TRUNCATE TABLE `Service`;
--
-- Contenu de la table `Service`
--

INSERT INTO `Service` (`id`, `Nom`, `Est_Ancien_Service`) VALUES
(1, 'Bureautique', 0),
(2, 'Infrastructure', 0),
(3, 'Etude', 0);

-- --------------------------------------------------------

--
-- Structure de la table `TempsPasse`
--

DROP TABLE IF EXISTS `TempsPasse`;
CREATE TABLE IF NOT EXISTS `TempsPasse` (
  `id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `collectivite_id` int(11) NOT NULL,
  `Pourcentage` int(11) NOT NULL,
  `Annee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `TempsPasse`
--

TRUNCATE TABLE `TempsPasse`;
-- --------------------------------------------------------

--
-- Structure de la table `TVA`
--

DROP TABLE IF EXISTS `TVA`;
CREATE TABLE IF NOT EXISTS `TVA` (
  `id` int(11) NOT NULL,
  `pourcentage` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `TVA`
--

TRUNCATE TABLE `TVA`;
--
-- Contenu de la table `TVA`
--

INSERT INTO `TVA` (`id`, `pourcentage`) VALUES
(1, '0.00'),
(2, '2.10'),
(3, '5.50'),
(4, '7.00'),
(5, '20.00');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

DROP TABLE IF EXISTS `Utilisateur`;
CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vider la table avant d'insérer `Utilisateur`
--

TRUNCATE TABLE `Utilisateur`;
--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `service_id`, `Nom`, `Prenom`) VALUES
(1, 1, 'OZBEK', 'Gökhan'),
(2, 1, 'PRINET', 'Patricia'),
(3, 1, 'THIEBAUT', 'Jean-Baptiste'),
(4, 1, 'FIRLEJ', 'Samuel'),
(5, 1, 'PAULY', 'Francis'),
(6, 1, 'HELMER', 'Nicole'),
(7, 1, 'VIRY', 'Jacques'),
(8, 1, 'HAZOTTE', 'Patrick'),
(9, 1, 'PAGNOTTA', 'Alexandre'),
(10, 1, 'BUN', 'Vanthy'),
(11, 1, 'CHEROUGE', 'Antoine'),
(12, 1, 'TOURTELLE', 'Bruno'),
(13, 1, 'WILT', 'Frédéric'),
(14, 1, 'MASONI', 'Jean-Marie'),
(15, 1, 'LIBERT', 'Isabelle'),
(16, 1, 'BIET', 'Alain'),
(17, 1, 'BERNEZ', 'Pierre-Marie'),
(18, 2, 'LEGER', 'Marc'),
(19, 2, 'KOZIAR', 'Jean-Marc'),
(20, 2, 'THIRIET', 'Daniel'),
(21, 2, 'MOQUE', 'Yann'),
(22, 2, 'DELICOURT', 'Jean-Luc'),
(23, 2, 'RAFENONIRINA-LAZA', 'Antso'),
(24, 2, 'SOLT', 'Christine'),
(25, 2, 'FREULET', 'Valérie'),
(26, 2, 'SAILLET-BARTHE', 'Pascale'),
(27, 2, 'RODAK', 'Patrick'),
(28, 2, 'GILSON-FOURNIER', 'Claudine'),
(29, 2, 'VIVILLE', 'Brigitte'),
(30, 2, 'GRANDEMANGE', 'Arnaud'),
(31, 2, 'WEYANT', 'Frédéric'),
(32, 2, 'DUPONT', 'François'),
(33, 3, 'RUVERA', 'Martine'),
(34, 3, 'FREIHUBER', 'Danielle'),
(35, 3, 'HAYON', 'Marcel'),
(36, 3, 'DI CRESCENZO', 'Marc'),
(37, 3, 'RUEZ', 'Muriel'),
(38, 3, 'TROUY', 'Lionel'),
(39, 3, 'BROUSSAIS', 'François'),
(40, 3, 'RICHARD', 'Antoine'),
(41, 3, 'BARDOT', 'Claire'),
(42, 3, 'ADLER', 'Rebecca'),
(43, 3, 'SCHEIBLING', 'Séverine'),
(44, 3, 'CERQUEIRA', 'Georges'),
(45, 3, 'BEITSCHER', 'Myriam'),
(46, 3, 'CHAUDOIN', 'Julien');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Activite`
--
ALTER TABLE `Activite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4103374398F35CA9` (`cleRepartition_id`);

--
-- Index pour la table `Application`
--
ALTER TABLE `Application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_22C75216670C757F` (`fournisseur_id`);

--
-- Index pour la table `Budget`
--
ALTER TABLE `Budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_745EF24DED5CA9E6` (`service_id`);

--
-- Index pour la table `CleRepartition`
--
ALTER TABLE `CleRepartition`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Collectivite`
--
ALTER TABLE `Collectivite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_979CC42BED5CA9E6` (`service_id`),
  ADD KEY `IDX_979CC42B3E030ACD` (`application_id`),
  ADD KEY `IDX_979CC42B670C757F` (`fournisseur_id`),
  ADD KEY `IDX_979CC42B8E54FB25` (`livraison_id`),
  ADD KEY `IDX_979CC42B9B0F88B1` (`activite_id`),
  ADD KEY `IDX_979CC42B1E40325` (`imputation_id`);

--
-- Index pour la table `CommandeConcerneCollectivite`
--
ALTER TABLE `CommandeConcerneCollectivite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_71972E2A82EA2E54` (`commande_id`),
  ADD KEY `IDX_71972E2AA7991F51` (`collectivite_id`);

--
-- Index pour la table `CommandePasseEtat`
--
ALTER TABLE `CommandePasseEtat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8B01505982EA2E54` (`commande_id`),
  ADD KEY `IDX_8B015059D5E86FF` (`etat_id`);

--
-- Index pour la table `EtatCommande`
--
ALTER TABLE `EtatCommande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Fournisseur`
--
ALTER TABLE `Fournisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Imputation`
--
ALTER TABLE `Imputation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `InformationCollectivite`
--
ALTER TABLE `InformationCollectivite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F212DDF598F35CA9` (`cleRepartition_id`),
  ADD KEY `IDX_F212DDF5A7991F51` (`collectivite_id`);

--
-- Index pour la table `InformationsCollectiviteListe`
--
ALTER TABLE `InformationsCollectiviteListe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `LigneCommande`
--
ALTER TABLE `LigneCommande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CF33509A82EA2E54` (`commande_id`),
  ADD KEY `IDX_CF33509A4D79775F` (`tva_id`);

--
-- Index pour la table `Livraison`
--
ALTER TABLE `Livraison`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `MasseSalariale`
--
ALTER TABLE `MasseSalariale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_57DE69C19B0F88B1` (`activite_id`);

--
-- Index pour la table `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `TempsPasse`
--
ALTER TABLE `TempsPasse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BB45A6C79B0F88B1` (`activite_id`),
  ADD KEY `IDX_BB45A6C7A7991F51` (`collectivite_id`);

--
-- Index pour la table `TVA`
--
ALTER TABLE `TVA`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9B80EC64ED5CA9E6` (`service_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Activite`
--
ALTER TABLE `Activite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `Application`
--
ALTER TABLE `Application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT pour la table `Budget`
--
ALTER TABLE `Budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `CleRepartition`
--
ALTER TABLE `CleRepartition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `Collectivite`
--
ALTER TABLE `Collectivite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `CommandeConcerneCollectivite`
--
ALTER TABLE `CommandeConcerneCollectivite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `CommandePasseEtat`
--
ALTER TABLE `CommandePasseEtat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `EtatCommande`
--
ALTER TABLE `EtatCommande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `Fournisseur`
--
ALTER TABLE `Fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Imputation`
--
ALTER TABLE `Imputation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT pour la table `InformationCollectivite`
--
ALTER TABLE `InformationCollectivite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `InformationsCollectiviteListe`
--
ALTER TABLE `InformationsCollectiviteListe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `LigneCommande`
--
ALTER TABLE `LigneCommande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Livraison`
--
ALTER TABLE `Livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `MasseSalariale`
--
ALTER TABLE `MasseSalariale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Service`
--
ALTER TABLE `Service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `TempsPasse`
--
ALTER TABLE `TempsPasse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `TVA`
--
ALTER TABLE `TVA`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Activite`
--
ALTER TABLE `Activite`
  ADD CONSTRAINT `FK_4103374398F35CA9` FOREIGN KEY (`cleRepartition_id`) REFERENCES `CleRepartition` (`id`);

--
-- Contraintes pour la table `Application`
--
ALTER TABLE `Application`
  ADD CONSTRAINT `FK_22C75216670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `Fournisseur` (`id`);

--
-- Contraintes pour la table `Budget`
--
ALTER TABLE `Budget`
  ADD CONSTRAINT `FK_745EF24DED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `Service` (`id`);

--
-- Contraintes pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD CONSTRAINT `FK_979CC42B1E40325` FOREIGN KEY (`imputation_id`) REFERENCES `Imputation` (`id`),
  ADD CONSTRAINT `FK_979CC42B3E030ACD` FOREIGN KEY (`application_id`) REFERENCES `Application` (`id`),
  ADD CONSTRAINT `FK_979CC42B670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `Fournisseur` (`id`),
  ADD CONSTRAINT `FK_979CC42B8E54FB25` FOREIGN KEY (`livraison_id`) REFERENCES `Livraison` (`id`),
  ADD CONSTRAINT `FK_979CC42B9B0F88B1` FOREIGN KEY (`activite_id`) REFERENCES `Activite` (`id`),
  ADD CONSTRAINT `FK_979CC42BED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `Service` (`id`);

--
-- Contraintes pour la table `CommandeConcerneCollectivite`
--
ALTER TABLE `CommandeConcerneCollectivite`
  ADD CONSTRAINT `FK_71972E2A82EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `Commande` (`id`),
  ADD CONSTRAINT `FK_71972E2AA7991F51` FOREIGN KEY (`collectivite_id`) REFERENCES `Collectivite` (`id`);

--
-- Contraintes pour la table `CommandePasseEtat`
--
ALTER TABLE `CommandePasseEtat`
  ADD CONSTRAINT `FK_8B01505982EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `Commande` (`id`),
  ADD CONSTRAINT `FK_8B015059D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `EtatCommande` (`id`);

--
-- Contraintes pour la table `InformationCollectivite`
--
ALTER TABLE `InformationCollectivite`
  ADD CONSTRAINT `FK_F212DDF598F35CA9` FOREIGN KEY (`cleRepartition_id`) REFERENCES `CleRepartition` (`id`),
  ADD CONSTRAINT `FK_F212DDF5A7991F51` FOREIGN KEY (`collectivite_id`) REFERENCES `Collectivite` (`id`);

--
-- Contraintes pour la table `LigneCommande`
--
ALTER TABLE `LigneCommande`
  ADD CONSTRAINT `FK_CF33509A4D79775F` FOREIGN KEY (`tva_id`) REFERENCES `TVA` (`id`),
  ADD CONSTRAINT `FK_CF33509A82EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `Commande` (`id`);

--
-- Contraintes pour la table `MasseSalariale`
--
ALTER TABLE `MasseSalariale`
  ADD CONSTRAINT `FK_57DE69C19B0F88B1` FOREIGN KEY (`activite_id`) REFERENCES `Activite` (`id`);

--
-- Contraintes pour la table `TempsPasse`
--
ALTER TABLE `TempsPasse`
  ADD CONSTRAINT `FK_BB45A6C79B0F88B1` FOREIGN KEY (`activite_id`) REFERENCES `Activite` (`id`),
  ADD CONSTRAINT `FK_BB45A6C7A7991F51` FOREIGN KEY (`collectivite_id`) REFERENCES `Collectivite` (`id`);

--
-- Contraintes pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD CONSTRAINT `FK_9B80EC64ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `Service` (`id`);
