<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ListeImputations
 *
 * @ORM\Entity
 */
class ListeImputations
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
    private $listeImputations;

    
    
    
     public function __construct()
    {
        $this->listeImputations = new ArrayCollection();
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
     * @param Imputation $i
     * @return $this
     */
    public function addImputation($i)
    {
        $this->listeImputations[] = $c;

        return $this;
    }

    /**
     * @param Imputation $info
     * @return $this
     */
    public function removeImputation($c)
    {
        $this->listeImputations->remove($c);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeImputations()
    {
        return $this->listeImputations;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeImputations($a)
    {
        $this->listeImputations = $a;

        return $this;
    }


    
    
}
