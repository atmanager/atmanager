<?php

namespace ATManager\IndicadorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class IndicEstadioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $actual=date ("Y");
        $builder
            ->add('fechadesde','date',array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'years' => range(2004,$actual)
            ))
            ->add('fechahasta','date', array(
                    'data' => new \DateTime()
            ))
            ->add('estadio','entity',array(
                    'class'=>'BackendBundle:Estadio',
                    'required'=>true,
                    'query_builder'=>function($er){
                        return $er->createQueryBuilder('e')
                            ->select('e')
                            ->orderBy('e.nombre','ASC');
                    }
            ))

            ->add('sector','entity',array(
                    'label'=>'Sector de Destino : ',
                    'class' => 'BackendBundle:Sector',
                    'query_builder' => function($er) {
                        return $er->createQueryBuilder('s')
                            ->innerJoin('s.tipo','t', 'WITH', 't.destino = :destino')
                            ->setParameter('destino',true)
                            ->orderBy('s.nombre','ASC')
                        ;
                    }           
            ))  

            ->add('Aceptar','submit');



             $validarRangoFechas = function(FormEvent $event)
            {
            $form = $event->getForm();
            $fechadesde = $form->get('fechadesde')->getData();
            $fechahasta = $form->get('fechahasta')->getData();
                 if ($fechahasta < $fechadesde)
                 {
                    $form['fechahasta']->addError(new FormError("fecha Hasta debe ser mayor o igual a Fecha Desde"));
                 }
        };
        $builder->addEventListener(FormEvents::POST_BIND, $validarRangoFechas); 
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_indicestadio';
    }
}