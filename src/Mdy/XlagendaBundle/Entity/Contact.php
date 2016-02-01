<?php
/**
 * File :	Contact.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Entity
 * Since :	17/09/2015
 * Update :	23/11/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Contact
 *
 * @ORM\Table(name="xla_contact")
 * @ORM\Entity(repositoryClass="Mdy\XlagendaBundle\Entity\ContactRepository")
 */
class Contact
{
	
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
	 * @ORM\Column(name="nom", type="string", length=255)
	 */
	private $nom;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="telephone", type="string", length=15, nullable=true)
	 */
	private $telephone;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="phone", type="string", length=15, nullable=true)
	 */
	private $phone;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255, nullable=true)
	 */
	private $email;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Mdy\XlagendaBundle\Entity\Event", mappedBy="contacts")
	 */
	private $events;

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 * @return Contact
	 */
	public function setNom($nom) {
		$this->nom = $nom;
		return $this;
	}

	/**
	 * Get nom
	 *
	 * @return string 
	 */
	public function getNom() {
		return $this->nom;
	}

	/**
	 * Set telephone
	 *
	 * @param string $telephone
	 * @return Contact
	 */
	public function setTelephone($telephone) {
		$this->telephone = $telephone;
		return $this;
	}

	/**
	 * Get telephone
	 *
	 * @return string 
	 */
	public function getTelephone() {
		return $this->telephone;
	}

	/**
	 * Set phone
	 *
	 * @param string $phone
	 * @return Contact
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
		return $this;
	}

	/**
	 * Get phone
	 *
	 * @return string 
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return Contact
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string 
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * Set listed
	 *
	 * @param boolean $listed
	 * @return Contact
	 */
	public function setListed($listed) {
		$this->listed = $listed;
		return $this;
	}

	/**
	 * Get listed
	 *
	 * @return boolean 
	 */
	public function getListed() {
		return $this->listed;
	}
}
