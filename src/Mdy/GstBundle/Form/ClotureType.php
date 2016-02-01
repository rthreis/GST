<?php
/**
 * File :	ClotureType.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Form
 * Since :	23/12/2015
 * Update :	01/02/2016
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mdy\GstBundle\Entity\EquipeRepository;

class ClotureType extends AbstractType
{
	private $idIntervention;
	public function __construct($idIntervention = null) {
		$this->idIntervention = $idIntervention;
	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('equipe', 'entity', array(
									'class' => 'MdyGstBundle:Equipe',
									'property' => 'nom',
									'query_builder' => function(EquipeRepository $repo){
										return $repo->findEquipes($this->idIntervention);
									}))
			->add('dateCloture', 'date')
			->add('travaux', 'textarea', array('label' => 'Travaux complémentaires effectués'))
			->add('duree', 'text', array('label' => 'Durée estimative'))
			->add('nbOuvrier', 'text', array('label' => 'Nombre d\'ouvrier'))
			->add('intervention', 'hidden' )
			->add('Clôturer la note', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Mdy\GstBundle\Entity\Cloture'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mdy_gstbundle_cloture';
	}
}
