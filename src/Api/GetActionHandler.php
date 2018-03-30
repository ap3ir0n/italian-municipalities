<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 31/03/2018
 */

namespace App\Api;


use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetActionHandler
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * GetActionHandler constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function handleRequest(Request $request, $persistentObject, $idAttribute = 'id')
    {
        $id = $request->attributes->get($idAttribute);

        $gd = $this->managerRegistry
            ->getRepository($persistentObject)
            ->find($id);

        if (!$gd) {
            throw $this->createNotFoundException(sprintf(
                'No entity found with id "%s"',
                $id
            ));
        }

        return $gd;
    }

    /**
     * Returns a NotFoundHttpException.
     *
     * This will result in a 404 response code. Usage example:
     *
     *     throw $this->createNotFoundException('Page not found!');
     *
     * @final
     */
    protected function createNotFoundException(string $message = 'Not Found', \Exception $previous = null): NotFoundHttpException
    {
        return new NotFoundHttpException($message, $previous);
    }
}