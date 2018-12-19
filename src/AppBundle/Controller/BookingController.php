<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Airport;
use AppBundle\Entity\AirportTransfer;
use AppBundle\Entity\Experience;
use AppBundle\Entity\Place;
use AppBundle\Entity\Service;
use AppBundle\Entity\Testimony;
use AppBundle\Entity\Transfer;
use AppBundle\Utils\Utils;
use Couchbase\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
     * @Route("/_booking", name="new_booking")
     */
    public function _bookingAction(Request $request){
        echo Service::class;
        dump([Transfer::class, Experience::class, AirportTransfer::class]);
        exit();
        return new Response($service);
    }
    /**
     * @Route("/booking", defaults={"_locale": "en"})
     * @Route("/{_locale}/booking", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|es|fr"}, name="add_booking")
     */
    public function bookingAction(Request $request, $_locale)
    {
        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();

        $booking = new Booking();
        $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking, array(
            'action' => $this->generateUrl('add_booking'),
            'method' => 'POST',
        ));
        if($booking)

        $booking_form->add('airportname', ChoiceType::class,
            ['choices' => $em->getRepository('AppBundle:Airport')->findAll(),
                'choices_as_values' => true,
                'choice_label' => 'NameLocale',
                'choice_value' => 'Id',
                'choice_name' => 'machineName',
                'attr'=>['disabled'=>true]
            ]);

        $booking_form->handleRequest($request);

        $places = $em->getRepository('AppBundle:Place')->findAll();

        if ($places) {

            $noPlaceSelected = true;
            if($booking->getPlace()>0)
                $noPlaceSelected = false;

            if ($booking_form->isSubmitted() && $booking_form->isValid()) {

                $captcha = '';

                //Si se ejecuta env. PROD, validar catpcha... y si no es success, ir a home!
                if(substr_count($_SERVER['SERVER_NAME'],'taxidriverscuba.com')) {
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

                $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
                $config = [];
                foreach ($_config as $item){
                    $config[$item->getName()]=$item->getValue();
                }


                //validacion para enviar correo a lester o no.
                if(!$booking->isExperience() && $booking->getNumpeople()<=5)
                    if($_price = $booking->calculateSimplePrice($config['price.increment']))
                    {
                        $booking->setPrice($_price);
                        $booking->setAccepted(true);
                    }


                $em->persist($booking);
                $em->flush();


                return $this->redirectToRoute('purchase_details', [
                    '_token'=>$booking->getToken(),
                    '_locale'=>$_locale
                ]);

            }

            return $this->redirectToRoute('home');
        }
        else
            throw new Exception("No hay entradas de lugares");
    }


    /**
    * @Route("/booking/{_id}", defaults={"_locale": "en"}, requirements={"_id":"\d+"})
    * @Route("/{_locale}/booking/{_id}/{_name}", requirements={"_id":"\d+"}, defaults={"_locale": "en"},
    * name="booking_place")
    */
    public function bookingPlaceAction(Request $request, $_locale, $_id, $_name)
    {
        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        $transfer = $em->getRepository('AppBundle:Transfer')->find($_id);
      
      if(!$transfer) {
            return $this->createNotFoundException("This product not exist");
        }
        
      if ($nameRequest != $nameLocale){
            return $this->redirectToRoute('booking_place',array(
                '_locale'=>$_locale,
                '_id'=> $_id,
                '_name' => $nameLocale
            ), 301);
        }
      
        $testimonials = $em->getRepository('AppBundle:Testimony')
                            ->findRandomByTransferOrPlace($transfer->getId(),$transfer->getTargetPlace()->getId());

        $suggestedPlaces = $em->getRepository('AppBundle:Transfer')->findRandomByImportant($transfer->getId());
        $nameLocale = Utils::slugify($transfer->getNameLocale());
        $nameRequest = $_name;

        

        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
        $config = [];;
        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }

        if ($transfer)
        {

            $booking = new Booking();
            $booking->setServiceType('Transfer');
            $booking->setTransfer($transfer);
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking, array(
                'action' => $this->generateUrl('add_booking'),
                'method' => 'POST',
            ), $em);
            $place = $transfer->getTargetPlace();

            $booking_form->add('airportname', ChoiceType::class,
                ['choices' => $em->getRepository('AppBundle:Airport')->findAll(),
                    'choices_as_values' => true,
                    'choice_label' => 'NameLocale',
                    'choice_value' => 'Id',
                    'choice_attr' => function(Airport $airport, $key, $price){
                        return ['data-airportname'=> $airport->machineName()];
                            },
                    'choice_name' => 'machineName',
                    'attr'=>['disabled'=>true]

                ]);

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();


            return $this->render('AppBundle:Front:bookingPlace.html.twig', [
                    'booking_form'=>$booking_form->createView(),
                    'locale'=>$_locale,
                    'content'=>$content[0],
                    'socialNetworks'=>$socialNetworks,
                    'hashtags'=>$hashtags,
                    'transfer'=>$transfer,
                    'place'=>$place,
                    'places'=>$places,
                    'config'=>$config,
                    'testimonials'=>$testimonials,
                    'suggestedPlaces'=>$suggestedPlaces
                    ]);
        }
        else
            throw new NotFoundHttpException();
    }


    /**
     * @Route("/airport/{_id}", defaults={"_locale": "en"}, requirements={"_id":"\d+"})
     * @Route("/{_locale}/airport/{_id}/{_name}", requirements={"_id":"\d+"}, defaults={"_locale": "en"},
     * name="booking_airport")
     */
    public function bookingAirportAction(Request $request, $_locale, $_id, $_name)
    {
        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        $airportTransfer = $em->getRepository('AppBundle:AirportTransfer')->find($_id);

        $nameLocale = Utils::slugify($airportTransfer->getNameLocale());
        $nameRequest = $_name;

        if ($nameRequest != $nameLocale){
            return $this->redirectToRoute('booking_airport',array(
                '_locale'=>$_locale,
                '_id'=> $_id,
                '_name' => $nameLocale
            ), 301);
        }

        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
        $config = [];;
        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }

        if ($airportTransfer)
        {

            $booking = new Booking();
            $booking->setServiceType('AirportTransfer');
            $booking->setAirportTransfer($airportTransfer);
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking, array(
                'action' => $this->generateUrl('add_booking'),
                'method' => 'POST',
            ), $em);
            $airport = $airportTransfer->getTargetAirport();

            $booking_form->add('airportname', ChoiceType::class,
                ['choices' => $em->getRepository('AppBundle:Airport')->findAll(),
                    'choices_as_values' => true,
                    'choice_label' => 'NameLocale',
                    'choice_value' => 'Id',
                    'choice_attr' => function(Airport $airport, $key, $price){
                        return ['data-airportname'=> $airport->machineName()];
                    },
                    'choice_name' => 'machineName'

                ]);

            $booking_form->add('targetPlace', ChoiceType::class,
                ['choices' => $em->getRepository('AppBundle:Place')->findAll(),
                    'choices_as_values' => true,
                    'choice_label' => 'NameLocale',
                    'choice_value' => 'Id',
                    'choice_attr' => function(Place $place, $key, $price){
                        return ['data-targetPlace'=> $place->getName(),
                                'data-airportPricesJSON'=>$place->getJSONAirportsPrices()];
                    },
                    'choice_name' => 'getName'

                ]);

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();


            return $this->render('AppBundle:Front:bookingAirTransfer.html.twig', [
                'booking_form'=>$booking_form->createView(),
                'locale'=>$_locale,
                'content'=>$content[0],
                'socialNetworks'=>$socialNetworks,
                'hashtags'=>$hashtags,
                'transfer'=>$airportTransfer,
                'airport'=>$airport,
                'places'=>$places,
                'config'=>$config
            ]);
        }
        else
            throw new NotFoundHttpException();
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

        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('AppBundle:Booking')->findOneBy(['token'=>$_token]);
        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();

        $config = [];

        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }


        if ($purchase) {

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();

            $service = null;
            if($purchase->getServiceType()=='Experience')
            {
                $service = $em->getRepository('AppBundle:Experience')->find($purchase->getExperience());
            }

            if($purchase->getServiceType()=='Transfer')
            {
                $service = $em->getRepository('AppBundle:Transfer')->find($purchase->getTransfer());
            }
            if($purchase->getServiceType()=='AirportTransfer')
            {
                $service = $em->getRepository('AppBundle:AirportTransfer')->find($purchase->getAirportTransfer());
            }
            if($purchase->getPlace())
                $place = $em->getRepository('AppBundle:Place')->find($purchase->getPlace());
            else $place = null;
            $places = $em->getRepository('AppBundle:Place')->findAll();

            $experience = null;
            if($purchase->isExperience())
                $experience = $em->getRepository("AppBundle:Experience")
                    ->find($purchase->getExperience());


            if($_paypalCallback == 'success' OR $purchase->getNumpeople()<=5){

                $purchase->setConfirmed(true);

                if (isset($_GET['tx']))
                    $purchase->setIdpaypal($_GET['tx']);

                $em->persist($purchase);
                $em->flush();
            }



            $paypalSuccessFormHtml = "";
            if($_paypalCallback == 'success') {
                if (isset($_GET['tx'])) {
                    $paypalTransactionID = $_GET['tx'];
                    /*echo "-->";
                    echo $_POST['item_number']." ID del producto\n";
                    echo $paypalTransactionID;
                    echo $_POST['mc_gross']." Monto recibido Paypal\n";
                    echo $_POST['mc_currency']."  Moneda recibida de Paypal\n";
                    //echo $_POST['st']." Estado del producto Paypal\n";
                    echo "-->";*/

                    //verificacion de que el precio pagado mediante paypal coincida con el calculado
                    if($_GET['amt'] >= round($purchase->getPrice() / $config['tasa.usd'],2,PHP_ROUND_HALF_DOWN))
                    {
                        $purchase->setConfirmed(true);
                        $em->persist($purchase);
                        $em->flush();

                    }

                    $paypalSuccessFormHtml = $this->render('AppBundle:Front:completePaypalTransfer.html.twig', [
                        'paypalTransactionID' => $paypalTransactionID,
                        'paypalIdentificationToken' => $config['paypal.token'],
                        'paypalUrl' => $config['paypal.url']
                    ]);
                }
            }

            $this->sendEmailNotifications($purchase);

            return $this->render('AppBundle:Front:purchaseDetails.html.twig', [
                'locale'=>$_locale,
                'content'=>$content[0],
                'socialNetworks'=>$socialNetworks,
                'hashtags'=>$hashtags,
                'place'=>$place,
                'experience' => $experience,
                'purchase'=>$purchase,
                'places'=>$places,
                'paypalCallback'=>$_paypalCallback,
                'config'=>$config,
                'paypalSuccessFormHtml' => $paypalSuccessFormHtml
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

        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
        $config = [];;
        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }

        if($purchase)
        {
            $_place = $em->getRepository('AppBundle:Place')->find($purchase->getPlace());
            $product_name = Utils::buildProductName($purchase, $_place);

            $account_email = $config['paypal.email'];

            return $this->render('AppBundle:Front:makePaypalTransfer.html.twig', [
                'account_email'=>$account_email,
                'product_name'=>$product_name,
                '_token'=>$_token,
                '_locale'=>$_locale,
                'product_price'=>$purchase->getPrice(),
                'paypalUrl' => $config['paypal.url']
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
        elseif($booking->getAirportTransfer())
            $place = $booking->getTargetPlace();
        else $place = null;


        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
        $config = [];;
        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }

        $content = $em->getRepository('AppBundle:SiteContent')->findAll();
        $senderEmail = $content[0]->getContactemail();
        $address = $content[0]->getContactaddressLocale();
        $telephone = $content[0]->getContacttelephone();

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setReplyTo($senderEmail)
            ->setTo($booking->getEmail())
            ->setFrom("taxidriverscuba-noreply@taxidriverscuba.com");

            if($booking->isExperience()){
                $experience = $em->getRepository("AppBundle:Experience")
                    ->find($booking->getExperience());
                $message->setBody(
                    $this->renderView(
                        'AppBundle:Email:clientExperienceNotification.html.twig',
                        [
                            'subject'=>$subject,
                            '_locale'=>$booking->getBookingLocale(),
                            'address' => $address,
                            'telephone'=> $telephone,
                            'experience'=>$experience,
                            'booking'=>$booking,
                            'config' => $config,
                        ]
                    ),
                    'text/html'
                );
            }
            else
                $message->setBody(
                    $this->renderView(
                        'AppBundle:Email:clientNotification.html.twig',
                        [
                            'subject'=>$subject,
                            '_locale'=>$booking->getBookingLocale(),
                            'address' => $address,
                            'telephone'=> $telephone,
                            'place'=>$place,
                            'booking'=>$booking,
                            'config' => $config,
                        ]
                    ),
                    'text/html'
                );


        $this->get('mailer')->send($message);

        $experience = null;
        if($booking->isExperience())
            $experience = $em->getRepository("AppBundle:Experience")
                ->find($booking->getExperience());

        $message = \Swift_Message::newInstance();

        if($booking->getIdpaypal())
            $message->setSubject($subject. " (".$booking->getId().") [PAGADO POR PAYPAL]");
        else
            $message->setSubject($subject. " (".$booking->getId().")");

            $message->setTo($senderEmail)
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
                        'experience'=>$experience,
                        'booking'=>$booking,
                        'config' => $config,
                    ]
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
    }
    
}
