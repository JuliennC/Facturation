<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TempsPasse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\TempsPasseRepository")
 */
class TempsPasse
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
     * @var integer
     *
     * @ORM\Column(name="Pourcentage", type="integer")
     */
    private $pourcentage;

    /**
     * @var integer
     *
     * @ORM\Column(name="Annee", type="integer")
     */
    private $annee;



	/**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Activite", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $activite;



   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Collectivite", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $collectivite;



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
     * Set pourcentage
     *
     * @param integer $pourcentage
     * @return TempsPasse
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    /**
     * Get pourcentage
     *
     * @return integer 
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return TempsPasse
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }



	/**
     * Set activite
     *
     * @param Activite $activite
     * @return TempsPasse
     */
    public function setActivite($activite)
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
     * Set collectivite
     *
     * @param Collectivite $collectivite
     * @return TempsPasse
     */
    public function setCollectivite($collectivite)
    {
        $this->collectivite = $collectivite;

        return $this;
    }

    /**
     * Get collectivite
     *
     * @return Collectivite 
     */
    public function getCollectivite()
    {
        return $this->collectivite;
    }




}

