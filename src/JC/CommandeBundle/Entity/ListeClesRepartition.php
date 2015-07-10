<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListeClesRepartition
 *
 * @ORM\Entity
 */
class ListeClesRepartition
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\Valid()   
     */
    private $listeClesRepartition;

    
    
    
     public function __construct()
    {
        $this->listeCles = new ArrayCollection();
    }

    


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
     * @param CleRepartition $c
     * @return $this
     */
    public function addCleRepartition($c)
    {
        $this->listeCles[] = $c;

        return $this;
    }

    /**
     * @param CleRepartition $c
     * @return $this
     */
    public function removeCleRepartition($c)
    {
        $this->listeCles->remove($c);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeClesRepartition()
    {
        return $this->listeCles;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeClesRepartition($a)
    {
        $this->listeCles = $a;

        return $this;
    }



}
