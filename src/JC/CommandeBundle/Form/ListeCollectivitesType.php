<?php

namespace JC\CommandeBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class ListeCollectivitesType extends AbstractType
{


	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listeCollectivites', 'collection', array(
            	'label' => false,
		        'type'         => new CollectiviteType(),
		        'allow_add'    => true,
		        'error_bubbling' => true,
		        'by_reference' => false,
		        'error_bubbling' => true)   )

            ->add('enregistrer', 'submit');
        ;
                    $builder ->getForm();




	//On ajoute une validation pour les collectivites
        $villeValidator = function(FormEvent $event){
	        
            $form = $event->getForm();

	        //On récupère la liste des collectiivtes du formulaire
	        $listeCollectivites = $form->get('listeCollectivites')->getData();
	        
	        //Liste qui contiendra les éléments à supprimer
	        $listeASupprimer = array();

	        //On parcours chaque collectivite pour savoir si une collectivite a un nom mais pas de date de début et de fin de mutualisation 
			foreach($listeCollectivites as $coll) {
				
				//Si la collectivite a un nom
				if ( $coll->getNom() != null ) {
					//Si la collectivite n'a pas de date de début de mutualisation
					if ( $coll->getDateDebutMutualisation() === null ){
						
						$form['listeCollectivites']->addError(new FormError("Veuillez mettre une date de début de mutualisation pour ".$coll->getNom()));
					}
					
					
					//Si la collectivite n'a pas de date de fin de mutualisation
					if ( $coll->getDateFinMutualisation() === null ) {
						
						$form['listeCollectivites']->addError(new FormError("Veuillez mettre une date de fin de mutualisation pour ".$coll->getNom()));
					}
				
				//Si le nom est null, et que toutes les dates aussi, pas de probleme, sinon erreur
				} else if (!( ($coll->getNom() === null) &&  ($coll->getDateDebutMutualisation() === null) && ($coll->getDateFinMutualisation() === null))){
						$form['listeCollectivites']->addError(new FormError("Veuillez entrer un nom à toutes les collectivites "));
				}
				
			}    	
	
    	    
	    };
        
        // adding the validator to the FormBuilderInterface
        $builder->addEventListener(FormEvents::POST_BIND, $villeValidator);
        

        }




    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\ListeCollectivites'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_listecollectivites';
    }
}
