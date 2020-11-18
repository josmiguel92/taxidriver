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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;
use AppBundle\Entity\Booking;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Utils\TelephoneNumber;

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

        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
        $config = [];;
        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }


        $booking = new Booking(['USD'=>$config['tasa.usd'], 'CUC'=>$config['tasa.cuc'], 'EUR'=>1]);
        $booking->setBookingSource();
        $booking->setBookingLanguage($_locale);
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

                //Si se ejecuta env. PROD, validar catpcha... y si no es success, regresar!
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
                            return $this->redirect($_SERVER['HTTP_REFERER']);

                }

                $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
                $config = [];
                foreach ($_config as $item){
                    $config[$item->getName()]=$item->getValue();
                }


                //validacion para enviar correo a lester o no.
                if($booking->getNumpeople()<=5)
                    if($_price = $booking->calculateSimplePrice($config['price.increment']))
                    {
                        $booking->setPrice($_price, $base_prices=true);

                        //en caso de que no se pague via trekkesoft todas lass reservas
                        if($config['price.increment'] == 'null')
                            $booking->setAccepted(true);
                    }

                $em->persist($booking);
                $em->flush();

                $this->sendEmailNotifications($booking);

                return $this->redirectToRoute('purchase_details', [
                    '_token'=>$booking->getToken(),
                    '_locale'=>$_locale
                ]);

            }

            $this->addFlash(
                'notice',
                'Error! >> danger >> ti-save'
            );
            return $this->redirect($_SERVER['HTTP_REFERER']);
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
           return $this->redirectToRoute('redirection_routing', ['name'=>$_name]);

        }

        $testimonials = $em->getRepository('AppBundle:Testimony')
                            ->findRandomByTransferOrPlace($transfer->getId(),$transfer->getTargetPlace()->getId());

        $suggestedPlaces = $em->getRepository('AppBundle:Transfer')->findRandomByImportant($transfer->getId());
        $nameLocale = Utils::slugify($transfer->getNameLocale());
        $nameRequest = $_name;


        if ($nameRequest != $nameLocale){
            return $this->redirectToRoute('booking_place',array(
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

        if ($transfer)
        {

            $booking = new Booking(['USD'=>$config['tasa.usd'], 'CUC'=>$config['tasa.cuc'], 'EUR'=>1]);
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

        $testimonials = $em->getRepository('AppBundle:Testimony')
            ->getRandomTestimony(3);

        $suggestedPlaces = $em->getRepository('AppBundle:Transfer')->findRandomByImportantAll();

        $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
        $config = [];;
        foreach ($_config as $item){
            $config[$item->getName()]=$item->getValue();
        }

        if ($airportTransfer)
        {

            $booking = new Booking(['USD'=>$config['tasa.usd'], 'CUC'=>$config['tasa.cuc'], 'EUR'=>1]);
            $booking->setServiceType('AirportTransfer');
            $booking->setAirportTransfer($airportTransfer);
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking, array(
                'action' => $this->generateUrl('add_booking'),
                'method' => 'POST',
            ), $em);
            $airport = $airportTransfer->getTargetAirport();

            $booking_form->add('airportname', null,
               /* ['choices' => $em->getRepository('AppBundle:Airport')->findAll(),
                    'choices_as_values' => true,
                    'choice_label' => 'NameLocale',
                    'choice_value' => 'Id',
                    'choice_attr' => function(Airport $airport, $key, $price){
                        return ['data-airportname'=> $airport->machineName()];
                    },
                    'choice_name' => 'machineName'

                ]
               */
               ['attr'=>['value'=>$airportTransfer->getTargetAirport()->getId(  )]]);

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
                'config'=>$config,
                'testimonials' => $testimonials,
                'suggestedPlaces'=>$suggestedPlaces
            ]);
        }
        else
            throw new NotFoundHttpException();
    }

    /**
     * @Route("/purchase-details/{_token}", requirements={"_token":"(TDC-)[0-9]{4}(-)[0-9a-z]{6}"})
     * @Route("/{_locale}/purchase-details/{_token}", defaults={"_locale": "en"},
     * requirements={"_locale": "en|es|fr", "_token":"(TD(C)?-)[0-9]{4}(-)[0-9a-z]{4,6}"},  name="purchase_details")
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

            //todo: duplicado
            $experience = null;
            if($purchase->isExperience())
                $experience = $em->getRepository("AppBundle:Experience")
                    ->find($purchase->getExperience());


//            if($_paypalCallback == 'success' OR $purchase->getNumpeople()<=5){
//
//                $purchase->setConfirmed(true);
//
//                if (isset($_GET['tx']))
//                    $purchase->setIdpaypal($_GET['tx']);
//
//                $em->persist($purchase);
//                $em->flush();
//            }



            $paypalSuccessFormHtml = "";
//            if($_paypalCallback == 'success') {
//                if (isset($_GET['tx'])) {
//                    $paypalTransactionID = $_GET['tx'];
//                    /*echo "-->";
//                    echo $_POST['item_number']." ID del producto\n";
//                    echo $paypalTransactionID;
//                    echo $_POST['mc_gross']." Monto recibido Paypal\n";
//                    echo $_POST['mc_currency']."  Moneda recibida de Paypal\n";
//                    //echo $_POST['st']." Estado del producto Paypal\n";
//                    echo "-->";*/
//
//                    //verificacion de que el precio pagado mediante paypal coincida con el calculado
//                    if($_GET['amt'] >= round($purchase->getPrice() / $config['tasa.usd'],2,PHP_ROUND_HALF_DOWN))
//                    {
//                        $purchase->setConfirmed(true);
//                        $em->persist($purchase);
//                        $em->flush();
//
//                    }
//
//                    $paypalSuccessFormHtml = $this->render('AppBundle:Front:completePaypalTransfer.html.twig', [
//                        'paypalTransactionID' => $paypalTransactionID,
//                        'paypalIdentificationToken' => $config['paypal.token'],
//                        'paypalUrl' => $config['paypal.url']
//                    ]);
//                }
//            }

            

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
            throw new NotFoundHttpException(
                "No existe esa referencia");
    }

    /**
    * @Route("/pay/{_token}", requirements={"_token":"[a-z0-9]*"}, name="paypal_redirection")
    **/
    public function payPalAction($_token){

        exit();//DISABLED METHOD

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

        $subject = "TaxiDriversCuba Notification ".$booking->getToken();
        $em = $this->getDoctrine()->getManager();
        
        $senderEmail = 'taxidriverscuba@gmail.com';
        $senderEmail_conf = 'reservation.taxidriverscuba@gmail.com';

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setReplyTo($senderEmail)
            ->setTo($booking->getEmail())
            ->setBcc(['josmiguel92@gmail.com', '14ndy15@gmail.com'])
            ->setFrom(['noreply2@taxidriverscuba.com'=>'TaxiDriversCuba']);
          
        $message->setBody(
                $this->renderView(
                    'AppBundle:Email:booking-email.html.twig',
                    [
                        'subject'=>$subject,
                        '_locale'=>$booking->getBookingLocale(),
                        'booking'=>$booking
                    ]
                ),
                'text/html'
            );
            

        $this->get('mailer')->send($message);


        //admin message
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
//            ->setReplyTo($senderEmail_conf)
            ->setTo($senderEmail_conf)
            ->setBcc(['josmiguel92@gmail.com', '14ndy15@gmail.com'])
            ->setFrom(['noreply2@taxidriverscuba.com'=>'TaxiDriversCuba']);

        $phone = new TelephoneNumber($booking->getTelephone());
        $message->setBody(
                $this->renderView(
                    'AppBundle:Email:bookingNotification.html.twig',
                    [
                        'subject'=>$subject,
                        '_locale'=>$booking->getBookingLocale(),
                        'booking'=>$booking,
                        'countryByPhone' => $phone->getCountry()
                    ]
                ),
                'text/html'
            );
            

        

        $this->get('mailer')->send($message);
    }


}
