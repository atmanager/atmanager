<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;



class AtBuscadorInicialType extends AbstractType
{

    function __construct() {
        
    }

    
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
                        'label'=>'Estadio: ',
                        'class'=>'BackendBundle:Estadio',
                        'required'=>false,
                        'empty_value'=>'Selecccione Estadio [*]',
                        'query_builder'=>function(EntityRepository $er)
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
