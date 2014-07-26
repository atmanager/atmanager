<?php

namespace ATManager\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlaSectorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigointerno','text', array('label' => 'Código Interno'))
            ->add('nombre','text', array('label' => 'Nombre'))
	    ->add('submit', 'submit', array('label' => 'Aceptar'));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\BackendBundle\Entity\AlaSector'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_backendbundle_alasector';
    }
}
