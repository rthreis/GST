<?php
/**
 * File :	LieuType.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Form
 * Since :	06/08/2015
 * Update :	07/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LieuType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('translations', 'a2lix_translations')
			->add('rue', 'text', array("required" => false))
			->add('numero', 'text', array("required" => false))
			->add('localite', 'text')
			->add('Ajouter', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\XlagendaBundle\Entity\Lieu'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_xlagendabundle_lieu';
	}
}
