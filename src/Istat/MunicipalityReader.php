<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Istat;


interface MunicipalityReader
{
    public function readMunicipalities(): array;
}