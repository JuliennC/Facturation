<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RechercheType extends AbstractType
{
	
	
	protected $champsDeRecherche;
	

    function __construct($champsDeRecherche)
    {
        $this->champsDeRecherche = $champsDeRecherche;
    }
	
	
	
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

			->add('objet', 'choice', array('choices' =>  $this->champsDeRecherche, 
											'multiple'=> false,
											'expanded' => false,
											'error_bubbling' => true))           
				
				
			->add('valeur', 'text', array('error_bubbling' => true))
			
            ->add('Rechercher', 'submit');
        ;
    
		
		$builder ->getForm();

    
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Recherche'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_recherche';
    }
}
