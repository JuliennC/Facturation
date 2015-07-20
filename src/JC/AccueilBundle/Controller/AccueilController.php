<?php

namespace JC\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

use JC\CommandeBundle\Entity\EtatCommande;
use JC\CommandeBundle\Entity\CommandePasseEtat;

class AccueilController extends Controller
{
	
	
    public function indexAction($annee)
    {
	    
   	    $em = $this->getDoctrine()->getManager();

        //Si aucune année n'est passée en paramêtre, 
        //On récupère l'année courrante
        if ($annee === "html"){
			$annee = date("Y");
        } 
		

   		//On recupere la liste des services
		$listeServices = $em->getRepository('JCCommandeBundle:Service')->findAll();	
		$infoServices = array();


   		foreach($listeServices as $service){
	   		
	   		//On recupere le budget du service pour l'annee correspondante a 'date'
	   		$budget = $em->getRepository('JCCommandeBundle:Budget')->findBudgetAvecAnneeEtService($annee, $service);

			//On vérifie qu'un budget a bien été créée
			// (Exemple, dans le cas de la création d'un nouveau service, le service n'a pas de budget pour l'année d'avant)	   		
	   		if(sizeof($budget) > 0){
		   	
		   		//On cree un tableau pour y stocker les informations du service
		   		$infoServices[$service->getNom()] = array('nom'=>$service->getNom(),'budget'=>$budget[0]->getMontant(),'nbCommandesPassees'=>0 , 'montantCommandesPassees'=>0);	
	   		
	   		} else {
		   		
		   		$session = new Session();
				$session->getFlashBag()->add('Warning', 'Attention : Aucun budget n\'a été saisi pour '.$service->getNom());

		   		$infoServices[$service->getNom()] = array('nom'=>$service->getNom(),'budget'=>1,'nbCommandesPassees'=>0 , 'montantCommandesPassees'=>0);	
		   		
	   		}

		}

		//On calcule le total des commandes crees en dans l'annee courrante		
		$infoCommandes = array();
		$infoCommandes['nombreCommandesPassees'] = 0;
		$infoCommandes['montantCommandesPassees'] = 0;
		$infoCommandes['nombreCommandesDirectes'] = 0;
		$infoCommandes['montantCommandesDirectes'] = 0;
		$infoCommandes['nombreCommandesMutualisees'] = 0;
		$infoCommandes['montantCommandesMutualisees'] = 0;

		

		 

		// On récupète toutes les commandes qui ont été Enregistrée dans l'année 'date'
		$listePasseEtat = $em->getRepository('JCCommandeBundle:CommandePasseEtat')->findPasseEtatDansAnnee("Enregistree", $annee);
		
				
		
		foreach($listePasseEtat as $etat){
			
			//On récupère la commande de l'état
			$commande = $etat->getCommande();
			
			//On calcule le nombre total de commandes 
			$infoCommandes['nombreCommandesPassees'] += 1;
				
			//On calcule le montant total des commandes 
			$infoCommandes['montantCommandesPassees'] += $commande->getTotalTTC();
				
			if($commande->getVentilation() == 'Directe'){
					
				//On calcul le nombre de commandes directes
				$infoCommandes['nombreCommandesDirectes'] += 1;

				//On calcul le montant des commandes directes
				$infoCommandes['montantCommandesDirectes'] += $commande->getTotalTTC();


			} else if($commande->getVentilation() == 'Mutualisee'){
					
				//On calcul le nombre de commandes mutualisees
				$infoCommandes['nombreCommandesMutualisees'] += 1;

				//On calcul le montant des commandes mutualisees
				$infoCommandes['montantCommandesMutualisees'] += $commande->getTotalTTC();

			}
				
			$infoServices[$commande->getService()->getNom()]['nbCommandesPassees'] += 1;
			$infoServices[$commande->getService()->getNom()]['montantCommandesPassees'] += $commande->getTotalTTC();

		}
		
		
		

        return $this->render('JCAccueilBundle:Accueil:index.html.twig', array('infoCommandes'=>$infoCommandes, 'annee'=>$annee, 'infoServices'=>$infoServices));
    }
    



	public function navBarreAction() {
	        
		return $this->render('JCAccueilBundle:Accueil:navBarre.html.twig');
		
	}


	
    
}
