<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;



class AtBuscadorInicialDeTecnicosType extends AbstractType
{

    function __construct($sector)
    { 
        $this->sector=$sector;
    }

    
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $sectorTecnico = $this->sector;
         $builder                 
                                 
             ->add('estadio','entity',
                    array
                    (
                        'label'=>'Escoja algún [Estadio] para filtrar AT. [Todos] no aplica filtro',
                        'class'=>'BackendBundle:Estadio',
                        'required'=>false,
                        'empty_value'=>'Todos (no aplica filtro)',
                        'query_builder'=>function(EntityRepository $er)
                            {
                            return $er->createQueryBuilder('e')
                                ->select('e')
                                ->orderBy('e.nombre','ASC');
                            }
                        ))

             ->add('tecnico','entity',
                    array
                    (
                        'label'=>'Escoja un tecnico de su sector para filtrar AT',
                        'class'=>'BackendBundle:Tecnico',
                        'required'=>true,
                        'empty_value'=>'Seleccione un técnico de su sector...',
                        'constraints'=>array(new Assert\NotNull()),
                        'query_builder'=>function(EntityRepository $er)use ($sectorTecnico)
                            {
                            return $er->createQueryBuilder('t')
                                ->select('t')
                                ->where('t.sector = :sector')
                                ->setParameter('sector',$sectorTecnico)
                                ->orderBy('t.nombre','ASC');
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
