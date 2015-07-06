<?php

namespace JC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

	 public function modificationCollectiviteAction($annee) {
		 
		
		 
		$em = $this->getDoctrine()->getManager();
		 
		//On charge toutes les collectivites et leur infos par années
		$tabAnnee = array();
		$tabCle = array();

		 
		//On récupere toutes les infos sur toutes les collectivites
		$toutesInfos = $em->getRepository('JCCommandeBundle:InformationCollectivite')->findAll(); 
		
		//On les dispatche par année
		foreach ($toutesInfos as $info) {
			
			//Si c'est la première fois que l'on rencontre l'année
			//On crée son tableau
			if (! array_key_exists($info->getAnnee(), $tabAnnee)) {
				
				$tabAnnee[$info->getAnnee()] = array();
				$tabCle[$info->getAnnee()] = array();
			}
			
			
			//Si c'est la premiere fois que l'on rencontre cet collectivite dans cette année
			//On crée son tableau
			if (! array_key_exists($info->getCollectivite()->getNom(), $tabAnnee[$info->getAnnee()])) {
				
				$tabAnnee[$info->getAnnee()][$info->getCollectivite()->getNom()] = array();
			}
			
			//On stock l'information
			$tabAnnee[$info->getAnnee()][$info->getCollectivite()->getNom()]['nom'] = $info->getCollectivite()->getNom();
			
			$tabAnnee[$info->getAnnee()][$info->getCollectivite()->getNom()][$info->getCleRepartition()->getNom()] = $info->getNombre();
			
			if(! in_array($info->getCleRepartition()->getNom(), $tabCle[$info->getAnnee()])) {
				array_push($tabCle[$info->getAnnee()], $info->getCleRepartition()->getNom());
			}
		}
		 
		 
        return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig', array('annee'=>$annee, 'tabAnnee' => $tabAnnee, 'tabCle'=>$tabCle));
	 }

}
