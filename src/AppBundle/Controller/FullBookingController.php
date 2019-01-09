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
    public function indexAction($page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $bookings = $em->getRepository('AppBundle:Booking')->listBookings($page);

        return $this->render('@App/Dash/booking/index.html.twig', array(
            'bookings' => $bookings,
            'prev_page' => $page-1,
            'next_page' => $page+1
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

/*
        return  $this->render('AppBundle:Dash/booking:pdf_export.html.twig', array(
            'booking' => $booking,
            'dataimage'=>$dataimage,
        ));

*/
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

}
