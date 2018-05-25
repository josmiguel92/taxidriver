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

class DefaultController extends Controller
{
    
    /**
     * @Route("/{_locale}", defaults={"_locale": "es"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="homepage")
     */
    public function indexAction(Request $request, $_locale)
    {
        return $this->render('AppBundle::default.html.twig', []);
    }

}
