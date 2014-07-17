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
    /**
     * Creates a new Repuesto entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Repuesto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Nuevo items agregado... ');
                return $this->redirect($this->generateUrl('repuesto_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al guardar, posible duplicacion ...[Pres. F5]');
                return $this->redirect($this->generateUrl('repuesto'));
            }
        }

        return $this->render('BackendBundle:Repuesto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Repuesto entity.
    *
    * @param Repuesto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Repuesto $entity)
    {
        $form = $this->createForm(new RepuestoType(), $entity, array(
            'action' => $this->generateUrl('repuesto_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Displays a form to create a new Repuesto entity.
     *
     */
    public function newAction()
    {
        $entity = new Repuesto();
        $form   = $this->createCreateForm($entity);

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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repuesto entity.');
        }

        $editForm = $this->createEditForm($entity);
        
        return $this->render('BackendBundle:Repuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Repuesto entity.
    *
    * @param Repuesto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Repuesto $entity)
    {
        $form = $this->createForm(new RepuestoType(), $entity, array(
            'action' => $this->generateUrl('repuesto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing Repuesto entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Repuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repuesto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            try{
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Actualizacion correcta...');
                return $this->redirect($this->generateUrl('repuesto_edit', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al guardar, posible duplicacion ...[Pres. F5]');
                return $this->redirect($this->generateUrl('repuesto'));
            }
        }

        return $this->render('BackendBundle:Repuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Repuesto entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Repuesto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Repuesto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('repuesto'));
    }

    /**
     * Creates a form to delete a Repuesto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('repuesto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objs = $em->getRepository('BackendBundle:Repuesto')->find($id);
            $em->remove($objs); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('repuesto'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al borrar...');
            return $this->redirect($this->generateUrl('repuesto'));
        }     
    }
}
