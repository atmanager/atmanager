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
            if ($fechadesde<=$fechahasta)
            {
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador2($fechadesde,$fechahasta));
            }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}
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

            if ($fechadesde<=$fechahasta)
            {
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador3($fechadesde,$fechahasta,$objsd));
            }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador3.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    

    public function indicador4Action(Request $request){
       /*
        inicializo las variables
        sino se cae el procedimiento
        cuando se accede por primera vez
        a la funcionalidad
       */
        $objest=null;
        $objsec=null;
        $promedio=0;

        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new IndicEstadioType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =new Indicador();
        if ($form->isValid()) {
            $fechadesde=$form->get('fechadesde')->getData();
            $fechahasta=$form->get('fechahasta')->getData();
            $objest=$form->get('estadio')->getData();
            $objsec=$form->get('sector')->getData();
           if ($fechadesde<=$fechahasta)
           {
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador4($fechadesde,$fechahasta,$objest,$objsec));
            $resul = $entities->getDatos(); 
            $promedio = $this->obtener_promedio_por_estadio($resul);
           }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}                   
        }
    	
        return $this->render('IndicadorBundle:Indicador:indicador4.html.twig', array(
            'estadio'=> $objest,
            'sector'=> $objsec,
            'promedio'=> $promedio,
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
           
           if ($fechadesde<=$fechahasta)
           {
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador5($fechadesde,$fechahasta,$objss));
            }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}                   
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
            if ($fechadesde<=$fechahasta)
           {
            $objst=$form->get('sertercero')->getData();
           
            if($objst)
            {    
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador6($fechadesde,$fechahasta,$objst));
            }else{$entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador6bis($fechadesde,$fechahasta));}
           }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}                    
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
            if ($fechadesde<=$fechahasta)
           { 
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador7($fechadesde,$fechahasta));
           }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}
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
            if ($fechadesde<=$fechahasta)
            {
            $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador8($fechadesde,$fechahasta));
            }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}
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
            
            if ($fechadesde<=$fechahasta)
            {
                if($objrep)
                {    
                $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador9($fechadesde,$fechahasta,$objrep));           
                }else{
                        $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador9bis($fechadesde,$fechahasta));           
                     }
            }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}
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
           
            if ($fechadesde<=$fechahasta)
            {
                $entities->setDatos($em->getRepository('IndicadorBundle:Indicador')->findByIndicador10($fechadesde,$fechahasta));
             }else{$this->get('session')->getFlashBag()->add('error','Fecha desde es mayor que fecha hasta');}   
        }
    	$paginator = $this->get('knp_paginator');
        $entities->setDatos($paginator->paginate($entities->getDatos(), $this->getRequest()->query->get('pagina',1), 10));
        return $this->render('IndicadorBundle:Indicador:indicador10.html.twig', array(
            'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }

    

    private function obtener_promedio_por_estadio($resul)
    {
        $x=0;
        $th=0;
            foreach ($resul as $key => $value) {
            $fin = $value['fechaFin']->format('Y-m-d H:i:s');
            $inicio = $value['fechaInicio']->format('Y-m-d H:i:s');
            $i = $this->calcula_horas($inicio, $fin);            
                $x=$x+1;
                $th=$th+$i;
            }
           
            if($x==0){$x=1;}  // no se puede dividir por cero,      
            return ($th/$x);
    }


    
    private function calcula_horas($inicio, $fin)
    { 
        $total_seconds = strtotime($fin) - strtotime($inicio); 
        $horas = floor ( $total_seconds / 3600 );
        return $horas;
    }
}