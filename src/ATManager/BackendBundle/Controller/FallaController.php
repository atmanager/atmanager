<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ATManager\BackendBundle\Entity\Falla;
use ATManager\BackendBundle\Form\FallaType;

/**
 * Falla controller.
 *
 * @Route("/falla")
 */
class FallaController extends Controller
{

    /**
     * Lists all Falla entities.
     *
     * @Route("/", name="falla")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Falla')->findAll();

        return $this->render('BackendBundle:Falla:index.html.twig', array(
            'entities' => $entities,
        ));

    }
    /**
     * Creates a new Falla entity.
     *
     * @Route("/", name="falla_create")
     * @Method("POST")
     * @Template("BackendBundle:Falla:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Falla();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('falla_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Falla entity.
    *
    * @param Falla $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Falla $entity)
    {
        $form = $this->createForm(new FallaType(), $entity, array(
            'action' => $this->generateUrl('falla_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Falla entity.
     *
     * @Route("/new", name="falla_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Falla();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Falla entity.
     *
     * @Route("/{id}", name="falla_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Falla')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Falla entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Falla entity.
     *
     * @Route("/{id}/edit", name="falla_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Falla')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Falla entity.');
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
    * Creates a form to edit a Falla entity.
    *
    * @param Falla $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Falla $entity)
    {
        $form = $this->createForm(new FallaType(), $entity, array(
            'action' => $this->generateUrl('falla_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing Falla entity.
     *
     * @Route("/{id}", name="falla_update")
     * @Method("PUT")
     * @Template("BackendBundle:Falla:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Falla')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Falla entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('falla_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Falla entity.
     *
     * @Route("/{id}", name="falla_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Falla')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Falla entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('falla'));
    }

    /**
     * Creates a form to delete a Falla entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('falla_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }
}
