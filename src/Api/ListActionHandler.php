<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 31/03/2018
 */

namespace App\Api;


use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class ListActionHandler
{
    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query               A Doctrine ORM query or query builder.
     * @return mixed
     */
    public function handleRequest($query, $page = 1, $limit = 25)
    {
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagerfanta
            ->setCurrentPage($page)
            ->setMaxPerPage($limit);

        $factory = new PagerfantaFactory('page', 'limit');
        $representation = $factory->createRepresentation(
            $pagerfanta, new Route('api_geographical_divisions_list')
        );

        return $representation;
    }
}