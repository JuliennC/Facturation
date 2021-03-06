<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ImputationConcerneBudgetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImputationConcerneBudgetRepository extends EntityRepository
{
	
	public function findAvecAnnee($annee){
		
		return $this
			->createQueryBuilder('icb')
			
			->leftJoin('icb.budget','b')
			->addSelect('b')

			->leftJoin('icb.imputation','i')
			->addSelect('i')


			->where('b.annee = :annee ')
			
			->setParameter('annee',$annee)
	
			->getQuery()	
			->getResult();
	}


}
