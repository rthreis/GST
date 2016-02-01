<?php
/**
 * File :	ContactImbricType.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Form
 * Since :	23/11/2015
 * Update :	23/11/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ContactImbricType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->remove('Enregistrer')
		;
		
		// $factory = $builder->getFormFactory();
		// $builder->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event){
																// $evenement = $event->getData();
																// $form = $event->getForm();
																// if( $evenement->getAffiche() != null){
																	// $form->remove('affiche');
																	// $form->add('affiche', 'button', array('label' => 'Supprimer l\'affiche'));
																// }
															// }
									// );
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\XlagendaBundle\Entity\Contact'
		));
	}

	/**
	 * @return string
	 */
	public function getName(){
		return 'mdy_xlagendabundle_contact_imbric';
	}
	
	public function getParent(){
		return new ContactType();
	}
}
