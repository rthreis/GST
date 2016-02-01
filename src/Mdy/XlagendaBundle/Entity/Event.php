<?php
/**
 * File :	Event.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Entity
 * Since :	06/08/2015
 * Update :	13/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="xla_event")
 * @ORM\Entity(repositoryClass="Mdy\XlagendaBundle\Entity\EventRepository")
 */
class Event
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="debut", type="datetime")
	 */
	private $debut;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fin", type="datetime", nullable=true)
	 */
	private $fin;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="lien", type="string", length=255, nullable=true)
	 * @Assert\Length(min=3)
	 */
	private $lien;
	
	/**
	 * @var boolean
	 * @ORM\Column(name="publication", type="boolean", nullable=true)
	 */
	private $publication;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Mdy\XlagendaBundle\Entity\Rubrique", cascade="persist", inversedBy="events")
	 * @ORM\JoinTable(name="xla_events_rubriques")
	 */
	private $rubriques;
		
	/**
	 * @ORM\ManyToOne(targetEntity="Mdy\XlagendaBundle\Entity\Lieu", cascade="persist", inversedBy="events")
	 */
	private $lieu;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Mdy\XlagendaBundle\Entity\Fichier", cascade={"persist"}, inversedBy="events")
	 */
	private $affiche;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Mdy\XlagendaBundle\Entity\Contact", cascade={"persist"}, inversedBy="events")
	 * @ORM\JoinTable(name="xla_events_contacts")
	 */
	private $contacts;

	public function __construct(){
		$this->rubriques = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function __call($method, $arguments)
	{
		return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
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
	 * Set debut
	 *
	 * @param \DateTime $debut
	 * @return Event
	 */
	public function setDebut($debut)
	{
		$this->debut = $debut;

		return $this;
	}

	/**
	 * Get debut
	 *
	 * @return \DateTime 
	 */
	public function getDebut()
	{
		return $this->debut;
	}

	/**
	 * Set fin
	 *
	 * @param \DateTime $fin
	 * @return Event
	 */
	public function setFin($fin)
	{
		$this->fin = $fin;

		return $this;
	}

	/**
	 * Get fin
	 *
	 * @return \DateTime 
	 */
	public function getFin()
	{
		return $this->fin;
	}

	/**
	 * Set lien
	 *
	 * @param string $lien
	 * @return Event
	 */
	public function setLien($lien)
	{
		$this->lien = $lien;

		return $this;
	}

	/**
	 * Get lien
	 *
	 * @return string 
	 */
	public function getLien()
	{
		return $this->lien;
	}
	
	/**
	 * Set Publication
	 * @param boolean $publication
	 * @return Event
	 */
	public function setPublication($publication){
		$this->publication = $publication;
		return $this;
	}
	
	/**
	 * Get Publication
	 * @return boolean
	 */
	public function getPublication(){
		return $this->publication;
	}
	
	/**
	 * Set Rubrique
	 * @param \Mdy\XlagendaBundle\Entity\Rubrique
	 * @return Event
	 */
	public function addRubrique(\Mdy\XlagendaBundle\Entity\Rubrique $rubrique){
		$this->rubriques[] = $rubrique;
	}
	
	/**
	 * Remove Rubrique
	 * @param \Mdy\XlagendaBundle\Entity\Rubrique
	 * @return Event
	 */
	public function removeRubrique(\Mdy\XlagendaBundle\Entity\Rubrique $rubrique){
		$this->rubriques->removeElement($rubrique);
		return $this;
	}
	
	/**
	 * Get Rubrique
	 * @return Rubrique
	 */
	public function getRubriques(){
		return $this->rubriques;
	}
	
	/**
	 * Set Lieu
	 * @param \Mdy\XlagendaBundle\Entity\Lieu
	 * @return Event
	 */
	public function setLieu(\Mdy\XlagendaBundle\Entity\Lieu $lieu){
		$this->lieu = $lieu;
	}
	
	/**
	 * Get Lieu
	 * @return \Mdy\XlagendaBundle\Entity\Lieu
	 */
	public function getLieu(){
		return $this->lieu;
	}
	
	/**
	 * Set Affiche
	 * @param \Mdy\XlagendaBundle\Entity\Fichier
	 * @return Event
	 */
	public function setAffiche(\Mdy\XlagendaBundle\Entity\Fichier $fichier){
		$this->affiche = $fichier;
	}
	
	/**
	 * Get Affiche
	 * @return \Mdy\XlagendaBundle\Entity\Fichier
	 */
	public function getAffiche(){
		return $this->affiche;
	}
	
	/**
	 * Set Contact
	 * @param \Mdy\XlagendaBundle\Entity\Contact
	 * @return Event
	 */
	public function addContact(\Mdy\XlagendaBundle\Entity\Contact $contact){
		$this->contacts[] = $contact;
	}
	
	/**
	 * Remove Contact
	 * @param \Mdy\XlagendaBundle\Entity\Contact
	 * @return Event
	 */
	public function removeContact(\Mdy\XlagendaBundle\Entity\Contact $contact){
		$this->rubriques->removeElement($contact);
		return $this;
	}
	
	/**
	 * Get Contact
	 * @return Contact
	 */
	public function getContacts(){
		return $this->contacts;
	}
}
