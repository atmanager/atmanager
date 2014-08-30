<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ATManager\AtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AtRepuestoType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha')
            ->add('numfac')
            ->add('proveedor','entity', array(
                'label'=>'Proveedor : ',
                'class' => 'BackendBundle:Proveedor',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nombre','ASC')
                    ;
                },
            ))
            ->add('repuesto','entity', array(
                'label'=>'Repuesto : ',
                'class' => 'BackendBundle:Repuesto',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre','ASC')
                    ;
                },
            ))
            ->add('cant')
            ->add('preciounit')
            ->add('comentario')
             
                               
            ->add('submit', 'submit', array('label' => 'Aceptar'));     
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
        return 'atmanager_atbundle_atrepuesto';
    }
}