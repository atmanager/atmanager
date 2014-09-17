<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Entity\Estadio;
use ATManager\BackendBundle\Form\EstadioType;

/**
 * Estadio controller.
 *
 */
class EstadioController extends Controller
{

    /**
     * Lists all Estadio entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Estadio')->findBy(array(), array('nombre'=>'ASC'));
        # findBy: primer array para where; segundo ordenacion

        return $this->render('BackendBundle:Estadio:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function newAction()
    {
        $entity = new Estadio();
        $form   = $this->createForm(new EstadioType(), $entity);
	$form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            try
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('estadio_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
         //       return $this->redirect($this->generateUrl('estadio_new'));
            }
        }
        return $this->render('BackendBundle:Estadio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Estadio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estadio entity.');
        }

        return $this->render('BackendBundle:Estadio:show.html.twig', 
            array('entity' => $entity)
        );
    }

    /**
     * Displays a form to edit an existing Estadio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Estadio')->find($id);
        $editForm = $this->createForm(new EstadioType(), $entity);
	$editForm->handleRequest($this->getRequest());
        if ($editForm->isValid()) {
            try{
		$em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('estadio_edit', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
           //     return $this->redirect($this->generateUrl('estadio_edit', array('id' => $id)));
            }
        }
        return $this->render('BackendBundle:Estadio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $obje = $em->getRepository('BackendBundle:Estadio')->find($id);
            $em->remove($obje); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('estadio'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('estadio'));
        }    
    }
}
