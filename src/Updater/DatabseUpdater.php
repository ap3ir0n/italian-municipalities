<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Updater;


class DatabseUpdater
{
    /**
     * @var MunicipalityRepository
     */
    private $repository;

    /**
     * DatabseUpdater constructor.
     * @param MunicipalityRepository $repository
     */
    public function __construct(MunicipalityRepository $repository)
    {
        $this->repository = $repository;
    }


    public function update()
    {
        // TODO: Implement update() method
    }
}