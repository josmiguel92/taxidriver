<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ConfigValue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Configvalue controller.
 *
 * @Route("dash/config/values")
 */
class ConfigValueController extends Controller
{


    /**
     * Creates a new configValue entity.
     *
     * @Route("/new", name="dash_config_values_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $configValue = new Configvalue();
        $form = $this->createForm('AppBundle\Form\ConfigValueType', $configValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configValue);
            $em->flush();

            return $this->redirectToRoute('dash_config_values_show', array('id' => $configValue->getId()));
        }

        return $this->render('configvalue/new.html.twig', array(
            'configValue' => $configValue,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing configValue entity.
     *
     * @Route("/{id}/edit", name="dash_config_values_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConfigValue $configValue)
    {
        $name = $configValue->getName();
        $editForm = $this->createForm('AppBundle\Form\ConfigValueType', $configValue);
        $editForm->handleRequest($request);
        $configValue->setName($name);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dash_config');
        }

        return $this->render('AppBundle:Dash:configvalue/edit.html.twig', array(
            'pagename'=>'config',
            'configValue' => $configValue,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a configValue entity.
     *
     * @Route("/{id}", name="dash_config_values_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ConfigValue $configValue)
    {
        $form = $this->createDeleteForm($configValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configValue);
            $em->flush();
        }

        return $this->redirectToRoute('dash_config_values_index');
    }

    /**
     * Creates a form to delete a configValue entity.
     *
     * @param ConfigValue $configValue The configValue entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigValue $configValue)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_config_values_delete', array('id' => $configValue->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
