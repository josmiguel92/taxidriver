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
use AppBundle\Entity\Booking;

/**
 * Cartel controller.
 *
 * @Route("/booking")
 */
class BookingController extends Controller
{
    
    /**
     * @Route("/add", name="add_booking")
     */
    public function bookingAction(Request $request)
    {
        $booking = new Booking();
        $booking_form = $this->createForm('AppBundle\Form\BookingType',$booking);

        $booking_form->handleRequest($request);

        if ($booking_form->isSubmitted() && $booking_form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();
        }

        //$em = $this->getDoctrine()->getManager();

        return $this->render('AppBundle:Front:booking.html.twig', [
                'booking_form'=>$booking_form->createView(),
                ]);
    }

}
