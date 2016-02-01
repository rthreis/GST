<?php
/**
 * File :	Equipe.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Entities
 * Since :	--
 * Update :	23/12/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Equipe
 * @ORM\Table(name="gst_equipe")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity(repositoryClass="Mdy\GstBundle\Entity\EquipeRepository")
 */
class Equipe {
	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(name="nom", type="string", length=255)
	 */
	private $nom;
	
	/**
	*@var datetime
	*@ORM\Column(name="deletedAt", type="datetime", nullable=true)
	*/
	private $deletedAt;
	
	/**
	*@ORM\ManyToMany(targetEntity="Mdy\GstBundle\Entity\Intervention", inversedBy="equipes")
	*@ORM\JoinTable(name="gst_equipe_intervention")
	*@ORM\JoinColumn(nullable=false)
	*/
	private $interventions;

	/**
	*@ORM\ManyToOne(targetEntity="Mdy\GstBundle\Entity\Cloture", inversedBy="equipe")
	*/
	private $clotures;

	/**
	 * Get id
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set nom
	 * @param string $nom
	 * @return Equipe
	 */
	public function setNom($nom) {
		$this->nom = $nom;
		return $this;
	}

	/**
	 * Get nom
	 * @return string 
	 */
	public function getNom() {
		return $this->nom;
	}

	/**
	 * Set deletedAt
	 * @param \DateTime $deletedAt
	 * @return equipe
	 */
	public function setDeletedAt($deletedAt){
		$this->deletedAt = $deletedAt;
		return $this;
	}

	/**
	 * Get deletedAt
	 * @return \DateTime 
	 */
	public function getDeletedAt(){
		return $this->deletedAt;
	}
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->interventions = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add interventions
	 * @param \Mdy\GstBundle\Entity\Intervention $interventions
	 * @return Equipe
	 */
	public function addIntervention(\Mdy\GstBundle\Entity\Intervention $interventions){
		$this->interventions[] = $interventions;
		return $this;
	}

	/**
	 * Remove interventions
	 * @param \Mdy\GstBundle\Entity\Intervention $interventions
	 */
	public function removeIntervention(\Mdy\GstBundle\Entity\Intervention $interventions){
		$this->interventions->removeElement($interventions);
	}

	/**
	 * Get interventions
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getInterventions(){
		return $this->interventions;
	}
}