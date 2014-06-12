<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
