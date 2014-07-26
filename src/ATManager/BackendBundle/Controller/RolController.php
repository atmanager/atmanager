<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Entity\Rol;
use ATManager\BackendBundle\Form\RolType;

/**
 * Rol controller.
 *
 */
class RolController extends Controller
{

    /**
     * Lists all Rol entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Rol')->findAll();

        return $this->render('BackendBundle:Rol:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function newAction()
    {
        $entity = new Rol();
        $form = $this->createForm(new RolType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
           try{
            	$em = $this->getDoctrine()->getManager();
            	$em->persist($entity);
            	$em->flush();
            	$this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('rol_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
                return $this->redirect($this->generateUrl('rol_new'));
             }
        }
        return $this->render('BackendBundle:Rol:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Finds and displays a Rol entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Rol')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rol entity.');
        }

        return $this->render('BackendBundle:Rol:show.html.twig', array(
            'entity'      => $entity
        ));
    }

    /**
     * Displays a form to edit an existing Rol entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Rol')->find($id);
        $editForm = $this->createForm(new RolType(), $entity);
	$editForm->handleRequest($this->getRequest());
	if ($editForm->isValid()) {
           
            try{
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('rol_edit', array('id' => $id)));
            }
             catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
                return $this->redirect($this->generateUrl('rol_edit', array('id' => $id)));
             }
        }
        return $this->render('BackendBundle:Rol:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objr = $em->getRepository('BackendBundle:Rol')->find($id);
            $em->remove($objr); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('rol'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('rol'));
        }     
    }
}
