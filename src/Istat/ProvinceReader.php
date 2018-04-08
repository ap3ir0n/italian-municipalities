<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Istat;


interface ProvinceReader
{
    public function readProvinces(): array;
}