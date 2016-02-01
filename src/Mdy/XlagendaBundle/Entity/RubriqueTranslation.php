<?php
/**
 * File :	RubriqueTranslation.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Entity
 * Since :	06/08/2015
 * Update :	11/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Rubrique
 *
 * @ORM\Table(name="xla_rubriqueTranslation")
 * @ORM\Entity
 */
class RubriqueTranslation
{
	use ORMBehaviors\Translatable\Translation;
	
	/**
	*@ORM\Column(type="string", length=50)
	*/
	protected $nom;
	
	/**
	*@ORM\Column(type="string", length=255, nullable=true)
	*/
	protected $accroche;
	
	public function getNom(){
		return $this->nom;
	}
	public function setNom($nom){
		$this->nom = $nom;
	}
	public function getAccroche(){
		return $this->accroche;
	}
	public function setAccroche($accroche){
		$this->accroche = $accroche;
	}
}
