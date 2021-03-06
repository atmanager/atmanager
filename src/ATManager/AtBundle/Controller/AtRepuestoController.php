<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ATManager\AtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\AtBundle\Entity\AtRepuesto;
use ATManager\AtBundle\Form\AtRepuestoType;

class AtRepuestoController extends Controller
{
    public function indexAction($idAt)
    {
        $sesion = $this->get('session');
       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret = $sesion->get('retorno');
    	$em = $this->getDoctrine()->getManager();
        $entities =array();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);
        $clasif=$em->getRepository('BackendBundle:EstadioClasif')->findByRepuestoAt(true);
        $esta = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasif);
        $estadio=$em->getRepository('AtBundle:AtHistorico')->findByEstadiosPuntalesAt($at,$esta);
        if($estadio)
        {
            $entities = $em->getRepository('AtBundle:AtRepuesto')->findByRepuestosPorAt($at);
            return $this->render('AtBundle:Atrepuesto:index.html.twig', array(
        	'entities'=> $entities,
                'at'=>$at,
                'ret'=>$ret
            ));                   
        }
        else
        {
            $this->get('session')->getFlashBag()->add('error','En evolución debe existir estadio: '.$esta);
            return $this->redirect($ret); 
        }      
    }
    public function newAction($idAt)
    {
        $em = $this->getDoctrine()->getManager();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);
        $entity = new AtRepuesto();
        $entity->setAt($at);
        $form = $this->createForm(new AtRepuestoType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
           try{
              $em->persist($entity);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('at_repuesto_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
            //  return $this->redirect($this->generateUrl('at_repuesto_new',array('idAt' => $entity->getAt()->getId())));
           }
        }
    	return $this->render('AtBundle:Atrepuesto:new.html.twig', array(
      	   'form' => $form->createView(),
           'entity' => $entity        
	));
    }
    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtRepuesto')->find($id);
        $form = $this->createForm(new AtRepuestoType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('at_repuesto_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
            //    return $this->redirect($this->generateUrl('at_repuesto_edit', array('id' => $entity->getId())));
            }    
        }
        return $this->render('AtBundle:Atrepuesto:edit.html.twig', array(
            'form'=>$form->createView(),
            'entity' => $entity
            ));
    }
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();         
        $entity = $em->getRepository('AtBundle:AtRepuesto')->find($id);
        try{
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('at_repuesto', array('idAt'=>$entity->getAt()->getId())));
        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('at_repuesto', array('idAt'=>$entity->getAt()->getId())));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtBundle:AtRepuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('AtBundle:Atrepuesto:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
