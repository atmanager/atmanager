<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ATManager\FrontendBundle\Form\DataTransformer\PatrimonioToNumberTransformer;

class AtType extends AbstractType
{


    private $em;

    public function __construct($em)
    { $this->em=$em;}
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                   
            
            ->add('personasolicita')
            ->add('descripcion')
            #->add('patrimonio')
            ->add('sectorsolicita')
            ->add('sectordestino')
            ->add('prioridad')
        ;
        $entityManager = $this->em;
        $transformer = new PatrimonioToNumberTransformer($entityManager);
        $builder->add(
            $builder->create('patrimonio', 'text', array('required'=>false))
                ->addModelTransformer($transformer)

        );
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
