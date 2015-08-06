-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Lun 03 Août 2015 à 13:58
-- Version du serveur :  5.5.42
-- Version de PHP :  5.4.42

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `facturation`
--

-- --------------------------------------------------------

--
-- Structure de la table `Activite`
--

CREATE TABLE `Activite` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Est_Ancienne_Activite` tinyint(1) NOT NULL,
  `cleRepartition_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Activite`
--

INSERT INTO `Activite` (`id`, `Nom`, `Est_Ancienne_Activite`, `cleRepartition_id`) VALUES
(1, 'Gérer les postes Adm', 0, 7),
(2, 'Gérer les smartphone/tablettes', 0, 5),
(3, 'Gérer les postes Ecole', 0, 8),
(4, 'Gérer les postes internet publiques', 0, 6),
(5, 'Gérer les télécoms', 0, 4),
(6, 'Gérer l''infrastructure', 0, 7),
(7, 'Intervenir sur demande - Bureautique', 0, 9),
(8, 'Intervenir sur demande - Infra', 0, 9),
(9, 'Intervenir sur demande - Etude', 0, 9),
(10, 'Gérer FI', 0, 3),
(11, 'Gérer POP', 0, 1),
(12, 'Gérer RH', 0, 2),
(13, 'Gérer GEST', 0, 9),
(14, 'Gérer TECH', 0, 9),
(15, 'Gérer WEB', 0, 9),
(16, 'Gérer SIG', 0, 9),
(17, 'Gérer SOC', 0, 9),
(18, 'Gérer CULT', 0, 9);

-- --------------------------------------------------------

--
-- Structure de la table `Application`
--

CREATE TABLE `Application` (
  `id` int(11) NOT NULL,
  `fournisseur_id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(173, 2, 'AGGLONUM Maintenance', 'Agglomération Numérique'),
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

CREATE TABLE `Budget` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `Montant` int(11) NOT NULL,
  `Annee` int(11) NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Budget`
--

INSERT INTO `Budget` (`id`, `service_id`, `Montant`, `Annee`, `Libelle`) VALUES
(1, 1, 2500, 2015, 'Logiciel - b'),
(2, 3, 10000, 2015, 'Logiciel - e'),
(3, 2, 12000, 2015, 'Logiciel - i'),
(4, 5, 10000, 2015, 'Materiel - c'),
(5, 4, 10000, 2015, 'Formation- s');

-- --------------------------------------------------------

--
-- Structure de la table `bug`
--

CREATE TABLE `bug` (
  `id` int(11) NOT NULL,
  `Type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Utilisateur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Circonstances` varchar(2555) COLLATE utf8_unicode_ci NOT NULL,
  `Commentaire` varchar(2555) COLLATE utf8_unicode_ci NOT NULL,
  `Statut` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `CleRepartition`
--

CREATE TABLE `CleRepartition` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `Collectivite` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date_Debut_Mutualisation` date DEFAULT NULL,
  `Date_Fin_Mutualisation` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Collectivite`
--

INSERT INTO `Collectivite` (`id`, `Nom`, `Date_Debut_Mutualisation`, `Date_Fin_Mutualisation`) VALUES
(1, 'Opéra National de Lorraine', '2010-01-01', '2050-01-01'),
(2, 'Mairie de Nancy', '2010-01-01', '2050-01-01'),
(3, 'Mairie de Vandoeuvre', '2010-01-01', '2050-01-01'),
(4, 'Mairie dArt-sur-meurthe', '2010-01-01', '2050-01-01'),
(5, 'Mairie d Essey-lès-Nancy', '2010-01-01', '2050-01-01'),
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
(24, 'Mairie d Houdemont', '2010-01-01', '2050-01-01'),
(25, 'Mairie d Heillecourt', '2010-01-01', '2050-01-01'),
(26, 'Mairie de Dommartemont', '2010-01-01', '2050-01-01'),
(27, 'Mairie de Tomblaine', '2010-01-01', '2050-01-01'),
(28, 'CCAS de Vandoeurvre', '2010-01-01', '2050-01-01'),
(29, 'CCAS de Laxou', '2010-01-01', '2050-01-01'),
(30, 'ONL', '2010-01-01', '2050-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

CREATE TABLE `Commande` (
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
  `TelephoneLivraison` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FaxFournisseur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ContactFournisseur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EmailContactFournisseur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Faxlivraison` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MontantPaye` decimal(10,2) NOT NULL,
  `Total_HT` decimal(10,2) NOT NULL,
  `Date_Envoi` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Commande`
--

