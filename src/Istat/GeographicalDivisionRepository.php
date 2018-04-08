<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Istat;


use App\Entity\GeographicalDivision;

class GeographicalDivisionRepository implements \App\Updater\GeographicalDivisionRepository
{

    /**
     * @var GeographicalDivisionReader
     */
    private $reader;

    /**
     * @var array
     */
    private $geographicalDivisions;

    /**
     * GeographicalDivisionRepository constructor.
     * @param GeographicalDivisionReader $reader
     */
    public function __construct(GeographicalDivisionReader $reader)
    {
        $this->reader = $reader;
        $this->geographicalDivisions = [];
    }

    public function findAll(): array
    {
        return $this->getGeographicalDivisions();
    }

    public function findOneByName($name): ?GeographicalDivision
    {
        $metropolitanCities = $this->getGeographicalDivisions();

        if (!isset($metropolitanCities[$name])) {
            return null;
        }

        return $metropolitanCities[$name];
    }

    /**
     * @return array
     */
    private function getGeographicalDivisions(): array
    {
        if (empty($this->geographicalDivisions)) {
            $geographicalDivisions = $this->reader->readGeographicalDivisions();
            foreach ($geographicalDivisions as $geographicalDivision) {
                /** @var GeographicalDivision $geographicalDivision */
                $this->geographicalDivisions[$geographicalDivision->getName()] = $geographicalDivision;
            }
        }

        return $this->geographicalDivisions;
    }
}