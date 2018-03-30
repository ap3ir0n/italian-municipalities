<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 31/03/2018
 */

namespace App\Api;


use Symfony\Component\HttpFoundation\Request;

trait ListControllerTrait
{
    public function getPage(Request $request)
    {
        return $request->query->get('page', 1);
    }

    public function getLimit(Request $request)
    {
        return $request->query->get('limit', 25);
    }
}