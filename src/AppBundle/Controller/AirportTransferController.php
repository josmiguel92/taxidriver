<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AirportTransfer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Airporttransfer controller.
 *
 */
class AirportTransferController extends Controller
{
    /**
     * Lists all airportTransfer entities.
     *
     * @Route("/dash/airporttransfers/", name="dash_airporttransfers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $airportTransfers = $em->getRepository('AppBundle:AirportTransfer')->findAll();

        return $this->render('@App/Dash/services/airporttransfer/index.html.twig', array(
            'airportTransfers' => $airportTransfers,
        ));
    }

    /**
     * Creates a new airportTransfer entity.
     *
     * @Route("/dash/airporttransfers/new", name="dash_airporttransfers_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $airportTransfer = new Airporttransfer();
        $form = $this->createForm('AppBundle\Form\AirportTransferType', $airportTransfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($airportTransfer);
            $em->flush();

            return $this->redirectToRoute('dash_airporttransfers_index');
        }

        return $this->render('@App/Dash/services/airporttransfer/new.html.twig', array(
            'airportTransfer' => $airportTransfer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing airportTransfer entity.
     *
     * @Route("/dash/airporttransfers/{id}/edit", name="dash_airporttransfers_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AirportTransfer $airportTransfer)
    {
        $deleteForm = $this->createDeleteForm($airportTransfer);
        $editForm = $this->createForm('AppBundle\Form\AirportTransferType', $airportTransfer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dash_airporttransfers_edit', array('id' => $airportTransfer->getId()));
        }

        return $this->render('@App/Dash/services/airporttransfer/edit.html.twig', array(
            'airportTransfer' => $airportTransfer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a airportTransfer entity.
     *
     * @Route("/dash/airporttransfers/{id}", name="dash_airporttransfers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AirportTransfer $airportTransfer)
    {
        $form = $this->createDeleteForm($airportTransfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($airportTransfer);
            $em->flush();
        }

        return $this->redirectToRoute('dash_airporttransfers_index');
    }

    /**
     * Creates a form to delete a airportTransfer entity.
     *
     * @param AirportTransfer $airportTransfer The airportTransfer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AirportTransfer $airportTransfer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_airporttransfers_delete', array('id' => $airportTransfer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
