<?php

namespace ATManager\BackendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ATManager\BackendBundle\Form\SectorTipoType;
use ATManager\BackendBundle\Entity\SectorTipo;

/**
 * SectorTipo controller.
 *
 * @Route("/sectortipo")
 */
class SectorTipoController extends Controller
{

    /**
     * Lists all SectorTipo entities.
     *
     * @Route("/", name="sectortipo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:SectorTipo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SectorTipo entity.
     *
     * @Route("/{id}", name="sectortipo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:SectorTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SectorTipo entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }


   #    nuevo
    public function newAction()
    {
        $objSectorTipo = new SectorTipo();
        $form = $this->createForm(new SectorTipoType(), $objSectorTipo);

        $form->handleRequest($this->getRequest());

        if ($form->isValid())
        {
          $em = $this->getDoctrine()->getManager();
          $em->persist($objSectorTipo);
          $em->flush();
          $this->get('session')->getFlashBag()->add('success','Tuvo exito la transacción');
          return $this->redirect($this->generateUrl('sectortipo_listado'));

        }
          return $this->render('BackendBundle:SectorTipo:new.html.twig', array(
            'form' => $form->createView()));

    }   


}
