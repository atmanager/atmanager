<?php

namespace ATManager\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepuestoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripamplia','text', array('label' => 'Descripción Amplia'))
            ->add('comentario')
	    ->add('clasif','entity', array(
                  'class'=>'BackendBundle:RepuestoClasif',
                  'query_builder'=>function($er){
                                                 return $er->createQueryBuilder('rc')
                                                 ->select('rc')
                                                 ->orderBy('rc.nombre','ASC'); 
            }))
            ->add('submit', 'submit', array('label' => 'Aceptar'));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\BackendBundle\Entity\Repuesto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_backendbundle_repuesto';
    }
}
