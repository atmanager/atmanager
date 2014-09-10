<?php

namespace ATManager\IndicadorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IndicadorBundle::index.html.twig');
    }
}
