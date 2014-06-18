<?php

namespace ATManager\PatrimonioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATManager\PatrimonioBundle\Entity\Patrimonio;
use ATManager\PatrimonioBundle\Form\PatrimonioType;
use ATManager\PatrimonioBundle\Form\PatrimonioBuscadorType;

/**
 * Patrimonio controller.
 *
 */
class PatrimonioController extends Controller
{

    /**
     * Lists all Patrimonio entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new PatrimonioBuscadorType(), null, array(
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        $entities = array();

        if ($form->isValid()) {
            $descripcion=$form->get('descripcion')->getData();
            $clasificacion=$form->get('clasificacion')->getData();
            $local=$form->get('local')->getData();
            $marca=$form->get('marca')->getData();

            $entities = $em->getRepository('PatrimonioBundle:Patrimonio')->findByFiltroPatrimonio($descripcion, $clasificacion, $local, $marca);




        }

        #$entities = $em->getRepository('PatrimonioBundle:Patrimonio')->findAll();


        // $dql = "select p from PatrimonioBundle:Patrimonio p where p.descripcion like :descripcion";
        // $query = $em->createQuery($dql);
        // $query->setParameter('descripcion', '%MONITOR%');
        // $entities = $query->getResult();        

        // #$entities = $em->getRepository('PatrimonioBundle:Patrimonio')->findBy(array('descripcion' => 'CARRO PORTABOLSA COLOR NEGRO'));
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('PatrimonioBundle:Patrimonio:index.html.twig', array(
            'entities' => $entities, 
            'form'=>$form->createView()
        ));
    }
    /**
     * Creates a new Patrimonio entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Patrimonio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('patrimonio_show', array('id' => $entity->getId())));
        }

        return $this->render('PatrimonioBundle:Patrimonio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Patrimonio entity.
    *
    * @param Patrimonio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Patrimonio $entity)
    {
        $form = $this->createForm(new PatrimonioType(), $entity, array(
            'action' => $this->generateUrl('patrimonio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Nuevo/Guardar'));

        return $form;
    }

    /**
     * Displays a form to create a new Patrimonio entity.
     *
     */
    public function newAction()
    {
        $entity = new Patrimonio();
        $form   = $this->createCreateForm($entity);

        return $this->render('PatrimonioBundle:Patrimonio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Patrimonio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patrimonio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PatrimonioBundle:Patrimonio:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Patrimonio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patrimonio entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PatrimonioBundle:Patrimonio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Patrimonio entity.
    *
    * @param Patrimonio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Patrimonio $entity)
    {
        $form = $this->createForm(new PatrimonioType(), $entity, array(
            'action' => $this->generateUrl('patrimonio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Editar'));

        return $form;
    }
    /**
     * Edits an existing Patrimonio entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patrimonio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('patrimonio_edit', array('id' => $id)));
        }

        return $this->render('PatrimonioBundle:Patrimonio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Patrimonio entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Patrimonio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('patrimonio'));
    }

    /**
     * Creates a form to delete a Patrimonio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patrimonio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }
}
