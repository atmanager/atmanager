<?php

namespace ATManager\AtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class AtTecnicoType extends AbstractType
{

    protected $opciones;

    public function __construct ($opciones)
    {
        $this->opciones = $opciones;
    }

        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones = $this->opciones;
        $builder
                ->add('tecnico','entity',
                    array(
                        'class'=>'BackendBundle:Tecnico',
                        'empty_value'=>'Seleccione Técnico Principal [*]',
                        'query_builder'=>function($er) use ($opciones)
                            {
                            return $er->createQueryBuilder('t') 
                                ->select('t')
                                ->Where('t.sector = :sector')
                                ->setParameter('sector', $opciones['sector']);
                            },
                          ))

              ->add('prioridad','entity',
                    array(
                        'class'=>'BackendBundle:Prioridad',
                        'empty_value'=>'Selecccione Prioridad de Abordaje: [*]',
                        'data'=>$opciones['prioridad'],
                        'mapped'=>false
                        
                )) 

                ->add('submit', 'submit', array('label' => 'Aceptar'));     
    }
     
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\AtBundle\Entity\AtTecnico',

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_atbundle_attecnico';
    }
}
