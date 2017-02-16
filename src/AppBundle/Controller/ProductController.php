<?php
/**
 * Created by PhpStorm.
 * User: anyapps
 * Date: 2017-02-16
 * Time: 02:17
 */

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    private $manager;

    public function __construct(EntityManager $entityManager)
    {
        $this->manager = $entityManager;
    }

    /**
     * SOAP Clear cache
     */
    public function init()
    {
        ini_set('soap.wsdl_cache_enable', 0);
        ini_set('soap.wsdl_cache_ttl', 0);
    }

    public function newAction()
    {

    }

    public function showAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}

