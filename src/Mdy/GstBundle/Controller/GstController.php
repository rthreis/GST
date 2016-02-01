<?php
/**
*@Author: 		R. Threis
*@Since:		
*@Last update:	20150702
*@File:			/src/Mdy/GstBunble/Controller/GstController.php
*/
namespace Mdy\GstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GstController extends Controller
{
	/**
	*@Security("has_role('ROLE_USER')")
	*/
	public function indexAction(){
		return $this->render('MdyGstBundle:Gst:index.html.twig');
	}
	
	public function menuAction(){
		return $this->render('MdyGstBundle:Gst:menu.html.twig');
	}
}
