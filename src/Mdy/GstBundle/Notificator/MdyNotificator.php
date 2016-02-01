<?php
/**
 * File :	MdyNotificator.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Notificator
 * Since :	--
 * Update :	08/10/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Notificator;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Mdy\GstBundle\Entity\Intervention;
use Mdy\UserBundle\Entity\User;

class MdyNotificator{
	protected $mailer;
	protected $em;
	
	public function __construct(\Swift_Mailer $mailer, $templating, EntityManager $doctrine){
		$this->mailer = $mailer;
		$this->templateEngine = $templating;
		$this->em = $doctrine;
	}
	
	public function notify(Intervention $intervention){
		// $em = $this->doctrine->getEntityManager();
		if( $intervention->getAccDirReq() ){
			$users = $this->em->getRepository('MdyUserBundle:User')->findByRole('directeur');
			$this->notifyDirecteur($intervention, $users);
		}
		if( $intervention->getAccEchReq() ){
			$users = $this->em->getRepository('MdyUserBundle:User')->findByRole('echevin');
			$this->notifyEchevin($intervention, $users);
		}
	}
	
	public function notifyDirecteur(Intervention $intervention, $users){
		$message = \Swift_Message::newInstance();
		$message->setSubject('Action requise sur demande n° '.$intervention->getNumero());
		$message->setFrom('gst@malmedy.be');
		$to = new ArrayCollection();
		foreach($users as $i => $user){
			$to->add($user->getEmail());
		}
		$message->setTo($to->toArray());
		$message->setBody($this->templateEngine->render('MdyGstBundle:Notificator:directeur.html.twig', array('intervention' => $intervention)));
		$this->mailer->send($message);
	}
	
	public function notifyEchevin(Intervention $intervention, $users){
		$message = \Swift_Message::newInstance();
		$message->setSubject('Action requise sur demande n° '.$intervention->getNumero());
		$message->setFrom('gst@malmedy.be');
		$to = new ArrayCollection();
		foreach($users as $i => $user){
			$to->add($user->getEmail());
		}
		$message->setTo($to->toArray());
		$message->setBody($this->templateEngine->render('MdyGstBundle:Notificator:echevin.html.twig', array('intervention' => $intervention)), 'text/html');
		$this->mailer->send($message);
	}
}