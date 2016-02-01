<?php
/**
 * File :	InterventionClotureType.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Form/
 * Since :	--
 * Update :	05/10/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mdy\GstBundle\Entity\EquipeRepository;

class InterventionClotureType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('objet', 'text', array('read_only'=>true))
			->add('contenu', 'textarea', array('read_only' => true))
			->add('dateCloture', 'date')
			->add('complement', 'textarea', array('required'=>false,
												'label' => 'Travaux complémentaires effectués'))
			->add('duree', 'text', array("required"=>false,
										'label' => 'Durée estimative'))
			->add('nbOuvrier', 'text', array("required"=>false,
										'label' => 'Nombre d\'ouvriers'))
			->add('Cloture', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\GstBundle\Entity\intervention'
		));
	}

	/**
	 * @return string
	 */
	public function getName(){
		return 'mdy_gstbundle_intervention_cloture';
	}
}
