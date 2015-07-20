<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ListeTempsPasses
 *
 * @ORM\Entity
 */
class ListeTempsPasses
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
    private $listeTempsPasses;




    public function __construct()
    {
        $this->listeTempsPasses = new ArrayCollection();
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
     * @param TempsPasse $tp
     * @return $this
     */
    public function addTempsPasse($tp)
    {
        $this->listeTempsPasses[] = $tp;

        return $this;
    }

    /**
     * @param TempsPasse $tp
     * @return $this
     */
    public function removeMasseSalariale($tp)
    {
        $this->listeTempsPasses->remove($tp);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeTempsPasses()
    {
        return $this->listeTempsPasses;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeTempsPasses($a)
    {
        $this->listeTempsPasses = $a;

        return $this;
    }

    
}

    