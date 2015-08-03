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

use JC\CommandeBundle\Entity\Imputation;
use JC\CommandeBundle\Entity\ListeImputations;
use JC\CommandeBundle\Form\ImputationType;
use JC\CommandeBundle\Form\ListeImputationsType;

use JC\CommandeBundle\Entity\MasseSalariale;
use JC\CommandeBundle\Entity\ListeMassesSalariales;
use JC\CommandeBundle\Form\MasseSalarialeType;
use JC\CommandeBundle\Form\ListeMassesSalarialesType;

use JC\CommandeBundle\Entity\TempsPasse;
use JC\CommandeBundle\Entity\ListeTempsPasses;
use JC\CommandeBundle\Form\TempsPasseType;
use JC\CommandeBundle\Form\ListeTempsPassesType;

use JC\CommandeBundle\Entity\Forfait;
use JC\CommandeBundle\Entity\ListeForfaits;
use JC\CommandeBundle\Form\ForfaitType;
use JC\CommandeBundle\Form\ListeForfaitsType;

use JC\CommandeBundle\Entity\ImputationConcerneBudget;




class AdminController extends Controller
{
    public function indexAction(Request $request, $annee )
    {

		//Si aucune année n'est entrée
		if($annee === "html"){
			 $annee = date('Y');
		}






		$formulaireEnvoye = $request->request->all();
		
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les collectivités ont été enregistrées avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des collectivités');
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les informations sur les collectivités ont été enregistrés avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des informations sur les collectivités');
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les clés de répartitions ont été enregistrées avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des clés de répartitions');
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les utilisateurs ont été enregistrés avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des utilisateurs');
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les services ont été enregistrés avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des services');
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les budgets ont été enregistrés avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des budgets');
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les applications ont été enregistrées avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des applications');
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
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les activités ont été enregistrées avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des activités');
			}
			
			
			
			
			
			
			
