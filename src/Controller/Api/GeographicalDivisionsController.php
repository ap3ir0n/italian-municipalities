<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Controller\Api;


use App\Api\ApiProblem;
use App\Api\ApiProblemException;
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
    /**
     * @Route(
     *     path="/api/geographical-divisions/{id}",
     *     methods={"GET"},
     *     name="api_geographical_divisions_get"
     * )
     */
    public function getAction($id)
    {
        $gd = $this->getDoctrine()->getRepository('App:GeographicalDivision')
            ->find($id);

        if (!$gd) {
            throw $this->createNotFoundException(sprintf(
                'No geographical division found with id "%s"',
                $id
            ));
        }

        return $gd;
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
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 25);

        $qb = $this->getDoctrine()
            ->getRepository('App:GeographicalDivision')
            ->createQueryBuilder('gd');
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pagerfanta
            ->setCurrentPage($page)
            ->setMaxPerPage($limit);

        $factory = new PagerfantaFactory('page', 'limit');
        $representation = $factory->createRepresentation(
            $pagerfanta, new \Hateoas\Configuration\Route('api_geographical_divisions_list')
        );

        return $representation;

//        $data = $this->getDoctrine()->getRepository('App:GeographicalDivision')->findAll();
//
//        $jsonData = $this->get('jms_serializer')->serialize($data, 'json');
//
//        return new JsonResponse($jsonData, JsonResponse::HTTP_OK, [], true);
    }


}