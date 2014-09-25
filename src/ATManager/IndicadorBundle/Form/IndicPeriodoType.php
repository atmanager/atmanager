<?php

namespace ATManager\IndicadorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class IndicPeriodoType extends AbstractType
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
            ->add('Aceptar','submit')
            ->add('exportar', 'checkbox', array(
                  'label'     => 'Exportar resultado a CSV',
                  'required'  => false,
            ));



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
        return 'atmanager_indicperiodo';
    }
}
