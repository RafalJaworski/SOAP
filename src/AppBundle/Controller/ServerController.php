<?php
/**
 * Created by PhpStorm.
 * User: anyapps
 * Date: 2017-02-16
 * Time: 02:16
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;

class ServerController extends Controller
{
    /**
     * Connect to CRUD service and call methods on it
     *
     * @param Request $request
     * @return Response
     */
    public function connectAction(Request $request)
    {
        return $this->manageRequest($request,'api_product_new','controller_service');
    }

    private function manageRequest(Request $request,String $route, String $serviceName){
        if($request->query->has('wsdl')){
            return $this->handleWSDL($this->generateUrl($route,[],UrlGeneratorInterface::ABSOLUTE_URL), $serviceName);
        }else {
            return $this->handleSOAP($this->generateUrl($route,[],UrlGeneratorInterface::ABSOLUTE_URL), $serviceName);
        }
    }

    /**
     * URI - absolute url to connect action
     * CLASS - CRUD class name
     * This method generates WSDL
     *
     * @param $uri
     * @param $class
     * @return Response
     */
    public function handleWSDL($uri, $class)
    {
        // Soap auto discover
        $autoDiscover = new AutoDiscover();
        $autoDiscover->setClass($this->get($class)); //set service
        $autoDiscover->setUri($uri);

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        ob_start();

        // Handle Soap
        $autoDiscover->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

    /**
     * URI - absolute url to connect action
     * CLASS - CRUD class name
     * This method call CRUD service
     *
     * @param $uri
     * @param $class
     * @return Response
     */
    public function handleSOAP($uri, $class)
    {
        // Soap server
        $soap = new Server(null,['location' => $uri, 'uri' => $uri]);
        $soap->setClass($this->get($class));

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        // Handle Soap
        $soap->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}

