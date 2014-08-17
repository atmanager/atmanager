<?php

namespace ATManager\PatrimonioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\PatrimonioBundle\Entity\Patrimonio;
use ATManager\BackendBundle\Entity\Tecnico;
use ATManager\PatrimonioBundle\Form\PatrimonioType;
use ATManager\PatrimonioBundle\Form\PatrimonioBuscadorType;
use Symfony\Component\HttpFoundation\StreamedResponse; // para exportar

class PatrimonioController extends Controller
{
    public function buscadorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new PatrimonioBuscadorType(), null, array(
            'method' => 'GET',
        ));
        $form->handleRequest($request);
        if ($form->isValid())
        {

            $entities = array();
            $numero=$form->get('numero')->getData();
            $descripcion=$form->get('descripcion')->getData();
            $observacion=$form->get('observacion')->getData();
            $serial=$form->get('serial')->getData();
            $clasificacion=$form->get('clasificacion')->getData();
            $local=$form->get('local')->getData();
            $marca=$form->get('marca')->getData();
            $entities = $em->getRepository('PatrimonioBundle:Patrimonio')->findByFiltroPatrimonio($numero, $descripcion, $observacion, $serial, $clasificacion, $local, $marca);
            $cant=count($entities);
            if ($form->get('exportar')->isClicked())
            {
                return $this->export($entities);
            }    
            else{
                $paginator = $this->get('knp_paginator');
                $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
                return $this->render('PatrimonioBundle:Patrimonio:index.html.twig', array(
                    'entities' => $entities, 
                    'form'=>$form->createView(),
                    'cant'=>$cant
                ));
            }
        }
        return $this->render('PatrimonioBundle:Patrimonio:find.html.twig', array(
                            'form'=>$form->createView()
        ));
    }    
    public function newAction()
    {
	    $hoy=new \DateTime();
        $entity = new Patrimonio();
        $form = $this->createForm(new PatrimonioType(), $entity);
        $form->handleRequest($this->getRequest());
       
       if ($form->isValid()){
	   if($entity->getFechaAlta()>$hoy){
		$this->get('session')->getFlashBag()->add('error','Error: Fecha de alta es mayor que la actual'); 
               	return $this->redirect($this->generateUrl('patrimonio_new'));		
	   }
	   try    	
	   {       
                /** asi se obtiene el usuario logueado desde una accion en un controlador **/
                $objt = $this->get('security.context')->getToken()->getUser();
                $entity->setTecnico($objt);         
        		$em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('patrimonio_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar crear item'); 
               	return $this->redirect($this->generateUrl('patrimonio_new'));
	   }
        }
        return $this->render('PatrimonioBundle:Patrimonio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Patrimonio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patrimonio entity.');
        }

        
        return $this->render('PatrimonioBundle:Patrimonio:show.html.twig', array(
            'entity'      => $entity       
            ));
    }


    public function existeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);

        if (!$entity) {
            return new Response('Error',400);
            
        }

        $data = array('descripcion'=>$entity->getDescripcion());
        return new Response(json_encode($data),200);
       
    }


    /**
     * Displays a form to edit an existing Patrimonio entity.
     *
     */
    public function editAction($id)
    {
	$hoy=new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);
        $editForm = $this->createForm(new PatrimonioType(), $entity);
        $editForm->handleRequest($this->getRequest());
        if ($editForm->isValid()) {
	    if($entity->getFechaAlta()>$hoy){
		$this->get('session')->getFlashBag()->add('error','Error: Fecha de alta es mayor que la actual'); 
               	return $this->redirect($this->generateUrl('patrimonio_edit', array('id' => $id)));		
	    }	
            try{
                $objt = $this->get('security.context')->getToken()->getUser();
                $entity->setTecnico($objt);
                $entity->setFechaModifica(new\DateTime());
                $em->persist($entity);            
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Editado'); 
                return $this->redirect($this->generateUrl('patrimonio_edit', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar editar item'); 
                return $this->redirect($this->generateUrl('patrimonio_edit', array('id' => $id)));
            }
        }
        return $this->render('PatrimonioBundle:Patrimonio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    public function deleteAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PatrimonioBundle:Patrimonio')->find($id);
            $entity->setHabilita(false);
            $entity->setFechaBaja(new\DateTime());
            $entity->setFechaModifica(new\DateTime());
            $objt = $this->get('security.context')->getToken()->getUser();
            $entity->setTecnico($objt);
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('patrimonio_buscador'));
        }
        catch(\Exception $e){
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');  
            return $this->redirect($this->generateUrl('patrimonio_buscador'));
        } 
    }
    /*
      funcion que exporta a CSV
    */
    private function export($entities)
    {
        
        $response = new StreamedResponse(function() use($entities) {  
        $handle = fopen('php://output', 'r+');
        $elemento = array();
        $encabezado = array();
        $encabezado[]='Patrimonio';
        $encabezado[]='Descripción';
        $encabezado[]='Precio';
        $encabezado[]='Estimado';
        $encabezado[]='Responsable';
        $encabezado[]='Modelo';
        $encabezado[]='Serial';
        $encabezado[]='Observación';
        $encabezado[]='Habilitado';
        $encabezado[]='Clasificación';
        $encabezado[]='Local';
        $encabezado[]='Marca';                
        $encabezado[]='Estado';
        $encabezado[]='Modificador';
        $encabezado[]='Fecha de Alta';
        $encabezado[]='Fecha de Baja';     
        $encabezado[]='Fecha de Edición';
        fputcsv($handle, $encabezado, ';'); 
        foreach ($entities as $key) 
        {
		    $elemento[0]=$key->getId();
            $elemento[1]=$key->getDescripcion();
            $elemento[2]=$key->getPrecio();
		    $elemento[3]=$key->getEstimado();
		    $elemento[4]=$key->getResponsable();
		    $elemento[5]=$key->getModelo();
		    $elemento[6]=$key->getSerial();
            $elemento[7]=$key->getObservacion();
		    $elemento[8]=$key->getHabilita();
		    $elemento[9]=$key->getClasificacion()->getNombre();
		    $elemento[10]=$key->getLocal()->getNombre();
		    $elemento[11]=$key->getMarca()->getNombre();				
		    $elemento[12]=$key->getEstado()->getNombre();
		    $elemento[13]=$key->getTecnico()->getNombre();
		    $elemento[14]=$key->getFechaAlta();
		    $elemento[15]=$key->getFechaBaja();		
		    $elemento[16]=$key->getFechaModifica();
		    fputcsv($handle, $elemento, ';');                   
        }
        fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->setCharset('iso-8859-1');
        $response->headers->set('Content-Disposition','attachment; filename="patrimonio.csv"');
        return $response;
    }

}