		//Si le formulaire envoyé est le formulaire des imputations
		} else if(isset($formulaireEnvoye['jc_commandebundle_listeimputations'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationImputationsAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les imputations ont été enregistrées avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des imputations');
			}
		
		
		
		
		
		
		
		//Si le formulaire envoyé est le formulaire des masses salariales
		} else if(isset($formulaireEnvoye['jc_commandebundle_listemassessalariales'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationMassesSalarialesAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les masses salariales ont été enregistrées avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des masses salariales');
			}
		
		
		




		//Si le formulaire envoyé est le formulaire des temps passés
		} else if(isset($formulaireEnvoye['jc_commandebundle_listetempspasses'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationTempsPassesAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les temps passés ont été enregistrés avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des temps passés');
			}
		
		
		
		
		
		
		//Si le formulaire envoyé est le formulaire des forfaits
		} else if(isset($formulaireEnvoye['jc_commandebundle_listeforfaits'])) {
				
			//A ce moment, on veut savoir si le form est valide
			/*
			*	Si le form est valide, la fonction renvoie 'true'
			*	Sinon la fonction renvoie le template
			*/
			$form_est_valid = $this->modificationForfaitsAction($request, $annee);
			
			
			//Donc si le form est valide, on redirige
			if($form_est_valid->getContent() === 'true'){
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Success', 'Les forfaits ont été enregistrés avec succès.');
				
				return $this->redirect($this->generateUrl('jc_admin_homepage', array($annee)));
			
			} else {
				
				$session = $request->getSession();
				$session->getFlashBag()->add('Error', 'Erreur dans l\'enregistrement des forfaits');
			}
		}



	

		set_time_limit(0);

        	
		//Si aucune requête, alors on affiche simplement les formulaires
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
	    	
	 		return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig', array('form'=>$form->createView()));
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
					$nouvelleInformation -> setNombre(0);

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
        $form = $this->get('form.factory')->create(new ListeUtilisateursType($em), $listeUtilisateurs);

	 	
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
	 *	Pour modifier les Services
	 *  
	 */
	 public function modificationServicesAction(Request $request) {

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
	 *	Pour modifier les informations des budgets des services
	 */
	 public function modificationBudgetsAction(Request $request, $annee) {
		 		 

		$em = $this->getDoctrine()->getManager();

		 
		//On récupère les budgets
		$listeB = $em->getRepository('JCCommandeBundle:Budget')->findByAnnee($annee);
				

		//Liste qui sera transformée en form
		$listeBudgets = new ListeBudgets();
		$listeBudgets -> setListeBudgets($listeB);
			
	    $form = $this->get('form.factory')->create(new ListeBudgetsType($em), $listeBudgets);
		$form->handleRequest($request);
			
		//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

        	//On récupère la liste des informations du formulaire
        	$listeBudgets = $form->get('listeBudgets')->getData();

        	foreach($listeBudgets as $b) {
			
				if($b->getMontant() != 0){
					$b->setAnnee($annee);
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
        $form = $this->get('form.factory')->create(new ListeApplicationsType($em), $listeApplications);

	 	
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
	 		//var_dump( 'mem 7 : '.(memory_get_usage()/1024/1024));

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
        $form = $this->get('form.factory')->create(new ListeActivitesType($em), $listeActivites);

	 	
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





	 


	/*
	 *	Pour modifier les imputations 
	 */
	 public function modificationImputationsAction(Request $request, $annee) {

	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les activites
	 	$listeImp = $em->getRepository('JCCommandeBundle:Imputation')->getQueryOrdreAlpha($annee)->getQuery()->getResult(); 
	 
	 	
	 	//Liste qui sera transformée en formulaire
	 	$listeImputations = new ListeImputations();
	 	$listeImputations ->setListeImputations($listeImp);
	 		 	
		//On récupère les imputationsConcerneBudget	 		 	
		$listeICB = $em->getRepository('JCCommandeBundle:ImputationConcerneBudget')->findAvecAnnee($annee); 
		

		//On trie les imputationConcerneBudget en fonction des imputation
		foreach($listeImp as $imp){
						
			foreach($listeICB as $icb){
				
				if($imp === $icb->getImputation()){

					$imp->addImputationConcerneBudget($icb->getBudget()->getId());
					
				}
			}
		}	


	 		 	
	 	//On crée le formulaire		
        $form = $this->get('form.factory')->create(new ListeImputationsType($em,$annee), $listeImputations);
	 	
		$form->handleRequest($request);

	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {
			

        	foreach($form->get('listeImputations') as $imp) {

				//On ne sauvegarde pas celle qui ont un nom null
				if ($imp->getData()->getLibelle() != null) {
									
					//On regarde si c'est une nouvelle imputation
					if(! in_array($imp->getData(), $listeImp)){
						
						//Si c'est une nouvelle imputaion, il faut récupérer la section

						$imp->getData()->setSection($imp->get('section')->getData());
						
					}
									
									
									
					//on suprime les imputationConcerneBudget
					foreach($listeICB as $icb) {
						$em->remove($icb);
					}
					
					
					//On enregistre les nouveaux imputationConcerneBudget
					
					//On récupère les checkbox des budgets
					$listeCheckBoxBudgets = $imp->get('listeImputationConcerneBudget')->getData();

					//on les enregistre
					foreach($listeCheckBoxBudgets as $idBudget){
						
						$icb = new ImputationConcerneBudget();
						$icb->setImputation($imp->getData());
						$icb->setBudget($em->getRepository('JCCommandeBundle:Budget')->findOneById($idBudget));
						
						$em->persist($icb);
					}
	
					
					$em->persist($imp->getData());
				}
			}
        	
        	
        	$em->flush();
        	

			return new Response('true');

    	} else {
	    	

	    
	 		return $this->render('JCAdminBundle:Admin:modif_imputations.html.twig', array('form'=>$form->createView(), 'annee'=>$annee));
		}
	 }






	 /*
	 *	Pour modifier les informations des collectivites dont l'année de début de mutualisation
	 *  est antérieur à l'année passée en paramêtre 
	 */
	 public function modificationMassesSalarialesAction(Request $request, $annee) {
		 		 

		$em = $this->getDoctrine()->getManager();

		 
		//On récupère les services
		$listeServices = $em->getRepository('JCCommandeBundle:Service')->getServiceOrdreAlpha()->getQuery()->getResult(); 

		//On récupère les masses salariales
		$listeMS = $em->getRepository('JCCommandeBundle:MasseSalariale')->getQueryByAnnee($annee)->leftJoin('ms.service', 's')->addSelect('s')->getQuery()->getResult();


		//On crée une liste des services que l'on trouvent grâce aux budgets, elle sera comparée à la liste de tous les services
		$listeServicesTrouves = array();

		//On parcours les budgets
		foreach($listeMS as $ms){
					
			//Et si le service n'est pas déjà ajouté, on l'ajoute
			if(! array_key_exists($ms->getService()->getNom(), $listeServicesTrouves)){
				$listeServicesTrouves[$ms->getService()->getNom()] = $ms;
			}
		}


		//Liste qui sera transformée en form
		$listeMassesSalariales = new ListeMassesSalariales();

				
		//On parcours chaque service pour savoir s'il a déjà une masse salariale de créée
		foreach($listeServices as $service) {										

			//Si une massa salariale existe, on le récupère
			if (array_key_exists($service->getNom(), $listeServicesTrouves)){

				$listeMassesSalariales->addMasseSalariale( $listeServicesTrouves[$service->getNom()] );
					
			//Sinon, on en crée un
			} else {

				$nouvelleMS = new MasseSalariale();
				$nouvelleMS -> setService($service);
				$nouvelleMS -> setAnnee($annee);
				$nouvelleMS -> setMontant(0);
												
				$listeMassesSalariales->addMasseSalariale($nouvelleMS);
			}

		}
		
		
			
	    $form = $this->get('form.factory')->create(new ListeMassesSalarialesType(), $listeMassesSalariales);
		$form->handleRequest($request);

		//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

        	//On récupère la liste des informations du formulaire
        	$listeMassesSalariales = $form->get('listeMassesSalariales')->getData();

        	foreach($listeMassesSalariales as $ms) {
			
				if($ms->getMontant() != 0){
					$em->persist($ms);
				}
        	}
        	
        	$em->flush();
        
			return new Response('true');


    	} else {
			
			//return new Response("kjb");
			return $this->render('JCAdminBundle:Admin:modif_masses_salariales.html.twig', array('form'=>$form->createView(),'annee'=>$annee));
		      	
		}
	}









	



	 /*
	 *	Pour modifier les temps passés
	 *  (Rappel : Chaque collectivite passe un certain temps (en %) sur chaque activite
	 *	informations tirées d'EasyLog 
	 */
	 public function modificationTempsPassesAction(Request $request, $annee) {
		 		 
		 
		 $listeTempsATransformee = array();

		 $em = $this->getDoctrine()->getManager();

		 
		//On récupère les collectivite pour l'année 
		$listeCollectivites = $em->getRepository('JCCommandeBundle:Collectivite')->findCollectivitesPourAnnee($annee); 

		//On récupère toutes les activites
		$listeActivites = $em->getRepository('JCCommandeBundle:Activite')->findAll(); 

		//On récupère la liste des temps passés, pour les collectivites "mutualisées" au cours de l'année $année
		//C'est à dire : - date début mutualisation <= $annee
		// 				- ET date fin mutualisation >= $annee
		// Note : On fait deux orderBy dans la requête, ce qui évite de réaliser des traitements pour trier les données
		$listeTemps = $em->getRepository('JCCommandeBundle:TempsPasse')->findTempsPourAnnee($annee);


		//On ajoute touts les temps récupérées dans la liste qui sera transformée en formulaire
		$listeTempsPourForm = new ListeTempsPasses();



			
		//On parcours chaque collectivite pour mettre leur temps manquants
		foreach($listeCollectivites as $coll) {
					
					
			/*	On a récupéré les informations déjà entrées
			* 	On cherche les temps manquants
			*/
				
			//Pour cela on stocke les temps entrés pour l'année donnée
			$listeActivitesUtilisees = array();
	
			foreach($listeTemps as $temps){
				
				if($temps->getCollectivite() === $coll){
					array_push($listeActivitesUtilisees, $temps->getActivite());

					//Et on ajoute le temps dans la liste qui sera transformée en formulaire
					$listeTempsPourForm->addTempsPasse($temps);		
				}
			}
	
					
					


						
			//On parcours les clés qui doivent être remplies
			foreach($listeActivites as $activite) {
						
				/*	On regarde si l'activite a déjà son information
				*	Si elle n'est pas présente dans le tableau des activites utilisées, il faut alors la rajouter
				*	On crée alors une nouvelle information
				*/	
				if(! in_array($activite, $listeActivitesUtilisees)){ 
							
					$nouveauTemps = new TempsPasse();
					$nouveauTemps -> setCollectivite($coll);
					$nouveauTemps -> setActivite($activite);
					$nouveauTemps -> setAnnee($annee);			
					$nouveauTemps -> setPourcentage(0);

					//On met l'information dans la liste
					$listeTempsPourForm->addTempsPasse($nouveauTemps);		
				}
				
			}

		}
				
				

		//On crée le formulaire (c'est lui qui contient chaque form pour chaque infos)
        $form = $this->get('form.factory')->create(new ListeTempsPassesType(), $listeTempsPourForm);
		$form->handleRequest($request);

		
		//On affiche la mémoire utilisée
		// A SUPPRIMER
        $mem_usage = memory_get_usage(true); 
		//var_dump(round($mem_usage/1048576,2)." megabytes");


		//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

        	//On récupère la liste des informations du formulaire
        	$liste = $form->get('listeTempsPasses')->getData();
        	
        	foreach($liste as $l) {
	        	
				$em->persist($l);

        	}
        	
        	$em->flush();
        
			return new Response('true');

    	} else {

			return $this->render('JCAdminBundle:Admin:modif_temps_passes.html.twig', array('form'=>$form->createView(),'annee'=>$annee, 'listeActivites'=>$listeActivites, 'listeCollectivites'=>$listeCollectivites));
		}        	

	}






	/*
	 *	Pour modifier les Forfaits 
	 */
	 public function modificationForfaitsAction(Request $request, $annee) {

	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les forfaits de l'année
	 	$listeForf = $em->getRepository('JCCommandeBundle:Forfait')->findByAnnee($annee); 
	 	
	 	//Liste qui sera transformée en formulaire
	 	$listeForfaits = new ListeForfaits();
	 	$listeForfaits ->setListeForfaits($listeForf);
	 	
	 	//Si aucun forfait n'est trouvé, c'est que l'on rentre pour la première fois dans la page forfait pour l'année donnée, 
	 	//On va donc récupérer les forfaits de l'année précédente
	 	if(sizeof($listeForf) === 0){
		 	
		 	//On récupère la liste de toutes les forfaits de l'année
		 	$listeForf = $em->getRepository('JCCommandeBundle:Forfait')->findByAnnee($annee-1); 


		 	
		 	//On parcours tous les forfaits trouvés l'année passée pour les renouveller cette année
		 	foreach($listeForf as $forfait){
			 	
			 	$nouveauForfait = new Forfait();
			 	$nouveauForfait->setCollectivite($forfait->getCollectivite());
			 	$nouveauForfait->setMontant($forfait->getMontant());
			 	$nouveauForfait->setAnnee($annee);

			 	$listeForfaits ->addForfait($nouveauForfait);
			 	
			 	//On enregistre le forfait dans la base
			 	$em->persist($nouveauForfait);

		 	}
		 	
		 	$em->flush();
		 	
		 	$listeForfaits ->setListeForfaits($listeForf);
	 	}
	 		

	 	 	
	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque clé)
        $form = $this->get('form.factory')->create(new ListeForfaitsType($em), $listeForfaits);
        	 	
		$form->handleRequest($request);



	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			//On sauvegarde les activites dans la base
        	foreach($form->get('listeForfaits')->getData() as $f) {

				//On ne sauvegarde pas celle qui ont un montant null
				if ($f->getMontant() != null) {


					$f->setAnnee($annee);
					$em->persist($f);
				}
			}
			

			
			//On regarde si des forfaits ont été supprimés
			foreach($listeForf as $forfait){
					
				if (! in_array($forfait, $form->get('listeForfaits')->getData())) {

					$em->remove($forfait);
				}
			}
			
        	$em->flush();
        	
			return new Response('true');


    	} else {

	 		return $this->render('JCAdminBundle:Admin:modif_forfaits.html.twig', array('form'=>$form->createView(), 'annee'=>$annee));
		}
	 }



}
