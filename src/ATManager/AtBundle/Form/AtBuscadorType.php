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
            ->add('numero','integer',array(
                'required'=>false
            ))  // ver Form Types Reference Symfony.com (2.5)

            ->add('descripcion','text',array(
                'required'=>false,
                'label'=>'Descripción'
            ))

            ->add('observacion','text',array(
                'required'=>false,
                'label'=>'Algún dato de observación...'

            ))

            ->add('serial','text',array(
                'required'=>false,
                'label'=>'Serie'

            ))

            ->add('clasificacion','entity',array(
                'class'=>'BackendBundle:PatrimonioClasif',
                'required'=>false,
                'empty_value'=>'Selecccione Clasificación [*]'
            ))// ver Form Types Reference Symfony.com (2.5)
            ->add('local','entity',array(
                'class'=>'BackendBundle:Local',
                'required'=>false,
                'empty_value'=>'Seleccione Local [*]'
            ))
            ->add('marca','entity',array(
                'class'=>'BackendBundle:Marca',
                'required'=>false,
                'empty_value'=>'Seleccione Marca [*]'
            ))
            ->add('filtrar','submit')
            ->add('exportar','submit')
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
