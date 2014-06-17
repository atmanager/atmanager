<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ATManager\BackendBundle\Entity\Sector;
use ATManager\BackendBundle\Form\SectorType;

/**
 * Sector controller.
 *
 * @Route("/sector")
 */
class SectorController extends Controller
{

    /**
     * Lists all Sector entities.
     *
     * @Route("/", name="sector")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Sector')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Sector entity.
     *
     * @Route("/", name="sector_create")
     * @Method("POST")
     * @Template("BackendBundle:Sector:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Sector();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sector_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Sector entity.
    *
    * @param Sector $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Sector $entity)
    {
        $form = $this->createForm(new SectorType(), $entity, array(
            'action' => $this->generateUrl('sector_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Sector entity.
     *
     * @Route("/new", name="sector_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Sector();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Sector entity.
     *
     * @Route("/{id}", name="sector_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Sector')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sector entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Sector entity.
     *
     * @Route("/{id}/edit", name="sector_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Sector')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sector entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Sector entity.
    *
    * @param Sector $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Sector $entity)
    {
        $form = $this->createForm(new SectorType(), $entity, array(
            'action' => $this->generateUrl('sector_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Sector entity.
     *
     * @Route("/{id}", name="sector_update")
     * @Method("PUT")
     * @Template("BackendBundle:Sector:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Sector')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sector entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sector_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Sector entity.
     *
     * @Route("/{id}", name="sector_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Sector')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sector entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sector'));
    }

    /**
     * Creates a form to delete a Sector entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sector_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
