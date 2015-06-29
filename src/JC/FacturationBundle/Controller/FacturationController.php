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

		$listePasseEtat = $em->getRepository('JCCommandeBundle:CommandePasseEtat')->findPasseEtatDansLannee("Payee", $annee);  
		
		echo sizeof($listePasseEtat);

        return $this->render('JCFacturationBundle:Facturation:index.html.twig', array('infosCollectivites'=>$tabColl, 'annee'=>$annee));
    }
    
    
    
    
    
    
    
    
    public function calculAction($nomCollectivite) {
	    
	    //Pour l'instant, le calcul se fait sur l'annee courrante
	    $annee = date('Y');
	    
   	    $em = $this->getDoctrine()->getManager();
	    
	    // On récupète toutes les ccc correspondante à la collectivite, à l'année, et au statu
		$listeCommandes = $em->getRepository('JCCommandeBundle:Commande')->findByStatuEtAnnee("Enregistree", $annees);

		// On récupère toutes la  collectivites
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
