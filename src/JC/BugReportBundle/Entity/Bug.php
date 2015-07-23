<?php

namespace JC\BugReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use JC\BugReportBundle\Entity\Image;

/**
 * Bug
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Bug
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
     * @ORM\Column(name="Type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Utilisateur", type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer un nom d'utilisateur.")
     */
    private $utilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="Circonstances", type="string", length=2555)
     * @Assert\NotBlank(message="Veuillez decrire les Circonstances du bug.")
     */
    private $Circonstances;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=2555)
     */
    private $commentaire;


	/**
     * @var string
     *
     * @ORM\Column(name="Statut", type="string", length=255, nullable=true)
     */
    private $statut;

	
	/**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=255, nullable=true)
     */
    private $libelle;
    
    
	/**
   * @ORM\OneToOne(targetEntity="JC\BugReportBundle\Entity\Image", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
    private $image;
    
    
	/**
     * Set image
     *
     * @param Image $image
     * @return Bug
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
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
     * Set type
     *
     * @param string $type
     * @return Bug
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set utilisateur
     *
     * @param string $utilisateur
     * @return Bug
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return string 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set Circonstances
     *
     * @param string $Circonstances
     * @return Bug
     */
    public function setCirconstances($Circonstances)
    {
        $this->Circonstances = $Circonstances;

        return $this;
    }

    /**
     * Get Circonstances
     *
     * @return string 
     */
    public function getCirconstances()
    {
        return $this->Circonstances;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Bug
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
	
	
	/**
     * Set statut
     *
     * @param string $statut
     * @return Bug
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }



	/**
     * Set libelle
     *
     * @param string $libelle
     * @return Bug
     */
    public function setLibelle($statut)
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


}

