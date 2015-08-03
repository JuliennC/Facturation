<?php

namespace JC\CommandeBundle\Form;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ListeForfaitsType extends AbstractType
{


	protected $em;
	

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	     //On récupère toutes les collectivites et applications pour ne pas avoir à faire autant de requêtes que d'applications
		$listeCollectivites = $this->em->getRepository('JCCommandeBundle:Collectivite')->findAllOrdreAlpha();
		$listeApplications = $this->em->getRepository('JCCommandeBundle:Application')->getApplicationOrdreAlpha();

	    
	    
        $builder
            ->add('listeForfaits', 'collection', array(
            	'label' => false,
		        'type'         => new ForfaitType($listeCollectivites, $listeApplications),
		        'allow_add'    => true,
		        'allow_delete'    => true,
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
            'data_class' => 'JC\CommandeBundle\Entity\ListeForfaits'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_listeforfaits';
    }
}
