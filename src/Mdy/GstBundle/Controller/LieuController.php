<?php
/**
 * File :	LieuController.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Form
 * Since :	--
 * Update :	17/11/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Mdy\GstBundle\Entity\Lieu;
use Mdy\GstBundle\Form\LieuType;
use Mdy\GstBundle\Form\LieuEditType;

class LieuController extends Controller
{
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function addAction(Request $request){
		$existor = $this->get('mdy_gst.exist');
		// Si pas requête AJAX
		if( !$request->isXmlHttpRequest() ){
			$em = $this->getDoctrine()->getManager();
			$lieu = new Lieu();
			// $lieu->setRemember(1);
			
			$form = $this->createForm(new LieuType, $lieu);
			if( $form->handleRequest($request)->isValid()){
				if( !$existor->lieuExist($lieu)){
					$em->persist($lieu);
					$em->flush();
					$this->get('session')->getFlashBag()->add('confirm', 'Lieu ajouté avec succès !');
					return $this->redirect($this->generateUrl('mdy_gst_listLieu'));
				}
				else{
					$this->get('session')->getFlashBag()->add('error', 'Ce lieu existe déjà et n\'a donc pas été ajouté !');
					return $this->redirect($this->generateUrl('mdy_gst_listLieu'));
				}
			}
			return $this->render('MdyGstBundle:Gst:Lieu/add.html.twig', array('form' => $form->createView()));
		}
		else{ // Si AJAX, le traitement diffère
			$em = $this->getDoctrine()->getManager();
			$lieu = new Lieu();
			$form = $this->createForm(new LieuType, $lieu);
			if( $request->getMethod() == "POST"){
				$form->bind($request);
				if( $form->isValid()){
					if( !$existor->lieuExist($lieu)){
						// $response = new Response(json_encode(array('id' => "je suis bien isValid")));
						// $response->headers->set('Content-Type', 'application/json');
						// return $response;
						$em->persist($lieu);
						$em->flush();
						$lieux = $em->getRepository("MdyGstBundle:Lieu")->findNotDeleted();
						$liste = "";
						if( !empty($lieux) ){
							foreach($lieux as $i => $unlieu){
								if( $unlieu->getId() == $lieu->getId() ){
									$liste .= '<option value="'.$unlieu->getId().'" selected="selected">'.$unlieu->getNom().'</option>';
								}
								else{
									$liste .= '<option value="'.$unlieu->getId().'">'.$unlieu->getNom().'</option>';
								}
							}
							$response = new Response(json_encode(array('liste' => $liste, 'message' => "Lieu ajouté avec succès !")));
							$response->headers->set('Content-Type', 'application/json');
							return $response;
						}
					}
					else {
						// il faut récupérer la liste des lieux et sélectionner le
						// lieu dans cette liste qui a été saisi dans le formulaire
						$saisie = $em->getRepository("MdyGstBundle:Lieu")->findByLieu($lieu);
						$lieux = $em->getRepository("MdyGstBundle:Lieu")->findNotDeleted();
						$liste = "";
						if( !empty($lieux) ){
							foreach($lieux as $i => $unlieu){
								if( $unlieu->getId() == $saisie[0]->getId() ){
									$liste .= '<option value="'.$unlieu->getId().'" selected="selected">'.$unlieu->getNom().'</option>';
								}
								else{
									$liste .= '<option value="'.$unlieu->getId().'">'.$unlieu->getNom().'</option>';
								}
							}
							$response = new Response(json_encode(array('liste' => $liste, 'message' => "Lieu ajouté avec succès !")));
							$response->headers->set('Content-Type', 'application/json');
							return $response;
						}
						
						return false;
					}
				}
			}
			return $this->container->get('templating')->renderResponse('MdyGstBundle:Gst:Lieu/add.ajax.twig', array('form' => $form->createView()));
		}
	}
	
	/**
	*@Security("has_role('ROLE_SUPERVISEUR')")
	*/
	public function deleteAction(Lieu $lieu, Request $request) {
		$form = $this->createFormBuilder()->getForm();
		if( $request->getMethod() == "POST" ){
			$form->bind($request);
			if( $form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->remove($lieu);
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Lieu supprimé avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_listLieu'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Lieu/delete.html.twig', array( 'lieu' => $lieu, 'form' => $form->createView() ));
	}
	
	/**
	*@Security("has_role('ROLE_SUPERVISEUR')")
	*/
	public function restoreAction($id, Request $request) {
		$form = $this->createFormBuilder()->getForm();
		$em = $this->getDoctrine()->getManager();
		$lieu = $em->getRepository('MdyGstBundle:Lieu')->find($id);
		if( $request->getMethod() == "POST" ){
			$form->bind($request);
			if( $form->isValid()){
				// $lieu = $em->getRepository('MdyGstBundle:Lieu')->find($lieu->getId());
				$lieu->setDeletedAt(null);
				$em->persist($lieu);
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Lieu restauré avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_listLieu'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Lieu/restore.html.twig', array( 'lieu' => $lieu, 'form' => $form->createView() ));
	}
	
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function editAction($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$lieu = $em->getRepository('MdyGstBundle:Lieu')->find($id);
		if( $lieu === null){
			throw new NotFoundHttpException("Le lieu recherché [".$id."] n'existe pas.");
		}
		$form = $this->createForm(new LieuEditType, $lieu);
		if( $form->handleRequest($request)->isValid()){
			$em->flush();
			$request->getSession()->getFlashBag()->add('confirm', 'Lieu modifié avec succès !');
			return $this->redirect($this->generateUrl('mdy_gst_listLieu'));
		}
		return $this->render('MdyGstBundle:Gst:Lieu/edit.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_USER')")
	*/
	public function listAction($filter, Request $request){
		$em  = $this->getDoctrine()->getManager();
		$listLieu = null;
		if( $filter == "none"){
			$listLieu = $em->getRepository("MdyGstBundle:Lieu")->findNotDeleted();
		}
		elseif( $filter == "deleted" ){
			$listLieu = $em->getRepository("MdyGstBundle:Lieu")->findDeleted();
		}
		else{
			$request->getSession()->getFlashBag()->add('error', 'Le filtre n\'est pas valide !');
		}
		return $this->render('MdyGstBundle:Gst:Lieu/list.html.twig', array('listLieu' => $listLieu, 'filter' => $filter));
	}
}
