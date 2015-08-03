<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forfait
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\ForfaitRepository")
 */
class Forfait
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
     * @ORM\Column(name="annee", type="string", length=255)
     */
    private $annee;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="string", length=255)
     */
    private $montant;
    
    
    
    
    /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Collectivite")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
   private $collectivite;
    
    
    
    /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Application")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
   private $application;
    

    


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
     * Set annee
     *
     * @param string $annee
     * @return Forfait
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set montant
     *
     * @param string $montant
     * @return Forfait
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string 
     */
    public function getMontant()
    {
        return $this->montant;
    }




	/**
     * Set collectivite
     *
     * @param Collectivite $collectivite
     * @return Forfait
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


	/**
     * Set application
     *
     * @param Application $application
     * @return Forfait
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


}
