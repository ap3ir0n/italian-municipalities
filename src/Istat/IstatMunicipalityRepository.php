<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Istat;


use App\Entity\Municipality;
use App\Updater\MunicipalityRepository;

class IstatMunicipalityRepository implements MunicipalityRepository
{
    /**
     * @var IStatMunicipalityReader
     */
    private $reader;

    /**
     * MunicipalityRepository constructor.
     * @param IStatMunicipalityReader $reader
     */
    public function __construct(IStatMunicipalityReader $reader)
    {
        $this->reader = $reader;
    }


    public function findAll(): array
    {
        // TODO: to implement
    }

    public function findOneByCode(): ?Municipality
    {
        // TODO: to implement
    }
}