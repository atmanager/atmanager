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

class AtServicioType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha','date',array(
                'label'=>'Fecha de Transacción'
            ))    
            ->add('serviciotercero','entity', array(
                'label'=>'Servicio Tercero : ',
                'class' => 'BackendBundle:ServicioTercero',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('st')
                        ->orderBy('st.nombre','ASC')
                    ;
                },
            ))
            ->add('proveedor','entity', array(
                'label'=>'Proveedor : ',
                'class' => 'BackendBundle:Proveedor',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nombre','ASC')
                    ;
                },
            ))             
            ->add('precio')
            ->add('contacto')
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
        return 'atmanager_atbundle_atserviciotercero';
    }

}
