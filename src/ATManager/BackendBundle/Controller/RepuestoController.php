<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Entity\Repuesto;
use ATManager\BackendBundle\Form\RepuestoType;
use ATManager\BackendBundle\Form\BuscadorType; 
/**
 * Repuesto controller.
 *
 */
class RepuestoController extends Controller
{

    /**
     * Lists all Repuesto entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =array();

        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $entities = $em->getRepository('BackendBundle:Repuesto')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Repuesto:index.html.twig', array(
            'entities' => $entities,
            'form'=>$form->createView()
        ));
    }
    public function newAction()
    {
        $entity = new Repuesto();
        $form = $this->createForm(new RepuestoType(), $entity);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('repuesto_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
                return $this->redirect($this->generateUrl('repuesto'));
            }
        }

        return $this->render('BackendBundle:Repuesto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Repuesto entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Repuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repuesto entity.');
        }

        return $this->render('BackendBundle:Repuesto:show.html.twig', array(
            'entity'      => $entity));
    }

    /**
     * Displays a form to edit an existing Repuesto entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Repuesto')->find($id);
        $editForm = $this->createForm(new RepuestoType(), $entity);
        $editForm->handleRequest($this->getRequest());
	if ($editForm->isValid()) {
            try{
		$em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('repuesto_show', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
                return $this->redirect($this->generateUrl('repuesto'));
            }
        }
        return $this->render('BackendBundle:Repuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objs = $em->getRepository('BackendBundle:Repuesto')->find($id);
            $em->remove($objs); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('repuesto'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('repuesto'));
        }     
    }
}
