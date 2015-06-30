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
	    
   	  	$em = $this->getDoctrine()->getManager();

	    //On récupere la collectivite
	    $collectivite = $em->getRepository('JCCommandeBundle:Collectivite')->findOneByNom($nomCollectivite); 
	    
	    //On recupere les commandes concernant la collectivite
	    // (On ne passe pas par CommandePasseEtat car il y a plus de CommandePasseEtat(Payee) que de CommandeConcerne(Collectivite))
	    $listeCCC = $em->getRepository('JCCommandeBundle:Commande')->findCommandePourCollectiviteAvecStatutPourAnnee($collectivite, "Payee", "2015");  

		
		//On crée le tableau qui contiendra les données
		$infosColl = array();
		$infosColl['nomColl'] = $collectivite->getNom();
		$infosColl['nbMutualisees'] = 0;
		$infosColl['nbDirectes'] = 0;
		$infosColl['montantMutualisees'] = 0;
		$infosColl['montantDirectes'] = 0;
		
		//On stock les commandes
		$tabCommande = array();


		//On parcours les états (donc les commandes) en faisant les calculs
		foreach($listeCCC as $ccc){
			
			//On recupere la commande
			$commande = $ccc->getCommande();
			
			//On stock les infos de la commande dans le tableau
			$tabCommande[$commande->getId()] = array();
			
			$tabCommande[$commande->getId()]['id'] = $commande->getId();
			$tabCommande[$commande->getId()]['ventilation'] = $commande->getVentilation();
			$tabCommande[$commande->getId()]['activite'] = $commande->getApplication()->getActivite()->getNom();
			$tabCommande[$commande->getId()]['dateCreation'] = $commande->getDateCreation();
			$tabCommande[$commande->getId()]['montant'] = $commande->getTotalTTC();

				//On vérifie que la commande a bien 
				//Si la commande est une commande mutualisée,
				if($commande->getVentilation() === "Mutualisee"){
					
					
					//On compte
					$infosColl['nbMutualisees'] += 1;
					
					$tabCommande[$commande->getId()]['repartition'] = $ccc->getRepartition();

					//On regarde la clé de repartition (de la commande, car celle de l'application a pu changer entre temps)
					//Puis on va chercher l'information de la collectivite liée à la clée
					//On fait ensuite le ratio (par exemple : nbHabitant_Nancy / nbHabitant_Total)
					$infosColl['montantMutualisees'] += $commande->getTotalTTC();
					
					$tabCommande[$commande->getId()]['montantAPayer'] = "A calculer";
				
				
				
				//Sinon, si c'est une commande directe
				} else if($commande->getVentilation() === "Directe"){
				
					//On compte
					$infosColl['nbDirectes'] += 1;
					
					$tabCommande[$commande->getId()]['repartition'] = $ccc->getRepartition()." %";

					
					//Pour le calcul, c'est plus simple
					//On prend la répartition (le pourcentage) et on le multiplie au total de la facture
					$montant = $commande->getTotalTTC() * ($ccc->getRepartition()/100);
					$infosColl['montantDirectes'] += $montant;
				
					$tabCommande[$commande->getId()]['montantAPayer'] = $montant;

				}			
			
			
		}
    
    
        return $this->render('JCFacturationBundle:Facturation:calcul_facturation.html.twig', array('infosColl'=>$infosColl, 'tabCommandes'=>$tabCommande, 'annee'=>$annee));

    }
    
    
    
    
}
