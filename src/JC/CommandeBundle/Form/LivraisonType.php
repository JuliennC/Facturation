<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LivraisonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('adresse', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('complementAdresse', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('codePostal', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('ville', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('telephone', 'text', array('required' => true , 'error_bubbling' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Livraison'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_livraison';
    }
}
