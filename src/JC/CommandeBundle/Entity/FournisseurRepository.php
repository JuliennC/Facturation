<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FournisseurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FournisseurRepository extends EntityRepository
{
	
	public function findFournisseursOrdreAlpha() {
            return $this
              ->createQueryBuilder('f')
              ->orderBy('f.nom', 'ASC')
              ->orderBy('f.adresse', 'ASC')
              ->getQuery()	
              ->getResult()
        ;
    
    }

}
