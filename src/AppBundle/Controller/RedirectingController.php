<?php
/**
 * Created by PhpStorm.
 * User: Josué Aguilar
 * Date: 15/05/2018
 * Time: 23:34
 */
namespace AppBundle\Controller;
use AppBundle\Entity\Experience;
use AppBundle\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RedirectingController extends Controller
{
    public function removeTrailingSlashAction(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();
        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);
        return $this->redirect($url, 301);
    }
	
    /**
     * @Route("/index.php")
     * @Route("/Bienvenido")
     * @Route("/Welcome")
     */
	public function homeRedirectionAction(Request $request)
	{
		return $this->redirectToRoute('home',array(), 301);
	}
	/**
     * @Route("/redirect/{name}", name="redirection_routing")
     */
	public function relocateServiceUrl($name)
    {
        $em = $this->getDoctrine()->getManager();

        $words = explode('-', $name);
        $words = array_reverse($words);
        $place = null;
        foreach ($words as $word)
        {
            $_place = $em->getRepository('AppBundle:Place')->findOneByWord($word);
            if($_place)
            {
                $place = $_place[0];
                break;
            }

        }
        if(!$place)
            throw  $this->createNotFoundException("This product not exist");

        $experience = $em->getRepository('AppBundle:Experience')->findOneBy(['targetPlace'=>$place->getId()]);
        if($experience)
            return $this->redirectToRoute('show_experience',
                ['id'=>$experience->getId(),
                    '_name' => Utils::slugify($experience->getName())
                ], 301);
        $transfer = $em->getRepository('AppBundle:Transfer')->findOneBy(['targetPlace'=>$place->getId()]);
        if($transfer)
            return $this->redirectToRoute('booking_place',
                ['_id'=>$transfer->getId(),
                    '_name' => Utils::slugify($transfer->getName())
                ],301);

        return $this->redirectToRoute('home');
    }
}