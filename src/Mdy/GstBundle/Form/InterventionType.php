<?php
/**
 * File :	InterventionType.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Form
 * Since :	01/06/2015
 * Update :	18/09/2015
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Mdy\GstBundle\Entity\LieuRepository;
use Mdy\GstBundle\Entity\EquipeRepository;
use Mdy\GstBundle\Entity\InterventionRepository;

class InterventionType extends AbstractType
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
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('numero', 'text', array('max_length' => 10))
			->add('objet', 'text', array('max_length' => 255, 'required' => false))
			->add('contenu', 'textarea')
			->add('demandeur', 'text', array('max_length' => 255))
			->add('contact', 'text', array('max_length' => 255, 'required' => false, 'label' => 'Données de contact (téléphone / GSM / ...)'))
			->add('dateDemande', 'date')
			->add('accDirReq', 'choice', array('required'=>true, 'label' => 'Requiert approbation de la directrice', 'choices' => array(0 => 'NON', 1 => 'OUI')))
			->add('accEchReq', 'choice', array('required'=>true, 'label' => 'Requiert approbation de l\'échevin', 'choices' => array (0 => 'NON', 1 => 'OUI')))
			->add('equipes', 'entity', array(
						'class' => 'MdyGstBundle:Equipe',
						'property' => 'nom',
						'expanded' => true,
						'multiple' => true,
						'query_builder' => function(EquipeRepository $repoE){
							return $repoE->findForSelect();
						}
					))
			->add('lieu', 'entity', array(
						'class' => 'MdyGstBundle:Lieu',
						'property' => 'nom',
						'query_builder' => function(LieuRepository $repo){
						return $repo->findForSelect();
						}
					))
			->add('addLieu', 'button', array('label' => '+', 'attr' => array('title' => 'Ajouter un lieu', 'data-toggle'=>'modal', 'data-target' => '#myModal')))
			->add('fichiers', 'collection', array(
						'type' => new FichierType(),
						'allow_add' => true,
						'prototype' => true
					))
			->add('Ajouter la demande', 'submit')
			->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
															$intervention = $event->getData();
															if( !$intervention || $intervention->getId() === null){
																$lastNumero = $this->em->getRepository('MdyGstBundle:Intervention')->getLastNumero();
																$intervention->setNumero($lastNumero);
															}
														})
		;
		$builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
																		$intervention = $event->getData();
																		$form = $event->getForm();
																		if( $intervention ){
																			$form->add('lieu', 'entity', array(
																						'class' => 'MdyGstBundle:Lieu',
																						'property' => 'nom',
																						'query_builder' => function(LieuRepository $repo){
																							return $repo->findAll();
																						}
																					));
																		}
																	});
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
		return 'mdy_gstbundle_intervention';
	}
}
