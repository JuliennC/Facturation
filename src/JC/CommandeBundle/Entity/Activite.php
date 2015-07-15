<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\ActiviteRepository")
 */
class Activite
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



// DEBUT CLES ETRANGERES

	/**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\CleRepartition", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $cleRepartition;
   

// FIN DES COLONNES - DEBUT PROPRIETE AUTRE



// FONCTIONS 



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
     * @return Activite
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



}
