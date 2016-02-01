<?php
/**
 * File :	ApprobationType.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Form
 * Since :	--
 * Update :	13/10/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ApprobationType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('Approuver', 'submit');
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\GstBundle\Entity\Approbation'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_gstbundle_approbation';
	}
}
