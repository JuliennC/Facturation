<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommandeConcerneCollectiviteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repartition')
            ->add('commande')
            ->add('collectivite')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\CommandeConcerneCollectivite'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_commandeconcernecollectivite';
    }
}
