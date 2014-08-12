<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;



class AtBuscadorInicialType extends AbstractType
{


    
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder                 
                                 
             ->add('estadio','entity',
                    array
                    (
                        'class'=>'BackendBundle:Estadio',
                        'required'=>false,
                        'empty_value'=>'Seleccione el Estadio en que desea visualizar las AT del su sector',
                        'query_builder'=>function($er)
                            {
                            return $er->createQueryBuilder('e')
                                ->select('e')
                                ->orderBy('e.nombre','ASC');
                            }
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
        return 'buscaEstadio';
    }
}
