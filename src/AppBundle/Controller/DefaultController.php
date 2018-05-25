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
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class DefaultController extends Controller
{
    
    /**
     * @Route("/{_locale}", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="homepage")
     */
    public function indexAction(Request $request, $_locale)
    {
        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:SiteContent')->findAll();
        $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
        $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
        if(count($content)>0)
            return $this->render('AppBundle:Front:index.html.twig', ['content'=>$content[0],
            'socialNetworks'=>$socialNetworks,
            'hashtags'=>$hashtags]);
        else throw new Exception("No hay configuracion disponible");
    }

        /**
         * @Route("/blog")
         * @Route("/{_locale}/blog", defaults={"_locale": "en"}, requirements={
         * "_locale": "en|es|fr"
         * }, name="homepage")
         */
        public function blogAction(Request $request, $_locale="en")
        {
            Utils::setRequestLocaleLang($_locale);
            $em = $this->getDoctrine()->getManager();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();

            return $this->render('AppBundle:Front:blog.html.twig',
            ['hashtags'=>$hashtags,
            'socialNetworks'=>$socialNetworks,]);
        }

}
