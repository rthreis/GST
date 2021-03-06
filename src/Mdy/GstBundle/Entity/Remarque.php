<?php

namespace Mdy\GstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Remarque
 *
 * @ORM\Table(name="gst_remarque")
 * @ORM\Entity(repositoryClass="Mdy\GstBundle\Entity\RemarqueRepository")
 */
class Remarque
{
	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(name="contenu", type="text")
	 */
	private $contenu;

	/**
	*@ORM\ManyToOne(targetEntity="Mdy\GstBundle\Entity\Intervention", inversedBy="remarques")
	*@ORM\JoinColumn(nullable=false)
	*/
	private $intervention;
	
	/**
	*@ORM\ManyToOne(targetEntity="Mdy\UserBundle\Entity\User")
	*@ORM\JoinColumn(nullable=false)
	*/
	private $auteur;

	/**
	 * Get id
	 * @return integer 
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * Set contenu
	 * @param string $contenu
	 * @return remarque
	 */
	public function setContenu($contenu){
		$this->contenu = $contenu;
		return $this;
	}

	/**
	 * Get contenu
	 * @return string 
	 */
	public function getContenu(){
		return $this->contenu;
	}

	/**
	 * Set intervention
	 * @param \Mdy\GstBundle\Entity\Intervention $intervention
	 * @return remarque
	 */
	public function setIntervention(\Mdy\GstBundle\Entity\Intervention $intervention){
		$this->intervention = $intervention;
		return $this;
	}

	/**
	 * Get intervention
	 * @return \Mdy\GstBundle\Entity\Intervention 
	 */
	public function getIntervention(){
		return $this->intervention;
	}

	/**
	 * Set auteur
	 * @param \Mdy\UserBundle\Entity\User $auteur
	 * @return Remarque
	 */
	public function setAuteur(\Mdy\UserBundle\Entity\User $auteur){
		$this->auteur = $auteur;
		return $this;
	}

	/**
	 * Get auteur
	 * @return \Mdy\UserBundle\Entity\User 
	 */
	public function getAuteur(){
		return $this->auteur;
	}
}
