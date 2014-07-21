<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Entity\EstadioClasif;
use ATManager\BackendBundle\Form\EstadioClasifType;

class EstadioClasifController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:EstadioClasif')->findAll();

        return $this->render('BackendBundle:EstadioClasif:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function newAction()
    {
        $entity = new EstadioClasif();
        $form   = $this->createForm(new EstadioClasifType(), $entity);
	$form->handleRequest($this->getRequest());
	if ($form->isValid())
        {
          try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Guardado');
            return $this->redirect($this->generateUrl('estadioclasif_show', array('id' => $entity->getId())));
          }
          catch(\Exception $e){
            $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
            return $this->redirect($this->generateUrl('estadioclasif'));
          }
        }
        return $this->render('BackendBundle:EstadioClasif:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:EstadioClasif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadioClasif entity.');
        }

        return $this->render('BackendBundle:EstadioClasif:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:EstadioClasif')->find($id);
        $editForm = $this->createForm(new EstadioClasifType(), $entity);
	$editForm->handleRequest($this->getRequest());
	 if ($editForm->isValid()) {
            try{
                $em->persist($entity);
		$em->flush();
		$this->get('session')->getFlashBag()->add('success','Item actualizado');
            	return $this->redirect($this->generateUrl('estadioclasif_show', array('id' => $id)));
	    }
            catch(\Exception $e){
            	$this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item'); 
            	return $this->redirect($this->generateUrl('estadioclasif'));
            }
        }
        return $this->render('BackendBundle:EstadioClasif:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()       
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objec = $em->getRepository('BackendBundle:EstadioClasif')->find($id);
            $em->remove($objec); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('estadioclasif'));
        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('estadioclasif'));
        }
       
        
    }
}
