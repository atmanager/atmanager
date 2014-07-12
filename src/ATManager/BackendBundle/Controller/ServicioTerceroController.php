<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATManager\BackendBundle\Entity\ServicioTercero;
use ATManager\BackendBundle\Form\ServicioTerceroType;

/**
 * ServicioTercero controller.
 *
 */
class ServicioTerceroController extends Controller
{

    /**
     * Lists all ServicioTercero entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:ServicioTercero')->findAll();

        return $this->render('BackendBundle:ServicioTercero:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ServicioTercero entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ServicioTercero();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('serviciotercero_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:ServicioTercero:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ServicioTercero entity.
    *
    * @param ServicioTercero $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ServicioTercero $entity)
    {
        $form = $this->createForm(new ServicioTerceroType(), $entity, array(
            'action' => $this->generateUrl('serviciotercero_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ServicioTercero entity.
     *
     */
    public function newAction()
    {
        $entity = new ServicioTercero();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:ServicioTercero:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ServicioTercero entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ServicioTercero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioTercero entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ServicioTercero:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing ServicioTercero entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ServicioTercero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioTercero entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ServicioTercero:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ServicioTercero entity.
    *
    * @param ServicioTercero $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ServicioTercero $entity)
    {
        $form = $this->createForm(new ServicioTerceroType(), $entity, array(
            'action' => $this->generateUrl('serviciotercero_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ServicioTercero entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ServicioTercero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioTercero entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('serviciotercero_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:ServicioTercero:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ServicioTercero entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:ServicioTercero')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ServicioTercero entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('serviciotercero'));
    }

    /**
     * Creates a form to delete a ServicioTercero entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('serviciotercero_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
