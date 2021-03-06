<?php
namespace Mdy\GstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Approbation
 *
 * @ORM\Table(name="gst_approbation")
 * @ORM\Entity(repositoryClass="Mdy\GstBundle\Entity\ApprobationRepository")
 */
class Approbation
{
	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="dateApprobation", type="datetime")
	 */
	private $dateApprobation;
	
	/**
	* @var string
	* @ORM\Column(name="roleApprobateur", type="string", length=25)
	*/
	private $roleApprobateur;

	/**
	*@ORM\ManyToOne(targetEntity="Mdy\GstBundle\Entity\Intervention", inversedBy="approbations")
	*@ORM\JoinColumn(nullable=false)
	*/
	private $intervention;
	
	
	/**
	*@ORM\ManyToOne(targetEntity="Mdy\UserBundle\Entity\User")
	*/
	private $user;

	/**
	 * Get id
	 * @return integer 
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * Set dateApprobation
	 * @param \DateTime $dateApprobation
	 * @return approbation
	 */
	public function setDateApprobation($dateApprobation){
		$this->dateApprobation = $dateApprobation;
		return $this;
	}

	/**
	 * Get dateApprobation
	 * @return \DateTime 
	 */
	public function getDateApprobation(){
		return $this->dateApprobation;
	}

	/**
	 * Set intervention
	 * @param \Mdy\GstBundle\Entity\Intervention $intervention
	 * @return approbation
	 */
	public function setIntervention(\Mdy\GstBundle\Entity\Intervention $intervention = null){
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
	 * Set user
	 * @param \Mdy\UserBundle\Entity\User $user
	 * @return Approbation
	 */
	public function setUser(\Mdy\UserBundle\Entity\User $user = null){
		$this->user = $user;
		return $this;
	}

	/**
	 * Get user
	 * @return \Mdy\UserBundle\Entity\User 
	 */
	public function getUser(){
		return $this->user;
	}

    /**
     * Set roleApprobateur
     * @param string $roleApprobateur
     * @return Approbation
     */
    public function setRoleApprobateur($roleApprobateur){
        $this->roleApprobateur = $roleApprobateur;
        return $this;
    }

    /**
     * Get roleApprobateur
     * @return string 
     */
    public function getRoleApprobateur(){
        return $this->roleApprobateur;
    }
}
