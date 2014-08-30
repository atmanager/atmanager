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
    public function obtenerAyudantesAction($id)
    {
        $sesion = $this->get('session');

       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret = $sesion->get('retorno');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:At')->find($id);
	return $this->render('AtBundle:AtTecnico:Atayudantes.html.twig', array(
        	'entity'=>$entity,
            	'ret'=>$ret
        ));          
    }
    public function newAyudanteAction($id){
       $sesion = $this->get('session');

       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret = $sesion->get('retorno');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:At')->find($id);
	$objtl = $this->get('security.context')->getToken()->getUser();
 	$objs = $objtl->getSector();
	$mapatec = $em->getRepository('AtBundle:AtTecnico')->findBySectorAyudante($objs,$entity);
	return $this->render('AtBundle:AtTecnico:newAyudante.html.twig', array(
        	'entity'=>$entity,
            	'mapatec'=>$mapatec,
                
        ));
    }
    public function asignarAyudanteAction($at,$tec)
    {
        /* recupero la variable de session definida en: buscadorAction()*/
        $sesion = $this->get('session');
        /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
        el proceso*/ 
        $ret = $sesion->get('retorno');
        /*--*/
        $objatt=new AtTecnico();
       	$em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:At')->find($at);
        try{	
	    $objt= $em->getRepository('BackendBundle:Tecnico')->findOneById($tec);
	    $rol = $em->getRepository('BackendBundle:Rol')->findOneByNombre('SECUNDARIO');
            echo "rol: ".$rol;
	    $objatt->setAt($entity);
	    $objatt->setRol($rol);
	    $objatt->setTecnico($objt);
	    $em->persist($objatt);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Se agregaron: Técnico Ayudante'); 
            return $this->redirect($ret);            
        }
	catch(\Exception $ex){
	    $this->get('session')->getFlashBag()->add('error',$ex->getMessage());
            return $this->redirect($ret);
        } 
    }
}
