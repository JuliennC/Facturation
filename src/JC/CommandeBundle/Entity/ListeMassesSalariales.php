<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * ListeMassesSalariales
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ListeMassesSalariales
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
    private $listeMassesSalariales;




    public function __construct()
    {
        $this->listeMassesSalariales = new ArrayCollection();
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
     * @param MasseSalariale $ms
     * @return $this
     */
    public function addMasseSalariale($ms)
    {
        $this->listeMassesSalariales[] = $ms;

        return $this;
    }

    /**
     * @param MasseSalariale $ms
     * @return $this
     */
    public function removeMasseSalariale($ms)
    {
        $this->listeMassesSalariales->remove($ms);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeMassesSalariales()
    {
        return $this->listeMassesSalariales;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeMassesSalariales($a)
    {
        $this->listeMassesSalariales = $a;

        return $this;
    }

    
}
