<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AtBundle::index.html.twig');
    }
}
