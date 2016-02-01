<?php
/**
 * File :	Intervention.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Entities
 * Since :	--
 * Update :	23/12/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * intervention
 *
 * @ORM\Table(name="gst_intervention")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity(repositoryClass="Mdy\GstBundle\Entity\InterventionRepository")
 */
class Intervention
{
	public function __construct(){
		$this->dateDemande = new \Datetime();
		$this->equipes = new ArrayCollection();
		$this->remarques = new ArrayCollection();
		$this->approbations = new ArrayCollection();
		$this->fichiers = new ArrayCollection();
	}
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var integer
	 * @ORM\Column(name="numero", type="integer", unique=true)
	 */
	private $numero;
	
	/**
	 * @var string
	 * @ORM\Column(name="objet", type="string", length=255, nullable=true)
	 */
	private $objet;

	/**
	 * @var string
	 * @ORM\Column(name="contenu", type="text")
	 * @Assert\NotBlank()
	 */
	private $contenu;
	
	/**
	*@ORM\ManyToOne(targetEntity="Mdy\UserBundle\Entity\User")
	*/
	private $auteur;
	
	/**
	* @var string
	* @ORM\Column(name="demandeur", type="string")
	* @Assert\NotBlank()
	*/
	private $demandeur;
	
	/**
	* @var string
	* @ORM\Column(name="contact", type="string", nullable=true)
	* 
	*/
	private $contact;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="dateDemande", type="datetime")
	 * @Assert\DateTime()
	 */
	private $dateDemande;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="dateAssignation", type="datetime", nullable=true)
	 * @Assert\DateTime()
	 */
	private $dateAssignation;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="dateCloture", type="datetime", nullable=true)
	 * @Assert\DateTime()
	 */
	private $dateCloture;
	
	/**
	 * @var string
	 * @ORM\Column(name="complement", type="text", nullable=true)
	 */
	private $complement;
	
	/**
	 * @var string
	 * @ORM\Column(name="duree", type="string", nullable=true)
	 */
	private $duree;
	
	/**
	 * @var string
	 * @ORM\Column(name="nbOuvrier", type="string", nullable=true)
	 */
	private $nbOuvrier;

	/**
	 * @var boolean
	 * @ORM\Column(name="accDirReq", type="boolean")
	 */
	private $accDirReq;

	/**
	 * @var boolean
	 * @ORM\Column(name="accEchReq", type="boolean")
	 */
	private $accEchReq;
	
	/**
	*@var boolean
	*@ORM\Column(name="printed", type="datetime", nullable=true)
	*@Assert\DateTime()
	*/
	private $printed;

	/**
	*@ORM\ManyToOne(targetEntity="Mdy\GstBundle\Entity\Lieu")
	*/
	private $lieu;
	
	/**
	*@ORM\ManyToMany(targetEntity="Mdy\GstBundle\Entity\Equipe", cascade={"persist"}, mappedBy="interventions")
	*/
	private $equipes;
	
	/**
	*@ORM\OneToMany(targetEntity="Mdy\GstBundle\Entity\Approbation", cascade={"persist"}, mappedBy="intervention")
	*/
	private $approbations;
	
	/**
	*@ORM\OneToMany(targetEntity="Mdy\GstBundle\Entity\Fichier", cascade={"persist", "remove"}, mappedBy="intervention")
	*/
	private $fichiers;
	
	/**
	*@ORM\OneToMany(targetEntity="Mdy\GstBundle\Entity\Remarque", cascade={"persist"}, mappedBy="intervention")
	*/
	private $remarques;
	
	/**
	*@ORM\OneToMany(targetEntity="Mdy\GstBundle\Entity\Cloture", cascade={"persist"}, mappedBy="intervention")
	*/
	private $clotures;
	
	/**
	* @var Datetime
	* @ORM\Column(name="deletedAt", type="datetime", nullable=true)
	*/
	private $deletedAt;
	
	/**
	 * @var string
	 * @ORM\Column(name="justify", type="text", nullable=true)
	 */
	private $justify;

	/**
	 * Get id
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set numero
	 * @param integer $numero
	 * @return intervention
	 */
	public function setNumero($numero){
		$this->numero = $numero;
	}
	
	/**
	 * Get numero
	 * @return integer
	 */
	public function getNumero(){
		return $this->numero;
	}

	/**
	 * Set objet
	 * @param string $objet
	 * @return intervention
	 */
	public function setObjet($objet) {
		$this->objet = $objet;
		return $this;
	}

	/**
	 * Get objet
	 * @return string 
	 */
	public function getObjet() {
		return $this->objet;
	}

	/**
	 * Set contenu
	 * @param string $contenu
	 * @return intervention
	 */
	public function setContenu($contenu) {
		$this->contenu = $contenu;
		return $this;
	}

	/**
	 * Get contenu
	 * @return string 
	 */
	public function getContenu() {
		return $this->contenu;
	}

	/**
	 * Set dateDemande
	 * @param \DateTime $dateDemande
	 * @return intervention
	 */
	public function setDateDemande($dateDemande) {
		$this->dateDemande = $dateDemande;
		return $this;
	}

	/**
	 * Get dateDemande
	 * @return \DateTime 
	 */
	public function getDateDemande() {
		return $this->dateDemande;
	}

	/**
	 * Set dateAssignation
	 * @param \DateTime $dateAssignation
	 * @return intervention
	 */
	public function setDateAssignation($dateAssignation) {
		$this->dateAssignation = $dateAssignation;
		return $this;
	}

	/**
	 * Get dateAssignation
	 * @return \DateTime 
	 */
	public function getDateAssignation() {
		return $this->dateAssignation;
	}

	/**
	 * Set dateCloture
	 * @param \DateTime $dateCloture
	 * @return intervention
	 */
	public function setDateCloture($dateCloture) {
		$this->dateCloture = $dateCloture;
		return $this;
	}

	/**
	 * Get dateCloture
	 * @return \DateTime 
	 */
	public function getDateCloture() {
		return $this->dateCloture;
	}
	
	/**
	 * Set complement
	 * @param string $complement
	 * @return intervention
	 */
	public function setComplement($complement) {
		$this->complement = $complement;
		return $this;
	}

	/**
	 * Get complement
	 * @return string
	 */
	public function getComplement() {
		return $this->complement;
	}
	
	/**
	 * Set duree
	 * @param string $duree
	 * @return intervention
	 */
	public function setDuree($duree) {
		$this->duree = $duree;
		return $this;
	}

	/**
	 * Get duree
	 * @return string
	 */
	public function getDuree() {
		return $this->duree;
	}
	
	/**
	 * Set nbOuvrier
	 * @param string $nbOuvrier
	 * @return intervention
	 */
	public function setNbOuvrier($nbOuvrier) {
		$this->nbOuvrier = $nbOuvrier;
		return $this;
	}

	/**
	 * Get nbOuvrier
	 * @return string
	 */
	public function getNbOuvrier() {
		return $this->nbOuvrier;
	}

	/**
	 * Set accDirReq
	 * @param boolean $accDirReq
	 * @return intervention
	 */
	public function setAccDirReq($accDirReq) {
		$this->accDirReq = $accDirReq;
		return $this;
	}

	/**
	 * Get accDirReq
	 * @return boolean 
	 */
	public function getAccDirReq() {
		return $this->accDirReq;
	}

	/**
	 * Set accEchReq
	 * @param boolean $accEchReq
	 * @return intervention
	 */
	public function setAccEchReq($accEchReq) {
		$this->accEchReq = $accEchReq;
		return $this;
	}

	/**
	 * Get accEchReq
	 * @return boolean 
	 */
	public function getAccEchReq() {
		return $this->accEchReq;
	}

	/**
	 * Set lieu
	 * @param \Mdy\GstBundle\Entity\Lieu $lieu
	 * @return intervention
	 */
	public function setLieu(\Mdy\GstBundle\Entity\Lieu $lieu = null) {
		$this->lieu = $lieu;
		return $this;
	}

	/**
	 * Get lieu
	 * @return \Mdy\GstBundle\Entity\Lieu 
	 */
	public function getLieu() {
		return $this->lieu;
	}

	/**
	 * Add equipes
	 * @param \Mdy\GstBundle\Entity\Equipe $equipes
	 * @return intervention
	 */
	public function addEquipe(\Mdy\GstBundle\Entity\Equipe $equipe) {
		$this->equipes[] = $equipe;
		$equipe->addIntervention($this);
		return $this;
	}

	/**
	 * Remove equipes
	 * @param \Mdy\GstBundle\Entity\equipe $Equipes
	 */
	public function removeEquipe(\Mdy\GstBundle\Entity\Equipe $equipe) {
		$this->equipes->removeElement($equipe);
		$equipe->removeIntervention($this);
	}

	/**
	 * Get equipes
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getEquipes() {
		return $this->equipes;
	}

	/**
	 * Set auteur
	 * @param string $auteur
	 * @return intervention
	 */
	public function setAuteur($auteur) {
		$this->auteur = $auteur;
		return $this;
	}

	/**
	 * Get auteur
	 * @return string 
	 */
	public function getAuteur() {
		return $this->auteur;
	}

	/**
	 * Set demandeur
	 * @param string $demandeur
	 * @return intervention
	 */
	public function setDemandeur($demandeur) {
		$this->demandeur = $demandeur;
		return $this;
	}

	/**
	 * Get demandeur
	 * @return string 
	 */
	public function getDemandeur() {
		return $this->demandeur;
	}

	/**
	 * Set deletedAt
	 * @param \DateTime $deletedAt
	 * @return intervention
	 */
	public function setDeletedAt($deletedAt) {
		$this->deletedAt = $deletedAt;
		return $this;
	}

	/**
	 * Get deletedAt
	 * @return \DateTime 
	 */
	public function getDeletedAt() {
		return $this->deletedAt;
	}
	
	/**
	 * Set justify
	 * @param string $justify
	 * @return intervention
	 */
	public function setJustify($justify){
		$this->justify = $justify;
	}
	
	/**
	 * Get justify
	 * @return string
	 */
	public function getJustify(){
		return $this->justify;
	}

	/**
	 * Add approbations
	 * @param \Mdy\GstBundle\Entity\Approbation $approbations
	 * @return Intervention
	 */
	public function addApprobation(\Mdy\GstBundle\Entity\Approbation $approbations) {
		$this->approbations[] = $approbations;
		return $this;
	}

	/**
	 * Remove approbations
	 * @param \Mdy\GstBundle\Entity\Approbation $approbations
	 */
	public function removeApprobation(\Mdy\GstBundle\Entity\Approbation $approbations) {
		$this->approbations->removeElement($approbations);
	}

	/**
	 * Get approbations
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getApprobations() {
		return $this->approbations;
	}

	/**
	 * Add remarques
	 * @param \Mdy\GstBundle\Entity\Remarque $remarques
	 * @return Intervention
	 */
	public function addRemarque(\Mdy\GstBundle\Entity\Remarque $remarques) {
		$this->remarques[] = $remarques;
		return $this;
	}

	/**
	 * Remove remarques
	 * @param \Mdy\GstBundle\Entity\Remarque $remarques
	 */
	public function removeRemarque(\Mdy\GstBundle\Entity\Remarque $remarques) {
		$this->remarques->removeElement($remarques);
	}

	/**
	 * Get remarques
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getRemarques() {
		return $this->remarques;
	}
	
	/**
	 * Add cloture
	 * @param \Mdy\GstBundle\Entity\Cloture $cloture
	 * @return intervention
	 */
	public function addCloture(\Mdy\GstBundle\Entity\Cloture $cloture) {
		$this->clotures[] = $cloture;
		$clotures->addIntervention($this);
		return $this;
	}

	/**
	 * Remove cloture
	 * @param \Mdy\GstBundle\Entity\Cloture $cloture
	 */
	public function removeCloture(\Mdy\GstBundle\Entity\Cloture $cloture) {
		$this->clotures->removeElement($cloture);
		// $equipe->removeIntervention($this);
	}

	/**
	 * Get clotures
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getClotures() {
		return $this->clotures;
	}

	/**
	 * Set printed
	 * @param boolean $printed
	 * @return Intervention
	 */
	public function setPrinted($printed) {
		$this->printed = $printed;
		return $this;
	}

	/**
	 * Get printed
	 * @return boolean 
	 */
	public function getPrinted() {
		return $this->printed;
	}

	/**
	 * Add fichiers
	 * @param \Mdy\GstBundle\Entity\Fichier $fichiers
	 * @return Intervention
	 */
	public function addFichier(\Mdy\GstBundle\Entity\Fichier $fichiers){
		$this->fichiers[] = $fichiers;
		return $this;
	}

	/**
	 * Remove fichiers
	 * @param \Mdy\GstBundle\Entity\Fichier $fichiers
	 */
	public function removeFichier(\Mdy\GstBundle\Entity\Fichier $fichiers){
		$this->fichiers->removeElement($fichiers);
	}

	/**
	 * Get fichiers
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getFichiers(){
		return $this->fichiers;
	}

	/**
	 * Set contact
	 * @param string $contact
	 * @return Intervention
	 */
	public function setContact($contact) {
		$this->contact = $contact;
		return $this;
	}

	/**
	 * Get contact
	 * @return string 
	 */
	public function getContact() {
		return $this->contact;
	}
}
