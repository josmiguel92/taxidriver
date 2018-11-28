<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\InfographItem;
use AppBundle\Entity\Place;
use AppBundle\Entity\Services;
use AppBundle\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use AppBundle\Entity\Image;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


/**
 * Admin controller.
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
        return $this->redirectToRoute('dash_booking');
    }

    /**
     * @Route("/gallery", name="dash_gallery")
     * @Method({"GET", "POST"})
     */
    public function galleryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository("AppBundle:Image")->findBy([],["id"=>'desc']);

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
            return $this->redirectToRoute('dash_sitecontent_edit');
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

        $social = new \AppBundle\Entity\Socialnetwork();

        $socialForm = $this->createForm('AppBundle\Form\SocialnetworkType', $social);

        $socialForm->handleRequest($request);

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

        $socialnetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
        $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
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
     * @Method("DELETE",)
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
        $place = new \AppBundle\Entity\Place();
        $placeForm = $this->createForm('AppBundle\Form\PlaceType', $place);


        $placeForm->handleRequest($request);



        try{
            if ($placeForm->isSubmitted() && $placeForm->isValid()) {
                $em->persist($place);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'El lugar fue añadido correctamente! >> info >> ti-save'
                );
            }

        }

        catch(UniqueConstraintViolationException $e){
            $this->addFlash(
                'notice',
                'Ya existe un campo con esos datos! >> danger >> ti-face-sad'
            );
        }


        $places = $em->getRepository('AppBundle:Place')->findAll();

        return $this->render('@App/Dash/services/services.html.twig',
            ['pagename'=>'services',
                'places'=>$places,
                'route_form'=>$placeForm->createView()
            ]);

    }



    /**
     * Displays a form to edit an existing Place entity.
     *
     * @Route("/services/place/{id}/edit", name="dash_services_place_edit")
     * @Method({"GET", "POST"})
     */
    public function editServiceRouteAction(Request $request, Place $place, $id)
    {
        $deleteForm = $this->createServicePlaceDeleteForm($place);
        $editForm = $this->createForm('AppBundle\Form\PlaceType', $place,
            ['action' => $this->generateUrl('dash_services_place_edit', array('id' => $id))]);

        $em = $this->getDoctrine()->getManager();


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($place);
            $em->flush();

            $this->addFlash(
                'notice',
                'Los cambios en la ruta fueron salvados! >> info >> ti-save'
            );

            return $this->redirectToRoute('dash_services_edit');
        }


        return $this->render('AppBundle:Dash:servicePlaceEditForm.html.twig', array(
            'route_form' => $editForm->createView(),
            'route_delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Creates a form to delete a Image entity.
     *
     * @param Place $image The Services entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createServicePlaceDeleteForm(\AppBundle\Entity\Place $place)
    {
        return $this->createFormBuilder()
            ->setAttributes(['name'=>'delete_image_form'])
            ->setAction($this->generateUrl('dash_services_place_delete', array('id' => $place->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


    /**
     * @Route("/bookinglist", name="dash_booking")
     * @Method("GET")
     */
    public function bookingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository("AppBundle:Booking")
        ->createQueryBuilder("b")
            ->where("b.pickuptime > :yesterday")
            ->setParameter("yesterday", new \DateTime('yesterday'))
            ->orderBy("b.pickuptime", "ASC")
            ->getQuery()->getResult();

        $_places = $em->getRepository("AppBundle:Place")->findByNonePlaceNames();
        $places = [];

        $all_books = $em->getRepository("AppBundle:Booking")->findAll();//ByTour(true);

        $tours_books = $em->getRepository("AppBundle:Booking")->findByTour(true);

        $experiences_books = $em->getRepository("AppBundle:Booking")->createQueryBuilder("b")
            ->where("b.experience is not null")
            ->getQuery()->getResult();

        $paypal_books =  $em->getRepository("AppBundle:Booking")->createQueryBuilder("b")
            ->where("b.idpaypal is not null")
            ->getQuery()->getResult();

        foreach ($_places as $value) {
            $places[$value['id']]=$value['name'];
        }

        return $this->render('AppBundle:Dash:booking.html.twig', [
            'pagename' => 'booking',
            'booking' => $booking,
            'all_books'=>$all_books,
            'tours_books'=>$tours_books,
            'experiences_books'=>$experiences_books,
            'paypal_books'=>$paypal_books,
            'places'=>$places]);
    }

    /**
     * @Route("/config", name="dash_config")
     * @Method("GET")
     */
    public function configAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $configValues = $em->getRepository('AppBundle:ConfigValue')->findAll();

        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
        $config = [];
        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }

       if(!isset($config['tasa.usd']))
           $em->persist(new \AppBundle\Entity\ConfigValue("tasa.usd",0.88, "Tasa de conversion USD/CUC"));


        if(!isset($config['price.increment']))
            $em->persist(new \AppBundle\Entity\ConfigValue("price.increment",10, "Incremento del precio por cada persona en los tours y transfers"));

        if(!isset($config['paypal.email']))
            $em->persist(new \AppBundle\Entity\ConfigValue("paypal.email","taxidriverscuba@gmail.com", "Email de la cuenta de Paypal"));

        if(!isset($config['paypal.token']))
            $em->persist(new \AppBundle\Entity\ConfigValue("paypal.token",'xxxxxxxxx',"Token de identificacion de la cuenta en Paypal"));

        if(!isset($config['paypal.url']))
            $em->persist(new \AppBundle\Entity\ConfigValue("paypal.url",'https://www.sandbox.paypal.com/cgi-bin/webscr',"URL para enviar info de pagos a PayPal"));


        if(!isset($config['credit.card']))
            $em->persist(new \AppBundle\Entity\ConfigValue("credit.card",'1234567890123456', "Credit Card"));


        $em->flush();
            $configValues = $em->getRepository('AppBundle:ConfigValue')->findAll();


        return $this->render('AppBundle:Dash:config.html.twig', [
            'pagename'=>'config',
            'configValues' => $configValues
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
        $deleteForm = $this->createInfographDeleteForm($item);
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


        return $this->render('AppBundle:Dash:infographItemEditForm.html.twig', array(
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


    /**
     * Deletes a InfographItem entity.
     *
     * @Route("/infograph/{id}/delete", name="dash_infographitem_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteInfographItemAction(Request $request, \AppBundle\Entity\InfographItem $item)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash(
            'notice',
            'El elemento fue eliminada! >> success >> ti-trash'
        );
        return $this->redirectToRoute('dash_sitecontent_edit');
    }

    /**
     * Deletes a BookingItem entity.
     *
     * @Route("/booking/{id}/delete", name="dash_booking_delete")
     * @Method("GET")
     */
    public function deleteBookingAction(Request $request, \AppBundle\Entity\Booking $item)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash(
            'notice',
            'El elemento fue eliminada! >> success >> ti-trash'
        );
        return $this->redirectToRoute('dash_booking');
    }

    public function notificationsAction(){
        $em =  $this->getDoctrine()->getManager();
        $booking_pend = $em->getRepository("AppBundle:Booking")->findBy(
            ['accepted'=>false]
        );
        $notify = false;

        if($booking_pend)
            $notify = true;

        return $this->render("AppBundle:Dash:notify.html.twig", [
            'notify'=>$notify,
            'booking'=>$booking_pend,
        ]);
    }

    public function sidebarAction($pagename){
        $em =  $this->getDoctrine()->getManager();

        $messagesCount = $em->createQuery(
            'SELECT count(c.id)
             FROM AppBundle:ContactMsgs c'
            )->getResult()[0][1];

        $bookingCount = count($em->getRepository("AppBundle:Booking")
            ->createQueryBuilder("b")

            ->where("b.accepted = false AND b.pickuptime >= :today")

            ->setParameter("today", new \DateTime('today'))
            ->getQuery()->getResult());

        return $this->render("AppBundle:Dash:sidebar.html.twig", [
            'messagesCount' => $messagesCount,
            'bookingCount'=>$bookingCount,
            'pagename'=>$pagename
        ]);
    }
    /**
     * Shows a Messages list
     * @Route("/messages", name="dash_messages_list")
     * @Method({"GET", "POST"})
     **/
    public function messageListAction(){
        $em =  $this->getDoctrine()->getManager();
        $messages = $em->getRepository("AppBundle:ContactMsgs")
            ->createQueryBuilder("c")->orderBy("c.insertDate", "DESC")
            ->getQuery()->getResult();

        return $this->render("AppBundle:Dash:messageList.html.twig", [
            'messages' => $messages
        ]);
    }

    /**
     * Delete a Messages item
     * @Route("/messages/delete/{id}", name="dash_message_delete")
     * @Method("GET")
     **/
    public function messageDeleteAction(\AppBundle\Entity\ContactMsgs $item){
        $em =  $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        return $this->redirectToRoute('dash_messages_list');
    }

    /**
     * Shows a Booking Details and Edit it.
     * @Route("/bookinglist/{booking}/details", requirements={"booking":"\d+"}, name="booking_details")
     * @Method({"GET", "POST"})
     **/
    public function bookinDetailsAction(Request $request, \AppBundle\Entity\Booking $booking){

        $editForm = $this->createForm('AppBundle\Form\BookingAdminType', $booking, [
            'action' => $this->generateUrl(
                'booking_details',
                array('booking' => $booking->getId())
            )
        ]);
        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository("AppBundle:Place")
                ->find($booking->getId());

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $booking->setAccepted(true);
            $em->persist($booking);
            $em->flush();

            if($booking->getPrice() > 0)
                $this->sendUpdateEmail($booking);
            $this->addFlash(
                'notice',
                'Los cambios fueron guardados! >> info >> ti-save'
            );
            return $this->redirectToRoute('dash_booking');
        }

        $views = ['pagename'=>'sitecontent',
            'form' => $editForm->createView(),
            'booking' => $booking,
            'place'=>$place,
        ];

        if($request->isXmlHttpRequest())
            return $this->render('AppBundle:Dash:bookingAjaxDetails.html.twig', $views);

        return $this->render('AppBundle:Dash:bookingGetDetails.html.twig', $views);

    }

    private function sendUpdateEmail(\AppBundle\Entity\Booking $booking){

        $subject = "Taxidriverscuba Notification [UPDATED]";
        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository("AppBundle:Place")
            ->find($booking->getId());

        $content = $em->getRepository('AppBundle:SiteContent')->findAll();
        $senderEmail = $content[0]->getContactemail();
        $address = $content[0]->getContactaddressLocale();
        $telephone = $content[0]->getContacttelephone();


        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom("taxidriverscuba-noreply@taxidriverscuba.com")
            ->setReplyTo($senderEmail)
            ->setTo($booking->getEmail())
            ->setBody(
                $this->renderView(
                    'AppBundle:Email:clientNotificationUpdated.html.twig',
                    [
                        'subject'=>$subject,
                        '_locale'=>$booking->getBookingLocale(),
                        'address' => $address,
                        'telephone'=> $telephone,
                        'place'=>$place,
                        'booking'=>$booking,
                    ]
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

    }

}
