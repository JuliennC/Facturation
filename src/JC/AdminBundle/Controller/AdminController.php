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
		 
        return $this->render('JCAdminBundle:Admin:modif_collectivites.html.twig');
	 }

}
