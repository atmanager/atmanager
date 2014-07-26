<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints as Assert;
use ATManager\BackendBundle\Form\MarcaType; 
use ATManager\BackendBundle\Entity\Marca; 
use Symfony\Component\HttpFoundation\Request;
use ATManager\BackendBundle\Form\BuscadorType;  

class MarcaController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $marcas =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $marcas = $em->getRepository('BackendBundle:Marca')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $marcas = $paginator->paginate($marcas, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Marca:index.html.twig', array(
        	'marcas'=> $marcas,
            'form'=>$form->createView() 	
        ));
    }
    public function newAction()
    {
        $objm = new Marca();
        $form = $this->createForm(new MarcaType(), $objm);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
          try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($objm);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Guardado');
            return $this->redirect($this->generateUrl('marca_show', array('id' => $objm->getId())));
          }
          catch(\Exception $e){
            $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
            return $this->redirect($this->generateUrl('marca_nuevo'));
          }
        }
    	return $this->render('BackendBundle:Marca:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Marca')->find($id);
        $form = $this->createForm(new MarcaType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('marca_editar', array('id' => $id)));
                }
            catch(\Exception $e)
            {
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item'); 
               return $this->redirect($this->generateUrl('marca_editar', array('id' => $id)));
            }
        }
    	return $this->render('BackendBundle:Marca:edit.html.twig',array(
            'entity'=>'$entity',
            'form'=>$form->createView()));
    }
   
    public function deleteAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objMarca = $em->getRepository('BackendBundle:Marca')->find($id);
            $em->remove($objMarca); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('marca_listado'));
        }
        catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('marca_listado'));
        }    	
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Marca')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('BackendBundle:Marca:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
