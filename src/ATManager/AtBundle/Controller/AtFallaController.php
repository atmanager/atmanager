<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ATManager\AtBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\AtBundle\Entity\AtFalla;
use ATManager\AtBundle\Form\AtFallaType;
class AtFallaController extends Controller
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

        $entities = $em->getRepository('AtBundle:AtFalla')->findByFallasPorAt($at);
        return $this->render('AtBundle:AtFalla:index.html.twig', array(
        	'entities'=> $entities,
                'at'=>$at,
                'ret'=>$ret
        ));
    }

    public function newAction($idAt)
    {
        $em = $this->getDoctrine()->getManager();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);
        $entity = new AtFalla();
        $entity->setAt($at);
        $objtl = $this->get('security.context')->getToken()->getUser();
        $opciones = $objtl->getSector();
        $form = $this->createForm(new AtFallaType($opciones), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
           try{
              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('at_falla_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error',$e->getMessage()); 
              return $this->redirect($this->generateUrl('at_falla_new', array('idAt' => $at->getId())));
           }
        }
    	return $this->render('AtBundle:AtFalla:new.html.twig', array(
      	   'form' => $form->createView(),
           'entity' => $entity        
	));
    }


    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtFalla')->find($id);
        $form = $this->createForm(new AtFallaType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('at_falla_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
                return $this->redirect($this->generateUrl('at_falla_edit', array('id' => $entity->getId())));
            }    
        }
        return $this->render('AtBundle:AtFalla:edit.html.twig', array(
            'form'=>$form->createView(),
            'entity' => $entity
            ))
             ;
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();         
            $entity = $em->getRepository('AtBundle:AtFalla')->find($id);
            $atId = $entity->getAt()->getId();
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('at_falla', array('idAt'=>$atId)) );
        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('at_falla', array('idAt'=>$atId)) );
        }    
    }


    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtBundle:AtFalla')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('AtBundle:AtFalla:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
