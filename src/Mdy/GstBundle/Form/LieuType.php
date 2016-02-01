<?php
/**
 * File :	LieuType.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Form
 * Since :	--
 * Update :	28/08/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Form;

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
			->add('nom')
			->add('rue', 'text', array('required' => false))
			->add('numero', 'text', array('required' => false))
			->add('codePostal')
			->add('localite')
			->add('remember', 'choice', array('choices' => array(0 => "NON", 1 => "OUI"),
												'label' => "Proposer dans la liste ?"))
			->add('Ajouter', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\GstBundle\Entity\Lieu'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_gstbundle_lieu';
	}
}
