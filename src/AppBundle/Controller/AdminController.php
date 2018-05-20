<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\InfographItem;
use AppBundle\Entity\Services;
use AppBundle\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use AppBundle\Entity\Image;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


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
    public function newImageAction(Request $request)
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
    public function editimageAction(Request $request, Image $imagen, $id)
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



    /**
     * Displays a form to edit the content of homepage.
     *
     * @Route("/sitecontent", name="dash_sitecontent_edit")
     * @Method({"GET", "POST"})
     */
    public function sitecontentAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:SiteContent')->find(1);
        $content ? $sitecontent = $content :  $sitecontent = new \AppBundle\Entity\SiteContent();

        $infographs = $em->getRepository("AppBundle:InfographItem")->findAll();

        $editForm = $this->createForm('AppBundle\Form\SiteContentType', $sitecontent);

        $new_infograph_form = $this->createForm('AppBundle\Form\InfographItemType', new InfographItem(),
            ['action' => $this->generateUrl('dash_infographitem_new')]);


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($sitecontent);
            $em->flush();

            $this->addFlash(
                'notice',
                'Los cambios en los contenidos fueron guardados! >> info >> ti-save'
            );
        }
        return $this->render('AppBundle:Dash:sitecontent.html.twig',
            ['pagename'=>'sitecontent',
            'content_form' => $editForm->createView(),
            'infographs' => $infographs,
            'new_infograph_form' => $new_infograph_form->createView(),
            ]);

    }

    /**
     * Displays a form to edit the content of social networks.
     *
     * @Route("/socialnet", name="dash_socialnet_edit")
     * @Method({"GET", "POST"})
     */
    public function socialnetAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $socialnetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
        $social = new \AppBundle\Entity\Socialnetwork();

        $socialForm = $this->createForm('AppBundle\Form\SocialnetworkType', $social);

        $socialForm->handleRequest($request);
        $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
        $hashtag = new \AppBundle\Entity\Hashtag();

        $tagsForm = $this->createForm('AppBundle\Form\HashtagType', $hashtag);
        $tagsForm->handleRequest($request);

        try{
            if ($socialForm->isSubmitted() && $socialForm->isValid()) {

                $em->persist($social);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Los cambios en los contenidos fueron guardados! >> info >> ti-save'
                );
            }


            if ($tagsForm->isSubmitted() && $tagsForm->isValid()) {

                $em->persist($hashtag);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Los cambios en los contenidos fueron guardados! >> info >> ti-save'
                );
            }
        }
        catch(UniqueConstraintViolationException $e){
            $this->addFlash(
                'notice',
                'Ya existe un campo con esos datos! >> danger >> ti-face-sad'
            );
        }

        return $this->render('AppBundle:Dash:socialnetwork.html.twig',
            ['pagename'=>'socialnet',
                'socialForm' => $socialForm->createView(),
                'socialnetworks'=> $socialnetworks,
                'hashtags'=>$hashtags,
                'tagsForm'=>$tagsForm->createView()
            ]);

    }

    /**
     * Deletes a HashTag entity.
     *
     * @Route("/hashtag/{id}/delete", name="dash_socialnet_hashtag_delete")
     * @Method("GET")
     */
    public function deletehashtagAction(Request $request, \AppBundle\Entity\Hashtag $item)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();

        $this->addFlash(
            'notice',
            'El Hashtag fue eliminado! >> success >> ti-trash'
        );
        return $this->redirectToRoute('dash_socialnet_edit');
    }

    /**
     * Deletes a HashTag entity.
     *
     * @Route("/socialnetwork/{id}/delete", name="dash_socialnet_profile_delete")
     * @Method("GET")
     */
    public function deletesocialnetAction(Request $request, \AppBundle\Entity\Socialnetwork $item)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash(
            'notice',
            'El perfil de Red Social fue eliminado! >> success >> ti-trash'
        );
        return $this->redirectToRoute('dash_socialnet_edit');
    }

    /**
     * Deletes a Place entity.
     *
     * @Route("/services/place/{id}/delete", name="dash_services_place_delete")
     * @Method("GET")
     */
    public function deleteplaceAction(Request $request, \AppBundle\Entity\Place $item)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash(
            'notice',
            'El lugar fue eliminado! >> success >> ti-trash'
        );
        return $this->redirectToRoute('dash_services_edit');
    }

    /**
     * Displays a form to edit the content of service route.
     *
     * @Route("/services", name="dash_services_edit")
     * @Method({"GET", "POST"})
     */
    public function servicesAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        $place = new \AppBundle\Entity\Place();

        $placeForm = $this->createForm('AppBundle\Form\PlaceType', $place);
        $placeForm->handleRequest($request);

        $services = $em->getRepository('AppBundle:Services')->findAll();
        $service = new \AppBundle\Entity\Services();

        $serviceForm = $this->createForm('AppBundle\Form\ServicesType', $service);
        $serviceForm->handleRequest($request);

        try{
            if ($placeForm->isSubmitted() && $placeForm->isValid()) {
                $em->persist($place);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'El lugar fue añadido correctamente! >> info >> ti-save'
                );
            }


            if ($serviceForm->isSubmitted() && $serviceForm->isValid()) {

                $em->persist($service);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Los cambios en los servicios fueron guardados! >> info >> ti-save'
                );
            }
        }
        catch(UniqueConstraintViolationException $e){
            $this->addFlash(
                'notice',
                'Ya existe un campo con esos datos! >> danger >> ti-face-sad'
            );
        }

        return $this->render('AppBundle:Dash:services.html.twig',
            ['pagename'=>'services',
                'serviceForm' => $serviceForm->createView(),
                'services'=> $services,
                'places'=>$places,
                'placeForm'=>$placeForm->createView()
            ]);

    }

    /**
     * Deletes a Place entity.
     *
     * @Route("/services/route/{id}/delete", name="dash_services_route_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteServiceAction(Request $request, \AppBundle\Entity\Services $item)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash(
            'notice',
            'La ruta fue eliminada! >> success >> ti-trash'
        );
        return $this->redirectToRoute('dash_services_edit');
    }

    /**
     * Displays a form to edit an existing Route entity.
     *
     * @Route("/services/route/{id}/edit", name="dash_services_route_edit")
     * @Method({"GET", "POST"})
     */
    public function editServiceRouteAction(Request $request, Services $services, $id)
    {
        $deleteForm = $this->createServiceRouteDeleteForm($services);
        $editForm = $this->createForm('AppBundle\Form\ServicesType', $services,
            ['action' => $this->generateUrl('dash_services_route_edit', array('id' => $id))]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($services);
            $em->flush();

            $this->addFlash(
                'notice',
                'Los cambios en la ruta fueron salvados! >> info >> ti-save'
            );

            return $this->redirectToRoute('dash_services_edit');
        }


        return $this->render('AppBundle:Dash:serviceRouteEditForm.html.twig', array(
            'route_form' => $editForm->createView(),
            'route_delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Creates a form to delete a Image entity.
     *
     * @param Image $image The Services entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createServiceRouteDeleteForm(\AppBundle\Entity\Services $service)
    {
        return $this->createFormBuilder()
            ->setAttributes(['name'=>'delete_image_form'])
            ->setAction($this->generateUrl('dash_services_route_delete', array('id' => $service->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


    /**
     * @Route("/booking", name="dash_booking")
     * @Method("GET")
     */
    public function bookingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository("AppBundle:Booking")->findAll();

        return $this->render('AppBundle:Dash:booking.html.twig', [
            'pagename' => 'booking',
            'booking' => $booking]);
    }

    /**
     * @Route("/paygateway", name="dash_paygateway")
     * @Method({"GET", "POST"})
     */
    public function paygatewayAction(){
        return $this->render('AppBundle:Dash:paygateway.html.twig', [
            'pagename' => 'paygateway',
        ]);
    }

    /**
     * @Route("/config", name="dash_config")
     * @Method("GET")
     */
    public function configAction(Request $request){
        return $this->render('AppBundle:Dash:config.html.twig', [
            'pagename'=>'config',
        ]);
    }

    /**
     * Creates a new InfographItem entity.
     *
     * @Route("/infograph/new", name="dash_infographitem_new")
     * @Method("POST")
     */
    public function newInfographItemAction(Request $request)
    {
        $item = new InfographItem();
        $form = $this->createForm('AppBundle\Form\InfographItemType', $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash(
                'notice',
                'La Infografía fue agregada correctamente! >> success >> ti-upload'
            );
        }
        else
            $this->addFlash(
                'notice',
                'Ocurrio un error con los datos. >> danger >> ti-face-sad'
            );


        return $this->redirectToRoute('dash_sitecontent_edit');

    }

    /**
     * Displays a form to edit an existing InfographItem entity.
     *
     * @Route("/infograph/{id}/edit", name="dash_infographitem_edit")
     * @Method({"GET", "POST"})
     */
    public function editinfographitemAction(Request $request, infographitem $item, $id)
    {
        $deleteForm = $this->createImageDeleteForm($item);
        $editForm = $this->createForm('AppBundle\Form\InfographItemType', $item,
            ['action' => $this->generateUrl('dash_infographitem_edit', array('id' => $id))]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash(
                'notice',
                'Los cambios en la infografia fueron salvados! >> info >> ti-save'
            );

            return $this->redirectToRoute('dash_sitecontent_edit');
        }


        return $this->render('AppBundle:Dash:contentEditInfographitemForm.html.twig', array(
            'infographitem_form' => $editForm->createView(),
            'infographitem_delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Creates a form to delete a InfographItem entity.
     *
     * @param InfographItem $item The InfographItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createInfographDeleteForm(\AppBundle\Entity\InfographItem $item)
    {
        return $this->createFormBuilder()
            ->setAttributes(['name'=>'delete_infographitem_form'])
            ->setAction($this->generateUrl('dash_infographitem_delete', array('id' => $item->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }



}
