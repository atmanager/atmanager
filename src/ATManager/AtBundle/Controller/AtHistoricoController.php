<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\AtBundle\Form\AtHistoricoType;
use ATManager\AtBundle\Form\AtHistoricoEditType;
use ATManager\FrontendBundle\Entity\At;
use ATManager\AtBundle\Entity\AtHistorico;


/**
 * AtNota controller.
 *
 */
class AtHistoricoController extends Controller
{
    public function indexAction($idAt)
    {
        $sesion = $this->get('session');
       /*la asigno a una variable que utilizare como parametro para redireccionar al finaliza
       el proceso*/ 
        $ret = $sesion->get('retorno');
    	$em = $this->getDoctrine()->getManager();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);
        $clasif=$em->getRepository('BackendBundle:EstadioClasif')->findByFinalizaAt(true);
        $esta = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasif);
        $estadio=$em->getRepository('AtBundle:AtHistorico')->findByEstadiosPuntalesAt($at,$esta);
        $entities = $em->getRepository('AtBundle:AtHistorico')->findByHistoricoPorAt($at);
        if($estadio)
        {
            $this->get('session')->getFlashBag()->add('error','AT finalizada. No se permite EVOLUCIONAR');
            return $this->redirect($ret); 
        }
        else
        {
            return $this->render('AtBundle:AtHistorico:index.html.twig', array(
        	'entities'=> $entities,
                'at'=>$at,
                'ret'=>$ret
            ));            
        }
    }

    public function newAction($idAt)
    {
        $em = $this->getDoctrine()->getManager();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);
        /* cargar un array con los estadios que no estan en la AT en cuestion*/
        $estadiosNoPresentes = $em->getRepository('AtBundle:AtHistorico')->findByHistoricoEstadiosNoPresentesEnAt($at);
        $entity = new AtHistorico();
        $entity->setAt($at);
        $form = $this->createForm(new AtHistoricoType($at, $em, $estadiosNoPresentes), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            if($entity->getEstadio()->getClasificacion()->getFinalizaAt())
            {
                if($entity->getAt()->getFallas()->isEmpty())
                {
                    $this->get('session')->getFlashBag()->add('error','Acción denegada. Falta cargar al menos una falla');
                    return $this->redirect($this->generateUrl('at_historico_new', array('idAt' => $at->getId())));
                }
                else
                {
                    $fechafin = new \DateTime(); 
                    $entity->getAt()->setFechafin($fechafin);
                }
            }
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');         
                return $this->redirect($this->generateUrl('at_historico_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
                return $this->redirect($this->generateUrl('at_historico_new',array('idAt' => $at->getId())));
            }                      
        }
    	return $this->render('AtBundle:AtHistorico:new.html.twig', array(
      	   'form' => $form->createView(),
           'entity' => $entity        
	));
    }
    public function editAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AtBundle:AtHistorico')->find($id);        
        $form = $this->createForm(new AtHistoricoEditType(), $entity);
        $form->handleRequest($this->getRequest());
        if($entity->getEstadio()->getClasificacion()->getIniciaAt() or $entity->getEstadio()->getClasificacion()->getDiagnosAt() or $entity->getEstadio()->getClasificacion()->getFinalizaAt()){
            $this->get('session')->getFlashBag()->add('error','No puede editar estadios Iniciado, en Diagnóstico o Finalizado');
            return $this->redirect($this->generateUrl('at_historico', array('idAt' => $entity->getAt()->getId())));
        }
        else
        {
            if ($form->isValid())
            {                        
                try{
                    $em->persist($entity);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success','Item actualizado');
                    return $this->redirect($this->generateUrl('at_historico_edit', array('id' => $entity->getId())));
                }
                catch(\Exception $e){
                    $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
                    return $this->redirect($this->generateUrl('at_historico_edit', array('id' => $entity->getId())));
                }                          
            }
        }
        return $this->render('AtBundle:AtHistorico:edit.html.twig', array(
            'form'=>$form->createView(),
            'entity' => $entity
        ));
    }
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();            
        $entity = $em->getRepository('AtBundle:AtHistorico')->find($id);
        if($entity->getEstadio()->getClasificacion()->getIniciaAt() or $entity->getEstadio()->getClasificacion()->getDiagnosAt() or $entity->getEstadio()->getClasificacion()->getFinalizaAt()){
            $this->get('session')->getFlashBag()->add('error','No puede eliminar estadios Iniciado, en Diagnóstico o Finalizado');
            return $this->redirect($this->generateUrl('at_historico', array('idAt' => $entity->getAt()->getId())));
        }
        else
        {
            try
            {        
                $em->remove($entity); 
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Eliminado');
                return $this->redirect($this->generateUrl('at_historico', array('idAt'=>$entity->getAt()->getId())));
            }
            catch(\Exception $e) {
                $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
                return $this->redirect($this->generateUrl('at_historico', array('idAt'=>$entity->getAt()->getId())));
            }        
        }    
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtBundle:AtHistorico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

         return $this->render('AtBundle:AtHistorico:show.html.twig', 
            array('entity' => $entity)
        );
    }
}
