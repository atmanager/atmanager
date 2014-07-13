<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# indicar en el createForm (newAction) que tipo de form es
use ATManager\BackendBundle\Form\LocalType; 

#indicar al new (newAction) a que entidad nos referimos 
use ATManager\BackendBundle\Entity\Local; 

class LocalController extends Controller
{
#    public function indexAction($name)
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$locales = $em->getRepository('BackendBundle:Local')->findAll();


    	$paginator = $this->get('knp_paginator');
        $locales = $paginator->paginate($locales, $this->getRequest()->query->get('pagina',1), 10);
        
        return $this->render('BackendBundle:Local:index.html.twig', array(
        	'locales'=> $locales	
        ));

    }


    #    nuevo
    public function newAction()
    {
        $objLocal = new Local();
        
        $form = $this->createForm(new LocalType(), $objLocal);

        $form->handleRequest($this->getRequest());

        if ($form->isValid())
        {
          try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($objLocal);

            #commit transaccional
            $em->flush();
            
            #mensaje
            $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
            
            return $this->redirect($this->generateUrl('local_listado'));
          }
          catch(\Exception $e){
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar agregar un nuevo item');  
            return $this->redirect($this->generateUrl('local_listado'));
          }

        }
        

    	return $this->render('BackendBundle:Local:new.html.twig', array(
      'form' => $form->createView()        ));
    }

    #    editar
    public function editAction($id)
    {
      
        $em = $this->getDoctrine()->getManager();
        $objLocal = $em->getRepository('BackendBundle:Local')->find($id);
        $form = $this->createForm(new LocalType(), $objLocal);

        $form->handleRequest($this->getRequest());

        if ($form->isValid())
        {
          $em->persist($objLocal);
          $em->flush();
          $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
          return $this->redirect($this->generateUrl('local_listado'));

        }


      return $this->render('BackendBundle:Local:edit.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objLocal = $em->getRepository('BackendBundle:Local')->find($id);
            $em->remove($objLocal); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('local_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('local_listado'));
        }
       
        
    }
}