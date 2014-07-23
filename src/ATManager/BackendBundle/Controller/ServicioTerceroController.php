<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Entity\ServicioTercero;
use ATManager\BackendBundle\Form\ServicioTerceroType;
use ATManager\BackendBundle\Form\BuscadorType; 

class ServicioTerceroController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $entities = $em->getRepository('BackendBundle:ServicioTercero')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:ServicioTercero:index.html.twig', array(
            'entities' => $entities,
            'form'=>$form->createView()
        ));
    }
    public function newAction()
    {
        $entity = new ServicioTercero();
        $form = $this->createForm(new ServicioTerceroType(), $entity);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) 
        {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('serviciotercero_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
                return $this->redirect($this->generateUrl('serviciotercero'));
            }
        }    
        return $this->render('BackendBundle:ServicioTercero:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ServicioTercero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioTercero entity.');
        }

        return $this->render('BackendBundle:ServicioTercero:show.html.twig', array(
            'entity' => $entity,  
        ));
    }
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:ServicioTercero')->find($id);
        $editForm =  $this->createForm(new ServicioTerceroType(), $entity);
	$editForm->handleRequest($this->getRequest());
	if ($editForm->isValid())
        {
            try{
		$em->persist($entity);
            	$em->flush();
             	$this->get('session')->getFlashBag()->add('success','Item actualizado');
             	return $this->redirect($this->generateUrl('serviciotercero_show', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
                return $this->redirect($this->generateUrl('serviciotercero'));
            }
            
        }
        return $this->render('BackendBundle:ServicioTercero:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objst = $em->getRepository('BackendBundle:ServicioTercero')->find($id);
            $em->remove($objst); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('serviciotercero'));

        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('serviciotercero'));
        }     
    }
}
