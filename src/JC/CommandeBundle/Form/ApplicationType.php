<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JC\CommandeBundle\Entity\FournisseurRepository;


class ApplicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))
			
			->add('fournisseur', 'entity', array(
				'class'    => 'JCCommandeBundle:Fournisseur',
				'property' => 'nom',
				'query_builder' => function(FournisseurRepository $repo) {
									return $repo->findFournisseursOrdreAlpha();} ,
				'error_bubbling' => true))        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Application'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_application';
    }
}
