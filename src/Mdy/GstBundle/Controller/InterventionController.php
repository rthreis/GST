<?php
/**
 * File :	InterventionController.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Controller
 * Since :	--
 * Update :	01/02/2016
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Common\Collections\ArrayCollection;
use Mdy\GstBundle\Entity\Intervention;
use Mdy\GstBundle\Entity\Equipe;
use Mdy\GstBundle\Entity\Approbation;
use Mdy\GstBundle\Entity\Fichier;
use Mdy\GstBundle\Entity\Cloture;
use Mdy\GstBundle\Form\InterventionType;
use Mdy\GstBundle\Form\InterventionEditType;
use Mdy\GstBundle\Form\InterventionSearchType;
use Mdy\GstBundle\Form\InterventionAssignationType;
use Mdy\GstBundle\Form\ClotureType;
use Mdy\GstBundle\Form\ApprobationType;

class InterventionController extends Controller{
	private $nombreParPage = 10;
	
	/**
	*@Security("has_role('ROLE_ADMIN')")
	*/
	public function resetAction(){
		$em = $this->getDoctrine()->getManager();
		$listIntervention = $em->getRepository('MdyGstBundle:Intervention')->findAll();
		foreach( $listIntervention as $i => $intervention){
			$intervention->setPrinted(false);
		}
		$em->flush();
		return $this->redirect($this->generateUrl('mdy_gst_listIntervention'));
	}
	
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function addAction(Request $request){
		$intervention = new Intervention();
		$form = $this->get('form.factory')->create(new InterventionType($this->getDoctrine()->getManager()), $intervention);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if ($form->isValid()) {
				$listFichiers = $intervention->getFichiers();
				foreach( $listFichiers as $i => $fichier){
					$fichier->setIntervention($intervention);
				}
				
				$intervention->setAuteur($this->getUser());
				$listEquipes = $intervention->getEquipes();
				foreach( $listEquipes as $i => $equipe){
					$equipe->addIntervention($intervention);
					$intervention->setDateAssignation(new \DateTime);
				}
				$em = $this->getDoctrine()->getManager();
				$em->persist($intervention);
				$em->flush();
				$notificator = $this->container->get('mdy_gst.notificator');
				$notificator->notify($intervention);
				$this->get('session')->getFlashBag()->add('confirm', 'Demande enregistrée avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_viewIntervention', array('id' => $intervention->getId())));
			}
		}
		return $this->render('MdyGstBundle:Gst:Intervention/add.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_SUPERVISEUR')")
	*/
	public function deleteAction(Intervention $intervention, Request $request){
		$form = $this->createFormBuilder()->getForm();
		if( $request->getMethod() == "POST" ){
			$form->bind($request);
			if( $form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$intervention->setDeletedAt(new \DateTime());
				$em->persist($intervention);
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Demande supprimée avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_listIntervention'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Intervention/delete.html.twig', array( 'intervention' => $intervention, 'form' => $form->createView() ));
	}
	
	/**
	*@Security("has_role('ROLE_SUPERVISEUR')")
	*/
	public function exportAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$listIntervention = $em->getRepository('MdyGstBundle:Intervention')->getExport();
		foreach( $listIntervention as $i => $intervention){
			$intervention->setPrinted(new \DateTime());
		}
		$em->flush();
		return $this->render('MdyGstBundle:Gst:Intervention/export.html.twig', array('listIntervention' => $listIntervention));
	}
	
	public function printAction(Request $request, Intervention $intervention){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository('MdyGstBundle:Intervention')->find($intervention->getId());
		$intervention->setPrinted(new \DateTime());
		$em->flush();
		return null;
	}
	
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function editAction(Intervention $intervention, Request $request){
		$em = $this->getDoctrine()->getManager();
		$form = $this->get('form.factory')->create(new InterventionEditType($this->getDoctrine()->getManager()), $intervention);
		$anciennesEquipes = new ArrayCollection();
		foreach($intervention->getEquipes() as $equi){
			$anciennesEquipes->add($equi);
		}
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if ($form->isValid()) {
				$listEquipes = $intervention->getEquipes();
				foreach( $anciennesEquipes as $i => $aequipe){
					// $this->get('session')->getFlashBag()->add('info', 'valeur de anciennesEquipes :'.$aequipe->getNom());
					if( !$listEquipes->contains($aequipe)){
						$intervention->removeEquipe($aequipe);
						$aequipe->removeIntervention($intervention);
					}
				}
				foreach( $listEquipes as $i => $equipe){
					if( !$anciennesEquipes->contains($equipe)){
						// $request->getSession()->getFlashBag()->add('info', 'valeur de listEquipes :'.$equipe->getNom());
						$equipe->addIntervention($intervention);
					}
				}
				if( $listEquipes->isEmpty() ){
					// $request->getSession()->getFlashBag()->add('info', 'La liste équipes est vide');
					$intervention->setDateAssignation(null);
				}else{
					$intervention->setDateAssignation(new \DateTime());
				}
				$listFichiers = $intervention->getFichiers();
				foreach( $listFichiers as $i => $fichier){
					$fichier->setIntervention($intervention);
				}
				$em->persist($intervention);
				$em->flush();
				$this->get('session')->getFlashBag()->add('confirm', 'Intervention modifiée avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_viewIntervention', array('id' => $intervention->getId())));
			}
		}
		return $this->render('MdyGstBundle:Gst:Intervention/edit.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_SUPERVISEUR')")
	*/
	public function assignationAction($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository('MdyGstBundle:Intervention')->find($id);
		$form = $this->get('form.factory')->create(new InterventionAssignationType, $intervention);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$listEquipes = $intervention->getEquipes();
				foreach( $listEquipes as $i => $equipe){
					$equipe->addIntervention($intervention);
				}
				if( $listEquipes != null){
					$intervention->setDateAssignation(new \DateTime());
				}
				$em->persist($intervention);
				$em->flush();
				$request->getSession()->getFlashBag()->add('info', 'Assignation effectuée avec succès !');
				return $this->redirect($this->generateUrl('mdy_gst_listIntervention'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Intervention/assignation.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_APPROBATEUR')")
	*/
	public function approbationAction(Intervention $intervention, Request $request){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository('MdyGstBundle:Intervention')->find($intervention->getId());
		$approbation = new Approbation();
		$approbation->setIntervention($intervention);
		/* Initialisation de la date de l'approbation à la date NOW() */
		$approbation->setDateApprobation(new \DateTime());
		/* Assignation du ROLE_ de l'utilisateur réalisant l'approbation */
		if( $this->get('security.context')->isGranted('ROLE_DIRECTEUR')){
			$approbation->setRoleApprobateur('ROLE_DIRECTEUR');
		}
		elseif( $this->get('security.context')->isGranted('ROLE_ECHEVIN')){
			$approbation->setRoleApprobateur('ROLE_ECHEVIN');
		}
		$user = $this->get('security.context')->getToken()->getUser();
		$approbation->setUser($user);
		$form = $this->get('form.factory')->create(new ApprobationType, $approbation);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$request->getSession()->getFlashBag()->add('confirm', 'La demande a été approuvée avec succès !');
				$em->persist($approbation);
				$em->flush();
				return $this->redirect($this->generateUrl('mdy_gst_listIntervention'));
			}
			else{
				$request->getSession()->getFlashBag()->add('error', 'Le formulaire n\'est pas valide !');
			}
		}
		$request->getSession()->getFlashBag()->add('info', 'Valeur de approbation::intervention: ['.$approbation->getIntervention()->getNumero().']');
		return $this->render('MdyGstBundle:Gst:Intervention/approbation.html.twig', array('form' => $form->createView(), 'intervention' => $approbation->getIntervention()));
	}
	
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function clotureAction(Intervention $intervention, Request $request){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository('MdyGstBundle:Intervention')->find($intervention->getId());
		$cloture = new Cloture();
		$cloture->setIntervention($intervention->getId());
		$cloture->setDateCloture(new \DateTime());
		$form = $this->get('form.factory')->create(new ClotureType($intervention->getId()), $cloture);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$cloture->setIntervention($intervention);
				$em->persist($intervention);
				$em->persist($cloture);
				$em->flush();
				return $this->redirect($this->generateUrl('mdy_gst_searchIntervention'));
			}
		}
		return $this->render('MdyGstBundle:Gst:Intervention/cloture.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_USER')")
	*/
	public function listAction($filter, $equipe, $page, Request $request){
		$em = $this->getDoctrine()->getManager();
		$security = $this->get('security.context');
		$listIntervention = null;
		$listEquipes = null;
		$filterEquipe = $equipe;
		$listEquipes = $em->getRepository("MdyGstBundle:Equipe")->findAll();
		if( $security->isGranted("ROLE_APPROBATEUR")){
			if( $security->isGranted('ROLE_DIRECTEUR')){
				$listIntervention = $em->getRepository("MdyGstBundle:Intervention")->myFindAll($filter, $filterEquipe, $this->nombreParPage, $page, "ROLE_DIRECTEUR");
			}
			elseif( $security->isGranted('ROLE_ECHEVIN')){
				$listIntervention = $em->getRepository("MdyGstBundle:Intervention")->myFindAll($filter, $filterEquipe, $this->nombreParPage, $page, "ROLE_ECHEVIN");
			}
		}
		elseif( $security->isGranted("ROLE_SUPERVISEUR") ){
			$listIntervention = $em->getRepository("MdyGstBundle:Intervention")->myFindAll($filter, $filterEquipe, $this->nombreParPage, $page, "ROLE_SUPERVISEUR");
		}
		elseif( $security->isGranted("ROLE_USER") ){
			$listIntervention = $em->getRepository("MdyGstBundle:Intervention")->myFindAll($filter, $filterEquipe, $this->nombreParPage, $page, "ROLE_REDACTEUR");
		}
		if( !$request->isXmlHttpRequest() ){
			return $this->render('MdyGstBundle:Gst:Intervention/list.html.twig', array('listIntervention' => $listIntervention,
																					'listEquipes' => $listEquipes,
																					'equipeFiltre' => $equipe,
																					'page' => $page,
																					'nombrePage' => ceil(count($listIntervention) / $this->nombreParPage),
																					'filtre' => $filter));
		}
		else{
			return $this->render('MdyGstBundle:Gst:Intervention/list.ajax.twig', array('listIntervention' => $listIntervention,
																					'listEquipes' => $listEquipes,
																					'equipeFiltre' => $equipe,
																					'page' => $page,
																					'nombrePage' => ceil(count($listIntervention) / $this->nombreParPage),
																					'filtre' => $filter));
		}
	}
	
	/**
	*@Security("has_role('ROLE_USER')")
	*/
	public function viewAction(Intervention $intervention){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository("MdyGstBundle:Intervention")->find($intervention->getId());
		if( $intervention === null or empty($intervention)){
			throw new NotFoundHttpException("La demande [".$id."] n'a pas été trouvée.");
		}
		$suivant = $em->getRepository("MdyGstBundle:Intervention")->getNext($intervention);
		$precedent = $em->getRepository("MdyGstBundle:Intervention")->getPrevious($intervention);
		return $this->render('MdyGstBundle:Gst:Intervention/view.html.twig', array('intervention' => $intervention, 'suivant' => $suivant, 'precedent' => $precedent));
	}
	
	/**
	*@Security("has_role('ROLE_USER')")
	*/
	public function rechercheAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$listIntervention = null;
		$intervention = $request->get('mdy_gstbundle_intervention_search');
		$form = $this->get('form.factory')->create(new InterventionSearchType);
		if( $request->getMethod() == "POST"){
			$form->bind($request);
			$listIntervention = $em->getRepository("MdyGstBundle:Intervention")->findByParameter($intervention);
			// $request->getSession()->getFlashBag()->add('info', 'valeur de lowerDate :'.var_dump($intervention['lowerDate']));
			// $request->getSession()->getFlashBag()->add('info', 'valeur de upperDate :'.var_dump($intervention['upperDate']));
		}
		return $this->render('MdyGstBundle:Gst:Intervention/search.html.twig', array('listInterventions' => $listIntervention,
																					'form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_REDACTEUR')")
	*/
	public function deleteFichierAction(Fichier $fichier, Intervention $intervention){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository("MdyGstBundle:Intervention")->find($intervention->getId());
		$intervention->removeFichier($fichier);
		$em->flush();
		return $this->redirect($this->generateUrl('mdy_gst_viewIntervention', array('id' => $intervention->getId())));
	}
}
