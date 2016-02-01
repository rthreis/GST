<?php
/**
 * File :	RubriqueController.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Controller
 * Since :	06/08/2015
 * Update :	11/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Mdy\XlagendaBundle\Entity\Rubrique;
use Mdy\XlagendaBundle\Form\RubriqueType;
use Mdy\XlagendaBundle\Form\RubriqueEditType;

class RubriqueController extends Controller
{
	public function indexAction($name)
	{
		return $this->render('MdyXlagendaBundle:Default:index.html.twig', array('name' => $name));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_REDACTEUR')")
	*/
	public function listAction(Request $request, $filter){
		$em = $this->getDoctrine()->getManager();
		$listRubrique = null;
		if( $filter == 'none'){
			$listRubrique = $em->getRepository('MdyXlagendaBundle:Rubrique')->findNotDeleted();
		}
		elseif( $filter == 'dele'){
			$listRubrique = $em->getRepository('MdyXlagendaBundle:Rubrique')->findDeleted();
		}
		else{
			$filter = none;
			$this->get('session')->getFlashBag()->add('erreur', 'Filtre incorrect ! Tentative d\'accès illégal !');
		}
		
		return $this->render('MdyXlagendaBundle:Rubrique:list.html.twig', array('listRubrique' => $listRubrique, 'filter' => $filter));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_EDITEUR')")
	*/
	public function addAction(Request $request){
		$rubrique = new Rubrique();
		$form = $this->get('form.factory')->create(new RubriqueType, $rubrique);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->persist($rubrique);
				$rubrique->mergeNewTranslations();
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Rubrique ajoutée avec succès !');
				return $this->redirect($this->generateUrl('mdy_xlagenda_rubrique_list'));
			}
		}
		
		return $this->render('MdyXlagendaBundle:Rubrique:add.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_EDITEUR')")
	*/
	public function editAction(Request $request, $id){
		$em = $this->getDoctrine()->getManager();
		$rubrique = $em->getRepository('MdyXlagendaBundle:Rubrique')->find($id);
		if( $rubrique === null){
			throw new NotFoundHttpException("La rubrique recherchée [".$id."] n'existe pas.");
		}
		$form = $this->createForm(new RubriqueEditType, $rubrique);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$em->persist($rubrique);
				$em->flush();
				$request->getSession()->getFlashBag()->add('confirm', 'Lieu modifié avec succès !');
				return $this->redirect($this->generateUrl('mdy_xlagenda_rubrique_list'));
			}
		}
		return $this->render('MdyXlagendaBundle:Rubrique:edit.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_EDITEUR')")
	*/
	public function deleteAction(Request $request, $id){
		$em = $this->getDoctrine()->getManager();
		$rubrique = $em->getRepository('MdyXlagendaBundle:Rubrique')->find($id);
		$em->remove($rubrique);
		$em->flush();
		return $this->redirect($this->generateUrl('mdy_xlagenda_rubrique_list'));
	}
	
	/**
	*@Security("has_role('ROLE_XLA_EDITEUR')")
	*/
	public function restoreAction(Request $request, $id){
		$em = $this->getDoctrine()->getManager();
		$rubrique = $em->getRepository('MdyXlagendaBundle:Rubrique')->find($id);
		$rubrique->setDeletedAt(null);
		$em->persist($rubrique);
		$em->flush();
		$this->get('session')->getFlashBag()->add('confirm', 'Equipe restaurée avec succès !');
		return $this->redirect($this->generateUrl('mdy_xlagenda_rubrique_list'));
	}
}
