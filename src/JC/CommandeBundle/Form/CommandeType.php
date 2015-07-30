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
use JC\CommandeBundle\Entity\LivraisonRepository;
use JC\CommandeBundle\Entity\ActiviteRepository;
use JC\CommandeBundle\Entity\ImputationRepository;

class CommandeType extends AbstractType
{
	
	
	
	protected $em;
	
	//tableau qui contient les collectivites
	protected $tabColl;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
        
		$this->tabColl = $this->em->getRepository('JCCommandeBundle:Collectivite')->findCollectivitesPourDateOrdreAlpha(date("Y-m-d"));

    }
    
    
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    
	    //$tabColl = array('Nancy' =>'Nancy', 'Grand-Nancy' =>'Grand-Nancy', 'Tomblaine' =>'Tomblaine', 'Saint-Max' =>'Saint-Max', 'Essey-lès-Nancy' =>'Essey-lès-Nancy', 'Saulxures' =>'Saulxures');
		
		$tabNom= array();

		foreach($this->tabColl as $coll){
            $tabNom[$coll->getNom()] = $coll->getNom();
		}
		
        $builder
        

            ->add('reference', 'text' , array('error_bubbling' => true, 'required'=>false))
            ->add('libelleFacturation', 'textarea' , array('error_bubbling' => true))

                                                
            //->add('dateCreation', 'date')
            ->add('dateLivraison', 'date', array('widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd/MM/yyyy',
                                                'attr' => array('class' => 'date'),
                                                'error_bubbling' => true
                                                ))


            ->add('engagement', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('imputation',  'entity', array(
				'class'    => 'JCCommandeBundle:Imputation',
				'query_builder' => function(ImputationRepository $repo) {
									return $repo->getQueryOrdreAlpha();} ,
				'error_bubbling' => true))
				
				

            ->add('utilisateur', 'entity', array(
				'class'    => 'JCCommandeBundle:Utilisateur',
				'property' => 'display',
				'query_builder' => function(UtilisateurRepository $repo) {
									return $repo->getUtilisateurOrdreAlpha();},
				'error_bubbling' => true))

			
			->add('activite', 'entity', array(
				'class'    => 'JCCommandeBundle:Activite',
				'property' => 'nom',
				'query_builder' => function(ActiviteRepository $repo) {
									return $repo->getActiviteNonAncienneOrdreAlpha();} ,
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
											'multiple'=> true,
											'expanded' => true,
											'error_bubbling' => true))
			
						
			->add('listeLignesCommande', 'collection', array(
				'label' => false,
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
			->add('faxLivraison', 'text', array('required' => false , 'error_bubbling' => true))

                                                                                
            ->add('nomFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('adresseFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('complementAdresseFournisseur', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('codePostalFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('villeFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('telephoneFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('faxFournisseur', 'text', array('required' => false , 'error_bubbling' => true))
            ->add('contactFournisseur', 'text', array('required' => true , 'error_bubbling' => true))
            ->add('emailContactFournisseur', 'text', array('required' => true , 'error_bubbling' => true))

            ;
                                                                        
             
            foreach($this->tabColl as $coll){
                $nom = "repartition".$coll->getId();
                $builder -> add($nom, 'hidden', array('mapped'=>false,
                									  'error_bubbling' => true,
                								      'attr' => array('attr_nom_ville' => $coll->getNom())));
            }           
    		
    		$builder->add('enregistrer', 'submit');
                                        
                                                                        
            $builder ->getForm();
        




		//On ajoute une validation pour les collectivites
        $villeValidator = function(FormEvent $event){
	        
            $form = $event->getForm();
            
            //Si c'est une commande mutualisee, 
            if ($form->get('ventilation')->getData() == "Mutualisee"){
	            
	            //Pour que le form soit valide, il faut qu'au moins une ville soit selectionnee

	            //On récupère les villes selectionnees
	            $villes = $form->get('villes_concernees')->getData();	            
	            
	            //On s'assure qu'il y en ai au moins une
	            if ( sizeof($villes) < 1) {
	              $form['villes_concernees']->addError(new FormError("Vous devez sélectionner au moins une ville."));
	            }
	        }
	    
			//Si c'est une commande directe
			else if($form->get('ventilation')->getData() == "Directe"){
			
				//Pour que le formulaire soit valide, il faut qu'au moins un champs cache 
				// ai une 'value' non vide
				
				//On récupère les champs caches
	            $villes = $form->get('villes_concernees')->getData();	
	            
	            //On comptera le nombre de char non numeric
		        $pourcentageAdditione = 0;
		        
		        //On comptera le nombre d'input vide
				$nombreChampsVide = 0;
	            
	            //On parcours les collectivite afin de retrouver tous les champs caches
	            foreach($this->tabColl as $coll){
		            
		            $champsCache = $form->get('repartition'.$coll->getId())->getData();	
		            		            
					//Si le champs est vide
					if( (sizeof($champsCache) == 0) or ($champsCache == '')){
						$nombreChampsVide +=1;
						
					//Si un champs contient des char non numeric
					} else if ( ! is_numeric($champsCache) ){
			            	              
			           	$form['repartition'.$coll->getId()]->addError(new FormError("Le champs de ".$coll->getNom()." doit être un numérique"));


		            } else {
						$pourcentageAdditione += $champsCache;			            
		            }
	            
	            }
			

				//Si aucun champs n'est rempli
				if($nombreChampsVide == sizeof($this->tabColl)){
	              	$form['villes_concernees']->addError(new FormError("Vous devez affecter la commande à au moins une collectivite."));
				
				
				//Si le total des pourcentages ne fait pas 100
				} else if($pourcentageAdditione != 100){
	              	$form['villes_concernees']->addError(new FormError("Le total des pourcentages doit faire 100."));
				}
			
			}
	    
	    };

        // adding the validator to the FormBuilderInterface
        $builder->addEventListener(FormEvents::POST_BIND, $villeValidator);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //On ajoute une validation pour les collectivites
        $modifTelephone = function(FormEvent $event){
	                    
            $data = $event->getData();
            
            //Tableau des numéro de téléphone/fax a changer
            $listeNum = array('telephoneLivraison', 'telephoneFournisseur', 'faxLivraison', 'faxFournisseur');
            
            foreach($listeNum as $num) {
	         
	         	//On récupère le numero de téléphone 
			 	$numeroTelephone = $data[$num];
            
	            //On enlève tous les espaces qu'il peut y avoir
            	$numeroTelephone = preg_replace('/\s+/', '', $numeroTelephone);
			
				//On remet le numero de téléphone
    	        $data[$num] = $numeroTelephone;
	            $event->setData($data);            
	            
            }
				    
	    };

        // adding the validator to the FormBuilderInterface
        $builder->addEventListener(FormEvents::PRE_BIND, $modifTelephone);
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
