<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LigneCommande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\LigneCommandeRepository")
 */
class LigneCommande
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
     * @ORM\Column(name="Libelle", type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer un libelle valide.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer un libelle valide.")
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="Reference", type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer une référence valide.")
     * @Assert\Length(min=2,  minMessage="Veuillez entrer une référence valide.")
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantite", type="integer")
     * @Assert\NotBlank(message="Veuillez entrer une quantite valide.")
     * @Assert\Regex("/^[0-9]+$/", message="Veuillez entrer une quantite valide.")  
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="Prix_Unitaire", type="decimal", scale=2)
   	 * @Assert\NotBlank(message="Veuillez entrer un prix unitaire valide.")
     * @Assert\Regex("/(?<=^| )\d+(\.\d+)?(?=$| )/", message="Veuillez entrer un prix unitaire valide.")  
     */
    private $prixUnitaire;

    /**
     * @var string
     *
     * @ORM\Column(name="Total_TTC", type="decimal", scale=2) 
     */
    private $totalTTC;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;






// DEBUT CLES ETRANGERES


	/**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\Commande", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $commande;


   /**
   * @ORM\ManyToOne(targetEntity="JC\CommandeBundle\Entity\TVA", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   private $tva;



// FIN DES COLONNES - DEBUT PROPRIETE AUTRE

	/**
     * @var array
     *
     */






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
     * Set libelle
     *
     * @param string $libelle
     * @return LigneCommande
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return LigneCommande
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return LigneCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixUnitaire
     *
     * @param string $prixUnitaire
     * @return LigneCommande
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return string 
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set totalTTC
     *
     * @param string $totalTTC
     * @return LigneCommande
     */
    public function setTotalTTC($totalTTC)
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * Get totalTTC
     *
     * @return string 
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return LigneCommande
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
    
    
    /**
     * Set commande
     *
     * @param Commande $commande
     * @return LigneCommande
     */
    public function setCommande(Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return Commande 
     */
    public function getCommande()
    {
        return $this->commande;
    }


    
     /**
     * Set tva
     *
     * @param TVA $tva
     * @return LigneCommande
     */
    public function setTVA(TVA $tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return TVA 
     */
    public function getTVA()
    {
        return $this->tva;
    }
}
