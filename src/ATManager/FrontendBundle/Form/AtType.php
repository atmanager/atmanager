<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AtType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('fechasolicitud')
            ->add('fechafin')
            ->add('personasolicita')
            ->add('ipsolicita')
            ->add('hostsolicita')
            ->add('descripcion')
            ->add('patrimonio')
            ->add('sectorsolicita')
            ->add('sectordestino')
            ->add('prioridad')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ATManager\FrontendBundle\Entity\At'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'atmanager_frontendbundle_at';
    }
}
