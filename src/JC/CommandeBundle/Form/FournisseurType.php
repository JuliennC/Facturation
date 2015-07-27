<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FournisseurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('required' => true, 'error_bubbling' => true))
            ->add('adresse', 'text', array('required' => true, 'error_bubbling' => true))
            ->add('complementAdresse', 'text', array('required' => false, 'error_bubbling' => true))
            ->add('codePostal', 'text', array('required' => true, 'error_bubbling' => true))
            ->add('ville', 'text', array('required' => true, 'error_bubbling' => true))
            ->add('telephone', 'text', array('required' => true, 'error_bubbling' => true))
            ->add('fax', 'text', array('required' => true, 'error_bubbling' => true))
            ->add('contact', 'text', array('required' => true, 'error_bubbling' => true))
            ->add('emailContact', 'text', array('required' => true, 'error_bubbling' => true))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Fournisseur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_fournisseur';
    }
}
