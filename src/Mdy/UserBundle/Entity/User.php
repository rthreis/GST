<?php
// src/Mdy/UserBundle/Entity/User.php

namespace Mdy\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Table(name="gst_user")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
* @ORM\Entity(repositoryClass="Mdy\UserBundle\Entity\UserRepository")
*/
class User extends BaseUser{
	
	/**
	*@ORM\Column(name="id", type="integer")
	*@ORM\Id
	*@ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	*@var string
	*@ORM\Column(name="nom", type="string")
	*/
	private $nom;
	
	/**
	*@var string
	*@ORM\Column(name="prenom", type="string")
	*/
	private $prenom;
	
	/**
	*@var string
	*@ORM\Column(name="langue", type="string")
	*/
	private $langue;
	
	/**
	*@var datetime
	*@ORM\Column(name="deletedAt", type="datetime", nullable=true)
	*/
	private $deletedAt;

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
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set langue
     *
     * @param string $langue
     * @return User
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string 
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return User
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
