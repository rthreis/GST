<?php
/**
 * File :	EventController.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Controller
 * Since :	06/08/2015
 * Update :	05/10/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Mdy\XlagendaBundle\Entity\Event;
use Mdy\XlagendaBundle\Form\EventType;
use Mdy\XlagendaBundle\Form\EventEditType;

class EventController extends Controller
{
	public function listAction(Request $request, $filter){
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		if( $user != null){
			$request->setLocale($user);
			$listEvent = null;
			$listEvent = $em->getRepository('MdyXlagendaBundle:Event')->listEvents(null);
			return $this->render('MdyXlagendaBundle:Event:list.html.twig', array('listEvent' => $listEvent, 'filter' => $filter));
		}
		else{ // utilisateur anonymous
			if( $request->isXmlHttpRequest()){ // il s'agit d'un appel AJAX
				if( $request->getMethod() == "POST"){
					$filter = Array();
					$filter['lieu'] = $request->request->get('lieu');
					$filter['rubrique'] = $request->request->get('rubrique');
					$filter['dateDebut'] = $request->request->get('dateDebut');
					$filter['dateFin'] = $request->request->get('dateFin');
					$listEvent = $em->getRepository('MdyXlagendaBundle:Event')->findFilter($filter);
					return $this->render('MdyXlagendaBundle:Event:visitor.ajax.twig', array('listEvent' => $listEvent));
				}
				else{
					
				}
			}
			else{ // il s'agit d'un appel "standard"
				$listEvent = $em->getRepository('MdyXlagendaBundle:Event')->myFindAll();
				$listLieu = $em->getRepository('MdyXlagendaBundle:Lieu')->findAll();
				$listRubrique = $em->getRepository('MdyXlagendaBundle:Rubrique')->findAll();
				return $this->render('MdyXlagendaBundle:Event:visitor.html.twig', array('listEvent' => $listEvent, 'listLieu' => $listLieu, 'listRubrique' => $listRubrique, 'filter' => null));
			}
		}
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function addAction(Request $request){
		$event = new Event();
		$form = $this->get('form.factory')->create(new EventType, $event);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->persist($event);
				$event->mergeNewTranslations();
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Evénement ajouté avec succès !');
				return $this->redirect($this->generateUrl('mdy_xlagenda_event_list'));
			}
		}
		return $this->render('MdyXlagendaBundle:Event:add.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function editAction(Request $request, Event $id){
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository('MdyXlagendaBundle:Event')->find($id);
		if( $event === null){
			throw new NotFoundHttpException("L'événement recherché [".$id."] n'existe pas.");
		}
		$form = $this->createForm(new EventEditType, $event);
		if( $form->handleRequest($request)->isValid()){
			$em->flush();
			$request->getSession()->getFlashBag()->add('confirm', 'Evénement modifié avec succès !');
			return $this->redirect($this->generateUrl('mdy_xlagenda_event_list'));
		}
		return $this->render('MdyXlagendaBundle:Event:edit.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function deleteAction(Request $request, $id){
		
	}
}
