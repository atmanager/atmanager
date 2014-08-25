<?php

namespace ATManager\AtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class AtNotaType extends AbstractType
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
        
        $builder->add('descripcion','text', 
                  array('label' => 'Referencia de la nota'
                  ))

                ->add('fecha','date',
                    array('label' => 'Fecha de nota'
                  ))

                ->add('comentario','textarea', 
                  array('label' => 'Comentarios'
                  ))

                ->add('file')
                        
                ->add('submit', 'submit', array('label' => 'Aceptar'));     
    }
     
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\AtBundle\Entity\AtNota',

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_atbundle_atnota';
    }
}
