<?php
/**
 * File :	LieuTranslation.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Entity
 * Since :	06/08/2015
 * Update :	13/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Lieu
 *
 * @ORM\Table(name="xla_lieuTranslation")
 * @ORM\Entity
 */
class LieuTranslation
{
	use ORMBehaviors\Translatable\Translation;
	
	/**
	*@ORM\Column(type="string", length=75)
	*/
	protected $nom;
	
	public function __toString(){
		return $this->getNom();
	}
	
	public function getNom(){
		return $this->nom;
	}
	public function setNom($nom){
		$this->nom = $nom;
	}
}
