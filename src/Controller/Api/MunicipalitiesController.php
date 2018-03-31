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
use Symfony\Component\Routing\Annotation\Route;

class MunicipalitiesController extends FOSRestController
{
    use ListControllerTrait;

    /**
     * @Route(
     *     path="/api/municipalities/{id}",
     *     methods={"GET"},
     *     name="api_municipalities_get"
     * )
     */
    public function getAction(Request $request)
    {
        $data = $this->get('App\Api\GetActionRepresentationMaker')
            ->make($request, 'App:Municipality');
        return View::create($data);
    }

    /**
     * @Route(
     *     path="/api/municipalities",
     *     methods={"GET"},
     *     name="api_municipalities_list"
     * )
     */
    public function listAction(Request $request)
    {
        $page = $this->getPage($request);
        $limit = $this->getLimit($request);
        $queryBuilder = $this->getDoctrine()
            ->getRepository('App:Municipality')
            ->createQueryBuilder('p');

        $data = $this->get('App\Api\ListActionRepresentationMaker')
            ->make($queryBuilder, $page, $limit);
        return View::create($data);
    }


}