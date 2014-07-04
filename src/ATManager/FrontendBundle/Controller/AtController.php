<?php

namespace ATManager\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\FrontendBundle\Entity\At;
use ATManager\FrontendBundle\Form\AtType;


class AtController extends Controller
{

    
  
    public function createAction(Request $request)
    {
        $entity = new At();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('at_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

  
    private function createCreateForm(At $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new AtType($em), $entity, array(
            'action' => $this->generateUrl('at_new'),
            'method' => 'POST'
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    
    public function newAction(Request $request)
    {
        $entity = new At();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $entity->setIpsolicita($request->getClientIp());
            //$entity->setIpsolicita($request->getHost());

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

        } 
        return $this->render('FrontendBundle:At:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

   
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:At')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find At entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

   
    
}
