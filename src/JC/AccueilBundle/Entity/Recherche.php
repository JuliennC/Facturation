<?php

namespace JC\AccueilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recherche
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Recherche
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
     * @ORM\Column(name="objetRecherche", type="string", length=255)
     */
    private $objetRecherche;

    /**
     * @var string
     *
     * @ORM\Column(name="roleRecherche", type="string", length=255)
     */
    private $roleRecherche;


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
     * Set objetRecherche
     *
     * @param string $objetRecherche
     * @return Recherche
     */
    public function setObjetRecherche($objetRecherche)
    {
        $this->objetRecherche = $objetRecherche;

        return $this;
    }

    /**
     * Get objetRecherche
     *
     * @return string 
     */
    public function getObjetRecherche()
    {
        return $this->objetRecherche;
    }

    /**
     * Set roleRecherche
     *
     * @param string $roleRecherche
     * @return Recherche
     */
    public function setRoleRecherche($roleRecherche)
    {
        $this->roleRecherche = $roleRecherche;

        return $this;
    }

    /**
     * Get roleRecherche
     *
     * @return string 
     */
    public function getRoleRecherche()
    {
        return $this->roleRecherche;
    }
}
