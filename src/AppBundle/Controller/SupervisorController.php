<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Place;
use AppBundle\Entity\Transfer;
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

    /**
     * @Route("/dash/migration/")
     */
    public function migrationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $value = 0.88;

        foreach (['AppBundle:Experience', 'AppBundle:Experience', 'AppBundle:Experience'] as $type) {
            $items = $em->getRepository($type)->findAll();
            foreach ($items as $item){
                $newPrice = $item->getBasePrice() * $value;
                dump([$type, $item->getName(), $item->getBasePrice(), $newPrice]);
                $item->setBasePrice($newPrice);
                $em->persist($item);
            }
        }

        $places = $em->getRepository('AppBundle:Place')->findAll();
        foreach ($places as $item){
            foreach ($item->getAirportsPrices() as $_name => $_value){
                $newPrice = $_value * $value;
                dump([$_name, $item->getName(), $_value, $newPrice]);
                $item->__set($_name, $newPrice);
                $em->persist($item);
            }

        }



        $em->flush();

        return new Response('ok');
    }

}
