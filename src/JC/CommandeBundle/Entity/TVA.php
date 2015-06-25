<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TVA
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\TVARepository")
 */
class TVA
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
     * @var string
     *
     * @ORM\Column(name="pourcentage", type="decimal", scale=2)
     */
    private $pourcentage;


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
     * Set pourcentage
     *
     * @param string $pourcentage
     * @return TVA
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    /**
     * Get pourcentage
     *
     * @return string 
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }
    
    
    public function getDisplay() {
	    return $this->pourcentage.' %';
    }
    
    
}
