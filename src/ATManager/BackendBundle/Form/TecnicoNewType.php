<?php

namespace ATManager\BackendBundle\Form;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class TecnicoNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'label' => 'Nombre completo *',
                'required' => true,
                'constraints'=>array(new Assert\NotBlank())
            ))

            ->add('documento', 'text', array(
                'label' => 'Documento número *(Único)',
                'required' => true,
                'constraints'=>array(new Assert\NotBlank())

            ))

            ->add('movil', 'text', array(
                'label' => 'Teléfono Movil (no fijo) ',
                'required' => false,
            ))

            ->add('email', 'email', array(
                'label' => 'E-mail *(Único)',
                'required' => true,
                'constraints'=>array(
                            new Assert\Email(),
                            new Assert\NotBlank())
            ))

            ->add('username', 'text', array(
                'label' => 'User de logueo *(Único)',
                'required' => true,
                'constraints'=>array(new Assert\NotBlank())
            ))

            ->add('plainpassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las contraseñas deben coincidir',
                'attr' => array('autocomplete' => 'off'),
                'required' => true,
                'first_name' => "contrasena_1",
                'second_name' => "contrasena_2",
                'first_options'  => array('label' => 'Contraseña *'),
                'second_options' => array('label' => 'Repetir Contraseña *'),
            ))
            ->add('rol', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Permiso *',
                'choices' => array(
                    'ROLE_ADMIN' => 'Super Administrador', 
                    'ROLE_JDS' => 'Jefe de Sector',
                    'ROLE_TECNICO' => 'Técnico',
                    'ROLE_OPERPAT' => 'Operador Patrimonios',
                ),

            ))

            ->add('sector','entity', array(
                'class' => 'BackendBundle:Sector',
                'label' => 'Sector *',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                    ->innerJoin('s.tipo','t', 'WITH', 't.destino = :destino')
                    ->setParameter('destino',true)
                    ;
                },
            ))


            ->add('submit', 'submit', array('label'=>'Aceptar'))

        ;
    }

    public function getName()
    {
        return 'userbundle_new';
    }
}
