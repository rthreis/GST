<?php

namespace Mdy\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository{
	
	public function findByRole($role){
		$qb = $this->createQueryBuilder('u');
		$role = '%'.$role.'%';
		$qb->andWhere($qb->expr()->like('u.roles', '?1'))
			->setParameter('1', $role);
		
		return $qb->getQuery()->getResult();
	}
}
