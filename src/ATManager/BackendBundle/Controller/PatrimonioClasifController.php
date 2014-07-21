<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Form\PatrimonioClasifType; 
use ATManager\BackendBundle\Form\BuscadorType; 
use ATManager\BackendBundle\Entity\PatrimonioClasif;  

class PatrimonioClasifController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $clasificaciones =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $clasificaciones = $em->getRepository('BackendBundle:PatrimonioClasif')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $clasificaciones = $paginator->paginate($clasificaciones, $this->getRequest()->query->get('pagina',1), 10);        
        return $this->render('BackendBundle:PatrimonioClasif:index.html.twig', array(
        	'clasificaciones'=> $clasificaciones,
            'form'=>$form->createView()	
        ));
    }
    public function newAction()
    {
        $objpc= new PatrimonioClasif();
        $form = $this->createForm(new PatrimonioClasifType(), $objpc);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())   
        {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($objpc);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('patrimonioclasif_show', array('id' => $objpc->getId())));
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
                return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
             }
        }
        return $this->render('BackendBundle:PatrimonioClasif:new.html.twig', array(
            'form' => $form->createView()
        ));
    	return $this->render('BackendBundle:PatrimonioClasif:new.html.twig');
    }
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $objpc = $em->getRepository('BackendBundle:PatrimonioClasif')->find($id);
        $form = $this->createForm(new PatrimonioClasifType(), $objpc);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $em->persist($objpc);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('patrimonioclasif_show', array('id' => $objpc->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
                return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
            }    
        }
        return $this->render('BackendBundle:PatrimonioClasif:edit.html.twig', array('form'=>$form->createView()));
    }
    public function deleteAction($id)
    {
    	
        try{
            $em = $this->getDoctrine()->getManager();
            $objpc = $em->getRepository('BackendBundle:PatrimonioClasif')->find($id);
            $em->remove($objpc); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
        }
        catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:PatrimonioClasif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatrimonioClasif entity.');
        }

         return $this->render('BackendBundle:PatrimonioClasif:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
