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
    public function indexAction(Request $request, $annee)
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
	 public function modificationCollectivitesAction(Request $request) {

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
        	foreach($listeCollectivites as $coll) {
	        	
				$em->persist($coll);
			}
        	
        	
        	$em->flush();
        
    	} 

	 	
	 	return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig', array('form'=>$form->createView(), 'listeCollectivites'=>$listeCollectivites));


	 }


	 /*
	 *	Pour modifier les informations des collectivites dont l'année de début de mutualisation
	 *  est antérieur à l'année passée en paramêtre 
	 */
	 public function modificationInformationsCollectivitesAction(Request $request, $annee) {
		 		 
		 //On ne peut modifier les informations des collectivites au plus tot que dans l'année courrante
		 if($annee > date('Y')){
			 $annee = date('Y');
		 }	 	
		 	
		 	
		$em = $this->getDoctrine()->getManager();
		 
		//On sauvegardera toutes les collectivites et leur infos pour l'année donnée
		$tabInfo = array();
		$tabCle = array();

		 		
		//On crée la liste d'informations, c'est elle qui sera transformée en formulaire après
		$listeInformations = new InformationsCollectiviteListe();
		

		//On récupere toutes les infos sur toutes les collectivites correspondantes à l'année donnée
		$toutesInfos = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findByAnnee($annee); 
		
		//Si la liste ne contient aucune informations, c'est que c'est la première fois que l'on
		//ouvre la page admin de l'année courrante
		//On récupère donc toutes les infos de l'année précédente, et on les duplique en changeant l'année
		if(sizeof($toutesInfos) === 0) {
			

			//On récupere toutes les infos sur toutes les collectivites correspondantes à l'année donnée
			$toutesInfos = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findByAnnee($annee -1); 
			
			foreach ($toutesInfos as $info) {
				
				$nouvelleInfo = new InformationCollectivite();
				$nouvelleInfo -> setCollectivite($info->getCollectivite());
				$nouvelleInfo -> setNombre($info->getNombre());
				$nouvelleInfo -> setCleRepartition($info->getCleRepartition());
				$nouvelleInfo -> setAnnee($annee);
				
				$em->persist($nouvelleInfo);

			}
			
			$em->flush();
		
		
			//On récupere toutes les infos sur toutes les collectivites correspondantes à l'année donnée
			$toutesInfos = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findByAnnee($annee); 		
		}
		

		
		//liste qui contient les informations de manière temporaire
		$li = array();
		
		//On les dispatche informations par collectivite
		foreach ($toutesInfos as $info) {
			
			
			//Si c'est la premiere fois que l'on rencontre cette collectivite
			//On crée son tableau
			if (! array_key_exists($info->getCollectivite()->getNom(), $tabInfo)) {
				
				$tabInfo[$info->getCollectivite()->getNom()] = array();
				$li[$info->getCollectivite()->getNom()] = array();

			}
			
			//On stock l'information
			$tabInfo[$info->getCollectivite()->getNom()]['nom'] = $info->getCollectivite()->getNom();
			$tabInfo[$info->getCollectivite()->getNom()][$info->getCleRepartition()->getNom()] = $info->getNombre();
			
			//On stocke temporairement l'info
			$li[$info->getCollectivite()->getNom()][$info->getCleRepartition()->getNom()] = $info;
						
			//On sauvegarde la clé si ce n'est pas déjà fait
			if(! in_array($info->getCleRepartition()->getNom(), $tabCle)) {
				array_push($tabCle, $info->getCleRepartition()->getNom());
			}
		}


		//Pour ajouter nos informations à la liste, il faut le faire dans l'ordre du tableau
		// (sinon les informations ne seront pas forcément aux bons endroits ligne-colonne)
		//On parcours donc les clés
		foreach($tabInfo as $coll){
			
			//On parcours les villes
			foreach($tabCle as $cle){

				//On récupère l'information que l'on avait stocké temporairement
				$info = $li[$coll['nom']][$cle];
				
				//On ajoute l'info à la liste d'infos
				$listeInformations->addInformation($info);

			}
		}


				 
		
		//On crée le formulaire (c'est lui qui contient chaque form pour chaque infos)
        $form = $this->get('form.factory')->create(new InformationsCollectiviteListeType(), $listeInformations);
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
	
	
        return $this->render('JCAdminBundle:Admin:modif_informations_collectivites.html.twig', array('form'=>$form->createView(),'annee'=>$annee, 'tabInfos' => $tabInfo, 'tabCle'=>$tabCle));
	 }

}
