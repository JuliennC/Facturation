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
     * @ORM\Column(name="Date_Envoi", type="datetime", nullable=true)
	 * @Assert\DateTime()
     */
    private $dateEnvoi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Creation", type="datetime", nullable=false)
	 * @Assert\DateTime()
     */
    private $dateCreation;

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
     * @ORM\Column(name="Bon_Coriolis", type="string", length=255, nullable=true)
     */
    private $bonCoriolis;


	/**
     * @var string
     *
     * @ORM\Column(name="Engagement", type="string", length=255, nullable=true)
     */
    private $engagement;



	/**
     * @var string
     *
     * @ORM\Column(name="Imputation", type="string", length=255, nullable=true)
     */
    private $imputation;


	/**
     * @var string
     *
     * @ORM\Column(name="Libelle_Facturation", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
     */
    private $libelleFacturation;


	/**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

	/**
     * @var string
     *
     * @ORM\Column(name="Total_TTC", type="decimal", scale=2, nullable=false)
     */
    private $totalTTC;
    

// DEBUT CLES ETRANGERES


	/**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Utilisateur", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $utilisateur;


   /*
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Application", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $application;
   
   
   
   
/* --------------- Informations concernant le fournisseur --------------- */
/* --------------- (Photo � l'instant T des information du fournisseur) --------------- */

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
     * @Assert\NotBlank(message="Veuillez entrer un numéro de téléphone de fournisseur valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un numéro de téléphone de fournisseur valide.")  
     */
    private $telephoneFournisseur;

   
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
/* --------------- (Photo � l'instant T des information du lieu de livraison) --------------- */

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
     * @Assert\NotBlank(message="Veuillez entrer un numéro de téléphone de livraison valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un numéro de téléphone de livraison valide.")  
     */
    private $telephoneLivraison;

   
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


   
  


// FIN DES COLONNES - DEBUT PROPRIETE AUTRE

	





// FONCTIONS 

public function __construct() {

	    // La date de création est la date d'aujourd'hui
		$this->dateCreation = new \Datetime();
		
		$this->etat = "Creee";
		
		$this->totalTTC = "0";

        $this->listelignesCommande = new ArrayCollection();
        
        $this->ventilation = "Directe";

	}






// GETTER ET SETTER


	

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
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     * @return Commande
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime 
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

   
    
    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
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
	   return $this->totalTTC;
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
     * Set utilisateur
     *
     * @param string $utilisateur
     * @return Commande
     */
    public function setUtilisateur(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
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
     * Set bonCoriolis
     *
     * @param string $bonCoriolis
     * @return Commande
     */
    public function setBonCoriolis($bonCoriolis)
    {
        $this->bonCoriolis = $bonCoriolis;

        return $this;
    }

    /**
     * Get bonCoriolis
     *
     * @return Commande 
     */
    public function getBonCoriolis()
    {
        return $this->bonCoriolis;
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
     * Set imputation
     *
     * @param string $imputation
     * @return Commande
     */
    public function setImputation($imputation)
    {
        $this->imputation = $imputation;

        return $this;
    }

    /**
     * Get imputation
     *
     * @return Commande 
     */
    public function getImputation()
    {
        return $this->imputation;
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
     * Set etat
     *
     * @param string
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
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


}
