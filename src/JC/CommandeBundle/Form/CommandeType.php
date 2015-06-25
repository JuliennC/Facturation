<?php

namespace JC\CommandeBundle\Form;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

use JC\CommandeBundle\Entity\UtilisateurRepository;
use JC\CommandeBundle\Entity\FournisseurRepository;
use JC\CommandeBundle\Entity\ApplicationRepository;
use JC\CommandeBundle\Entity\ProjetRepository;
use JC\CommandeBundle\Entity\LivraisonRepository;
use JC\CommandeBundle\Entity\ActiviteRepository;

class CommandeType extends AbstractType
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
	    
	    //$tabColl = array('Nancy' =>'Nancy', 'Grand-Nancy' =>'Grand-Nancy', 'Tomblaine' =>'Tomblaine', 'Saint-Max' =>'Saint-Max', 'Essey-lès-Nancy' =>'Essey-lès-Nancy', 'Saulxures' =>'Saulxures');
	    $tabColl = $this->em->getRepository('JCCommandeBundle:Collectivite')->findAllOrdreAlpha();
		
		$tabNom= array();

		foreach($tabColl as $coll){
                    $tabNom[$coll->getNom()] = $coll->getNom();
		}
		
        $builder
        

            ->add('reference', 'text' , array('error_bubbling' => true))
            ->add('libelleFacturation', 'textarea' , array('error_bubbling' => true))

            ->add('dateEnvoi', 'date', array(	'widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd/MM/yyyy',
                                                'attr' => array('class' => 'date'),
                                                'error_bubbling' => true
                                                ))
                                                
            //->add('dateCreation', 'date')
            ->add('dateLivraison', 'date', array(	'widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd/MM/yyyy',
                                                'attr' => array('class' => 'date'),
                                                'error_bubbling' => true
                                                ))

            ->add('bonCoriolis', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('engagement', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('imputation', 'text', array('required' => false, 'error_bubbling' => true))

            ->add('utilisateur', 'entity', array(
				'class'    => 'JCCommandeBundle:Utilisateur',
				'property' => 'display',
				'query_builder' => function(UtilisateurRepository $repo) {
									return $repo->getUtilisateurOrdreAlpha();},
				'error_bubbling' => true))

			
			->add('activite', 'entity', array(
				'mapped' => false,
				'class'    => 'JCCommandeBundle:Activite',
				'property' => 'nom',
				'query_builder' => function(ActiviteRepository $repo) {
									return $repo->getActiviteOrdreAlpha();} ,
				'error_bubbling' => true))
			
			->add('application', 'entity', array(
				'class'    => 'JCCommandeBundle:Application',
				'property' => 'display',
				'query_builder' => function(ApplicationRepository $repo) {
									/*return $repo->getApplicationWithActiviteName("Activite_1")*/
									return $repo->getApplicationOrdreAlpha();},
				'error_bubbling' => true))

			//Le champs est caché car on passe par des bouton
			->add('ventilation', 'hidden')
			
			->add('etat', 'hidden', array('mapped' => false))
			
			// On s'oocupe des différentes villes
			->add('villes_concernees', 'choice', array('choices' => $tabNom, 
											'mapped' => false,
											'multiple'=>true,
											'expanded' => true,
											'error_bubbling' => true))
			

                     
            ->add('enregistrer',      'submit')
						
			->add('listeLignesCommande', 'collection', array(
		        'type'         => new LigneCommandeType(),
		        'allow_add'    => true,
		        'allow_delete' => true,
		        'error_bubbling' => true,
		        'by_reference' => false
		        
		      ))			
			
                                                                                
                                                                                
            ->add('nomLivraison', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('adresseLivraison', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('complementAdresseLivraison', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('codePostalLivraison', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('villeLivraison', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('telephoneLivraison', 'text', array('required' => true , 'error_bubbling' => true))
			
                                                                                
            ->add('nomFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('adresseFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('complementAdresseFournisseur', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('codePostalFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('villeFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('telephoneFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ;
                                                                        
             
            foreach($tabColl as $coll){
                $nom = "repartition".$coll->getId();
                $builder -> add($nom, 'hidden', array('mapped'=>false));
            }                                                   
                                                                        
            $builder ->getForm();
        




		//On ajoute une validation pour les collectivites
        $villeValidator = function(FormEvent $event){
	        
            $form = $event->getForm();
            $villes = $form->get('villes_concernees')->getData();
            
            if ( sizeof($villes) < 1) {
              $form['villes_concernees']->addError(new FormError("Vous devez sélectionner au moins une ville."));
            }
        };

        // adding the validator to the FormBuilderInterface
        $builder->addEventListener(FormEvents::POST_BIND, $villeValidator);
    }
    


        
    
    
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JC\CommandeBundle\Entity\Commande'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_commandebundle_commande';
    }
}
