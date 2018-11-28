<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Experience;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Booking;
use AppBundle\Utils\Utils;

/**
 * Experience controller.
 *
 */
class ExperienceController extends Controller
{
    /**
     * Lists all experience entities.
     *
     * @Route("/dash/experience/", name="dash_experience_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $experiences = $em->getRepository('AppBundle:Experience')->findAll();

        return $this->render('@App/Dash/services/experience/index.html.twig', array(
            'experiences' => $experiences,
        ));
    }

    /**
     * Creates a new experience entity.
     *
     * @Route("/dash/experience/new", name="dash_experience_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $experience = new Experience();
        $form = $this->createForm('AppBundle\Form\ExperienceType', $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($experience);
            $em->flush();

            return $this->redirectToRoute('dash_experience_index');
        }

        return $this->render('@App/Dash/services/experience/new.html.twig', array(
            'experience' => $experience,
            'edit_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a experience entity.
     *
     * @Route("/dash/experience/{id}", name="dash_experience_show")
     * @Method("GET")
     */
    public function showAction(Experience $experience)
    {
        $deleteForm = $this->createDeleteForm($experience);

        return $this->render('@App/Dash/services/experience/show.html.twig', array(
            'experience' => $experience,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing experience entity.
     *
     * @Route("/dash/experience/{id}/edit", name="dash_experience_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Experience $experience)
    {
        $deleteForm = $this->createDeleteForm($experience);
        $editForm = $this->createForm('AppBundle\Form\ExperienceType', $experience);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dash_experience_edit', array('id' => $experience->getId()));
        }

        return $this->render('@App/Dash/services/experience/edit.html.twig', array(
            'experience' => $experience,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a experience entity.
     *
     * @Route("/dash/experience/{id}", name="dash_experience_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Experience $experience)
    {
        $form = $this->createDeleteForm($experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($experience);
            $em->flush();
        }

        return $this->redirectToRoute('dash_experience_index');
    }

    /**
     * Creates a form to delete a experience entity.
     *
     * @param Experience $experience The experience entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Experience $experience)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_experience_delete', array('id' => $experience->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Show a experience entity.
     *
     * @Route("/{_locale}/experience/{id}/{_name}", name="show_experience", defaults={"_locale": "en"}, requirements={"_id":"\d+"})
     * @Method("GET")
     */
    public function showExperienceAction(Experience $experience, $_locale)
    {
        Utils::setRequestLocaleLang($_locale);
        if ($experience) {

            $em = $this->getDoctrine()->getManager();
            $content = $em->getRepository('AppBundle:SiteContent')->findAll();

            if ($content) {
                $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
                $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
                $places = $em->getRepository('AppBundle:Place')->findAllSorted();
                $infographys = $em->getRepository('AppBundle:InfographItem')->findAll();
                $testimonials = $em->getRepository('AppBundle:Testimony')->findAll();

                $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
                $config = [];

                foreach ($_config as $item){
                    $config[$item->getName()]=$item->getValue();
                }

                $booking = new Booking();
                $form = $this->createForm('AppBundle\Form\BookingType', $booking,
                    ['action' => $this->generateUrl('add_booking')]);


                return $this->render('AppBundle:Front:bookingExperience.html.twig', array(
                    'content' => $content[0],
                    'experience' => $experience,
                    'booking_form' => $form->createView(),
                    'locale' => $_locale,
                    'socialNetworks'=>$socialNetworks,
                    'hashtags'=>$hashtags,
                    'places'=>$places,
                    'infographys'=>$infographys,
                    'testimonials'=>$testimonials,
                    'config' => $config,
                ));
            }
        }
        else{
            throw new NotFoundHttpException();
        }

    }
}
