<?php

namespace JC\CommandeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JC\CommandeBundle\Entity\Commande;
use JC\CommandeBundle\Entity\Utilisateur;
use JC\CommandeBundle\Entity\Fournisseur;
use JC\CommandeBundle\Entity\LigneCommande;
use JC\CommandeBundle\Entity\Application;
use JC\CommandeBundle\Entity\Activite;
use JC\CommandeBundle\Entity\Livraison;
use JC\CommandeBundle\Entity\CleRepartition;
use JC\CommandeBundle\Entity\Collectivite;
use JC\CommandeBundle\Entity\CommandeConcerneCollectivite;
use JC\CommandeBundle\Entity\TVA;
use JC\CommandeBundle\Entity\Service;
use JC\CommandeBundle\Entity\Budget;
use JC\CommandeBundle\Entity\EtatCommande;
use JC\CommandeBundle\Entity\CommandePasseEtat;
use JC\CommandeBundle\Entity\InformationCollectivite;
use JC\CommandeBundle\Entity\MasseSalariale;
use JC\CommandeBundle\Entity\TempsPasse;
use JC\CommandeBundle\Entity\Imputation;

use JC\CommandeBundle\Form\CommandeType;


use Symfony\Component\HttpFoundation\JsonResponse;



class CommandeController extends Controller
{
	
	
	/*
	*	Page principale, remplace en quelque sorte index
	*/
	  public function listeAction($service)
	  {
		$em = $this->getDoctrine()->getManager();
		
		
		
		if($service != "html"){

			//On recupere le service
			$s = $em->getRepository('JCCommandeBundle:Service')->findOneByNom($service);
			
			//On recupre toutes les personnes du service
			$pers = $em->getRepository('JCCommandeBundle:Utilisateur')->findByService($s);
			
			//Et on recupere les commande
			$listeCommande = $em->getRepository('JCCommandeBundle:Commande')->findByUtilisateur($pers);  	

			
		} else {
		
			// On recupere toutes les commandes
			$listeCommande = $em->getRepository('JCCommandeBundle:Commande')->findAll();  	
		}
		

	    return $this->render( 'JCCommandeBundle:Commande:liste.html.twig', array('tabCommande' => $listeCommande) );
	  }
	  
	  
	  
	  
	  
	  
	/*
	*	Page qui affiche le detail d'une commande (grÃ¢ce Ã  $id)
	*/
	  public function detailAction($id)
	  {
	   
	    
	    //---------- Recuperation de la commande ----------
	    
	    // On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:Commande') ;

		// On recupere l'entite correspondante Ã  l'id $id
		$commande = $repository->find($id);

		//S'il n'y a pas de commande correspondante ˆ l'id
	    if ($commande === null) {
	      // On declenche une exception NotFoundHttpexception
	      throw new NotFoundHttpexception('Commande "'.$id.'" inexistante.');
	    } 
		

		//	Si la commande n'est ni payee, ni envoyee, on redirige vers la page de moficiation
		if( ($commande->getEtat() === "Creee") || ($commande->getEtat() === "Enregistree")){
								
			//Si la commande est envoye ou payee, on ne peux pas la modifier. en renvoie donc sur la page detail
			return $this->redirect($this->generateUrl('jc_commande_modification', array('id' => $commande->getId())));
		}
			


		//---------- Recuperation des ligne de la commande ----------
		
		// On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:LigneCommande') ;

		// On recupere la liste des lignes correspondante Ã  la commande		
		$commande -> setListeLignesCommande($repository->findLignesCommandeAvecCommande($commande->getId()));
	    
	    
	    //---------- Recuperation des collectivite concernees par la commande ----------
		
		// On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:CommandeConcerneCollectivite') ;

		// On recupere la liste des lignes correspondante Ã  la commande		
		$tabTransition = $repository->findCommandeConcerneCollectiviteAvecCommande($commande->getId());
	    

	 	    	    		
			return $this->render( 'JCCommandeBundle:Commande:detail.html.twig', array('commande' => $commande ,
																						'tabTransition' => $tabTransition) );
	    
	
	}
	  
	  
	  
	  
	  
	  
	  
	/*
	*	action pour creer une commande
	*/
	  public function creationAction(Request $request)
	  {
	
			$em = $this->getDoctrine()->getManager();

			//On cree la commande
			$commande = new Commande(); 
            
            $etatCree = new CommandePasseEtat();
            $etatCree -> setCommande($commande);
            $etatCree -> setEtat($em->getRepository('JCCommandeBundle:EtatCommande')->findOneByLibelle("Creee"));
            $etatCree -> setDatePassage(new \Datetime());
 			
 			$commande -> addEtat($etatCree);

                        
            return $this->miseEnPlaceForm($request, $commande);
	  }
	  
	  
	  
	  
	  
	  
	  
	  
	  	/*
	  	*	action pour modifier une commande
		*/
		public function modificationAction(Request $request, $id)
		{
			$em = $this->getDoctrine()->getManager();

			//On recupere la commande
			$commande = $em->getRepository('JCCommandeBundle:Commande')->findOneById($id); 

			//On recupere aussi les ligne de la commande
			$commande -> setListeLignesCommande($em->getRepository('JCCommandeBundle:LigneCommande')->findLignesCommandeAvecCommande($commande->getId()));


			//	On verifie l'etat de la commande
			if( ($commande->getEtat() === "Envoyee") || ($commande->getEtat() === "Payee")){
				
				//Si la commande est envoye ou payee, on ne peux pas la modifier. en renvoie donc sur la page detail
				return $this->redirect($this->generateUrl('jc_commande_detail', array('id' => $commande->getId())));
			}
			
			return $this->miseEnPlaceForm($request, $commande);
	    	  
		
	}

	  
	  
	  
	  
	  
	  
