<?php
namespace ATManager\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SectorTipoType extends AbstractType {

public function buildForm(FormBuilderInterface $builder, array $options)
{
  $builder
	  ->add('descripcion')
	  ->add('origen')
	  ->add('destino')
	  ->add('Submit','submit',array('label'=>'Guardar'));

}

public function setDefaultsOptions(OptionsResolverInterface $resolver)
{
	$resolver->setDefaults(array(
		'data_class' => 'ATManager\BackendBundle\Entity\SectorTipo'
		));

}

public function getName()
{
	return 'Form_SectorTipo';
}

}

