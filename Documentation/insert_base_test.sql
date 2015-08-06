-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Jeu 06 Août 2015 à 16:39
-- Version du serveur :  5.5.42
-- Version de PHP :  5.4.42

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `facturation`
--


--
-- Contenu de la table `Fournisseur`
--

INSERT INTO `Fournisseur` (`id`, `Nom`, `Adresse`, `Complement_Adresse`, `Code_Postal`, `Ville`, `Telephone`, `Fax`, `Contact`, `EmailContact`) VALUES
(1, 'Fournisseur test', '10 Rue du Pont', '2ème étage', 5400, 'Nancy', '0383090909', NULL, NULL, NULL);


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



--
-- Contenu de la table `EtatCommande`
--

INSERT INTO `EtatCommande` (`id`, `Libelle`) VALUES
(1, 'Creee'),
(2, 'Enregistree'),
(3, 'Engagee'),
(4, 'Paiement'),
(5, 'Terminee'),
(6, 'Supprimee');




--
-- Contenu de la table `Imputation`
--

INSERT INTO `Imputation` (`id`, `Libelle`, `Sous_fonction`, `Article`, `Section`, `Est_Facture`) VALUES
(1, 'Cotisation ville-internet', '90.14', '6281,63', 'Fonctionnement', 1),
(2, 'Cotisation mission Ecoter', '90.14', '6281.57', 'Fonctionnement', 1),
(3, 'Cotisation Avicca', '90.14', '6281.56', 'Fonctionnement', 1),
(4, 'Divers Travaux', '90.14', '2318-360', 'Investissement', 1),
(5, 'Divers Travaux', '90.14', '2318-496', 'Investissement', 1),
(6, 'Logiciels-  Piscines', '413', '205', 'Investissement', 1),
(7, 'Matériels -Piscines', '413', '2183', 'Investissement', 1),
(8, 'Eau : Participations (HT)', '01', '13918', 'Investissement', 1),
(9, 'Eau : Logiciels (HT)', '01', '205', 'Investissement', 1),
(10, 'Eau : Matériels (HT)', '01', '2183', 'Investissement', 1),
(11, 'Eau : Instal.,outillages tech.et travaux  (HT)', '01', '2315', 'Investissement', 1),
(12, 'Eau : Prestations de service (HT)', '01', '618.8', 'Fonctionnement', 1),
(13, 'Eau : Maintenance (HT)', '01', '6156', 'Fonctionnement', 1),
(14, 'Eau : Frais de telecom (HT)', '01', '6262', 'Fonctionnement', 1),
(15, 'Ass. : Participations (HT)', '02', '13918', 'Investissement', 1),
(16, 'Ass : Logiciels (HT)', '02', '205', 'Investissement', 1),
(17, 'Ass : Matériels (HT)', '02', '2183', 'Investissement', 1),
(18, 'Ass : Instal.,outillages tech.et travaux  (HT)', '02', '2315', 'Investissement', 1),
(19, 'Ass : Prestations de service (HT)', '02', '618.8', 'Fonctionnement', 1),
(20, 'Ass : Maintenance (HT)', '02', '6156', 'Fonctionnement', 1),
(21, 'Ass : Frais de telecom (HT)', '02', '6262', 'Fonctionnement', 1),
(22, 'Maintenance logiciels piscines', '413', '6156', 'Fonctionnement', 1),
(23, 'Maintenance des logiciels', '020.3', '6156', 'Fonctionnement', 1),
(24, 'Formations', '020.3', '6184', 'Fonctionnement', 1),
(25, 'Prestations de service', '020.3', '6188', 'Fonctionnement', 1),
(26, 'Annonces et insertions', '020.3', '6231', 'Fonctionnement', 1),
(27, 'Frais de Telecommunication', '020.3', '6262', 'Fonctionnement', 1),
(28, 'Autres fournitures- Achat de billet', '020.3', '60228', 'Fonctionnement', 1),
(29, 'Fournitures petit équipement', '020.3', '60632', 'Fonctionnement', 1),
(30, 'Cotisation "club utilisateur Coriolis"', '020.3', '6281.58', 'Fonctionnement', 1),
(31, 'Remboursement de frais au Ciril', '020.3', '62878.3', 'Fonctionnement', 1),
(32, 'Frais de telecommunication', '020.5', '6262', 'Fonctionnement', 1),
(33, 'Maintenance des logiciels ( SIG)', '820.1', '6156', 'Fonctionnement', 1),
(34, 'formations (SIG)', '820.1', '6184', 'Fonctionnement', 1),
(35, 'Prestations de service (SIG)', '820.1', '6188', 'Fonctionnement', 1),
(36, 'Maintenance Cyberbases - Abonnement', '90.16', '6156', 'Fonctionnement', 1),
(37, 'Formations (Cyberbases)', '90.16', '6184', 'Fonctionnement', 1),
(38, 'Prestations de service', '90.16', '6188', '', 1),
(39, 'Frais de telecommunication', '90.16', '6262', '', 1),
(40, 'Remboursement de frais de location', '90.16', '62878', '', 1),
(41, 'Logiciels', '020.3', '2051', 'Investissement', 1),
(42, 'Matériels', '020.3', '2183', 'Investissement', 1),
(43, 'Travaux de cablages', '020.3', '2315', 'Investissement', 1),
(44, 'Sub. d''équipement au Ciril', '020.3', '20418.22', 'Investissement', 1),
(45, 'Divers Travaux -SIG-', '820.1', '2318', 'Investissement', 1),
(46, 'logiciels', '90.14', '2051-308', 'Investissement', 1),
(47, 'Matériels', '90.14', '2183-308', 'Investissement', 1),
(48, 'Matériels', '90.14', '2183-360', 'Investissement', 1),
(49, 'Mobiliers er autres', '90.14', '2184-308', 'Investissement', 1),
(50, 'Cotisation ADULLACT', '90.14', '6281,59', 'Fonctionnement', 1),
(51, 'locations mobiliers et immobiliers', '90.16', '6132', 'Fonctionnement', 1),
(52, 'ImpSpécifique pour Nancy - report 2007', '020.2', '2183-Ncy', 'Investissement', 1),
(53, 'Documentation générale et technique', '020.3', '6182-300', 'Fonctionnement', 1),
(54, 'Documentation générale et technique', '020.3', '6182', 'Fonctionnement', 1),
(55, 'Cotisation au club utilisateurs Droits de Cités', '020.3', '6281.75', 'Fonctionnement', 1),
(56, 'Autres fournitures non stockées', '020.3', '60628', 'Fonctionnement', 1),
(57, 'Etudes et recherches', '020.3', '617-300', 'Fonctionnement', 1),
(58, 'Catalogues et imprimés', '020.3', '6236', 'Fonctionnement', 1),
(59, 'Etudes Préopérationnelles', '020.3', '2031', 'Investissement', 1),
(60, 'Travaux de réseau et voirie', '020.3', '2315', 'Investissement', 1),
(61, 'Club Utilisateur', '020.3', '6281.91', 'Fonctionnement', 1),
(62, 'Maintenance G-NY (PDU)', '820.3', '6156', 'Fonctionnement', 1),
(63, 'Installations générales', '020.3', '2135', 'Investissement', 1),
(64, 'entretien et réparations sur biens mobiliers', '020.3', '61558.300', 'Fonctionnement', 1);

