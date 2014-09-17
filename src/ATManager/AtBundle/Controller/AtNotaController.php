<?php

namespace ATManager\AtBundle\Controller;

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
    public function indexAction($idAt)
    {
        $sesion = $this->get('session');
       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret = $sesion->get('retorno');
    	$em = $this->getDoctrine()->getManager();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);
        $entities = $em->getRepository('AtBundle:AtNota')->findByNotasPorAt($at);
        return $this->render('AtBundle:AtNota:index.html.twig', array(
        	'entities'=> $entities,
            'at'=>$at,
            'ret'=>$ret
            
        ));
    }
    public function newAction($idAt)
    {
        $em = $this->getDoctrine()->getManager();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);
        $entity = new AtNota();
        $entity->setAt($at);
        $form = $this->createForm(new AtNotaType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
           try{
              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('at_nota_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
           //   return $this->redirect($this->generateUrl('at_nota_new',array('idAt'=>$entity->getAt()->getId())));
           }
        }
    	return $this->render('AtBundle:AtNota:new.html.twig', array(
      	   'form' => $form->createView(),
           'entity' => $entity        
	));
    }
    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtNota')->find($id);
        $form = $this->createForm(new AtNotaType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                if($form->get('eliminarImagen')->getData())
                {
                    $entity->removeUpload();
                    $entity->setPath(null);
                }  
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('at_nota_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
            //    return $this->redirect($this->generateUrl('at_nota_edit', array('id' => $entity->getId())));
            }    
        }
        return $this->render('AtBundle:AtNota:edit.html.twig', array(
            'form'=>$form->createView(),
            'entity' => $entity
            ));
    }
    public function eliminarAction($id)
    {       
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtNota')->find($id);
        try{            
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('at_nota', array('idAt'=>$entity->getAt()->getId())));
        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
          return $this->redirect($this->generateUrl('at_nota', array('idAt'=>$entity->getAt()->getId())));
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