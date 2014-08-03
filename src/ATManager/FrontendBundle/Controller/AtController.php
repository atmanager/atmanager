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
    public function newAction()
    {
        $entity = new At();
	$em = $this->getDoctrine()->getManager();        
	$form = $this->createForm(new AtType($em), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $entity->setIpsolicita($this->container->get('request')->getClientIp());
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $atHistorico= new atHistorico();
                $atHistorico->setAt($entity);
                $clasificacion = $em->getRepository('BackendBundle:EstadioClasif')->findOneByIniciaAt(true);
                $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasificacion);
                $atHistorico->setEstadio($estadio);
                $atHistorico->setComentario('Inicializado');
                $em->persist($atHistorico);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Solicitud Aceptada');
                return $this->redirect($this->generateUrl('at_show', array('id' => $entity->getId())));
            }catch(\Exception $ex){
                $this->get('session')->getFlashBag()->add('error','Problemas al solicitar Atencion Técnica');
                return $this->redirect($this->generateUrl('at_new'));
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
	return $this->render('FrontendBundle:At:show.html.twig', 
            array('entity' => $entity)
        );
    }

    public function verHistoricoAction($id)
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
