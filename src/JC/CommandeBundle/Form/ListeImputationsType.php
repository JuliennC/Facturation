<?php

namespace JC\CommandeBundle\Form;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListeImputationsType extends AbstractType
{

	protected $em;
	protected $annee;
	

    function __construct(EntityManager $em, $annee)
    {
        $this->em = $em;
        $this->annee = $annee;
    }


		
	
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    	    
	  	//On récupère tous les budgets pour ne pas avoir à faire autant de requete que de budget
		$listeBudgets = $this->em->getRepository('JCCommandeBundle:Budget')->findByAnnee($this->annee);

        $builder
            ->add('listeImputations', 'collection', array(
            	'label' => false,
		        'type'         => new ImputationType($listeBudgets),
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
