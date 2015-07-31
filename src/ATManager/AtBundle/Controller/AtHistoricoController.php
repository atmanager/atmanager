a<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\AtBundle\Form\AtHistoricoType;
use ATManager\AtBundle\Form\AtHistoricoEditType;
use ATManager\AtBundle\Entity\AtHistorico;
use ATManager\AtBundle\Entity\AtTecnico;


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
        
        /* bloque ATFinalizada: 
           busco si alguno de los estadios que contiene la AT
           tiene el atributo de FInalizado en True*/

            $clasif=$em->getRepository('BackendBundle:EstadioClasif')->findByFinalizaAt(true);
            $esta = $em->getRepository('BackendBundle:Estadio')->findOneByClasificacion($clasif);
            $estadio=$em->getRepository('AtBundle:AtHistorico')->findByEstadiosPuntalesAt($at,$esta);
        /* fin bloque */

        
        /* compruebo que no este finalizada */
        if($estadio)
        {
            $this->get('session')->getFlashBag()->add('error','AT finalizada. No se permite EVOLUCIONAR');
            return $this->redirect($ret); 
        }
        else
        {
            /* si no esta finalizada, trae su colección de estadios */
            $entities = $em->getRepository('AtBundle:AtHistorico')->findByHistoricoPorAt($at);
            return $this->render('AtBundle:AtHistorico:index.html.twig', array(
        	'entities'=> $entities,
                'at'=>$at,
                'ret'=>$ret
            ));            
        }
    }

    
    /*

        Agrega un nuevo estadio a la AT
        Fecha Ultima Modificación: 27/10/2014
    */
    public function newAction($idAt)
    {
        $em = $this->getDoctrine()->getManager();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);

        /*  sector del usuario logueado*/

         $objt = $this->get('security.context')->getToken()->getUser();   
         $sector=$objt->getSector();


        /* cargar un array con los estadios que no estan en la AT en cuestion*/
        //$estadiosNoPresentes = $em->getRepository('AtBundle:AtHistorico')->findByHistoricoEstadiosNoPresentesEnAt($at);
        $estadiosNoPresentes = $em->getRepository('AtBundle:AtHistorico')->findByHistoricoEstadiosNoPresentesEnAtExceptoCancelado($at);
        $entity = new AtHistorico();
        $entity->setAt($at);
        $form = $this->createForm(new AtHistoricoType($at, $em, $estadiosNoPresentes, $sector), $entity);
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
                    /* si no se escoge un tecnico nuevo ppal*/
                    if($form->get("tecnico")->getData() == null) 
                    {
                        $rol = $em->getRepository('BackendBundle:Rol')->findOneByPrincipal(true);
                        $att = $em->getRepository('AtBundle:AtTecnico')->FindByRolPrincipal($at,$rol);
                        $entity->setTecnico($att->getTecnico());
                    }else{ 
                        
                        /* se escogio un nuevo tecnico ppal
                           agrega un nuevo tecnico en AtTecnico con Rol ppal, 
                           updatea el anterior ppal como ayudante
                       */
                        
                        $rol = $em->getRepository('BackendBundle:Rol')->findOneByPrincipal(true);
                        
                        $tecnicoEscogido = $form->get("tecnico")->getData();

                        $att_tecnicoActual = $em->getRepository('AtBundle:AtTecnico')->FindByRolPrincipal($at,$rol);
                        
                                     
                       if($att_tecnicoActual->getTecnico() == $tecnicoEscogido) 
                       {
                        /* existe el técnico escogido en esta AT y está como principal*/

                       }else{
                               
                                /* busco el tecnico escogido para ver sino está como ayudante*/
                                $att_existe = $em->getRepository('AtBundle:AtTecnico')->FindByAtTecnico($at, $tecnicoEscogido->getId());
                                
                                /* control interno 
                                if(isset($att_existe))
                                {echo " TEX que existe: ";}else{echo "tex no existe ".var_dump($att_existe);} 
                                */  

                                /* el ppal anterior pasa a ayudante*/
                                $rol_falso = $em->getRepository('BackendBundle:Rol')->findOneByPrincipal(false);
                                $att_tecnicoActual->setRol($rol_falso);
                                $em->persist($att_tecnicoActual);

        

                                   
                                
                                if(isset($att_existe))
                                {
                                    /* el tecnico escogido ya existe en la relacion con rol ayudante
                                       entonces le cambio el rol a ppal*/
                                  
                                    $att_existe->setRol($rol);
                                    $em->persist($att_existe);

                                }else{    



                                /* agrego un nuevo tec con rol ppal.*/
                                $nuevoAtt = new AtTecnico();
                                $nuevoAtt->setAt($at);
                                $nuevoAtt->setTecnico($tecnicoEscogido);
                                $nuevoAtt->setRol($rol);
                                $em->persist($nuevoAtt);

                                /*$comentario = $form->get("comentario")." técnico actual: ".$tecnicoEscogido;
                                echo "nuevo tecnico ".$comentario;
                                $entity->setComentario($comentario);*/ 

                                }



                            } 

                    } 
                                       
                    
                    /* graba un nuevo estadio*/    
                    $em->persist($entity);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success','Se agrego satisfactoriamente una nueva evolución');         
                    return $this->redirect($this->generateUrl('at_historico_show', array('id' => $entity->getId())));
                }
                catch(\Exception $e){
                    $this->get('session')->getFlashBag()->add('error','Error al intentar agregar nueva evolución...'.$e->getMessage()); 
                   
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
                 //   return $this->redirect($this->generateUrl('at_historico_edit', array('id' => $entity->getId())));
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
