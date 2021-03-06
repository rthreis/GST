<?php
/**
 * File :	EventRepository.php
 * Bundle :	MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Entity
 * Since :	06/08/2015
 * Update :	16/09/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
	
	public function findFilter($filter){
		$qb = $this->createQueryBuilder('i');
		if( $filter['lieu'] > 0){
			$qb->leftJoin('i.lieu', 'l')
				->andWhere($qb->expr()->eq('l.id', '?1'))
				->setParameter('1', $filter['lieu'])
				;
		}
		if( $filter['rubrique'] > 0 ){
			$qb->leftJoin('i.rubriques', 'r')
				->andWhere($qb->expr()->eq('r.id', '?1'))
				->setParameter('1', $filter['rubrique'])
				;
		}
		if( $filter['dateDebut'] != ''){
			$qb->andWhere($qb->expr()->gte('i.debut', '?1'))
				->setParameter('1', $filter['dateDebut'])
				;
		}
		if( $filter['dateFin'] != ''){
			$qb->andWhere($qb->expr()->lte('i.debut', '?1'))
				->setParameter('1', $filter['dateDebut'])
				;
		}
		return $qb->getQuery()->getResult();
	}
	
	public function listEvents($filtre){
		$qb = $this->createQueryBuilder('e');
		$today = date('Y-m-d H:M:i');
		$qb->leftJoin('e.translations', 'et')
			->andWhere($qb->expr()->gte('e.debut', '?2'))
			->setParameter('2', $today)
			->orWhere($qb->expr()->gte('e.fin', '?3'))
			->setParameter('3', $today)
			;
		return $qb->getQuery()->getResult();
	}
	
	public function myFindAll(){
		$qb = $this->createQueryBuilder('e');
		$today = date('Y-m-d H:M:i');
		$qb->leftJoin('e.translations', 'et')
			->andWhere($qb->expr()->gte('e.debut', '?2'))
			->setParameter('2', $today)
			->orWhere($qb->expr()->gte('e.fin', '?3'))
			->setParameter('3', $today)
			->andWhere($qb->expr()->eq('e.publication', '?1'))
			->setParameter('1', '1')
			
			;
		return $qb->getQuery()->getResult();
	}
}
