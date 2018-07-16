<?php
/**
 * Created by PhpStorm.
 * User: Josué Aguilar
 * Date: 15/05/2018
 * Time: 23:34
 */
namespace AppBundle\Controller;
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
     */
	public function homeRedirectionAction(Request $request)
	{
		return $this->redirectToRoute('home',array(), 301);
	}
}