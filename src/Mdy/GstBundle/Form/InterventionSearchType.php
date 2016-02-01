<?php

namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mdy\GstBundle\Entity\LieuRepository;
use Mdy\GstBundle\Entity\EquipeRepository;

class InterventionSearchType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('numero', 'text', array('label' => 'Numéro de la demande', 'required' => false))
			->add('objet', 'text', array('max_length' => 255, 'required' => false))
			->add('demandeur', 'text', array('required' => false))
			->add('cloture', 'choice', array('required' => false, 'label' => 'Filtrer les interventions', 'choices' => array(0 => 'Exclure les clôturées', 1 => 'Inclure les clôturées', 2 => 'Uniquement les clôturées'), 'empty_value' => false))
			->add('lowerDate', 'date', array('label' => 'Date de début', 'required' => false, 'input' => 'string', 'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
			->add('upperDate', 'date', array('label' => 'Date de fin', 'required' => false, 'input' => 'string', 'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
			// ->add('equipes', 'entity', array(
						// 'class' => 'MdyGstBundle:Equipe',
						// 'property' => 'nom',
						// 'expanded' => true,
						// 'multiple' => true,
						// 'query_builder' => function(EquipeRepository $repoE){
							// return $repoE->findForSelect();
						// }
					// ))
			// ->add('lieu', 'entity', array(
						// 'class' => 'MdyGstBundle:Lieu',
						// 'property' => 'nom',
						// 'query_builder' => function(LieuRepository $repo){
						// return $repo->findForSelect();
						// }
					// ))
			->add('Rechercher', 'submit')
		;
	}
	
	/**
	 * @return string
	 */
	public function getName(){
		return 'mdy_gstbundle_intervention_search';
	}
}
