<?php

namespace JC\CommandeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ImputationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImputationRepository extends EntityRepository
{
	
	public function queryFindAll() {
    return $this
      ->createQueryBuilder('i')
    ;
    
    }}