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

class AtBuscadorCasosExitosType extends AbstractType
{
     

    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       
        $builder

         ->add('numero','integer',array(
                'required'=>false,
                'label'=>'Número de AT'
            ))
                
         ->add('falla','entity', array(
                'required'=>false,
                'empty_value'=>'Todas',
                 'label'=>'Seleccione una falla',
                'class' => 'BackendBundle:Falla',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                    ->where('f.estado=true')
                    ->orderBy('f.nombre','ASC')
                    ;
                },
            ))



            ->add('descripcion','text', array(
              'label' => 'Ingrese sintomas/motivos para buscar casos similares',
               'required'=>false  

            ))

          /*  ->add('chkfalla','checkbox', array(
              'label' => 'Falla',
               'required'=>false  

            ))   

              ->add('chksintoma','checkbox', array(
              'label' => 'Sintoma',
               'required'=>false  

            )) */            
                       
            ->add('submit', 'submit', array(
                'label' => 'Aceptar'
            ));     
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
        return 'atmanager_atbundle_buscadorCasos';
    }

}
