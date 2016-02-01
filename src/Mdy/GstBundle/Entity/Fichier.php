<?php
// src/Mdy/GstBundle/Entity/Fichier.php
namespace Mdy\GstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Fichier
 * @ORM\Table(name="gst_fichier")
 * @ORM\Entity(repositoryClass="Mdy\GstBundle\Entity\FichierRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Fichier
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
	 * @ORM\Column(name="url", type="string", length=255)
	 */
	private $url;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="alt", type="string", length=255)
	 */
	private $alt;
	
	/**
	*@ORM\ManyToOne(targetEntity="Mdy\GstBundle\Entity\Intervention", inversedBy="fichiers")
	*@ORM\JoinColumn(nullable=false)
	*/
	private $intervention;
	
	private $file;
	
	private $tempFilename;

	public function getUploadDir(){
		return 'uploads/img';
	}
	
	public function getUploadRootDir(){
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	
	public function getWebPath(){
		return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
	}
	
	/**
	 * Get id
	 * @return integer 
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * Set url
	 * @param string $url
	 * @return Fichier
	 */
	public function setUrl($url){
		$this->url = $url;
		return $this;
	}

	/**
	 * Get url
	 * @return string 
	 */
	public function getUrl(){
		return $this->url;
	}

	/**
	 * Set alt
	 * @param string $alt
	 * @return Fichier
	 */
	public function setAlt($alt){
		$this->alt = $alt;
		return $this;
	}

	/**
	 * Get alt
	 * @return string 
	 */
	public function getAlt(){
		return $this->alt;
	}
	
	/**
	* Set file
	* @param UploadedFile $file
	*/
	public function setFile(UploadedFile $file){
		$this->file = $file;
		if( $this->url !== null){
			$this->tempFilename = $this->url;
			$this->url = null;
			$this->alt = null;
		}
	}
	
	/**
	* Get file
	* @return UploadedFile
	*/
	public function getFile(){
		return $this->file;
	}

	/**
	 * Set intervention
	 * @param \Mdy\GstBundle\Entity\Intervention $intervention
	 * @return Fichier
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
	*@ORM\PrePersist()
	*@ORM\PreUpdate()
	*/
	public function preUpload(){
		if( $this->file === null){
			return;
		}
		$this->url = $this->file->guessExtension();
		$this->alt = $this->file->getClientOriginalName();
	}
	
	/**
	*@ORM\PostPersist()
	*@ORM\PostUpdate()
	*/
	public function upload(){
		if($this->file === null){
			return;
		}
		if( $this->tempFilename !== null){
			$oldfFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
			if(file_exists($oldFile)){
				unlink($oldFile);
			}
		}
		$this->file->move($this->getUploadRootDir(), $this->id.'.'.$this->url);
	}
	
	/**
	*@ORM\PreRemove();
	*/
	public function preRemoveUpload(){
		$this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
	}
	
	/**
	*@ORM\PostRemove()
	*/
	public function removeUpload(){
		if( file_exists($this->tempFilename)){
			unlink($this->tempFilename);
		}
	}
}
