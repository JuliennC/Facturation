<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\CommandeRepository")
 */
class Commande
{
  
  
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Reference", type="string", length=255, nullable=true)
     */
    private $reference;

    

    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Livraison", type="datetime", nullable=true)
	 * @Assert\DateTime()
     */
    private $dateLivraison;


    /**
     * @var string
     *
     * @ORM\Column(name="Ventilation", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $ventilation;





	/**
     * @var string
     *
     * @ORM\Column(name="Engagement", type="string", length=255, nullable=true)
     */
    private $engagement;



	/**
     * @var string
     *
     * @ORM\Column(name="Libelle_Facturation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer libelle pour la facturation.")
     */
    private $libelleFacturation;


	/**
     * @var string
     *
     * @ORM\Column(name="Total_TTC", type="decimal", scale=2, nullable=false)
     */
    private $totalTTC;
    

// DEBUT CLES ETRANGERES


	/**
     * @var string
     *
     * @ORM\Column(name="Utilisateur", type="string", length=255, nullable=false)
     */
   private $utilisateur;



   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Service", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $service;



   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Application", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $application;
   
   
   

   
   
   
/* --------------- Informations concernant le fournisseur --------------- */
/* --------------- (Photo à l'instant T des information du fournisseur) --------------- */

   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Fournisseur", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   * @Assert\Valid()   
   */
   private $fournisseur;

   
   /**
     * @var string
     *
     * @ORM\Column(name="NomFournisseur", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un nom valide pour le fournisseur.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer un nom valide pour le fournisseur.")
     */
    private $nomFournisseur;

    /**
     * @var string
     *
     * @ORM\Column(name="AdresseFournisseur", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer une adresse de fournisseur valide.")
     * @Assert\Length(min=2 , minMessage="Veuillez saisir une adresse de fournisseur valide.")
     */
    private $adresseFournisseur;

    /**
     * @var string
     *
     * @ORM\Column(name="Complement_Adresse_Fournisseur", type="string", length=255, nullable=true)
     */
    private $complementAdresseFournisseur;

    /**
     * @var integer
     *
     * @ORM\Column(name="Code_Postal_Fournisseur", type="integer", nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un code postal de fournisseur valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un code postal de fournisseur valide.")  
     */
    private $codePostalFournisseur;

    /**
     * @var string
     *
     * @ORM\Column(name="VilleFournisseur", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer le nom d'une ville de fournisseur valide.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer un nom de ville de fournisseur valide.")
     */
    private $villeFournisseur;

    /**
     * @var string
     *
     * @ORM\Column(name="TelephoneFournisseur", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un numÃ©ro de téléphone de fournisseur valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un numéro de téléphone de fournisseur valide.")  
     */
    private $telephoneFournisseur;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="FaxFournisseur", type="string", length=255, nullable=true)
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un numéro de fax pour de fournisseur valide.")  
     */
    private $faxFournisseur;
    

	 /**
     * @var string
     *
     * @ORM\Column(name="ContactFournisseur", type="string", length=255, nullable=true)
     */
    private $contactFournisseur;


	/**
     * @var string
     *
     * @ORM\Column(name="EmailContactFournisseur", type="string", length=255, nullable=true)
     * @Assert\Regex("/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/", message="Veuillez entrer une addresse email valide pour le fournisseur.")  
     */
    private $emailContactFournisseur;





   
  /**
     * Set nomFournisseur
     *
     * @param string $nomFournisseur
     * @return Commande
     */
    public function setNomFournisseur($nomFournisseur)
    {
        $this->nomFournisseur = $nomFournisseur;

        return $this;
    }

    /**
     * Get nomFournisseur
     *
     * @return string 
     */
    public function getNomFournisseur()
    {
        return $this->nomFournisseur;
    }

    /**
     * Set adresse
     *
     * @param string $adresseFournisseur
     * @return Livraison
     */
    public function setAdresseFournisseur($adresseFournisseur)
    {
        $this->adresseFournisseur = $adresseFournisseur;

        return $this;
    }

    /**
     * Get adresseFournisseur
     *
     * @return string 
     */
    public function getAdresseFournisseur()
    {
        return $this->adresseFournisseur;
    }

    /**
     * Set complementAdresseLivraison
     *
     * @param string $complementAdresseFournisseur
     * @return Livraison
     */
    public function setComplementAdresseFournisseur($complementAdresseFournisseur)
    {
        $this->complementAdresseFournisseur = $complementAdresseFournisseur;

        return $this;
    }

    /**
     * Get complementAdresseFournisseur
     *
     * @return string 
     */
    public function getComplementAdresseFournisseur()
    {
        return $this->complementAdresseFournisseur;
    }

    /**
     * Set codePostalFournisseur
     *
     * @param integer $codePostalFournisseur
     * @return Commande
     */
    public function setCodePostalFournisseur($codePostalFournisseur)
    {
        $this->codePostalFournisseur = $codePostalFournisseur;

        return $this;
    }

    /**
     * Get codePostalFournisseur
     *
     * @return integer 
     */
    public function getCodePostalFournisseur()
    {
        return $this->codePostalFournisseur;
    }

    /**
     * Set villeFournisseur
     *
     * @param string $villeFournisseur
     * @return Commande
     */
    public function setVilleFournisseur($villeFournisseur)
    {
        $this->villeFournisseur = $villeFournisseur;

        return $this;
    }

    /**
     * Get villeFournisseur
     *
     * @return string 
     */
    public function getVilleFournisseur()
    {
        return $this->villeFournisseur;
    }

    /**
     * Set telephoneFournisseur
     *
     * @param string $telephoneFournisseur
     * @return Commande
     */
    public function setTelephoneFournisseur($telephoneFournisseur)
    {
        $this->telephoneFournisseur = $telephoneFournisseur;

        return $this;
    }

    /**
     * Get telephoneFournisseur
     *
     * @return string 
     */
    public function getTelephoneFournisseur()
    {
        return $this->telephoneFournisseur;
    }







