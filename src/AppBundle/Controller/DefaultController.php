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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    
    /**
     * @Route("/{_locale}", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="home")
     */
    public function indexAction(Request $request, $_locale)
    {
        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:SiteContent')->findAll();

        if ($content) {
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            $places = $em->getRepository('AppBundle:Place')->findAll();
            $infographys = $em->getRepository('AppBundle:InfographItem')->findAll();
            $blogEntries = $em->getRepository('AppBundle:Blogentrie')->findBlogEntries(0, 4);
            $testimonials = $em->getRepository('AppBundle:Testimony')->findAll();
            $drivers = $em->getRepository('AppBundle:Drivers')->findAll();

            $featureImage = $blogEntries[0]->getWebPath();

            return $this->render('AppBundle:Front:index.html.twig',
            ['locale'=>$_locale,
            'content'=>$content[0],
            'featureImage'=>$featureImage,
            'blogEntries'=>$blogEntries,
            'socialNetworks'=>$socialNetworks,
            'hashtags'=>$hashtags,
            'places'=>$places,
            'infographys'=>$infographys,
            'testimonials'=>$testimonials,
            'drivers'=>$drivers,
            ]);
        }
        else throw new \Exception("No hay datos en la DB",500 );
    }

    /**
     * @Route("/blog")
     * @Route("/{_locale}/blog/{_page}", defaults={"_locale": "en", "_page":1}, requirements={
     * "_locale": "en|es|fr",
     * "_page":"\d+"
     * }, name="blog")
     */
    public function blogAction(Request $request, $_locale='en', $_page=1)
    {
        $entriesNumber = 2;
        $startEntry = $entriesNumber*($_page-1);


        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $blogEntries = $em->getRepository('AppBundle:Blogentrie')->findBlogEntries($startEntry, $entriesNumber);

        if ($blogEntries) {

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            $places = $em->getRepository('AppBundle:Place')->findAll();
            $tags = $em->getRepository('AppBundle:Tag')->findAll();
            $blogEntries = $em->getRepository('AppBundle:Blogentrie')->findBlogEntries($startEntry, $entriesNumber);

            $countEntries = $em->getRepository('AppBundle:Blogentrie')->findBlogEntriesCount();
            $featureImage = "//";

            return $this->render('AppBundle:Front:blog.html.twig',
            ['locale'=>$_locale,
            'content'=>$content[0],
            'hashtags'=>$hashtags,
            'places'=>$places,
            'featureImage'=>$featureImage,
            'socialNetworks'=>$socialNetworks,
            'tags'=>$tags,
            'entriesNumber'=>$entriesNumber,
            'blogEntries'=>$blogEntries,
            'countEntries' => $countEntries,
                'pageNumber' => $_page,
                ]);
        }
        else
            throw new Exception("No hay entradas en el blog");
    }

    /**
     * @Route("/{_locale}/blog/{_id}/{_name}", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|es|fr",
     * "_id":"\d+",
     * }, name="blogEntry")
     */
    public function blogEntryAction(Request $request, $_locale="en", $_id)
    {

        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $blogEntry = $em->getRepository('AppBundle:Blogentrie')->find($_id);

        if ($blogEntry)
        {
            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            $places = $em->getRepository('AppBundle:Place')->findAll();
            $tags = $em->getRepository('AppBundle:Tag')->findAll();

            return $this->render('AppBundle:Front:blogEntry.html.twig',
            ['locale'=>$_locale,
            'content'=>$content[0],
            'hashtags'=>$hashtags,
            'places'=>$places,
            'socialNetworks'=>$socialNetworks,
            'tags'=>$tags,
            'blogEntry'=>$blogEntry]);
        }
        else{
            throw new NotFoundHttpException();
        }
    }

}
