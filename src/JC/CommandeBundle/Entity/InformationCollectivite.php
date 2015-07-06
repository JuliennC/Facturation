<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InformationCollectivite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\InformationCollectiviteRepository")
 */
class InformationCollectivite
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
     * @ORM\Column(name="Nombre", type="string", length=255)
	 * @Assert\NotBlank(message="Vérifier que toutes les cases soientt remplies.")
     * @Assert\Length(min=1,  minMessage="Vérifier que toutes les cases soientt remplies.")
     */
    private $nombre;



	/**
     * @var integer
     *
     * @ORM\Column(name="Annee", type="integer")
     */
    private $annee;



   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\CleRepartition", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $cleRepartition;


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
     * Set nombre
     *
     * @param string $nombre
     * @return InformationCollectivite
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }



	/**
     * Set annee
     *
     * @param Annee $annee
     * @return InformationCollectivite
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
     * Set cleRepartition
     *
     * @param CleRepartition $cleRepartition
     * @return InformationCollectivite
     */
    public function setCleRepartition($cleRepartition)
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
     * Set collectivite
     *
     * @param Collectivite $collectivite
     * @return InformationCollectivite
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
