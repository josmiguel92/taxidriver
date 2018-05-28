<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Place;
use AppBundle\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;
use AppBundle\Entity\Booking;

/**
 * Booking controller.
 * @Route("/booking", defaults={"_locale": "en"})
 * @Route("/{_locale}/booking", defaults={"_locale": "en"}, requirements={
 * "_locale": "en|es|fr"})
 */
class BookingController extends Controller
{
    
    /**
     * @Route("/", name="add_booking")
     */
    public function bookingAction(Request $request, $_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository('AppBundle:Place')->findAll();

        if ($places) {

            $booking = new Booking();
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking);
            $booking_form->handleRequest($request);

            if ($booking_form->isSubmitted() && $booking_form->isValid()) {
                $em->persist($booking);
                $em->flush();
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
     * @Route("/{_id}", requirements={"_id":"\d+"})
     * @Route("/{_id}/{_name}", requirements={"_id":"\d+"},
     * name="booking_place")
     */
    public function bookingPlaceAction(Request $request, $_locale, $_id)
    {

        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository('AppBundle:Place')->find($_id);

        if ($place)
        {

            $booking = new Booking();
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking);

            $booking_form->handleRequest($request);
            if ($booking_form->isSubmitted() && $booking_form->isValid()) {
                $em->persist($booking);
                $em->flush();
            }

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
                    ]);
        }
        else
            throw new NotFoundHttpException();
    }

    /**
     * @Route("/own-tour", name="bookingOwnTour")
     */
    public function bookingOwnTourAction(Request $request, $_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:SiteContent')->findAll();

        if ($content) {

            $booking = new Booking();
            $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking);
            $booking_form->handleRequest($request);

            if ($booking_form->isSubmitted() && $booking_form->isValid()) {
                $em->persist($booking);
                $em->flush();
            }


            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();

            return $this->render('AppBundle:Front:bookingOwnTour.html.twig', [
                    'booking_form'=>$booking_form->createView(),
                    'locale'=>$_locale,
                    'content'=>$content[0],
                    'socialNetworks'=>$socialNetworks,
                    'hashtags'=>$hashtags,
                    ]);
        }
        else
            throw new Exception("No hay entradas de lugares");
    }
}
