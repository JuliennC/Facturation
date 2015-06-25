<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandeConcerneCollectivite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\CommandeConcerneCollectiviteRepository")
 */
class CommandeConcerneCollectivite
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
     * @ORM\Column(name="Repartion", type="string")
     */
    private $repartition;





// DEBUT CLES ETRANGERES



   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Commande")
   * @ORM\JoinColumn(nullable=false)
   */
   private $commande;


   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Collectivite")
   * @ORM\JoinColumn(nullable=false)
   */
   private $collectivite;


   
  


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
     * Set repartition
     *
     * @param integer $repartition
     * @return CommandeConcerneCollectivite
     */
    public function setRepartition($repartition)
    {
        $this->repartition = $repartition;

        return $this;
    }

    /**
     * Get repartition
     *
     * @return string 
     */
    public function getRepartition()
    {
        return $this->repartition;
    }




	/**
     * Set commande
     *
     * @param Commande 
     * @return CommandeConcerneCollectivite
     */
    public function setCommande(Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return Commande 
     */
    public function getCommande()
    {
        return $this->commande;
    }





	/**
     * Set collectivite
     *
     * @param Collectivite 
     * @return CommandeConcerneCollectivite
     */
    public function setCollectivite(Collectivite $collectivite)
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
