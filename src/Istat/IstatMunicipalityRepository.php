<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Istat;


use App\Entity\Municipality;

class MunicipalityRepository
{
    /**
     * @var MunicipalityReader
     */
    private $reader;

    /**
     * MunicipalityRepository constructor.
     * @param MunicipalityReader $reader
     */
    public function __construct(MunicipalityReader $reader)
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