/* --------------- Informations concernant la livraison --------------- */
/* --------------- (Photo à l'instant T des information du lieu de livraison) --------------- */

   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Livraison", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   * @Assert\Valid()   
   */
   private $livraison;

   
   /**
     * @var string
     *
     * @ORM\Column(name="NomLivraison", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un nom valide pour la livraison.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer un nom valide pour la livraison.")
     */
    private $nomLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="AdresseLivraison", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer une adresse de livraison valide.")
     * @Assert\Length(min=2 , minMessage="Veuillez saisir une adresse de livraison valide.")
     */
    private $adresseLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="Complement_Adresse_Livraison", type="string", length=255, nullable=true)
     */
    private $complementAdresseLivraison;

    /**
     * @var integer
     *
     * @ORM\Column(name="Code_Postal_Livraison", type="integer", nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un code postal de livraison valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un code postal de livraison valide.")  
     */
    private $codePostalLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="VilleLivraison", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer le nom d'une ville de livraison valide.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer un nom de ville de livraison valide.")
     */
    private $villeLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="TelephoneLivraison", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un numÃ©ro de tÃ©lÃ©phone de livraison valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un numÃ©ro de tÃ©lÃ©phone de livraison valide.")  
     */
    private $telephoneLivraison;

	/**
     * @var string
     *
     * @ORM\Column(name="Faxlivraison", type="string", length=255, nullable=true)
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un numéro de fax pour de livraison valide.")  
     */
    private $faxLivraison;



	/**
     * @var string
     *
     * @ORM\Column(name="MontantPaye", type="decimal", scale=2, nullable=false)
     */
    private $montantPaye;
   
   
   
   
   
   
   /**
     * Set nomLivraison
     *
     * @param string $nomLivraison
     * @return Livraison
     */
    public function setNomLivraison($nomLivraison)
    {
        $this->nomLivraison = $nomLivraison;

        return $this;
    }

    /**
     * Get nomLivraison
     *
     * @return string 
     */
    public function getNomLivraison()
    {
        return $this->nomLivraison;
    }

    /**
     * Set adresse
     *
     * @param string $adresseLivraison
     * @return Livraison
     */
    public function setAdresseLivraison($adresseLivraison)
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    /**
     * Get adresseLivraison
     *
     * @return string 
     */
    public function getAdresseLivraison()
    {
        return $this->adresseLivraison;
    }

    /**
     * Set complementAdresseLivraison
     *
     * @param string $complementAdresseLivraison
     * @return Livraison
     */
    public function setComplementAdresseLivraison($complementAdresseLivraison)
    {
        $this->complementAdresseLivraison = $complementAdresseLivraison;

        return $this;
    }

    /**
     * Get complementAdresseLivraison
     *
     * @return string 
     */
    public function getComplementAdresseLivraison()
    {
        return $this->complementAdresseLivraison;
    }

    /**
     * Set codePostalLivraison
     *
     * @param integer $codePostalLivraison
     * @return Livraison
     */
    public function setCodePostalLivraison($codePostalLivraison)
    {
        $this->codePostalLivraison = $codePostalLivraison;

        return $this;
    }

    /**
     * Get codePostalLivraison
     *
     * @return integer 
     */
    public function getCodePostalLivraison()
    {
        return $this->codePostalLivraison;
    }

    /**
     * Set villeLivraison
     *
     * @param string $villeLivraison
     * @return Livraison
     */
    public function setVilleLivraison($villeLivraison)
    {
        $this->villeLivraison = $villeLivraison;

        return $this;
    }

    /**
     * Get villeLivraison
     *
     * @return string 
     */
    public function getVilleLivraison()
    {
        return $this->villeLivraison;
    }

    /**
     * Set telephone
     *
     * @param string $telephoneLivraison
     * @return Livraison
     */
    public function setTelephoneLivraison($telephoneLivraison)
    {
        $this->telephoneLivraison = $telephoneLivraison;

        return $this;
    }

    /**
     * Get telephoneLivraison
     *
     * @return string 
     */
    public function getTelephoneLivraison()
    {
        return $this->telephoneLivraison;
    }


   /**
     * @var ArrayCollection
	 * @Assert\Valid()
     */

   private $listelignesCommande;


   
  

	
   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Activite", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $activite;




	/**
   * @ORM\OneToMany(targetEntity="JC\CommandeBundle\Entity\CommandePasseEtat", mappedBy="commande", cascade={"persist"})
   */
   private $etats;
   
   
   
   
   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Imputation", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $imputation;
   
   
   
