<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BudgetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BudgetRepository extends EntityRepository
{
	public function findBudgetAvecAnneeEtService($annee, $service){
		
		return $this
		->createQueryBuilder('b')
		->where('b.annee = :annee')
		->setParameter('annee', $annee)
		->Andwhere('b.service = :service')
		->setParameter('service', $service)
		->getQuery()	
		->getResult()

		;

	}
	
	
	
	public function getQueryByAnnee($annee){
		
		return $this
		->createQueryBuilder('b')
		->where('b.annee = :annee')
		->setParameter('annee', $annee)
		->orderBy('b.libelle', 'ASC');

	}
}
