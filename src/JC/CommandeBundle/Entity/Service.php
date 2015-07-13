<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\ServiceRepository")
 */
class Service
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Est_Ancien_Service", type="boolean")
     */
    private $estAncienService;


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
     * Set nom
     *
     * @param string $nom
     * @return Service
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set estAncienService
     *
     * @param boolean $estAncienService
     * @return Service
     */
    public function setEstAncienService($estAncienService)
    {
        $this->estAncienService = $estAncienService;

        return $this;
    }

    /**
     * Get estAncienService
     *
     * @return boolean 
     */
    public function getEstAncienService()
    {
        return $this->estAncienService;
    }
}
