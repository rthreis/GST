<?php
/**
*@Author: 		R. Threis
*@Since:		20150716
*@Last update:	20150716
*@File:			/src/Mdy/GstBunble/Controller/StatisticController.php
*/
namespace Mdy\GstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Mdy\GstBundle\Entity\Equipe;
use Mdy\GstBundle\Entity\Lieu;
use Mdy\GstBundle\Entity\Intervention;
use Mdy\GstBundle\Form\RemarqueType;

class StatisticController extends Controller
{
	public function statsAction(Request $request){
		
		return $this->render('MdyGstBundle:Gst:Statistic/stats.html.twig');
	}
	
	public function calculateAction(Request $request){
		if( $request->isXmlHttpRequest() and $request->getMethod() === "POST"){
			$filtre = $request->request->get('filtre');
			$em = $this->getDoctrine()->getManager();
			$stats = null;
			if( $filtre == 'inli'){
				$stats = $em->getRepository("MdyGstBundle:Intervention")->statInLi();
			}
			elseif( $filtre == 'ineq'){
				$stats = $em->getRepository("MdyGstBundle:Equipe")->statInEq();
			}
			elseif( $filtre == 'eqli'){
				$stats = $em->getRepository("MdyGstBundle:Intervention")->statEqLi();
			}
			return $this->render('MdyGstBundle:Gst:Statistic/stats.ajax.twig', array ('stats' => $stats, 'filtre' => $filtre));
		}
		else{
			return "Accès illégal";
		}
	}
}