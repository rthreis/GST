<?php
/**
 * File :	MdyExist.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Exist
 * Since :	15/10/2015
 * Update :	15/10/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Exist;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Mdy\GstBundle\Entity\Lieu;
use Mdy\GstBundle\Entity\Equipe;

class MdyExist{
	protected $em;
	
	public function __construct(EntityManager $doctrine){
		$this->em = $doctrine;
	}
	
	/**
	 * 
	 * @param : Lieu dont il faut vérifier l'existence
	 * @return : true => le lieu existe déjà
	 * 			 false => le lieu n'existe pas
	 */
	public function lieuExist(Lieu $lieu){
		$result = $this->em->getRepository('MdyGstBundle:Lieu')->findByLieu($lieu);
		if( !$result ){
			return false;
		}else{
			return true;
		}
	}
	
	public function equipeExist(Equipe $equipe){
		
	}
}