<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForfaitType extends AbstractType
{	
	
	protected $listeCollectivites;
	

    function __construct($listeCollectivites)
    {
        $this->listeCollectivites = $listeCollectivites;
    }



	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('montant', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))

			->add('collectivite', 'entity', array(
				    'class'    => 'JCCommandeBundle:Collectivite',
				    'choices'   => $this->listeCollectivites,
				    'multiple'  => false ,
				    'expanded' => false,
					'error_bubbling' => false,
					));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Forfait'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_forfait';
    }
}
