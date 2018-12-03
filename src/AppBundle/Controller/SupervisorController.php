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
        $experiences = $em->getRepository('AppBundle:Experience')->findAll();

        $havana = new Place();
        $havana->setName('La Habana')->setNameEn('Havana');
        $havana->setPath('d3c2a2b9ad.jpeg');
        $em->persist($havana);

        foreach ($experiences as $exp){
            $exp->setNameEs($exp->getName());

            if($exp->getId()==3)
            {
                    $exp->setBasePrice(120);
                    $exp->setTargetPlace($havana);
            }
            if($exp->getId()==5)
            {//playa larga
                $exp->setBasePrice(153);
                $exp->setTargetPlace($em->getRepository('AppBundle:Place')->find(10));
            }
            if($exp->getId()==6 OR $exp->getId()==4)
            {
                $exp->setTargetPlace($havana);
            }

            $em->persist($exp);
        }

        $places = $em->getRepository('AppBundle:Place')->findAll();

        foreach ($places as $place)
        {
            $transfer = new Transfer();
            $transfer->setTargetPlace($place);
            $transfer->setName($place->getNameEn())
                     ->setNameEs($place->getName());
            $transfer->setPath($place->getPath());

            $em->persist($transfer);
        }

        $em->flush();

        return new Response('ok');
    }

}
