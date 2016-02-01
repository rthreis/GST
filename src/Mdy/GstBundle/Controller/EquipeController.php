<?php
/**
 * File :	EquipeController.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Controller
 * Since :	--
 * Update :	27/08/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Mdy\GstBundle\Entity\Equipe;
use Mdy\GstBundle\Form\EquipeType;

class EquipeController extends Controller
{
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function addAction(Request $request){
		$equipe = new Equipe();
		$form = $this->get('form.factory')->create(new EquipeType, $equipe);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->persist($equipe);
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Equipe ajoutée avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_listEquipe'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Equipe/add.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_SUPERVISEUR')")
	*/
	public function deleteAction(Equipe $equipe, Request $request){
		$form = $this->createFormBuilder()->getForm();
		if( $request->getMethod() == "POST" ){
			$form->bind($request);
			if( $form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->remove($equipe);
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Equipe supprimée avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_listEquipe'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Equipe/delete.html.twig', array( 'equipe' => $equipe, 'form' => $form->createView() ));
	}
	
	/**
	*@Security("has_role('ROLE_SUPERVISEUR')")
	*/
	public function restoreAction($id, Request $request){
		$form = $this->createFormBuilder()->getForm();
		$em = $this->getDoctrine()->getManager();
		$equipe = $em->getRepository("MdyGstBundle:Equipe")->find($id);
		if( $request->getMethod() == "POST"){
			$form->bind($request);
			if( $form->isValid()){
				$equipe->setDeletedAt(null);
				$em->persist($equipe);
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Equipe restaurée avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_listEquipe'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Equipe/restore.html.twig', array( 'equipe' => $equipe, 'form' => $form->createView() ));
	}
	
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function editAction(Equipe $equipe, Request $request){
		$em = $this->getDoctrine()->getManager();
		$equipe = $em->getRepository("MdyGstBundle:Equipe")->find($equipe->getId());
		if( $equipe == null){
			throw new NotFoundException('L\'équipe recherchée ["'.$equipe->getId().'"] n\'a pas été trouvée');
		}
		$form = $this->createForm(new EquipeType, $equipe);
		if( $request->getMEthod() === "POST"){
			$form->bind($request);
			if( $form->isValid()){
				$em->persist($equipe);
				$em->flush();
				return $this->redirect($this->generateUrl('mdy_gst_listEquipe'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Equipe/edit.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_USER')")
	*/
	public function listAction($filter, Request $request){
		$em  = $this->getDoctrine()->getManager();
		$listEquipes = null;
		if( $filter == "none"){
			$listEquipes = $em->getRepository("MdyGstBundle:Equipe")->findNotDeleted();
		}
		elseif( $filter == "deleted" ){
			$listEquipes = $em->getRepository("MdyGstBundle:Equipe")->findDeleted();
		}
		else{
			$request->getSession()->getFlashBag()->add('error', 'Le filtre n\'est pas valide !');
		}
		return $this->render('MdyGstBundle:Gst:Equipe/list.html.twig', array('listEquipes' => $listEquipes, 'filter' => $filter));
	}
}
