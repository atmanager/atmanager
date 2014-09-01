<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\FrontendBundle\Entity\At;
use ATManager\AtBundle\Entity\AtTecnico;
use ATManager\BackendBundle\Entity\Rol;

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
        $falso=false;
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
	       $rol = $em->getRepository('BackendBundle:Rol')->findOneByNombre('SECUNDARIO');
           $entity->setAt($objat);
	       $entity->setRol($rol);
	       $entity->setTecnico($objt);
	       $em->persist($entity);
           $em->flush();
           $this->get('session')->getFlashBag()->add('success','Se agregaron: Técnico Ayudante'); 
           return $this->redirect($ret2);            
        }
	catch(\Exception $ex){
	       $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
           return $this->redirect($ret2);
        } 
    }
    public function eliminarAction($id)
    {                
        try{

            $em = $this->getDoctrine()->getManager();
            
            $entity = $em->getRepository('AtBundle:AtTecnico')->find($id);
            $atId = $entity->getAt()->getId();
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ayudante Eliminado');
            return $this->redirect($this->generateUrl('atecnico', array('atId'=>$atId)));
        }
        catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('atecnico', array('atId'=>$atId)));
        }    
    }
}
