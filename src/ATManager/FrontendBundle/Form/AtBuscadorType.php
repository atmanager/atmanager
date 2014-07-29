<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AtBuscadorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder                 
           ->add('numero')
           ->add('personasolicita','text', array(
            'label'=>'[*] Apellido y Nombre del Solicitante :'
            ))
                       
           ->add('sectorsolicita','entity', array(
                'label'=>'[*] Sector de origen : ',
                'class' => 'BackendBundle:Sector',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                    ->innerJoin('s.tipo','t', 'WITH', 't.origen = :origen')
                    ->setParameter('origen',true)
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
        return 'pb';
    }
}
