<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Place;
use AppBundle\Utils\Utils;
use Couchbase\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;
use AppBundle\Entity\Booking;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Booking controller.
 */
class BookingController extends Controller
{

    /**
     * @Route("/booking", defaults={"_locale": "en"})
     * @Route("/{_locale}/booking", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|es|fr"}, name="add_booking")
     */
    public function bookingAction(Request $request, $_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();

        if ($places) {

            $booking = new Booking();
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking, array(
                'action' => $this->generateUrl('add_booking'),
                'method' => 'POST',
            ));

            $booking_form->handleRequest($request);


            if ($booking_form->isSubmitted() && $booking_form->isValid()) {

                if(isset($_POST['g-recaptcha-response']))
                {
                    $captcha=$_POST['g-recaptcha-response'];

                    if ($booking->getPlacesCollection())
                        $booking->setPlacesCollection(Utils::placesJasonParse($booking->getPlacesCollection()));
                    $application_key = $this->container->getParameter('google.recaptcha_secret_key');
                    //$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$application_key."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
                    /*    if($response['success'] == true)
                    {
*/
                        //validacion para enviar correo a lester o no.
                        if(Utils::isSimpleBooking($booking))
                        {
                            $_place = $em->getRepository('AppBundle:Place')->find($booking->getPlace());
                            $booking->setPrice(Utils::calculateSimpleRoutePrices($_place, $booking->getNumpeople()));

                            $booking->setAccepted(true);

                        }
                        $em->persist($booking);
                        $em->flush();
                        return $this->redirectToRoute('purchase_details', [
                            '_token'=>$booking->getToken(),
                            '_locale'=>$_locale
                        ]);



                 //   }
                    //TODO: enviar mensaje flash de que no se lleno el formulario correctamentes

                }


            }

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();

           return $this->render('AppBundle:Front:booking.html.twig', [
                    'booking_form'=>$booking_form->createView(),
                    'locale'=>$_locale,
                    'content'=>$content[0],
                    'socialNetworks'=>$socialNetworks,
                    'hashtags'=>$hashtags,
                    'places'=>$places,
                    ]);
        }
        else
            throw new Exception("No hay entradas de lugares");
    }


    /**
    * @Route("/booking/{_id}", defaults={"_locale": "en"}, requirements={"_id":"\d+"})
     * @Route("/{_locale}/booking/{_id}/{_name}", requirements={"_id":"\d+"}, defaults={"_locale": "en"},
     * name="booking_place")
     */
    public function bookingPlaceAction(Request $request, $_locale, $_id)
    {

        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        $place = $em->getRepository('AppBundle:Place')->find($_id);

        if ($place)
        {

            $booking = new Booking();
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking, array(
                'action' => $this->generateUrl('add_booking'),
                'method' => 'POST',
            ));

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();


            return $this->render('AppBundle:Front:bookingPlace.html.twig', [
                    'booking_form'=>$booking_form->createView(),
                    'locale'=>$_locale,
                    'content'=>$content[0],
                    'socialNetworks'=>$socialNetworks,
                    'hashtags'=>$hashtags,
                    'place'=>$place,
                    'places'=>$places,
                    ]);
        }
        else
            throw new NotFoundHttpException();
    }

    /**
     * @Route("/booking/own-tour")
     * @Route("/{_locale}/booking/own-tour", defaults={"_locale": "en"},
     * requirements={"_locale": "en|es|fr"},  name="bookingOwnTour")
     */
    public function bookingOwnTourAction(Request $request, $_locale='en')
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:SiteContent')->findAll();
        $places = $em->getRepository('AppBundle:Place')->findAll();

        if ($content) {

            $booking = new Booking();
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking, array(
                'action' => $this->generateUrl('add_booking'),
                'method' => 'POST',
            ));

            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();

            return $this->render('AppBundle:Front:bookingOwnTour.html.twig', [
                'booking_form'=>$booking_form->createView(),
                'locale'=>$_locale,
                'content'=>$content[0],
                'socialNetworks'=>$socialNetworks,
                'hashtags'=>$hashtags,
                'places'=>$places,
                ]);
        }
        else
            throw new Exception("No hay entradas de lugares");
    }

    /**
     * @Route("/purchase-details/{_token}", requirements={"_token":"[a-z0-9]*"})
     * @Route("/{_locale}/purchase-details/{_token}", defaults={"_locale": "en"},
     * requirements={"_locale": "en|es|fr", "_token":"[a-z0-9]*"},  name="purchase_details")
     */
    public function purchaseDetailsAction(Request $request, $_locale='en', $_token)
    {
        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('AppBundle:Booking')->findOneBy(['token'=>$_token]);

        if ($purchase) {

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            $_places = $em->getRepository('AppBundle:Place')->findBy(['id'=>$purchase->getPlacesCollection()]);
            $place = $em->getRepository('AppBundle:Place')->find($purchase->getPlace());
            $places = $em->getRepository('AppBundle:Place')->findAll();


            return $this->render('AppBundle:Front:purchaseDetails.html.twig', [
                'locale'=>$_locale,
                'content'=>$content[0],
                'socialNetworks'=>$socialNetworks,
                'hashtags'=>$hashtags,
                'selectedPlaces'=>$_places,
                'place'=>$place,
                'purchase'=>$purchase,
                'places'=>$places,
                ]);
        }
        else
            throw new \HttpRequestException(
                "No existe esa referencia",400);
    }

    /**
    * @Route("/pay/{_token}", requirements={"_token":"[a-z0-9]*"}, name="paypal_redirection")
    **/
    public function payPalAction($_token){
        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('AppBundle:Booking')->findOneBy(['token'=>$_token]);
        if($purchase)
        {
            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            //$email = $content[0]->getEmail();
            $account_email = 'karlita.garcia.l0v3-facila@gmail.com';
            $_place = $em->getRepository('AppBundle:Place')->find($purchase->getPlace());
            $product_name = "Tour Taxi driver Cuba".$_place->getNameLocale();
            $product_id = $_token;
            $_person_number = $purchase->getNumpeople();
            $product_price = Utils::calculateSimpleRoutePrices($_place, $_person_number);

            return $this->render('AppBundle:Front:dummyPaypalForm.html.twig', [
                'account_email'=>$account_email,
                'product_name'=>$product_name,
                'product_id'=>$_token,
                'product_price'=>$product_price

            ]);
        }
        else
        throw new \HttpRequestException(
        "No existe esa referencia",400);

    }

    /**
     * @Route("/purchase-details/{_token}/edit", requirements={"_token":"[a-z0-9]*"},  name="purchase_details_edit")
     */
    public function purchaseDetailsEditAction(Request $request, $_token)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository("AppBundle:Booking")->findOneBy(['token'=>$_token]);

        return new Response($booking->getFullname());
    }
}
