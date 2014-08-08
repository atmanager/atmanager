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

      
    /*private function createCreateForm(AtTecnico $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new AtTecnicoType($em), $entity, array(
            'action' => $this->generateUrl('at_new'),
            'method' => 'POST'
        ));

      return $form;
    }

    
    public function newAction(Request $request)
    {
        $entity = new At();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            try{

                $entity->setIpsolicita($request->getClientIp());
                //$entity->setIpsolicita($request->getHost());

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                

                $atHistorico= new atHistorico();
                $atHistorico->setAt($entity);
                
                $em = $this->getDoctrine()->getManager();
                
                $clasificacion = $em->getRepository('BackendBundle:EstadioClasif')->findOneByIniciaAt(true);
                $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasificacion);
                $atHistorico->setEstadio($estadio);
                $atHistorico->setComentario('Inicializado');
                $em->persist($atHistorico);
                $em->flush();
                 $request->getSession()->getFlashBag()->add('success','Solicitud Aceptada');
                return $this->redirect($this->generateUrl('at_show', array('id' => $entity->getId())));
               }catch(\Exception $ex){
                $request->getSession()->getFlashBag()->add('error','Problemas al solicitar Atencion Técnica');
                return $this->redirect($this->generateUrl('at_show'));
            }

        }

        return $this->render('FrontendBundle:At:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

   
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:At')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find At entity.');
        }

        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontendBundle:At:show.html.twig', 
            array('entity' => $entity)
        );
    }

     public function verHistoricoAction(Request $request, $id)
    {
        
                  
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:At')->find($id);
            
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find At entity.');
            }

        return $this->render('FrontendBundle:At:showHistorico.html.twig', array(
            'entity' => $entity,
        ));
    } */


    public function buscadorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(new AtBuscadorInicialType(), null, array(
            'method' => 'GET'
        ));

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
                            'form'=>$form->createView(),
			 	
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

        

         $form = $this->createForm(new AtTecnicoType(), $objAtTec, array(
            'method' => 'GET'
        ));

               

       $form->handleRequest($request);
       
        if ($form->isValid())
        {
            try{
            
            $em->persist($objAtTec);


            $atHistorico= new atHistorico();
            $atHistorico->setAt($entity);            
            $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByNombre('EN DIAGNOSTICO');
            $atHistorico->setEstadio($estadio);
            $atHistorico->setComentario('At Aceptada. Agregada a la agenda del técnico');

            $em->persist($atHistorico);

            $em->flush();
            $request->getSession()->getFlashBag()->add('success','Se agregaron: Tecnico Responsable; Nueva evolución');
            return $this->redirect($this->generateUrl('atecnica_buscador'));
            }catch(\Exception $ex){
                $request->getSession()->getFlashBag()->add('error',$ex->getMessage());
                return $this->redirect($this->generateUrl('atecnica_buscador'));
            }
                
            
            // redirect a visualizar AT
        }
        return $this->render('AtBundle:Atecnica:newAtTecnico.html.twig', array(
                            'form'=>$form->createView(),
                
        ));
    }           
}
