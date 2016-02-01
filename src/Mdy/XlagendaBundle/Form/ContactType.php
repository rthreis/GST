<?php
/**
 * File :	ContactType.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Form
 * Since :	17/09/2015
 * Update :	17/09/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nom')
			->add('telephone', 'text', array('label' => 'Numéro de téléphone',
									'required' => false))
			->add('phone', 'text', array('label' => 'Numéro de GSM',
								'required' => false))
			->add('email', 'text', array('required' => false))
			->add('Enregistrer', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\XlagendaBundle\Entity\Contact'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_xlagendabundle_contact';
	}
}
