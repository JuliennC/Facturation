<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForfaitType extends AbstractType
{	
	
	protected $listeCollectivites;
	protected $listeApplications;


    function __construct($listeCollectivites, $listeApplications)
    {
        $this->listeCollectivites = $listeCollectivites;
        $this->listeApplications = $listeApplications;
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
					))
					
					
			->add('application', 'entity', array(
				    'class'    => 'JCCommandeBundle:Application',
				    'choices'   => $this->listeApplications,
				    'multiple'  => false ,
				    'expanded' => false,
					'error_bubbling' => false,
					))
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
