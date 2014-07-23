<?php

namespace ATManager\PatrimonioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PatrimonioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('responsable')
            ->add('modelo')
            ->add('serial')
            ->add('observacion')
            ->add('precio')
            //->add('estimado')
            ->add('clasificacion')
            ->add('local')
            ->add('marca')
            ->add('fechaAlta')
             ->add('submit', 'submit', array('label' => 'Aceptar'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\PatrimonioBundle\Entity\Patrimonio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_patrimoniobundle_patrimonio';
    }
}
