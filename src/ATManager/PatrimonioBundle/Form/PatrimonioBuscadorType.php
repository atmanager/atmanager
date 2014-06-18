<?php

namespace ATManager\PatrimonioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PatrimonioBuscadorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion','text',array(
                'required'=>false
            ))  // ver Form Types Reference Symfony.com (2.5)
            ->add('clasificacion','entity',array(
                'class'=>'BackendBundle:PatrimonioClasif',
                'required'=>false,
                'empty_value'=>'Todas...'
            ))// ver Form Types Reference Symfony.com (2.5)
            ->add('local','entity',array(
                'class'=>'BackendBundle:Local',
                'required'=>false,
                'empty_value'=>'Todas...'
            ))
            ->add('marca','entity',array(
                'class'=>'BackendBundle:Marca',
                'required'=>false,
                'empty_value'=>'Todas...'
            ))
            ->add('filtrar','submit')
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pb';
    }
}
