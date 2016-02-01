<?php
/**
 * File :	XlaExistor.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Existor
 * Since :	04/12/2015
 * Update :	04/12/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Existor;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Mdy\XlagendaBundle\Entity\Lieu;
use Mdy\XlagendaBundle\Entity\Contact;

class XlaExistor{
	protected $em;
	
	public function __construct(EntityManager $doctrine){
		$this->em = $doctrine;
	}
	
	public function lieuExist(Lieu $lieu){
		$result = $em->getRepository('MdyXlagendaBundle:LieuRepository')->exist($lieu);
	}
	
	public function contactExist(Contact $contact){
		
	}
}