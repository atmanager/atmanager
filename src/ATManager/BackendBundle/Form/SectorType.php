<?php

namespace ATManager\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text', array('label' => 'Nombre: *'))
            ->add('internos','text', array('label' => 'Teléfonos Internos: *'))
            ->add('mail')
            ->add('referente','text', array('label' => 'Referente: *'))
            ->add('tipo')
            ->add('submit', 'submit', array('label' => 'Aceptar'));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\BackendBundle\Entity\Sector'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_backendbundle_sector';
    }
}
