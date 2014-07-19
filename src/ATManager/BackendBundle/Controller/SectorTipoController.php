<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ATManager\BackendBundle\Form\SectorTipoType;
use ATManager\BackendBundle\Entity\SectorTipo;

class SectorTipoController extends Controller
{

    /**
     * Lists all SectorTipo entities.
     *
     * @Route("/", name="sectortipo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:SectorTipo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SectorTipo entity.
     *
     * @Route("/{id}", name="sectortipo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:SectorTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SectorTipo entity.');
        }

        return $this->render('BackendBundle:SectorTipo:show.html.twig', 
            array('entity' => $entity)
        );
    }


   #    nuevo
    public function newAction()
    {
        $objst = new SectorTipo();
        $form = $this->createForm(new SectorTipoType(), $objst);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                  $em = $this->getDoctrine()->getManager();
                  $em->persist($objst);
                  $em->flush();
                  $this->get('session')->getFlashBag()->add('success','Item Guardado');
                  return $this->redirect($this->generateUrl('sectortipo_show', array('id' => $objst->getId())));
            }
            catch(\Exception $e){
                  $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
                  return $this->redirect($this->generateUrl('sectortipo_listado'));
            }

        }
          return $this->render('BackendBundle:SectorTipo:new.html.twig', array(
            'form' => $form->createView()));

    }   


     #    editar
    public function editAction($id)
    {
      
        $em = $this->getDoctrine()->getManager();
        $objst = $em->getRepository('BackendBundle:SectorTipo')->find($id);
        $form = $this->createForm(new SectorTipoType(), $objst);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
              	$em->persist($objst);
              	$em->flush();
              	$this->get('session')->getFlashBag()->add('success','Item actualizado');
             	return $this->redirect($this->generateUrl('sectortipo_edit', array('id' => $objst->getId())));
     	    }
            catch(\Exception $e){
           	$this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
          	return $this->redirect($this->generateUrl('sectortipo_listado'));
            }
        }
        return $this->render('BackendBundle:SectorTipo:edit.html.twig', array('form'=>$form->createView()));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objst = $em->getRepository('BackendBundle:SectorTipo')->find($id);
            $em->remove($objst); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('sectortipo_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('sectortipo_listado'));
        }
       
        
    }


}
