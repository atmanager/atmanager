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
                
            ->add('falla','entity', array(
                'required'=>false,
                'empty_value'=>'escoja una falla para puntualizar su busqueda',
                'class' => 'BackendBundle:Falla',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                    ->orderBy('f.nombre','ASC')
                    ;
                },
            ))

            ->add('descripcion','text', array(
              'label' => 'Ingrese sintomas para buscar casos similares',
               'required'=>false  

            ))       
                       
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
