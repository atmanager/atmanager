<?php

namespace ATManager\IndicadorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class IndicServicioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $actual=date("Y");
        $builder
            ->add('fechadesde','date',array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'years' => range(2004,$actual)
            ))
             ->add('fechahasta','date', array(
                    'data' => new \DateTime()
            ))
            ->add('sertercero','entity', array(
                'label'=>'Seleccione Servicio Tercero: ',
                'class' => 'BackendBundle:ServicioTercero',
                'required'=>false,
                'empty_value'=>'Todos...',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('st')
                        ->orderBy('st.nombre','ASC')
                    ;
                },
            ))  
            ->add('Aceptar','submit')
             ->add('exportar', 'checkbox', array(
                  'label'     => 'Exportar resultado a CSV',
                  'required'  => false,
            ));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_indicperiodo';
    }
}