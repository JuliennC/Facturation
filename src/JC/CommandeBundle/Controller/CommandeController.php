<?php

namespace JC\CommandeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

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
use JC\CommandeBundle\Entity\PaiementCommande;

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
			
			//On recupère toutes les personnes du service
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
	*	Page qui affiche le detail d'une commande (gr√¢ce √† $id)
	*/
	  public function detailAction($id)
	  {

	    
	    //---------- Recuperation de la commande ----------
	    
	    // On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:Commande') ;

		// On recupere l'entite correspondante √† l'id $id
		$commande = $repository->find($id);

		//S'il n'y a pas de commande correspondante à l'id
	    if ($commande === null) {
	      // On declenche une exception NotFoundHttpexception
	      throw new NotFoundHttpexception('Commande "'.$id.'" inexistante.');
	    } 
		

		//	Si la commande n'est ni Paiement partiel, ni Engagee, on redirige vers la page de moficiation
		if( ($commande->getEtat() === "Creee") || ($commande->getEtat() === "Enregistree")){
								
			//Si la commande est envoye ou Paiement partiel, on ne peux pas la modifier. en renvoie donc sur la page detail
			return $this->redirect($this->generateUrl('jc_commande_modification', array('id' => $commande->getId())));
		}
			


		//---------- Recuperation des ligne de la commande ----------
		
		// On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:LigneCommande') ;

		// On recupere la liste des lignes correspondante √† la commande		
		$commande -> setListeLignesCommande($repository->findLignesCommandeAvecCommande($commande->getId()));
	    
	    
	    //---------- Recuperation des collectivite concernees par la commande ----------
		
		// On recupere le repository
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('JCCommandeBundle:CommandeConcerneCollectivite') ;

		// On recupere la liste des lignes correspondante √† la commande		
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
			if( ($commande->getEtat() === "Engagee") || ($commande->getEtat() === "Paiement") || ($commande->getEtat() === "Terminee")){
				
				//Si la commande est envoye ou Paiement partiel, on ne peux pas la modifier. en renvoie donc sur la page detail
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
			
			
			/*	On a besoin de connaitre l'ancienne ventilation pour le formulaire
			*	C'est à dire la ventilation de départ, ou la ventilation avant qu'un changement dans le form soit fait
			*/
			$ancienneVentilation = $commande->getVentilation();
			
			
			//	On Creee le formulaire avec la commande
            $form = $this->get('form.factory')->create(new CommandeType($em), $commande);
			$form->handleRequest($request);
			
			
                       
			
            //  On recupere la liste des livraisons deja Enregistrees
            $listeLivraisons = $em->getRepository('JCCommandeBundle:Livraison')->findLivraisonsOrdreAlpha();
                        
            //  On recupere la liste des fournisseurs deja enregistres
            $listeFournisseurs = $em->getRepository('JCCommandeBundle:Fournisseur')->findFournisseursOrdreAlpha()->getQuery()->getResult();
                        

			//On recupere toutes les villes deja choisie DANS LA BASe De DONNee
            $cCCDejaBDD = $em->getRepository('JCCommandeBundle:CommandeConcerneCollectivite')->findCommandeConcerneCollectiviteAvecCommande($commande->getId());
			
			//On recupere donc toutes les villes
			$listeToutesLesVilles = $em->getRepository('JCCommandeBundle:Collectivite')->findCollectivitesPourDateOrdreAlpha($commande->getDateCreation());
			
			
			//On récupère les ligne de la commandes entrées avant la modification du formulaire pour voir les lignes supprimées
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
                    $this->CreeeToEnregistree($commande);
                    $etat = "Enregistree";
                
                }
                
                        
                
                            
                //On supprime toutes les villes concernees
                foreach($cCCDejaBDD as $coll){
                    $em->remove($coll);
                }
                          
                          
                //Si la commande est une commande directe, 
                //Les villes selectionnées sont les villes qui n'ont pas d'input vide
                if($ventilation === "Directe"){
					
	            	//On parcours donc toutes les villes pour trouver leur input
	            	foreach($listeToutesLesVilles as $ville){
		            	
		            	//On récupère leur input
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
	            //On doit uniquement recupere les villes grâce à leur checkbox
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
			    
				
				//On regarde si des lignes ont été supprimées
				foreach($listeLigneComAvant as $ligne){
					
					if (! in_array($ligne, $nouveauTabLigneCommande)){
						$em->remove($ligne);
					}
				}
				
				
				
			
			    $montantTTCCommande = 0;
			    $montantHTCommande = 0;

			    
			    foreach($nouveauTabLigneCommande as $n){
				    
				    //On additionne le montant total TTC de la commande
				    $montantTTCCommande += $n->getTotalTTC();
				    
				    //On additionne le montant total HT de la commande
				    $montantHTCommande += ($n->getQuantite() * $n->getPrixUnitaire()) ;
				    
					$n -> setCommande($commande);
					$em->persist($n);
			    }

				//On remet le bon montant de la commnande
				$commande -> setTotalTTC($montantTTCCommande);
				$commande -> setTotalHT($montantHTCommande);
					
				$em->persist($commande);
        		$em->flush();
                                
                                 
                        
				$etatCree = new CommandePasseEtat();
				$etatCree -> setCommande($commande);
				$etatCree -> setEtat($em->getRepository('JCCommandeBundle:EtatCommande')->findOneByLibelle($etat));
				$etatCree -> setDatePassage(new \Datetime());
				$em->persist($etatCree);

    
        		$em->flush();

        		
                                //On redirige, il ne faut donc que l'id de la commande
				return $this->redirect($this->generateUrl('jc_commande_modification', array('id'=>$commande->getId())));

				
				
				
			} else {
                            
                //On affiche le formulaire, il faut donc plus d'informations
				return $this->render('JCCommandeBundle:Commande:modification.html.twig', array( 'form' => $form->createView(), 'commande'=>$commande , 
																								'cCCDejaBDD'=>$cCCDejaBDD, 'ancienneVentilation'=>$ancienneVentilation, 																										'tabVilles'=>$listeToutesLesVilles, 'listeLivraisons'=>$listeLivraisons, 																										'listeFournisseurs'=>$listeFournisseurs));	
	    	}
	    	  
		
	}

	  
	  
	  
	  
	  	// ---------- AUTRES FONCTIONS ----------
	
        
                /*
	  	* Fonction qui enregistre les infos lorsqu'une commande n'est que Creee,
                * elle enregistre les changements dans les tables livraison et fournisseur
                * elle retourne la commande
	  	*/
	  	public function CreeeToEnregistree($commande) {
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

                                $lieu->setNom($commande->getNomLivraison());                                
                                $lieu->setAdresse($commande->getAdresseLivraison());
                                $lieu->setComplementAdresse($commande->getComplementAdresseLivraison());
                                $lieu->setCodePostal($commande->getCodePostalLivraison());
                                $lieu->setVille($commande->getVilleLivraison());
                                $lieu->setTelephone($commande->getTelephoneLivraison());
                                $lieu->setFax($commande->getFaxLivraison());
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

                                $fournisseur->setNom($commande->getNomFournisseur());                                
                                $fournisseur->setAdresse($commande->getAdresseFournisseur());
                                $fournisseur->setComplementAdresse($commande->getComplementAdresseFournisseur());
                                $fournisseur->setCodePostal($commande->getCodePostalFournisseur());
                                $fournisseur->setVille($commande->getVilleFournisseur());
                                $fournisseur->setTelephone($commande->getTelephoneFournisseur());
                                $fournisseur->setFax($commande->getFaxFournisseur());
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
	  	*		Fonction qui change l'état d'une commande
	  	*/
	  	public function changeEtatAction() {
		  
		  	$request = $this->container->get('request');
		  	
		  	
	        $idCom = '';
	        $idCom = $request->get('id');

			$nvlEtat = '';
	        $nvlEtat = $request->get('etat');

	  		if( $idCom != '' && $nvlEtat != '') {
		    
				$em = $this->getDoctrine()->getManager();
	
	            $com = $em->getRepository('JCCommandeBundle:Commande')->findOneById($idCom) ;
				
				$etatCree = new CommandePasseEtat();
				$etatCree -> setCommande($com);
				$etatCree -> setEtat($em->getRepository('JCCommandeBundle:EtatCommande')->findOneByLibelle($nvlEtat));
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
	  	
	  	
	  	
	  	
	  	
	  	
	  	/*
	  	*		Fonction pour le paiement d'une commande
	  	*/
	  	public function paiementCommandeAction() {
		  
		  	$request = $this->container->get('request');
		  	
	        $idCom = '';
	        $idCom = $request->get('id');

			$montant = '';
	        $montant = $request->get('montant');
			$montant = preg_replace('/"/', '', $montant);
			$montant = preg_replace('/,/', '.', $montant);

	  		if( $idCom != '' && $montant != '') {
	
				$em = $this->getDoctrine()->getManager();
				
				//On enregistre le paiement dans la commande pour éviter d'avoir des requetes et des sommes à faire à chaque fois 
				// que l'on veut savoir le total payé pour une commande
	            $com = $em->getRepository('JCCommandeBundle:Commande')->findOneById($idCom) ;				
				$com->setMontantPaye($com->getMontantPaye() + $montant);
				$em->persist($com);
				


				//On garde une trace du paiement
				$paiementCommande = new PaiementCommande();
				$paiementCommande->setCommande($com);
				$paiementCommande->setMontant($montant);
				$paiementCommande->setDatePaiement(new \DateTime());
				$em->persist($paiementCommande);
				
				//Booléan qui définie si aucune erreur n'est trouvée
				$flush = true;
				
				//Si le montant entré est inférieur à 0
				if($montant < 0){
					$flush = false;
					
					$session = new Session();
					$session->getFlashBag()->add('Error', 'Vous ne pouvez pas entré un montant négatif.');
				}
				
				
				//Si c'est le premier paiement, on enregistre un état paiement
				if ($com->getEtat() === "Engagee"){
					
					$etatPaiement = new CommandePasseEtat();
					$etatPaiement -> setCommande($com);
					$etatPaiement -> setEtat($em->getRepository('JCCommandeBundle:EtatCommande')->findOneByLibelle("Paiement"));
					$etatPaiement -> setDatePassage(new \Datetime());
					$em->persist($etatPaiement);
				}  
				

				//On teste si le montant du paiement + le total déjà payé est égale au montant de la facture
				// Il est important de ne pas mettre de else if, si on paie pour la premiere fois, la commande en entière
				if($com->getMontantPaye() === $com->getTotalTTC()) {

					$etatTermine = new CommandePasseEtat();
					$etatTermine -> setCommande($com);
					$etatTermine -> setEtat($em->getRepository('JCCommandeBundle:EtatCommande')->findOneByLibelle("Terminee"));
					$etatTermine -> setDatePassage(new \Datetime());
					$em->persist($etatTermine);	
			
				//Si le montant est supérieur au montant de la commande, on refuse et on met un message d'erreur
				} else {

					$flush = false;

					$session = new Session();
					$session->getFlashBag()->add('Error', 'Le montant entré + le montant déjà payé pour cette commande est supérieur au total de la commande.');
				}
				
				
			
				if ($flush) {
					$em->flush();
				}

				//On prepare la reponse
				$response = new JsonResponse(true);

	            return $response;


            }  else {
	            
	            $response = new JsonResponse("Non non ..");
																			
	            return $response;
            }
   	        	
		}
	  	  
}