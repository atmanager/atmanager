<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Form\BuscadorType; 
use ATManager\BackendBundle\Entity\RepuestoClasif;
use ATManager\BackendBundle\Form\RepuestoClasifType;

/**
 * RepuestoClasif controller.
 *
 */
class RepuestoClasifController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $entities = $em->getRepository('BackendBundle:RepuestoClasif')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);        
        return $this->render('BackendBundle:RepuestoClasif:index.html.twig', array(
        	'entities'=> $entities,
            'form'=>$form->createView()	
        ));
    }
    public function newAction()
    {
        $entity= new RepuestoClasif();
        $form = $this->createForm(new RepuestoClasifType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())   
        {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('repuestoclasif_show', array('id' => $entity->getId())));
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
                return $this->redirect($this->generateUrl('repuestoclasif_new'));
             }
        }
        return $this->render('BackendBundle:RepuestoClasif:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:RepuestoClasif')->find($id);
        $form = $this->createForm(new RepuestoClasifType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('repuestoclasif_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
                return $this->redirect($this->generateUrl('repuestoclasif_edit', array('id' => $entity->getId())));
            }    
        }
        return $this->render('BackendBundle:RepuestoClasif:edit.html.twig', array('edit_form'=>$form->createView()));
    }
    public function deleteAction($id)
    {
    	
        try{
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:RepuestoClasif')->find($id);
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('repuestoclasif'));
        }
        catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('repuestoclasif'));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:RepuestoClasif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatrimonioClasif entity.');
        }

         return $this->render('BackendBundle:RepuestoClasif:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
