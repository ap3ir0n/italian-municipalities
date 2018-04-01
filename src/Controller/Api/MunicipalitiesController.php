<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Controller\Api;


use App\Api\ApiProblem;
use App\Api\ApiProblemException;
use App\Api\ListControllerTrait;
use App\Entity\Municipality;
use App\Form\MunicipalityType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MunicipalitiesController extends FOSRestController
{
    use ListControllerTrait;

    /**
     * @Route(
     *     path="/api/municipalities/{id}",
     *     methods={"GET"},
     *     name="api_municipalities_get"
     * )
     */
    public function getAction(Request $request)
    {
        $data = $this->get('App\Api\GetActionRepresentationMaker')
            ->make($request, 'App:Municipality');
        $view = $this->view($data, Response::HTTP_OK);
        return $this->handleView($this->view($data, Response::HTTP_OK));
    }

    /**
     * @Route(
     *     path="/api/municipalities",
     *     methods={"GET"},
     *     name="api_municipalities_cget"
     * )
     */
    public function cgetAction(Request $request)
    {
        $page = $this->getPage($request);
        $limit = $this->getLimit($request);
        $queryBuilder = $this->getDoctrine()
            ->getRepository('App:Municipality')
            ->createQueryBuilder('p');

        $data = $this->get('App\Api\ListActionRepresentationMaker')
            ->make($queryBuilder, $page, $limit);
        $view = $this->view($data, Response::HTTP_OK);
        return $this->handleView($this->view($data, Response::HTTP_OK));
    }

    /**
     * @Route(
     *     path="/api/municipalities",
     *     methods={"POST"},
     *     name="api_municipalities_insert"
     * )
     */
    public function postAction(Request $request)
    {
        $municipality = new Municipality();
        return $this->handleRequest($request, $municipality);
    }

    /**
     * @Route(
     *     path="/api/municipalities/{id}",
     *     methods={"PUT"},
     *     name="api_municipalities_put"
     * )
     */
    public function putAction($id, Request $request) {
        return $this->handleUpdateRequest($request, $id);
    }

    /**
     * @Route(
     *     path="/api/municipalities/{id}",
     *     methods={"PATCH"},
     *     name="api_municipalities_patch"
     * )
     */
    public function patchAction($id, Request $request) {
        return $this->handleUpdateRequest($request, $id);
    }

    private function handleUpdateRequest(Request $request, $id) {
        $municipality = $this->getDoctrine()->getManager()->getRepository('App:Municipality')->find($id);

        if (!$municipality) {
            throw $this->createNotFoundException(sprintf('No entity found with id "%s"', $id));
        }

        return $this->handleRequest($request, $municipality);
    }

    private function handleRequest(Request $request, Municipality $project) {
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(MunicipalityType::class, $project);
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        $statusCode = $request->getMethod() != 'POST' ? Response::HTTP_OK : Response::HTTP_CREATED;
        $view = $this->view($project, $statusCode);
        return $this->handleView($view);
    }

    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }

    protected function throwApiProblemValidationException(FormInterface $form)
    {
        $errors = $this->getErrorsFromForm($form);

        $apiProblem = new ApiProblem(400,ApiProblem::TYPE_VALIDATION_ERROR);
        $apiProblem->set('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }

}