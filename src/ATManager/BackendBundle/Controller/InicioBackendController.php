<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InicioBackendController extends Controller
{
#    public function indexAction($name)
    public function indexAction()
    {
        return $this->render('BackendBundle::base_backend.html.twig');
        /*return $this->render('BackendBundle::base_backend.html.twig');*/

    }
}
