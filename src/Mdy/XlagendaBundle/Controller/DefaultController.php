<?php
/**
 * File :	DefaultController.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlAgendaBundle/Controller
 * Since :	06/08/2015
 * Update :	07/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MdyXlagendaBundle:Default:index.html.twig', array('name' => $name));
    }
	
	public function menuAction(){
		return $this->render('MdyXlagendaBundle::menu.html.twig');
	}
}