INSERT INTO `Commande` (`id`, `service_id`, `application_id`, `fournisseur_id`, `livraison_id`, `activite_id`, `imputation_id`, `Reference`, `Date_Livraison`, `Ventilation`, `Engagement`, `Libelle_Facturation`, `Total_TTC`, `Utilisateur`, `NomFournisseur`, `AdresseFournisseur`, `Complement_Adresse_Fournisseur`, `Code_Postal_Fournisseur`, `VilleFournisseur`, `TelephoneFournisseur`, `NomLivraison`, `AdresseLivraison`, `Complement_Adresse_Livraison`, `Code_Postal_Livraison`, `VilleLivraison`, `TelephoneLivraison`, `FaxFournisseur`, `ContactFournisseur`, `EmailContactFournisseur`, `Faxlivraison`, `MontantPaye`, `Total_HT`, `Date_Envoi`) VALUES
(7, 2, 10, 2, 1, 18, 8, 'ReFint78_3', '2015-07-07 00:00:00', 'Mutualisee', '123', 'libelle', '4801.30', 'nomA prenomA', 'Fournisseur test 2', '34 Rue Saint-Jean', '-', 54000, 'Nancy', '0383010101', 'Lieu livraison test', '50 Rue Sainte-Catherine', '4eme étage', 54000, 'Nancy', '0383121212', NULL, 'contact f', 'email@fournisseur.fr', NULL, '4791.30', '4551.00', '2015-07-09 00:00:00'),
(8, 2, 10, 1, 2, 18, 8, NULL, '2015-08-19 00:00:00', 'Forfait', NULL, 'libelle', '447310.03', 'nomA prenomA', 'Fournisseur test', '10 Rue du Pont', '2ème étage', 5400, 'Nancy', '0383090909', 'Lieu livraison test2', '50 Rue Sainte-Catherine', '4eme étage', 54000, 'Nancy', '0383121212', NULL, NULL, NULL, NULL, '10.00', '418046.76', '2015-08-22 00:00:00'),
(9, 2, 10, 2, 2, 18, 8, 'ref', '2015-08-04 00:00:00', 'Forfait', NULL, 'libelle', '5966.02', 'nomA prenomA', 'Fournisseur test 2', '34 Rue Saint-Jean', '-', 54000, 'Nancy', '0383010101', 'Lieu livraison test2', '50 Rue Sainte-Catherine', '4eme étage', 54000, 'Nancy', '0383121212', NULL, 'contact f', 'email@fournisseur.fr', NULL, '10.00', '5655.00', '2015-08-13 00:00:00'),
(10, 2, 10, 2, 2, 18, 8, 'ref', '2015-08-11 00:00:00', 'Forfait', NULL, 're', '5400.07', 'nomA prenomA', 'Fournisseur test 2', '34 Rue Saint-Jean', '-', 54000, 'Nancy', '0383010101', 'Lieu livraison test2', '50 Rue Sainte-Catherine', '4eme étage', 54000, 'Nancy', '0383121212', NULL, 'contact f', 'email@fournisseur.fr', NULL, '10.00', '5289.00', '2015-08-06 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `CommandeConcerneCollectivite`
--

CREATE TABLE `CommandeConcerneCollectivite` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `collectivite_id` int(11) NOT NULL,
  `Repartion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `CommandeConcerneCollectivite`
--

INSERT INTO `CommandeConcerneCollectivite` (`id`, `commande_id`, `collectivite_id`, `Repartion`) VALUES
(147, 7, 29, 'Participation'),
(148, 7, 18, 'Participation'),
(149, 7, 25, 'Participation'),
(153, 9, 18, 'Participation'),
(154, 9, 6, 'Participation'),
(157, 10, 18, 'Participation'),
(158, 10, 24, 'Participation');

-- --------------------------------------------------------

--
-- Structure de la table `CommandePasseEtat`
--

CREATE TABLE `CommandePasseEtat` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `etat_id` int(11) NOT NULL,
  `datePassage` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `CommandePasseEtat`
--

INSERT INTO `CommandePasseEtat` (`id`, `commande_id`, `etat_id`, `datePassage`) VALUES
(72, 7, 1, '2015-07-31 11:07:18'),
(73, 7, 2, '2015-07-31 11:07:19'),
(74, 7, 3, '2015-07-31 11:07:50'),
(76, 7, 4, '2015-07-31 11:17:22'),
(77, 8, 1, '2015-08-03 10:09:05'),
(78, 8, 2, '2015-08-03 10:09:06'),
(79, 8, 2, '2015-08-03 10:14:09'),
(80, 8, 2, '2015-08-03 10:14:32'),
(84, 7, 5, '2015-08-03 12:34:29'),
(85, 8, 2, '2015-08-03 12:36:42'),
(86, 8, 3, '2015-08-03 12:37:02'),
(87, 8, 4, '2015-08-03 12:37:16'),
(89, 9, 1, '2015-08-03 12:47:24'),
(90, 9, 2, '2015-08-03 12:47:25'),
(91, 9, 2, '2015-08-03 12:49:37'),
(92, 9, 3, '2015-08-03 12:52:47'),
(93, 9, 4, '2015-08-03 12:52:56'),
(94, 9, 5, '2015-08-03 12:53:01'),
(95, 10, 1, '2015-08-03 13:09:04'),
(96, 10, 2, '2015-08-03 13:09:05'),
(97, 10, 3, '2015-08-03 13:09:16'),
(98, 10, 4, '2015-08-03 13:09:24'),
(99, 10, 5, '2015-08-03 13:10:01');

-- --------------------------------------------------------

--
-- Structure de la table `EtatCommande`
--

CREATE TABLE `EtatCommande` (
  `id` int(11) NOT NULL,
  `Libelle` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `EtatCommande`
--

INSERT INTO `EtatCommande` (`id`, `Libelle`) VALUES
(1, 'Creee'),
(2, 'Enregistree'),
(3, 'Engagee'),
(4, 'Paiement'),
(5, 'Terminee');

-- --------------------------------------------------------

--
-- Structure de la table `forfait`
--

CREATE TABLE `forfait` (
  `id` int(11) NOT NULL,
  `collectivite_id` int(11) NOT NULL,
  `annee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `montant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `application_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `forfait`
--

INSERT INTO `forfait` (`id`, `collectivite_id`, `annee`, `montant`, `application_id`) VALUES
(8, 18, '2015', '1231', 10);

-- --------------------------------------------------------

--
-- Structure de la table `Fournisseur`
--

CREATE TABLE `Fournisseur` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Complement_Adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Code_Postal` int(11) NOT NULL,
  `Ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EmailContact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Fournisseur`
--

INSERT INTO `Fournisseur` (`id`, `Nom`, `Adresse`, `Complement_Adresse`, `Code_Postal`, `Ville`, `Telephone`, `Fax`, `Contact`, `EmailContact`) VALUES
(1, 'Fournisseur test', '10 Rue du Pont', '2ème étage', 5400, 'Nancy', '0383090909', NULL, NULL, NULL),
(2, 'Fournisseur test 2', '34 Rue Saint-Jean', '-', 54000, 'Nancy', '0383010101', NULL, 'contact f', 'email@fournisseur.fr');

-- --------------------------------------------------------

--
-- Structure de la table `Image`
--

CREATE TABLE `Image` (
  `id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Imputation`
--

CREATE TABLE `Imputation` (
  `id` int(11) NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Sous_fonction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Article` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Section` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Est_Facture` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Imputation`
--

INSERT INTO `Imputation` (`id`, `Libelle`, `Sous_fonction`, `Article`, `Section`, `Est_Facture`) VALUES
(1, 'Cotisation ville-internet', '90.14', '6281,63', 'Fonctionnement', 0),
(2, 'Cotisation mission Ecoter', '90.14', '6281.57', 'Fonctionnement', 0),
(3, 'Cotisation Avicca', '90.14', '6281.56', 'Fonctionnement', 0),
(4, 'Divers Travaux', '90.14', '2318-360', 'Investissement', 0),
(5, 'Divers Travaux', '90.14', '2318-496', 'Investissement', 0),
(6, 'Logiciels-  Piscines', '413', '205', 'Investissement', 0),
(7, 'Matériels -Piscines', '413', '2183', 'Investissement', 0),
(8, 'Eau : Participations (HT)', '01', '13918', 'Investissement', 0),
(9, 'Eau : Logiciels (HT)', '01', '205', 'Investissement', 0),
(10, 'Eau : Matériels (HT)', '01', '2183', 'Investissement', 0),
(11, 'Eau : Instal.,outillages tech.et travaux  (HT)', '01', '2315', 'Investissement', 0),
(12, 'Eau : Prestations de service (HT)', '01', '618.8', 'Fonctionnement', 0),
(13, 'Eau : Maintenance (HT)', '01', '6156', 'Fonctionnement', 0),
(14, 'Eau : Frais de telecom (HT)', '01', '6262', 'Fonctionnement', 0),
(15, 'Ass. : Participations (HT)', '02', '13918', 'Investissement', 0),
(16, 'Ass : Logiciels (HT)', '02', '205', 'Investissement', 0),
(17, 'Ass : Matériels (HT)', '02', '2183', 'Investissement', 0),
(18, 'Ass : Instal.,outillages tech.et travaux  (HT)', '02', '2315', 'Investissement', 0),
(19, 'Ass : Prestations de service (HT)', '02', '618.8', 'Fonctionnement', 0),
(20, 'Ass : Maintenance (HT)', '02', '6156', 'Fonctionnement', 0),
(21, 'Ass : Frais de telecom (HT)', '02', '6262', 'Fonctionnement', 0),
(22, 'Maintenance logiciels piscines', '413', '6156', 'Fonctionnement', 0),
(23, 'Maintenance des logiciels', '020.3', '6156', 'Fonctionnement', 0),
(24, 'Formations', '020.3', '6184', 'Fonctionnement', 0),
(25, 'Prestations de service', '020.3', '6188', 'Fonctionnement', 0),
(26, 'Annonces et insertions', '020.3', '6231', 'Fonctionnement', 0),
(27, 'Frais de Telecommunication', '020.3', '6262', 'Fonctionnement', 0),
(28, 'Autres fournitures- Achat de billet', '020.3', '60228', 'Fonctionnement', 0),
(29, 'Fournitures petit équipement', '020.3', '60632', 'Fonctionnement', 0),
(30, 'Cotisation "club utilisateur Coriolis"', '020.3', '6281.58', 'Fonctionnement', 0),
(31, 'Remboursement de frais au Ciril', '020.3', '62878.3', 'Fonctionnement', 0),
(32, 'Frais de telecommunication', '020.5', '6262', 'Fonctionnement', 0),
(33, 'Maintenance des logiciels ( SIG)', '820.1', '6156', 'Fonctionnement', 0),
(34, 'formations (SIG)', '820.1', '6184', 'Fonctionnement', 0),
(35, 'Prestations de service (SIG)', '820.1', '6188', 'Fonctionnement', 0),
(36, 'Maintenance Cyberbases - Abonnement', '90.16', '6156', 'Fonctionnement', 0),
(37, 'Formations (Cyberbases)', '90.16', '6184', 'Fonctionnement', 0),
(38, 'Prestations de service', '90.16', '6188', '', 0),
(39, 'Frais de telecommunication', '90.16', '6262', '', 0),
(40, 'Remboursement de frais de location', '90.16', '62878', '', 0),
(41, 'Logiciels', '020.3', '2051', 'Investissement', 0),
(42, 'Matériels', '020.3', '2183', 'Investissement', 0),
(43, 'Travaux de cablages', '020.3', '2315', 'Investissement', 0),
(44, 'Sub. d''équipement au Ciril', '020.3', '20418.22', 'Investissement', 0),
(45, 'Divers Travaux -SIG-', '820.1', '2318', 'Investissement', 0),
(46, 'logiciels', '90.14', '2051-308', 'Investissement', 0),
(47, 'Matériels', '90.14', '2183-308', 'Investissement', 0),
(48, 'Matériels', '90.14', '2183-360', 'Investissement', 0),
(49, 'Mobiliers er autres', '90.14', '2184-308', 'Investissement', 0),
(50, 'Cotisation ADULLACT', '90.14', '6281,59', 'Fonctionnement', 0),
(51, 'locations mobiliers et immobiliers', '90.16', '6132', 'Fonctionnement', 0),
(52, 'ImpSpécifique pour Nancy - report 2007', '020.2', '2183-Ncy', 'Investissement', 0),
(53, 'Documentation générale et technique', '020.3', '6182-300', 'Fonctionnement', 0),
(54, 'Documentation générale et technique', '020.3', '6182', 'Fonctionnement', 0),
(55, 'Cotisation au club utilisateurs Droits de Cités', '020.3', '6281.75', 'Fonctionnement', 0),
(56, 'Autres fournitures non stockées', '020.3', '60628', 'Fonctionnement', 0),
(57, 'Etudes et recherches', '020.3', '617-300', 'Fonctionnement', 0),
(58, 'Catalogues et imprimés', '020.3', '6236', 'Fonctionnement', 0),
(59, 'Etudes Préopérationnelles', '020.3', '2031', 'Investissement', 0),
(60, 'Travaux de réseau et voirie', '020.3', '2315', 'Investissement', 0),
(61, 'Club Utilisateur', '020.3', '6281.91', 'Fonctionnement', 0),
(62, 'Maintenance G-NY (PDU)', '820.3', '6156', 'Fonctionnement', 0),
(63, 'Installations générales', '020.3', '2135', 'Investissement', 0),
(64, 'entretien et réparations sur biens mobiliers', '020.3', '61558.300', 'Fonctionnement', 0);

-- --------------------------------------------------------

--
-- Structure de la table `ImputationConcerneBudget`
--

CREATE TABLE `ImputationConcerneBudget` (
  `id` int(11) NOT NULL,
  `imputation_id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `ImputationConcerneBudget`
--

INSERT INTO `ImputationConcerneBudget` (`id`, `imputation_id`, `budget_id`) VALUES
(17, 8, 1),
(18, 8, 3),
(19, 8, 5),
(20, 10, 4),
(21, 41, 3),
(22, 46, 3);

-- --------------------------------------------------------

--
-- Structure de la table `InformationCollectivite`
--

CREATE TABLE `InformationCollectivite` (
  `id` int(11) NOT NULL,
  `collectivite_id` int(11) NOT NULL,
  `Nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Annee` int(11) NOT NULL,
  `cleRepartition_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `InformationCollectivite`
--

INSERT INTO `InformationCollectivite` (`id`, `collectivite_id`, `Nombre`, `Annee`, `cleRepartition_id`) VALUES
(1, 8, '100', 2015, 4),
(2, 17, '123', 2015, 8),
(3, 1, '0', 2015, 1),
(4, 1, '0', 2015, 2),
(5, 1, '0', 2015, 3),
(6, 1, '90', 2015, 4),
(7, 1, '12', 2015, 5),
(8, 1, '0', 2015, 6),
(9, 1, '0', 2015, 7),
(10, 1, '34', 2015, 8),
(11, 1, '0', 2015, 9),
(12, 2, '107334', 2015, 1),
(13, 2, '27669', 2015, 2),
(14, 2, '27529', 2015, 3),
(15, 2, '2678', 2015, 4),
(16, 2, '76', 2015, 5),
(17, 2, '0', 2015, 6),
(18, 2, '0', 2015, 7),
(19, 2, '0', 2015, 8),
(20, 2, '0', 2015, 9),
(21, 3, '31017', 2015, 1),
(22, 3, '8305', 2015, 2),
(23, 3, '17697', 2015, 3),
(24, 3, '741', 2015, 4),
(25, 3, '10', 2015, 5),
(26, 3, '0', 2015, 6),
(27, 3, '0', 2015, 7),
(28, 3, '0', 2015, 8),
(29, 3, '0', 2015, 9),
(30, 4, '1599', 2015, 1),
(31, 4, '0', 2015, 2),
(32, 4, '0', 2015, 3),
(33, 4, '0', 2015, 4),
(34, 4, '8', 2015, 5),
(35, 4, '0', 2015, 6),
(36, 4, '0', 2015, 7),
(37, 4, '0', 2015, 8),
(38, 4, '0', 2015, 9),
(39, 5, '8832', 2015, 1),
(40, 5, '0', 2015, 2),
(41, 5, '0', 2015, 3),
(42, 5, '162', 2015, 4),
(43, 5, '10', 2015, 5),
(44, 5, '0', 2015, 6),
(45, 5, '0', 2015, 7),
(46, 5, '0', 2015, 8),
(47, 5, '0', 2015, 9),
(48, 6, '9628', 2015, 1),
(49, 6, '0', 2015, 2),
(50, 6, '0', 2015, 3),
(51, 6, '0', 2015, 4),
(52, 6, '5', 2015, 5),
(53, 6, '0', 2015, 6),
(54, 6, '0', 2015, 7),
(55, 6, '0', 2015, 8),
(56, 6, '0', 2015, 9),
(57, 7, '15197', 2015, 1),
(58, 7, '2894', 2015, 2),
(59, 7, '3933', 2015, 3),
(60, 7, '167', 2015, 4),
(61, 7, '4', 2015, 5),
(62, 7, '0', 2015, 6),
(63, 7, '0', 2015, 7),
(64, 7, '0', 2015, 8),
(65, 7, '0', 2015, 9),
(66, 8, '8302', 2015, 1),
(67, 8, '0', 2015, 2),
(68, 8, '0', 2015, 3),
(69, 8, '2', 2015, 5),
(70, 8, '0', 2015, 6),
(71, 8, '0', 2015, 7),
(72, 8, '0', 2015, 8),
(73, 8, '0', 2015, 9),
(74, 9, '9785', 2015, 1),
(75, 9, '0', 2015, 2),
(76, 9, '0', 2015, 3),
(77, 9, '0', 2015, 4),
(78, 9, '1', 2015, 5),
(79, 9, '0', 2015, 6),
(80, 9, '0', 2015, 7),
(81, 9, '0', 2015, 8),
(82, 9, '0', 2015, 9),
(83, 10, '4978', 2015, 1),
(84, 10, '0', 2015, 2),
(85, 10, '0', 2015, 3),
(86, 10, '0', 2015, 4),
(87, 10, '0', 2015, 5),
(88, 10, '0', 2015, 6),
(89, 10, '0', 2015, 7),
(90, 10, '0', 2015, 8),
(91, 10, '0', 2015, 9),
(92, 11, '6063', 2015, 1),
(93, 11, '0', 2015, 2),
(94, 11, '0', 2015, 3),
(95, 11, '0', 2015, 4),
(96, 11, '0', 2015, 5),
(97, 11, '0', 2015, 6),
(98, 11, '0', 2015, 7),
(99, 11, '0', 2015, 8),
(100, 11, '0', 2015, 9),
(101, 12, '6648', 2015, 1),
(102, 12, '0', 2015, 2),
(103, 12, '0', 2015, 3),
(104, 12, '112', 2015, 4),
(105, 12, '3', 2015, 5),
(106, 12, '0', 2015, 6),
(107, 12, '0', 2015, 7),
(108, 12, '0', 2015, 8),
(109, 12, '0', 2015, 9),
(110, 13, '9661', 2015, 1),
(111, 13, '0', 2015, 2),
(112, 13, '0', 2015, 3),
(113, 13, '0', 2015, 4),
(114, 13, '0', 2015, 5),
(115, 13, '0', 2015, 6),
(116, 13, '0', 2015, 7),
(117, 13, '0', 2015, 8),
(118, 13, '0', 2015, 9),
(119, 14, '4428', 2015, 1),
(120, 14, '0', 2015, 2),
(121, 14, '0', 2015, 3),
(122, 14, '0', 2015, 4),
(123, 14, '2', 2015, 5),
(124, 14, '0', 2015, 6),
(125, 14, '0', 2015, 7),
(126, 14, '0', 2015, 8),
(127, 14, '0', 2015, 9),
(128, 15, '4010', 2015, 1),
(129, 15, '0', 2015, 2),
(130, 15, '0', 2015, 3),
(131, 15, '40', 2015, 4),
(132, 15, '2', 2015, 5),
(133, 15, '0', 2015, 6),
(134, 15, '0', 2015, 7),
(135, 15, '0', 2015, 8),
(136, 15, '0', 2015, 9),
(137, 16, '0', 2015, 1),
(138, 16, '7534', 2015, 2),
(139, 16, '8849', 2015, 3),
(140, 16, '311', 2015, 4),
(141, 16, '0', 2015, 5),
(142, 16, '0', 2015, 6),
(143, 16, '0', 2015, 7),
(144, 16, '0', 2015, 8),
(145, 16, '0', 2015, 9),
(146, 17, '0', 2015, 1),
(147, 17, '0', 2015, 2),
(148, 17, '983', 2015, 3),
(149, 17, '0', 2015, 4),
(150, 17, '4', 2015, 5),
(151, 17, '0', 2015, 6),
(152, 17, '0', 2015, 7),
(153, 17, '0', 2015, 9),
(154, 18, '0', 2015, 1),
(155, 18, '21046', 2015, 2),
(156, 18, '34412', 2015, 3),
(157, 18, '2633', 2015, 4),
(158, 18, '222', 2015, 5),
(159, 18, '0', 2015, 6),
(160, 18, '0', 2015, 7),
(161, 18, '0', 2015, 8),
(162, 18, '0', 2015, 9),
(163, 19, '14827', 2015, 1),
(164, 19, '0', 2015, 2),
(165, 19, '0', 2015, 3),
(166, 19, '131', 2015, 4),
(167, 19, '0', 2015, 5),
(168, 19, '0', 2015, 6),
(169, 19, '0', 2015, 7),
(170, 19, '0', 2015, 8),
(171, 19, '0', 2015, 9),
(172, 20, '0', 2015, 1),
(173, 20, '0', 2015, 2),
(174, 20, '0', 2015, 3),
(175, 20, '0', 2015, 4),
(176, 20, '0', 2015, 5),
(177, 20, '0', 2015, 6),
(178, 20, '0', 2015, 7),
(179, 20, '0', 2015, 8),
(180, 20, '0', 2015, 9),
(181, 21, '0', 2015, 1),
(182, 21, '0', 2015, 2),
(183, 21, '0', 2015, 3),
(184, 21, '18', 2015, 4),
(185, 21, '0', 2015, 5),
(186, 21, '0', 2015, 6),
(187, 21, '0', 2015, 7),
(188, 21, '0', 2015, 8),
(189, 21, '0', 2015, 9),
(190, 22, '0', 2015, 1),
(191, 22, '0', 2015, 2),
(192, 22, '0', 2015, 3),
(193, 22, '0', 2015, 4),
(194, 22, '0', 2015, 5),
(195, 22, '0', 2015, 6),
(196, 22, '0', 2015, 7),
(197, 22, '0', 2015, 8),
(198, 22, '0', 2015, 9),
(199, 23, '2374', 2015, 1),
(200, 23, '0', 2015, 2),
(201, 23, '0', 2015, 3),
(202, 23, '0', 2015, 4),
(203, 23, '0', 2015, 5),
(204, 23, '0', 2015, 6),
(205, 23, '0', 2015, 7),
(206, 23, '0', 2015, 8),
(207, 23, '0', 2015, 9),
(208, 24, '2354', 2015, 1),
(209, 24, '0', 2015, 2),
(210, 24, '0', 2015, 3),
(211, 24, '0', 2015, 4),
(212, 24, '0', 2015, 5),
(213, 24, '0', 2015, 6),
(214, 24, '0', 2015, 7),
(215, 24, '0', 2015, 8),
(216, 24, '0', 2015, 9),
(217, 25, '5796', 2015, 1),
(218, 25, '0', 2015, 2),
(219, 25, '0', 2015, 3),
(220, 25, '0', 2015, 4),
(221, 25, '0', 2015, 5),
(222, 25, '0', 2015, 6),
(223, 25, '0', 2015, 7),
(224, 25, '0', 2015, 8),
(225, 25, '0', 2015, 9),
(226, 26, '670', 2015, 1),
(227, 26, '0', 2015, 2),
(228, 26, '0', 2015, 3),
(229, 26, '0', 2015, 4),
(230, 26, '0', 2015, 5),
(231, 26, '0', 2015, 6),
(232, 26, '0', 2015, 7),
(233, 26, '0', 2015, 8),
(234, 26, '0', 2015, 9),
(235, 27, '8101', 2015, 1),
(236, 27, '0', 2015, 2),
(237, 27, '0', 2015, 3),
(238, 27, '0', 2015, 4),
(239, 27, '0', 2015, 5),
(240, 27, '0', 2015, 6),
(241, 27, '0', 2015, 7),
(242, 27, '0', 2015, 8),
(243, 27, '0', 2015, 9),
(244, 28, '0', 2015, 1),
(245, 28, '217', 2015, 2),
(246, 28, '983', 2015, 3),
(247, 28, '0', 2015, 4),
(248, 28, '15', 2015, 5),
(249, 28, '0', 2015, 6),
(250, 28, '0', 2015, 7),
(251, 28, '0', 2015, 8),
(252, 28, '0', 2015, 9),
(253, 29, '0', 2015, 1),
(254, 29, '476', 2015, 2),
(255, 29, '983', 2015, 3),
(256, 29, '0', 2015, 4),
(257, 29, '0', 2015, 5),
(258, 29, '0', 2015, 6),
(259, 29, '0', 2015, 7),
(260, 29, '0', 2015, 8),
(261, 29, '0', 2015, 9),
(262, 30, '0', 2015, 1),
(263, 30, '1941', 2015, 2),
(264, 30, '2949', 2015, 3),
(265, 30, '0', 2015, 4),
(266, 30, '0', 2015, 5),
(267, 30, '0', 2015, 6),
(268, 30, '0', 2015, 7),
(269, 30, '0', 2015, 8),
(270, 30, '0', 2015, 9);

-- --------------------------------------------------------

--
-- Structure de la table `InformationsCollectiviteListe`
--

CREATE TABLE `InformationsCollectiviteListe` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `LigneCommande`
--

CREATE TABLE `LigneCommande` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `tva_id` int(11) NOT NULL,
  `Libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Quantite` int(11) NOT NULL,
  `Prix_Unitaire` decimal(10,2) NOT NULL,
  `Total_TTC` decimal(10,2) NOT NULL,
  `Commentaire` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `LigneCommande`
--

INSERT INTO `LigneCommande` (`id`, `commande_id`, `tva_id`, `Libelle`, `Reference`, `Quantite`, `Prix_Unitaire`, `Total_TTC`, `Commentaire`) VALUES
(5, 7, 3, 'libelle', 'ref1', 123, '37.00', '4801.30', 'com'),
(6, 8, 4, 'libelle', 'erf', 12, '34837.23', '447310.03', 'com'),
(7, 9, 3, 'li', 'refg', 87, '65.00', '5966.02', 'com'),
(8, 10, 2, 'li', 'def', 43, '123.00', '5400.07', '-');

-- --------------------------------------------------------

--
-- Structure de la table `ListeActivites`
--

CREATE TABLE `ListeActivites` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeApplications`
--

CREATE TABLE `ListeApplications` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeBudgets`
--

CREATE TABLE `ListeBudgets` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeClesRepartition`
--

CREATE TABLE `ListeClesRepartition` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeCollectivites`
--

CREATE TABLE `ListeCollectivites` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeForfaits`
--

CREATE TABLE `ListeForfaits` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeImputations`
--

CREATE TABLE `ListeImputations` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeMassesSalariales`
--

CREATE TABLE `ListeMassesSalariales` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeServices`
--

CREATE TABLE `ListeServices` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeTempsPasses`
--

CREATE TABLE `ListeTempsPasses` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ListeUtilisateurs`
--

CREATE TABLE `ListeUtilisateurs` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Livraison`
--

CREATE TABLE `Livraison` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Complement_Adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Code_Postal` int(11) NOT NULL,
  `Ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Livraison`
--

INSERT INTO `Livraison` (`id`, `Nom`, `Adresse`, `Complement_Adresse`, `Code_Postal`, `Ville`, `Telephone`, `Fax`) VALUES
(1, 'Lieu livraison test', '50 Rue Sainte-Catherine', '4eme étage', 54000, 'Nancy', '0383121212', NULL),
(2, 'Lieu livraison test2', '50 Rue Sainte-Catherine', '4eme étage', 54000, 'Nancy', '0383121212', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `MasseSalariale`
--

CREATE TABLE `MasseSalariale` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `Montant` int(11) NOT NULL,
  `Annee` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `MasseSalariale`
--

INSERT INTO `MasseSalariale` (`id`, `service_id`, `Montant`, `Annee`) VALUES
(4, 1, 10000, 2015),
(5, 3, 20000, 2015),
(6, 2, 30000, 2015);

-- --------------------------------------------------------

--
-- Structure de la table `PaiementCommande`
--

CREATE TABLE `PaiementCommande` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `DatePaiement` datetime NOT NULL,
  `Montant` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `PaiementCommande`
--

INSERT INTO `PaiementCommande` (`id`, `commande_id`, `DatePaiement`, `Montant`) VALUES
(22, 7, '2015-07-31 11:17:42', '4791.3'),
(23, 8, '2015-08-03 12:37:16', '10'),
(24, 9, '2015-08-03 12:52:56', '10'),
(25, 10, '2015-08-03 13:09:24', '10');

-- --------------------------------------------------------

--
-- Structure de la table `Service`
--

CREATE TABLE `Service` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Est_Ancien_Service` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Service`
--

INSERT INTO `Service` (`id`, `Nom`, `Est_Ancien_Service`) VALUES
(1, 'Bureautique', 0),
(2, 'Infrastructure', 0),
(3, 'Etude', 0),
(4, 'SIG', 0),
(5, 'Cyberbase', 0);

-- --------------------------------------------------------

--
-- Structure de la table `TempsPasse`
--

CREATE TABLE `TempsPasse` (
  `id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `collectivite_id` int(11) NOT NULL,
  `Pourcentage` int(11) NOT NULL,
  `Annee` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=541 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `TempsPasse`
--

INSERT INTO `TempsPasse` (`id`, `activite_id`, `collectivite_id`, `Pourcentage`, `Annee`) VALUES
(1, 1, 20, 0, 2015),
(2, 2, 20, 0, 2015),
(3, 3, 20, 0, 2015),
(4, 4, 20, 0, 2015),
(5, 5, 20, 0, 2015),
(6, 6, 20, 0, 2015),
(7, 7, 20, 0, 2015),
(8, 8, 20, 0, 2015),
(9, 9, 20, 0, 2015),
(10, 10, 20, 0, 2015),
(11, 11, 20, 0, 2015),
(12, 12, 20, 0, 2015),
(13, 13, 20, 0, 2015),
(14, 14, 20, 0, 2015),
(15, 15, 20, 0, 2015),
(16, 16, 20, 0, 2015),
(17, 17, 20, 0, 2015),
(18, 18, 20, 0, 2015),
(19, 1, 29, 0, 2015),
(20, 2, 29, 0, 2015),
(21, 3, 29, 0, 2015),
(22, 4, 29, 0, 2015),
(23, 5, 29, 0, 2015),
(24, 6, 29, 0, 2015),
(25, 7, 29, 0, 2015),
(26, 8, 29, 0, 2015),
(27, 9, 29, 0, 2015),
(28, 10, 29, 0, 2015),
(29, 11, 29, 0, 2015),
(30, 12, 29, 0, 2015),
(31, 13, 29, 0, 2015),
(32, 14, 29, 0, 2015),
(33, 15, 29, 0, 2015),
(34, 16, 29, 0, 2015),
(35, 17, 29, 0, 2015),
(36, 18, 29, 0, 2015),
(37, 1, 16, 0, 2015),
(38, 2, 16, 0, 2015),
(39, 3, 16, 0, 2015),
(40, 4, 16, 0, 2015),
(41, 5, 16, 0, 2015),
(42, 6, 16, 0, 2015),
(43, 7, 16, 0, 2015),
(44, 8, 16, 0, 2015),
(45, 9, 16, 0, 2015),
(46, 10, 16, 0, 2015),
(47, 11, 16, 0, 2015),
(48, 12, 16, 0, 2015),
(49, 13, 16, 0, 2015),
(50, 14, 16, 0, 2015),
(51, 15, 16, 0, 2015),
(52, 16, 16, 0, 2015),
(53, 17, 16, 0, 2015),
(54, 18, 16, 0, 2015),
(55, 1, 28, 0, 2015),
(56, 2, 28, 0, 2015),
(57, 3, 28, 0, 2015),
(58, 4, 28, 0, 2015),
(59, 5, 28, 0, 2015),
(60, 6, 28, 0, 2015),
(61, 7, 28, 0, 2015),
(62, 8, 28, 0, 2015),
(63, 9, 28, 0, 2015),
(64, 10, 28, 0, 2015),
(65, 11, 28, 0, 2015),
(66, 12, 28, 0, 2015),
(67, 13, 28, 0, 2015),
(68, 14, 28, 0, 2015),
(69, 15, 28, 0, 2015),
(70, 16, 28, 0, 2015),
(71, 17, 28, 0, 2015),
(72, 18, 28, 0, 2015),
(73, 1, 18, 0, 2015),
(74, 2, 18, 0, 2015),
(75, 3, 18, 0, 2015),
(76, 4, 18, 0, 2015),
(77, 5, 18, 0, 2015),
(78, 6, 18, 0, 2015),
(79, 7, 18, 0, 2015),
(80, 8, 18, 0, 2015),
(81, 9, 18, 0, 2015),
(82, 10, 18, 0, 2015),
(83, 11, 18, 0, 2015),
(84, 12, 18, 0, 2015),
(85, 13, 18, 0, 2015),
(86, 14, 18, 0, 2015),
(87, 15, 18, 0, 2015),
(88, 16, 18, 0, 2015),
(89, 17, 18, 0, 2015),
(90, 18, 18, 50, 2015),
(91, 1, 5, 0, 2015),
(92, 2, 5, 0, 2015),
(93, 3, 5, 0, 2015),
(94, 4, 5, 0, 2015),
(95, 5, 5, 0, 2015),
(96, 6, 5, 0, 2015),
(97, 7, 5, 0, 2015),
(98, 8, 5, 0, 2015),
(99, 9, 5, 0, 2015),
(100, 10, 5, 0, 2015),
(101, 11, 5, 0, 2015),
(102, 12, 5, 0, 2015),
(103, 13, 5, 0, 2015),
(104, 14, 5, 0, 2015),
(105, 15, 5, 0, 2015),
(106, 16, 5, 0, 2015),
(107, 17, 5, 0, 2015),
(108, 18, 5, 0, 2015),
(109, 1, 25, 0, 2015),
(110, 2, 25, 0, 2015),
(111, 3, 25, 0, 2015),
(112, 4, 25, 0, 2015),
(113, 5, 25, 0, 2015),
(114, 6, 25, 0, 2015),
(115, 7, 25, 0, 2015),
(116, 8, 25, 0, 2015),
(117, 9, 25, 0, 2015),
(118, 10, 25, 0, 2015),
(119, 11, 25, 0, 2015),
(120, 12, 25, 0, 2015),
(121, 13, 25, 0, 2015),
(122, 14, 25, 0, 2015),
(123, 15, 25, 0, 2015),
(124, 16, 25, 0, 2015),
(125, 17, 25, 0, 2015),
(126, 18, 25, 0, 2015),
(127, 1, 24, 0, 2015),
(128, 2, 24, 0, 2015),
(129, 3, 24, 0, 2015),
(130, 4, 24, 0, 2015),
(131, 5, 24, 0, 2015),
(132, 6, 24, 0, 2015),
(133, 7, 24, 0, 2015),
(134, 8, 24, 0, 2015),
(135, 9, 24, 0, 2015),
(136, 10, 24, 0, 2015),
(137, 11, 24, 0, 2015),
(138, 12, 24, 0, 2015),
(139, 13, 24, 0, 2015),
(140, 14, 24, 0, 2015),
(141, 15, 24, 0, 2015),
(142, 16, 24, 0, 2015),
(143, 17, 24, 0, 2015),
(144, 18, 24, 0, 2015),
(145, 1, 4, 0, 2015),
(146, 2, 4, 0, 2015),
(147, 3, 4, 0, 2015),
(148, 4, 4, 0, 2015),
(149, 5, 4, 0, 2015),
(150, 6, 4, 0, 2015),
(151, 7, 4, 0, 2015),
(152, 8, 4, 0, 2015),
(153, 9, 4, 0, 2015),
(154, 10, 4, 0, 2015),
(155, 11, 4, 0, 2015),
(156, 12, 4, 0, 2015),
(157, 13, 4, 0, 2015),
(158, 14, 4, 0, 2015),
(159, 15, 4, 0, 2015),
(160, 16, 4, 0, 2015),
(161, 17, 4, 0, 2015),
(162, 18, 4, 0, 2015),
(163, 1, 26, 0, 2015),
(164, 2, 26, 0, 2015),
(165, 3, 26, 0, 2015),
(166, 4, 26, 0, 2015),
(167, 5, 26, 0, 2015),
(168, 6, 26, 0, 2015),
(169, 7, 26, 0, 2015),
(170, 8, 26, 0, 2015),
(171, 9, 26, 0, 2015),
(172, 10, 26, 0, 2015),
(173, 11, 26, 0, 2015),
(174, 12, 26, 0, 2015),
(175, 13, 26, 0, 2015),
(176, 14, 26, 0, 2015),
(177, 15, 26, 0, 2015),
(178, 16, 26, 0, 2015),
(179, 17, 26, 0, 2015),
(180, 18, 26, 0, 2015),
(181, 1, 23, 0, 2015),
(182, 2, 23, 0, 2015),
(183, 3, 23, 0, 2015),
(184, 4, 23, 0, 2015),
(185, 5, 23, 0, 2015),
(186, 6, 23, 0, 2015),
(187, 7, 23, 0, 2015),
(188, 8, 23, 0, 2015),
(189, 9, 23, 0, 2015),
(190, 10, 23, 0, 2015),
(191, 11, 23, 0, 2015),
(192, 12, 23, 0, 2015),
(193, 13, 23, 0, 2015),
(194, 14, 23, 0, 2015),
(195, 15, 23, 0, 2015),
(196, 16, 23, 0, 2015),
(197, 17, 23, 0, 2015),
(198, 18, 23, 0, 2015),
(199, 1, 6, 0, 2015),
(200, 2, 6, 0, 2015),
(201, 3, 6, 0, 2015),
(202, 4, 6, 0, 2015),
(203, 5, 6, 0, 2015),
(204, 6, 6, 0, 2015),
(205, 7, 6, 0, 2015),
(206, 8, 6, 0, 2015),
(207, 9, 6, 0, 2015),
(208, 10, 6, 0, 2015),
(209, 11, 6, 0, 2015),
(210, 12, 6, 0, 2015),
(211, 13, 6, 0, 2015),
(212, 14, 6, 0, 2015),
(213, 15, 6, 0, 2015),
(214, 16, 6, 0, 2015),
(215, 17, 6, 0, 2015),
(216, 18, 6, 0, 2015),
(217, 1, 11, 0, 2015),
(218, 2, 11, 0, 2015),
(219, 3, 11, 0, 2015),
(220, 4, 11, 0, 2015),
(221, 5, 11, 0, 2015),
(222, 6, 11, 0, 2015),
(223, 7, 11, 0, 2015),
(224, 8, 11, 0, 2015),
(225, 9, 11, 0, 2015),
(226, 10, 11, 0, 2015),
(227, 11, 11, 0, 2015),
(228, 12, 11, 0, 2015),
(229, 13, 11, 0, 2015),
(230, 14, 11, 0, 2015),
(231, 15, 11, 0, 2015),
(232, 16, 11, 0, 2015),
(233, 17, 11, 0, 2015),
(234, 18, 11, 0, 2015),
(235, 1, 7, 0, 2015),
(236, 2, 7, 0, 2015),
(237, 3, 7, 0, 2015),
(238, 4, 7, 0, 2015),
(239, 5, 7, 0, 2015),
(240, 6, 7, 0, 2015),
(241, 7, 7, 0, 2015),
(242, 8, 7, 0, 2015),
(243, 9, 7, 0, 2015),
(244, 10, 7, 0, 2015),
(245, 11, 7, 0, 2015),
(246, 12, 7, 0, 2015),
(247, 13, 7, 0, 2015),
(248, 14, 7, 0, 2015),
(249, 15, 7, 0, 2015),
(250, 16, 7, 0, 2015),
(251, 17, 7, 0, 2015),
(252, 18, 7, 0, 2015),
(253, 1, 12, 0, 2015),
(254, 2, 12, 0, 2015),
(255, 3, 12, 0, 2015),
(256, 4, 12, 0, 2015),
(257, 5, 12, 0, 2015),
(258, 6, 12, 0, 2015),
(259, 7, 12, 0, 2015),
(260, 8, 12, 0, 2015),
(261, 9, 12, 0, 2015),
(262, 10, 12, 0, 2015),
(263, 11, 12, 0, 2015),
(264, 12, 12, 0, 2015),
(265, 13, 12, 0, 2015),
(266, 14, 12, 0, 2015),
(267, 15, 12, 0, 2015),
(268, 16, 12, 0, 2015),
(269, 17, 12, 0, 2015),
(270, 18, 12, 0, 2015),
(271, 1, 8, 0, 2015),
(272, 2, 8, 0, 2015),
(273, 3, 8, 0, 2015),
(274, 4, 8, 0, 2015),
(275, 5, 8, 0, 2015),
(276, 6, 8, 0, 2015),
(277, 7, 8, 0, 2015),
(278, 8, 8, 0, 2015),
(279, 9, 8, 0, 2015),
(280, 10, 8, 0, 2015),
(281, 11, 8, 0, 2015),
(282, 12, 8, 0, 2015),
(283, 13, 8, 0, 2015),
(284, 14, 8, 0, 2015),
(285, 15, 8, 0, 2015),
(286, 16, 8, 0, 2015),
(287, 17, 8, 0, 2015),
(288, 18, 8, 0, 2015),
(289, 1, 13, 0, 2015),
(290, 2, 13, 0, 2015),
(291, 3, 13, 0, 2015),
(292, 4, 13, 0, 2015),
(293, 5, 13, 0, 2015),
(294, 6, 13, 0, 2015),
(295, 7, 13, 0, 2015),
(296, 8, 13, 0, 2015),
(297, 9, 13, 0, 2015),
(298, 10, 13, 0, 2015),
(299, 11, 13, 0, 2015),
(300, 12, 13, 0, 2015),
(301, 13, 13, 0, 2015),
(302, 14, 13, 0, 2015),
(303, 15, 13, 0, 2015),
(304, 16, 13, 0, 2015),
(305, 17, 13, 0, 2015),
(306, 18, 13, 0, 2015),
(307, 1, 2, 0, 2015),
(308, 2, 2, 0, 2015),
(309, 3, 2, 0, 2015),
(310, 4, 2, 0, 2015),
(311, 5, 2, 0, 2015),
(312, 6, 2, 0, 2015),
(313, 7, 2, 0, 2015),
(314, 8, 2, 0, 2015),
(315, 9, 2, 0, 2015),
(316, 10, 2, 0, 2015),
(317, 11, 2, 0, 2015),
(318, 12, 2, 0, 2015),
(319, 13, 2, 0, 2015),
(320, 14, 2, 0, 2015),
(321, 15, 2, 0, 2015),
(322, 16, 2, 0, 2015),
(323, 17, 2, 0, 2015),
(324, 18, 2, 0, 2015),
(325, 1, 14, 0, 2015),
(326, 2, 14, 0, 2015),
(327, 3, 14, 0, 2015),
(328, 4, 14, 0, 2015),
(329, 5, 14, 0, 2015),
(330, 6, 14, 0, 2015),
(331, 7, 14, 0, 2015),
(332, 8, 14, 0, 2015),
(333, 9, 14, 0, 2015),
(334, 10, 14, 0, 2015),
(335, 11, 14, 0, 2015),
(336, 12, 14, 0, 2015),
(337, 13, 14, 0, 2015),
(338, 14, 14, 0, 2015),
(339, 15, 14, 0, 2015),
(340, 16, 14, 0, 2015),
(341, 17, 14, 0, 2015),
(342, 18, 14, 0, 2015),
(343, 1, 9, 0, 2015),
(344, 2, 9, 0, 2015),
(345, 3, 9, 0, 2015),
(346, 4, 9, 0, 2015),
(347, 5, 9, 0, 2015),
(348, 6, 9, 0, 2015),
(349, 7, 9, 0, 2015),
(350, 8, 9, 0, 2015),
(351, 9, 9, 0, 2015),
(352, 10, 9, 0, 2015),
(353, 11, 9, 0, 2015),
(354, 12, 9, 0, 2015),
(355, 13, 9, 0, 2015),
(356, 14, 9, 0, 2015),
(357, 15, 9, 0, 2015),
(358, 16, 9, 0, 2015),
(359, 17, 9, 0, 2015),
(360, 18, 9, 0, 2015),
(361, 1, 15, 0, 2015),
(362, 2, 15, 0, 2015),
(363, 3, 15, 0, 2015),
(364, 4, 15, 0, 2015),
(365, 5, 15, 0, 2015),
(366, 6, 15, 0, 2015),
(367, 7, 15, 0, 2015),
(368, 8, 15, 0, 2015),
(369, 9, 15, 0, 2015),
(370, 10, 15, 0, 2015),
(371, 11, 15, 0, 2015),
(372, 12, 15, 0, 2015),
(373, 13, 15, 0, 2015),
(374, 14, 15, 0, 2015),
(375, 15, 15, 0, 2015),
(376, 16, 15, 0, 2015),
(377, 17, 15, 0, 2015),
(378, 18, 15, 0, 2015),
(379, 1, 10, 0, 2015),
(380, 2, 10, 0, 2015),
(381, 3, 10, 0, 2015),
(382, 4, 10, 0, 2015),
(383, 5, 10, 0, 2015),
(384, 6, 10, 0, 2015),
(385, 7, 10, 0, 2015),
(386, 8, 10, 0, 2015),
(387, 9, 10, 0, 2015),
(388, 10, 10, 0, 2015),
(389, 11, 10, 0, 2015),
(390, 12, 10, 0, 2015),
(391, 13, 10, 0, 2015),
(392, 14, 10, 0, 2015),
(393, 15, 10, 0, 2015),
(394, 16, 10, 0, 2015),
(395, 17, 10, 0, 2015),
(396, 18, 10, 0, 2015),
(397, 1, 27, 0, 2015),
(398, 2, 27, 0, 2015),
(399, 3, 27, 0, 2015),
(400, 4, 27, 0, 2015),
(401, 5, 27, 0, 2015),
(402, 6, 27, 0, 2015),
(403, 7, 27, 0, 2015),
(404, 8, 27, 0, 2015),
(405, 9, 27, 0, 2015),
(406, 10, 27, 0, 2015),
(407, 11, 27, 0, 2015),
(408, 12, 27, 0, 2015),
(409, 13, 27, 0, 2015),
(410, 14, 27, 0, 2015),
(411, 15, 27, 0, 2015),
(412, 16, 27, 0, 2015),
(413, 17, 27, 0, 2015),
(414, 18, 27, 0, 2015),
(415, 1, 3, 0, 2015),
(416, 2, 3, 0, 2015),
(417, 3, 3, 0, 2015),
(418, 4, 3, 0, 2015),
(419, 5, 3, 0, 2015),
(420, 6, 3, 0, 2015),
(421, 7, 3, 0, 2015),
(422, 8, 3, 0, 2015),
(423, 9, 3, 0, 2015),
(424, 10, 3, 50, 2015),
(425, 11, 3, 0, 2015),
(426, 12, 3, 0, 2015),
(427, 13, 3, 0, 2015),
(428, 14, 3, 0, 2015),
(429, 15, 3, 0, 2015),
(430, 16, 3, 0, 2015),
(431, 17, 3, 0, 2015),
(432, 18, 3, 0, 2015),
(433, 1, 19, 0, 2015),
(434, 2, 19, 0, 2015),
(435, 3, 19, 0, 2015),
(436, 4, 19, 0, 2015),
(437, 5, 19, 0, 2015),
(438, 6, 19, 0, 2015),
(439, 7, 19, 0, 2015),
(440, 8, 19, 0, 2015),
(441, 9, 19, 0, 2015),
(442, 10, 19, 0, 2015),
(443, 11, 19, 0, 2015),
(444, 12, 19, 0, 2015),
(445, 13, 19, 0, 2015),
(446, 14, 19, 0, 2015),
(447, 15, 19, 0, 2015),
(448, 16, 19, 0, 2015),
(449, 17, 19, 0, 2015),
(450, 18, 19, 0, 2015),
(451, 1, 30, 0, 2015),
(452, 2, 30, 0, 2015),
(453, 3, 30, 0, 2015),
(454, 4, 30, 0, 2015),
(455, 5, 30, 0, 2015),
(456, 6, 30, 0, 2015),
(457, 7, 30, 0, 2015),
(458, 8, 30, 0, 2015),
(459, 9, 30, 0, 2015),
(460, 10, 30, 0, 2015),
(461, 11, 30, 0, 2015),
(462, 12, 30, 0, 2015),
(463, 13, 30, 0, 2015),
(464, 14, 30, 0, 2015),
(465, 15, 30, 0, 2015),
(466, 16, 30, 0, 2015),
(467, 17, 30, 0, 2015),
(468, 18, 30, 0, 2015),
(469, 1, 1, 0, 2015),
(470, 2, 1, 0, 2015),
(471, 3, 1, 0, 2015),
(472, 4, 1, 0, 2015),
(473, 5, 1, 0, 2015),
(474, 6, 1, 0, 2015),
(475, 7, 1, 0, 2015),
(476, 8, 1, 0, 2015),
(477, 9, 1, 0, 2015),
(478, 10, 1, 0, 2015),
(479, 11, 1, 0, 2015),
(480, 12, 1, 0, 2015),
(481, 13, 1, 0, 2015),
(482, 14, 1, 0, 2015),
(483, 15, 1, 0, 2015),
(484, 16, 1, 0, 2015),
(485, 17, 1, 0, 2015),
(486, 18, 1, 0, 2015),
(487, 1, 22, 0, 2015),
(488, 2, 22, 0, 2015),
(489, 3, 22, 0, 2015),
(490, 4, 22, 0, 2015),
(491, 5, 22, 0, 2015),
(492, 6, 22, 0, 2015),
(493, 7, 22, 0, 2015),
(494, 8, 22, 0, 2015),
(495, 9, 22, 0, 2015),
(496, 10, 22, 0, 2015),
(497, 11, 22, 0, 2015),
(498, 12, 22, 0, 2015),
(499, 13, 22, 0, 2015),
(500, 14, 22, 0, 2015),
(501, 15, 22, 0, 2015),
(502, 16, 22, 0, 2015),
(503, 17, 22, 0, 2015),
(504, 18, 22, 0, 2015),
(505, 1, 17, 0, 2015),
(506, 2, 17, 0, 2015),
(507, 3, 17, 0, 2015),
(508, 4, 17, 0, 2015),
(509, 5, 17, 0, 2015),
(510, 6, 17, 0, 2015),
(511, 7, 17, 0, 2015),
(512, 8, 17, 0, 2015),
(513, 9, 17, 0, 2015),
(514, 10, 17, 0, 2015),
(515, 11, 17, 0, 2015),
(516, 12, 17, 0, 2015),
(517, 13, 17, 0, 2015),
(518, 14, 17, 0, 2015),
(519, 15, 17, 0, 2015),
(520, 16, 17, 0, 2015),
(521, 17, 17, 0, 2015),
(522, 18, 17, 0, 2015),
(523, 1, 21, 0, 2015),
(524, 2, 21, 0, 2015),
(525, 3, 21, 0, 2015),
(526, 4, 21, 0, 2015),
(527, 5, 21, 0, 2015),
(528, 6, 21, 0, 2015),
(529, 7, 21, 0, 2015),
(530, 8, 21, 0, 2015),
(531, 9, 21, 0, 2015),
(532, 10, 21, 0, 2015),
(533, 11, 21, 0, 2015),
(534, 12, 21, 0, 2015),
(535, 13, 21, 0, 2015),
(536, 14, 21, 0, 2015),
(537, 15, 21, 0, 2015),
(538, 16, 21, 0, 2015),
(539, 17, 21, 0, 2015),
(540, 18, 21, 0, 2015);

-- --------------------------------------------------------

--
-- Structure de la table `TVA`
--

CREATE TABLE `TVA` (
  `id` int(11) NOT NULL,
  `pourcentage` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `Utilisateur` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `expired` tinyint(1) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) DEFAULT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `service_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `Nom`, `Prenom`) VALUES
(49, 2, 'testA', 'testa', 'a@a.fr', 'a@a.fr', 1, '', 'mdp', '2015-08-03 08:02:27', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, 'nomA', 'prenomA'),
(50, 3, 'testC', 'testc', 't@f.fr', 't@f.fr', 1, '', 'mdp', '2015-07-21 15:10:12', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_COMPTA";}', 0, NULL, 'nomC', 'prenomC');

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
-- Index pour la table `bug`
--
ALTER TABLE `bug`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_DC1F9F43DA5256D` (`image_id`);

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
-- Index pour la table `forfait`
--
ALTER TABLE `forfait`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7408FD1EA7991F51` (`collectivite_id`),
  ADD KEY `IDX_7408FD1E3E030ACD` (`application_id`);

--
-- Index pour la table `Fournisseur`
--
ALTER TABLE `Fournisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Image`
--
ALTER TABLE `Image`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Imputation`
--
ALTER TABLE `Imputation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ImputationConcerneBudget`
--
ALTER TABLE `ImputationConcerneBudget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DD96CBFF1E40325` (`imputation_id`),
  ADD KEY `IDX_DD96CBFF36ABA6B8` (`budget_id`);

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
-- Index pour la table `ListeActivites`
--
ALTER TABLE `ListeActivites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeApplications`
--
ALTER TABLE `ListeApplications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeBudgets`
--
ALTER TABLE `ListeBudgets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeClesRepartition`
--
ALTER TABLE `ListeClesRepartition`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeCollectivites`
--
ALTER TABLE `ListeCollectivites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeForfaits`
--
ALTER TABLE `ListeForfaits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeImputations`
--
ALTER TABLE `ListeImputations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeMassesSalariales`
--
ALTER TABLE `ListeMassesSalariales`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeServices`
--
ALTER TABLE `ListeServices`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeTempsPasses`
--
ALTER TABLE `ListeTempsPasses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ListeUtilisateurs`
--
ALTER TABLE `ListeUtilisateurs`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `IDX_57DE69C1ED5CA9E6` (`service_id`);

--
-- Index pour la table `PaiementCommande`
--
ALTER TABLE `PaiementCommande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E9D1EEDA82EA2E54` (`commande_id`);

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
  ADD UNIQUE KEY `UNIQ_9B80EC6492FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_9B80EC64A0D96FBF` (`email_canonical`),
  ADD KEY `IDX_9B80EC64ED5CA9E6` (`service_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Activite`
--
ALTER TABLE `Activite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `Application`
--
ALTER TABLE `Application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT pour la table `Budget`
--
ALTER TABLE `Budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `bug`
--
ALTER TABLE `bug`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `CleRepartition`
--
ALTER TABLE `CleRepartition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `Collectivite`
--
ALTER TABLE `Collectivite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `CommandeConcerneCollectivite`
--
ALTER TABLE `CommandeConcerneCollectivite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=159;
--
-- AUTO_INCREMENT pour la table `CommandePasseEtat`
--
ALTER TABLE `CommandePasseEtat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT pour la table `EtatCommande`
--
ALTER TABLE `EtatCommande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `forfait`
--
ALTER TABLE `forfait`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `Fournisseur`
--
ALTER TABLE `Fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Image`
--
ALTER TABLE `Image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Imputation`
--
ALTER TABLE `Imputation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT pour la table `ImputationConcerneBudget`
--
ALTER TABLE `ImputationConcerneBudget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `InformationCollectivite`
--
ALTER TABLE `InformationCollectivite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=271;
--
-- AUTO_INCREMENT pour la table `InformationsCollectiviteListe`
--
ALTER TABLE `InformationsCollectiviteListe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `LigneCommande`
--
ALTER TABLE `LigneCommande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `ListeActivites`
--
ALTER TABLE `ListeActivites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeApplications`
--
ALTER TABLE `ListeApplications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeBudgets`
--
ALTER TABLE `ListeBudgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeClesRepartition`
--
ALTER TABLE `ListeClesRepartition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeCollectivites`
--
ALTER TABLE `ListeCollectivites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeForfaits`
--
ALTER TABLE `ListeForfaits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeImputations`
--
ALTER TABLE `ListeImputations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeMassesSalariales`
--
ALTER TABLE `ListeMassesSalariales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeServices`
--
ALTER TABLE `ListeServices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeTempsPasses`
--
ALTER TABLE `ListeTempsPasses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ListeUtilisateurs`
--
ALTER TABLE `ListeUtilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Livraison`
--
ALTER TABLE `Livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `MasseSalariale`
--
ALTER TABLE `MasseSalariale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `PaiementCommande`
--
ALTER TABLE `PaiementCommande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `Service`
--
ALTER TABLE `Service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `TempsPasse`
--
ALTER TABLE `TempsPasse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=541;
--
-- AUTO_INCREMENT pour la table `TVA`
--
ALTER TABLE `TVA`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
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
-- Contraintes pour la table `bug`
--
ALTER TABLE `bug`
  ADD CONSTRAINT `FK_DC1F9F43DA5256D` FOREIGN KEY (`image_id`) REFERENCES `Image` (`id`);

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
-- Contraintes pour la table `forfait`
--
ALTER TABLE `forfait`
  ADD CONSTRAINT `FK_7408FD1E3E030ACD` FOREIGN KEY (`application_id`) REFERENCES `Application` (`id`),
  ADD CONSTRAINT `FK_7408FD1EA7991F51` FOREIGN KEY (`collectivite_id`) REFERENCES `Collectivite` (`id`);

--
-- Contraintes pour la table `ImputationConcerneBudget`
--
ALTER TABLE `ImputationConcerneBudget`
  ADD CONSTRAINT `FK_DD96CBFF1E40325` FOREIGN KEY (`imputation_id`) REFERENCES `Imputation` (`id`),
  ADD CONSTRAINT `FK_DD96CBFF36ABA6B8` FOREIGN KEY (`budget_id`) REFERENCES `Budget` (`id`);

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
  ADD CONSTRAINT `FK_57DE69C1ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `Service` (`id`);

--
-- Contraintes pour la table `PaiementCommande`
--
ALTER TABLE `PaiementCommande`
  ADD CONSTRAINT `FK_E9D1EEDA82EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `Commande` (`id`);

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
