<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListeActivites
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ListeActivites
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
    private $listeActivites;

    
    
    
     public function __construct()
    {
        $this->listeActivites = new ArrayCollection();
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
     * @param Activite $a
     * @return $this
     */
    public function addActivites($a)
    {
        $this->listeActivites[] = $s;

        return $this;
    }

    /**
     * @param Activite $a
     * @return $this
     */
    public function removeActivite($a)
    {
        $this->listeActivites->remove($a);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeActivites()
    {
        return $this->listeActivites;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeActivites($a)
    {
        $this->listeActivites = $a;

        return $this;
    }

    

    
    
}
