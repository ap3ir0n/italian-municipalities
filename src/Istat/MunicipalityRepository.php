<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Istat;


use App\Entity\Municipality;

class MunicipalityRepository implements \App\Updater\MunicipalityRepository
{
    /**
     * @var MunicipalityReader
     */
    private $reader;

    /**
     * @var array
     */
    private $municipalities;

    /**
     * MunicipalityRepository constructor.
     * @param MunicipalityReader $reader
     */
    public function __construct(MunicipalityReader $reader)
    {
        $this->reader = $reader;
        $this->municipalities = [];
    }


    public function findAll(): array
    {
        return $this->getMunicipalities();
    }

    public function findOneByCode($code): ?Municipality
    {
        $municipalities = $this->getMunicipalities();

        if (!isset($municipalities[$code])) {
            return null;
        }

        return $municipalities[$code];
    }

    /**
     * @return array
     */
    private function getMunicipalities(): array
    {
        if (empty($this->municipalities)) {
            $municipalities = $this->reader->readMunicipalities();
            foreach ($municipalities as $municipality) {
                /** @var Municipality $municipality */
                $this->municipalities[$municipality->getIstatCode()] = $municipality;
            }
        }

        return $this->municipalities;
    }

}