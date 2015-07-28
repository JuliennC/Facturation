<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementCommande
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PaiementCommande
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
     * @ORM\Column(name="DatePaiement", type="datetime")
     */
    private $datePaiement;
        
    
    
     /**
     * @var string
     *
     * @ORM\Column(name="Montant", type="string", length=255, nullable=false)
     */
    private $montant;
    
    
    /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Commande", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false) 
   */
   private $commande;
    
    


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
     * Set datePaiement
     *
     * @param \DateTime $datePaiement
     * @return PaiementCommande
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    /**
     * Get datePaiement
     *
     * @return \DateTime 
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }



	 /**
     * Set commande
     *
     * @param Commande $commande
     * @return PaiementCommande
     */
    public function setCommande($commande)
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
     * Set montant
     *
     * @param string $montant
     * @return PaiementCommande
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


	


}
