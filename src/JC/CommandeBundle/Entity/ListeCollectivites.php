<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListeCollectivites
 *
 * @ORM\Entity
 */
class ListeCollectivites
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
    private $listeCollectivites;

    
    
    
     public function __construct()
    {
        $this->listeCollectivites = new ArrayCollection();
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
     * @param Collectivite $c
     * @return $this
     */
    public function addCollectivite($c)
    {
        $this->listeCollectivites[] = $c;

        return $this;
    }

    /**
     * @param Collectivite $info
     * @return $this
     */
    public function removeCollectivite($c)
    {
        $this->listeCollectivites->remove($c);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeCollectivites()
    {
        return $this->listeCollectivites;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeCollectivites($a)
    {
        $this->listeCollectivites = $a;

        return $this;
    }


    
    
    
}
