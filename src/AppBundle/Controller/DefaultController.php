<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\ContactMsgs;
use AppBundle\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $posters = $em->getRepository('AppBundle:Image')->findLastPosters(1);
            $blogEntries = $em->getRepository('AppBundle:Blogentrie')->findBlogEntries(0, 0);

            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            $places = $em->getRepository('AppBundle:Place')->findAll(); //TODO: eliminar esta consulta y no pasar los places
            $infographys = $em->getRepository('AppBundle:InfographItem')->findAll();
            $testimonials = $em->getRepository('AppBundle:Testimony')->getRandomTestimony();

            $experiences = $em->getRepository('AppBundle:Experience')->findAllSorted();
            $transfers = $em->getRepository('AppBundle:Transfer')->findAllSorted();
            $airport_transfers = $em->getRepository('AppBundle:AirportTransfer')->findAllSorted();

            $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
            $config = [];

            foreach ($_config as $item){
                $config[$item->getName()]=$item->getValue();
            }

            $featureImage = '';
            if(count($posters)>0)
                $featureImage = $posters[0]->getWebPath();

            $messageForm = $this->createForm('AppBundle\Form\ContactMsgsType',
                            new ContactMsgs(),
                            array(
                                'action' => $this->generateUrl('sendMessage'),
                                'method' => 'POST'
                                )
                            );

            return $this->render('AppBundle:Front:index.html.twig',
            ['locale'=>$_locale,
            'content'=>$content[0],
            'featureImage'=>$featureImage,
            'posters'=>$posters,
            'blogEntries'=>$blogEntries,
            'socialNetworks'=>$socialNetworks,
            'hashtags'=>$hashtags,

            'transfers'=>$transfers,
            'places'=>$places,
            'experiences'=>$experiences,
            'airport_transfers' => $airport_transfers,
            'infographys'=>$infographys,
            'testimonials'=>$testimonials,
            'config' => $config,
            'messageForm' => $messageForm->createView(),

            ]);
        }
        else throw new \Exception("No hay datos en la DB", 500 );
    }


    /**
     * @Route("/{_locale}/deposit/{code}", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|es|fr",
     * "code":"\d+"
     * }, name="deposit")
     */
    public function deposit(Request $request, $code, $_locale)
    {

        $ActivityId = null;
        #40
        if ($code == 40){
            $ActivityId = 282391;
        }
        #75
        elseif ($code == 75){
            $ActivityId = 283942;
        }
        elseif ($code == 150)
            $ActivityId = 283945;

        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:SiteContent')->findAll();
        if ($content) {
            $posters = $em->getRepository('AppBundle:Image')->findLastPosters(1);
            $blogEntries = $em->getRepository('AppBundle:Blogentrie')->findBlogEntries(0, 0);

            $socialNetworks = $em->getRepository('AppBundle:Socialnetwork')->findAll();
            $hashtags = $em->getRepository('AppBundle:Hashtag')->findAll();
            $places = $em->getRepository('AppBundle:Place')->findAll(); //TODO: eliminar esta consulta y no pasar los places
            $infographys = $em->getRepository('AppBundle:InfographItem')->findAll();
            $testimonials = $em->getRepository('AppBundle:Testimony')->getRandomTestimony();

            $experiences = $em->getRepository('AppBundle:Experience')->findAllSorted();
            $transfers = $em->getRepository('AppBundle:Transfer')->findAllSorted();
            $airport_transfers = $em->getRepository('AppBundle:AirportTransfer')->findAllSorted();

            $_config = $em->getRepository('AppBundle:ConfigValue')->findAll();
            $config = [];

            foreach ($_config as $item){
                $config[$item->getName()]=$item->getValue();
            }

            $featureImage = '';
            if(count($posters)>0)
                $featureImage = $posters[0]->getWebPath();

            $messageForm = $this->createForm('AppBundle\Form\ContactMsgsType',
                new ContactMsgs(),
                array(
                    'action' => $this->generateUrl('sendMessage'),
                    'method' => 'POST'
                )
            );

            return $this->render('AppBundle:Front:deposit.html.twig',
                ['locale'=>$_locale,
                    'content'=>$content[0],
                    'featureImage'=>$featureImage,
                    'posters'=>$posters,
                    'blogEntries'=>$blogEntries,
                    'socialNetworks'=>$socialNetworks,
                    'hashtags'=>$hashtags,

                    'transfers'=>$transfers,
                    'places'=>$places,
                    'experiences'=>$experiences,
                    'airport_transfers' => $airport_transfers,
                    'infographys'=>$infographys,
                    'testimonials'=>$testimonials,
                    'config' => $config,
                    'messageForm' => $messageForm->createView(),
                    'activityId'=>$ActivityId
                ]);
        }
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
    public function blogEntryAction(Request $request, $_locale="en", $_id, $_name)
    {

        Utils::setRequestLocaleLang($_locale);
        $em = $this->getDoctrine()->getManager();
        $blogEntry = $em->getRepository('AppBundle:Blogentrie')->find($_id);

        $nameLocale = $blogEntry->getTitleLocale();
        $nameRequest = $_name;

        if ($nameRequest != $nameLocale){
            return $this->redirectToRoute('blogEntry',array(
                '_locale'=>$_locale,
                '_id'=> $_id,
                '_name' => $nameLocale
            ), 301);
        }

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
     * @Route("/{_locale}/blog/{_tag}/", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|es|fr",
     * }, name="tag_posts")
     */
    public function tagPostsAction(Request $request, $_locale='en', $_page=1, $_tag){
        $em = $this->getDoctrine()->getManager();

        $tag = [];
        if($_locale == 'es')
            $tag = $em->getRepository("AppBundle:Tag")->findBy(['tag'=>$_tag]);

        else
            $tag = $em->getRepository("AppBundle:Tag")->findBy(['tagEn'=>$_tag]);

        if(!$tag)
            throw new NotFoundHttpException();

        $tags_id = [];
        foreach ($tag as $item)
            $tags_id[] = $item->getId();

        $blogEntries = $em->getRepository("AppBundle:Tag")->findPostByTags($tags_id);

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
                    'currentTag' =>$tag[0]
                ]);
        }
        else
            throw new \Exception("No hay entradas en el blog");

    }

    /**
     * @Route("/bloglike/{_id}", requirements={
     * "_id":"\d+",
     * }, name="bloglikeEntry")
     */
    public function blogLikeEntryAction(Request $request, \AppBundle\Entity\Blogentrie $_id)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest())
        {
            $_id->addLike();
            $em->persist($_id);
            $em->flush();
        }

        return new JsonResponse(['status'=>'ok']);
    }

    /**
     * @Route("/sendMessage", methods={"POST"}, name="sendMessage")
     */
    public function sendMessageAction(Request $request)
    {

        $message = new ContactMsgs();
        $messageForm = $this->createForm('AppBundle\Form\ContactMsgsType',$message);
        $messageForm->handleRequest($request);
        $_locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:SiteContent')->findAll();

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
        $em->persist($message);
        $em->flush();
        $sended_email = true;

        $senderEmail = $content[0]->getContactemail();
        $subject = "Nuevo contacto a traves de la Web (".$message->getId().")";
        $email = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setReplyTo($senderEmail)
            ->setTo($senderEmail)
            ->setFrom("taxidriverscuba-noreply@taxidriverscuba.com")
            ->setBody(
                $this->renderView(
                    'AppBundle:Email:contactNotification.html.twig',
                    [
                    'subject'=>$subject,
                    '_locale'=>$_locale,
                    'message'=>$message,
                    ]
                ),
            'text/html'
            );
        $this->get('mailer')->send($email);
        }

        $this->addFlash('message', 'Mensaje enviado. Muchas gracias<br>Message sended, Thanks a lot!');
        
        return $this->redirectToRoute('home');

    }
}
