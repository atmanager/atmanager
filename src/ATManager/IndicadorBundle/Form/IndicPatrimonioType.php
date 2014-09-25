<?php

namespace ATManager\IndicadorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ATManager\FrontendBundle\Form\DataTransformer\PatrimonioToNumberTransformer;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints as Assert;

class IndicPatrimonioType extends AbstractType
{
    private $em;
    public function __construct($em) {
        $this->em=$em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $actual=date("Y");
        $etm = $this->em;
        $transformer = new PatrimonioToNumberTransformer($etm);
        
         $builder        
            ->add(
                $builder->create('patrimonio', 'text', array(
                    'required'=>true,
                    'label'=>'Ingrese número de Patrimonio ',
                    'required' => true,
                    'constraints'=>array(new Assert\NotBlank())
                ))
                ->addModelTransformer($transformer)
            );


        $builder
            ->add('fechadesde','date',array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'years' => range(2004,$actual),
                    'label'=>'Desde fecha: '
            ))

           ->add('fechahasta','date', array(
                    'data' => new \DateTime()
            ));
            
       
        $builder  
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
        return 'atmanager_indicpatrimonio';
    }
}
