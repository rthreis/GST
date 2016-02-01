<?php
/**
 * File :	ContactController.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Controller
 * Since :	17/09/2015
 * Update :	21/09/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Mdy\XlagendaBundle\Entity\Contact;
use Mdy\XlagendaBundle\Form\ContactType;

class ContactController extends Controller
{
	public function listAction(Request $request, $filter){
		$em = $this->getDoctrine()->getManager();
		$listContacts = null;
		if( $filter == "none"){
			$listContacts = $em->getRepository('MdyXlagendaBundle:Contact')->getNotDeleted();
		}
		else{
			$listContacts = $em->getRepository('MdyXlagendaBundle:Contact')->getDeleted();
		}
		return $this->render('MdyXlagendaBundle:Contact:list.html.twig', array('listContacts' => $listContacts, 'filter' => $filter));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function addAction(Request $request){
		$contact = new Contact();
		$em = $this->getDoctrine()->getManager();
		if( $request->isXmlHttpRequest() ){
			$form = $this->createForm(new ContactType, $contact);
			if( $request->getMethod() == 'POST'){
				$form->bind($request);
				if( $form->isValid()){
					$em = $this->getDoctrine()->getManager();
					$em->persist($contact);
					$em->flush();
					$listContacts = $em->getRepository('MdyXlagendaBundle:Contact')->getNotDeleted();
					// $tableauContact = $listContacts->toArray();
					foreach( $listContacts as $i => $contact){
						$tableauContact[] = array('id' => $contact->getId(), 'nom' => $contact->getNom());
					}
					$response = new JsonResponse();
					$response->setData($tableauContact);
					return $response;
					//return $this->redirect($this->generateUrl('mdy_xlagenda_event_list'));
				}
			}
			return $this->container->get('templating')->renderResponse('MdyXlagendaBundle:Contact:add.ajax.twig', array('form' => $form->createView()));
		}
		else{
			$form = $this->createForm(new ContactType, $contact);
			if( $request->getMethod() == 'POST'){
				$form->bind($request);
				if( $form->isValid()){
					$em = $this->getDoctrine()->getManager();
					$em->persist($contact);
					$em->flush();
					$this->get('session')->getFlashBag()->add('confirm', 'Contact ajouté avec succès !');
					return $this->redirect($this->generateUrl('mdy_xlagenda_event_list'));
				}
			}
			return $this->render('MdyXlagendaBundle:Contact:add.html.twig', array('form' => $form->createView()));
		}
	}
	
	public function editAction(Request $request){
		
	}
	
	public function deleteAction(Request $request){
		
	}
}