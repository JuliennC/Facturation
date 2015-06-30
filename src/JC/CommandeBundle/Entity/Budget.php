<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Budget
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\BudgetRepository")
 */
class Budget
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
     * @ORM\Column(name="Montant", type="integer")
     */
    private $montant;

	/**
     * @var integer
     *
     * @ORM\Column(name="Annee", type="integer")
     */
    private $annee;


// DEBUT CLES ETRANGERES




	/**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Service", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $service;




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
     * Set montant
     *
     * @param integer $montant
     * @return Budget
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer 
     */
    public function getMontant()
    {
        return $this->montant;
    }




	/**
     * Set annee
     *
     * @param integer $annee
     * @return Budget
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
     * Set service
     *
     * @param Service $service
     * @return Budget
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return Service 
     */
    public function getService()
    {
        return $this->service;
    }




}
