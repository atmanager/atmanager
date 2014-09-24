<?php

namespace ATManager\IndicadorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class IndicSecSolicitanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $actual=date ("Y");
        $builder
            ->add('fechadesde','date',array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'years' => range(2004,$actual)
            ))
            ->add('fechahasta','date', array(
                    'data' => new \DateTime()
            ))
            ->add('secsolicitante','entity', array(
                'label'=>'Sector Solicitante : ',
                'class' => 'BackendBundle:Sector',
                'required'=>false,
                'empty_value'=>'Todos...',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.tipo','t', 'WITH', 't.origen = :origen')
                        ->setParameter('origen',true)
                        ->orderBy('s.nombre','ASC')
                    ;
                }
            ))    
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
        return 'atmanager_indicsolicitante';
    }
}