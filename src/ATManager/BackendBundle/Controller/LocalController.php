<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Form\LocalType;  
use ATManager\BackendBundle\Entity\Local; 
use ATManager\BackendBundle\Form\BuscadorType;

class LocalController extends Controller
{
#    public function indexAction($name)
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $locales =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $locales = $em->getRepository('BackendBundle:Local')->findByName($nombre);
        }
    	$paginator = $this->get('knp_paginator');
        $locales = $paginator->paginate($locales, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Local:index.html.twig', array(
        	'locales'=> $locales,
            'form'=>$form->createView()	
        ));
    }
    public function newAction()
    {
        $objl = new Local();
        $form = $this->createForm(new LocalType(), $objl);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
           try{
              $em = $this->getDoctrine()->getManager();
              $em->persist($objl);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('local_show', array('id' => $objl->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
            //  return $this->redirect($this->generateUrl('local_nuevo'));
           }
        }
    	return $this->render('BackendBundle:Local:new.html.twig', array(
      	   'form' => $form->createView()        
	));
    }
    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $objl = $em->getRepository('BackendBundle:Local')->find($id);
        $form = $this->createForm(new LocalType(), $objl);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{  
                $em->persist($objl);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('local_edit', array('id' => $objl->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
              //  return $this->redirect($this->generateUrl('local_edit', array('id' => $objl->getId())));
            }    
        }
        return $this->render('BackendBundle:Local:edit.html.twig', array('form'=>$form->createView()));
    }
    public function deleteAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objl = $em->getRepository('BackendBundle:Local')->find($id);
            $em->remove($objl); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('local_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('local_listado'));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Local')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('BackendBundle:Local:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
