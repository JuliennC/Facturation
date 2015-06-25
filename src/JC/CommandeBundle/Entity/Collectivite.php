<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $nom;





// DEBUT CLES ETRANGERES





// FIN DES COLONNES - DEBUT PROPRIETE AUTRE

	//La liste commande contient des commandes ET DES CommandesConcernesCollectivites
	private $listeCommande;


// FONCTIONS 

public function __construct() {

	    // La date de création est la date d'aujourd'hui
		$this->listeCommande = array();

	}
	
	

// ---------- Gestion des commandes ----------
	
public function addCommande($commande) {
	
	if($this->listeCommande == null) {
		$this->listeCommande = array();
	}
	
	array_push($this->listeCommande, $commande);
}





public function getListeCommandes(){


	return $this->listeCommande;
}





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
}
