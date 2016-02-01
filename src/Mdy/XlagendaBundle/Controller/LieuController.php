<?php
/**
 * File :	LieuController.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Controller
 * Since :	06/08/2015
 * Update :	25/11/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Mdy\XlagendaBundle\Entity\Lieu;
use Mdy\XlagendaBundle\Form\LieuType;
use Mdy\XlagendaBundle\Form\LieuEditType;

class LieuController extends Controller
{
	public function listAction(Request $request, $filter){
		$listLieu = null;
		$em = $this->getDoctrine()->getManager();
		$listLieu = $em->getRepository('MdyXlagendaBundle:Lieu')->findAll();
		return $this->render('MdyXlagendaBundle:Lieu:list.html.twig', array('listLieu' => $listLieu, 'filter' => $filter));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function addAction(Request $request){
		$lieu = new Lieu();
		$em = $this->getDoctrine()->getManager();
		$form = $this->get('form.factory')->create(new LieuType, $lieu);
		if( !$request->isXmlHttpRequest()){
			if( $request->getMethod() == 'POST'){
				$form->bind($request);
				if( $form->isValid()){
					
					$em->persist($lieu);
					$lieu->mergeNewTranslations();
					$em->flush();
					$this->get('session')->getFlashBag()->add('confirm', 'Lieu ajouté avec succès !');
					return $this->redirect($this->generateUrl('mdy_xlagenda_lieu_list'));
				}
			}
			return $this->render('MdyXlagendaBundle:Lieu:add.html.twig', array('form' => $form->createView()));
		}
		else{
			if( $request->getMethod() == "POST"){
				$form->bind($request);
				if($form->isValid() ){
					$em->persist($lieu);
					$em->flush();
					// il faut retourner une réponse
					
				}
			}
			else{
				return $this->container->get('templating')->renderResponse('MdyXlagendaBundle:Lieu:add.ajax.twig', array('form' => $form->createView()));
			}
		}
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function editAction(Request $request, Lieu $id){
		$em = $this->getDoctrine()->getManager();
		$lieu = $em->getRepository('MdyXlagendaBundle:Lieu')->find($id);
		if( $lieu === null){
			throw new NotFoundHttpException("Le lieu recherché [".$id."] n'existe pas.");
		}
		$form = $this->createForm(new LieuEditType, $lieu);
		if( $form->handleRequest($request)->isValid()){
			$em->flush();
			$request->getSession()->getFlashBag()->add('confirm', 'Lieu modifié avec succès !');
			return $this->redirect($this->generateUrl('mdy_xlagenda_lieu_list'));
		}
		return $this->render('MdyXlagendaBundle:Lieu:edit.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function deleteAction(Request $request, $id){
		
	}
}
