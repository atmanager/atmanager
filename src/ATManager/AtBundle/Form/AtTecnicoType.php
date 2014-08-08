<?php

namespace ATManager\AtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class AtTecnicoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        
         $builder
                ->add('tecnico','entity',
                    array(
                        'class'=>'BackendBundle:Tecnico',
                        'empty_value'=>'Selecccione Clasificación [*]',
                        'query_builder'=>function($er)
                            {
                            return $er->createQueryBuilder('t')
                                ->select('t')
                                ->Where('t.sector=1');
                            }
                          ))
                    
                           ->add('submit', 'submit', array('label' => 'Aceptar'));
        
    }
   
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
