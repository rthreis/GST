<?php

namespace Mdy\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Mdy\UserBundle\Entity\User;
use Mdy\UserBundle\Form\UserType;

class UserController extends Controller
{
	/**
	*@Security("has_role('ROLE_ADMIN')")
	*/
	public function listAction(Request $request){
		$userManager = $this->get('fos_user.user_manager');
		
		$listUsers = $userManager->findUsers();
		
		if( $listUsers == null){
			$request->getSession()->getFlashBag()->add('info', 'Aucun utilisateur trouvé');
			return $this->redirect($this->generateUrl('mdy_core_index'));
		}
		return $this->render('MdyUserBundle:User:list.html.twig', array('listUsers' => $listUsers));
	}
	
	/**
	*@Security("has_role('ROLE_ADMIN')")
	*/
	public function addAction(Request $request){
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->createUser();
		$form = $this->get('form.factory')->create(new UserType, $user);
		if ($form->handleRequest($request)->isValid()) {
			$user->setEnabled(true);
			$userManager->updateUser($user);
			$request->getSession()->getFlashBag()->add('info', 'Utilisateur bien enregistrée.');

			return $this->redirect($this->generateUrl('mdy_user_list'));
		}
		return $this->render('MdyUserBundle:User:add.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_ADMIN')")
	*/
	public function editAction(Request $request, User $user){
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $user->getId()));
		$form = $this->get('form.factory')->create(new UserType, $user);
		if ($form->handleRequest($request)->isValid()) {
			$user->setEnabled(true);
			$userManager->updateUser($user);
			$request->getSession()->getFlashBag()->add('info', 'Utilisateur bien modifié.');

			return $this->redirect($this->generateUrl('mdy_user_list'));
		}
		return $this->render('MdyUserBundle:User:edit.html.twig', array('form' => $form->createView()));
	}
	
	/**
	*@Security("has_role('ROLE_ADMIN')")
	*/
	public function deleteAction(Request $request, User $user){
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $user->getId()));
		$user->setEnabled(false);
		$userManager->updateUser($user);
		return $this->redirect($this->generateUrl('mdy_user_list'));
	}
}
