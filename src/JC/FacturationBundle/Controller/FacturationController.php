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
			$tabCommande[$commande->getId()] = array();
			
			$tabCommande[$commande->getId()]['id'] = $commande->getId();
			$tabCommande[$commande->getId()]['ventilation'] = $commande->getVentilation();
			$tabCommande[$commande->getId()]['activite'] = $commande->getActivite()->getNom();
			$tabCommande[$commande->getId()]['dateCreation'] = $commande->getDateCreation();
			$tabCommande[$commande->getId()]['montant'] = $commande->getTotalTTC();
			$tabCommande[$commande->getId()]['ventilation'] = $commande->getVentilation();

				//On vérifie que la commande a bien 
				//Si la commande est une commande mutualisée,
				if($commande->getVentilation() === "Mutualisee"){
					
									

					//Lorsque la clé == "Participation"
					// 
					//			total = montantCommande * ratio
					//Avec 
					//			ratio = nbTotalFacture_Activite_1 / nbTotalFacture_Activite_1_Collectivite_x
					if($ccc->getRepartition() === "Participation") {
						
						//On récupere le nb total des facture pour l'activite de l'activite de la commande
						$commandeActivite = $em->getRepository('JCCommandeBundle:Commande')->findByActivite($commande->getApplication()->getActivite());
						
						//On récupere le nombre de commandes liées à l'activite
						$totalActivite = sizeof($commandeActivite);
						
						//On recupere le nombre de commande liée à l'acitivte et à la collectivite
						$cccActiviteCollectivite = $em->getRepository('JCCommandeBundle:Commande')->findCommandeAvecActiviteEtCollectivite($commande->getApplication()->getActivite(), $collectivite);
						
						//On fait le ratio :
						$ratio = sizeof($cccActiviteCollectivite) / $totalActivite;


						//On calcule le montant à payer grâce au ratio
						$montant = $ratio * $commande->getTotalTTC();
					
						//On stocke le ratio
						$tabCommande[$commande->getId()]['repartition'] = ($ratio*100);

						//On explique le ratio
						$tabCommande[$commande->getId()]['infoRatioText'] = $info->getNombre()." commandes concerne ".$collectivite->getNom().", sur un total de ".$totalCle;
						$tabCommande[$commande->getId()]['infoRatioTitre'] = $commande->getApplication()->getActivite();
						
						
						// ----- IL FAUT AJOUTER UN CHAMPS ACTIVITE DANS LA COMMANDE !!! --------
						
						
						
					//On regarde la clé de repartition (de la commande, car celle de l'application a pu changer entre temps)
					//Puis on va chercher l'information de la collectivite liée à la clée
					//On fait ensuite le ratio (par exemple : nbHabitant_Collectivite_x / nbHabitant_Total)
					// 
					//			total = montantCommande * ratio
					//Avec 
					//			ratio = nbTotalHabitant_Collectivite_x / nbTotalHabitant
					} else {
						
						//On récupere l'InformationCollectivite
						$info = $infosColl[$commande->getActivite()->getCleRepartition()->getNom()];

						//On récupere la "somme des clés", ceci afin de faire un ratio pour la collectivite
						$totalCle = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findSommeDeCleEtAnnee($info->getCleRepartition(), $annee)[1];

						//On fait le ratio
						$ratio = $info->getNombre() / $totalCle;
						
						//On calcule le montant à payer grâce au ratio
						$montant = $ratio * $commande->getTotalTTC();
					
						//On stocke le ratio
						$tabCommande[$commande->getId()]['repartition'] = ($ratio*100);

						//On explique le ratio
						$tabCommande[$commande->getId()]['infoRatioText'] = $info->getNombre()." sur un total de ".$totalCle;
						$tabCommande[$commande->getId()]['infoRatioTitre'] = $ccc->getRepartition();
					}
					
					


					//On met les infos
					$infosColl['montantMutualisees'] += $montant;
					$infosColl['nbMutualisees'] += 1;
					$tabCommande[$commande->getId()]['montantAPayer'] = $montant;
					//$tabCommande[$commande->getId()]['repartition'] = $ccc->getRepartition();
				
				
				//Sinon, si c'est une commande directe
				} else if($commande->getVentilation() === "Directe"){
				
					
					//Pour le calcul, c'est plus simple
					//On prend la répartition (le pourcentage) et on le multiplie au total de la facture
					$montant = $commande->getTotalTTC() * ($ccc->getRepartition()/100);
					
					
					//On met les infos
					$infosColl['montantDirectes'] += $montant;
					$infosColl['nbDirectes'] += 1;
					$tabCommande[$commande->getId()]['montantAPayer'] = $montant;
					$tabCommande[$commande->getId()]['repartition'] = $ccc->getRepartition();
				}			
			
			
		}
    
    
        return $this->render('JCFacturationBundle:Facturation:calcul_facturation.html.twig', array('infosColl'=>$infosColl, 'tabCommandes'=>$tabCommande, 'annee'=>$annee));

    }
    
    
    
    
}
