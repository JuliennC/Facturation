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


class AdminController extends Controller
{
    public function indexAction(Request $request, $annee )
    {
	     //Si aucune année n'est entrée, on modifie l'année précédente
		 if($annee === "html"){
			 $annee = date('Y');
			 $annee -= 1; 
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



	 	$em = $this->getDoctrine()->getManager();

	 	//On récupère la liste de toutes les collectivites
	 	$l = $em->getRepository('JCCommandeBundle:Collectivite')->findAll(); 

	 	//Liste qui sera transformée en formulaire
	 	$listeCollectivites = new ListeCollectivites();
	 	$listeCollectivites ->setListeCollectivites($l);
	 		 	
	 	
	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque infos)
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
        	

    	} 

	 	
	 	return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig', array('form'=>$form->createView()));


	 }





	 /*
	 *	Pour modifier les informations des collectivites dont l'année de début de mutualisation
	 *  est antérieur à l'année passée en paramêtre 
	 */
	 public function modificationInformationsCollectivitesAction(Request $request, $annee) {
		 		 
		 $listeInformations = array();

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
		 



		//Si on veut modifier les informations de l'année courrante.
		if ($annee === date('Y')) {
			 
			//Si c'est la première fois que l'on entre dans la partie admin de l'année
			if (sizeof($listeInformations) === 0) {

			
				//On parcours chaque collectivite pour mettre leur clées
				foreach($listeCollectivites as $coll) {

					//On récupère les information de l'année dernière pour pré-remplir les champs
					$listeInformationsPrecendentes = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findInformationsPourAnnee($annee-1);
	
					//On crée une information pour chaque clé
					foreach($listeCles as $cle) {
					
						$nouvelleInformation = new InformationCollectivite();
						$nouvelleInformation -> setCollectivite($coll);
						$nouvelleInformation -> setCleRepartition($cle);
						$nouvelleInformation -> setAnnee($annee);
						
						$nombre = 0;
						
						//On regarde si la clé été déjà utilisée l'année précédente
						foreach($listeInformationsPrecendentes as $ip){
							
							//Si elle était utilisée, on peut prendre le nombre
							if($ip->getCleRepartition() === $cle) {
								$nombre = $ip->getNombre();
								break;
							}
						}
						
						$nouvelleInformation -> setNombre($nombre);
						
						//On sauvegarde l'information
						$em->persist($nouvelleInformation);
					
					}

				}
				
				$em->flush();


			//Si des informations ont déjà été entrées pour l'année courrante
			} else {
				
				//Il faut s'assurrer qu'il n'y a pas eu de nouvelles clées créer entre temps
				
				//Pour cela on stocke les clés qui ont des informations entrées pour l'année courrante
				$listeClesUtilisees = array();

				foreach($listeInformations as $information){
					array_push($listeClesUtilisees, $information->getCleRepartition());					
				}
				
				//On fait la différence des deux listes
				dump($listeCles[0]);
				dump($listeClesUtilisees[0]);

				
				//On parcours l'ensemble des clés		
				foreach($listeCles as $cle){
					
					//On regarde si elles ont déjà leurs informations
					if(! in_array($cle, $listeClesUtilisees)){
						
						//Si la clé n'as pas d'information, on crée l'information pour chaque collectivite
						
						foreach($listeCollectivites as $coll){
						
							$nouvelleInformation = new InformationCollectivite();
							$nouvelleInformation -> setCollectivite($coll);
							$nouvelleInformation -> setCleRepartition($cle);
							$nouvelleInformation -> setAnnee($annee);						
							$nouvelleInformation -> setNombre(0);
								
							//On sauvegarde l'information
							$em->persist($nouvelleInformation);	
						}

					}
				}
				
				
				
				$em->flush();
				
			}
				
				
			//On récupère toutes les informations
			$listeInformations = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findInformationsPourAnnee($annee);
			
	



		//Si on veut mofifier les informations des années précédentes, il n'y a qu'a rechercher les informations.
		 }
						
				
		
		
			$listeCles = array();	
				
			//On récupère les clés de répartition.
			foreach($listeInformations as $information) {
				
				//Si la clé n'existe pas, on la crée
				if(! in_array($information->getCleRepartition()->getNom(), $listeCles)){
					
					array_push($listeCles, $information->getCleRepartition()->getNom());
				}
			}
			
			
					 
			$listeCollectivites = array();	
				
			//On récupère les collectivites
			foreach($listeInformations as $information) {
				
				//Si la clé n'existe pas, on la crée
				if(! in_array($information->getCollectivite()->getNom(), $listeCollectivites)){
					
					array_push($listeCollectivites, $information->getCollectivite()->getNom());
				}
			}

		
		
		//On crée maintenant la InformationsCollectiviteListe
		$informationsCollectiviteListe = new InformationsCollectiviteListe();
		$informationsCollectiviteListe -> setListeInformations($listeInformations);


		//On crée le formulaire (c'est lui qui contient chaque form pour chaque infos)
        $form = $this->get('form.factory')->create(new InformationsCollectiviteListeType(), $informationsCollectiviteListe);
		$form->handleRequest($request);

			
		//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

        	//On récupère la liste des informations du formulaire
        	$liste = $form->get('listeInformations')->getData();
        	
        	foreach($liste as $l) {
	        	
				$em->persist($l);

        	}
        	
        	$em->flush();
        
    	} 
	
		
        return $this->render('JCAdminBundle:Admin:modif_informations_collectivites.html.twig', array('form'=>$form->createView(),'annee'=>$annee, 'listeInformations'=>$listeInformations, 'listeCles'=>$listeCles, 'listeCollectivites'=>$listeCollectivites));
        
	 }








	/*
	*	Fonction qui redirige vers la page d'accueil, sert lors de la soumission d'un form valid 
	*/


}
