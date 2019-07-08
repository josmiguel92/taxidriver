<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
include __DIR__."/../Utils/phpqrcode.php";
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Booking controller.
 *
 * @Route("dash/bookings")
 */
class FullBookingController extends Controller
{
    /**
     * Lists all booking entities.
     *
     * @Route("/page/{page}", name="dash_bookings_index", requirements={"page":"\d+"})
     * @Method("GET")
     */
    public function indexAction($page = 1, Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $all_booking = $request->get('all_booking');
        $minDate = $request->get('minDate');
        $maxDate = $request->get('maxDate');

        if($all_booking=='yes')
            $bookings = $em->getRepository('AppBundle:Booking')->listFutureBookings($page);
        else
        {
            if($request->get('filterByDateSubmit'))
            {

                $bookings = $em->getRepository('AppBundle:Booking')->listBetweenDates($minDate, $maxDate, $page = 1);
            }
            else $bookings = $em->getRepository('AppBundle:Booking')->listBookings($page);
        }
        

        return $this->render('@App/Dash/booking/index.html.twig', array(
            'bookings' => $bookings,
            'prev_page' => $page-1,
            'next_page' => $page+1,
            'all_booking' => $all_booking
        ));
    }

    /**
     * Creates a new booking entity.
     *
     * @Route("/new", name="dash_bookings_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm('AppBundle\Form\FullBookingType', $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('dash_bookings_show', array('id' => $booking->getId()));
        }

        return $this->render('AppBundle:Dash/booking:new.html.twig', array(
            'booking' => $booking,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing booking entity.
     *
     * @Route("/{id}/edit", name="dash_bookings_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Booking $booking)
    {
        $deleteForm = $this->createDeleteForm($booking);
        $editForm = $this->createForm('AppBundle\Form\FullBookingType', $booking);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dash_bookings_edit', array('id' => $booking->getId()));
        }

        return $this->render('AppBundle:Dash/booking:edit.html.twig', array(
            'booking' => $booking,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a booking entity.
     *
     * @Route("/{id}", name="dash_bookings_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Booking $booking)
    {
        $form = $this->createDeleteForm($booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($booking);
            $em->flush();
        }

        return $this->redirectToRoute('dash_bookings_index');
    }

    /**
     * Creates a form to delete a booking entity.
     *
     * @param Booking $booking The booking entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Booking $booking)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_bookings_delete', array('id' => $booking->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Generate QR code from a booking entity.
     *
     * @Route("/qrcode/{id}", name="dash_bookings_qr")
     * @Method("GET")
     */
    public function qrcodeAction(Booking $booking)
    {
        $url = $this->generateUrl('purchase_details',['_token'=>$booking->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        \QRcode::png($url);
        exit();
    }

    /**
     * Generate PDF from a booking entity.
     *
     * @Route("/export/{id}", name="dash_bookings_pdf_export")
     * @Method("GET")
     */
    public function exportAction(Booking $booking)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->set_option('dpi', 120);



        $url = $this->generateUrl('purchase_details',['_token'=>$booking->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        //;
        $dataimage = \QRcode::_png($url);

        $dompdf->loadHtml(
            $this->renderView('AppBundle:Dash/booking:pdf_export.html.twig', array(
                'booking' => $booking,
                'dataimage'=>$dataimage,
            ))
        );


        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        $filename = 'booking'.$booking->getId().'_'.$booking->getPickuptimeFormated().'.pdf';
        // Output the generated PDF to Browser
        $dompdf->stream($filename);


    }

    /**
     * Generate PDF from a booking entity.
     *
     * @Route("/multiple_export/{filter}", name="dash_bookings_multiple_pdf_export")
     * @Method("GET")
     */
    public function multipleExportAction($filter = 'week')
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->set_option('dpi', 120);

        $em = $this->getDoctrine()->getManager();

        /** @var Booking $bookings */
        $bookings = $em->getRepository("AppBundle:Booking")
            ->createQueryBuilder("b")
            ->where("b.pickuptime > :start_day");

        if($filter == 'week'){
            $bookings->andWhere("b.pickuptime < :nextweek")
                ->setParameter("nextweek", new \DateTime("today + 1 week"));
        }
        $bookings = $bookings
            ->setParameter("start_day", new \DateTime('today'))
            ->orderBy("b.pickuptime", "ASC")
            ->getQuery()->getResult();

        if($filter == 'week'){
            $dompdf->loadHtml(
                $this->renderView('AppBundle:Dash/booking:multiple_pdf_export.html.twig', array(
                    'bookings' => $bookings,
                ))
            );

            $range_name = date('m.d.Y').'semanal';
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            $filename = 'bookings_'.$range_name.'.pdf';
            // Output the generated PDF to Browser
            $dompdf->stream($filename);

        }
        else{
            return $this->render('AppBundle:Dash/booking:multiple_pdf_export.html.twig', array(
                    'bookings' => $bookings,
                ));
        }


    }


    /**
     * Finds and displays a booking entity.
     *
     * @Route("/{id}", name="dash_bookings_show")
     * @Method("GET")
     */
    public function showAction(Booking $booking)
    {
        $deleteForm = $this->createDeleteForm($booking);

        return $this->render('AppBundle:Dash/booking:show.html.twig', array(
            'booking' => $booking,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Finds and displays events interval
     *
     * @Route("/json/calendar_events.json", name="booking_calendar_events")
     * @Method("GET")
     */
    public function calendarEventsAction(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $em = $this->getDoctrine()->getManager();

        if($startDateTime = new \DateTime($start) and $endDateTime = new \DateTime($end))
        {
            $bookings = $em->getRepository('AppBundle:Booking')->listBetweenDates($start, $end, $page = 1, 100);
            $result = [];
            foreach ($bookings as $item) {
                $result[] = [
                    'url' => $this->generateUrl('dash_bookings_show', ['id' => $item->getId()]),
                    'title' => $item->getToken(),
                    'start' => $item->getPickuptimeFormated('Y-m-d'),
                    'color' => $item->getEventColor(),
                  //  'description' => $item->getInternalDescription()
                ];
            }
            return $this->json($result);
        }

        return $this->json([]);
    }

}
