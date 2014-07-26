<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Form\BuscadorType;
use ATManager\BackendBundle\Entity\AlaSector;
use ATManager\BackendBundle\Form\AlaSectorType;

/**
 * AlaSector controller.
 *
 */
class AlaSectorController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $entities = $em->getRepository('BackendBundle:AlaSector')->findByName($nombre);
        }
    	$paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:AlaSector:index.html.twig', array(
        	'entities'=> $entities,
            	'form'=>$form->createView()	
        ));
    }
    public function newAction()
    {
        $entity = new AlaSector();
        $form = $this->createForm(new AlaSectorType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
           try{
              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('alasector_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
              return $this->redirect($this->generateUrl('alasector'));
           }
        }
    	return $this->render('BackendBundle:AlaSector:new.html.twig', array(
      	   'form' => $form->createView()        
	));
    }
    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:AlaSector')->find($id);
        $form = $this->createForm(new AlaSectorType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{  
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('alasector_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
                return $this->redirect($this->generateUrl('alasector'));
            }    
        }
        return $this->render('BackendBundle:AlaSector:edit.html.twig', array('form'=>$form->createView()));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:AlaSector')->find($id);
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('alasector'));
        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('alasector'));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AlaSector')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('BackendBundle:AlaSector:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
