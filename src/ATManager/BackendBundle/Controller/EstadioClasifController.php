<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATManager\BackendBundle\Entity\EstadioClasif;
use ATManager\BackendBundle\Form\EstadioClasifType;

/**
 * EstadioClasif controller.
 *
 */
class EstadioClasifController extends Controller
{

    /**
     * Lists all EstadioClasif entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:EstadioClasif')->findAll();

        return $this->render('BackendBundle:EstadioClasif:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EstadioClasif entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EstadioClasif();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Se agregó nueva clasificación de estadio');
            return $this->redirect($this->generateUrl('estadioclasif_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar agregar un nuevo item, posible duplicacion ...[Pres. F5]');
                return $this->redirect($this->generateUrl('estadioclasif'));
             }

            
        }

        return $this->render('BackendBundle:EstadioClasif:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a EstadioClasif entity.
    *
    * @param EstadioClasif $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(EstadioClasif $entity)
    {
        $form = $this->createForm(new EstadioClasifType(), $entity, array(
            'action' => $this->generateUrl('estadioclasif_create'),
            'method' => 'POST',
        ));

         return $form;
    }

    /**
     * Displays a form to create a new EstadioClasif entity.
     *
     */
    public function newAction()
    {
        $entity = new EstadioClasif();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:EstadioClasif:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EstadioClasif entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:EstadioClasif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadioClasif entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:EstadioClasif:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing EstadioClasif entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:EstadioClasif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadioClasif entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:EstadioClasif:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EstadioClasif entity.
    *
    * @param EstadioClasif $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EstadioClasif $entity)
    {
        $form = $this->createForm(new EstadioClasifType(), $entity, array(
            'action' => $this->generateUrl('estadioclasif_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EstadioClasif entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:EstadioClasif')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadioClasif entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('estadioclasif_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:EstadioClasif:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EstadioClasif entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:EstadioClasif')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EstadioClasif entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estadioclasif'));
    }

    /**
     * Creates a form to delete a EstadioClasif entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estadioclasif_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


      #    borrar
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objEstClasif = $em->getRepository('BackendBundle:EstadioClasif')->find($id);
            $em->remove($objEstClasif); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('estadioclasif'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('estadioclasif'));
        }
       
        
    }
}
