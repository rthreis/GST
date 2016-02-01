<?php

namespace Mdy\GstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * lieu
 *
 * @ORM\Table(name="gst_lieu")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity(repositoryClass="Mdy\GstBundle\Entity\LieuRepository")
 */
class Lieu
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
	 * @var string
	 *
	 * @ORM\Column(name="nom", type="string", length=255, nullable=true)
	 */
	private $nom;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="rue", type="string", length=255, nullable=true)
	 */
	private $rue;

	/**
	 * @var string
	 * @ORM\Column(name="numero", type="string", length=255, nullable=true)
	 */
	private $numero;

	/**
	 * @var string
	 * @ORM\Column(name="codePostal", type="string", length=255)
	 */
	private $codePostal = 4960;

	/**
	 * @var string
	 * @ORM\Column(name="localite", type="string", length=255)
	 */
	private $localite = "Malmedy";

	/**
	*@var datetime
	*@ORM\Column(name="deletedAt", type="datetime", nullable=true)
	*/
	private $deletedAt;

	/**
	 *@var boolean
	 *@ORM\Column(name="remember", type="boolean", nullable=true)
	 */
	private $remember;
	
	/**
	 * Get id
	 * @return integer 
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * Set nom
	 * @param string $nom
	 * @return lieu
	 */
	public function setNom($nom){
		$this->nom = $nom;
		return $this;
	}

	/**
	 * Get nom
	 * @return string 
	 */
	public function getNom(){
		return $this->nom;
	}

	/**
	 * Set rue
	 * @param string $rue
	 * @return lieu
	 */
	public function setRue($rue){
		$this->rue = $rue;
		return $this;
	}

	/**
	 * Get rue
	 * @return string 
	 */
	public function getRue(){
		return $this->rue;
	}

	/**
	 * Set numero
	 * @param string $numero
	 * @return lieu
	 */
	public function setNumero($numero){
		$this->numero = $numero;

		return $this;
	}

	/**
	 * Get numero
	 * @return string 
	 */
	public function getNumero(){
		return $this->numero;
	}

	/**
	 * Set codePostal
	 * @param string $codePostal
	 * @return lieu
	 */
	public function setCodePostal($codePostal){
		$this->codePostal = $codePostal;

		return $this;
	}

	/**
	 * Get codePostal
	 * @return string 
	 */
	public function getCodePostal(){
		return $this->codePostal;
	}

	/**
	 * Set localite
	 * @param string $localite
	 * @return lieu
	 */
	public function setLocalite($localite){
		$this->localite = $localite;
		return $this;
	}

	/**
	 * Get localite
	 * @return string 
	 */
	public function getLocalite(){
		return $this->localite;
	}

	/**
	 * Set deletedAt
	 * @param \DateTime $deletedAt
	 * @return lieu
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
	 * Set remember
	 * @param boolean $remember
	 * @return lieu*/
	public function setRemember($remember){
		$this->remember = $remember;
	}
	
	/**
	 * Get remember
	 * @return boolean
	 */
	public function getRemember(){
		return $this->remember;
	}
}
