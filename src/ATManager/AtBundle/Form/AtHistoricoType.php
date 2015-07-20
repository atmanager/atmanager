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
use Symfony\Component\Validator\Constraints as Assert;

class AtHistoricoType extends AbstractType
{

    private $arrayEstadios;
    private $at;
    private $em;

    public function __construct($at, $em, $arrayEstadios, $sector)
    { 
      $this->arrayEstadios=$arrayEstadios; 
      $this->at=$at; 
      $this->em=$em; 
      $this->sector=$sector;
    }

     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $arrayEstadios = $this->arrayEstadios;
            $sector = $this->sector;
           
        $builder
            ->add('fecha',null, array(
                'label'=>'Fecha de Evolución: ',
                'disabled' =>true,
            )) 

             ->add('estadio', null, array(
                'choices' => $arrayEstadios,
                'required' => true,
                'multiple' => false,
                'label' => 'estadio',                                  
            ))

              ->add('tecnico','entity',
                    array
                    (
                        'label'=>'Escoja un tecnico de su sector para Reasignar este estadio (asumirá con Rol principal)',
                        'class'=>'BackendBundle:Tecnico',
                        'required'=>false,
                        'empty_value'=>'Seleccione un técnico de su sector (no obligatorio)',
                        'query_builder'=>function(EntityRepository $er)use ($sector)
                            {
                            return $er->createQueryBuilder('t')
                                ->select('t')
                                ->where('t.sector = :sector')
                                ->setParameter('sector',$sector)
                                ->orderBy('t.nombre','ASC');
                            }
                        )) 



            ->add('comentario','textarea',array(
                'label'=>'Describa que tareas realiza para cumplir con este estadio :',
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
            'data_class' => 'ATManager\AtBundle\Entity\AtHistorico',

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_atbundle_athistorico';
    }

}
