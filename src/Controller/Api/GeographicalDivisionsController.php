<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Controller\Api;


use App\Api\ApiProblem;
use App\Api\ApiProblemException;
use App\Api\ListControllerTrait;
use FOS\RestBundle\Controller\FOSRestController;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        return $this->get('App\Api\GetActionRepresentationMaker')
            ->make($request, 'App:GeographicalDivision');
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

        return $this->get('App\Api\ListActionRepresentationMaker')->make($queryBuilder, $page, $limit);
    }


}