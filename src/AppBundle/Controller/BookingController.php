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
        Utils::setRequestLocaleLang($_locale);
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

                $captcha = '';

                //Si se ejecuta env. PROD, validar catpcha... y si no es success, ir a home!
                if($_SERVER['SCRIPT_NAME']!= '/app_dev.php') {
                    if (isset($_POST['g-recaptcha-response'])) {
                        $captcha = $_POST['g-recaptcha-response'];
                    }
                    $application_key = $this->container->getParameter('google.recaptcha_secret_key');
                    $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret="
                                            .$application_key."&response=".$captcha.
                                            "&remoteip=".$_SERVER['REMOTE_ADDR']),
                                        true);
                        if($response['success'] != true)
                            return $this->redirectToRoute('home', [
                                '_locale'=>$_locale
                            ]);

                }

                //validacion para enviar correo a lester o no.
                if(Utils::isSimpleBooking($booking))
                {
                    $_place = $em->getRepository('AppBundle:Place')->find($booking->getPlace());
                    $booking->setPrice(Utils::calculateSimpleRoutePrices($_place, $booking->getNumpeople()));

                    $booking->setAccepted(true);
                }
                $em->persist($booking);
                $em->flush();

                //todo: mover a la Action correcta, luego del pago
                $this->sendEmailNotifications($booking);

                return $this->redirectToRoute('purchase_details', [
                    '_token'=>$booking->getToken(),
                    '_locale'=>$_locale
                ]);

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
        Utils::setRequestLocaleLang($_locale);
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
        Utils::setRequestLocaleLang($_locale);
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
     * @Route("/{_locale}/purchase-details/{_token}/{_paypalCallback}", defaults={"_locale": "en"},
     * requirements={"_locale": "en|es|fr", "_paypalCallback":"success|cancel|cash", "_token":"[a-z0-9]*"},  name="purchase_details_paypal")
     */
    public function purchaseDetailsAction(Request $request, $_locale='en', $_token, $_paypalCallback=null)
    {
        Utils::setRequestLocaleLang($_locale);

        if(isset($_REQUEST['tx'])){
            echo "<!-- ";
            echo $_REQUEST['item_number']." ID del producto\n";
            echo $_REQUEST['tx']." ID de transacción Paypal\n";
            echo $_REQUEST['amt']." Monto recibido Paypal\n";
            echo $_REQUEST['cc']."  Moneda recibida de Paypal\n";
            echo $_REQUEST['st']." Estado del producto Paypal\n";
            echo "-->";
        }
        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('AppBundle:Booking')->findOneBy(['token'=>$_token]);

        if ($purchase) {

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            if($purchase->getPlace())
                $place = $em->getRepository('AppBundle:Place')->find($purchase->getPlace());
            else $place = null;
            $places = $em->getRepository('AppBundle:Place')->findAll();

            /*TODO: proccess Paypal POST headers and push it on DB*/

            return $this->render('AppBundle:Front:purchaseDetails.html.twig', [
                'locale'=>$_locale,
                'content'=>$content[0],
                'socialNetworks'=>$socialNetworks,
                'hashtags'=>$hashtags,
                'place'=>$place,
                'purchase'=>$purchase,
                'places'=>$places,
                'paypalCallback'=>$_paypalCallback
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
        $_locale = Utils::getRequestLocaleLang();

        if($purchase)
        {
            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            //$email = $content[0]->getEmail();
            $account_email = 'karlita.garcia.l0v3@gmail.com';
            $_place = $em->getRepository('AppBundle:Place')->find($purchase->getPlace());
            $_person_number = $purchase->getNumpeople();
            //TODO:Escribir bien el nombre del producto
            $product_name = Utils::buildProductName($purchase, $_place);

            $price = Utils::calculateSimpleRoutePrices($_place, $_person_number);
            $product_price = $price - 0.1*$price;

            return $this->render('AppBundle:Front:dummyPaypalForm.html.twig', [
                'account_email'=>$account_email,
                'product_name'=>$product_name,
                '_token'=>$_token,
                '_locale'=>$_locale,
                'product_price'=>$product_price

            ]);
        }
        else
        throw new \HttpRequestException(
        "No existe esa referencia",400);

    }

    private function sendEmailNotifications(\AppBundle\Entity\Booking $booking){

        $subject = "Taxidriverscuba Notification";
        $em = $this->getDoctrine()->getManager();
        if($booking->getPlace())
            $place = $em->getRepository("AppBundle:Place")
                ->find($booking->getPlace());
        else $place = null;

        $content = $em->getRepository('AppBundle:SiteContent')->findAll();
        $senderEmail = $content[0]->getContactemail();
        $address = $content[0]->getContactaddressLocale();
        $telephone = $content[0]->getContacttelephone();

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setReplyTo($senderEmail)
            ->setTo($booking->getEmail())
            //TODO: get email from parameters
            ->setFrom("taxidriverscuba-noreply@taxidriverscuba.com")
            ->setBody(
                $this->renderView(
                    'AppBundle:Email:clientNotification.html.twig',
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

        $message = \Swift_Message::newInstance()
            ->setSubject($subject. " (".$booking->getId().")")
            ->setTo($senderEmail)
            ->setFrom("noreply@taxidriverscuba.com")
            ->setBody(
                $this->renderView(
                    'AppBundle:Email:booking-email.html.twig',
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
