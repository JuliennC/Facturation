<?php

namespace JC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use JC\CommandeBundle\Entity\InformationsCollectiviteListe;
use JC\CommandeBundle\Entity\InformationCollectivite;
use JC\CommandeBundle\Form\InformationsCollectiviteListeType;
use JC\CommandeBundle\Form\InformationCollectiviteType;

use JC\CommandeBundle\Entity\Collectivite;
use JC\CommandeBundle\Entity\ListeCollectivites;
use JC\CommandeBundle\Form\ListeCollectivitesType;
use JC\CommandeBundle\Form\CollectiviteType;

use JC\CommandeBundle\Entity\CleRepartition;
use JC\CommandeBundle\Entity\ListeClesRepartition;
use JC\CommandeBundle\Form\ListeClesRepartitionType;
use JC\CommandeBundle\Form\CleRepartitionType;

use JC\CommandeBundle\Entity\Utilisateur;
use JC\CommandeBundle\Entity\ListeUtilisateurs;
use JC\CommandeBundle\Form\ListeUtilisateursType;
use JC\CommandeBundle\Form\UtilisateurType;

use JC\CommandeBundle\Entity\Service;
use JC\CommandeBundle\Entity\ListeServices;
use JC\CommandeBundle\Form\ServiceType;
use JC\CommandeBundle\Form\ListeServicesType;

use JC\CommandeBundle\Entity\Budget;
use JC\CommandeBundle\Entity\ListeBudgets;
use JC\CommandeBundle\Form\BudgetType;
use JC\CommandeBundle\Form\ListeBudgetsType;

use JC\CommandeBundle\Entity\Application;
use JC\CommandeBundle\Entity\ListeApplications;
use JC\CommandeBundle\Form\ApplicationType;
use JC\CommandeBundle\Form\ListeApplicationsType;

use JC\CommandeBundle\Entity\Activite;
use JC\CommandeBundle\Entity\ListeActivites;
use JC\CommandeBundle\Form\ActiviteType;
use JC\CommandeBundle\Form\ListeActivitesType;




class AdminController extends Controller
{
    public function indexAction(Request $request, $annee )
    {

		//Si aucune année n'est entrée
		if($annee === "html"){
			 $annee = date('Y');
		}


		$formulaireEnvoye = $request->request->all();
		dump($formulaireEnvoye);
		
		/*
		*	On doit vérifier les formulaire ici afain de pouvoir effectuer les redirections si besoin
		*	Chose que l'on ne peut pas faire depuis un "block controller"
		* 	Le seul moyen était de passer par une redirection en JS, ce qui était .... moche
		*/
		
		//Si le form pour la liste des collectivite a été envoyé
		if(isset($formulaireEnvoye['jc_commandebundle_listecollectivites'])) {
			
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationCollectivitesAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} 
		
		
		
		//Si le formulaire envoyé est le formulaire de la liste des informations des collectivites
		} else if(isset($formulaireEnvoye['jc_commandebundle_informationscollectiviteliste'])) {

			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationInformationsCollectivitesAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} 

		
		
