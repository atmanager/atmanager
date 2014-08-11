<?php

namespace ATManager\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ATManager\FrontendBundle\Form\DataTransformer\PatrimonioToNumberTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class AtEditType extends AbstractType
{


    private $em;

    public function __construct($em, $at)
    { 
        $this->em=$em;
        $this->at=$at;
    }


        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        #->add('patrimonio')
        $entityManager = $this->em;
     
        $transformer = new PatrimonioToNumberTransformer($entityManager);

        $builder->add(
            $builder->create('patrimonio', 'text', array(
            'required'=>false,
            'label'=>'Ingrese número de Patrimonio '
             ))
            
            ->addModelTransformer($transformer)

            );




        $builder  

         
            ->add('personasolicita','text', array(
            'label'=>'[*] Apellido y Nombre del Solicitante :',
            'read_only'=>true
            ))

         
            ->add('descripcion','textarea', array(
            'label'=>'Describa cual es el sintoma/problema observado: ',
            'read_only'=>true
            ))
            
           
           ->add('sectorsolicita','entity', array(
                'label'=>'Sector de origen : ',
                'read_only'=>true,
                'class' => 'BackendBundle:Sector',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                    ->innerJoin('s.tipo','t', 'WITH', 't.origen = :origen')
                    ->setParameter('origen',true)
                     ->orderBy('s.nombre','ASC')
                    ;
                },
            ))


                       
            ->add('sectordestino','entity', 
                array(
                        'label'=>'Para sector técnico : ',
                        'class' => 'BackendBundle:Sector',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('s')
                            ->innerJoin('s.tipo','t', 'WITH', 't.destino = :destino')
                            ->setParameter('destino',true)
                            ->orderBy('s.nombre','ASC')
                            ;
                        },
            ))
            

            ->add('prioridad','entity', array(
                'label'=>'Escoja una prioridad',
                'class' => 'BackendBundle:Prioridad',
                'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('p')
                            ->orderBy('p.nombre','DESC')
                            ;
                        },
                
            ))

            ->add('submit', 'submit', array('label' => 'Aceptar'))
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
