<?php

namespace ATManager\AtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
        $entities =array();
        $at = $em->getRepository('FrontendBundle:At')->find($idAt);

        $entities = $em->getRepository('AtBundle:AtHistorico')->findByHistoricoPorAt($at);
        return $this->render('AtBundle:AtHistorico:index.html.twig', array(
        	'entities'=> $entities,
            'at'=>$at,
            'ret'=>$ret
            
        ));
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
           try{


              if($entity->getEstadio()->getClasificacion()->getFinalizaAt())
              {
                if($entity->getAt()->miFallas()>0)
                {  
                  $fechafin = new \DateTime(); 
                  $entity->getAt()->setFechafin($fechafin);
                  $entity->setComentario("AT CERRADA");
               }else
                   {
                      $this->get('session')->getFlashBag()->add('error','No se puede cerrar falta cargar fallas');         
                      return $this->redirect($this->generateUrl('at_historico_new', array('idAt' => $idAt)));
                   }
              } 

              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('at_historico_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
              // return $this->redirect($this->generateUrl('at_nota_new'));
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
        return $this->render('AtBundle:AtHistorico:edit.html.twig', array(
            'form'=>$form->createView(),
            'entity' => $entity
            ))
             ;
    }
    public function eliminarAction($id)
    {                
        try{

            $em = $this->getDoctrine()->getManager();
            
            $entity = $em->getRepository('AtBundle:AtHistorico')->find($id);

            $atId = $entity->getAt()->getId();

            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('at_historico', array('idAt'=>$atId)) );
        }
	catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
          return $this->redirect($this->generateUrl('at_historico', array('idAt'=>$atId)) );
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

    private function PuedeFinalizar()
    {
      return true;
    }
}
