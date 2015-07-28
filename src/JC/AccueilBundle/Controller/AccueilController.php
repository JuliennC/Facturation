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
		

   		//On recupere la liste des budgets pour l'année donnée
		$listeBudgets = $em->getRepository('JCCommandeBundle:Budget')->getQueryByAnnee($annee)->leftJoin('b.service','s')->addSelect('s')->getQuery()->getResult();	
		
		//On stockera les informations sur les différents services
		$infoServices = array();

		
		//On parcours les budgets
		foreach($listeBudgets as $budget){
			
			
			//Si c'est la première fois que l'on tombe sur ce service
			if(! array_key_exists($budget->getService()->getNom(), $infoServices)) {

				//On l'ajoute à la liste, pour stocker le budget
				$infoServices[$budget->getService()->getNom()] = array();
			}
			
			//On enregistre le budget dans la liste
			$infoServices[$budget->getService()->getNom()][$budget->getLibelle()] = array();

			$infoServices[$budget->getService()->getNom()][$budget->getLibelle()]['libelle'] = $budget->getLibelle();
			$infoServices[$budget->getService()->getNom()][$budget->getLibelle()]['montant'] = $budget->getMontant();
			$infoServices[$budget->getService()->getNom()][$budget->getLibelle()]['montantUtilise'] = 0;
		}
		
		
		// On récupète toutes les commandes qui ont été Enregistrée dans l'année 'date'
		$listePasseEtat = $em->getRepository('JCCommandeBundle:CommandePasseEtat')->findPasseEtatDansAnnee("Enregistree", $annee);
		
		dump('Nombre de commande : '.sizeof($listePasseEtat));
		
		//On récupère la liste des imputations avec les budgets associés
		$listeICB = $em->getRepository('JCCommandeBundle:ImputationConcerneBudget')->findAvecAnnee($annee); 
		
		$listeICBOrganisee = array();
		
		//On organise un tableau pour accèder plus facilement aux informations
		foreach($listeICB as $icb){
			
			//Si c'est la première fois qu'on rencontre l'imputation
			if(! array_key_exists($icb->getImputation()->getId(), $listeICBOrganisee)){
				$listeICBOrganisee[$icb->getImputation()->getId()] = array();
			}
			
			//On stock le budget
			array_push($listeICBOrganisee[$icb->getImputation()->getId()], $icb->getBudget());
		}
		
		
		
		dump($listeICBOrganisee);
		
		//On calcule le total des commandes créées dans l'annee donnée		
		$infoCommandes = array();
		$infoCommandes['nombreCommandesPassees'] = 0;
		$infoCommandes['montantCommandesPassees'] = 0;
		$infoCommandes['nombreCommandesDirectes'] = 0;
		$infoCommandes['montantCommandesDirectes'] = 0;
		$infoCommandes['nombreCommandesMutualisees'] = 0;
		$infoCommandes['montantCommandesMutualisees'] = 0;


		
		foreach($listePasseEtat as $etat){

			$etat = $etat[0];
			
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
			
			
			//On récupère l'imputation de la commande
			$imputation = $commande->getImputation();
			
			$budgetTrouve = null;
			
			//On prend un compteur pour être sur qu'une imputation n'est pas reliée à deux budget d'un même service
			$i = 0;
			
			
			//Si la clé n'existe pas c'est que l'imputation n'est relié à aucun budget
			if (! array_key_exists($imputation->getId(), $listeICBOrganisee)) {
				
				$session = new Session();
				$session->getFlashBag()->add('Warning', 'L\'imputation '.$imputation->getLibelle().' n\'est reliée à aucun budget du service '.$commande->getService()->getNom());


			//Sinon on peut lancer le calcul
			} else {
				
				//On va regarder à quel budget de CE service correspond l'imputation
				foreach($listeICBOrganisee[$imputation->getId()] as $budget){

					//On regarde quel budget correspond au service de la commande
					if($budget->getService() === $commande->getService()){
						
						$budgetTrouve = $budget->getLibelle();
						$i++;
					}
				}
				
				
				//Si service === null, c'est qu'aucun budget de ce service n'est lié à l'imputation, c'est donc une erreur
				if($budgetTrouve === null){
					
					$session = new Session();
					$session->getFlashBag()->add('Warning', 'L\'imputation '.$imputation->getLibelle().' n\' reliée à aucun budget du service '.$commande->getService()->getNom());
				
				} else if ($i > 1) {
					
					$session = new Session();
					$session->getFlashBag()->add('Warning', 'L\'imputation '.$imputation->getLibelle().' est reliée à plusieurs budgets du service '.$commande->getService()->getNom());
							
				} else {
					
					//On stocke les infos
					$infoServices[$commande->getService()->getNom()][$budgetTrouve]['montantUtilise'] += $commande->getTotalTTC();
				
				}
			}
		}
		
		
		dump($infoServices);


        return $this->render('JCAccueilBundle:Accueil:index.html.twig', array('infoCommandes'=>$infoCommandes, 'annee'=>$annee, 'infoServices'=>$infoServices));
    }
    



	public function navBarreAction(Request $request) {
	        
		return $this->render('JCAccueilBundle:Accueil:navBarre.html.twig', array('request'=>$request));
		
	}


	
    
}
