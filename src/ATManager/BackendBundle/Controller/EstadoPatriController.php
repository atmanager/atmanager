<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATManager\BackendBundle\Entity\EstadoPatri;
use ATManager\BackendBundle\Form\EstadoPatriType;

/**
 * EstadoPatri controller.
 *
 */
class EstadoPatriController extends Controller
{

     /**
     * Lists all Prioridad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:EstadoPatri')->findAll();

        return $this->render('BackendBundle:EstadoPatri:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function newAction()
    {
        $entity = new EstadoPatri();
        $form = $this->createForm(new EstadoPatriType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('estadopatri_show', array('id' => $entity->getId())));
            }
        catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
         //       return $this->redirect($this->generateUrl('estadopatri_new'));
            }
        }
        return $this->render('BackendBundle:EstadoPatri:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Prioridad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:EstadoPatri')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoPatri entity.');
        }

        return $this->render('BackendBundle:EstadoPatri:show.html.twig', array(
            'entity'      => $entity));
    }

    /**
     * Displays a form to edit an existing Prioridad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:EstadoPatri')->find($id);
        $editForm =  $this->createForm(new EstadoPatriType(), $entity);
        $editForm->handleRequest($this->getRequest());
        if ($editForm->isValid()) {
            try{
                $em->flush();          
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('estadopatri_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
           //     return $this->redirect($this->generateUrl('estadopatri_edit', array('id' => $entity->getId())));
            }
        }
        return $this->render('BackendBundle:EstadoPatri:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objPv = $em->getRepository('BackendBundle:EstadoPatri')->find($id);
            $em->remove($objPv); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('estadopatri'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('estadopatri'));
        }      
    }
}
