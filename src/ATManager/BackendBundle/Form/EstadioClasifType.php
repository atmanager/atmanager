<?php

namespace ATManager\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstadioClasifType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('iniciaAt')
            ->add('diagnosAt')
            ->add('finalizaAt')
            ->add('cancelaAt')
            ->add('servicioAt')
            ->add('repuestoAt')    
            ->add('submit', 'submit', array('label' => 'Aceptar'));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\BackendBundle\Entity\EstadioClasif'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_backendbundle_estadioclasif';
    }
}
