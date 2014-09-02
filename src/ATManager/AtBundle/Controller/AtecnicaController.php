<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\AtBundle\Entity\AtHistorico;
use ATManager\AtBundle\Entity\AtTecnico;
use ATManager\BackendBundle\Entity\Rol;
use ATManager\FrontendBundle\Form\AtType;
use ATManager\FrontendBundle\Form\AtBuscadorType;
use ATManager\FrontendBundle\Form\AtBuscadorInicialType;  
use ATManager\AtBundle\Form\AtTecnicoType;  


class AtecnicaController extends Controller
{
    public function buscadorAction(Request $request)
    {

      /*
        Asumimos que este es la funcion que inicia un  proceso en cascada
        que incluye: 
        1) Escoger un estadio para recuperar las AT
        2) Visualizar las AT por el estadio escogido
        3) Asignar un tecnico responsable a la AT escogida (link "Aceptar")
        4) Regresar al punto 2, luego del paso 3.

        Si queremos regresar al punto 2, guardando la URL en una variable de sesśion
        debemos utilizar las siguientes definiciones: 1, 2, 3
      */  
     
     // [1] obtiene el string de la URL que nos muestra el punto 2, 
     //   guardandola en la variable $retorno.
     $retorno = 'http://'.$request->getHost().$request->getRequestUri(); 

     // [2] inicalizamos la variable de session global: 
     $sesion = $this->get('session'); 

     // [3] le asignamos el valor obtenido
     $sesion->set('retorno',$retorno); // 3

     /* en esta funcion solo se define la variable de session la que usará en otras funciones
     del controlador como por ejemplo: generoAgendaTecnicoAction(Request $request, $id)*/

    
        $em = $this->getDoctrine()->getManager();
        $clas_esta = $em->getRepository('BackendBundle:EstadioClasif')->findOneByIniciaAt(true);
        $esta = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clas_esta);
        $form = $this->createForm(new AtBuscadorInicialType(), null, array(
            'method' => 'GET'
        ));
        // asigna al select del estadio del type, el estadio que eligio el usuario
        $form->get('estadio')->setData($esta); 
        $form->handleRequest($request);        
        if ($form->isValid())
        {
	    $entities =array();        	  
            $objt = $this->get('security.context')->getToken()->getUser();
            $sector=$objt->getSector();
            $estadio=$form->get('estadio')->getData();            
            $entities = $em->getRepository('FrontendBundle:At')->findByFiltroPorSectorEstadio($sector, $estadio);
            $paginator = $this->get('knp_paginator');
            $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
            return $this->render('FrontendBundle:At:viewStarting.html.twig', array( 
                    'form'=>$form->createView(),
		    'entities' => $entities,
                    'estadio' => $estadio 	
            ));
        }
        return $this->render('AtBundle:Atecnica:find.html.twig', array(
                            'form'=>$form->createView()	 	
        ));
    }   
    public function generoAgendaTecnicoAction($id)
    {
	    $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:At')->find($id);
	    $objtl = $this->get('security.context')->getToken()->getUser();
 	    $opciones['sector'] = $objtl->getSector();
	    $mapatec = $em->getRepository('AtBundle:AtTecnico')->findBySector($opciones['sector']);
	    return $this->render('AtBundle:Atecnica:newAtTecnico.html.twig', array(
        	'entity'=>$entity,
            	'mapatec'=>$mapatec
        ));          
    }  
  

    public function asignarTecnicoATAction($at,$tec)
    {
        /* recupero la variable de session definida en: buscadorAction()*/
        $sesion = $this->get('session');
        /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
        el proceso*/ 
        $ret = $sesion->get('retorno');
        /*--*/
        $objatt=new AtTecnico();
       	$em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:At')->find($at);
        $objtl = $this->get('security.context')->getToken()->getUser();
        $opciones['sector'] = $objtl->getSector();
        try{	
	    $objt= $em->getRepository('BackendBundle:Tecnico')->findOneById($tec);
	    
        $rol = $em->getRepository('BackendBundle:Rol')->findOneByPrincipal(true);	

	    $objatt->setAt($entity);
	    $objatt->setRol($rol);
	    $objatt->setTecnico($objt);
	    $em->persist($objatt);
            $ath= new atHistorico();
            $ath->setAt($entity);   
            $clas_esta = $em->getRepository('BackendBundle:EstadioClasif')->findOneByDiagnosAt(true);         
            $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clas_esta);
            $ath->setEstadio($estadio);
            $ath->setComentario('At Aceptada. Agregada a la agenda de: '.$objt->getNombre());
            // hasta aquí guarda el historico de la at asignada
            $em->persist($ath);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Se agregaron: Técnico Responsable y Nueva evolución'); 
            return $this->redirect($ret);            
        }
	catch(\Exception $ex){
	    $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
            return $this->redirect($ret);
        }	               
    }
    public function cancelarAction($id)
    {
        /* recupero la variable de session definida en: buscadorAction()*/
        $sesion = $this->get('session');

       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret = $sesion->get('retorno');
        $fechafin=new \DateTime();
        try{
            $em = $this->getDoctrine()->getManager();
            $objtl = $this->get('security.context')->getToken()->getUser();
            $entity = $em->getRepository('FrontendBundle:At')->find($id);
            $entity->setFechafin($fechafin);
            $em->persist($entity);
            //
            $ath= new atHistorico();
            $ath->setAt($entity);            
            $clas_esta = $em->getRepository('BackendBundle:EstadioClasif')->findOneByCancelaAt(true);         
            $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clas_esta);
            $ath->setEstadio($estadio);
            $ath->setComentario('At Cancelada por:,'.' '.$objtl->getNombre() );
            $em->persist($ath);
            //
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Se canceló AT'); 
            return $this->redirect($ret);
        }
        catch(\Exception $ex){
            $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
            return $this->redirect($ret);
        }
    }
    // Fecha: 24/08/2014
    // Busca las ats del técnico logueado
    public function buscarAgendaTecnicoAction(Request $request)
    {
                 
        $retorno = 'http://'.$request->getHost().$request->getRequestUri(); 
        $sesion = $this->get('session'); 
        $sesion->set('retorno',$retorno);
       
        /* ------------------------------------*/
        $objt = $this->get('security.context')->getToken()->getUser();   
        $em = $this->getDoctrine()->getManager();
        $clas_esta = $em->getRepository('BackendBundle:EstadioClasif')->findOneByDiagnosAt(true);
        $esta = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clas_esta);
        $form = $this->createForm(new AtBuscadorInicialType(), null, array(
            'method' => 'GET'
        ));
        // asigna al select del estadio del type, el estadio que eligio el usuario
        $form->get('estadio')->setData($esta); 
        $form->handleRequest($request);        
        if ($form->isValid())
        {
	        $entities =array();        	  
            $sector=$objt->getSector();
            $rol=1;
            $estadio=$form->get('estadio')->getData();            
            $entities = $em->getRepository('FrontendBundle:At')->findByFiltroPorTecnico($objt,$rol,$estadio);
            $paginator = $this->get('knp_paginator');
            $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
            return $this->render('AtBundle:Atecnica:veragendatecnico.html.twig', array( 
                   // 'form'=>$form->createView(),
		            'entities' => $entities,
                    'tecnico' => $objt,
                    'retorno' =>$retorno 	
            ));
        }
        return $this->render('AtBundle:Atecnica:find.html.twig', array(
                            'form'=>$form->createView()	 	
        ));
    }
    
    
}
