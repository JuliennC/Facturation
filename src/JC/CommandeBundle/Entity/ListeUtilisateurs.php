<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListeUtilisateurs
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ListeUtilisateurs
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
    private $listeUtilisateurs;

    
    
    
     public function __construct()
    {
        $this->listeUtilisateurs = new ArrayCollection();
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
     * @param Utilisateur $u
     * @return $this
     */
    public function addUtilisateur($u)
    {
        $this->listeUtilisateurs[] = $u;

        return $this;
    }

    /**
     * @param Utilisateur $info
     * @return $this
     */
    public function removeUtilisateur($u)
    {
        $this->listeUtilisateurs->remove($u);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListeUtilisateurs()
    {
        return $this->listeUtilisateurs;
    }

    /**
     * @param ArrayCollection $a
     * @return $this
     */
    public function setListeUtilisateurs($a)
    {
        $this->listeUtilisateurs = $a;

        return $this;
    }


}
