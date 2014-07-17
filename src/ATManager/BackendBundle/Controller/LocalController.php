<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# indicar en el createForm (newAction) que tipo de form es
use ATManager\BackendBundle\Form\LocalType; 

#indicar al new (newAction) a que entidad nos referimos 
use ATManager\BackendBundle\Entity\Local; 
use ATManager\BackendBundle\Form\BuscadorType;

class LocalController extends Controller
{
#    public function indexAction($name)
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $locales =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $locales = $em->getRepository('BackendBundle:Local')->findByName($nombre);
        }
    	$paginator = $this->get('knp_paginator');
        $locales = $paginator->paginate($locales, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Local:index.html.twig', array(
        	'locales'=> $locales,
            'form'=>$form->createView()	
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
            $this->get('session')->getFlashBag()->add('error','Hubo un error al intentar agregar un nuevo item');  
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
            try{  
                $em->persist($objLocal);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
                return $this->redirect($this->generateUrl('local_listado'));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Hubo un error al intentar agregar un nuevo item');  
                return $this->redirect($this->generateUrl('local_listado'));
          }    

        }


      return $this->render('BackendBundle:Local:edit.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objl = $em->getRepository('BackendBundle:Local')->find($id);
            $em->remove($objl); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('local_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('local_listado'));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Local')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('BackendBundle:Local:show.html.twig', 
            array('entity' => $entity)
        );
    }
}