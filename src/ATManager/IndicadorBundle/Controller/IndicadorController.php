<?php

namespace ATManager\IndicadorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ATManager\IndicadorBundle\Entity\Indicador;
use ATManager\IndicadorBundle\Form\IndicPatrimonioType;
use ATManager\IndicadorBundle\Form\IndicPeriodoType;
use ATManager\IndicadorBundle\Form\IndicSecDestinoType;
use ATManager\IndicadorBundle\Form\IndicSecSolicitanteType;
use ATManager\IndicadorBundle\Form\IndicEstadioType;
use ATManager\IndicadorBundle\Form\IndicRepuestoType;
use ATManager\IndicadorBundle\Form\IndicServicioType;

class IndicadorController extends Controller
{
    public function indicador1Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicPatrimonioType($em),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $objpat=$form->get('patrimonio')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador1($fechadesde,$fechahasta,$objpat));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador1.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador2Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicPeriodoType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador2($fechadesde,$fechahasta));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador2.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador3Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicSecDestinoType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $objsd=$form->get('secdestino')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador3($fechadesde,$fechahasta,$objsd));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador3.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador4Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicEstadioType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $objest=$form->get('estadio')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador4($fechadesde,$fechahasta,$objest));
            print_r($entities->getDatos());
            die;          
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador4.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador5Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicSecSolicitanteType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $objss=$form->get('secsolicitante')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador5($fechadesde,$fechahasta,$objss));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador5.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador6Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicServicioType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $objst=$form->get('sertercero')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador6($fechadesde,$fechahasta,$objst));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador6.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador7Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicPeriodoType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador7($fechadesde,$fechahasta));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador7.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador8Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicPeriodoType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador8($fechadesde,$fechahasta));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador8.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador9Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicRepuestoType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $objrep=$form->get('repuesto')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador9($fechadesde,$fechahasta,$objrep));           
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador9.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function indicador10Action(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicPeriodoType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador10($fechadesde,$fechahasta));
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador10.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
}