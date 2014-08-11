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
use ATManager\FrontendBundle\Form\AtEditType;
use ATManager\FrontendBundle\Form\AtBuscadorType; 


class AtController extends Controller
{
    
    public function newAction()
    {
        $entity = new At();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new AtType($em), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                # evalua,  si el patrimonio esta de baja no permite abrir la atencion
                if($entity->getPatrimonio())
                {   
                    $objPatri = $entity->getPatrimonio();
                    if($objPatri->getHabilita()==false)
                    {    
                        $request->getSession()->getFlashBag()->add('error',$objPatri->getDescripcion()." : Esta de baja !!, no se acepta Solicitud de AT " ); 
                        return $this->redirect($this->generateUrl('at_new'));
                    }
                }    
                $entity->setIpsolicita($this->container->get('request')->getClientIp());
                
                $em->persist($entity);
                $atHistorico= new atHistorico();
                $atHistorico->setAt($entity);
                $clasificacion = $em->getRepository('BackendBundle:EstadioClasif')->findOneByIniciaAt(true);
                $estadio = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasificacion);
                $atHistorico->setEstadio($estadio);
                $atHistorico->setComentario('Inicializado');
                $em->persist($atHistorico);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Solicitud Aceptada');
                return $this->redirect($this->generateUrl('at_show', array('id' => $entity->getId())));
            }catch(\Exception $ex){
                $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
                return $this->redirect($this->generateUrl('at_new'));
            }
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


        return $this->render('FrontendBundle:At:show.html.twig', 
            array('entity' => $entity)
        );
    }

    public function verHistoricoAction($id)
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


    public function verUltimoEstadioAction($id)
    {
        
        try{
                $em = $this->getDoctrine()->getManager();
                $estadio = $em->getRepository('FrontendBundle:At')->findByFiltroUltimoEstadio($id);
                $esta = $em->getRepository('BackendBundle:Estadio')->find($estadio);
                echo "".$esta;

               if (!$estadio)
               {
                    throw $this->createNotFoundException('No pude obtener el ultimo estadio');
               }

               echo "Estadio ".$estadio;

               
                return $this->redirect($this->generateUrl('at_buscador'));
            
       
            }catch(\Exception $ex){        
                $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
             return $this->redirect($this->generateUrl('at_buscador'));
        }
            
    } 


    public function buscadorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(new AtBuscadorType(), null, array(
            'method' => 'GET'
        ));

	   $form->handleRequest($request);
        if ($form->isValid())
        {
	        $entities =array();        	
            $numero=$form->get('numero')->getData();
            $personasolicita=$form->get('personasolicita')->getData();
            $sectorsolicita=$form->get('sectorsolicita')->getData();
            if($numero=="" and $personasolicita=="" and $sectorsolicita==""){
                $this->get('session')->getFlashBag()->add('error','Introduce algún criterio');
                return $this->render('FrontendBundle:At:find.html.twig', array(
                            'form'=>$form->createView(),
                ));        
            }

            $entities = $em->getRepository('FrontendBundle:At')->findByFiltroAt($numero, $personasolicita, $sectorsolicita);
                $paginator = $this->get('knp_paginator');
                $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
                return $this->render('FrontendBundle:At:index.html.twig', array( 
                    'form'=>$form->createView(),
		              'entities' => $entities 	
                ));
        }
        return $this->render('FrontendBundle:At:find.html.twig', array(
                            'form'=>$form->createView(),
			 	
        ));
    }   


     # agosto 8. Dario
    # Editar una asistencia técnica.
    # Dejar Cambiar solo Sector Destino y Patrimonio

     /**
     * Displays a form to edit an existing AT entity.
     *
     */
    public function editAction($id)
    {
   
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:At')->find($id);
        $Form = $this->createForm(new AtEditType($em, $id), $entity);

        $Form->handleRequest($this->getRequest());
        if ($Form->isValid()) {
         
            try{
              
                $em->persist($entity);            
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Editado'); 
                return $this->redirect($this->generateUrl('at_edit', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar editar item'); 
                return $this->redirect($this->generateUrl('at_edit', array('id' => $id)));
            }
        }
        return $this->render('FrontendBundle:At:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $Form->createView()
        ));
    }
      
}
