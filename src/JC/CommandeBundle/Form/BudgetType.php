<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BudgetType extends AbstractType
{
	
	
	protected $listeServices;
	

    function __construct($listeServices)
    {
        $this->listeServices = $listeServices;
    }
	
	
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

				->add('service', 'entity', array(
				    'class'    => 'JCCommandeBundle:Service',
				    'choices'   => $this->listeServices,
				    'multiple'  => false ,
				    'expanded' => false,
					'error_bubbling' => false,
					))
					
            ->add('libelle', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))
            ->add('montant', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Budget'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_budget';
    }
}
