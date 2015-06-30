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

                        
            return $this->miseenPlaceForm($request, $commande);
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
			
			return $this->miseenPlaceForm($request, $commande);
	    	  
		
	}

	  
	  
	  
	  
	  
	  
        /*
		*	action applele a la creation d'une commande
        *      et a la modification d'une commande
        *      C'est elle qui met en place le form et qui gere les submit  
		*/
                public function miseenPlaceForm(Request $request, $commande)
		{
	  	
			$em = $this->getDoctrine()->getManager();
			
			//	On creee le formulaire avec la commande
            $form = $this->get('form.factory')->create(new CommandeType($em), $commande);
			$form->handleRequest($request);
			
			
                       
			
            //  On recupere la liste des livraisons deja enregistrees
            $listeLivraisons = $em->getRepository('JCCommandeBundle:Livraison')->findLivraisonsOrdreAlpha();
                        
            //  On recupere la liste des fournisseurs deja enregistres
            $listeFournisseurs = $em->getRepository('JCCommandeBundle:Fournisseur')->findFournisseursOrdreAlpha();
                        
			
			//On recupere toutes les villes deja choisie DANS LA BASe De DONNee
            $cCCDejaBDD = $em->getRepository('JCCommandeBundle:CommandeConcerneCollectivite')->findCommandeConcerneCollectiviteAvecCommande($commande->getId());
			
			//On recupere donc toutes les villes
			$listeToutesLesVilles = $em->getRepository('JCCommandeBundle:Collectivite')->findAll();
			
			
			//	Si le formulaire est valide, on l'enregistre en base.
		    if ($form->isValid()) {
			    
                            //on recupere la ventialation
			    $ventilation = $form->get('ventilation')->getData();
			    $commande->setVentilation($ventilation);
			   
			   
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
	                    $cCC->setRepartition( $commande->getApplication()->getCleRepartition()->getNom());

						$em->persist($cCC);
					}
	            }
                 
               
				
				
				//On enregistre les ligne de commandes entrees
			    $nouveauTabLigneCommande = $form->get('listeLignesCommande')->getData();
			    
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

	  
	  
	  
	  
	  	// ---------- AUTReS FONCTIONS ----------
	
        
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
	
	        
	    
			/*} else {
		    	return $this->redirect($this->generateUrl('jc_commande_creation'));
				}*/
	  
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
	  	  
	  	  
	  	  
	  
	  
	 
	// Fonction qui sera supprimee -- sert uniquement Ã  inserer dans la base de donnee
	  
	  
	public function bddAction(){
		  
		 var_dump("insert");		  
		// On recupere l'entityManager
		$em = $this->getDoctrine()->getManager();

		
		// Creation d'un utilisateur
		$service1 = new Service();
		$service1->setNom("Bureautique");
		$em->persist($service1);

		$service2 = new Service();
		$service2->setNom("Etude");
		$em->persist($service2);

		
		
		//CrŽation des budgets
		$budget1 = new Budget();
		$budget1->setMontant(350000);
		$budget1->setAnnee("2015");
		$budget1->setService($service1);
		$em->persist($budget1);

		$budget2 = new Budget();
		$budget2->setMontant(425000);
		$budget2->setAnnee("2015");
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

		
		// Creation d'une activite
		$activite = new Activite();
		$activite -> setNom('Activite_1');
		$activite -> setUniteOeuvre(12345);
		$em->persist($activite);

		$activite2 = new Activite();
		$activite2 -> setNom('Activite_2');
		$activite2 -> setUniteOeuvre(67890);
		$em->persist($activite2);
		
				
				
		// Creation d'une cle de repartition
		$cle = new CleRepartition();
		$cle -> setNom("Nombre d'habitant");
		
		
		// Creation d'une application
		$application = new Application();
		$application -> setNom('Application_1');
		$application -> setUnixOracle(false);
		$application -> setActivite($activite);
		$application -> setCleRepartition($cle);
		$application -> setFournisseur($fournisseur);
		$em->persist($application);

		$application2 = new Application();
		$application2 -> setNom('Application_2');
		$application2 -> setUnixOracle(false);
		$application2 -> setActivite($activite2);
		$application2 -> setCleRepartition($cle);
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
		$em->persist($coll1);		
		
		$info_Coll_1 = new InformationCollectivite();
		$info_Coll_1 -> setNombre('105000');		
		$info_Coll_1 -> setAnnee("2015");	
		$info_Coll_1 -> setCleRepartition($cle);	
		$info_Coll_1 -> setCollectivite($coll1);	
		$em->persist($info_Coll_1);




		$coll2 = new Collectivite();
		$coll2 -> setNom('Saint-Max');
		$em->persist($coll2);		
		
		$info_Coll_2 = new InformationCollectivite();
		$info_Coll_2 -> setNombre('9870');		
		$info_Coll_2 -> setAnnee("2015");		
		$info_Coll_2 -> setCleRepartition($cle);	
		$info_Coll_2 -> setCollectivite($coll2);	
		$em->persist($info_Coll_2);
		
		
		
		
		$coll3 = new Collectivite();
		$coll3 -> setNom('Vandoeuvre');
		$em->persist($coll3);

		$info_Coll_3 = new InformationCollectivite();
		$info_Coll_3 -> setNombre('22000');		
		$info_Coll_3 -> setAnnee("2015");
		$info_Coll_3 -> setCleRepartition($cle);	
		$info_Coll_3 -> setCollectivite($coll3);	
		$em->persist($info_Coll_3);




		$coll4 = new Collectivite();
		$coll4 -> setNom('Malzeville');
		$em->persist($coll4);		
		
		$info_Coll_4 = new InformationCollectivite();
		$info_Coll_4 -> setNombre('5640');		
		$info_Coll_4 -> setAnnee("2015");
		$info_Coll_4 -> setCleRepartition($cle);	
		$info_Coll_4 -> setCollectivite($coll4);	
		$em->persist($info_Coll_4);
		
		
		

		$coll5 = new Collectivite();
		$coll5 -> setNom('Tomblaine');
		$em->persist($coll5);		
		
		$info_Coll_5 = new InformationCollectivite();
		$info_Coll_5 -> setNombre('13028');		
		$info_Coll_5 -> setAnnee("2015");	
		$info_Coll_5 -> setCleRepartition($cle);
		$info_Coll_5 -> setCollectivite($coll5);	
		$em->persist($info_Coll_5);
		
		


		$coll6 = new Collectivite();
		$coll6 -> setNom('essey-les-Nancy');
		$em->persist($coll6);	
		
		$info_Coll_6 = new InformationCollectivite();
		$info_Coll_6 -> setNombre('7892');		
		$info_Coll_6 -> setAnnee("2015");	
		$info_Coll_6 -> setCleRepartition($cle);	
		$info_Coll_6 -> setCollectivite($coll6);	
		$em->persist($info_Coll_6);
	


		$commande1 = new Commande();
		$commande1 -> setVentilation("Mutualisee");
		$commande1 -> setReference("ReFint78_1");
		$commande1 -> setBonCoriolis("bonC 65");
		$commande1 -> setengagement("engag 90");
		$commande1 -> setImputation("imput 87");
		$commande1 -> setFournisseur($fournisseur);
		$commande1 -> setUtilisateur($utilisateur);
		$commande1 -> setApplication($application);
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
		$commande2 -> setBonCoriolis("bonC 65");
		$commande2 -> setengagement("engag 90");
		$commande2 -> setImputation("imput 87");
		$commande2 -> setFournisseur($fournisseur);
		$commande2 -> setUtilisateur($utilisateur);
		$commande2 -> setApplication($application);
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
		$commande3 -> setBonCoriolis("bonC 65");
		$commande3 -> setengagement("engag 90");
		$commande3 -> setImputation("imput 87");
		$commande3 -> setFournisseur($fournisseur2);
		$commande3 -> setUtilisateur($utilisateur2);
		$commande3 -> setApplication($application);
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
		$commande4 -> setBonCoriolis("bonC 65");
		$commande4 -> setengagement("engag 90");
		$commande4 -> setImputation("imput 87");
		$commande4 -> setFournisseur($fournisseur2);
		$commande4 -> setUtilisateur($utilisateur2);
		$commande4 -> setApplication($application);
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

		
		
		//On ne se sert de la table de transition QUe pour les commandes directes
		$concerne1 = new CommandeConcerneCollectivite();
		$concerne1 -> setRepartition("Nombre d'habitant");
		$concerne1 -> setCommande($commande1);
		$concerne1 -> setCollectivite($coll1);
		$em->persist($concerne1);	
		
		$concerne2 = new CommandeConcerneCollectivite();
		$concerne2 -> setRepartition("Nombre d'habitant");
		$concerne2 -> setCommande($commande1);
		$concerne2 -> setCollectivite($coll2);
		$em->persist($concerne2);	
		
		$concerne4 = new CommandeConcerneCollectivite();
		$concerne4 -> setRepartition("Nombre d'habitant");
		$concerne4 -> setCommande($commande1);
		$concerne4 -> setCollectivite($coll4);
		$em->persist($concerne4);	
		
		$concerne5 = new CommandeConcerneCollectivite();
		$concerne5 -> setRepartition("Nombre d'habitant");
		$concerne5 -> setCommande($commande2);
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
		$concerne8 -> setRepartition("Nombre d'habitant");
		$concerne8 -> setCommande($commande3);
		$concerne8 -> setCollectivite($coll5);
		$em->persist($concerne8);

		$concerne9 = new CommandeConcerneCollectivite();
		$concerne9 -> setRepartition("Nombre d'habitant");
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
		$cpe -> setDatePassage(new \Datetime());
		$em->persist($cpe);
		
		$cpe2 = new CommandePasseEtat();
		$cpe2 -> setCommande($commande1);
		$cpe2 -> setEtat($etat2);
		$cpe2 -> setDatePassage(new \Datetime());
		$em -> persist($cpe2);
		
		$cpe3 = new CommandePasseEtat();
		$cpe3 -> setCommande($commande1);
		$cpe3 -> setEtat($etat3);
		$cpe3 -> setDatePassage(new \Datetime());
		$em -> persist($cpe3);
		
		$cpe4 = new CommandePasseEtat();
		$cpe4 -> setCommande($commande1);
		$cpe4 -> setEtat($etat4);
		$cpe4 -> setDatePassage(new \Datetime());
		$em -> persist($cpe4);
		
		$cpe5 = new CommandePasseEtat();
		$cpe5 -> setCommande($commande2);
		$cpe5 -> setEtat($etat1);
		$cpe5 -> setDatePassage(new \Datetime());
		$em->persist($cpe5);
		
		$cpe6 = new CommandePasseEtat();
		$cpe6 -> setCommande($commande2);
		$cpe6 -> setEtat($etat2);
		$cpe6 -> setDatePassage(new \Datetime());
		$em -> persist($cpe6);
		
		$cpe7 = new CommandePasseEtat();
		$cpe7 -> setCommande($commande2);
		$cpe7 -> setEtat($etat3);
		$cpe7 -> setDatePassage(new \Datetime());
		$em -> persist($cpe7);
		
		$cpe7_bis = new CommandePasseEtat();
		$cpe7_bis -> setCommande($commande2);
		$cpe7_bis -> setEtat($etat4);
		$cpe7_bis -> setDatePassage(new \Datetime());
		$em -> persist($cpe7_bis);
		
		$cpe8 = new CommandePasseEtat();
		$cpe8 -> setCommande($commande2);
		$cpe8 -> setEtat($etat3);
		$cpe8 -> setDatePassage(new \Datetime());
		$em -> persist($cpe8);
		
		$cpe9 = new CommandePasseEtat();
		$cpe9 -> setCommande($commande3);
		$cpe9 -> setEtat($etat1);
		$cpe9 -> setDatePassage(new \Datetime());
		$em->persist($cpe9);
		
		$cpe10 = new CommandePasseEtat();
		$cpe10 -> setCommande($commande3);
		$cpe10 -> setEtat($etat2);
		$cpe10 -> setDatePassage(new \Datetime());
		$em -> persist($cpe10);
		
		$cpe11 = new CommandePasseEtat();
		$cpe11 -> setCommande($commande3);
		$cpe11 -> setEtat($etat3);
		$cpe11 -> setDatePassage(new \Datetime());
		$em -> persist($cpe11);
		
		$cpe12 = new CommandePasseEtat();
		$cpe12 -> setCommande($commande3);
		$cpe12 -> setEtat($etat4);
		$cpe12 -> setDatePassage(new \Datetime());
		$em -> persist($cpe12);
		
		$cpe13 = new CommandePasseEtat();
		$cpe13 -> setCommande($commande4);
		$cpe13 -> setEtat($etat1);
		$cpe13 -> setDatePassage(new \Datetime());
		$em->persist($cpe13);
		
		$cpe14 = new CommandePasseEtat();
		$cpe14 -> setCommande($commande4);
		$cpe14 -> setEtat($etat2);
		$cpe14 -> setDatePassage(new \Datetime());
		$em -> persist($cpe14);
		

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
		$ligneCommande -> setPrixUnitaire(13050,2);
		$ligneCommande -> setTotalTTC(130502);
		$ligneCommande -> setCommentaire("Aucun commentaire");
		$ligneCommande -> setCommande($commande1);
		$ligneCommande -> setTVA($tva1);
		$em->persist($ligneCommande);			
		
		
		$ligneCommande2 = new LigneCommande();
		$ligneCommande2 -> setLibelle("Ligne 2 de la commande numero 1 pour le service bureautique");
		$ligneCommande2 -> setReference("RF987BUR");
		$ligneCommande2 -> setQuantite(5);
		$ligneCommande2 -> setPrixUnitaire(3550,2);
		$ligneCommande2 -> setTotalTTC(10503);
		$ligneCommande2 -> setCommentaire("Aucun commentaire 1");
		$ligneCommande2 -> setCommande($commande1);
		$ligneCommande2 -> setTVA($tva2);
		$em->persist($ligneCommande2);
		
		$commande1->setTotalTTC(130502+10503);
		$em->persist($commande1);
		
		
		$ligneCommande3 = new LigneCommande();
		$ligneCommande3 -> setLibelle("Ligne 1 de la commande numero 2 pour le service bureautique");
		$ligneCommande3 -> setReference("RF321BUR");
		$ligneCommande3 -> setQuantite(1);
		$ligneCommande3 -> setPrixUnitaire(24050,2);
		$ligneCommande3 -> setTotalTTC(24050,2);
		$ligneCommande3 -> setCommentaire("Aucun commentaire");
		$ligneCommande3 -> setCommande($commande2);
		$ligneCommande3 -> setTVA($tva3);
		$em->persist($ligneCommande3);			

		$commande2->setTotalTTC(24050,2);
		$em->persist($commande2);


		$ligneCommande4 = new LigneCommande();
		$ligneCommande4 -> setLibelle("Ligne 1 de la commande numero 3 pour le service bureautique");
		$ligneCommande4 -> setReference("RF321BUR");
		$ligneCommande4 -> setQuantite(12);
		$ligneCommande4 -> setPrixUnitaire(24050,2);
		$ligneCommande4 -> setTotalTTC(288600);
		$ligneCommande4 -> setCommentaire("Aucun commentaire");
		$ligneCommande4 -> setCommande($commande3);
		$ligneCommande4 -> setTVA($tva1);
		$em->persist($ligneCommande4);			

		$commande3->setTotalTTC(288600);
		$em->persist($commande3);


		$ligneCommande5 = new LigneCommande();
		$ligneCommande5 -> setLibelle("Ligne 1 de la commande numero 4 pour le service bureautique");
		$ligneCommande5 -> setReference("RF321BUR");
		$ligneCommande5 -> setQuantite(10);
		$ligneCommande5 -> setPrixUnitaire(1050,2);
		$ligneCommande5 -> setTotalTTC(10502);
		$ligneCommande5 -> setCommentaire("Aucun commentaire");
		$ligneCommande5 -> setCommande($commande4);
		$ligneCommande5 -> setTVA($tva2);
		$em->persist($ligneCommande5);			

		$commande4->setTotalTTC(10502);
		$em->persist($commande4);

				
		// Ã‰tape 2 : On Â« flush Â» tout ce qui a ete persiste avant
		$em->flush();
		$em->clear();
	      throw new NotFoundHttpexception('Ok, bien insere.');
	      
	      
	   }
	  
	  
	  
	 	  
}