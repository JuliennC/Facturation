<?php

namespace JC\CommandeBundle\Form;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListeImputationsType extends AbstractType
{

	
	protected $em;
	

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

	
	
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    	    
	  	
	  	  //On récupère toutes les sections pour ne pas avoir à faire autant de requete qu'li y a d'imputation
		$listeSections = $this->em->getRepository('JCCommandeBundle:SectionImputation')->findAll();

	  	
        $builder
            ->add('listeImputations', 'collection', array(
            	'label' => false,
		        'type'         => new ImputationType($listeSections),
		        'allow_add'    => true,
		        'error_bubbling' => true,
		        'by_reference' => false))

            ->add('enregistrer', 'submit');
        ;
         
        $builder ->getForm();

}



    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\ListeImputations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_listeimputations';
    }
}
