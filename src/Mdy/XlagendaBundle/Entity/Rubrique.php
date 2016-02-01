<?php
/**
 * File :	Rubrique.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Entity
 * Since :	06/08/2015
 * Update :	11/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Rubrique
 *
 * @ORM\Table(name="xla_rubrique")
 * @ORM\Entity(repositoryClass="Mdy\XlagendaBundle\Entity\RubriqueRepository")
 */
class Rubrique
{
	use ORMBehaviors\Translatable\Translatable;
	use ORMBehaviors\SoftDeletable\SoftDeletable;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	
	/**
	*@ORM\ManyToMany(targetEntity="Mdy\XlagendaBundle\Entity\Event", mappedBy="rubriques")
	*/
	private $events;

	public function __construct(){
		$this->events = new \Doctrine\Common\Collections\ArrayCollection;
	}
	
	public function __call($method, $arguments)
	{
		return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
	}
	
	public function __toString(){
		return $this->getNom();
	}
	
	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set Events
	 * @param \Mdy\XlagendaBundle\Entity\Event
	 * @return rubrique
	 */
	public function addEvent(\Mdy\XlagendaBundle\Entity\Event $event){
		$this->events[] = $event;
		return $this;
	}
	
	/**
	 * Remove Event
	 * @param \Mdy\XlagendaBundle\Entity\Event
	 * @return rubrique
	 */
	public function removeEvent(\Mdy\XlagendaBundle\Entity\Event $event){
		$this->events->removeElement($event);
		return $this;
	}
	
	/**
	 * Get Events
	 * @return events
	 */
	public function getEvents(){
		return $this->events;
	}
}
