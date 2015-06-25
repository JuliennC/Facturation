<?php

namespace JC\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use JC\AccueilBundle\Entity\Recherche;


class AccueilController extends Controller
{
	
	
    public function indexAction()
    {
        return $this->render('JCAccueilBundle:Accueil:index.html.twig');
    }
    



	public function navBarreAction(Request $request) {
		
		
		// On crée un objet Advert
		$recherche = new Recherche();

		// On crée le FormBuilder grâce au service form factory
		$form = $this->createFormBuilder($recherche)
		->add('objetRecherche', 'text')
		->add('Recherche', 'submit')
		->getForm()
		;
		
		$form->handleRequest($request);



		if ($form->isValid()) {
	      // On redirige vers la page de visualisation de l'annonce nouvellement créée
	      /*return $this->redirect($this->generateUrl('jc_accueil_recherche', array('recherche' => $recherche->getObjetRecherche() 
	      																			)));*/
	      																			
		  		return $this->render('JCAccueilBundle:Accueil:recherche.html.twig');

	    }
	
	        
		// Si la requête est en GET, on affiche une page de confirmation avant de supprimer
		return $this->render('JCAccueilBundle:Accueil:navBarre.html.twig', array('form' => $form->createView()) );
		
	}


	
	
	
	
	public function rechercheAction($recherche, $role) {

					
		return $this->render('JCAccueilBundle:Accueil:recherche.html.twig');
	
	}

	
	
    
}
