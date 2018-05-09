<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use AppBundle\Entity\Image;


/**
 * Cartel controller.
 *
 * @Route("/dash")
 */
class AdminController extends Controller
{

    /**
     * @Route("/{_locale}", defaults={"_locale": "es"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="dash")
     */
    public function indexAction(Request $request, $_locale)
    {
        return $this->render('AppBundle:Dash:default.html.twig', ['pagename'=>'dash']);
    }

    /**
     * @Route("/gallery", name="dash_gallery")
     * @Method({"GET", "POST"})
     */
    public function galleryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository("AppBundle:Image")->findAll();

        if ($images and count($images) > 0)
        {
            $firstimage = $images[count($images)-1];
            $deleteFormView = $this->createImageDeleteForm($firstimage)->createView();
        }

        $image = new \AppBundle\Entity\Image();

        $deleteFormView = null;
        $new_image_form = $this->createForm('AppBundle\Form\ImageType', $image,
                        ['action' => $this->generateUrl('dash_gallery_image_new')]);
        $form = $this->createForm('AppBundle\Form\ImageType', $image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
        }


        return $this->render('AppBundle:Dash:gallery.html.twig', [
            'pagename' => 'gallery',
            'image_form' => $form->createView(),
            'new_image_form' => $new_image_form->createView(),
            'image_delete_form' => $deleteFormView,
            'image_list' => $images]);
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/gallery/{id}/edit", name="dash_gallery_image_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, \AppBundle\Entity\Image $image)
    {
        $form = $this->createImageDeleteForm($image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
        }
        $this->addFlash(
            'notice',
            'La imagen fue eliminada definitivamente! >> success >> ti-trash'
        );
        return $this->redirectToRoute('dash_gallery');
    }


    /**
     * Creates a new Image entity.
     *
     * @Route("/gallery/image/new", name="dash_gallery_image_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $imagen = new Image();
        $form = $this->createForm('AppBundle\Form\ImageType', $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagen);
            $em->flush();

            $this->addFlash(
                'notice',
                'La imagen fue subida correctamente! >> success >> ti-upload'
            );
        }
        else
            $this->addFlash(
                'notice',
                'Ocurrio un error con los datos. >> danger >> ti-face-sad'
            );


        return $this->redirectToRoute('dash_gallery');

    }

    /**
     * Displays a form to edit an existing Imagen entity.
     *
     * @Route("/gallery/{id}/edit", name="dash_gallery_image_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Image $imagen, $id)
    {
        $deleteForm = $this->createImageDeleteForm($imagen);
        $editForm = $this->createForm('AppBundle\Form\ImageType', $imagen,
                                ['action' => $this->generateUrl('dash_gallery_image_edit', array('id' => $id))]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagen);
            $em->flush();

            $this->addFlash(
                'notice',
                'Los cambios en la imagen fueron salvados! >> info >> ti-save'
            );

            return $this->redirectToRoute('dash_gallery');
        }


        return $this->render('AppBundle:Dash:galleryEditImageForm.html.twig', array(
            'image_form' => $editForm->createView(),
            'image_delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Creates a form to delete a Image entity.
     *
     * @param Image $image The Image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImageDeleteForm(\AppBundle\Entity\Image $image)
    {
        return $this->createFormBuilder()
            ->setAttributes(['name'=>'delete_image_form'])
            ->setAction($this->generateUrl('dash_gallery_image_delete', array('id' => $image->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
