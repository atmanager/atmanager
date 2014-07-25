<?php

namespace ATManager\PatrimonioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PatrimonioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('responsable')
            ->add('modelo')
            ->add('serial')
            ->add('observacion')
            ->add('precio')
            ->add('clasificacion','entity',
                    array(
                        'class'=>'BackendBundle:PatrimonioClasif',
                        'required'=>false,
                        'empty_value'=>'Selecccione Clasificación [*]'
                    )
            )
            ->add('local','entity',
                    array(
                        'class'=>'BackendBundle:Local',
                        'required'=>false,
                        'empty_value'=>'Seleccione Local [*]'
                    )
            )
            ->add('marca','entity',
                    array
                    (
                        'class'=>'BackendBundle:Marca',
                        'required'=>false,
                        'empty_value'=>'Seleccione Marca [*]'
                    )
            )
            ->add('fechaAlta')
            ->add('estimado',null,array(
                    'required'=>false,
                    'label'=>'Precio es estimado'
                ))
            ->add('estado','entity',
                    array
                    (
                        'class'=>'BackendBundle:EstadoPatri',
                        'required'=>false,
                        'empty_value'=>'Seleccione un Estado de conservación [*]'
                    )
            )
            ->add('submit', 'submit', array('label' => 'Aceptar'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\PatrimonioBundle\Entity\Patrimonio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_patrimoniobundle_patrimonio';
    }
}
