<?php

namespace ATManager\AtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AtNotaType extends AbstractType
{

    protected $opciones;

    public function __construct ($opciones = null)
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

        
        // si estamos editando        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, 
        function (FormEvent $event)
        {
        $AtNota = $event->getData();
        $form = $event->getForm();

        // check if the Product object is "new"
        // If no data is passed to the form, the data is "null".
        // This should be considered a new "Product"
          if ($AtNota->getId())
          {
              $form->add('eliminarImagen','checkbox',array(
                    'mapped' => false,
                    'required' => false, 
                    ));
          }
        });             
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
