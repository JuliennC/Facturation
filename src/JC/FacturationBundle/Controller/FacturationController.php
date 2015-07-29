<?php

namespace JC\FacturationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

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
		$listePasseEtat = $em->getRepository('JCCommandeBundle:CommandePasseEtat')->findPasseEtatDansAnnee("Terminee", $annee);  
		
		
		//On parcours les passages d'états,
		//Dans lesquels on pourra récupérer la commande
		foreach($listePasseEtat as $etat){
			
			$etat = $etat[0];
			
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
		

		
		/*	Si ce qui a été retourné par la fonction calcul est une redirection (donc pas un tableau)
		*	Par exemple s'il y a eu une erreur dans la facturation
		*	Alors, on retourne la redirection
		*/
		if(! is_array($tabRes)) {
			return $tabRes;
		}
    
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


		
		/*	Si ce qui a été retourné par la fonction calcul est une redirection
		*	Par exemple s'il y a eu une erreur dans la facturation
		*	Alors, on retourne la redirection
		*/
		if( is_a($tabRes,'RedirectResponse')) {
			return $tabRes;
		}



		//On crée la table activite
		$tabActivites = array();


		//On va stocker les totaux, pour ne pas le faire en twig
		$tabRes['infosColl']['totalFactures']['Investissement'] = 0;
		$tabRes['infosColl']['totalFactures']['Fonctionnement'] = 0;

		
		//On crée les tableaux
		foreach ($listeActivite as $activite) {

			$tabActivites[$activite->getNom()] = array();
			$tabActivites[$activite->getNom()]['nom'] = $activite->getNom();
			$tabActivites[$activite->getNom()]['montantFactures']['Investissement'] = 0;
			$tabActivites[$activite->getNom()]['montantFactures']['Fonctionnement'] = 0;
			$tabActivites[$activite->getNom()]['montantMasseSalariale'] = 0;
			$tabActivites[$activite->getNom()]['applications'] = array();
			
			
			//On regarde si la collectivite à bien une partie de la masse salariale à payer 
			//Dans cette activite
			if (array_key_exists($activite->getNom(), $tabRes['tabMassesSalariales'])) {
			
				//On ne va chercher le total de la masse salariale qu'une seule fois par activite
				//On récupere le montant de la masse salariale dans le tableau retourné par calculFacturatoin(..)
				$tabActivites[$activite->getNom()]['montantMasseSalariale'] = $tabRes['tabMassesSalariales'][$activite->getNom()]['montantAPayer']; 	
			
				
			} else {
				
				//Si la collectivite ne devait rien payer, on met 0
				$tabActivites[$activite->getNom()]['montantMasseSalariale'] = 0; 	
			}
			
		}
		
		
		
		//On calcule le montant des commandes par ativite
		
		//ATTENTION, ici $commande est un tablea, tableau créé dans la fonction calculFacturation 
		// On ne peut donc pas faire de $commande->getActivite()->getNom() !!!!!
		foreach($tabRes['tabCommandes'] as $commande) {
			
			//On stock les infos de la commane (comme l'application, le montant etc..)
			if (! array_key_exists($commande['application'], $tabActivites[$commande['activite']]['applications'])) {
				
				$tabActivites[$commande['activite']]['applications'][$commande['application']] = array();
				$tabActivites[$commande['activite']]['applications'][$commande['application']]['nom'] = $commande['application'];
				
				$tabActivites[$commande['activite']]['applications'][$commande['application']]['Investissement'] = 0;
				$tabActivites[$commande['activite']]['applications'][$commande['application']]['Fonctionnement'] = 0;
			}
			
			
			//On incrémente le montant des factures pour l'activite
			$tabActivites[$commande['activite']]['montantFactures'][$commande['imputation']] += $commande['montantAPayer'];			

			//On incrémente le montant des factures total
			// (On le fait ici pour ne pas le faire dans le twig.
			$tabRes['infosColl']['totalFactures'][$commande['imputation']] += $commande['montantAPayer'];
			
			//On compte aussi le total par application
			$tabActivites[$commande['activite']]['applications'][$commande['application']][$commande['imputation']] += $commande['montantAPayer'];
		}
	
	  	
		$content = $this->renderView('JCFacturationBundle:Facturation:pdf_facture.html.twig', array('infosColl' => $tabRes['infosColl'] , 'annee'=>$annee, 'tabActivites'=>																													$tabActivites, /*'totalActivitesFactures'=>$totalActivitesFactures, 																														'totalActivitesMassesSalariales'=>$totalActivitesMassesSalariales*/) );
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
	    
	    //On recupere les commandes concernant la collectivite, qui sont passées à l'etat payée en 20xx ($annee)
	    // (On ne passe pas par CommandePasseEtat car il y a plus de CommandePasseEtat(terminee) que de CommandeConcerne(Collectivite))
	    $listeCCC = $em->getRepository('JCCommandeBundle:Commande')->findCommandePourCollectiviteAvecStatutPourAnnee($collectivite, "Terminee", $annee);  
		
		
		//On crée le tableau qui contiendra les données
		$infosColl = array();
		$infosColl['nomColl'] = $collectivite->getNom();
		$infosColl['nbMutualisees'] = 0;
		$infosColl['nbDirectes'] = 0;
		$infosColl['montantMutualisees'] = 0;
		$infosColl['montantDirectes'] = 0;
		$infosColl['montantInvestissement'] = 0;
		$infosColl['montantFonctionnement'] = 0;
		
		
		//On récupere les infos de la collectivite (clés de repartition)
		$listInfosColl = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findToutesInfosPourCollectiviteEtAnnee($collectivite, $annee);

		//On stock les infos
		foreach($listInfosColl as $info){

			$infosColl[$info->getCleRepartition()->getNom()] = $info;
		}
		
		
		//On stock les commandes
		$tabCommandes = array();


		//On parcours les commande concerne collectivite pour faire les calculs
		foreach($listeCCC as $ccc){
			
			//On recupere la commande
			$commande = $ccc->getCommande();
			
			//On stock les infos de la commande dans le tableau
			$tabCommandes[$commande->getId()] = array();
			
			$tabCommandes[$commande->getId()]['id'] = $commande->getId();
			$tabCommandes[$commande->getId()]['ventilation'] = $commande->getVentilation();
			$tabCommandes[$commande->getId()]['imputation'] = $commande->getImputation()->getSection();
			$tabCommandes[$commande->getId()]['activite'] = $commande->getActivite()->getNom();
			$tabCommandes[$commande->getId()]['dateCreation'] = $commande->getDateCreation();
			$tabCommandes[$commande->getId()]['montantTotal'] = $commande->getTotalTTC();
			$tabCommandes[$commande->getId()]['application'] = $commande->getApplication()->getNom();



				//Si la commande est une commande mutualisée,
				if($commande->getVentilation() === "Mutualisee"){
					
					
					/*	On vérifie que l'information existe bien 
					*	Sinon c'est qu'elle a été oubliée	
					*	On met donc un message flash pour avertir la personnes 
					*	Et on redirige vers l'accueil de Facturation
					*/
					if(! array_key_exists($commande->getActivite()->getCleRepartition()->getNom(), $infosColl)){
								
						$session = new Session();
						$session->getFlashBag()->add('Error', 'Erreur : La clé '.$commande->getActivite()->getCleRepartition()->getNom().' n\'a pas été renseignée pour'.$collectivite->getNom().' pour l\'année '.$annee);
						
						return $this->redirect($this->generateUrl('jc_facturation_homepage', array($annee)));
						
					}
					
					
					//On récupere l'InformationCollectivité
					$info = $infosColl[$commande->getActivite()->getCleRepartition()->getNom()];



					//Si le $info->getNombre() == 0, c'est qu'il y a sans doute eu un oubli dans la table des infos
					//On met donc un flash message Warning pour avertir, et être sur que cela est volontaire
					if ($info->getNombre() === 0 || $info->getNombre() === "0"){
						
						$session = new Session();
						$session->getFlashBag()->add('Warning', 'Attention : La clé '.$info->getCleRepartition()->getNom().' est à 0 pour '.$collectivite->getNom());
					}
					

					//On récupere la "somme des clés", ceci afin de faire un ratio pour la collectivite
					$totalCle = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findSommeDeCleEtAnneePourCommande($info->getCleRepartition(), $annee, $commande)[1];



					//On fait le ratio
					//Si le total des clès fait 0, alors on change en 1 ( ce qui ne change rien, car le seul cas serait 0/0 --> donc 0/1 )
					// et c'est qu'il y a sans doute eu un oubli dans la table des infos
					//On met donc un flash message Warning pour avertir, et être sur que cela est volontaire
					if ($totalCle === 0 || $totalCle === "0") {
						
						$session = new Session();
						$session->getFlashBag()->add('Warning', 'Attention : La somme des clés '.$info->getCleRepartition()->getNom().' = 0.');
						
						$totalCle = 1;
					}
					
					
					
					
					$ratio = $info->getNombre() / $totalCle;
						
					//On calcule le montant à payer grâce au ratio
					$montant = $ratio * $commande->getTotalTTC();
					
					//On stocke le ratio
					$tabCommandes[$commande->getId()]['repartition'] = ($ratio*100);

					//On explique le ratio
					$tabCommandes[$commande->getId()]['infoRatioText'] = $info->getNombre()." sur un total de ".$totalCle;
					$tabCommandes[$commande->getId()]['infoRatioTitre'] = $commande->getActivite()->getCleRepartition()->getNom();
					
					
					//On met les infos
					$infosColl['montantMutualisees'] += $montant;
					$infosColl['nbMutualisees'] += 1;
					$infosColl['montant'.$commande->getImputation()->getSection()] += $montant;
					
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
					$infosColl['montant'.$commande->getImputation()->getSection()] += $montant;

					$tabCommandes[$commande->getId()]['montantAPayer'] = $montant;
					$tabCommandes[$commande->getId()]['repartition'] = $ccc->getRepartition();
				}			
			
			
			
			
			
		}
    
    
    
    
		// --------------- On a donc finit de calculer les montant des commandes ---------------


		// --------------- On passe au calcul des masses salariales ---------------
		
		
		//On stock les montants des masses salariales
		$tabMassesSalariales = array();
		
		//On récupère les masses salarials pour l'année donnée
		$listeMassesSalarialesAnnee = $em->getRepository('JCCommandeBundle:MasseSalariale')->findByAnnee($annee);
    
		//On récupère la liste des activites
		$listeActivites = $em->getRepository('JCCommandeBundle:Activite')->findAll();
    
		//On additionnera les montants des masses salariales
		$infosColl['montantMassesSalariales'] = 0;
		
		
		//Si aucune masse salariale n'est définie pour l'année, on le signale, cela doit être une erreur
		if (sizeof($listeMassesSalarialesAnnee) === 0){
			
			$session = new Session();
			$session->getFlashBag()->add('Warning', 'Attention : Aucune masse salariale n\'a pas été définie pour l\'année '.$annee.'.');
		}
    
    
    
		//On parcours chaque masse salariale afin de connaitre la part que la collectivite doit payer
		foreach($listeMassesSalarialesAnnee as $ms) {
			
			
			/*	On parcours les masses salariales, 
			*	On récupère le service, et on parcours les commandes pour calcule le ratio de chaque activite
			*		--> nombre commande activite / nombre total commande 
			*	
			*	On peut calculer le montant de chaque activite pour le service
			*
			*	Une fois fait, il faut calculer avec le pourcentage de temps passé pour la collectivite
			*/
			
			$service = $ms->getService();
			
			
			//On compte le nombre de commande qui concerne le service
			$nbCommandeService = 0;
			
			//On parcours les commandes
			foreach($listeCCC as $ccc){
				
				//On récupère la commande
				$commande = $ccc->getCommande();
				
				//On compte le nombre de commande qui correspondent à l'activite
				if ($commande->getService() === $service){
					$nbCommandeService ++;
				
				//Si la commande ne concerne pas le service, on la supprime du tableau
				} else {
					unset($commande);
				}
						
			}
			
		
				
			/*	S'il n'y a aucune commande pour le service, on avertie l'utilisateur
			*
			*	Cela doit être une erreur car sinon la masse salariale du service ne sera JAMAIS repartie sur les collectivites
			*/
				
			if($nbCommandeService === 0 && $ms->getMontant()){
					
				$session = new Session();
				$session->getFlashBag()->add('Warning', 'Attention : Aucune commande ne concerne le service '.$service.'. Ce qui veut dire que la masse salariale du service ('.$ms->getMontant().' €) ne sera pas répartie sur les collectivites !');
					
				//On passe à un autre service
				continue;
			}
				
		
		
			
			//On parcours les activites
			foreach($listeActivites as $activite) {
				
				$nbCommandesActivite = 0;

				//On parcours les commandes
				foreach($listeCCC as $ccc){
				
					//On récupère la commande
					$commande = $ccc->getCommande();
				
					//On compte le nombre de commande qui correspondent à l'activite
					if ($commande->getActivite() === $activite){
						
						$nbCommandesActivite ++;
					}	
				}				
				
				
				//On init l'array de l'activite
				$tabMassesSalariales[$activite->getNom()] = array();
				
				//On récupère le temps passé de l'année pour l'Activite
				$tempsPasse = $em->getRepository('JCCommandeBundle:TempsPasse')->findOneAvecAnneeEtActivitePourCollectivite($annee, $activite, $collectivite);
				
				
				/*  S'il n'y a pas de temps passé pour l'activite, ET QUE le nb de commandes concernant l'activité est à 0
				*	alors on prévient l'utilisateur car cela est une erreur
				*
				*	Car on est obligé de facturer une partie de la masse si le nombre de commande est > 0
				*/
				if(sizeof($tempsPasse) === 0 && $nbCommandesActivite != 0) {
					
					$session = new Session();
					$session->getFlashBag()->add('Error', 'Erreur : Le temps passé pour '.$collectivite->getNom().' pour l\'activité '.$activite->getNom().' n\'a pas été définie.');

					return $this->redirect($this->generateUrl('jc_facturation_homepage', array($annee)));
				}

				$tempsPasse = $tempsPasse[0];
				
				//On calule le montant dû par la collectivite
				$masseDeLActivite = $ms->getMontant() * ($nbCommandesActivite / $nbCommandeService);
			
			
				/*	S'il le temps passé en pourcentage est 0, ET QUE le nb de commandes concernant l'activité est à 0
				*	alors on prévient l'utilisateur car cela est une erreur
				*
				*	Car on est obligé de facturer une partie de la masse si le nombre de commande est > 0
				*/
				if($tempsPasse->getPourcentage() === 0 && $nbCommandesActivite != 0) {
					
					$session = new Session();
					$session->getFlashBag()->add('Error', 'Erreur : Le temps passé pour '.$collectivite->getNom().' pour l\'activité '.$activite->getNom().' est de 0.');

					return $this->redirect($this->generateUrl('jc_facturation_homepage', array($annee)));
				}
			
				$montantDuParLaCollectivite = $masseDeLActivite * ($tempsPasse->getPourcentage()/100);
				
				
				
				//On stoke les informations concernant la masse salariale (due , totale, etc)
				$tabMassesSalariales[$activite->getNom()]['activite'] = $activite->getNom();
				$tabMassesSalariales[$activite->getNom()]['montantTotal'] =  $ms->getMontant();
				$tabMassesSalariales[$activite->getNom()]['pourcentage'] =  $tempsPasse->getPourcentage();
				$tabMassesSalariales[$activite->getNom()]['montantAPayer'] =  $montantDuParLaCollectivite;
				
				$infosColl['montantMassesSalariales'] += $montantDuParLaCollectivite;
			}
			
			
		}
		
		//Tableau qui est retourné
		$tabRes = array();
		
		$tabRes['infosColl'] = $infosColl;
		$tabRes['tabCommandes'] = $tabCommandes;
		$tabRes['tabMassesSalariales'] = $tabMassesSalariales;
	    //throw new NotFoundHttpexception('sd.');
		return $tabRes;
	 }
    
}
