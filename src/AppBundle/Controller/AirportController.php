<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Airport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Airport controller.
 *
 * @Route("dash/airport")
 */
class AirportController extends Controller
{
    /**
     * Lists all airport entities.
     *
     * @Route("/", name="dash_airport_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $airports = $em->getRepository('AppBundle:Airport')->findAll();

        return $this->render('AppBundle:Dash:airport/index.html.twig', array(
            'airports' => $airports,
        ));
    }

    /**
     * Creates a new airport entity.
     *
     * @Route("/new", name="dash_airport_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $airport = new Airport();
        $form = $this->createForm('AppBundle\Form\AirportType', $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($airport);
            $em->flush();

            return $this->redirectToRoute('dash_services_edit');
        }

        return $this->render('AppBundle:Dash:airport/new.html.twig', array(
            'airport' => $airport,
            'form' => $form->createView(),
            'pagename'=>'services',
        ));
    }



    /**
     * Displays a form to edit an existing airport entity.
     *
     * @Route("/{id}/edit", name="dash_airport_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Airport $airport)
    {
        $deleteForm = $this->createDeleteForm($airport);
        $editForm = $this->createForm('AppBundle\Form\AirportType', $airport);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dash_services_edit');
        }

        return $this->render('AppBundle:Dash:airport/edit.html.twig', array(
            'airport' => $airport,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pagename'=>'services',
        ));
    }

    /**
     * Deletes a airport entity.
     *
     * @Route("/{id}", name="dash_airport_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Airport $airport)
    {
        $form = $this->createDeleteForm($airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($airport);
            $em->flush();
        }

        return $this->redirectToRoute('dash_airport_index');
    }

    /**
     * Creates a form to delete a airport entity.
     *
     * @param Airport $airport The airport entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Airport $airport)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_airport_delete', array('id' => $airport->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
