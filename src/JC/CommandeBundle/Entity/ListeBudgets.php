<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListeBudgets
 *
 * @ORM\Entity
 */
class ListeBudgets
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
    private $listeBudgets;




    public function __construct()
    {
        $this->listeBudgets = new ArrayCollection();
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
     * @param Budget $b
     * @return $this
     */
    public function addBudget($b)
    {
        $this->listeBudgets[] = $b;

        return $this;
    }

    /**
     * @param Budget $info
     * @return $this
     */
    public function removeBudget($b)
    {
        $this->listeBudgets->remove($b);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeBudgets()
    {
        return $this->listeBudgets;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeBudgets($a)
    {
        $this->listeBudgets = $a;

        return $this;
    }



}
