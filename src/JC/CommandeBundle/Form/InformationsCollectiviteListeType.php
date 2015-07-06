<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class InformationsCollectiviteListeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listeInformations', 'collection', array(
            	'label' => false,
		        'type'         => new InformationCollectiviteType(),
		        'allow_add'    => true,
		        'allow_delete' => true,
		        'error_bubbling' => true,
		        'by_reference' => false,
		        'error_bubbling' => true)   )

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
            'data_class' => 'JC\CommandeBundle\Entity\InformationsCollectiviteListe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_informationscollectiviteliste';
    }
}
