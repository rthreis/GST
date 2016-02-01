<?php
/**
 * File :	Cloture.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Entities
 * Since :	23/12/2015
 * Update :	23/12/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Cloture
 *
 * @ORM\Table(name="gst_cloture")
 * @ORM\Entity(repositoryClass="Mdy\GstBundle\Entity\ClotureRepository")
 */
class Cloture
{
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
	 * @ORM\Column(name="dateCloture", type="datetime")
	 */
	private $dateCloture;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="travaux", type="text")
	 */
	private $travaux;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="duree", type="string", length=100)
	 */
	private $duree;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nbOuvrier", type="string", length=100)
	 */
	private $nbOuvrier;

	/**
	*@ORM\ManyToOne(targetEntity="Mdy\GstBundle\Entity\Intervention", inversedBy="clotures")
	*@ORM\JoinColumn(nullable=false)
	*/
	private $intervention;

	/**
	 *@ORM\OneToMany(targetEntity="Mdy\GstBundle\Entity\Equipe", cascade={"persist"}, mappedBy="clotures")
	 */
	private $equipe;

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
	 * Set dateCloture
	 *
	 * @param \DateTime $dateCloture
	 * @return Cloture
	 */
	public function setDateCloture($dateCloture){
		$this->dateCloture = $dateCloture;
		return $this;
	}

	/**
	 * Get dateCloture
	 *
	 * @return \DateTime 
	 */
	public function getDateCloture(){
		return $this->dateCloture;
	}

	/**
	 * Set travaux
	 *
	 * @param string $travaux
	 * @return Cloture
	 */
	public function setTravaux($travaux){
		$this->travaux = $travaux;
		return $this;
	}

	/**
	 * Get travaux
	 *
	 * @return string 
	 */
	public function getTravaux(){
		return $this->travaux;
	}

	/**
	 * Set duree
	 *
	 * @param string $duree
	 * @return Cloture
	 */
	public function setDuree($duree){
		$this->duree = $duree;
		return $this;
	}

	/**
	 * Get duree
	 *
	 * @return string 
	 */
	public function getDuree(){
		return $this->duree;
	}

	/**
	 * Set nbOuvrier
	 *
	 * @param string $nbOuvrier
	 * @return Cloture
	 */
	public function setNbOuvrier($nbOuvrier){
		$this->nbOuvrier = $nbOuvrier;
		return $this;
	}

	/**
	 * Get nbOuvrier
	 *
	 * @return string 
	 */
	public function getNbOuvrier(){
		return $this->nbOuvrier;
	}
	
	/**
	 * Set intervention
	 *
	 * @param Intervention $intervention
	 * @return Cloture
	 */
	public function setIntervention($intervention){
		$this->intervention = $intervention;
		return $this;
	}

	/**
	 * Get intervention
	 *
	 * @return Intervention
	 */
	public function getIntervention(){
		return $this->intervention;
	}
	
	/**
	 * Add equipes
	 * @param \Mdy\GstBundle\Entity\Equipe $equipes
	 * @return intervention
	 */
	public function addEquipe(\Mdy\GstBundle\Entity\Equipe $equipe) {
		$this->equipe = $equipe;
		return $this;
	}

	/**
	 * Get equipes
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getEquipe() {
		return $this->equipe;
	}
}
