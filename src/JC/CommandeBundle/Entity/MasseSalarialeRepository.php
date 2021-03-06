<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MasseSalarialeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MasseSalarialeRepository extends EntityRepository
{
	
	
	public function findMasseSalarialeAvecAnneeEtService($annee, $service){
		
		return $this
		->createQueryBuilder('ms')
		->where('ms.annee = :annee')
		->setParameter('annee', $annee)
		->Andwhere('ms.service = :service')
		->setParameter('service', $service)
		->getQuery()	
		->getResult()

		;

	}

	
	
	public function getQueryByAnnee($annee){
		
		return $this
		->createQueryBuilder('ms')
		->where('ms.annee = :annee')
		->setParameter('annee', $annee);

	}

	
}
