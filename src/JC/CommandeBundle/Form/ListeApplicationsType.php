<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListeApplicationsType extends AbstractType
{
	
	
	
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listeApplications', 'collection', array(
            	'label' => false,
		        'type'         => new ApplicationType(),
		        'allow_add'    => true,
		        'error_bubbling' => true,
		        'by_reference' => false))

            ->add('enregistrer', 'submit');
        ;
         
        $builder ->getForm();

}
	

	
	

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\ListeApplications'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_listeapplications';
    }
}
