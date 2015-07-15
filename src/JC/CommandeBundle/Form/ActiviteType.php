<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JC\CommandeBundle\Entity\CleRepartitionRepository;


class ActiviteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('required' => true , 'error_bubbling' => true, 'label' => false))
            
            ->add('estAncienneActivite','checkbox', array('required'=>false, 'error_bubbling' => true, ))
         
            ->add('cleRepartition', 'entity', array(
				'class'    => 'JCCommandeBundle:CleRepartition',
				'property' => 'nom',
				'query_builder' => function(CleRepartitionRepository $repo) {
									return $repo->getCleOrdreAlpha();} ,
				'error_bubbling' => true));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Activite'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_activite';
    }
}
