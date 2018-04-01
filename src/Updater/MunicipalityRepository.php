<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Updater;


use App\Entity\Municipality;

interface MunicipalityReader
{
    public function findAll(): array;

    public function findOneByCode(): ?Municipality;
}