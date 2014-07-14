<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints as Assert;

# indicar en el createForm (newAction) que tipo de form es
use ATManager\BackendBundle\Form\MarcaType; 

#indicar al new (newAction) a que entidad nos referimos 
use ATManager\BackendBundle\Entity\Marca; 
use Symfony\Component\HttpFoundation\Request;
use ATManager\BackendBundle\Form\BuscadorType;  

class MarcaController extends Controller
{
#    listado
    public function indexAction(Request $request)
    {
    	
        #La manipulación de la información de Doctrine2 (buscar, crear, modificar y borrar registros en
        #las tablas) se realiza a través de un objeto especial llamado Entity Manager ($em).
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $marcas =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $marcas = $em->getRepository('BackendBundle:Marca')->findByName($nombre);
        }
    	
        # trae todos los registros ordenanos por su ID.
        #$marcas = $em->getRepository('BackendBundle:Marca')->findAll();

        
        # consulta simil LIKE. Preguntar a Martin como puedo obtener la ocurrecia desde 
        # un [input type = text] desde donde cargo la ocurrencia.

        /*$dql = "select m from BackendBundle:Marca m where m.nombre like :nombre";
        $query = $em->createQuery($dql);
        $query->setParameter('nombre', '%ALLI%');
        $marcas = $query->getResult();*/

        # buscar por nombre exacto, no por aproximacion...
        #$marcas = $em->getRepository('BackendBundle:Marca')->findBy(array('nombre' => 'ALLIED'));

        # ordenado por nombre ascendente, no funciona ver con Martin
        #$marcas = $em->getRepository('BackendBundle:Marca')->findBy(array('nombre' => 'ASC'));



        $paginator = $this->get('knp_paginator');
        $marcas = $paginator->paginate($marcas, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Marca:index.html.twig', array(
        	'marcas'=> $marcas,
            'form'=>$form->createView() 	
        ));


    }


    #    nuevo
    public function newAction()
    {
        $objMarca = new Marca();
        $form = $this->createForm(new MarcaType(), $objMarca);

        $form->handleRequest($this->getRequest());

        if ($form->isValid())
        {

          try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($objMarca);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
            return $this->redirect($this->generateUrl('marca_listado'));
          }
          catch(\Exception $e){
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar agregar un nuevo item');  
            return $this->redirect($this->generateUrl('marca_listado'));
          }


        }
        

    	return $this->render('BackendBundle:Marca:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    #    editar
    public function editAction($id)
    {
      
        $em = $this->getDoctrine()->getManager();
        $objMarca = $em->getRepository('BackendBundle:Marca')->find($id);
        $form = $this->createForm(new MarcaType(), $objMarca);

        $form->handleRequest($this->getRequest());

        if ($form->isValid())
        {
          $em->persist($objMarca);
          $em->flush();
          $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
          return $this->redirect($this->generateUrl('marca_listado'));

        }


    	return $this->render('BackendBundle:Marca:edit.html.twig', array('form'=>$form->createView()));
    }

    #    borrar
    public function deleteAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objMarca = $em->getRepository('BackendBundle:Marca')->find($id);
            $em->remove($objMarca); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
            return $this->redirect($this->generateUrl('marca_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('marca_listado'));
        }
       
      	
    }
}
