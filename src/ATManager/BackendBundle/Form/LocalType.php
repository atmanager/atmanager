<?php
namespace ATManager\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class LocalType extends AbstractType {

public function buildForm(FormBuilderInterface $builder, array $options)
{
  $builder
	  ->add('nombre')
	  ->add('codigointerno')
	  ->add('alasector','entity', array(
                  'class'=>'BackendBundle:AlaSector',
                  'query_builder'=>function($er){
                        	return $er->createQueryBuilder('al')
                             		->select('al')
                                      	->orderBy('al.codigointerno','ASC'); 
            }))
	  ->add('Submit','submit',array('label'=>'Aceptar'));

}

public function setDefaultsOptions(OptionsResolverInterface $resolver)
{
	$resolver->setDefaults(array(
		'data_class' => 'ATManager\BackendBundle\Entity\Local'
		));

}

public function getName()
{
	return 'Form_Local';
}

}

