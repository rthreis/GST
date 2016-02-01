<?php
// src/OC/PlatformBundle/Purger/OCAdvertPurger.php
namespace OC\PlatformBundle\Purger;

use Doctrine\Bundle\DoctrineBundle\Registry;

class OCAdvertPurger{
	
	protected $doctrine;
	protected $days;
	
	/**
	* @var Symfony\Bundle\DoctrineBundle\Registry $doctrine
	* @var int $days
	*/
	public function __construct(Registry $doctrine, $days){
		$this->doctrine = $doctrine;
		$this->days = $days;
	}
	/**
	* Purge les annonces échuent ne disposant pas de candidatures
	*
	* @param int $days
	* @return integer
	*/
	public function purge($days){
		$repository = $this->doctrine->getEntityManager()->getRepository('OCPlatformBundle:Advert');
		$em = $this->doctrine->getEntityManager();
		
		$listAdverts = $repository->findToPurge($days);
		/*
		foreach($listAdverts as $i => $advert){
			$em->remove($advert);
		}
		$em->flush();*/
		return count($listAdverts);
	}
}