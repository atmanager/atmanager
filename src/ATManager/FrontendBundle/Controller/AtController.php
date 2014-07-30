<?php

namespace ATManager\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ATManager\FrontendBundle\Entity\At;
use ATManager\AtBundle\Entity\AtHistorico;
use ATManager\FrontendBundle\Form\AtType;
use ATManager\FrontendBundle\Form\AtBusType; 


class AtController extends Controller
{

      
    private function createCreateForm(At $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new AtType($em), $entity, array(
            'action' => $this->generateUrl('at_new'),
            'method' => 'POST'
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

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
    } 


    public function buscadorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new AtBusType(), null, array(
            'method' => 'GET'
        ));
	$form->handleRequest($request);
        if ($form->isValid())
        {
	    $entities =array();        	
            $numero=$form->get('numero')->getData();
            $personasolicita=$form->get('personasolicita')->getData();
            $sectorsolicita=$form->get('sectorsolicita')->getData();
            

            $entities = $em->getRepository('FrontendBundle:At')->findByFiltroAt($numero, $personasolicita, $sectorsolicita);
                $paginator = $this->get('knp_paginator');
                $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
                return $this->render('FrontendBundle:At:index.html.twig', array( 
                    'form'=>$form->createView(),
		    'entities' => $entities 	
                ));
        }
        return $this->render('FrontendBundle:At:find.html.twig', array(
                            'form'=>$form->createView(),
			 	
        ));
    }         
}
