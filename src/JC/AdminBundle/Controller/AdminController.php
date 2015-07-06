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


class AdminController extends Controller
{
    public function indexAction($annee)
    {
	     //Si aucune année n'est entrée, on modifie l'année précédente
		 if($annnee = "html"){
			 $annee = date('Y');
			 $annee -= 1; 
		}
		
        return $this->render('JCAdminBundle:Admin:index.html.twig', array('annee' => $annee));
    }
    
    
    
    
    /*
	 *	Fonctions qui permettent les modifications des tables
	 * le paramêtre année est pour savoir qu'elle année afficher
	 */

	 public function modificationCollectiviteAction(Request $request, $annee) {
		 
		
		 
		$em = $this->getDoctrine()->getManager();
		 
		//On charge toutes les collectivites et leur infos par années
		$tabInfo = array();
		$tabCle = array();

		 
		//On récupere toutes les infos sur toutes les collectivites
		$toutesInfos = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findAll(); 
		
		
		//On crée la liste d'informations, c'est elle qui sera transformée en formulaire après
		$listeInformations = new InformationsCollectiviteListe();
		
		//liste qui contient les informations de manière temporaire
		$li = array();
		
		//On les dispatche par année
		foreach ($toutesInfos as $info) {
			
			
			//Si c'est la premiere fois que l'on rencontre cet collectivite
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
						
			//Si l'on a pas encore entrée d'infos sur cette clé à cette année
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


		
			
		 
		
		//On crée le formulaire (c'est lui qui contient chaque form pour chaque infos
        $form = $this->get('form.factory')->create(new InformationsCollectiviteListeType($em), $listeInformations);
		$form->handleRequest($request);


		//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {
        echo("o");
        	//On récupère la liste des informations du formulaire
        	$liste = $form->get('listeInformations')->getData();
        	
        	foreach($liste as $l) {
	        	
	        		        $em->persist($l);

        	}
        	
        	$em->flush();
        	
			return $this->redirect($this->generateUrl('jc_accueil_homepage', array('annee'=>$annee)));

    	}
    	
		$le = $form->getErrorsAsString();

echo("jh : ".sizeof($le));

		 $form->getErrorsAsString();
        return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig', array('form'=>$form->createView(),'annee'=>$annee, 'tabInfos' => $tabInfo, 'tabCle'=>$tabCle));
	 }

}
