<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     $retorno = $request->getHost().$request->getRequestUri();
     $sesion = $this->get('session');
     $sesion->set('retorno',$retorno);
     


        $em = $this->getDoctrine()->getManager();
        $clas_esta = $em->getRepository('BackendBundle:EstadioClasif')->findOneByIniciaAt(true);
        $esta = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clas_esta);
        

        $form = $this->createForm(new AtBuscadorInicialType(), null, array(
            'method' => 'GET'
        ));

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
		            'entities' => $entities 	
            ));
        }
        return $this->render('AtBundle:Atecnica:find.html.twig', array(
                            'form'=>$form->createView()	 	
        ));
    }   
    public function generoAgendaTecnicoAction(Request $request, $id)
    {

        
        



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

        // $form = $this->createForm(new PlumeOptionsType($opciones)
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
                $this->get('session')->getFlashBag()->add('success','Se agregaron: Tecnico Responsable; Nueva evolución');
                return $this->redirect($this->generateUrl('atecnica_buscador'));
            }catch(\Exception $ex){
                $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
                return $this->redirect($this->generateUrl('atecnica_buscador'));
            }    
            // redirect a visualizar AT
        }

        $entities = $em->getRepository('AtBundle:AtHistorico')->findBySector($opciones['sector']);
        return $this->render('AtBundle:Atecnica:newAtTecnico.html.twig', array(
                            'form'=>$form->createView(),
                            'entity'=>$entity,
                            'entities'=>$entities
        ));
    }    
    
    
}