<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\ApplicationRepository")
 */
class Application
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="UnixOracle", type="boolean", nullable=true)
     
     */
    private $unixOracle;



// DEBUT CLES ETRANGERES


	
   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Activite", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $activite;


   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\CleRepartition", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $cleRepartition;
   
   
   
   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Fournisseur", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $fournisseur;





// FIN DES COLONNES - DEBUT PROPRIETE AUTRE



// FONCTIONS 

	public function getDisplay() {
		return ($this->nom." - ".$this->activite->getNom());
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
     * Set nom
     *
     * @param string $nom
     * @return Application
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set unixOracle
     *
     * @param boolean $unixOracle
     * @return Application
     */
    public function setUnixOracle($unixOracle)
    {
        $this->unixOracle = $unixOracle;

        return $this;
    }

    /**
     * Get unixOracle
     *
     * @return boolean 
     */
    public function getUnixOracle()
    {
        return $this->unixOracle;
    }


	


	/**
     * Set Activite
     *
     * @param Activite
     * @return Application
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
     * Set cleRepartition
     *
     * @param CleRepartition
     * @return Application
     */
    public function setCleRepartition(CleRepartition $cleRepartition)
    {
        $this->cleRepartition = $cleRepartition;

        return $this;
    }

    /**
     * Get cleRepartition
     *
     * @return CleRepartition 
     */
    public function getCleRepartition()
    {
        return $this->cleRepartition;
    }




	/**
     * Set fournisseur
     *
     * @param Fournisseur
     * @return Application
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





}
