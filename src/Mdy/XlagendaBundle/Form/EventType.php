<?php
/**
 * File :	EventType.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Form
 * Since :	06/08/2015
 * Update :	23/11/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Mdy\XlagendaBundle\Entity\LieuRepository;
use Mdy\XlagendaBundle\Entity\RubriqueRepository;

class EventType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('translations', 'a2lix_translations' , array(
															'fields' => array(
																		'nom' => array(
																				'label' => 'Nom',
																				'locale_options' => array(
																									'de' => array(
																											'label' => 'Name'),
																									'nl' => array(
																											'label' => 'Naam'))),
																		'description' => array(
																						'label' => 'Description',
																						'required' => true,
																						'attr' => array(
																							// 'class' => 'tinymce',
																							'type' => 'textarea'),
																						'locale_options' => array(
																											'de' => array(
																													'label' => 'Beschreibung'),
																											'nl' => array(
																													'label' => 'Bescrijvingen')))
																		)
																)
				)
			->add('debut', 'datetime', array('label' => 'Date et heure de début',
											'widget' => 'single_text'
											))
			->add('fin', 'datetime', array('label' => 'Date et heure de fin',
											'widget' => 'single_text',
											'required' => false))
			->add('rubriques', 'entity', array(
						'class' => 'MdyXlagendaBundle:Rubrique',
						'multiple' => true,
						'expanded' => true,
						'query_builder' => function(RubriqueRepository $rr){
							return $rr->findForList();
						}
					))
			->add('lieu', 'entity', array(
						'class' => 'MdyXlagendaBundle:Lieu',
						// 'property' => 'nom',
						'query_builder' => function(LieuRepository $repo){
							return $repo->findForSelect();
						}
					))
			->add('addLieu', 'button', array('label' => 'Ajouter un lieu', 'attr' => array('title' => 'Ajouter un lieu', 'data-toggle'=>'modal', 'data-target' => '#myModal')))
			->add('affiche', new FichierType(), array('label' => "" , 'required' => false))
			->add('lien', 'text', array('label' => 'Adresse du site internet',
										'required' => false))
			// ->add('contacts', 'entity', array('label' => 'Contacts',
											// 'class' => 'MdyXlagendaBundle:Contact',
											// 'property' => 'nom',
											// 'expanded' => false,
											// 'multiple' => true
											// ))
			->add('contacts', 'collection', array('type' => new ContactImbricType(),
													'allow_add' => true,
													'allow_delete' => true))
			// ->add('addContact', 'button', array('label' => 'Ajouter contact', 'attr' => array('title' => 'Ajouter un contact', 'data-toggle'=>'modal', 'data-target' => '#myModal')))
			->add('publication', 'choice', array('required' => false,
													'label' => "Publier l'actualités ?",
													'choices' => array( 1=>"OUI", 0=>"NON")))
			->add('Ajouter', 'submit')
		;
		
		$factory = $builder->getFormFactory();
		$builder->addEventListener(
			FormEvents::PRE_SET_DATA,
			function(FormEvent $event) use ($factory){
				$article = $event->getData();
				if( $article === null){
					return;
				}
			}
			);
		$builder->addEventListener(FormEvents::PRE_SUBMIT,	function(FormEvent $event){
																$evenement = $event->getData();
																$form = $event->getForm();
																if( $evenement ){
																	$form->add('contacts', 'entity', array('label' => 'Contacts',
																				'class' => 'MdyXlagendaBundle:Contact',
																				'property' => 'nom',
																				'expanded' => false,
																				'multiple' => true
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
			'data_class' => 'Mdy\XlagendaBundle\Entity\Event'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_xlagendabundle_event';
	}
}
