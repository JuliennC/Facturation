<?php

namespace JC\CommandeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\exception\NotFoundHttpexception;
use JC\CommandeBundle\entity\Commande;
use JC\CommandeBundle\entity\Utilisateur;
use JC\CommandeBundle\entity\Fournisseur;
use JC\CommandeBundle\entity\LigneCommande;
use JC\CommandeBundle\entity\Application;
use JC\CommandeBundle\entity\Activite;
use JC\CommandeBundle\entity\Livraison;
use JC\CommandeBundle\entity\CleRepartition;
use JC\CommandeBundle\entity\Collectivite;
use JC\CommandeBundle\entity\CommandeConcerneCollectivite;
use JC\CommandeBundle\entity\etatCommande;
use JC\CommandeBundle\entity\TVA;

use JC\CommandeBundle\Form\CommandeType;


use Symfony\Component\HttpFoundation\JsonResponse;
//	    "components/jquery": "~2.1",



class CommandeController extends Controller
{
	
	
	/*
	*	Page principale, remplace en quelque sorte index
	*/
	  public function listeAction()
	  {
		$em = $this->getDoctrine()->getManager();
		
		// On recupete toutes les commandes
		$listeCommande = $em->getRepository('JCCommandeBundle:Commande')->findAll();  

	    return $this->render( 'JCCommandeBundle:Commande:liste.html.twig', array('tabCommande' => $listeCommande) );
	  }
	  
	  
	  
	  
	  
	  
	/*
	*	Page qui affiche le detail d'une commande (grâce à $id)
	*/
	  public function detailAction($id)
	  {
	    
	    
	    //---------- Recuperation de la commande ----------
	    
	    // On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:Commande') ;

		// On recupere l'entite correspondante à l'id $id
		$commande = $repository->find($id);

		//	Si la commande n'est ni payee, ni envoyee, on redirige vers la page de moficiation
		if( ($commande->getetat() === "Creee") || ($commande->getetat() === "enregistree")){
								
			//Si la commande est envoye ou payee, on ne peux pas la modifier. en renvoie donc sur la page detail
			return $this->redirect($this->generateUrl('jc_commande_modification', array('id' => $commande->getId())));
		}
			


		//---------- Recuperation des ligne de la commande ----------
		
		// On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:LigneCommande') ;

		// On recupere la liste des lignes correspondante à la commande		
		$commande -> setListeLignesCommande($repository->findLignesCommandeAvecCommande($commande->getId()));
	    
	    
	    //---------- Recuperation des collectivite concernees par la commande ----------
		
		// On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:CommandeConcerneCollectivite') ;

		// On recupere la liste des lignes correspondante à la commande		
		$tabTransition = $repository->findCommandeConcerneCollectiviteAvecCommande($commande->getId());
	    

	 	    	    
	    	    
	    //S'il n'y a pas de commande correspondante à l'id
	    if ($commande === null) {
	      // On declenche une exception NotFoundHttpexception, cela va afficher
	      // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
	      throw new NotFoundHttpexception('Commande "'.$id.'" inexistante.');
	    
	    } 

		
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
			if( ($commande->getetat() === "envoyee") || ($commande->getetat() === "Payee")){
				
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
			    $commande -> setetat($etat);

                            
                //On enregistre le lien entre le lieu de livraison et la commande,
                // et le lien du fournisseur et la commande
                if($etat === "Cree"){
                    creeeToenregistree($commande);
                }
                         
                            
                            
				
        		
                            
                //On supprime toutes les villes concernees
                foreach($cCCDejaBDD as $coll){
                    $em->remove($coll);
                }
                          
                          
                //Si la commande est une commande directe, 
                //Les villes selectionn�es sont les villes qui n'ont pas d'input vide
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
	            //On doit uniquement recupere les villes gr�ce � leur checkbox
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
			    
			    foreach($nouveauTabLigneCommande as $n){
					$n -> setCommande($commande);
					$em->persist($n);
			    }


					
				$em->persist($commande);
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
	  	public function creeeToenregistree($commande) {
                    
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
                                // On recherche si un lieu existe deja avec ce nom
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
                                
                                
                                $commande->setetat("enregistree");
                                return $commande;
                }
        
        
	
	  	/*
	  	*		Fonction qui retourne les applications correspondantes à une activite  
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
		*		Fonction qui retourne les applications correspondantes à une activite  
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
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  	  
	  
	  
	 
	// Fonction qui sera supprimee -- sert uniquement à inserer dans la base de donnee
	  
	  
	public function bddAction(){
		  
		 var_dump("insert");		  
		// On recupere l'entityManager
		$em = $this->getDoctrine()->getManager();



		// Creation d'un utilisateur
		$utilisateur = new Utilisateur();
		$utilisateur->setNom('DUPONT');
		$utilisateur->setPrenom('Paul');
		$em->persist($utilisateur);

		// Creation d'un utilisateur
		$utilisateur2 = new Utilisateur();
		$utilisateur2 ->setNom('GeRMAIN');
		$utilisateur2 ->setPrenom('Pierre');
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
		
		
		
		// Creation d'une collectivite
		$coll1 = new Collectivite();
		$coll1 -> setNom('Grand-Nancy');		
		$em->persist($coll1);		

		$coll2 = new Collectivite();
		$coll2 -> setNom('Saint-Max');
		$em->persist($coll2);		
		
		$coll3 = new Collectivite();
		$coll3 -> setNom('Vandoeuvre');
		$em->persist($coll3);		

		$coll4 = new Collectivite();
		$coll4 -> setNom('Malzeville');
		$em->persist($coll4);		
		
		$coll5 = new Collectivite();
		$coll5 -> setNom('Tomblaine');
		$em->persist($coll5);		

		$coll6 = new Collectivite();
		$coll6 -> setNom('essey-les-Nancy');
		$em->persist($coll6);		
				
		
				
		$commande = new Commande();
		$commande -> setVentilation("Mutualisee");
		$commande -> setReference("ReFint78_1");
		$commande -> setBonCoriolis("bonC 65");
		$commande -> setengagement("engag 90");
		$commande -> setImputation("imput 87");
		$commande -> setFournisseur($fournisseur);
		$commande -> setUtilisateur($utilisateur);
		$commande -> setApplication($application);
		$commande -> setLivraison($livraison);
		$commande -> setetat("enregistree");
		$commande -> setLibelleFacturation("llll");
        $commande -> setNomLivraison($livraison->getNom());
                $commande -> setAdresseLivraison($livraison->getAdresse());
                $commande -> setComplementAdresseLivraison($livraison->getComplementAdresse());
                $commande -> setTelephoneLivraison($livraison->getTelephone());
                $commande -> setVilleLivraison($livraison->getVille());
                $commande -> setCodePostalLivraison($livraison->getCodePostal());
                $commande -> setNomFournisseur($fournisseur->getNom());
                $commande -> setAdresseFournisseur($fournisseur->getAdresse());
                $commande -> setComplementAdresseFournisseur($fournisseur->getComplementAdresse());
                $commande -> setTelephoneFournisseur($fournisseur->getTelephone());
                $commande -> setVilleFournisseur($fournisseur->getVille());
                $commande -> setCodePostalFournisseur($fournisseur->getCodePostal());
		$em->persist($commande);
		
		
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
		$commande2 -> setetat("enregistree");
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
		$commande3 -> setUtilisateur($utilisateur);
		$commande3 -> setApplication($application);
		$commande3 -> setLivraison($livraison);
		$commande3 -> setetat("enregistree");
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
		$commande4 -> setUtilisateur($utilisateur);
		$commande4 -> setApplication($application);
		$commande4 -> setLivraison($livraison);
		$commande4 -> setetat("enregistree");
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
		$concerne1 -> setRepartition('75');
		$concerne1 -> setCommande($commande2);
		$concerne1 -> setCollectivite($coll1);
		$em->persist($concerne1);		


		$concerne2 = new CommandeConcerneCollectivite();
		$concerne2 -> setRepartition('25');
		$concerne2 -> setCommande($commande2);
		$concerne2 -> setCollectivite($coll2);
		$em->persist($concerne2);		

		$concerne3 = new CommandeConcerneCollectivite();
		$concerne3 -> setRepartition('100');
		$concerne3 -> setCommande($commande4);
		$concerne3 -> setCollectivite($coll5);
		$em->persist($concerne3);


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
		$ligneCommande -> setPrixUnitaire(1050,2);
		$ligneCommande -> setTotalTTC(10502);
		$ligneCommande -> setCommentaire("Aucun commentaire");
		$ligneCommande -> setCommande($commande);
		$ligneCommande -> setTVA($tva1);
		$em->persist($ligneCommande);			
		
		
		$ligneCommande2 = new LigneCommande();
		$ligneCommande2 -> setLibelle("Ligne 2 de la commande numero 1 pour le service bureautique");
		$ligneCommande2 -> setReference("RF987BUR");
		$ligneCommande2 -> setQuantite(5);
		$ligneCommande2 -> setPrixUnitaire(3550,2);
		$ligneCommande2 -> setTotalTTC(10503);
		$ligneCommande2 -> setCommentaire("Aucun commentaire 1");
		$ligneCommande2 -> setCommande($commande);
		$ligneCommande2 -> setTVA($tva2);
		$em->persist($ligneCommande2);
		
		$commande->setTotalTTC(10502+10503);
		$em->persist($commande);
		
		
		$ligneCommande3 = new LigneCommande();
		$ligneCommande3 -> setLibelle("Ligne 1 de la commande numero 2 pour le service bureautique");
		$ligneCommande3 -> setReference("RF321BUR");
		$ligneCommande3 -> setQuantite(18);
		$ligneCommande3 -> setPrixUnitaire(1050,2);
		$ligneCommande3 -> setTotalTTC(10502);
		$ligneCommande3 -> setCommentaire("Aucun commentaire");
		$ligneCommande3 -> setCommande($commande2);
		$ligneCommande3 -> setTVA($tva3);
		$em->persist($ligneCommande3);			

		$commande2->setTotalTTC(10502);
		$em->persist($commande2);


		$ligneCommande4 = new LigneCommande();
		$ligneCommande4 -> setLibelle("Ligne 1 de la commande numero 3 pour le service bureautique");
		$ligneCommande4 -> setReference("RF321BUR");
		$ligneCommande4 -> setQuantite(7);
		$ligneCommande4 -> setPrixUnitaire(1050,2);
		$ligneCommande4 -> setTotalTTC(10502);
		$ligneCommande4 -> setCommentaire("Aucun commentaire");
		$ligneCommande4 -> setCommande($commande3);
		$ligneCommande4 -> setTVA($tva1);
		$em->persist($ligneCommande4);			

		$commande3->setTotalTTC(10502);
		$em->persist($commande3);


		$ligneCommande5 = new LigneCommande();
		$ligneCommande5 -> setLibelle("Ligne 1 de la commande numero 4 pour le service bureautique");
		$ligneCommande5 -> setReference("RF321BUR");
		$ligneCommande5 -> setQuantite(19);
		$ligneCommande5 -> setPrixUnitaire(1050,2);
		$ligneCommande5 -> setTotalTTC(10502);
		$ligneCommande5 -> setCommentaire("Aucun commentaire");
		$ligneCommande5 -> setCommande($commande4);
		$ligneCommande5 -> setTVA($tva2);
		$em->persist($ligneCommande5);			

		$commande4->setTotalTTC(10502);
		$em->persist($commande4);

				
		// Étape 2 : On « flush » tout ce qui a ete persiste avant
		$em->flush();
		$em->clear();
	      throw new NotFoundHttpexception('Ok, bien insere.');
	      
	      
	     	  }
	  
	  
	  
	 	  
}