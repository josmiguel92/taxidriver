<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Testimony;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Testimony controller.
 *
 * @Route("dash/testimonies")
 */
class TestimonyController extends Controller
{
    /**
     * Lists all testimony entities.
     *
     * @Route("/", name="dash_testimonies_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $testimonies = $em->getRepository('AppBundle:Testimony')->findAll();

        return $this->render('AppBundle:Dash:testimony/index.html.twig', array(
            'testimonies' => $testimonies,
        ));
    }

    /**
     * Creates a new testimony entity.
     *
     * @Route("/new", name="dash_testimonies_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $testimony = new Testimony();
        $form = $this->createForm('AppBundle\Form\TestimonyType', $testimony);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($testimony);
            $em->flush();

            $this->addFlash(
                'notice',
                'El testimonio fue agregado correctamente! >> success >> ti-disk'
            );

            return $this->redirectToRoute('dash_testimonies_index');
        }

        return $this->render('AppBundle:Dash:testimony/new.html.twig', array(
            'testimony' => $testimony,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing testimony entity.
     *
     * @Route("/{id}/edit", name="dash_testimonies_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Testimony $testimony)
    {
        $deleteForm = $this->createDeleteForm($testimony);
        $editForm = $this->createForm('AppBundle\Form\TestimonyType', $testimony);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'El testimonio fue editado correctamente! >> success >> ti-pencil'
            );

            return $this->redirectToRoute('dash_testimonies_edit', array('id' => $testimony->getId()));
        }

        return $this->render('AppBundle:Dash:testimony/edit.html.twig', array(
            'testimony' => $testimony,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a testimony entity.
     *
     * @Route("/{id}", name="dash_testimonies_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Testimony $testimony)
    {
        $form = $this->createDeleteForm($testimony);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($testimony);
            $em->flush();

            $this->addFlash(
                'notice',
                'El testimonio fue eliminado correctamente! >> success >> ti-trash'
            );
        }

        return $this->redirectToRoute('dash_testimonies_index');
    }

    /**
     * Creates a form to delete a testimony entity.
     *
     * @param Testimony $testimony The testimony entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Testimony $testimony)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_testimonies_delete', array('id' => $testimony->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
