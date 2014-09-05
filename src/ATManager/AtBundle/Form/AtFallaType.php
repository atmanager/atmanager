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

class AtFallaType extends AbstractType
{
     

    protected $opciones;

    public function __construct ($opciones)
    {
        $this->opciones = $opciones;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $sector =  $this->opciones;
        $builder
                
            ->add('falla','entity', array(
                'label'=>'Falla tipificada : ',
                'class' => 'BackendBundle:Falla',
                'query_builder' => function(EntityRepository $er) use ($sector) {
                    return $er->createQueryBuilder('f')
                    ->innerJoin('f.sector','cs','WITH','cs.id= :sector')
                    ->setParameter('sector',$sector)
                    ->orderBy('f.nombre','ASC')
                    ;
                },
            ))


            ->add('rol','entity', array(
                'label'=>'Jerarquia de la falla : ',
                'class' => 'BackendBundle:Rol',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        
                        ->orderBy('r.nombre','ASC')

                    ;
                },
            ))             
                       
            ->add('submit', 'submit', array('label' => 'Aceptar'));     
    }
     
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

          $resolver->setDefaults(array(
            'data_class' => 'ATManager\AtBundle\Entity\AtFalla'

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_atbundle_atfalla';
    }

}