        /*
		*	action applele a la creation d'une commande
        *      et a la modification d'une commande
        *      C'est elle qui met en place le form et qui gere les submit  
		*/
                public function miseEnPlaceForm(Request $request, $commande)
		{
	  	
			$em = $this->getDoctrine()->getManager();
			
			//	On creee le formulaire avec la commande
            $form = $this->get('form.factory')->create(new CommandeType($em), $commande);
			$form->handleRequest($request);
			
			
                       
			
            //  On recupere la liste des livraisons deja enregistrees
            $listeLivraisons = $em->getRepository('JCCommandeBundle:Livraison')->findLivraisonsOrdreAlpha();
                        
            //  On recupere la liste des fournisseurs deja enregistres
            $listeFournisseurs = $em->getRepository('JCCommandeBundle:Fournisseur')->findFournisseursOrdreAlpha()->getQuery()->getResult();
                        

			//On recupere toutes les villes deja choisie DANS LA BASe De DONNee
            $cCCDejaBDD = $em->getRepository('JCCommandeBundle:CommandeConcerneCollectivite')->findCommandeConcerneCollectiviteAvecCommande($commande->getId());
			
			//On recupere donc toutes les villes
			$listeToutesLesVilles = $em->getRepository('JCCommandeBundle:Collectivite')->findCollectivitesPourDateOrdreAlpha($commande->getDateCreation());
			
			
			//On rŽcupre les ligne de la commandes entrŽes avant la modification du formulaire pour voir les lignes supprimŽes
			$listeLigneComAvant = $em->getRepository('JCCommandeBundle:LigneCommande')->findByCommande($commande);
			
			
			//	Si le formulaire est valide, on l'enregistre en base.
		    if ($form->isValid()) {
			    
                //on recupere la ventialation
			    $ventilation = $form->get('ventilation')->getData();
			    $commande->setVentilation($ventilation);
			    
			    //On enregistre le nom de l'utilisateur 
			    $utilisateur = $form->get('utilisateur')->getData();
			    $commande->setUtilisateur($utilisateur->getNom().' '.$utilisateur->getPrenom());

			    //On enregistre le service correspondant
			    $commande->setService($utilisateur->getService());
			   
			    //	On enregistre l'etat de la commande
			    $etat = $form->get('etat')->getData();

                            
                //On enregistre le lien entre le lieu de livraison et la commande,
                // et le lien du fournisseur et la commande

                if($etat === "Creee"){
                    $this->creeeToEnregistree($commande);
                    $etat = "Enregistree";
                }
                        
                
                            
                //On supprime toutes les villes concernees
                foreach($cCCDejaBDD as $coll){
                    $em->remove($coll);
                }
                          
                          
                //Si la commande est une commande directe, 
                //Les villes selectionnŽes sont les villes qui n'ont pas d'input vide
                if($ventilation === "Directe"){
					
	            	//On parcours donc toutes les villes pour trouver leur input
	            	foreach($listeToutesLesVilles as $ville){
		            	
		            	//On rŽcupre leur input
		            	$nbD = $form->get('repartition'.$ville->getId())->getData();
		            	
		            	//Si l'input n'est pas vide, on ajoute un CommandeConcerneCollectivite
		            	if(sizeof($nbD) > 0){
			            	
			            	//On cree une ccc, on la lie a la commande, a la collectivite et on met la repartition					
							$cCC = new CommandeConcerneCollectivite();
		                    $cCC->setCommande($commande);
		                    $cCC->setCollectivite($em->getRepository('JCCommandeBundle:Collectivite')->findOneByNom($ville->getNom()));
		                    
		                    //La repartition est donc la cle de l'application concernee
		                    $cCC->setRepartition($nbD);
	
							$em->persist($cCC);
		            	}
	            	}    
	            
	            
	            
	            //Si la commande est une commande mutualisee,
	            //On doit uniquement recupere les villes gr‰ce ˆ leur checkbox
	            } else if($ventilation === "Mutualisee") {
		            
		            //On recupere les villes selectionnees dans le formulaire
					$listeNomVillesChoisiesFormulaire = $form->get('villes_concernees')->getData();
                            
                    //On parcours toutes les villes choisie dans le formulaire
					foreach($listeNomVillesChoisiesFormulaire as $nomColl){

						//On cree une ccc, on la lie a la commande, a la collectivite et on met la repartition					
						$cCC = new CommandeConcerneCollectivite();
	                    $cCC->setCommande($commande);
	                    $cCC->setCollectivite($em->getRepository('JCCommandeBundle:Collectivite')->findOneByNom($nomColl));
	                    
	                    //La repartition est donc la cle de l'application concernee
	                    $cCC->setRepartition($commande->getActivite()->getCleRepartition()->getNom());

						$em->persist($cCC);
					}
	            }
                 
               
               	//On enregistre les lignes de commandes entrees
			    $nouveauTabLigneCommande = $form->get('listeLignesCommande')->getData();
			    
				
				//On regarde si des lignes ont ŽtŽ supprimŽes
				foreach($listeLigneComAvant as $ligne){
					
					if (! in_array($ligne, $nouveauTabLigneCommande)){
						$em->remove($ligne);
					}
				}
				
				
				
			
			    $montantCommande = 0;
			    
			    foreach($nouveauTabLigneCommande as $n){
				    
				    //On additionne le montant total de la commande
				    $montantCommande += $n->getTotalTTC();
				    
					$n -> setCommande($commande);
					$em->persist($n);
			    }

				//On remet le bon montant de la commnande
				$commande -> setTotalTTC($montantCommande);
					
				$em->persist($commande);
        		$em->flush();
                                
                                 
                                 
                                 
                $etats = $em->getRepository('JCCommandeBundle:CommandePasseEtat')->findEtatPourCommande($commande, $etat);            	

            	if(sizeof($etats) === 0){ 
					$etatCree = new CommandePasseEtat();
					$etatCree -> setCommande($commande);
					$etatCree -> setEtat($em->getRepository('JCCommandeBundle:EtatCommande')->findOneByLibelle($etat));
					$etatCree -> setDatePassage(new \Datetime());
					$em->persist($etatCree);
        		}
        		$em->flush();

        		
                                //On redirige, il ne faut donc que l'id de la commande
				return $this->redirect($this->generateUrl('jc_commande_modification', array('id'=>$commande->getId())));

				
				
				
			} else {
                            
                //On affiche le formulaire, il faut donc plus d'informations
				return $this->render('JCCommandeBundle:Commande:modification.html.twig', array( 'form' => $form->createView(), 'commande'=>$commande , 
																								'cCCDejaBDD'=>$cCCDejaBDD,'tabVilles'=>$listeToutesLesVilles, 																													'listeLivraisons'=>$listeLivraisons, 'listeFournisseurs'=>$listeFournisseurs));	
	    	}
	    	  
		
	}

	  
	  
	  
	  
	  	// ---------- AUTRES FONCTIONS ----------
	
        
                /*
	  	* Fonction qui enregistre les infos lorsqu'une commande n'est que creee,
                * elle enregistre les changements dans les tables livraison et fournisseur
                * elle retourne la commande
	  	*/
	  	public function creeeToEnregistree($commande) {
                    			$em = $this->getDoctrine()->getManager();

                    // ----- On enregistre le lieux -----
                                // On recherche si un lieu existe deja avec ce nom
                                $liste = $em->getRepository('JCCommandeBundle:Livraison')->findByNom($commande->getNomLivraison());
                                
                                // Si oui, on le met a jour
                                if(sizeof($liste) > 0) {
                                    $lieu = $liste[0];

                                } else {
                                    $lieu = new Livraison();
                                }
                                
                                $lieu->setAdresse($commande->getAdresseLivraison());
                                $lieu->setComplementAdresse($commande->getComplementAdresseLivraison());
                                $lieu->setCodePostal($commande->getCodePostalLivraison());
                                $lieu->setVille($commande->getVilleLivraison());
                                $lieu->setTelephone($commande->getTelephoneLivraison());
                                $em->persist($lieu);
                                                                    
                                $commande->setLivraison($lieu);
                                
                                // ----- On enregistre le fournsieeur -----
                                // On recherche si un fournisseur existe deja avec ce nom
                                $liste = $em->getRepository('JCCommandeBundle:Fournisseur')->findByNom($commande->getNomFournisseur());

                                // Si oui, on le met a jour
                                if(sizeof($liste) > 0) {
                                    $fournisseur = $liste[0];

                                } else {
                                    $fournisseur = new Fournisseur();
                                }
                                
                                $fournisseur->setAdresse($commande->getAdresseFournisseur());
                                $fournisseur->setComplementAdresse($commande->getComplementAdresseFournisseur());
                                $fournisseur->setCodePostal($commande->getCodePostalFournisseur());
                                $fournisseur->setVille($commande->getVilleFournisseur());
                                $fournisseur->setTelephone($commande->getTelephoneFournisseur());
                                $em->persist($fournisseur);
                                
                                $commande->setFournisseur($fournisseur);
                                
                                
                                
                                return $commande;
                }
        
        
	
	  	/*
	  	*		Fonction qui retourne les TVA
	  	*/
	  	public function getTVAAction() {
		  
		  	$request = $this->container->get('request');

	  		if($request->isXmlHttpRequest()) {
		    
	
				$em = $this->getDoctrine()->getManager();
	
	            $repository = $em->getRepository('JCCommandeBundle:TVA') ;
		
				$tva = $repository->getTVACroissant()->getQuery()->getResult();
				
				$tabReponse = array();
				
				foreach($tva as $t){
					array_push($tabReponse, array('id' => $t->getId(), 'pourcentage' => $t->getPourcentage()));
				}
				
				//On prepare la reponse
				$response = new JsonResponse($tabReponse);
																			
	            return $response;


            }  else {
	            
	            $response = new JsonResponse("Non non ..");
																			
	            return $response;
            }
   	        	
		}
	  
	  
	  
	  
	  
