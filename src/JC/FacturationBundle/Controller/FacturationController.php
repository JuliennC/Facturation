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
    
    
    public function indexAction()
    {
   	    $em = $this->getDoctrine()->getManager();


   		//On recupere l'annee
		$date = date("Y");
		

   		//On recupere la liste des services
		$listeServices = $em->getRepository('JCCommandeBundle:Service')->findAll();	
		$infoServices = array();


   		foreach($listeServices as $service){
	   		
	   		//On recupere le budget du service pour l'annee correspondante a 'date'
	   		$budget = $em->getRepository('JCCommandeBundle:Budget')->findBudgetAvecAnneeEtService($em->getRepository('JCCommandeBundle:Annee')->findOneByLibelle($date), $service);

			//On cree un tableau pour y stocker les informations du service
			$infoServices[$service->getNom()] = array('nom'=>$service->getNom(),'budget'=>$budget,'nbCommandesPassees'=>0 , 'montantCommandesPassees'=>0);
			
			
			
		}



		// On récupète toutes les commandes
		$listeCommandes = $em->getRepository('JCCommandeBundle:Commande')->findAll();
		$infoCommandess = array();
		
		
		//On calcule le total des commandes crees en dans l'annee courrante		
		$infoCommandes['nombreCommandesPassees'] = 0;
		$infoCommandes['montantCommandesPassees'] = 0;
		$infoCommandes['nombreCommandesDirectes'] = 0;
		$infoCommandes['montantCommandesDirectes'] = 0;
		$infoCommandes['nombreCommandesMutualisees'] = 0;
		$infoCommandes['montantCommandesMutualisees'] = 0;

		
		
		foreach($listeCommandes as $commande){
			
			//Si la commande a ete passee dans l'annee courrante
			if ($commande->getDateCreation() > $date){
				
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
				
				$infoServices[$commande->getUtilisateur()->getService()->getNom()]['nbCommandesPassees'] += 1;
				$infoServices[$commande->getUtilisateur()->getService()->getNom()]['montantCommandesPassees'] += $commande->getTotalTTC();

			}
		}
		
		
		
		
		

		

        return $this->render('JCFacturationBundle:Facturation:index.html.twig', array('infoCommandes'=>$infoCommandes, 'annee'=>$date, 'infoServices'=>$infoServices));
    }
    
    
    
    
    
    
    
    
    public function calculAction() {
	    
   	    $em = $this->getDoctrine()->getManager();
	    
	    // On récupète toutes les commandes
		$listeCommandes = $em->getRepository('JCCommandeBundle:Commande')->findByStatu("Enregistree");

		// On récupète toutes les collectivites
		$listeCollectivites = $em->getRepository('JCCommandeBundle:Collectivite')->findAll();

		
		$totalDirect = 0;
		$totalMutu = 0;
		

		foreach($listeCommandes as $commande) {

			if( $commande->getVentilation() === 'Mutualisée' ) {

				$totalMutu += $commande->getTotalTTC(); 
				
				foreach($listeCollectivites as $coll) {
					
					//$coll -> addCommande($commande);
				}
				
				
				
				
			} else if( $commande->getVentilation() === 'Directe' )  {

				$totalDirect += $commande->getTotalTTC(); 
				
				//On récupère les collectivites concernées avec la table de transitions
				$listeTransition = $em->getRepository('JCCommandeBundle:CommandeConcerneCollectivite')->findByCommande($commande->getId());
				
				foreach($listeTransition as $tran) {
					
					echo $tran->getCollectivite()->addCommande($commande);
				}
				
			} 
			
			
		}


		//On calcule pour chaque type de commande
		return $this->render('JCFacturationBundle:Facturation:calcul_facturation.html.twig', array('listeCollectivite'=> $listeCollectivites, 'total_d'=>$totalDirect , 'total_m' => $totalMutu));
	    
    }
    
    
    
    
}
