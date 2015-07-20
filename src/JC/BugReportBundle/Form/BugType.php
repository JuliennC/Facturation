<?php

namespace JC\BugReportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BugType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',  'choice', array(
	            	'choices' => array('Bug', 'Amelioration', 'Question'),
					'multiple' => false,
					'expanded' => false,
					'error_bubbling' => true))
    
    
            ->add('utilisateur')
            ->add('circonstances', 'textarea', array('required' => true , 'error_bubbling' => true))
            ->add('commentaire', 'textarea', array('required' => true , 'error_bubbling' => true))
			
			->add('envoyer', 'submit');

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\BugReportBundle\Entity\Bug'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_bugreportbundle_bug';
    }
}
