<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceRepository extends EntityRepository
{
	
	public function getServiceOrdreAlpha() {
    return $this
      ->createQueryBuilder('s')
      ->orderBy('s.nom', 'ASC')

    ;
  }
}
