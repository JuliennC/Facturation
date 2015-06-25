<?php

namespace JC\CommandeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JC\CommandeBundle\Entity\Commande;

class LoadCategory implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    
    
    // Création d'une commande
	$commande = new Commande();
	$commande ->setVentilation("Mutualisé");
	$commande ->setUtilisateur($utilisateur);

	// Création d'une commande
	$commande = new Commande();
	$commande ->setVentilation("Mutualisé");
	$commande ->setUtilisateur($utilisateur);


    // On la persiste
    $manager->persist($category);
    

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}