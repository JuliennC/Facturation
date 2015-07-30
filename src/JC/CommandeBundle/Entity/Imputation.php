<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Imputation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\ImputationRepository")
 */
class Imputation
{
	
	public function __tostring(){
		return $this->sousFonction.' - '.$this->article;
	}
	
	
	
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
     * @ORM\Column(name="Libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="Sous_fonction", type="string", length=255)
     */
    private $sousFonction;

    /**
     * @var string
     *
     * @ORM\Column(name="Article", type="string", length=255)
     */
    private $article;


	
	/**
     * @var string
	 *
     * @ORM\Column(name="Section", type="string", length=255)
	 *
   	*/
   private $section;
   
   
   
    /**
     * @var boolean
     *
     * @ORM\Column(name="Est_Facture", type="boolean")
     */
    private $estFacture;
   


	// Ne sert que pour le formulaire admin
	private $listeImputationConcerneBudget;



	
     public function __construct()
    {
        $this->listeImputationConcerneBudget = new ArrayCollection();
    }




	/**
     * @return ArrayCollection
     */
    public function getlisteImputationConcerneBudget()
    {
        return $this->listeImputationConcerneBudget;
    }




	/**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setlisteImputationConcerneBudget($a)
    {
        $this->listeImputationConcerneBudget = $a;

        return $this;
    }



	/**
     * @param ArrayCollection $a
     * @return $this
     */
    public function addImputationConcerneBudget($icb)
    {
        $this->listeImputationConcerneBudget[] = $icb;

        return $this;
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
     * Set libelle
     *
     * @param string $libelle
     * @return Imputation
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
     * Set sousFonction
     *
     * @param string $sousFonction
     * @return Imputation
     */
    public function setSousFonction($sousFonction)
    {
        $this->sousFonction = $sousFonction;

        return $this;
    }

    /**
     * Get sousFonction
     *
     * @return string 
     */
    public function getSousFonction()
    {
        return $this->sousFonction;
    }

    /**
     * Set article
     *
     * @param string $article
     * @return Imputation
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }


	/**
     * Set section
     *
     * @param string $section
     * @return Imputation
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string 
     */
    public function getSection()
    {
        return $this->section;
    }



	/**
     * Set estFacture
     *
     * @param boolean $estFacture
     * @return Imputation
     */
    public function setEstFacture($estFacture)
    {
        $this->estFacture = $estFacture;

        return $this;
    }

    /**
     * Get estFacture
     *
     * @return boolean 
     */
    public function getEstFacture()
    {
        return $this->estFacture;
    }




}


