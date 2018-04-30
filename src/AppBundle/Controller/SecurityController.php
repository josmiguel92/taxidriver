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

class SecurityController extends Controller
{
    
    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Dash:loginform.html.twig', [
            'last_username' => $lastUsername,]);
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        //este controlador no se ejecutar'a
    }
}
