<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImputationConcerneBudget
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ImputationConcerneBudget
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
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Imputation", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $imputation;



   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Budget", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $budget;

    
    


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
     * Set imputation
     *
     * @param Imputation $imputation
     * @return Imputation
     */
    public function setImputation($imputation)
    {
        $this->imputation = $imputation;

        return $this;
    }

    
     /**
     * Get imputation
     *
     * @return Imputation 
     */
    public function getImputation()
    {
        return $this->imputation;
    }



	/**
     * Set budget
     *
     * @param Budget $budget
     * @return budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    
     /**
     * Get budget
     *
     * @return Budget 
     */
    public function getBudget()
    {
        return $this->budget;
    }



}
