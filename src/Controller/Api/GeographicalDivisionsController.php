<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Controller\Api;


use App\Api\ListControllerTrait;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeographicalDivisionsController extends FOSRestController
{
    use ListControllerTrait;

    /**
     * @Route(
     *     path="/api/geographical-divisions/{id}",
     *     methods={"GET"},
     *     name="api_geographical_divisions_get"
     * )
     */
    public function getAction(Request $request)
    {
        $data = $this->get('App\Api\GetActionRepresentationMaker')
            ->make($request, 'App:GeographicalDivision');
        return $this->handleView($this->view($data, Response::HTTP_OK));
    }

    /**
     * @Route(
     *     path="/api/geographical-divisions",
     *     methods={"GET"},
     *     name="api_geographical_divisions_list"
     * )
     */
    public function listAction(Request $request)
    {
        $page = $this->getPage($request);
        $limit = $this->getLimit($request);
        $queryBuilder = $this->getDoctrine()
            ->getRepository('App:GeographicalDivision')
            ->createQueryBuilder('gd');

        $data = $this->get('App\Api\ListActionRepresentationMaker')
            ->make($queryBuilder, $page, $limit);
        return $this->handleView($this->view($data, Response::HTTP_OK));
    }


}