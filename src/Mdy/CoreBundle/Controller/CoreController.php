<?php

namespace Mdy\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
	public function indexAction(){
		return $this->render('MdyCoreBundle:Core:index.html.twig');
	}
	
	public function menuAction(){
		return $this->render('MdyCoreBundle:Core:menu.html.twig');
	}
}
