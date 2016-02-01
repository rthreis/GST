<?php
/**
 * File :	Lieu.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlangendaBundle/Entity
 * Since :	06/08/2015
 * Update :	11/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Lieu
 *
 * @ORM\Table(name="xla_lieu")
 * @ORM\Entity(repositoryClass="Mdy\XlagendaBundle\Entity\LieuRepository")
 */
class Lieu
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
	 * @var string
	 *
	 * @ORM\Column(name="rue", type="string", length=255, nullable=true)
	 */
	private $rue;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="numero", type="string", length=5, nullable=true)
	 */
	private $numero;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="localite", type="string", length=255)
	 */
	private $localite;
		
	/**
	 * @ORM\OneToMany(targetEntity="Mdy\XlagendaBundle\Entity\Event", mappedBy="lieu")
	 */
	private $events;

	
	public function __construct(){
		$this->events = new \Doctrine\Common\Collections\ArrayCollection();
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
	public function getId() {
		return $this->id;
	}

	/**
	 * Set rue
	 *
	 * @param string $rue
	 * @return Lieu
	 */
	public function setRue($rue) {
		$this->rue = $rue;
		return $this;
	}

	/**
	 * Get rue
	 *
	 * @return string 
	 */
	public function getRue() {
		return $this->rue;
	}

	/**
	 * Set numero
	 *
	 * @param string $numero
	 * @return Lieu
	 */
	public function setNumero($numero) {
		$this->numero = $numero;
		return $this;
	}

	/**
	 * Get numero
	 *
	 * @return string 
	 */
	public function getNumero() {
		return $this->numero;
	}

	/**
	 * Set localite
	 *
	 * @param string $localite
	 * @return Lieu
	 */
	public function setLocalite($localite) {
		$this->localite = $localite;
		return $this;
	}

	/**
	 * Get localite
	 *
	 * @return string 
	 */
	public function getLocalite() {
		return $this->localite;
	}
	
	/**
	 * add Event
	 * @param Mdy\XlagendaBundle\Entity\Event
	 * @return Lieu
	 */
	public function addEvent(\Mdy\XlagendaBundle\Entity\Event $event){
		$this->events[] = $event;
		return $this;
	}
	
	/**
	 * Remove Event
	 * @param Mdy\XlagendaBundle\Entity\Event
	 * @return Lieu
	 */
	public function removeEvent(\Mdy\XlagendaBundle\Entity\Event $event){
		$this->events->removeElement($event);
		return $this;
	}
	
	/**
	 * Get Event
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getEvents(){
		return $this->events;
	}
}
