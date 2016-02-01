<?php

namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mdy\GstBundle\Entity\EquipeRepository;

class InterventionAssignationType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('objet', 'text', array('read_only'=>true))
			->add('contenu', 'textarea', array('read_only' => true))
			->add('equipes', 'entity', array(
						'class' => 'MdyGstBundle:Equipe',
						'property' => 'nom',
						'expanded' => true,
						'multiple' => true
					))
			->add('Assigner', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\GstBundle\Entity\intervention'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_gstbundle_intervention_assignation';
	}
}
