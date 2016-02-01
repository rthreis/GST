<?php
/**
*@Author: 		R. Threis
*@Since:		
*@Last update:	20150702
*@File:			/src/Mdy/GstBunble/Controller/RemarqueController.php
*/
namespace Mdy\GstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Mdy\GstBundle\Entity\Remarque;
use Mdy\GstBundle\Entity\Intervention;
use Mdy\GstBundle\Form\RemarqueType;

class RemarqueController extends Controller
{
	/**
	*@Security("has_role('ROLE_USER')")
	*/
	public function addAction(Request $request, Intervention $intervention){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository('MdyGstBundle:Intervention')->find($intervention->getId());
		if( $intervention == null){
			throw new NotFoundHttpException("La demande [".$id."] n'a pas été trouvée.");
		}
		$remarque = new Remarque();
		$remarque->setIntervention($intervention);
		$user = $this->container->get('security.context')->getToken()->getUser();
		$remarque->setAuteur($user);
		$form = $this->get('form.factory')->create(new RemarqueType, $remarque);
		if( $request->getMethod() == 'POST'){
			$form->bind($request);
			if( $form->isValid()){
				$this->get('session')->getFlashBag()->add('confirm', 'La remarque a été ajoutée avec succès !');
				$em->persist($remarque);
				$em->flush();
				return $this->redirect($this->generateUrl('mdy_gst_listIntervention'));
			}
			else{
				$request->getSession()->getFlashBag()->add('info', 'Le formulaire n\'est pas valide !');
			}
		}
		return $this->render('MdyGstBundle:Gst:Remarque/add.html.twig', array('form' => $form->createView()));
	}
	
	public function deleteAction($id){
		return $this->render('MdyGstBundle:Gst:Remarque/delete.html.twig');
	}
	
	public function editAction($id){
		return $this->render('MdyGstBundle:Gst:Remarque/edit.html.twig');
	}
	
	public function listAction(){
		return $this->render('MdyGstBundle:Gst:Remarque/list.html.twig');
	}
}
