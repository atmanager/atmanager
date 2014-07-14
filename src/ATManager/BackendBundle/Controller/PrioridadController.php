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
    /**
     * Creates a new Prioridad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Prioridad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Prioridad Guardada');
                return $this->redirect($this->generateUrl('prioridad_show', array('id' => $entity->getId())));
            }catch(\Exception $e){
                    $this->get('session')->getFlashBag()->add('success','Error al intentar agregar un items..');
                    return $this->redirect($this->generateUrl('prioridad_listado', array('id' => $entity->getId())));
                   }
        }

        return $this->render('BackendBundle:Prioridad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Prioridad entity.
    *
    * @param Prioridad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Prioridad $entity)
    {
        $form = $this->createForm(new PrioridadType(), $entity, array(
            'action' => $this->generateUrl('prioridad_create'),
            'method' => 'POST',
        ));

        // $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Prioridad entity.
     *
     */
    public function newAction()
    {
        $entity = new Prioridad();
        $form   = $this->createCreateForm($entity);

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

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Prioridad:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Prioridad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Prioridad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prioridad entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Prioridad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Prioridad entity.
    *
    * @param Prioridad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Prioridad $entity)
    {
        $form = $this->createForm(new PrioridadType(), $entity, array(
            'action' => $this->generateUrl('prioridad_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

      //  $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Prioridad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Prioridad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prioridad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            try{
                $em->flush();          
                $this->get('session')->getFlashBag()->add('success','Prioridad actualiza..');
                return $this->redirect($this->generateUrl('prioridad_edit', array('id' => $entity->getId())));
            }catch(\Exception $e){
                        $this->get('session')->getFlashBag()->add('success','Error al intentar actualizar un items..');
                        return $this->redirect($this->generateUrl('prioridad_listado', array('id' => $entity->getId())));
                    }


        }

        return $this->render('BackendBundle:Prioridad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Prioridad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Prioridad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prioridad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('prioridad_listado'));
    }

    /**
     * Creates a form to delete a Prioridad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prioridad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objPv = $em->getRepository('BackendBundle:Prioridad')->find($id);
            $em->remove($objPv); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('prioridad_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('prioridad_listado'));
        }
       
        
    }
}
