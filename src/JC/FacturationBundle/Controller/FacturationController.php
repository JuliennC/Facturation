<?php

namespace JC\FacturationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JC\CommandeBundle\Entity\Commande;
use JC\CommandeBundle\Entity\CleRepartition;
use JC\CommandeBundle\Entity\Collectivite;
use JC\CommandeBundle\Entity\CommandeConcerneCollectivite;
use JC\CommandeBundle\Entity\EtatCommande;

class FacturationController extends Controller
{
    
    
    public function indexAction($annee)
    {
	  	$em = $this->getDoctrine()->getManager();
	  	
	  	
	  	//Si aucune année est entrée, on met celle courante
	  	if($annee === 'html'){
		
		  	$annee = date('Y');
	  	
	  	}
	  	
	  	//Tableau qui sera envoyé à la view
	    $tabColl = array();
	    
	    
	    // On récupète toutes les collectivite
		$listeColl = $em->getRepository('JCCommandeBundle:Collectivite')->findAll();   
	    
	    //On cree un espace dans le tableau pour toutes les coll
	    foreach($listeColl as $coll){
		    
		    $tabColl[$coll->getNom()] = array();
		    
		    $tabColl[$coll->getNom()]['nom'] = $coll->getNom();
		    
		    //On stockera les commande mutualisees
   		    $tabColl[$coll->getNom()]['Mutualisee'] = 0;

   			//On stockera les commande directes
   		    $tabColl[$coll->getNom()]['Directe'] = 0;

	    }

	    
		//On récupère toutes les ccc
		//L'annee passé en paramêtre est l'année à laquelle la DSIT a payé la facture
		// Généralement n-1
		$listePasseEtat = $em->getRepository('JCCommandeBundle:CommandePasseEtat')->findPasseEtatDansAnnee("Payee", $annee);  
		
		
		//On parcours les passages d'états,
		//Dans lesquels on pourra récupérer la commande
		foreach($listePasseEtat as $etat){
			
			//On récupère la commande
			$commande = $etat->getCommande();
			
			//On récupere les collectivites concernées
			$listeTransition = $em->getRepository('JCCommandeBundle:CommandeConcerneCollectivite')->findByCommande($commande);
			
			//On dispatche la commande avec les collectivites concernées
			foreach($listeTransition as $t){
				
				$tabColl[$t->getCollectivite()->getNom()][$commande->getVentilation()] += 1;
			}
			
		}


        return $this->render('JCFacturationBundle:Facturation:index.html.twig', array('infosCollectivites'=>$tabColl, 'annee'=>$annee));
    }
    
    
    
    
    
    
    
    
    public function calculAction($nomCollectivite, $annee) {
	    
	    
		$tabRes = $this->calculFacturation($nomCollectivite, $annee);
    
        return $this->render('JCFacturationBundle:Facturation:calcul_facturation.html.twig', array('infosColl'=>$tabRes['infosColl'], 'tabCommandes'=>$tabRes['tabCommandes'], 
        																							'annee'=>$annee, 'tabMassesSalariales'=>$tabRes['tabMassesSalariales']));

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    		

     public function genererPDFFactureAction($nomCollectivite, $annee)
    {
		
		//On récupere les activites
		$em = $this->getDoctrine()->getManager();
	  	    
	    // On récupète toutes les activites
		$listeActivite = $em->getRepository('JCCommandeBundle:Activite')->findAll();  

		$tabRes = $this->calculFacturation($nomCollectivite, $annee);

		$tabActivites = array();
		$totalActivitesFactures = 0;
		$totalActivitesMassesSalariales = 0;

		
		//On crée les tableaux
		foreach ($listeActivite as $activite) {

			$tabActivites[$activite->getNom()] = array();
			$tabActivites[$activite->getNom()]['nom'] = $activite->getNom();
			$tabActivites[$activite->getNom()]['montantFactures'] = 0;

			
			//On ne va chercher le total de la masse salariale qu'une seule fois par activite
			//On récupere le montant de la masse salariale dans le tableau retourné par calculFacturatoin(..)
			$tabActivites[$activite->getNom()]['montantMasseSalariale'] = $tabRes['tabMassesSalariales'][$activite->getNom()]['montantAPayer']; 
		
			$totalActivitesMassesSalariales += $tabRes['tabMassesSalariales'][$activite->getNom()]['montantAPayer'];

		}
		
		
		
		//On calcule le montant des commandes par ativite
		
		//ATTENTION, ici $commande est un tablea, tableau créé dans la fonction calculFacturation 
		// On ne peut donc pas faire de $commande->getActivite()->getNom() !!!!!
		foreach($tabRes['tabCommandes'] as $commande) {
			
			
			$tabActivites[$commande['activite']]['montantFactures'] += $commande['montantAPayer'];			

			$totalActivitesFactures += $commande['montantAPayer'];
		}
		
		
		
	  	
		$content = $this->renderView('JCFacturationBundle:Facturation:pdf_facture.html.twig', array('infosColl' => $tabRes['infosColl'] , 'annee'=>$annee, 'tabActivites'=>																													$tabActivites, 'totalActivitesFactures'=>$totalActivitesFactures, 																														'totalActivitesMassesSalariales'=>$totalActivitesMassesSalariales) );
	    //$pdfData = $this->get('obtao.pdf.generator')->outputPdf($content);
	
	    /* You can also pass some options.
	       The following options are available :
	            protected $font = 'Arial'
	            protected $format = 'P'
	            protected $language = 'en'
	            protected $size = 'A4'
	       Here is an example to generate a pdf with a special font and a landscape orientation
	    */
	    $pdfData = $this->get('obtao.pdf.generator')->outputPdf($content,array('font'=>'Arial','format'=>'P'));
	
	    $response = new Response($pdfData);
	    $response->headers->set('Content-Type', 'application/pdf');
	
	    return $response;
	  	
	  	
	  	
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*
	 *	Fonction qui calcule ce que doit une collectivite pour une année donnée
	 *	
	 *	Elle est appelé lors du visionnage de la facture en "html" et est aussi appelé lors de la génération du PDF
	 *
	 *	Elle retourne :  - 'infosColl' qui contient les informations générales comme le montant des factures mutualisées, le nb de facture directes etc..
	 * 					 - 'tabCommandes' qui contient toutes les commande de la collectivite avec leurs informations nécéssaires
	 * 					 - 'tabMassesSalariales' qui contient les informations des masses salariales que la collectivite doit payer
	 */
    
	 public function calculFacturation($nomCollectivite, $annee) {
		 
		 
		$em = $this->getDoctrine()->getManager();

	    //On récupere la collectivite
	    $collectivite = $em->getRepository('JCCommandeBundle:Collectivite')->findOneByNom($nomCollectivite); 
	    
	    //On recupere les commandes concernant la collectivite
	    // (On ne passe pas par CommandePasseEtat car il y a plus de CommandePasseEtat(Payee) que de CommandeConcerne(Collectivite))
	    $listeCCC = $em->getRepository('JCCommandeBundle:Commande')->findCommandePourCollectiviteAvecStatutPourAnnee($collectivite, "Payee", $annee);  
		
		
		//On crée le tableau qui contiendra les données
		$infosColl = array();
		$infosColl['nomColl'] = $collectivite->getNom();
		$infosColl['nbMutualisees'] = 0;
		$infosColl['nbDirectes'] = 0;
		$infosColl['montantMutualisees'] = 0;
		$infosColl['montantDirectes'] = 0;
		
		
		//On récupere les infos de la collectivite (clés de repartition)
		$listInfosColl = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findToutesInfosPourCollectiviteEtAnnee($collectivite, $annee);

		//On stock les infos
		foreach($listInfosColl as $info){

			$infosColl[$info->getCleRepartition()->getNom()] = $info;
		}
		
		
		//On stock les commandes
		$tabCommande = array();


		//On parcours les états (donc les commandes) en faisant les calculs
		foreach($listeCCC as $ccc){
			
			//On recupere la commande
			$commande = $ccc->getCommande();
			
			//On stock les infos de la commande dans le tableau
			$tabCommandes[$commande->getId()] = array();
			
			$tabCommandes[$commande->getId()]['id'] = $commande->getId();
			$tabCommandes[$commande->getId()]['ventilation'] = $commande->getVentilation();
			$tabCommandes[$commande->getId()]['activite'] = $commande->getActivite()->getNom();
			$tabCommandes[$commande->getId()]['dateCreation'] = $commande->getDateCreation();
			$tabCommandes[$commande->getId()]['montantTotal'] = $commande->getTotalTTC();
			$tabCommandes[$commande->getId()]['ventilation'] = $commande->getVentilation();

				//On vérifie que la commande a bien 
				//Si la commande est une commande mutualisée,
				if($commande->getVentilation() === "Mutualisee"){
					
									

			
						
					//On récupere l'InformationCollectivité
					$info = $infosColl[$commande->getActivite()->getCleRepartition()->getNom()];

					//On récupere la "somme des clés", ceci afin de faire un ratio pour la collectivite
					$totalCle = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findSommeDeCleEtAnnee($info->getCleRepartition(), $annee)[1];

					//On fait le ratio
					$ratio = $info->getNombre() / $totalCle;
						
					//On calcule le montant à payer grâce au ratio
					$montant = $ratio * $commande->getTotalTTC();
					
					//On stocke le ratio
					$tabCommandes[$commande->getId()]['repartition'] = ($ratio*100);

					//On explique le ratio
					$tabCommandes[$commande->getId()]['infoRatioText'] = $info->getNombre()." sur un total de ".$totalCle;
					$tabCommandes[$commande->getId()]['infoRatioTitre'] = $ccc->getRepartition();
					
					
					//On met les infos
					$infosColl['montantMutualisees'] += $montant;
					$infosColl['nbMutualisees'] += 1;
					$tabCommandes[$commande->getId()]['montantAPayer'] = $montant;
					$tabCommandes[$commande->getId()]['activite'] = $commande->getActivite()->getNom();
				
				
				//Sinon, si c'est une commande directe
				} else if($commande->getVentilation() === "Directe"){
				
					
					//Pour le calcul, c'est plus simple
					//On prend la répartition (le pourcentage) et on le multiplie au total de la facture
					$montant = $commande->getTotalTTC() * ($ccc->getRepartition()/100);
					
					
					//On met les infos
					$infosColl['montantDirectes'] += $montant;
					$infosColl['nbDirectes'] += 1;
					$tabCommandes[$commande->getId()]['montantAPayer'] = $montant;
					$tabCommandes[$commande->getId()]['repartition'] = $ccc->getRepartition();
				}			
			
			
		}
    
    
    
    
    
		// --------------- On a donc finit de calculer les montant des commandes ---------------
		
		
		//On stock les montants des masses salariales
		$tabMassesSalariales = array();
		
		//On calcule maintenant la répartition de la masse salarials
		$listeMassesSalarialesAnnees = $em->getRepository('JCCommandeBundle:MasseSalariale')->findByAnnee($annee);
    
		//On additionnera les masses salariales
		$infosColl['montantMassesSalariales'] = 0;
    
		//On parcours chaque masse salariale afin de connaitre la part que la collectivite doit payer
		foreach($listeMassesSalarialesAnnees as $ms) {
			
			//On init l'array de l'activite
			$tabMassesSalariales[$ms->getActivite()->getNom()] = array();
			
			//On récupère le temps passé de l'année pour l'Activite
			$tempsPasse = $em->getRepository('JCCommandeBundle:TempsPasse')->findOneAvecAnneeEtActivitePourCollectivite($annee, $ms->getActivite(), $collectivite)[0];

			//On calule le montant du
			$montant = $ms->getMontant() * ($tempsPasse->getPourcentage()/100);
			
			
			//On stoke les informations concernant la masse salariale (due , totale, etc)
			$tabMassesSalariales[$ms->getActivite()->getNom()]['activite'] =  $ms->getActivite()->getNom();
			$tabMassesSalariales[$ms->getActivite()->getNom()]['montantTotal'] =  $ms->getMontant();
			$tabMassesSalariales[$ms->getActivite()->getNom()]['pourcentage'] =  $tempsPasse->getPourcentage();
			$tabMassesSalariales[$ms->getActivite()->getNom()]['montantAPayer'] =  $montant;
			
			$infosColl['montantMassesSalariales'] += $montant;
			
			
		}
		
		//Tableau qui est retourné
		$tabRes = array();
		
		$tabRes['infosColl'] = $infosColl;
		$tabRes['tabCommandes'] = $tabCommandes;
		$tabRes['tabMassesSalariales'] = $tabMassesSalariales;
		
		return $tabRes;
	 }
    
}
