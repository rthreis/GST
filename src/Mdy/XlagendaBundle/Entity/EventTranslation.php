<?php
/**
 * File :	EventTranslation.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Entity
 * Since :	06/08/2015
 * Update :	123/10/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="xla_eventTranslation")
 * @ORM\Entity
 */
class EventTranslation
{
	use ORMBehaviors\Translatable\Translation;
	
	/**
	*@ORM\Column(type="string", length=75)
	*@Assert\Length(min=3, max=75)
	*/
	protected $nom;
	
	/**
	*@ORM\Column(type="text")
	*@Assert\Length(min=3)
	*/
	protected $description;
	
	public function getNom(){
		return $this->nom;
	}
	public function setNom($nom){
		$this->nom = $nom;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($description){
		$this->description = $description;
	}
}