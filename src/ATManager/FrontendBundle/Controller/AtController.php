<?php

namespace ATManager\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ATManager\FrontendBundle\Entity\At;
use ATManager\AtBundle\Entity\AtHistorico;
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
            

            $atHistorico= new atHistorico();
            $atHistorico->setAt($entity);
            
            $em = $this->getDoctrine()->getManager();
            
            $clasificacion = $em->getRepository('BackendBundle:EstadioClasif')->findOneByIniciaAt(true);
            $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasificacion);
            $atHistorico->setEstadio($estadio);
            $atHistorico->setComentario('Inicializado');
            $em->persist($atHistorico);


            $em->flush();


            return $this->redirect($this->generateUrl('at_show', array('id' => $entity->getId())));

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

        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontendBundle:At:show.html.twig', 
            array('entity' => $entity)
        );
    }


  
     
    
    private function createDeleteForm($id)
    {

            return $this->createFormBuilder()
            ->setAction($this->generateUrl('at_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }


      public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:At')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find At entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('at'));
    }  

     public function verHistoricoAction(Request $request, $id)
    {
        
                  
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:At')->find($id);
            
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find At entity.');
            }

        return $this->render('FrontendBundle:At:showHistorico.html.twig', array(
            'entity' => $entity,
        ));
    }  



    
}
