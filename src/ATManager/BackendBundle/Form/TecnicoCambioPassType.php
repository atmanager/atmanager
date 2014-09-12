<?php

namespace ATManager\BackendBundle\Form;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class TecnicoCambioPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('plainpassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las contraseñas deben coincidir',
                'attr' => array('autocomplete' => 'off'),
                'required' => false,
                'first_name' => "contrasena_1",
                'second_name' => "contrasena_2",
                'first_options'  => array('label' => 'Contraseña *'),
                'second_options' => array('label' => 'Repetir Contraseña *'),
            ))
           

           ->add('submit', 'submit', array('label'=>'Aceptar'))
        ;
    }

    public function getName()
    {
        return 'tecnicocambiopass';
    }
}
