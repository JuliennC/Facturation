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
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=255, nullable=true)
     */
    private $libelle;




// DEBUT CLES ETRANGERES

   
   
   
   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Fournisseur", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $fournisseur;





// FIN DES COLONNES - DEBUT PROPRIETE AUTRE



// FONCTIONS 

	public function getDisplay() {
		return ($this->nom);
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
     * Set libelle
     *
     * @param string $nom
     * @return Application
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
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
