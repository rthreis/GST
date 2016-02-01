<?php
/**
 * File :	InterventionEditType.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Form
 * Since :	---
 * Update :	01/10/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Mdy\GstBundle\Entity\LieuRepository;

class InterventionEditType extends AbstractType
{
	protected $em;
	
	
	public function __construct(\Doctrine\ORM\EntityManager $em) 
	{
		$this->em = $em;
	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('lieu', 'entity', array('class' => 'MdyGstBundle:Lieu',
						'property' => 'nom',
						'query_builder' => function(LieuRepository $repo){
							return $repo->findAll();
						}))
			->remove('Ajouter la demande')
			->add('Enregistrer les modifications', 'submit')
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
		return 'mdy_gstbundle_intervention_edit';
	}
	
	public function getParent(){
		return new InterventionType($this->em);
	}
}