		//Si le formulaire envoyé est le formulaire de la liste des clés de répartition
		} else if(isset($formulaireEnvoye['jc_commandebundle_listeclesrepartition'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationClesRepartitionAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			}
			
			
		//Si le formulaire envoyé est le formulaire de la liste des utilisateurs
		} else if(isset($formulaireEnvoye['jc_commandebundle_listeutilisateurs'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationUtilisateursAction($request);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			}
			
			
		//Si le formulaire envoyé est le formulaire de la liste des services
		} else if(isset($formulaireEnvoye['jc_commandebundle_listeservices'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationServicesAction($request);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			}
			
			
		//Si le formulaire envoyé est le formulaire des budgets
		} else if(isset($formulaireEnvoye['jc_commandebundle_listebudgets'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationBudgetsAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			}
			
			
		//Si le formulaire envoyé est le formulaire des applications
		} else if(isset($formulaireEnvoye['jc_commandebundle_listeapplications'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationApplicationsAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			}
			
		
		
		//Si le formulaire envoyé est le formulaire des activites
		} else if(isset($formulaireEnvoye['jc_commandebundle_listeactivites'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationActivitesAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			}
		}
		



 
		        	

		
        	

		return $this->render('JCAdminBundle:Admin:index.html.twig', array('request'=>$request, 'annee' => $annee));
		

		
				
    }
    
    
    
    
    /*
	 *	Fonctions qui permettent les modifications des tables
	 * le paramêtre année est pour savoir qu'elle année afficher
	 */






	 
	




	 /*
	 *	Pour modifier les collectivites 
	 *  et leurs date de début et de fin de mutualisation
	 */
	 public function modificationCollectivitesAction(Request $request, $annee) {

	 $b = 0;
	 
	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les collectivites
	 	$l = $em->getRepository('JCCommandeBundle:Collectivite')->findAll(); 

	 	//Liste qui sera transformée en formulaire
	 	$listeCollectivites = new ListeCollectivites();
	 	$listeCollectivites ->setListeCollectivites($l);
	 		 	
	 	
	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque collectivite)
        $form = $this->get('form.factory')->create(new ListeCollectivitesType(), $listeCollectivites);
		$form->handleRequest($request);

	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			//On sauvegarde les villes dans la base
        	foreach($form->get('listeCollectivites')->getData() as $coll) {

				//On ne sauvegarde pas celle qui ont un nom null
				if ($coll->getNom() != null) {
					$em->persist($coll);
				}
			}
        	
        	
        	$em->flush();
        	
        	return new Response('true');

    	} else {
	    	
	 		return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig', array('form'=>$form->createView(), 'bool_form'=>$b));
    	}

	 	


	 }





	 /*
	 *	Pour modifier les informations des collectivites dont l'année de début de mutualisation
	 *  est antérieur à l'année passée en paramêtre 
	 */
	 public function modificationInformationsCollectivitesAction(Request $request, $annee) {
		 		 
		 
		 
		 $listeInformationsATransformee = array();

		 $em = $this->getDoctrine()->getManager();

		 
		//On récupère les collectivite pour l'année 
		$listeCollectivites = $em->getRepository('JCCommandeBundle:Collectivite')->findCollectivitesPourAnnee($annee); 

		//On récupère toutes les clés
		$listeCles = $em->getRepository('JCCommandeBundle:CleRepartition')->findAll(); 

		//On récupère la liste des informations collectivités, pour les collectivites "mutualisées" au cours de l'année $année
		//C'est à dire : - date début mutualisation <= $annee
		// 				- ET date fin mutualisation >= $annee
		// Note : On fait deux orderBy dans la requête, ce qui évite de réaliser des traitements pour trier les données
		$listeInformations = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findInformationsPourAnnee($annee);


		//On ajoute toutes les informations récupérées dans la liste qui sera transformée en formulaire
		$listeInfosPourForm = new InformationsCollectiviteListe();



			
		//On parcours chaque collectivite pour mettre leur clées manquantes
		foreach($listeCollectivites as $coll) {
					
					
			/*	On a récupéré les informations déjà entrées
			*	On va comparer les clé de ces informations au clés qui doivent être remplies
			*	Pour savoir si des clés sont manquantes
			*/
				
			//Pour cela on stocke les clés qui ont des informations entrées pour l'année donnée
			$listeClesUtilisees = array();
	
			foreach($listeInformations as $information){
				
				if($information->getCollectivite() === $coll){
					array_push($listeClesUtilisees, $information->getCleRepartition());

					//Et on ajoute l'info dans la liste qui sera transformée en formulaire
					$listeInfosPourForm->addInformation($information);		
				}
			}
	
					
					
			//On récupère les informations de l'année dernière pour pré-remplir les champs des clés manquantes
			$listeInformationsPrecendentes = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findToutesInfosPourCollectiviteEtAnnee($coll,$annee-1);


						
			//On parcours les clés qui doivent être remplies
			foreach($listeCles as $cle) {
						
				/*	On regarde si la clé a déjà son information
				*	Si elle n'est pas présente dans le tableau des clés utilisées, il faut alors la rajouter
				*	On crée alors une nouvelle information
				*/	
				if(! in_array($cle, $listeClesUtilisees)){ 
							
					$nouvelleInformation = new InformationCollectivite();
					$nouvelleInformation -> setCollectivite($coll);
					$nouvelleInformation -> setCleRepartition($cle);
					$nouvelleInformation -> setAnnee($annee);
							
					$nombre = 0;


					//On regarde si la clé été déjà utilisée l'année précédente
					foreach($listeInformationsPrecendentes as $ip){
							
						//Si elle était utilisée, on peut prendre le nombre comme 'base'
						if($ip->getCleRepartition() === $cle) {
							$nombre = $ip->getNombre();
							break;
						}
					}
						
					
					$nouvelleInformation -> setNombre($nombre);

					//On met l'information dans la liste
					$listeInfosPourForm->addInformation($nouvelleInformation);		
				}
				
			}

		}
				
				

		//On crée le formulaire (c'est lui qui contient chaque form pour chaque infos)
        $form = $this->get('form.factory')->create(new InformationsCollectiviteListeType(), $listeInfosPourForm);
		$form->handleRequest($request);

			
		//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

        	//On récupère la liste des informations du formulaire
        	$liste = $form->get('listeInformations')->getData();
        	
        	foreach($liste as $l) {
	        	
				$em->persist($l);

        	}
        	
        	$em->flush();
        
			return new Response('true');

    	} else {

			return $this->render('JCAdminBundle:Admin:modif_informations_collectivites.html.twig', array('form'=>$form->createView(),'annee'=>$annee, 'listeCles'=>$listeCles, 'listeCollectivites'=>$listeCollectivites));
		}        	

	}







	/*
	 *	Pour modifier les clés de répartition 
	 *  
	 */
	 public function modificationClesRepartitionAction(Request $request) {

	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les collectivites
	 	$listeCles = $em->getRepository('JCCommandeBundle:CleRepartition')->findAll(); 
	 	
	 	//Liste qui sera transformée en formulaire
	 	$listeClesRepartition = new ListeClesRepartition();
	 	$listeClesRepartition ->setListeClesRepartition($listeCles);
	 		 	
	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque clé)
        $form = $this->get('form.factory')->create(new ListeClesRepartitionType(), $listeClesRepartition);

	 	
		$form->handleRequest($request);

	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			//On sauvegarde les villes dans la base
        	foreach($form->get('listeClesRepartition')->getData() as $cle) {

				//On ne sauvegarde pas celle qui ont un nom null
				if ($cle->getNom() != null) {
					$em->persist($cle);
				}
			}
        	
        	
        	$em->flush();
        	

			return new Response('true');

    	} else {
	 		
	 		return $this->render('JCAdminBundle:Admin:modif_cles_repartition.html.twig', array('form'=>$form->createView()));
		}
	 }






	 /*
	 *	Pour modifier les utilisateurs
	 *  
	 */
	 public function modificationUtilisateursAction(Request $request) {

	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les collectivites
	 	$listeU = $em->getRepository('JCCommandeBundle:Utilisateur')->getUtilisateurOrdreAlpha()->getQuery()->getResult();
	 	
	 	//Liste qui sera transformée en formulaire
	 	$listeUtilisateurs = new ListeUtilisateurs();
	 	$listeUtilisateurs -> setListeUtilisateurs($listeU);
	 		 	
	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque utilisateur)
        $form = $this->get('form.factory')->create(new ListeUtilisateursType(), $listeUtilisateurs);

	 	
		$form->handleRequest($request);

	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			//On sauvegarde les villes dans la base
        	foreach($form->get('listeUtilisateurs')->getData() as $user) {

				//On ne sauvegarde pas celle qui ont un nom null
				if ($user->getNom() != null) {
					$em->persist($user);
				}
				
			}     
			
			
			//On cherche des utilisateur à supprimer
			foreach($listeU as $user){
				
				//Si l'utilisateur n'est plus dans le formulaire, c'est qu'il faut le supprimer
				if(! in_array($user, $form->get('listeUtilisateurs')->getData())) {
					
					//On supprime l'utilisateur
					$em->remove($user);
				}
			}   	
        	
        	$em->flush();
        	

			return new Response('true');

    	} else {
	 		
	 		return $this->render('JCAdminBundle:Admin:modif_utilisateurs.html.twig', array('form'=>$form->createView()));
		}
		
	 }





	 /*
	 *	Pour modifier les utilisateurs
	 *  
	 */
	 public function modificationServicesAction(Request $request) {
dump('kg');

	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de tous les services
	 	$listeS = $em->getRepository('JCCommandeBundle:Service')->getServiceOrdreAlpha()->getQuery()->getResult();
	 	
	 	
	 	//Liste qui sera transformée en formulaire
	 	$listeServices = new ListeServices();
	 	$listeServices->setListeServices($listeS);
	 	

	 	
	 		 	
	 	//On crée les formulaires 
        $form = $this->get('form.factory')->create(new ListeServicesType(), $listeServices);
		$form->handleRequest($request);


	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			

			//On sauvegarde les service dans la base
        	foreach($form->get('listeServices')->getData() as $service) {
					dump('id : '.$service->getId());

				//On ne sauvegarde pas ceux qui ont un nom null
				if ($service->getNom() != null ) {
					$em->persist($service);
				
				} 
					
					
				
				
				
			}     
			
			
			
			
		   	$em->flush();
        	

			return new Response('true');

    	} else {
	 		
	 		return $this->render('JCAdminBundle:Admin:modif_services.html.twig', array('form'=>$form->createView()));
		}
		
	 }







	 /*
	 *	Pour modifier les informations des collectivites dont l'année de début de mutualisation
	 *  est antérieur à l'année passée en paramêtre 
	 */
	 public function modificationBudgetsAction(Request $request, $annee) {
		 		 

		$em = $this->getDoctrine()->getManager();

		 
		//On récupère les services
		$listeServices = $em->getRepository('JCCommandeBundle:Service')->getServiceOrdreAlpha()->getQuery()->getResult(); 


		//Liste qui sera transformée en form
		$listeBudgets = new ListeBudgets();

				
			//On parcours chaque service pour creer leur budget
			foreach($listeServices as $service) {					

				//On regarde si un budget avait déjà été définie
				$budget = $em->getRepository('JCCommandeBundle:Budget')->findBudgetAvecAnneeEtService($annee, $service);
					

				//Si un budget existe, on le récupère
				if (sizeof($budget) > 0){
					$listeBudgets->addBudget($budget[0]);
					
				//Sinon, on en crée un
				} else {

					$nouveauBudget = new Budget();
					$nouveauBudget -> setService($service);
					$nouveauBudget -> setAnnee($annee);
					$nouveauBudget -> setMontant(0);
												
					$listeBudgets->addBudget($nouveauBudget);
				}

			}
		
			
	    $form = $this->get('form.factory')->create(new ListeBudgetsType(), $listeBudgets);
		$form->handleRequest($request);
			
		//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

        	//On récupère la liste des informations du formulaire
        	$listeBudgets = $form->get('listeBudgets')->getData();
        		        	dump('l b'.$listeBudgets);
        	foreach($listeBudgets as $b) {
			
				if($b->getMontant() != 0){
					$em->persist($b);
					}
        	}
        	
        	$em->flush();
        
			return new Response('true');


    	} else {
			
			//return new Response("kjb");
			return $this->render('JCAdminBundle:Admin:modif_budgets.html.twig', array('form'=>$form->createView(),'annee'=>$annee));
		      	
		}
	}








	/*
	 *	Pour modifier les applications 
	 */
	 public function modificationApplicationsAction(Request $request) {

	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les collectivites
	 	$listeApp = $em->getRepository('JCCommandeBundle:Application')->getApplicationOrdreAlpha()->getQuery()->getResult(); 
	 	
	 	//Liste qui sera transformée en formulaire
	 	$listeApplications = new ListeApplications();
	 	$listeApplications ->setListeApplications($listeApp);
	 		 	
	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque clé)
        $form = $this->get('form.factory')->create(new ListeApplicationsType(), $listeApplications);

	 	
		$form->handleRequest($request);

	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			//On sauvegarde les villes dans la base
        	foreach($form->get('listeApplications')->getData() as $app) {

				//On ne sauvegarde pas celle qui ont un nom null
				if ($app->getNom() != null) {
					$em->persist($app);
				}
			}
        	
        	
        	$em->flush();
        	

			return new Response('true');

    	} else {
	 		
	 		return $this->render('JCAdminBundle:Admin:modif_applications.html.twig', array('form'=>$form->createView()));
		}
	 }
	 
	 
	 
	 
	 




	/*
	 *	Pour modifier les activite 
	 */
	 public function modificationActivitesAction(Request $request) {

	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les activites
	 	$listeAct = $em->getRepository('JCCommandeBundle:Activite')->getActiviteOrdreAlpha()->getQuery()->getResult(); 
	 	
	 	//Liste qui sera transformée en formulaire
	 	$listeActivites = new ListeActivites();
	 	$listeActivites ->setListeActivites($listeAct);
	 		 	
	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque clé)
        $form = $this->get('form.factory')->create(new ListeActivitesType(), $listeActivites);

	 	
		$form->handleRequest($request);

	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			//On sauvegarde les activites dans la base
        	foreach($form->get('listeActivites')->getData() as $act) {

				//On ne sauvegarde pas celle qui ont un nom null
				if ($act->getNom() != null) {
					$em->persist($act);
				}
			}
        	
        	
        	$em->flush();
        	

			return new Response('true');

    	} else {
	 		
	 		return $this->render('JCAdminBundle:Admin:modif_activites.html.twig', array('form'=>$form->createView()));
		}
	 }



}
