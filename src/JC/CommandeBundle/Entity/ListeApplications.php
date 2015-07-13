<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ListeApplications
 *
 * @ORM\Entity
 */
class ListeApplications
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
    private $listeApplications;

    
    
    
     public function __construct()
    {
        $this->listeApplications = new ArrayCollection();
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
     * @param Application $a
     * @return $this
     */
    public function addApplication($a)
    {
        $this->listeApplications[] = $s;

        return $this;
    }

    /**
     * @param Application $a
     * @return $this
     */
    public function removeApplication($a)
    {
        $this->listeApplications->remove($a);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeApplications()
    {
        return $this->listeApplications;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeApplications($a)
    {
        $this->listeApplications = $a;

        return $this;
    }

    

    
    
}
