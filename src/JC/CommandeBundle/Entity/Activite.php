<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\ActiviteRepository")
 */
class Activite
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
     * @var integer
     *
     * @ORM\Column(name="Unite_Oeuvre", type="integer")
     */
    private $uniteOeuvre;





// DEBUT CLES ETRANGERES


// FIN DES COLONNES - DEBUT PROPRIETE AUTRE



// FONCTIONS 



// GETTER ET SETTER








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
     * @return Activite
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
     * Set uniteOeuvre
     *
     * @param integer $uniteOeuvre
     * @return Activite
     */
    public function setUniteOeuvre($uniteOeuvre)
    {
        $this->uniteOeuvre = $uniteOeuvre;

        return $this;
    }

    /**
     * Get uniteOeuvre
     *
     * @return integer 
     */
    public function getUniteOeuvre()
    {
        return $this->uniteOeuvre;
    }
}
