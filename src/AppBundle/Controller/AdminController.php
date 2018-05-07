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
     * @Route("/galery", name="dash_gallery")
     * @Method({"GET", "POST"})
     */
    public function galeryAction(Request $request)
    {
        $image = new \AppBundle\Entity\Image();
        $form = $this->createForm('AppBundle\Form\ImageType', $image);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->render('AppBundle:Dash:gallery.html.twig', ['pagename' => 'gallery', 'image_form' => $form->createView()]);

        }

        return $this->render('AppBundle:Dash:gallery.html.twig', ['pagename' => 'gallery', 'image_form' => $form->createView()]);

    }

}
