<?php
/**
 * File :	MdyExistor.php
 * Bundle : MdyCoreBundle
 * Path :	src/Mdy/CoreBundle/Existor
 * Since :	03/12/2015
 * Update :	03/12/2015
 * Author :	R. Threis
 */
namespace Mdy\CoreBundle\Existor;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

class MdyExistor{
	protected $em;
	
	public function __construct(EntityManager $doctrine){
		$this->em = $doctrine;
	}
	
	public function exist($value){
		
		$varType = get_class($value);
		
	}
}