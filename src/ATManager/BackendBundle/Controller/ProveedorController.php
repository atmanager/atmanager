<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATManager\BackendBundle\Entity\Proveedor;
use ATManager\BackendBundle\Form\ProveedorType;
use ATManager\BackendBundle\Form\BuscadorType; 

/**
 * Proveedor controller.
 *
 */
class ProveedorController extends Controller
{

    /**
     * Lists all Proveedor entities.
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
            $entities = $em->getRepository('BackendBundle:Proveedor')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Proveedor:index.html.twig', array(
            'entities' => $entities,
            'form'=>$form->createView()
        ));
    }
    /**
     * Creates a new Proveedor entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Proveedor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Proveedor Guardado');
                return $this->redirect($this->generateUrl('proveedor_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('success','Error al guardar, posible duplicacion ...[Pres. F5]');
                return $this->redirect($this->generateUrl('proveedor'));
            }
        }

        return $this->render('BackendBundle:Proveedor:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Proveedor entity.
    *
    * @param Proveedor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Proveedor $entity)
    {
        $form = $this->createForm(new ProveedorType(), $entity, array(
            'action' => $this->generateUrl('proveedor_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Displays a form to create a new Proveedor entity.
     *
     */
    public function newAction()
    {
        $entity = new Proveedor();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:Proveedor:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Proveedor entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }
        return $this->render('BackendBundle:Proveedor:show.html.twig', array(
            'entity'      => $entity,
            ));
    }

    /**
     * Displays a form to edit an existing Proveedor entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('BackendBundle:Proveedor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Proveedor entity.
    *
    * @param Proveedor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Proveedor $entity)
    {
        $form = $this->createForm(new ProveedorType(), $entity, array(
            'action' => $this->generateUrl('proveedor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing Proveedor entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            try{
                $em->flush();
                return $this->redirect($this->generateUrl('proveedor_edit', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('success','Error al editar, posible duplicacion ...[Pres. F5]');
                return $this->redirect($this->generateUrl('proveedor'));
            }
        }

        return $this->render('BackendBundle:Proveedor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    /**
     * Deletes a Proveedor entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Proveedor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proveedor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('proveedor'));
    }

    /**
     * Creates a form to delete a Proveedor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proveedor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objp = $em->getRepository('BackendBundle:Proveedor')->find($id);
            $em->remove($objp); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('proveedor'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('proveedor'));
        }     
    }
}
