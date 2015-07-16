<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imputation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\ImputationRepository")
 */
class Imputation
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
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\SectionImputation", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $section;
   

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
     * @param SectionImputation $section
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


}


