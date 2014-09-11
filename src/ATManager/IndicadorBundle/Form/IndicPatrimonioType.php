<?php

namespace ATManager\IndicadorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ATManager\FrontendBundle\Form\DataTransformer\PatrimonioToNumberTransformer;

class IndicPatrimonioType extends AbstractType
{
    private $em;
    public function __construct($em) {
        $this->em=$em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $actual=date ("Y");
        $etm = $this->em;
        $transformer = new PatrimonioToNumberTransformer($etm);
        
         $builder        
            ->add(
                $builder->create('patrimonio', 'text', array(
                    'required'=>true,
                    'label'=>'Ingrese número de Patrimonio '
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
            ->add('fechahasta','date',array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'years' => range(2004,$actual),
                    'label'=>'Hasta fecha: '
            ));
       
        $builder  
            ->add('Aceptar','submit');    
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
