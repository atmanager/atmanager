<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ATManager\AtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\AtBundle\Entity\AtServicioTercero;
use ATManager\AtBundle\Form\AtServicioType;

class AtServicioTerceroController extends Controller
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
        $clasif=$em->getRepository('BackendBundle:EstadioClasif')->findByServicioAt(true);
        $esta = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasif);
        $estadio=$em->getRepository('AtBundle:AtHistorico')->findByEstadiosPuntalesAt($at,$esta);      
        if($estadio)
        {
            $entities = $em->getRepository('AtBundle:AtServicioTercero')->findByServiciosPorAt($at);
            return $this->render('AtBundle:Atservicio:index.html.twig', array(
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
        $entity = new AtServicioTercero();
        $entity->setAt($at);
        $form = $this->createForm(new AtServicioType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
           try{
              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('at_servicio_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error',$e->getMessage()); 
             // return $this->redirect($this->generateUrl('at_servicio_new', array('idAt' => $entity->getAt()->getId())));
           }
        }
    	return $this->render('AtBundle:Atservicio:new.html.twig', array(
      	   'form' => $form->createView(),
           'entity' => $entity        
	));
    }
    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtServicioTercero')->find($id);
        $form = $this->createForm(new AtServicioType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('at_servicio_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
            //    return $this->redirect($this->generateUrl('at_servicio_edit', array('id' => $entity->getId())));
            }    
        }
        return $this->render('AtBundle:Atservicio:edit.html.twig', array(
            'form'=>$form->createView(),
            'entity' => $entity
        ));
    }
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();         
        $entity = $em->getRepository('AtBundle:AtServicioTercero')->find($id);
        try{            
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('at_servicio', array('idAt'=>$entity->getAt()->getId())));
        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('at_servicio', array('idAt'=>$entity->getAt()->getId())));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtBundle:AtServicioTercero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('AtBundle:Atservicio:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
