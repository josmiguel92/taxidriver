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

class SupervisorController extends Controller
{
    
    /**
     * @Route("/dash/supervisor", name="supervisor")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle::default.html.twig', []);
    }

    /**
     * @Route("/dash/boletin/{token}", name="boletin")
     */
    public function boletinAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository("AppBundle:Booking")->findOneBy(['token'=>$token]);
        $place = $em->getRepository("AppBundle:Place")->find($booking->getPlace());
        $places_collection = $em->getRepository("AppBundle:Place")->findBy(['id'=>$booking->getPlacesCollection()]);
        $ownroute = [];

                return $this->render('AppBundle:Email:booking-email.html.twig', [
            'subject'=>'ASUNTO',
            'email' => 'user@gmail.com',
            '_locale'=>'en',
            'address' => 'Calle O, La Habana, Cuba',
            'telephone'=> '+53 5 5864523',
            'token'=>$token,
            'place'=>$place,
            'places_collection'=>$places_collection,
            'ownroute'=>$ownroute,
            'booking'=>$booking,
        ]);
    }

}
