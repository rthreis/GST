<?php
/**
 * File :	UserType.php
 * Bundle : MdyUserBundle
 * Path :	src/Mdy/UserBundle/Form
 * Since :	01/07/2015
 * Update :	13/08/2015
 * Author :	R. Threis
 */
namespace Mdy\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nom', 'text', array('max_length' => 75))
			->add('prenom', 'text', array('max_length' => 50))
			->add('langue', 'choice', array('choices' => array('FR' => 'Français',
																'DE' => 'Allemand',
																'NL' => 'Néerlandais'
																),
											'expanded' => true,
											'multiple' => false))
			->add('roles', 'choice', array('choices' => array('ROLE_UTILISATEUR' => 'Utilisateur',
															'ROLE_REDACTEUR' => 'Rédacteur',
															'ROLE_SUPERVISEUR' => 'Superviseur',
															'ROLE_DIRECTEUR' => 'Directeur/trice des travaux',
															'ROLE_ECHEVIN' => 'Echevin(e) des travaux',
															'ROLE_APPROBATEUR' => 'Approbateur',
															'ROLE_ADMIN' => 'Administrateur'
															),
											'expanded' => true,
											'multiple' => true))
			->add('Enregistrer', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\UserBundle\Entity\User'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_userbundle_add';
	}
	
	public function getParent(){
		return 'fos_user_registration';
	}
}
