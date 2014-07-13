<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# indicar en el createForm (newAction) que tipo de form es
use ATManager\BackendBundle\Form\PatrimonioClasifType; 

#indicar al new (newAction) a que entidad nos referimos 
use ATManager\BackendBundle\Entity\PatrimonioClasif;  

class PatrimonioClasifController extends Controller
{
#    listado
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$clasificaciones = $em->getRepository('BackendBundle:PatrimonioClasif')->findAll();
        $paginator = $this->get('knp_paginator');
        $clasificaciones = $paginator->paginate($clasificaciones, $this->getRequest()->query->get('pagina',1), 10);        
        return $this->render('BackendBundle:PatrimonioClasif:index.html.twig', array(
        	'clasificaciones'=> $clasificaciones	
        ));

    }


    #    nuevo
    public function newAction()
    {

        $objPatClasif = new PatrimonioClasif();
        $form = $this->createForm(new PatrimonioClasifType(), $objPatClasif);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())   // solo ingresa si el FORM esta completo
        {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($objPatClasif);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
                return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
            }catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar agregar un nuevo item, posible duplicacion ...[Pres. F5]');
                return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
             }
        }
        return $this->render('BackendBundle:PatrimonioClasif:new.html.twig', array(
            'form' => $form->createView()
        ));



    	return $this->render('BackendBundle:PatrimonioClasif:new.html.twig');
    }

    #    editar
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $objPatClasif = $em->getRepository('BackendBundle:PatrimonioClasif')->find($id);
        $form = $this->createForm(new PatrimonioClasifType(), $objPatClasif);

        $form->handleRequest($this->getRequest());

        if ($form->isValid())
        {
            try{
                $em->persist($objPatClasif);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
                return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar agregar un nuevo item, posible duplicacion ...[Pres. F5]');
                return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
            }    
        }


        return $this->render('BackendBundle:PatrimonioClasif:edit.html.twig', array('form'=>$form->createView()));

    	
    }

    #    borrar
    public function deleteAction($id)
    {
    	
        try{
            $em = $this->getDoctrine()->getManager();
            $objPatClasif = $em->getRepository('BackendBundle:PatrimonioClasif')->find($id);
            $em->remove($objPatClasif); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('patrimonioat_listado'));
        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('patrimonioclasif_listado'));
        }
        
    }
}