		/*
		*		Fonction qui retourne les applications correspondantes Ã  une activite  
	  	*/
	  	public function applicationPourActiviteAction() {
		  
	  
	  		$request = $this->container->get('request');

	  		//if($request->isXmlHttpRequest()) {
		    
	        $nomActivite = '';
	        $nomActivite = $request->get('act');
	
			$em = $this->getDoctrine()->getManager();


	        if($nomActivite != '') {


	               $repository = $em->getRepository('JCCommandeBundle:Application') ;
	
				   $applications = $repository->getApplicationWithActiviteName($nomActivite)->getQuery()->getResult();

				   $tabNomApplications = array();
				   
				   /*foreach($applications as $app) {
					   array_push($tabNomApplications, $app->getNom());
				   }*/

				   //On prepare la reponse
				   $response = new JsonResponse($applications);
				   /*$response->setData(array(
				   		'data' => $tabNomApplications
				   	));*/


															
                    return $response;
                    
                    
				   /*return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Acteur:liste.html.twig', array(
				   'acteurs' => $acteurs*/
	           
	        } else {
				echo("non");
		    	return $this->redirect($this->generateUrl('jc_commande_creation'));
	        }
	
	        
	    
			
	  	}
	  	  
	  	  
	  	  
	  	  
	  	  /*
	  	*		Fonction qui marque une commande ˆ payŽe
	  	*/
	  	public function marqueCommandePayeeAction() {
		  
		  	$request = $this->container->get('request');
		  	
		  	
	        $idCom = '';
	        $idCom = $request->get('id');

	  		if($request->isXmlHttpRequest() && $idCom != '') {
		    
	
				$em = $this->getDoctrine()->getManager();
	
	            $com = $em->getRepository('JCCommandeBundle:Commande')->findOneById($idCom) ;
				
				$etatCree = new CommandePasseEtat();
				$etatCree -> setCommande($com);
				$etatCree -> setEtat($em->getRepository('JCCommandeBundle:EtatCommande')->findOneByLibelle("Payee"));
				$etatCree -> setDatePassage(new \Datetime());
				$em->persist($etatCree);
				
				$em->flush();
				//On prepare la reponse
				$response = new JsonResponse(true);
																			
	            return $response;


            }  else {
	            
	            $response = new JsonResponse("Non non ..");
																			
	            return $response;
            }
   	        	
		}
	  	  
	  	  
	  	  
