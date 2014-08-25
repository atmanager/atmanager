<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\AtBundle\Form\AtNotaType;
use ATManager\FrontendBundle\Entity\At;
use ATManager\AtBundle\Entity\AtNota;


/**
 * AtNota controller.
 *
 */
class AtNotaController extends Controller
{
    public function indexAction(At $at)
    {
    	$em = $this->getDoctrine()->getManager();
        $entities =array();
        $entities = $em->getRepository('AtBundle:AtNota')->findByNotasPorAt($at);
        return $this->render('AtBundle:AtNota:index.html.twig', array(
        	'entities'=> $entities
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
              return $this->redirect($this->generateUrl('alasector_new'));
           }
        }
    	return $this->render('AtBundle:AtNota:new.html.twig', array(
      	   'form' => $form->createView()        
	));
    }
    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtNota')->find($id);
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
                return $this->redirect($this->generateUrl('alasector_edit', array('id' => $entity->getId())));
            }    
        }
        return $this->render('AtBundle:AtNota:edit.html.twig', array('form'=>$form->createView()));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AtBundle:AtNota')->find($id);
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

        $entity = $em->getRepository('AtBundle:AtNota')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('AtBundle:AtNota:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
