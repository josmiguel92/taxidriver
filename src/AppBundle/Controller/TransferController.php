<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transfer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Transfer controller.
 *
 */
class TransferController extends Controller
{
    /**
     * Lists all transfer entities.
     *
     * @Route("/dash/transfer/", name="dash_transfer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transfers = $em->getRepository('AppBundle:Transfer')->findAll();

        return $this->render('@App/Dash/services/transfer/index.html.twig', array(
            'transfers' => $transfers,
        ));
    }

    /**
     * Creates a new transfer entity.
     *
     * @Route("/dash/transfer/new", name="dash_transfer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $transfer = new Transfer();
        $form = $this->createForm('AppBundle\Form\TransferType', $transfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transfer);
            $em->flush();

            return $this->redirectToRoute('dash_transfer_index');
        }

        return $this->render('@App/Dash/services/transfer/new.html.twig', array(
            'transfer' => $transfer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transfer entity.
     *
     * @Route("/dash/transfer/{id}/edit", name="dash_transfer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Transfer $transfer)
    {
        $deleteForm = $this->createDeleteForm($transfer);
        $editForm = $this->createForm('AppBundle\Form\TransferType', $transfer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dash_transfer_edit', array('id' => $transfer->getId()));
        }

        return $this->render('@App/Dash/services/transfer/edit.html.twig', array(
            'transfer' => $transfer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transfer entity.
     *
     * @Route("/dash/transfer/{id}", name="dash_transfer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Transfer $transfer)
    {
        $form = $this->createDeleteForm($transfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transfer);
            $em->flush();
        }

        return $this->redirectToRoute('dash_transfer_index');
    }

    /**
     * Creates a form to delete a transfer entity.
     *
     * @param Transfer $transfer The transfer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transfer $transfer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_transfer_delete', array('id' => $transfer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
