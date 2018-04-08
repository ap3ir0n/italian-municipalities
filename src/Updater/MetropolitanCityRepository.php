<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Updater;


use App\Entity\MetropolitanCity;

interface MetropolitanCityRepository
{
    public function findAll(): array;

    public function findOneByCode($code): ?MetropolitanCity;

}