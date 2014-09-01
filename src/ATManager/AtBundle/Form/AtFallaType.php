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

//select * from falla_sector fs inner join Falla f on fs.falla_id=f.id where fs.sector_id=1
       $sector =  $this->opciones;
       echo "sector: ".$sector->getId();

        $builder
                
            ->add('falla','entity', array(
                'label'=>'Falla tipificada : ',
                'class' => 'BackendBundle:Falla',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                     ->innerJoin('s.tipo','t', 'WITH', 't.destino = :destino')
                            ->setParameter('destino',true)
                            ->orderBy('s.nombre','ASC')
                            ;

                        ->orderBy('f.nombre','ASC')
                    ;
                },
            ))



            /* ->add('sectordestino','entity', 
                array(
                        'label'=>'[*] Para sector técnico : ',
                        'class' => 'BackendBundle:Sector',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('s')
                            ->innerJoin('s.tipo','t', 'WITH', 't.destino = :destino')
                            ->setParameter('destino',true)
                            ->orderBy('s.nombre','ASC')
                            ;
                        },
            ))*/

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
