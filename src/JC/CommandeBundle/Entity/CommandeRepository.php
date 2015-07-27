<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandeRepository extends EntityRepository
{
	

	public function findCommandePourCollectiviteAvecStatutPourAnnee($collectivite, $statut, $annee){
		
		return $this
			->getEntityManager()
		    ->getRepository('JCCommandeBundle:CommandeConcerneCollectivite')
			
			->createQueryBuilder('ccc')
			
			->leftJoin('ccc.commande','com')
			->addSelect('com')
			
			->leftJoin('com.etats', 'passeEtat')
			->addSelect('passeEtat')
			
			->leftJoin('passeEtat.etat', 'et')
			->addSelect('et')
			
			->leftJoin('com.application', 'app')
			->addSelect('app')
			
			->leftJoin('com.activite', 'act')
			->addSelect('act')
			
			->leftJoin('act.cleRepartition', 'cle')
			->addSelect('cle')
			
			->where('ccc.collectivite = :collectivite AND et.libelle = :statut AND year(passeEtat.datePassage) = :annee')
			->setParameter('collectivite',$collectivite)
			->setParameter('statut',$statut)
			->setParameter('annee',$annee)
	
			->getQuery()	
			->getResult();

	}





	public function findCommandeAvecActiviteEtCollectivite($activite, $collectivite){
		
		return $this
			->getEntityManager()
		    ->getRepository('JCCommandeBundle:CommandeConcerneCollectivite')
			
			->createQueryBuilder('ccc')
			
			->leftJoin('ccc.commande','com')
			->addSelect('com')
			
			
			
			->where('ccc.collectivite = :collectivite AND com.activite = :activite')
			->setParameter('collectivite',$collectivite)
			->setParameter('activite',$activite)

	
			->getQuery()	
			->getResult();

	}



	
}
