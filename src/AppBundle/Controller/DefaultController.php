<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\ContactMsgs;
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

            $featureImage = '';
            if(count($blogEntries)>0)
                $featureImage = $blogEntries[0]->getWebPath();

            $message = new ContactMsgs();
            $messageForm = $this->createForm('AppBundle\Form\ContactMsgsType',$message);
            $messageForm->handleRequest($request);
            $sended_email = false;
            if ($messageForm->isSubmitted() && $messageForm->isValid()) {
                $em->persist($message);
                $em->flush();
                $sended_email = true;

                $senderEmail = $content[0]->getContactemail();
                $address = $content[0]->getContactaddressLocale();
                $telephone = $content[0]->getContacttelephone();
                $subject = "Nuevo contacto a traves de la Web";
                $email = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setReplyTo($senderEmail)
                    ->setTo($senderEmail)
                    ->setFrom("noreply@taxidriverscuba.com")
                    ->setBody(
                        $this->renderView(
                            'AppBundle:Email:contactNotification.html.twig',
                            [
                                'subject'=>$subject,
                                '_locale'=>$_locale,
                                'address' => $address,
                                'telephone'=> $telephone,
                                'message'=>$message,
                            ]
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($email);
            }


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
            'messageForm' => $messageForm->createView(),
            'sended_email'=>$sended_email
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
        $entriesNumber = 4;
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

    /**
     * @Route("/{_locale}/blog/{_tag}/{_page}", defaults={"_locale": "en", "_page":1}, requirements={
     * "_locale": "en|es|fr",
     * "_page":"\d+",
     * }, name="tag_posts")
     */
    public function tagPostsAction(Request $request, $_locale='en', $_page=1, $_tag){
        $em = $this->getDoctrine()->getManager();

        $tag = null;;
        if($_locale == 'es')
            $tag = $em->getRepository("AppBundle:Tag")->findBy(['tag'=>$_tag]);

        else
            $tag = $em->getRepository("AppBundle:Tag")->findBy(['tagEn'=>$_tag]);

        if(!$tag)
            throw new NotFoundHttpException();

        $tags_id = [];
        foreach ($tag as $item)
            $tags_id[] = $item->getId();

//TODO: write query to get blogentries from tag's ids
        $blogEntries = $em->getRepository("AppBundle:Blogentrie")->findBy(['tags'=>$tags_id]);


        if ($blogEntries) {

            $content = $em->getRepository('AppBundle:SiteContent')->findAll();
            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            $places = $em->getRepository('AppBundle:Place')->findAll();
            $tags = $em->getRepository('AppBundle:Tag')->findAll();

            $countEntries = count($blogEntries);
            $featureImage = "//";

            return $this->render('AppBundle:Front:blog.html.twig',
                ['locale'=>$_locale,
                    'content'=>$content[0],
                    'hashtags'=>$hashtags,
                    'places'=>$places,
                    'featureImage'=>$featureImage,
                    'socialNetworks'=>$socialNetworks,
                    'tags'=>$tags,
                    'entriesNumber'=>4,
                    'blogEntries'=>$blogEntries,
                    'countEntries' => $countEntries,
                    'pageNumber' => $_page,
                    'currentTag' =>$tag
                ]);
        }
        else
            throw new \Exception("No hay entradas en el blog");

    }

}