	  public function bAction(){
		  // Creation d'une activite		
		$activite3 = new Activite();
		$activite3 -> setNom('Gerer les postes adm');
		$activite3 -> setCleRepartition($cle);
		$em->persist($activite3);		
			
		$activite4 = new Activite();
		$activite4 -> setNom('Gerer les smartphones / tablettes');
		$activite4 -> setUniteOeuvre(67890);
		$activite4 -> setCleRepartition($cle2);
		$em->persist($activite4);
		
		$activite5 = new Activite();
		$activite5 -> setNom('Gerer les postes Žcoles');
		$activite5 -> setUniteOeuvre(12345);
		$activite5 -> setCleRepartition($cle);
		$em->persist($activite5);
				
		$activite6 = new Activite();
		$activite6 -> setNom('Gerer les postes internet publiques');
		$activite6 -> setUniteOeuvre(67890);
		$activite6 -> setCleRepartition($cle2);
		$em->persist($activite6);
	
		$activite7 = new Activite();
		$activite7 -> setNom('Gerer les telecoms');
		$activite7 -> setUniteOeuvre(12345);
		$activite7 -> setCleRepartition($cle);
		$em->persist($activite7);
		
		$activite8 = new Activite();
		$activite8 -> setNom("Gerer l'infrastructure");
		$activite8 -> setUniteOeuvre(67890);
		$activite8 -> setCleRepartition($cle2);
		$em->persist($activite8);		
		
		$activite9 = new Activite();
		$activite9 -> setNom("Intervenir sur demande - Bureautique");
		$activite9 -> setUniteOeuvre(67890);
		$activite9 -> setCleRepartition($cle);
		$em->persist($activite9);		
		
		$activite10 = new Activite();
		$activite10 -> setNom("Intervenir sur demande - Infrastructure");
		$activite10 -> setUniteOeuvre(67890);
		$activite10 -> setCleRepartition($cle2);
		$em->persist($activite10);
		
		$activite11 = new Activite();
		$activite11 -> setNom("Intervenir sur demande - Etude");
		$activite11 -> setUniteOeuvre(67890);
		$activite11 -> setCleRepartition($cle);
		$em->persist($activite11);

		$activite2 = new Activite();
		$activite2 -> setNom('Gerer FI');
		$activite2 -> setUniteOeuvre(67890);
		$activite2 -> setCleRepartition($cle2);
		$em->persist($activite2);

		$activite12 = new Activite();
		$activite12 -> setNom('Gerer POP');
		$activite12 -> setUniteOeuvre(67890);
		$activite12 -> setCleRepartition($cle);
		$em->persist($activite12);
		
		$activite = new Activite();
		$activite -> setNom('Gerer RH');
		$activite -> setUniteOeuvre(12345);
		$activite -> setCleRepartition($cle);
		$em->persist($activite);

		$activite13 = new Activite();
		$activite13 -> setNom('Gerer GEST');
		$activite13 -> setUniteOeuvre(67890);
		$activite13 -> setCleRepartition($cle2);
		$em->persist($activite13);
		
		$activite14 = new Activite();
		$activite14 -> setNom('Gerer TECH');
		$activite14 -> setUniteOeuvre(67890);
		$activite14 -> setCleRepartition($cle);
		$em->persist($activite14);
			
		$activite15 = new Activite();
		$activite15 -> setNom('Gerer WEB');
		$activite15 -> setUniteOeuvre(67890);
		$activite15 -> setCleRepartition($cle2);
		$em->persist($activite15);
			
		$activite16 = new Activite();
		$activite16 -> setNom('Gerer SIG');
		$activite16 -> setUniteOeuvre(67890);
		$activite16 -> setCleRepartition($cle);
		$em->persist($activite16);	
		
		$activite17 = new Activite();
		$activite17 -> setNom('Gerer SOC');
		$activite17 -> setUniteOeuvre(67890);
		$activite17 -> setCleRepartition($cle2);
		$em->persist($activite17);	
				
		$activite18 = new Activite();
		$activite18 -> setNom('Gerer CULT');
		$activite18 -> setUniteOeuvre(67890);
		$activite18 -> setCleRepartition($cle);
		$em->persist($activite18);	
		
		$em->flush();
	  }
	  
	 
	// Fonction qui sera supprimee -- sert uniquement Ã  inserer dans la base de donnee
	  
	  
	public function bddAction(){
		  
		 var_dump("insert");		  
		// On recupere l'entityManager
		$em = $this->getDoctrine()->getManager();

		
		// Creation des services
		$service1 = new Service();
		$service1->setNom("Bureautique");
		$service1->setEstAncienService(false);
		$em->persist($service1);

		$service2 = new Service();
		$service2->setNom("Etude");
		$service1->setEstAncienService(false);
		$em->persist($service2);

	
		
		
		//CrŽation des budgets
		$budget1 = new Budget();
		$budget1->setMontant(1200000);
		$budget1->setAnnee("2014");
		$budget1->setService($service1);
		$em->persist($budget1);

		$budget2 = new Budget();
		$budget2->setMontant(1340000);
		$budget2->setAnnee("2014");
		$budget2->setService($service2);
		$em->persist($budget2);

		
		// Creation d'un utilisateur
		$utilisateur = new Utilisateur();
		$utilisateur->setNom('DUPONT');
		$utilisateur->setPrenom('Paul');
		$utilisateur->setService($service1);
		$em->persist($utilisateur);

		// Creation d'un utilisateur
		$utilisateur2 = new Utilisateur();
		$utilisateur2 ->setNom('GERMAIN');
		$utilisateur2 ->setPrenom('Pierre');
		$utilisateur2 ->setService($service2);
		$em->persist($utilisateur2);

		
		
		
		// Creation d'un fournisseur
		$fournisseur = new Fournisseur();
		$fournisseur ->setNom('Fournisseur_1');
		$fournisseur ->setAdresse('Addresse fournisseur 1');
		$fournisseur -> setComplementAdresse('complement add fournisseur 1');
		$fournisseur -> setCodePostal(54000);
		$fournisseur -> setVille('Nancy');
		$fournisseur -> setTelephone("0383297218");
		$fournisseur -> setFax("08383909090");
		$em->persist($fournisseur);
		
		// Creation d'un fournisseur
		$fournisseur2 = new Fournisseur();
		$fournisseur2 ->setNom('Fournisseur_2');
		$fournisseur2 ->setAdresse('Addresse fournisseur 2');
		$fournisseur2 -> setComplementAdresse('complement add fournisseur 2');
		$fournisseur2 -> setCodePostal(54000);
		$fournisseur2 -> setVille('Nancy');
		$fournisseur2 -> setTelephone("0383297218");
		$fournisseur2 -> setFax("08383909090");
		$em->persist($fournisseur2);



		// Creation d'une cle de repartition
		$cle = new CleRepartition();
		$cle -> setNom("Nombre d'habitant");
		$em->persist($cle);

		$cle2 = new CleRepartition();
		$cle2 -> setNom("Nombre de bulletin de paie");
		$em->persist($cle2);

		
		

		// Creation d'une activite		
		$activite3 = new Activite();
		$activite3 -> setNom('Gerer les postes adm');
		$activite3 -> setCleRepartition($cle);
		$em->persist($activite3);		
			
		$activite4 = new Activite();
		$activite4 -> setNom('Gerer les smartphones / tablettes');
		$activite4 -> setUniteOeuvre(67890);
		$activite4 -> setCleRepartition($cle2);
		$em->persist($activite4);
		
		$activite5 = new Activite();
		$activite5 -> setNom('Gerer les postes Žcoles');
		$activite5 -> setUniteOeuvre(12345);
		$activite5 -> setCleRepartition($cle);
		$em->persist($activite5);
				
		$activite6 = new Activite();
		$activite6 -> setNom('Gerer les postes internet publiques');
		$activite6 -> setUniteOeuvre(67890);
		$activite6 -> setCleRepartition($cle2);
		$em->persist($activite6);
	
		$activite7 = new Activite();
		$activite7 -> setNom('Gerer les telecoms');
		$activite7 -> setUniteOeuvre(12345);
		$activite7 -> setCleRepartition($cle);
		$em->persist($activite7);
		
		$activite8 = new Activite();
		$activite8 -> setNom("Gerer l'infrastructure");
		$activite8 -> setUniteOeuvre(67890);
		$activite8 -> setCleRepartition($cle2);
		$em->persist($activite8);		
		
		$activite9 = new Activite();
		$activite9 -> setNom("Intervenir sur demande - Bureautique");
		$activite9 -> setUniteOeuvre(67890);
		$activite9 -> setCleRepartition($cle);
		$em->persist($activite9);		
		
		$activite10 = new Activite();
		$activite10 -> setNom("Intervenir sur demande - Infrastructure");
		$activite10 -> setUniteOeuvre(67890);
		$activite10 -> setCleRepartition($cle2);
		$em->persist($activite10);
		
		$activite11 = new Activite();
		$activite11 -> setNom("Intervenir sur demande - Etude");
		$activite11 -> setUniteOeuvre(67890);
		$activite11 -> setCleRepartition($cle);
		$em->persist($activite11);

		$activite2 = new Activite();
		$activite2 -> setNom('Gerer FI');
		$activite2 -> setUniteOeuvre(67890);
		$activite2 -> setCleRepartition($cle2);
		$em->persist($activite2);

		$activite12 = new Activite();
		$activite12 -> setNom('Gerer POP');
		$activite12 -> setUniteOeuvre(67890);
		$activite12 -> setCleRepartition($cle);
		$em->persist($activite12);
		
		$activite = new Activite();
		$activite -> setNom('Gerer RH');
		$activite -> setUniteOeuvre(12345);
		$activite -> setCleRepartition($cle);
		$em->persist($activite);

		$activite13 = new Activite();
		$activite13 -> setNom('Gerer GEST');
		$activite13 -> setUniteOeuvre(67890);
		$activite13 -> setCleRepartition($cle2);
		$em->persist($activite13);
		
		$activite14 = new Activite();
		$activite14 -> setNom('Gerer TECH');
		$activite14 -> setUniteOeuvre(67890);
		$activite14 -> setCleRepartition($cle);
		$em->persist($activite14);
			
		$activite15 = new Activite();
		$activite15 -> setNom('Gerer WEB');
		$activite15 -> setUniteOeuvre(67890);
		$activite15 -> setCleRepartition($cle2);
		$em->persist($activite15);
			
		$activite16 = new Activite();
		$activite16 -> setNom('Gerer SIG');
		$activite16 -> setUniteOeuvre(67890);
		$activite16 -> setCleRepartition($cle);
		$em->persist($activite16);	
		
		$activite17 = new Activite();
		$activite17 -> setNom('Gerer SOC');
		$activite17 -> setUniteOeuvre(67890);
		$activite17 -> setCleRepartition($cle2);
		$em->persist($activite17);	
				
		$activite18 = new Activite();
		$activite18 -> setNom('Gerer CULT');
		$activite18 -> setUniteOeuvre(67890);
		$activite18 -> setCleRepartition($cle);
		$em->persist($activite18);	
		
		
				
		
		//Creation des masses salarial pour les service
		$masse1 = new MasseSalariale();
		$masse1 -> setMontant(200000);
		$masse1 -> setAnnee(2014);
		$masse1 -> setActivite($activite);
		$em->persist($masse1);

		$masse2 = new MasseSalariale();
		$masse2 -> setMontant(350000);
		$masse2 -> setAnnee(2014);
		$masse2 -> setActivite($activite2);
		$em->persist($masse2);
		
		
		
		
		// Creation d'une application
		$application = new Application();
		$application -> setNom('Logitud - Municipol');
		$application -> setFournisseur($fournisseur);
		$em->persist($application);

		$application2 = new Application();
		$application2 -> setNom('Ares - Multifacturation');
		$application2 -> setFournisseur($fournisseur);
		$em->persist($application2);
		
		
		
		
		// Creation d'un lieu de livraison
		$livraison = new Livraison();
		$livraison -> setNom('Communaute Ubraine du Grand-Nancy');
		$livraison -> setAdresse("6 rue de mon desert");
		$livraison -> setComplementAdresse("DSIT - bureautique - telephonie - 1er etage");
		$livraison -> setCodePostal(54000);
		$livraison -> setVille("Nancy");
		$livraison -> setTelephone("0383010203");
		$em->persist($livraison);		
		
		
		
		// Creation d'une collectivite et de ses informations
		$coll1 = new Collectivite();
		$coll1 -> setNom('Grand-Nancy');
		$coll1 -> setDateDebutMutualisation(new \Datetime("2013-07-08"));
		$coll1 -> setDateFinMutualisation(new \Datetime("2025-12-31"));
		$em->persist($coll1);		
		
		$info_Coll_1 = new InformationCollectivite();
		$info_Coll_1 -> setNombre('105000');		
		$info_Coll_1 -> setAnnee("2014");	
		$info_Coll_1 -> setCleRepartition($cle);	
		$info_Coll_1 -> setCollectivite($coll1);	
		$em->persist($info_Coll_1);

		$info_Coll_1_2 = new InformationCollectivite();
		$info_Coll_1_2 -> setNombre('30045');		
		$info_Coll_1_2 -> setAnnee("2014");	
		$info_Coll_1_2 -> setCleRepartition($cle2);	
		$info_Coll_1_2 -> setCollectivite($coll1);	
		$em->persist($info_Coll_1_2);



		$coll2 = new Collectivite();
		$coll2 -> setNom('Saint-Max');
		$coll2 -> setDateDebutMutualisation(new \Datetime("2013-07-08"));
		$coll2 -> setDateFinMutualisation(new \Datetime("2025-12-31"));
		$em->persist($coll2);		
		
		$info_Coll_2 = new InformationCollectivite();
		$info_Coll_2 -> setNombre('9870');		
		$info_Coll_2 -> setAnnee("2014");		
		$info_Coll_2 -> setCleRepartition($cle);	
		$info_Coll_2 -> setCollectivite($coll2);	
		$em->persist($info_Coll_2);
		
		$info_Coll_2_2 = new InformationCollectivite();
		$info_Coll_2_2 -> setNombre('1203');		
		$info_Coll_2_2 -> setAnnee("2014");	
		$info_Coll_2_2 -> setCleRepartition($cle2);	
		$info_Coll_2_2 -> setCollectivite($coll2);	
		$em->persist($info_Coll_2_2);
		
		
		
		$coll3 = new Collectivite();
		$coll3 -> setNom('Vandoeuvre');
		$coll3 -> setDateDebutMutualisation(new \Datetime("2013-07-08"));
		$coll3 -> setDateFinMutualisation(new \Datetime("2025-12-31"));
		$em->persist($coll3);

		$info_Coll_3 = new InformationCollectivite();
		$info_Coll_3 -> setNombre('22000');		
		$info_Coll_3 -> setAnnee("2014");
		$info_Coll_3 -> setCleRepartition($cle);	
		$info_Coll_3 -> setCollectivite($coll3);	
		$em->persist($info_Coll_3);

		$info_Coll_3_2 = new InformationCollectivite();
		$info_Coll_3_2 -> setNombre('1392');		
		$info_Coll_3_2 -> setAnnee("2014");	
		$info_Coll_3_2 -> setCleRepartition($cle2);	
		$info_Coll_3_2 -> setCollectivite($coll3);	
		$em->persist($info_Coll_3_2);
		


		$coll4 = new Collectivite();
		$coll4 -> setNom('Malzeville');
		$coll4 -> setDateDebutMutualisation(new \Datetime("2013-07-08"));
		$coll4 -> setDateFinMutualisation(new \Datetime("2025-12-31"));
		$em->persist($coll4);		
		
		$info_Coll_4 = new InformationCollectivite();
		$info_Coll_4 -> setNombre('5640');		
		$info_Coll_4 -> setAnnee("2014");
		$info_Coll_4 -> setCleRepartition($cle);	
		$info_Coll_4 -> setCollectivite($coll4);	
		$em->persist($info_Coll_4);
		
		$info_Coll_4_2 = new InformationCollectivite();
		$info_Coll_4_2 -> setNombre('123');		
		$info_Coll_4_2 -> setAnnee("2014");	
		$info_Coll_4_2 -> setCleRepartition($cle2);	
		$info_Coll_4_2 -> setCollectivite($coll4);	
		$em->persist($info_Coll_4_2);
		
		

		$coll5 = new Collectivite();
		$coll5 -> setNom('Tomblaine');
		$coll5 -> setDateDebutMutualisation(new \Datetime("2013-07-08"));
		$coll5 -> setDateFinMutualisation(new \Datetime("2025-12-31"));
		$em->persist($coll5);		
		
		$info_Coll_5 = new InformationCollectivite();
		$info_Coll_5 -> setNombre('13028');		
		$info_Coll_5 -> setAnnee("2014");	
		$info_Coll_5 -> setCleRepartition($cle);
		$info_Coll_5 -> setCollectivite($coll5);	
		$em->persist($info_Coll_5);
		
		$info_Coll_5_2 = new InformationCollectivite();
		$info_Coll_5_2 -> setNombre('983');		
		$info_Coll_5_2 -> setAnnee("2014");	
		$info_Coll_5_2 -> setCleRepartition($cle2);	
		$info_Coll_5_2 -> setCollectivite($coll5);	
		$em->persist($info_Coll_5_2);
		
		


		$coll6 = new Collectivite();
		$coll6 -> setNom('essey-les-Nancy');
		$coll6 -> setDateDebutMutualisation(new \Datetime("2013-07-08"));
		$coll6 -> setDateFinMutualisation(new \Datetime("2025-12-31"));
		$em->persist($coll6);	
		
		$info_Coll_6 = new InformationCollectivite();
		$info_Coll_6 -> setNombre('7892');		
		$info_Coll_6 -> setAnnee("2014");	
		$info_Coll_6 -> setCleRepartition($cle);	
		$info_Coll_6 -> setCollectivite($coll6);	
		$em->persist($info_Coll_6);
	
		$info_Coll_6_2 = new InformationCollectivite();
		$info_Coll_6_2 -> setNombre('234');		
		$info_Coll_6_2 -> setAnnee("2014");	
		$info_Coll_6_2 -> setCleRepartition($cle2);	
		$info_Coll_6_2 -> setCollectivite($coll6);	
		$em->persist($info_Coll_6_2);
	



		//Creation des temps passŽs
		$temps1 = new TempsPasse();
		$temps1 -> setPourcentage(30);
		$temps1 -> setAnnee(2014);
		$temps1 -> setActivite($activite);
		$temps1 -> setCollectivite($coll1);
		$em->persist($temps1);
		
		
		$temps2 = new TempsPasse();
		$temps2 -> setPourcentage(15);
		$temps2 -> setAnnee(2014);
		$temps2 -> setActivite($activite);
		$temps2 -> setCollectivite($coll2);
		$em->persist($temps2);
		
		$temps3 = new TempsPasse();
		$temps3 -> setPourcentage(25);
		$temps3 -> setAnnee(2014);
		$temps3 -> setActivite($activite);
		$temps3 -> setCollectivite($coll3);
		$em->persist($temps3);
		
		$temps4 = new TempsPasse();
		$temps4 -> setPourcentage(10);
		$temps4 -> setAnnee(2014);
		$temps4 -> setActivite($activite);
		$temps4 -> setCollectivite($coll4);
		$em->persist($temps4);
		
		$temps5 = new TempsPasse();
		$temps5 -> setPourcentage(10);
		$temps5 -> setAnnee(2014);
		$temps5 -> setActivite($activite);
		$temps5 -> setCollectivite($coll5);
		$em->persist($temps5);
		
		$temps6 = new TempsPasse();
		$temps6 -> setPourcentage(10);
		$temps6 -> setAnnee(2014);
		$temps6 -> setActivite($activite);
		$temps6 -> setCollectivite($coll6);
		$em->persist($temps6);
		
		
		$temps1_2 = new TempsPasse();
		$temps1_2 -> setAnnee(2014);
		$temps1_2 -> setPourcentage(30);
		$temps1_2 -> setActivite($activite2);
		$temps1_2 -> setCollectivite($coll1);
		$em->persist($temps1_2);
		
		$temps2_2 = new TempsPasse();
		$temps2_2 -> setPourcentage(15);
		$temps2_2 -> setAnnee(2014);
		$temps2_2 -> setActivite($activite2);
		$temps2_2 -> setCollectivite($coll2);
		$em->persist($temps2_2);
		
		$temps3_2 = new TempsPasse();
		$temps3_2 -> setPourcentage(25);
		$temps3_2 -> setAnnee(2014);
		$temps3_2 -> setActivite($activite2);
		$temps3_2 -> setCollectivite($coll3);
		$em->persist($temps3_2);
		
		$temps4_2 = new TempsPasse();
		$temps4_2 -> setPourcentage(10);
		$temps4_2 -> setActivite($activite2);
		$temps4_2 -> setAnnee(2014);
		$temps4_2 -> setCollectivite($coll4);
		$em->persist($temps4_2);
		
		$temps5_2 = new TempsPasse();
		$temps5_2 -> setPourcentage(10);
		$temps5_2 -> setAnnee(2014);
		$temps5_2 -> setActivite($activite2);
		$temps5_2 -> setCollectivite($coll5);
		$em->persist($temps5_2);
		
		$temps6_2 = new TempsPasse();
		$temps6_2 -> setPourcentage(10);
		$temps6_2 -> setAnnee(2014);
		$temps6_2 -> setActivite($activite2);
		$temps6_2 -> setCollectivite($coll6);
		$em->persist($temps6_2);
		
		
		//On crŽe les imputations
		$imputation1 = new Imputation();
		$imputation1 -> setLibelle("Maintenance des Logiciels");
		$imputation1 -> setSousFonction("020.3");
		$imputation1 -> setArticle("6156");
		$imputation1 -> setSection("Investissement");
		$em->persist($imputation1);


		$imputation2 = new Imputation();
		$imputation2 -> setLibelle("Formations");
		$imputation2 -> setSousFonction("020.3");
		$imputation2 -> setArticle("6184");
		$imputation2 -> setSection("Fonctionnement");
		$em->persist($imputation2);



		$commande1 = new Commande();
		$commande1 -> setVentilation("Mutualisee");
		$commande1 -> setReference("ReFint78_1");
		$commande1 -> setImputation($imputation1);
		$commande1 -> setengagement("engag 90");
		$commande1 -> setFournisseur($fournisseur);
		$commande1 -> setUtilisateur($utilisateur->getNom().' '.$utilisateur->getPrenom());
		$commande1 -> setService($utilisateur->getService());
		$commande1 -> setApplication($application);
		$commande1 -> setActivite($activite);
		$commande1 -> setLivraison($livraison);
		$commande1 -> setLibelleFacturation("llll");
        $commande1 -> setNomLivraison($livraison->getNom());
        $commande1 -> setAdresseLivraison($livraison->getAdresse());
        $commande1 -> setComplementAdresseLivraison($livraison->getComplementAdresse());
        $commande1 -> setTelephoneLivraison($livraison->getTelephone());
        $commande1 -> setVilleLivraison($livraison->getVille());
        $commande1 -> setCodePostalLivraison($livraison->getCodePostal());
        $commande1 -> setNomFournisseur($fournisseur->getNom());
        $commande1 -> setAdresseFournisseur($fournisseur->getAdresse());
        $commande1 -> setComplementAdresseFournisseur($fournisseur->getComplementAdresse());
        $commande1 -> setTelephoneFournisseur($fournisseur->getTelephone());
        $commande1 -> setVilleFournisseur($fournisseur->getVille());
        $commande1 -> setCodePostalFournisseur($fournisseur->getCodePostal());
		$em->persist($commande1);
		
		
		$commande2 = new Commande();
		$commande2 -> setVentilation("Directe");
		$commande2 -> setReference("ReFint78_2");
		$commande2 -> setImputation($imputation1);
		$commande2 -> setengagement("engag 90");
		$commande2 -> setFournisseur($fournisseur);
		$commande2 -> setUtilisateur($utilisateur->getNom().' '.$utilisateur->getPrenom());
		$commande2 -> setService($utilisateur->getService());
		$commande2 -> setApplication($application2);
		$commande2 -> setActivite($activite);
		$commande2 -> setLivraison($livraison);
		$commande2 -> setLibelleFacturation("llll");
        $commande2 -> setNomLivraison($livraison->getNom());
        $commande2 -> setAdresseLivraison($livraison->getAdresse());
        $commande2 -> setComplementAdresseLivraison($livraison->getComplementAdresse());
        $commande2 -> setTelephoneLivraison($livraison->getTelephone());
        $commande2 -> setVilleLivraison($livraison->getVille());
        $commande2 -> setCodePostalLivraison($livraison->getCodePostal());
        $commande2 -> setNomFournisseur($fournisseur->getNom());
        $commande2 -> setAdresseFournisseur($fournisseur->getAdresse());
        $commande2 -> setComplementAdresseFournisseur($fournisseur->getComplementAdresse());
        $commande2 -> setTelephoneFournisseur($fournisseur->getTelephone());
        $commande2 -> setVilleFournisseur($fournisseur->getVille());
        $commande2 -> setCodePostalFournisseur($fournisseur->getCodePostal());
		$em->persist($commande2);
		

		$commande3 = new Commande();
		$commande3 -> setVentilation("Mutualisee");
		$commande3 -> setReference("ReFint78_3");
		$commande3 -> setImputation($imputation2);		
		$commande3 -> setengagement("engag 90");
		$commande3 -> setFournisseur($fournisseur2);
		$commande3 -> setUtilisateur($utilisateur2->getNom().' '.$utilisateur2->getPrenom());
		$commande3 -> setService($utilisateur2->getService());
		$commande3 -> setApplication($application);
		$commande3 -> setActivite($activite2);
		$commande3 -> setLivraison($livraison);
		$commande3 -> setLibelleFacturation("llll");
        $commande3 -> setNomLivraison($livraison->getNom());
        $commande3 -> setAdresseLivraison($livraison->getAdresse());
        $commande3 -> setComplementAdresseLivraison($livraison->getComplementAdresse());
        $commande3 -> setTelephoneLivraison($livraison->getTelephone());
        $commande3 -> setVilleLivraison($livraison->getVille());
        $commande3 -> setCodePostalLivraison($livraison->getCodePostal());
		$commande3 -> setNomFournisseur($fournisseur2->getNom());
        $commande3 -> setAdresseFournisseur($fournisseur2->getAdresse());
        $commande3 -> setComplementAdresseFournisseur($fournisseur2->getComplementAdresse());
        $commande3 -> setTelephoneFournisseur($fournisseur2->getTelephone());
        $commande3 -> setVilleFournisseur($fournisseur2->getVille());
        $commande3 -> setCodePostalFournisseur($fournisseur2->getCodePostal());
        $em->persist($commande3);
                
		
		$commande4 = new Commande();
		$commande4 -> setVentilation("Directe");
		$commande4 -> setReference("ReFint78-4");
		$commande4 -> setImputation($imputation2);		
		$commande4 -> setengagement("engag 90");
		$commande4 -> setFournisseur($fournisseur2);
		$commande4 -> setUtilisateur($utilisateur2->getNom().' '.$utilisateur2->getPrenom());
		$commande4 -> setService($utilisateur2->getService());
		$commande4 -> setApplication($application2);
		$commande4 -> setActivite($activite2);
		$commande4 -> setLivraison($livraison);
		$commande4 -> setLibelleFacturation("llll");
        $commande4 -> setNomLivraison($livraison->getNom());
        $commande4 -> setAdresseLivraison($livraison->getAdresse());
        $commande4 -> setComplementAdresseLivraison($livraison->getComplementAdresse());
        $commande4 -> setTelephoneLivraison($livraison->getTelephone());
        $commande4 -> setVilleLivraison($livraison->getVille());
        $commande4 -> setCodePostalLivraison($livraison->getCodePostal());
        $commande4 -> setNomFournisseur($fournisseur2->getNom());
        $commande4 -> setAdresseFournisseur($fournisseur2->getAdresse());
        $commande4 -> setComplementAdresseFournisseur($fournisseur2->getComplementAdresse());
        $commande4 -> setTelephoneFournisseur($fournisseur2->getTelephone());
        $commande4 -> setVilleFournisseur($fournisseur2->getVille());
        $commande4 -> setCodePostalFournisseur($fournisseur2->getCodePostal());
		$em->persist($commande4);

		
		
		$commande5 = new Commande();
		$commande5 -> setVentilation("Directe");
		$commande5 -> setReference("ReFint78-5");
		$commande5 -> setImputation($imputation2);		
		$commande5 -> setengagement("engag 90");
		$commande5 -> setFournisseur($fournisseur2);
		$commande5 -> setUtilisateur($utilisateur2->getNom().' '.$utilisateur2->getPrenom());
		$commande5 -> setService($utilisateur2->getService());
		$commande5 -> setApplication($application);
		$commande5 -> setActivite($activite2);
		$commande5 -> setLivraison($livraison);
		$commande5 -> setLibelleFacturation("llll");
        $commande5 -> setNomLivraison($livraison->getNom());
        $commande5 -> setAdresseLivraison($livraison->getAdresse());
        $commande5 -> setComplementAdresseLivraison($livraison->getComplementAdresse());
        $commande5 -> setTelephoneLivraison($livraison->getTelephone());
        $commande5 -> setVilleLivraison($livraison->getVille());
        $commande5 -> setCodePostalLivraison($livraison->getCodePostal());
        $commande5 -> setNomFournisseur($fournisseur2->getNom());
        $commande5 -> setAdresseFournisseur($fournisseur2->getAdresse());
        $commande5 -> setComplementAdresseFournisseur($fournisseur2->getComplementAdresse());
        $commande5 -> setTelephoneFournisseur($fournisseur2->getTelephone());
        $commande5 -> setVilleFournisseur($fournisseur2->getVille());
        $commande5 -> setCodePostalFournisseur($fournisseur2->getCodePostal());
		$em->persist($commande5);


		
		$commande6 = new Commande();
		$commande6 -> setVentilation("Directe");
		$commande6 -> setReference("ReFint78-6");
		$commande6 -> setImputation($imputation1);		
		$commande6 -> setengagement("engag 90");
		$commande6 -> setFournisseur($fournisseur2);
		$commande6 -> setUtilisateur($utilisateur2->getNom().' '.$utilisateur2->getPrenom());
		$commande6 -> setService($utilisateur2->getService());
		$commande6 -> setApplication($application);
		$commande6 -> setActivite($activite2);
		$commande6 -> setLivraison($livraison);
		$commande6 -> setLibelleFacturation("llll");
        $commande6 -> setNomLivraison($livraison->getNom());
        $commande6 -> setAdresseLivraison($livraison->getAdresse());
        $commande6 -> setComplementAdresseLivraison($livraison->getComplementAdresse());
        $commande6 -> setTelephoneLivraison($livraison->getTelephone());
        $commande6 -> setVilleLivraison($livraison->getVille());
        $commande6 -> setCodePostalLivraison($livraison->getCodePostal());
        $commande6 -> setNomFournisseur($fournisseur2->getNom());
        $commande6 -> setAdresseFournisseur($fournisseur2->getAdresse());
        $commande6 -> setComplementAdresseFournisseur($fournisseur2->getComplementAdresse());
        $commande6 -> setTelephoneFournisseur($fournisseur2->getTelephone());
        $commande6 -> setVilleFournisseur($fournisseur2->getVille());
        $commande6 -> setCodePostalFournisseur($fournisseur2->getCodePostal());
		$em->persist($commande6);
		
		
		
		//On ne se sert de la table de transition QUe pour les commandes directes
		$concerne1 = new CommandeConcerneCollectivite();
		$concerne1 -> setRepartition($commande1->getActivite()->getCleRepartition()->getNom());
		$concerne1 -> setCommande($commande1);
		$concerne1 -> setCollectivite($coll1);
		$em->persist($concerne1);	
		
		$concerne2 = new CommandeConcerneCollectivite();
		$concerne2 -> setRepartition($commande1->getActivite()->getCleRepartition()->getNom());
		$concerne2 -> setCommande($commande1);
		$concerne2 -> setCollectivite($coll2);
		$em->persist($concerne2);	
		
		$concerne4 = new CommandeConcerneCollectivite();
		$concerne4 -> setRepartition($commande1->getActivite()->getCleRepartition()->getNom());
		$concerne4 -> setCommande($commande1);
		$concerne4 -> setCollectivite($coll4);
		$em->persist($concerne4);	
		
		$concerne5 = new CommandeConcerneCollectivite();
		$concerne5 -> setRepartition($commande1->getActivite()->getCleRepartition()->getNom());
		$concerne5 -> setCommande($commande1);
		$concerne5 -> setCollectivite($coll6);
		$em->persist($concerne5);		


		$concerne6 = new CommandeConcerneCollectivite();
		$concerne6 -> setRepartition('25');
		$concerne6 -> setCommande($commande2);
		$concerne6 -> setCollectivite($coll2);
		$em->persist($concerne6);		

		$concerne7 = new CommandeConcerneCollectivite();
		$concerne7 -> setRepartition('75');
		$concerne7 -> setCommande($commande2);
		$concerne7 -> setCollectivite($coll5);
		$em->persist($concerne7);


		$concerne8 = new CommandeConcerneCollectivite();
		$concerne8 -> setRepartition($commande3->getActivite()->getCleRepartition()->getNom());
		$concerne8 -> setCommande($commande3);
		$concerne8 -> setCollectivite($coll5);
		$em->persist($concerne8);

		$concerne9 = new CommandeConcerneCollectivite();
		$concerne9 -> setRepartition($commande3->getActivite()->getCleRepartition()->getNom());
		$concerne9 -> setCommande($commande3);
		$concerne9 -> setCollectivite($coll2);
		$em->persist($concerne9);
		
		
		$concerne10 = new CommandeConcerneCollectivite();
		$concerne10 -> setRepartition("30");
		$concerne10 -> setCommande($commande4);
		$concerne10 -> setCollectivite($coll6);
		$em->persist($concerne10);		


		$concerne11 = new CommandeConcerneCollectivite();
		$concerne11 -> setRepartition('30');
		$concerne11 -> setCommande($commande4);
		$concerne11 -> setCollectivite($coll2);
		$em->persist($concerne11);		

		$concerne12 = new CommandeConcerneCollectivite();
		$concerne12 -> setRepartition('40');
		$concerne12 -> setCommande($commande4);
		$concerne12 -> setCollectivite($coll1);
		$em->persist($concerne12);
		
		
		$concerne13 = new CommandeConcerneCollectivite();
		$concerne13 -> setRepartition("15");
		$concerne13 -> setCommande($commande5);
		$concerne13 -> setCollectivite($coll3);
		$em->persist($concerne13);		


		$concerne14 = new CommandeConcerneCollectivite();
		$concerne14 -> setRepartition('35');
		$concerne14 -> setCommande($commande5);
		$concerne14 -> setCollectivite($coll5);
		$em->persist($concerne14);		

		$concerne15 = new CommandeConcerneCollectivite();
		$concerne15 -> setRepartition('50');
		$concerne15 -> setCommande($commande5);
		$concerne15 -> setCollectivite($coll4);
		$em->persist($concerne15);
		
		$concerne16 = new CommandeConcerneCollectivite();
		$concerne16 -> setRepartition($commande6->getActivite()->getCleRepartition()->getNom());
		$concerne16 -> setCommande($commande6);
		$concerne16 -> setCollectivite($coll5);
		$em->persist($concerne16);

		$concerne17 = new CommandeConcerneCollectivite();
		$concerne17 -> setRepartition($commande6->getActivite()->getCleRepartition()->getNom());
		$concerne17 -> setCommande($commande6);
		$concerne17 -> setCollectivite($coll2);
		$em->persist($concerne17);
		
		$concerne18 = new CommandeConcerneCollectivite();
		$concerne18 -> setRepartition($commande6->getActivite()->getCleRepartition()->getNom());
		$concerne18 -> setCommande($commande6);
		$concerne18 -> setCollectivite($coll3);
		$em->persist($concerne18);
		
		$concerne19 = new CommandeConcerneCollectivite();
		$concerne19 -> setRepartition($commande6->getActivite()->getCleRepartition()->getNom());
		$concerne19 -> setCommande($commande6);
		$concerne19 -> setCollectivite($coll4);
		$em->persist($concerne19);

		
		
		
		// Creation des etats
		$etat1 = new EtatCommande();
		$etat1 -> setLibelle("Creee");
		$em->persist($etat1);		

		$etat2 = new EtatCommande();
		$etat2 -> setLibelle("Enregistree");
		$em->persist($etat2);		

		$etat3 = new EtatCommande();
		$etat3 -> setLibelle("Envoyee");
		$em->persist($etat3);		

		$etat4 = new EtatCommande();
		$etat4 -> setLibelle("Payee");
		$em->persist($etat4);
		
		
		//On met les CommandePasseEtat
		$cpe = new CommandePasseEtat();
		$cpe -> setCommande($commande1);
		$cpe -> setEtat($etat1);
		$cpe -> setDatePassage(new \Datetime("2014-07-08"));
		$em->persist($cpe);
		
		$cpe2 = new CommandePasseEtat();
		$cpe2 -> setCommande($commande1);
		$cpe2 -> setEtat($etat2);
		$cpe2 -> setDatePassage(new \Datetime("2014-07-09"));
		$em -> persist($cpe2);
		
		$cpe3 = new CommandePasseEtat();
		$cpe3 -> setCommande($commande1);
		$cpe3 -> setEtat($etat3);
		$cpe3 -> setDatePassage(new \Datetime("2014-07-10"));
		$em -> persist($cpe3);
		
		$cpe4 = new CommandePasseEtat();
		$cpe4 -> setCommande($commande1);
		$cpe4 -> setEtat($etat4);
		$cpe4 -> setDatePassage(new \Datetime("2014-07-11"));
		$em -> persist($cpe4);
		
		$cpe5 = new CommandePasseEtat();
		$cpe5 -> setCommande($commande2);
		$cpe5 -> setEtat($etat1);
		$cpe5 -> setDatePassage(new \Datetime("2014-07-08"));
		$em->persist($cpe5);
		
		$cpe6 = new CommandePasseEtat();
		$cpe6 -> setCommande($commande2);
		$cpe6 -> setEtat($etat2);
		$cpe6 -> setDatePassage(new \Datetime("2014-07-09"));
		$em -> persist($cpe6);
		
		$cpe7 = new CommandePasseEtat();
		$cpe7 -> setCommande($commande2);
		$cpe7 -> setEtat($etat3);
		$cpe7 -> setDatePassage(new \Datetime("2014-07-10"));
		$em -> persist($cpe7);
		
		$cpe7_bis = new CommandePasseEtat();
		$cpe7_bis -> setCommande($commande2);
		$cpe7_bis -> setEtat($etat4);
		$cpe7_bis -> setDatePassage(new \Datetime("2014-07-11"));
		$em -> persist($cpe7_bis);

		
		$cpe9 = new CommandePasseEtat();
		$cpe9 -> setCommande($commande3);
		$cpe9 -> setEtat($etat1);
		$cpe9 -> setDatePassage(new \Datetime("2014-07-08"));
		$em->persist($cpe9);
		
		$cpe10 = new CommandePasseEtat();
		$cpe10 -> setCommande($commande3);
		$cpe10 -> setEtat($etat2);
		$cpe10 -> setDatePassage(new \Datetime("2014-07-09"));
		$em -> persist($cpe10);
		
		$cpe11 = new CommandePasseEtat();
		$cpe11 -> setCommande($commande3);
		$cpe11 -> setEtat($etat3);
		$cpe11 -> setDatePassage(new \Datetime("2014-07-10"));
		$em -> persist($cpe11);
		
		$cpe12 = new CommandePasseEtat();
		$cpe12 -> setCommande($commande3);
		$cpe12 -> setEtat($etat4);
		$cpe12 -> setDatePassage(new \Datetime("2014-07-11"));
		$em -> persist($cpe12);
		
		$cpe13 = new CommandePasseEtat();
		$cpe13 -> setCommande($commande4);
		$cpe13 -> setEtat($etat1);
		$cpe13 -> setDatePassage(new \Datetime("2014-07-08"));
		$em->persist($cpe13);
		
		$cpe14 = new CommandePasseEtat();
		$cpe14 -> setCommande($commande4);
		$cpe14 -> setEtat($etat2);
		$cpe14 -> setDatePassage(new \Datetime("2014-07-09"));
		$em -> persist($cpe14);
		
		$cpe15 = new CommandePasseEtat();
		$cpe15 -> setCommande($commande4);
		$cpe15 -> setEtat($etat3);
		$cpe15 -> setDatePassage(new \Datetime("2014-07-10"));
		$em -> persist($cpe15);
		
		$cpe16 = new CommandePasseEtat();
		$cpe16 -> setCommande($commande4);
		$cpe16 -> setEtat($etat4);
		$cpe16 -> setDatePassage(new \Datetime("2014-07-11"));
		$em -> persist($cpe16);
		
		$cpe16 = new CommandePasseEtat();
		$cpe16 -> setCommande($commande4);
		$cpe16 -> setEtat($etat4);
		$cpe16 -> setDatePassage(new \Datetime("2014-07-08"));
		$em -> persist($cpe16);
		
		$cpe17 = new CommandePasseEtat();
		$cpe17 -> setCommande($commande5);
		$cpe17 -> setEtat($etat1);
		$cpe17 -> setDatePassage(new \Datetime("2014-07-08"));
		$em -> persist($cpe17);
		
		$cpe18 = new CommandePasseEtat();
		$cpe18 -> setCommande($commande5);
		$cpe18 -> setEtat($etat2);
		$cpe18 -> setDatePassage(new \Datetime("2014-07-08"));
		$em -> persist($cpe18);

		$cpe19 = new CommandePasseEtat();
		$cpe19 -> setCommande($commande6);
		$cpe19 -> setEtat($etat1);
		$cpe19 -> setDatePassage(new \Datetime("2014-07-08"));
		$em -> persist($cpe19);

		$cpe20 = new CommandePasseEtat();
		$cpe20 -> setCommande($commande6);
		$cpe20 -> setEtat($etat2);
		$cpe20 -> setDatePassage(new \Datetime("2014-07-08"));
		$em -> persist($cpe20);
		
		
		
		

		//Creation des TVA
		$tva1 = new TVA();
		$tva1 -> setPourcentage(5.5);
		$em -> persist($tva1);
		
		$tva2 = new TVA();
		$tva2 -> setPourcentage(15.9);
		$em -> persist($tva2);

		$tva3 = new TVA();
		$tva3 -> setPourcentage(21);
		$em -> persist($tva3);	
		
		
		$ligneCommande = new LigneCommande();
		$ligneCommande -> setLibelle("Ligne 1 de la commande numero 1 pour le service bureautique");
		$ligneCommande -> setReference("RF321BUR");
		$ligneCommande -> setQuantite(10);
		$ligneCommande -> setPrixUnitaire(13050.2);
		$ligneCommande -> setTotalTTC(137679.61);
		$ligneCommande -> setCommentaire("Aucun commentaire");
		$ligneCommande -> setCommande($commande1);
		$ligneCommande -> setTVA($tva1);
		$em->persist($ligneCommande);			
		
		
		$ligneCommande2 = new LigneCommande();
		$ligneCommande2 -> setLibelle("Ligne 2 de la commande numero 1 pour le service bureautique");
		$ligneCommande2 -> setReference("RF987BUR");
		$ligneCommande2 -> setQuantite(5);
		$ligneCommande2 -> setPrixUnitaire(3550.2);
		$ligneCommande2 -> setTotalTTC(20573.409);
		$ligneCommande2 -> setCommentaire("Aucun commentaire 1");
		$ligneCommande2 -> setCommande($commande1);
		$ligneCommande2 -> setTVA($tva2);
		$em->persist($ligneCommande2);
		
		$commande1->setTotalTTC(137679.61+20573.409);
		$em->persist($commande1);
		
		
		$ligneCommande3 = new LigneCommande();
		$ligneCommande3 -> setLibelle("Ligne 1 de la commande numero 2 pour le service bureautique");
		$ligneCommande3 -> setReference("RF321BUR");
		$ligneCommande3 -> setQuantite(1);
		$ligneCommande3 -> setPrixUnitaire(24050.2);
		$ligneCommande3 -> setTotalTTC(29100.742);
		$ligneCommande3 -> setCommentaire("Aucun commentaire");
		$ligneCommande3 -> setCommande($commande2);
		$ligneCommande3 -> setTVA($tva3);
		$em->persist($ligneCommande3);			

		$commande2->setTotalTTC(29100.742);
		$em->persist($commande2);


		$ligneCommande4 = new LigneCommande();
		$ligneCommande4 -> setLibelle("Ligne 1 de la commande numero 3 pour le service bureautique");
		$ligneCommande4 -> setReference("RF321BUR");
		$ligneCommande4 -> setQuantite(12);
		$ligneCommande4 -> setPrixUnitaire(24050.2);
		$ligneCommande4 -> setTotalTTC(304475.532);
		$ligneCommande4 -> setCommentaire("Aucun commentaire");
		$ligneCommande4 -> setCommande($commande3);
		$ligneCommande4 -> setTVA($tva1);
		$em->persist($ligneCommande4);			

		$commande3->setTotalTTC(304475.532);
		$em->persist($commande3);


		$ligneCommande5 = new LigneCommande();
		$ligneCommande5 -> setLibelle("Ligne 1 de la commande numero 4 pour le service bureautique");
		$ligneCommande5 -> setReference("RF321BUR");
		$ligneCommande5 -> setQuantite(10);
		$ligneCommande5 -> setPrixUnitaire(1050.2);
		$ligneCommande5 -> setTotalTTC(12171.818);
		$ligneCommande5 -> setCommentaire("Aucun commentaire");
		$ligneCommande5 -> setCommande($commande4);
		$ligneCommande5 -> setTVA($tva2);
		$em->persist($ligneCommande5);			

		$commande4->setTotalTTC(12171.818);
		$em->persist($commande4);



		$ligneCommande6 = new LigneCommande();
		$ligneCommande6 -> setLibelle("Ligne 1 de la commande numero 4 pour le service bureautique");
		$ligneCommande6 -> setReference("RF321BUR");
		$ligneCommande6 -> setQuantite(10);
		$ligneCommande6 -> setPrixUnitaire(1732.2);
		$ligneCommande6 -> setTotalTTC(20959.62);
		$ligneCommande6 -> setCommentaire("Aucun commentaire");
		$ligneCommande6 -> setCommande($commande5);
		$ligneCommande6 -> setTVA($tva3);
		$em->persist($ligneCommande6);			

		$commande5->setTotalTTC(20959.62);
		$em->persist($commande5);


		$ligneCommande7 = new LigneCommande();
		$ligneCommande7 -> setLibelle("Ligne 1 de la commande numero 4 pour le service bureautique");
		$ligneCommande7 -> setReference("RF321BUR");
		$ligneCommande7 -> setQuantite(8);
		$ligneCommande7 -> setPrixUnitaire(1314.2);
		$ligneCommande7 -> setTotalTTC(11091.848);
		$ligneCommande7 -> setCommentaire("Aucun commentaire");
		$ligneCommande7 -> setCommande($commande6);
		$ligneCommande7 -> setTVA($tva1);
		$em->persist($ligneCommande7);			

		$commande6->setTotalTTC(11091.848);
		$em->persist($commande6);

				
		// Ã‰tape 2 : On Â« flush Â» tout ce qui a ete persiste avant
		$em->flush();
		$em->clear();
	      throw new NotFoundHttpexception('Ok, bien insere.');
	      
	      
	   }
	  
	  
	  
	 	  
}