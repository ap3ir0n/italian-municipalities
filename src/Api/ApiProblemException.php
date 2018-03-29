<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Api;


use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    /**
     * @var ApiProblem
     */
    private $apiProblem;

    public function __construct(ApiProblem $apiProblem, \Exception $previous = null, array $headers = array(), ?int $code = 0)
    {
        $this->apiProblem = $apiProblem;

        parent::__construct($apiProblem->getStatusCode(), $apiProblem->getTitle(), $previous, $headers, $code);
    }
}