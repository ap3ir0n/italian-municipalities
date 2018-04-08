<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Controller\Api;


use App\Istat\CsvReader;
use App\Istat\GeographicalDivisionRepository;
use App\Istat\MetropolitanCityRepository;
use App\Istat\MunicipalityRepository;
use App\Istat\ProvinceRepository;
use App\Updater\DatabseUpdater;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends FOSRestController
{
    /**
     * @Route(
     *     path="/api/update",
     *     methods={"GET"},
     *     name="api_update"
     * )
     */
    public function updateAction(Request $request)
    {
        // TODO: refactor as services

        $filename = 'https://www.istat.it/storage/codici-unita-amministrative/Elenco-comuni-italiani.csv';
        $reader = new CsvReader($filename);

        $municipalityRepository = new MunicipalityRepository($reader);
        $geographicalDivisionRepository = new GeographicalDivisionRepository($reader);
        $metropolitanCityRepository = new MetropolitanCityRepository($reader);
        $provinceRepository = new ProvinceRepository($reader);
        $entityManager = $this->getDoctrine()->getManager();

        $updater = new DatabseUpdater(
            $municipalityRepository,
            $geographicalDivisionRepository,
            $metropolitanCityRepository,
            $provinceRepository,
            $entityManager
        );

        $updater->update();

        return $this->handleView($this->view(null));
    }
}