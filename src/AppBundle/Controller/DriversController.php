<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Drivers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Driver controller.
 *
 * @Route("dash/drivers")
 */
class DriversController extends Controller
{
    /**
     * Lists all driver entities.
     *
     * @Route("/", name="dash_drivers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $drivers = $em->getRepository('AppBundle:Drivers')->findAll();

        return $this->render('AppBundle:Dash:drivers/index.html.twig', array(
            'drivers' => $drivers,
        ));
    }

    /**
     * Creates a new driver entity.
     *
     * @Route("/new", name="dash_drivers_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $driver = new Drivers();
        $form = $this->createForm('AppBundle\Form\DriversType', $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($driver);
            $em->flush();

            return $this->redirectToRoute('dash_drivers_show', array('id' => $driver->getId()));
        }

        return $this->render('AppBundle:Dash:drivers/new.html.twig', array(
            'driver' => $driver,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing driver entity.
     *
     * @Route("/{id}/edit", name="dash_drivers_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Drivers $driver)
    {
        $deleteForm = $this->createDeleteForm($driver);
        $editForm = $this->createForm('AppBundle\Form\DriversType', $driver);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dash_drivers_edit', array('id' => $driver->getId()));
        }

        return $this->render('AppBundle:Dash:drivers/edit.html.twig', array(
            'driver' => $driver,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a driver entity.
     *
     * @Route("/{id}", name="dash_drivers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Drivers $driver)
    {
        $form = $this->createDeleteForm($driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($driver);
            $em->flush();
        }

        return $this->redirectToRoute('dash_drivers_index');
    }

    /**
     * Creates a form to delete a driver entity.
     *
     * @param Drivers $driver The driver entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Drivers $driver)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_drivers_delete', array('id' => $driver->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
