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
                        'empty_value'=>'Selecccione un técnico responsable para la AT [*]',
                        'query_builder'=>function($er) use ($opciones)
                            {
                            return $er->createQueryBuilder('t') 
                                ->select('t')
                                ->Where('t.sector = :opciones')
                                ->setParameter('opciones', $opciones);
                            },
                          ))
                    
                           ->add('submit', 'submit', array('label' => 'Aceptar'));
                            
        
    }




    /*$builder->add('framePlume', 'entity', array(
    'class' => 'DessinPlumeBundle:PhysicalPlume',
    'query_builder' => function(EntityRepository $er) use ($profile)
                        {
                            return $er->createQueryBuilder('pp')
                                ->where("pp.profile = :profile")
                                ->orderBy('pp.index', 'ASC')
                                ->setParameter('profile', $profile)
                            ;
                        },

));*/

   
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\AtBundle\Entity\AtTecnico'
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
