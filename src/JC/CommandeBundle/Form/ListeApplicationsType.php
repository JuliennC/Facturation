<?php

namespace JC\CommandeBundle\Form;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListeApplicationsType extends AbstractType
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
	    
	     //On récupère tous les fournisseurs pour ne pas avoir à faire autant de requete que d'application
		$listeFournisseurs = $this->em->getRepository('JCCommandeBundle:Fournisseur')->findFournisseursOrdreAlpha()->getQuery()->getResult();
        
	    
        $builder
            ->add('listeApplications', 'collection', array(
            	'label' => false,
		        'type'         => new ApplicationType($listeFournisseurs),
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
