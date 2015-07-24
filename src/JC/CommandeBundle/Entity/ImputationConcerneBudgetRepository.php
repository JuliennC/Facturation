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
	
	public function findAvecImputationEtAnnee($imputation, $annee){
		
		return $this
			->createQueryBuilder('icb')
			
			->leftJoin('icb.budget','b')
			->addSelect('b')

			->where('b.annee = :annee AND icb.imputation = :imputation')
			
			->setParameter('annee',$annee)
			->setParameter('imputation',$imputation)
	
			->getQuery()	
			->getResult();
	}


}
