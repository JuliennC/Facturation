<?php

namespace JC\CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JC\CommandeBundle\Entity\TVARepository;

class LigneCommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'textarea', array('required' => true , 'error_bubbling' => true))
            ->add('reference', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('quantite', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('prixUnitaire', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('totalTTC', 'hidden')
            ->add('tva', 'entity', array(
				'mapped' => true,
				'class'    => 'JCCommandeBundle:TVA',
				'property' => 'display',
				'query_builder' => function(TVARepository $repo) {
									return $repo->getTVACroissant();} ,
				'error_bubbling' => true
				))

            ->add('commentaire', 'textarea', array('required' => false , 'error_bubbling' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\LigneCommande'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_lignecommande';
    }
}
