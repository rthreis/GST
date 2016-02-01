<?php
// src/Mdy/GstBundle/Form/LieuType.php

namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LieuEditType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->remove('Ajouter')
			->add('Enregistrer', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\GstBundle\Entity\Lieu'
		));
	}

	/**
	 * @return string
	 */
	public function getName(){
		return 'mdy_gstbundle_lieu_edit';
	}
	
	
	public function getParent(){
		return new LieuType();
	}
}
