<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;



class AtBuscadorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder                 
            ->add('numero','integer',array(
                'required'=>false
            ))

            ->add('personasolicita','text', array(
            'required'=>false,
            'label'=>'[*] Apellido y Nombre del Solicitante :'
            ))

            /*->add('sectorsolicita','entity',array(
            'class'=>'BackendBundle:Sector',
            'required'=>false,
            'empty_value'=>'Selecccione su sector de trabajo'
            ))*/
                       
            ->add('sectorsolicita','entity', array(
                'required'=>false,
                'label'=>'[*] Sector de origen : ',
                'class' => 'BackendBundle:Sector',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                    ->innerJoin('s.tipo','t', 'WITH', 't.origen = :origen')
                    ->setParameter('origen',true)
                    ->orderBy('s.nombre','ASC')
                   ;
                },
            ))

            
            ->add('filtrar','submit')           
            ;
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
        return 'atb';
    }
}
