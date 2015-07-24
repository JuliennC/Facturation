<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImputationType extends AbstractType
{
	
		
	protected $listeBudgets;

	 function __construct($listeBudgets)  {

	 	$this->listeBudgets = array();

        foreach($listeBudgets as $b){
	        
	    	$this->listeBudgets[$b->getId()] = $b->__toString() ;
	    }

    }

	
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	   
	    
        $builder
            ->add('libelle', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))
            ->add('sousFonction', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))
            ->add('article', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))        
			->add('section')
            ->add('estFacture','checkbox', array('required'=>false, 'error_bubbling' => true ))
        
        
			// On s'oocupe des différentes budget
			->add('listeImputationConcerneBudget', 'choice', array('choices' => $this->listeBudgets, 
											'label'=> false,
											'multiple'=> true,
											'expanded' => true,
											'error_bubbling' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Imputation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_imputation';
    }
}
