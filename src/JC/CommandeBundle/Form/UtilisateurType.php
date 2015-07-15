<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JC\CommandeBundle\Entity\ServiceRepository;


class UtilisateurType extends AbstractType
{
	
	
		
	protected $listeServices;
	

    function __construct($listeServices)
    {
        $this->listeFournisseurs = $listeServices;
    }
	
	
	
	
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            
            
            ->add('service', 'entity', array(
				    'class'    => 'JCCommandeBundle:Service',
				    'choices'   => $this->listeFournisseurs,
				    'multiple'  => false ,
				    'expanded' => false,
					'error_bubbling' => false,
					));

            
            /*->add('service','entity', array(
					'class'    => 'JCCommandeBundle:Service',
					'property' => 'nom',
					'query_builder' => function(ServiceRepository $repo) {
										return $repo->getServiceNonAncienOrdreAlpha();},
					'error_bubbling' => true, 
					))    */
				;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_utilisateur';
    }
}
