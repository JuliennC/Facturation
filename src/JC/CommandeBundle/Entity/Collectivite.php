<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Collectivite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\CommandeBundle\Entity\CollectiviteRepository")
 */
class Collectivite
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
     * @Assert\Length(min=2,  minMessage="Veuillez vérifier le nom des collectivites.")
     */
    private $nom;



	/**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Debut_Mutualisation", type="date", nullable=true)
	 * @Assert\DateTime(message="test")
     */
    private $dateDebutMutualisation;


	/**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Fin_Mutualisation", type="date", nullable=true)
	 * @Assert\DateTime()
     */
    private $dateFinMutualisation;


// DEBUT CLES ETRANGERES





// FIN DES COLONNES - DEBUT PROPRIETE AUTRE




// FONCTIONS 


	
	







public function getTotalCommandesDirectes(){

	$total = 0;
	
	foreach($this->listeCommande as $c){
		
		//on ne récupère que les commandes directes
		if ($c instanceof CommandeConcerneCollectivite) { 
			
			$total += $c->getCommande()->getTotalTTC() *  $c->getPourcentage();
		} else {
			echo "poin";
		}
	}

	return $total;
}


public function getTotalCommandesMutualisees(){
	
	$total = 0;
	
	foreach($this->listeCommande as $c){
		
		if ($c instanceof Commande) { 
			$total += $c->getTotalTTC(); 
		}
	}

	return $total;
}







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
     * @return Collectivite
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
     * Set dateDebutMutualisation
     *
     * @param string $dateDebutMutualisation
     * @return Collectivite
     */
    public function setdateDebutMutualisation($dateDebutMutualisation)
    {
        $this->dateDebutMutualisation = $dateDebutMutualisation;

        return $this;
    }

    /**
     * Get dateDebutMutualisation
     *
     * @return string 
     */
    public function getdateDebutMutualisation()
    {
        return $this->dateDebutMutualisation;
    }
    
    
    
    /**
     * Set dateFinMutualisation
     *
     * @param string $dateFinMutualisation
     * @return Collectivite
     */
    public function setdateFinMutualisation($dateFinMutualisation)
    {
        $this->dateFinMutualisation = $dateFinMutualisation;

        return $this;
    }

    /**
     * Get dateFinMutualisation
     *
     * @return string 
     */
    public function getdateFinMutualisation()
    {
        return $this->dateFinMutualisation;
    }
    
    
}