// FIN DES COLONNES - DEBUT PROPRIETE AUTRE

	





	// FONCTIONS 
	
	public function __construct() {
					
		$this->totalTTC = 0;
	
	    $this->listelignesCommande = new ArrayCollection();
	        
	    $this->ventilation = "Directe";
	        
	    $this->etats = new ArrayCollection();
	    
	    $this->montantPaye = 0;
	}
	





// GETTER ET SETTER

	public function addEtat(CommandePasseEtat $etat){
		$this->etats->add($etat);
	}


	public function getEtat(){
		
		//On prend une vieille date pour pouvoir comparer les date des états, on est sur qu'aucun état n'est plus encien
		$dateEtat = new \DateTime("1970-01-01 00:00:00.0");
		
		$etat = null;
		
		foreach($this->etats as $e){
			if($e->getDatePassage() >= $dateEtat){
				$dateEtat = $e->getDatePassage();
				$etat = $e;
				
			}
		}
		
		return $etat->getEtat()->getLibelle();
	}


	public function getDateEngagement(){
		return $this->getCommandePasseEtat("Engagee");
	}

	public function getDateCreation(){
		return $this->getCommandePasseEtat("Creee");
	}


	/**
     * Get etat
     *
     * @return CommandePasseEtat 
     */
    public function getCommandePasseEtat($etat)
    {
        foreach($this->etats as $e){
	        if($e->getEtat()->getLibelle() === $etat){
		        return $e->getDatePassage();
	        }
        }
        
    }
	

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Commande
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    

    

    /**
     * Set dateLivraison
     *
     * @param \DateTime $dateLivraison
     * @return Commande
     */
    public function setDateLivraison($dateLivraison)
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    /**
     * Get dateLivraison
     *
     * @return \DateTime 
     */
    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    


	/**
     * Get listelignesCommande
     *
     * @return ArrayCollection 
     */
    public function getListelignesCommande()
    {   
	    return $this->listelignesCommande;
    }


	/**
     * Set listelignesCommande
     *
     * @param ArrayCollection $listelignesCommande
     * @return Commande
     */
	 public function setListelignesCommande($listelignesCommande)
    {
        $this->listelignesCommande = $listelignesCommande;

        return $this;
    }



	/**
     * Get TotalTTC
     *
     * @return string
     */

    public function getTotalTTC()
	{
	   return  "".$this->totalTTC;
	}
   
  
	
	/**
     * Set TotalTTC
     *
     * @param string $total
     * @return Commande
     */

    public function setTotalTTC($total)
	{
		$this->totalTTC = $total;
	   return $this;
	}
  
  
    /**
     * Set ventilation
     *
     * @param string $ventilation
     * @return Commande
     */
    public function setVentilation($ventilation)
    {
        $this->ventilation = $ventilation;

        return $this;
    }

    /**
     * Get ventilation
     *
     * @return string 
     */
    public function getVentilation()
    {
        return $this->ventilation;
    }


	


	/**
     * Set application
     *
     * @param Application $application
     * @return Commande
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return Application 
     */
    public function getApplication()
    {
        return $this->application;
    }





	/**
     * Set livraison
     *
     * @param Livraison $livraison
     * @return Commande
     */
    public function setLivraison(Livraison $livraison)
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * Get livraison
     *
     * @return Livraison 
     */
    public function getLivraison()
    {
        return $this->livraison;
    }


	
	/**
     * Set engagement
     *
     * @param string $engagement
     * @return Commande
     */
    public function setEngagement($engagement)
    {
        $this->engagement = $engagement;

        return $this;
    }

    /**
     * Get engagement
     *
     * @return Commande 
     */
    public function getEngagement()
    {
        return $this->engagement;
    }



	


	 /**
     * Set fournisseur
     *
     * @param Fournisseur
     * @return Commande
     */
    public function setFournisseur(Fournisseur $fournisseur)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return Fournisseur 
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }



	/**
     * Set libelleFacturation
     *
     * @param string $libelleFacturation
     * @return Commande
     */
    public function setLibelleFacturation($libelleFacturation)
    {
        $this->libelleFacturation = $libelleFacturation;

        return $this;
    }

    /**
     * Get libelleFacturation
     *
     * @return String 
     */
    public function getLibelleFacturation()
    {
        return $this->libelleFacturation;
    }




	

	/**
     * Set activite
     *
     * @param Activite
     * @return Commande
     */
    public function setActivite(Activite $activite)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get activite
     *
     * @return Activite 
     */
    public function getActivite()
    {
        return $this->activite;
    }



	/**
     * Set imputation
     *
     * @param imputation
     * @return Commande
     */
    public function setImputation(Imputation $imputation)
    {
        $this->imputation = $imputation;

        return $this;
    }

    /**
     * Get imputation
     *
     * @return Imputation 
     */
    public function getImputation()
    {
        return $this->imputation;
    }

	 
	 
	 
	 
	 /**
     * Set utilisteur
     *
     * @param string $utilisateur
     * @return Commande
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return String 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
	 
	 
	 
	 /**
     * Set service
     *
     * @param Service $service
     * @return Commande
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return Service 
     */
    public function getService()
    {
        return $this->service;
    }
	 
	 
	 
	 
	 /**
     * Set faxFournisseur
     *
     * @param string $faxFournisseur
     * @return Commande
     */
    public function setFaxFournisseur($faxFournisseur)
    {
        $this->faxFournisseur = $faxFournisseur;

        return $this;
    }

    /**
     * Get faxFournisseur
     *
     * @return Service 
     */
    public function getFaxFournisseur()
    {
        return $this->faxFournisseur;
    }
	 
	 
	 /**
     * Set contactFournisseur
     *
     * @param string $contactFournisseur
     * @return Commande
     */
    public function setContactFournisseur($contactFournisseur)
    {
        $this->contactFournisseur = $contactFournisseur;

        return $this;
    }

    /**
     * Get contactFournisseur
     *
     * @return Service 
     */
    public function getContactFournisseur()
    {
        return $this->contactFournisseur;
    }
	 
	 
	
	/**
     * Set emailContactFournisseur
     *
     * @param string $emailContactFournisseur
     * @return Commande
     */
    public function setEmailContactFournisseur($emailContactFournisseur)
    {
        $this->emailContactFournisseur = $emailContactFournisseur;

        return $this;
    }

    /**
     * Get emailContactFournisseur
     *
     * @return Service 
     */
    public function getEmailContactFournisseur()
    {
        return $this->emailContactFournisseur;
    }
	 

	
	/**
     * Set faxLivraison
     *
     * @param string $faxLivraison
     * @return Commande
     */
    public function setFaxLivraison($faxLivraison)
    {
        $this->faxLivraison = $faxLivraison;

        return $this;
    }

    /**
     * Get faxLivraison
     *
     * @return Service 
     */
    public function getFaxLivraison()
    {
        return $this->faxLivraison;
    }



	/**
     * Set montantPaye
     *
     * @param string $montantPaye
     * @return Commande
     */
    public function setMontantPaye($montantPaye)
    {
        $this->montantPaye = $montantPaye;

        return $this;
    }

    /**
     * Get montantPaye
     *
     * @return string 
     */
    public function getMontantPaye()
    {
        return "".$this->montantPaye;
    }
    
    
    


}
