<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blogentrie;
use AppBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Blogentrie controller.
 *
 * @Route("dash/blog")
 */
class BlogentrieController extends Controller
{
    /**
     * Lists all blogentrie entities.
     *
     * @Route("/", name="dash_blog_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogentries = $em->getRepository('AppBundle:Blogentrie')

            ->createQueryBuilder("c")->orderBy("c.publisheddate", "DESC")
            ->getQuery()->getResult();

          //  ->findBy(['id'=>''], ['publisheddate'=>'DESC']);

        return $this->render('AppBundle:Dash:blogentrie/index.html.twig', array(
            'blogentries' => $blogentries,
        ));
    }

    /**
     * Creates a new blogentrie entity.
     *
     * @Route("/new", name="dash_blog_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blogentrie = new Blogentrie();



        $form = $this->createForm('AppBundle\Form\BlogentrieType', $blogentrie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $blogentrie->setTitleurl(urlencode($blogentrie->getTitle()));
            $blogentrie->setTitleurlen(urlencode($blogentrie->getTitleEn()));
            $em->persist($blogentrie);
            $em->flush();

            return $this->redirectToRoute('dash_blog_index');
        }

        return $this->render('AppBundle:Dash:blogentrie/new.html.twig', array(
            'blogentrie' => $blogentrie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blogentrie entity.
     *
     * @Route("/{id}/edit", name="dash_blog_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Blogentrie $blogentrie)
    {
        $deleteForm = $this->createDeleteForm($blogentrie);
        $editForm = $this->createForm('AppBundle\Form\BlogentrieType', $blogentrie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'Los cambios en el Post fueron guardados! >> info >> ti-save'
            );
            return $this->redirectToRoute('dash_blog_edit', array('id' => $blogentrie->getId()));
        }

        return $this->render('AppBundle:Dash:blogentrie/edit.html.twig', array(
            'blogentrie' => $blogentrie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blogentrie entity.
     *
     * @Route("/{id}", name="dash_blog_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Blogentrie $blogentrie)
    {
        $form = $this->createDeleteForm($blogentrie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogentrie);
            $em->flush();
            $this->addFlash(
                'notice',
                'El Post fue eliminado correctamente >> danger >> ti-trash'
            );
        }

        return $this->redirectToRoute('dash_blog_index');
    }

    /**
     * Creates a form to delete a blogentrie entity.
     *
     * @param Blogentrie $blogentrie The blogentrie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Blogentrie $blogentrie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_blog_delete', array('id' => $blogentrie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
