<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandePasseEtat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\CommandePasseEtatRepository")
 */
class CommandePasseEtat
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
     * @var \DateTime
     *
     * @ORM\Column(name="datePassage", type="datetime")
     */
    private $datePassage;




// DEBUT CLES ETRANGERES


   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Commande", inversedBy="etats", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $commande;


   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\EtatCommande", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $etat;







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
     * Set datePassage
     *
     * @param \DateTime $datePassage
     * @return CommandePasseEtat
     */
    public function setDatePassage($datePassage)
    {
        $this->datePassage = $datePassage;

        return $this;
    }

    /**
     * Get datePassage
     *
     * @return \DateTime 
     */
    public function getDatePassage()
    {
        return $this->datePassage;
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
     * Set etat
     *
     * @param EtatCommande 
     * @return CommandeConcerneCollectivite
     */
    public function setEtat(EtatCommande $etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return EtatCommande 
     */
    public function getEtat()
    {
        return $this->etat;
    }



}
