<?php
/**
 * File :	RubriqueType.php
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

class RubriqueType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('translations', 'a2lix_translations')
			// , array(
															// 'fields' => array(
																// 'nom' => array(
																	// 'field_type' => 'text',
																	// 'max_length' => 50,
																	// 'label' => "Nom de la rubrique"),
																// 'accroche' => array(
																	// 'field_type' => 'text',
																	// 'max_length' => 255,
																	// 'label' => "Chemin de l'image d'accroche"),
																	// 'required' => false)))
			->add('Ajouter', 'submit')
		;
	}
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\XlagendaBundle\Entity\Rubrique'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_xlagendabundle_rubrique';
	}
}
