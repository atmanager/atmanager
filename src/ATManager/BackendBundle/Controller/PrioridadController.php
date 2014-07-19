<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Entity\Prioridad;
use ATManager\BackendBundle\Form\PrioridadType;

/**
 * Prioridad controller.
 *
 */
class PrioridadController extends Controller
{

    /**
     * Lists all Prioridad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Prioridad')->findAll();

        return $this->render('BackendBundle:Prioridad:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function newAction()
    {
        $entity = new Prioridad();
        $form = $this->createForm(new PrioridadType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('prioridad_show', array('id' => $entity->getId())));
            }
	    catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
                return $this->redirect($this->generateUrl('prioridad_listado'));
            }
        }
        return $this->render('BackendBundle:Prioridad:new.html.twig', array(
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
        $entity = $em->getRepository('BackendBundle:Prioridad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prioridad entity.');
        }

        return $this->render('BackendBundle:Prioridad:show.html.twig', array(
            'entity'      => $entity));
    }

    /**
     * Displays a form to edit an existing Prioridad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Prioridad')->find($id);
        $editForm =  $this->createForm(new PrioridadType(), $entity);
	$editForm->handleRequest($this->getRequest());
	if ($editForm->isValid()) {
            try{
                $em->flush();          
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('prioridad_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
                return $this->redirect($this->generateUrl('prioridad_listado'));
            }
        }
        return $this->render('BackendBundle:Prioridad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objPv = $em->getRepository('BackendBundle:Prioridad')->find($id);
            $em->remove($objPv); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('prioridad_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('prioridad_listado'));
        }      
    }
}
