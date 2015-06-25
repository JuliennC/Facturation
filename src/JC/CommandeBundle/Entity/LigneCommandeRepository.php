<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * LigneCommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LigneCommandeRepository extends EntityRepository
{
	
	public function findLignesCommandeAvecCommande($id) {
		
	    $qb = $this->createQueryBuilder('l');

		$qb ->where('l.commande = :id')
			->setParameter('id', $id)
		;

		return $qb ->getQuery()
					->getResult()
		;
		
	}



}
