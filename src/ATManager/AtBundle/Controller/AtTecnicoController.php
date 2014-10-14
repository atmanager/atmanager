<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\FrontendBundle\Entity\At;
use ATManager\AtBundle\Entity\AtTecnico;
use ATManager\BackendBundle\Entity\Rol;
use Symfony\Component\HttpFoundation\Request;
use ATManager\AtBundle\Form\AtTecnicoType;  

/**
 * AtNota controller.
 *
 */
class AtTecnicoController extends Controller
{
    public function indexAction($atId)
    {
        $sesion = $this->get('session');
        $ret = $sesion->get('retorno');

        $em = $this->getDoctrine()->getManager();
        $objat = $em->getRepository('FrontendBundle:At')->find($atId);
	return $this->render('AtBundle:AtTecnico:index.html.twig', array(
            'entity'=>$objat,
            'ret'=>$ret
        ));          
    }
    public function mapaAction($atId){
       $sesion = $this->get('session');

       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret2 = $sesion->get('retorno');
        $em = $this->getDoctrine()->getManager();
        $objat = $em->getRepository('FrontendBundle:At')->find($atId);
	    $objtl = $this->get('security.context')->getToken()->getUser();
 	    $objsector = $objtl->getSector();
	    $mapatec = $em->getRepository('AtBundle:AtTecnico')->findBySectorAyudante($objsector, $objat);

	    return $this->render('AtBundle:AtTecnico:new.html.twig', array(
        	'entity'=>$objat,
            	'mapatec'=>$mapatec,
                
        ));
        
    }
    public function newAction($atId,$tecId)
    {
        /* recupero la variable de session definida en: buscadorAction()*/
        $sesion = $this->get('session');
        /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
        el proceso*/ 
        $ret2 = $sesion->get('retorno');
        /*--*/
        $entity=new AtTecnico();
       	$em = $this->getDoctrine()->getManager();
        $objat = $em->getRepository('FrontendBundle:At')->find($atId);
        try{	
            $objt= $em->getRepository('BackendBundle:Tecnico')->findOneById($tecId);
            $rol = $em->getRepository('BackendBundle:Rol')->findOneByPrincipal(false);
            $entity->setAt($objat);
            $entity->setRol($rol);
            $entity->setTecnico($objt);
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Se agregó: Técnico Ayudante'); 
            return $this->redirect($this->generateUrl('atecnico_show',array('id'=>$entity->getId())));            
        }
	catch(\Exception $ex){
            $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
           // return $this->redirect($this->generateUrl('atecnico_mapa',array('atId'=>$entity->getAt()->getId())));
        } 
    }
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtTecnico')->find($id);            
        try{
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ayudante Eliminado');
            return $this->redirect($this->generateUrl('atecnico', array('atId'=>$entity->getAt()->getId())));
        }
        catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('atecnico', array('atId'=>$entity->getAt()->getId())));
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AtBundle:AtTecnico')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }
         return $this->render('AtBundle:AtTecnico:show.html.twig', 
            array('entity' => $entity)
        );
    }

    public function reasignarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtTecnico')->find($id);
        $objteclog = $this->get('security.context')->getToken()->getUser();
        $objsector = $objteclog->getSector();

        $form = $this->createForm(new AtTecnicoType($objsector), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Se reasignó un nuevo técnico ppal.');
                return $this->redirect($this->generateUrl('atecnica_reasignotec', array('id' => $entity->getAt())));
            }
            catch(\Exception $e)
            {
                $this->get('session')->getFlashBag()->add('error','Error al intentar reasignar un técnico ppal.'); 
            }
        }
        return $this->render('AtBundle:AtTecnico:edit.html.twig',array(
            'entity'=>'$entity',
            'form'=>$form->createView()));
    }





}