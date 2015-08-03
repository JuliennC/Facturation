<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ForfaitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ForfaitRepository extends EntityRepository
{
	
	
	public function	findForfaitsPourCollectivitePourAnnee($collectivite, $annee){
		
		return $this
			
			->createQueryBuilder('f')
			
			->leftJoin('f.application','a')
			->addSelect('a')
						
			->where('f.collectivite = :collectivite AND f.annee = :annee')
			->setParameter('collectivite',$collectivite)
			->setParameter('annee',$annee)
	
			->getQuery()	
			->getResult();
		
	}
	
	
	
	public function	findForfaitsPourCollectiviteEtApplicationPourAnnee($collectivite, $application, $annee){
		
		return $this
			
			->createQueryBuilder('f')
			
			->leftJoin('f.application','a')
			->addSelect('a')
						
			->where('f.collectivite = :collectivite AND f.application = :application AND f.annee = :annee')
			->setParameter('collectivite',$collectivite)
			->setParameter('application',$application)
			->setParameter('annee',$annee)
	
			->getQuery()	
			->getResult();
		
	}

	
}
