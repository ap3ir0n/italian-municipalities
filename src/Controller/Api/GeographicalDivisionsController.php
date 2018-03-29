<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Controller\Api;


use App\Api\ApiProblem;
use App\Api\ApiProblemException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeographicalDivisionsController extends Controller
{
    /**
     * @Route(
     *     path="/api/geographical-divisions/{geographicalDivisionId}",
     *     methods={"GET"},
     *     name="api_geographical_divisions_get"
     * )
     */
    public function getAction($geographicalDivisionId)
    {
        $data = $this->getDoctrine()->getRepository('App:GeographicalDivision')
            ->find($geographicalDivisionId);

        if (!$data) {
            throw $this->createNotFoundException(sprintf(
                'No geographical division found with id "%s"',
                $geographicalDivisionId
            ));
        }

        $jsonData = $this->get('jms_serializer')->serialize($data, 'json');

        return new JsonResponse($jsonData, JsonResponse::HTTP_OK, [], true);
    }

    /**
     * @Route(
     *     path="/api/geographical-divisions",
     *     methods={"GET"},
     *     name="api_geographical_divisions_list"
     * )
     */
    public function listAction()
    {
        $data = $this->getDoctrine()->getRepository('App:GeographicalDivision')->findAll();

        $jsonData = $this->get('jms_serializer')->serialize($data, 'json');

        return new JsonResponse($jsonData, JsonResponse::HTTP_OK, [], true);
    }


}