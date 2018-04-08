<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Istat;


use App\Entity\MetropolitanCity;

class MetropolitanCityRepository implements \App\Updater\MetropolitanCityRepository
{

    /**
     * @var MetropolitanCityReader
     */
    private $reader;

    /**
     * @var array
     */
    private $metropolitanCities;

    /**
     * MetropolitanCityRepository constructor.
     * @param MetropolitanCityReader $reader
     */
    public function __construct(MetropolitanCityReader $reader)
    {
        $this->reader = $reader;
        $this->metropolitanCities = [];
    }

    public function findAll(): array
    {
        return $this->getMetropolitanCities();
    }

    public function findOneByCode($code): ?MetropolitanCity
    {
        $metropolitanCities = $this->getMetropolitanCities();

        if (!isset($metropolitanCities[$code])) {
            return null;
        }

        return $metropolitanCities[$code];
    }

    /**
     * @return array
     */
    private function getMetropolitanCities(): array
    {
        if (empty($this->metropolitanCities)) {
            $metropolitanCities = $this->reader->readMetropolitanCities();
            foreach ($metropolitanCities as $metropolitanCity) {
                /** @var MetropolitanCity $metropolitanCity */
                $this->metropolitanCities[$metropolitanCity->getCode()] = $metropolitanCity;
            }
        }

        return $this->metropolitanCities;
    }
}