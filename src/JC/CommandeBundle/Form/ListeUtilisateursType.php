<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class ListeUtilisateursType extends AbstractType
{

	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listeUtilisateurs', 'collection', array(
            	'label' => false,
		        'type'         => new UtilisateurType(),
		        'allow_add'    => true,
		        'allow_delete' => true,
		        'error_bubbling' => true,
		        'by_reference' => false))

            ->add('enregistrer', 'submit');
        ;
         
        $builder ->getForm();








		//On ajoute une validation pour les collectivites
        $utilisateurValidator = function(FormEvent $event){
	        
            $form = $event->getForm();

	        //On récupère la liste des collectiivtes du formulaire
	        $listeUtilisateurs = $form->get('listeUtilisateurs')->getData();
	        
	       

	        //On parcours chaque utilisateur pour savoir s'il a un nom et un prénom 
			foreach($listeUtilisateurs as $user) {
				
				//Si la'utilisateur a un nom
				if ( $user->getNom() != null ) {
					
					//Et qu'il n'a pas de prénom
					if ( $user->getPrenom() === null ){
						
						$form['listeUtilisateurs']->addError(new FormError("Veuillez entrer un prénom pour ".$user->getNom()));
					}
					
									
				//Si l'utilisateur n'a pas de nom
				} else {
					
					//Et qu'il a un prénom
					if ( $user->getPrenom() != null ){
						
						$form['listeUtilisateurs']->addError(new FormError("Veuillez entrer un nom pour ".$user->getPrenom()));
					}

				}
				
			}    	
	
    	    
	    };
        
        // adding the validator to the FormBuilderInterface
        $builder->addEventListener(FormEvents::POST_BIND, $utilisateurValidator);



	}


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\ListeUtilisateurs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_listeutilisateurs';
    }
}
