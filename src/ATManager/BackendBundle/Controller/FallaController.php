<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ATManager\BackendBundle\Entity\Falla;
use ATManager\BackendBundle\Form\FallaType;
use ATManager\BackendBundle\Form\BuscadorType;
/**
 * Falla controller.
 *
 * @Route("/falla")
 */
class FallaController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $entities = $em->getRepository('BackendBundle:Falla')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);        

        return $this->render('BackendBundle:Falla:index.html.twig', array(
            'entities' => $entities,
            'form'=>$form->createView()
        ));
    }
    public function newAction(Request $request)
    {
        $entity = new Falla();
        $form   = $this->createForm(new FallaType(), $entity, array(
        'action' => $this->generateUrl('falla_new'),
        'attr'=>array('id'=>'formFalla')
        ));

	    $form->handleRequest($request);

        if ($form->isValid()) 
        {
            try{  
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                if($request->isXmlHttpRequest()){ 
                    $datos=array(
                     'id'=>$entity->getId(),
                     'nombre'=>$entity->getNombre()
                     );
                    return new JsonResponse($datos);
                }
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('falla_show', array('id' => $entity->getId())));                
            }

            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
             //   return $this->redirect($this->generateUrl('falla_new'));
             }

        }elseif($request->isXmlHttpRequest()){
             $html = $this->renderView('BackendBundle:Falla:form.html.twig', array(
             'formFalla'   => $form->createView(),
            ));
             return new Response($html,400);

        }

        return $this->render('BackendBundle:Falla:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
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

        return $this->render('BackendBundle:Falla:show.html.twig', 
            array('entity' => $entity)
        );
    }
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Falla')->find($id);
        $editForm = $this->createForm(new FallaType(), $entity);
        $editForm->handleRequest($this->getRequest());
	if ($editForm->isValid()) {
            try{
		$em->persist($entity);
            	$em->flush();
            	$this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('falla_edit', array('id' => $id)));
            }
	    catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
            //    return $this->redirect($this->generateUrl('falla_edit', array('id' => $id)));
            }
	}
        return $this->render('BackendBundle:Falla:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()            
        ));
    }
    public function eliminarAction($id)
    {                
          try{
                $em = $this->getDoctrine()->getManager();
                $objf = $em->getRepository('BackendBundle:Falla')->find($id);
                $objf->setEstado(false);
                $em->persist($objf);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Eliminado');
                return $this->redirect($this->generateUrl('falla_listado'));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');  
                return $this->redirect($this->generateUrl('falla_listado'));
            }     
    }
}