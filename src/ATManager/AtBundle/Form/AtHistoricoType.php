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

class AtHistoricoType extends AbstractType
{

    private $arrayEstadios;
    private $at;
    private $em;

    public function __construct($at, $em, $arrayEstadios)
    { 
      $this->arrayEstadios=$arrayEstadios; 
      $this->at=$at; 
      $this->em=$em; 
    }

     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $arrayEstadios = $this->arrayEstadios;
            
           
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
