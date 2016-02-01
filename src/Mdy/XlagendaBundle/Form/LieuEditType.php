<?php
/**
 * File :	LieuEditType.php
 * Bundle : MdyXlagendaBundle
 * Path :	src/Mdy/XlagendaBundle/Form
 * Since :	11/08/2015
 * Update :	11/08/2015
 * Author :	R. Threis
 */
namespace Mdy\XlagendaBundle\Form;

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
			'data_class' => 'Mdy\XlagendaBundle\Entity\Lieu'
		));
	}

	/**
	 * @return string
	 */
	public function getName(){
		return 'mdy_xlagendabundle_lieu_edit';
	}
	
	
	public function getParent(){
		return new LieuType();
	}
}
