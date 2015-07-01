<?php

namespace JC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('JCAdminBundle:Admin:index.html.twig');
    }
    
    
    
    
    /*
	 *	Fonctions qui permettent les modifications des tables
	 */

	 public function modificationCollectiviteAction() {
		 
		$em = $this->getDoctrine()->getManager();
		 
		//On charge toutes les collectivites et leur infos par années
		$tabAnnee = array();
		 
		 
		//On récupere toutes les infos sur toutes les collectivites
		$toutesInfos = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findAll(); 
		
		//On les dispatche par année
		foreach ($toutesInfos as $info) {
			
			//Si c'est la première fois que l'on rencontre l'année
			//On crée son tableau
			if (! array_key_exists($info->getAnnee(), $tabAnnee)) {
				
				$tabAnnee[$info->getAnnee()] = array();
			}
			
			
			//Si c'est la premiere fois que l'on rencontre cet collectivite dans cette année
			//On crée son tableau
			if (! array_key_exists($info->getCollectivite()->getNom(), $tabAnnee)) {
				
				$tabAnnee[$info->getAnnee()] = array();
			}
			
		}
		 
		 
		 
        return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig');
	 }

}
