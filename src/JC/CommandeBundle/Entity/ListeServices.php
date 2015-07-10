<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListeServices
 *
 * @ORM\Entity
 */
class ListeServices
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
    private $listeServices;

    
    
    
     public function __construct()
    {
        $this->listeServices = new ArrayCollection();
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
     * @param Service $s
     * @return $this
     */
    public function addService($s)
    {
        $this->listeServices[] = $s;

        return $this;
    }

    /**
     * @param Service $info
     * @return $this
     */
    public function removeService($s)
    {
        $this->listeServices->remove($s);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeServices()
    {
        return $this->listeServices;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeServices($a)
    {
        $this->listeServices = $a;

        return $this;
    }
    
    
}
