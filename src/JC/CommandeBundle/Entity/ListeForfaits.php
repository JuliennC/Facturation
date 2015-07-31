<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * ListeForfaits
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ListeForfaits
{
	
	/**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\Valid()   
     */
    private $listeForfaits;

    
    
    
     public function __construct()
    {
        $this->listeForfaits = new ArrayCollection();
    }


	
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * @param Forfait $f
     * @return $this
     */
    public function addForfait($f)
    {
        $this->listeForfaits[] = $f;

        return $this;
    }

    /**
     * @param Forfait $info
     * @return $this
     */
    public function removeForfait($f)
    {
        $this->listeForfaits->remove($f);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeForfaits()
    {
        return $this->listeForfaits;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeForfaits($a)
    {
        $this->listeForfaits = $a;

        return $this;
    }

}
