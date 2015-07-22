<?php

namespace JC\CommandeBundle\Form;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ListeBudgetsType extends AbstractType
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
	    
	    
	    //On récupère tous les services pour ne pas avoir à faire autant de requete que de budget
		$listeServices = $this->em->getRepository('JCCommandeBundle:Service')->getServiceNonAncienOrdreAlpha()->getQuery()->getResult();
		
	    
        $builder
            ->add('listeBudgets', 'collection', array(
            	'label' => false,
		        'type'         => new BudgetType($listeServices),
			    'allow_add' => true,
		        'by_reference' => false,
		        'error_bubbling' => true)   )

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
            'data_class' => 'JC\CommandeBundle\Entity\ListeBudgets'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_listebudgets';
    }
}
