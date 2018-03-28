<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function homeAction()
    {
        return new Response('Ciao mondo');
    }

    /**
     * @Route("/data")
     */
    public function dataAction()
    {
        return new JsonResponse([
            'test' => 'Ciao mondo'
        ]);
    }

}