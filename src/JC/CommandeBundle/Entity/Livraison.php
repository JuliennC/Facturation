<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Livraison
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\LivraisonRepository")
 */
class Livraison
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
     * @ORM\Column(name="Nom", type="string", length=255, nullable=false)
	 * @Assert\NotBlank(message="Veuillez entrer un nom valide pour la livraison.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer un nom valide pour la livraison.")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=false)
	 * @Assert\NotBlank(message="Veuillez entrer une adresse de livraison valide.")
     * @Assert\Length(min=2 , minMessage="Veuillez saisir une adresse de livraison valide.")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="Complement_Adresse", type="string", length=255, nullable=true)
     */
    private $complementAdresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="Code_Postal", type="integer", nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un code postal de livraison valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un code postal de livraison valide.")  
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=255, nullable=false)
	 * @Assert\NotBlank(message="Veuillez entrer le nom d'une ville de livraison valide.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer un nom de ville de livraison valide.")
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un numéro de téléphone de livraison valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer un numéro de téléphone de livraison valide.")  
     */
    private $telephone;

	/**
     * @var integer
     *
     * @ORM\Column(name="Fax", type="string", length=255, nullable=true)
     */
    private $fax;






// DEBUT CLES ETRANGERES


// FIN DES COLONNES - DEBUT PROPRIETE AUTRE



// FONCTIONS 

	public function getDisplay() {
		return ($this->nom." - ".$this->complementAdresse);
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
     * @return Livraison
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
     * Set adresse
     *
     * @param string $adresse
     * @return Livraison
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set complementAdresse
     *
     * @param string $complementAdresse
     * @return Livraison
     */
    public function setComplementAdresse($complementAdresse)
    {
        $this->complementAdresse = $complementAdresse;

        return $this;
    }

    /**
     * Get complementAdresse
     *
     * @return string 
     */
    public function getComplementAdresse()
    {
        return $this->complementAdresse;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     * @return Livraison
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return integer 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Livraison
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Livraison
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
    
    
    
    /**
     * Set fax
     *
     * @param string $fax
     * @return Livraison
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }
}
