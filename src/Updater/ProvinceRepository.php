<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Updater;


use App\Entity\Province;

interface ProvinceRepository
{
    public function findAll(): array;

    public function findOneByCode($code): ?Province;
}