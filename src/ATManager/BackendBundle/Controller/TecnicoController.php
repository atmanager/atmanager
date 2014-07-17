<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

# indicar en el createForm (newAction) que tipo de form es
use ATManager\BackendBundle\Form\TecnicoNewType; 

use ATManager\BackendBundle\Form\TecnicoEditarType; 
use ATManager\BackendBundle\Form\BuscadorType; 
#indicar al new (newAction) a que entidad nos referimos 
use ATManager\BackendBundle\Entity\Tecnico;   


class TecnicoController extends Controller
{
    public function indexAction(Request $request)
    {
    	
        #La manipulación de la información de Doctrine2 (buscar, crear, modificar y borrar registros en
        #las tablas) se realiza a través de un objeto especial llamado Entity Manager ($em).
        $em = $this->getDoctrine()->getManager(); 	
        # trae todos los registros ordenanos por su ID.
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $tecnicos = array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData(); 
            $tecnicos = $em->getRepository('BackendBundle:Tecnico')->findByOrden($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $tecnicos = $paginator->paginate($tecnicos, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Tecnico:index.html.twig', array(
        	'tecnicos'=> $tecnicos,
            'form'=>$form->createView()	
        ));

    }


   public function newAction(Request $request){
        $userManager = $this->container->get('fos_user.user_manager');  // 1) declarado en security.yml
        $entity = $userManager->createUser();

        # crea un nuevo objeto de tecnico. Ver config.yml ahi se relaciona
        # user.manager con el técnico.

    
        $form = $this->createForm(new TecnicoNewType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $nombre = $form->get('nombre')->getData();
            $documento = $form->get('documento')->getData();
            $movil = $form->get('movil')->getData();
            $email = $form->get('email')->getData();
            $sector = $form->get('sector')->getData();
            $username = $form->get('username')->getData();


            $contrasena = $form->get('plainpassword')->getData();
            $rol = $form->get('rol')->getData();

            $entity->setNombre($nombre);
            $entity->setDocumento($documento);
            $entity->setMovil($movil);
            $entity->setSector($sector);
            $entity->setUsername($username);
            $entity->setEmail($email);
            $entity->setPlainPassword($contrasena);
            $entity->setEnabled(true);
            $entity->setRoles(array($rol));
            $entity->setLastLogin(null);
            try {
                $userManager->updateUser($entity);
                $request->getSession()->getFlashBag()->add('success', 'Guardado correctamente');
                return $this->redirect($this->generateUrl('tecnico_listado'));
            } catch(\Exception $ex) {
                $request->getSession()->getFlashBag()->add('error', 'Ocurrio un problema al cargar un nuevo técnico');
                return $this->redirect($this->generateUrl('tecnico_new'));
            }
        }

        return $this->render('BackendBundle:Tecnico:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    #    editar
    public function editAction($id, Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        $objTecnico = $em->getRepository('BackendBundle:Tecnico')->find($id);

        $options['nombre'] = $objTecnico->getNombre();
        $options['documento'] = $objTecnico->getDocumento();
        $options['username'] = $objTecnico->getUsername();
        $options['email'] = $objTecnico->getEmail();
        $options['movil'] = $objTecnico->getMovil();
        $options['enabled'] = $objTecnico->isEnabled();
        $options['sector'] = $objTecnico->getSector();
        $roles = $objTecnico->getRoles();
        $options['rol'] = $roles[0];
        $form = $this->createForm(new TecnicoEditarType(), $options); // no pasar objeto tecnico

        $form->handleRequest($this->getRequest());

        if ($form->isValid())
        {

            $objTecnico->setNombre($form->get('nombre')->getData());  
            $objTecnico->setDocumento($form->get('documento')->getData());  
            $objTecnico->setUsername($form->get('username')->getData());  
            $objTecnico->setEmail($form->get('email')->getData());  
            $objTecnico->setMovil($form->get('movil')->getData());  
            $objTecnico->setEnabled($form->get('enabled')->getData());  
            $objTecnico->setSector($form->get('sector')->getData());  
            $contrasenia = $form->get('plainpassword')->getData();

            if (!empty($contrasenia))
            {  
                $objTecnico->setPlainPassword($contrasenia);
            }
            $arrayRoles=array();
            $arrayRoles[]=$form->get('rol')->getData();
            $objTecnico->setRoles($arrayRoles); 
            try {
                $userManager -> updateUser($objTecnico);
                $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
                return $this->redirect($this->generateUrl('tecnico_listado'));
            } 
            catch(\Exception $ex) {
               $request->getSession()->getFlashBag()->add('error', 'El Técnico ya existe');
                //return $this->redirect($this->generateUrl('tecnico_listado'));
            }
        }


    	return $this->render('BackendBundle:Tecnico:edit.html.twig', array('form'=>$form->createView()));
    }

    #    borrar
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $objTecnico = $em->getRepository('BackendBundle:Tecnico')->find($id);
        
        try{
            $em->remove($objTecnico); 
            $em->flush();
        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('success','Hubo un error al intentar borrar...');
            return $this->redirect($this->generateUrl('tecnico_listado'));
        }
        $this->get('session')->getFlashBag()->add('success','Ok al borrar...');
        return $this->redirect($this->generateUrl('tecnico_listado'));
      	
    }

     /**
     * Finds and displays a Patrimonio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Tecnico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tecnico entity.');
        }

        return $this->render('BackendBundle:Tecnico:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
        ));
    }


     /**
     * Creates a form to delete a Tecnico entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tecnico_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }

    public function eliminarAction($id)
    {
            try{
                $em = $this->getDoctrine()->getManager();
                $objt = $em->getRepository('BackendBundle:Tecnico')->find($id);
                $objt->setEnabled(false);
                $em->persist($objt);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Ok al borrar');
                return $this->redirect($this->generateUrl('tecnico_listado'));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Hubo un error al intentar borrar');  
                return $this->redirect($this->generateUrl('tecnico_listado'));
            }    
        
        //return $this->render('BackendBundle:Local:edit.html.twig', array('form'=>$form->createView()));
    }
}