--
-- Contenu de la table `forfait`
--

INSERT INTO `forfait` (`id`, `collectivite_id`, `annee`, `montant`, `application_id`) VALUES
(1, 18, '2015', '1231', 10);



--
-- Contenu de la table `Livraison`
--

INSERT INTO `Livraison` (`id`, `Nom`, `Adresse`, `Complement_Adresse`, `Code_Postal`, `Ville`, `Telephone`, `Fax`) VALUES
(1, 'Lieu livraison test', '50 Rue Sainte-Catherine', '4eme étage', 54000, 'Nancy', '0383121212', NULL);



--
-- Contenu de la table `Service`
--

INSERT INTO `Service` (`id`, `Nom`, `Est_Ancien_Service`) VALUES
(1, 'Bureautique', 0),
(2, 'Infrastructure', 0),
(3, 'Etude', 0),
(4, 'SIG', 0),
(5, 'Cyberbase', 0);


--
-- Contenu de la table `TVA`
--

INSERT INTO `TVA` (`id`, `pourcentage`) VALUES
(1, '0.00'),
(2, '2.10'),
(3, '5.50'),
(4, '7.00'),
(5, '20.00');

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `service_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `Nom`, `Prenom`) VALUES
(49, 2, 'testA', 'testa', 'a@a.fr', 'a@a.fr', 1, '', 'mdp', '2015-08-05 09:55:06', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, 'nomA', 'prenomA'),
(50, 3, 'testC', 'testc', 't@f.fr', 't@f.fr', 1, '', 'mdp', '2015-07-21 15:10:12', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:11:"ROLE_COMPTA";}', 0, NULL, 'nomC', 'prenomC');




--
-- Contenu de la table `Budget`
--

INSERT INTO `Budget` (`id`, `service_id`, `Montant`, `Annee`, `Libelle`) VALUES
(1, 1, 2500, 2015, 'Logiciel - b'),
(2, 3, 10000, 2015, 'Logiciel - e'),
(3, 2, 12000, 2015, 'Logiciel - i'),
(4, 5, 10000, 2015, 'Materiel - c'),
(5, 4, 10000, 2015, 'Formation- s');
