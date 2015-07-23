<?php

namespace JC\BugReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

use JC\BugReportBundle\Entity\Bug;
use JC\BugReportBundle\Form\BugType;


class BugReportController extends Controller
{
    public function indexAction(Request $request)
    {
	    
	    
	   $em = $this->getDoctrine()->getManager();

	 	$bug = new Bug();
	 	
	 	//On récupère tous les bugs	
	 	$listeBugs = $em->getRepository('JCBugReportBundle:Bug')->findAll();

	 	//On crée le formulaire (c'est lui qui contient chaque form pour chaque collectivite)
        $form = $this->get('form.factory')->create(new BugType(), $bug);
		$form->handleRequest($request);

	 	//Si le formulaire est valide, on sauvegarde dans la base
		if ($form->isValid()) {

			
			$session = $request->getSession();
			$session->getFlashBag()->add('Success', 'Votre report à bien été envoyé.');

			 // Ajoutez cette ligne :
			 // c'est elle qui déplace l'image là où on veut les stocker
			 $bug->getImage()->upload();
			
			$em->persist($bug);
			
           	$em->flush();
        	
				return $this->redirect($this->generateUrl('jc_bug_report_homepage'));

		}	    			

   			
	    
	    
	    
        return $this->render('JCBugReportBundle:BugReport:index.html.twig', array('form'=>$form->createView(), 'listeBugs'=>$listeBugs));
    }
}
