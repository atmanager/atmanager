<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
#    public function indexAction($name)
    public function inicioAction()
    {
        return $this->render('::inicio.html.twig');
       

    }


    #    index de backend
    public function indexAction()
    {
        return $this->render('BackendBundle::index.html.twig');
       

    }

     #    ayuda de la aplicación
    public function ayudaAction()
    {
        //return new Response('Ayuda');

        return $this->render('::ayuda.html.twig');
       

    }

    #    ayuda de la aplicación
    public function portadaAction()
    {
        //return new Response('Ayuda');

        return $this->render('::portada.html.twig');
       

    }

    public function mailAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('soporte.masvernat@gmail.com')
            ->setTo('atmanagerpro@gmail.com')
            ->setBody("Mail prueba")
        ;
        $this->get('mailer')->send($message);

        return $this->render('::portada.html.twig');
    }
}
