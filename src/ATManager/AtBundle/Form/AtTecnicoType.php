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

class AtTecnicoType extends AbstractType
{

    private $sector;

    public function __construct($sector)
    { $this->sector=$sector;}
    
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            
        $sec=$this->sector;

           
        $builder
             ->add('tecnico','entity', array(
                'class' => 'BackendBundle:Tecnico',
                'label'=>'Escoja un nuevo técnico ppal.',
                'query_builder' => function(EntityRepository $er) use ($sec)
                {
                    return $er->createQueryBuilder('t')
                    ->Where('t.sector = :sector')
                    ->setParameter('sector',$sec);
                },
            ))

             ->add('rol','entity', array(
                'label'=>'Escoja una prioridad',
                'class' => 'BackendBundle:Rol',
                'read_only'=>true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r');                                                    ;
                },
                
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
         $resolver->setDefaults(array(
            'data_class' => 'ATManager\AtBundle\Entity\AtTecnico',

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_atbundle_attecnico';
    }

}
