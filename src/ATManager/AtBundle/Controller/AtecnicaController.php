<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

use ATManager\FrontendBundle\Entity\At;
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
    public function generoAgendaTecnicoAction(Request $request, $id)
    {
        
       /* recupero la variable de session definida en: buscadorAction()*/
        $sesion = $this->get('session');

       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret = $sesion->get('retorno');
       
                      
        $objAtTec=new AtTecnico();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:At')->find($id);
        $rol = $em->getRepository('BackendBundle:Rol')->findOneByNombre('PRINCIPAL');
        $objAtTec->setAt($entity);
        $objAtTec->setRol($rol);
        // capturo el tecnico jefe logueado
        $objtecnicoLogin = $this->get('security.context')->getToken()->getUser();       
        // asigno a $opciones el sector del tecnico jefe logueado
        $opciones['sector'] = $objtecnicoLogin->getSector();
        $opciones['prioridad'] = $entity->getPrioridad();

         $form = $this->createForm(new AtTecnicoType($opciones), $objAtTec, array(
            'method' => 'GET'
        ));
        $form->handleRequest($this->getRequest());       
        if ($form->isValid())
        {
            try{
                $em->persist($objAtTec);
                $atHistorico= new atHistorico();
                $atHistorico->setAt($entity);            
                $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByNombre('EN DIAGNOSTICO');
                $atHistorico->setEstadio($estadio);
                $atHistorico->setComentario('At Aceptada. Agregada a la agenda del técnico');
                // hasta aquí guarda el historico de la at asignada
                $em->persist($atHistorico);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Se agregaron: Tecnico Responsable y Nueva evolución');
                
                /* redirecciono usando la variable de session*/
                return $this->redirect($ret);
                
            }catch(\Exception $ex){
                $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
                return $this->redirect($ret);
            }    
            
        }

        $entities = $em->getRepository('AtBundle:AtHistorico')->findBySector($opciones['sector']);
        return $this->render('AtBundle:Atecnica:newAtTecnico.html.twig', array(
                            'form'=>$form->createView(),
                            'entity'=>$entity,
                            'entities'=>$entities
        ));
    }    
    
    
}