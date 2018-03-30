<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Tests\Controller\Api;

use App\Controller\Api\GeographicalDivisionsController;
use App\DataFixtures\GeographicalDivisionFixtures;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GeographicalDivisionsControllerFunctionalTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EntityManager
     */
    protected $em;

    protected function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $loader = new Loader();
        $loader->addFixture(new GeographicalDivisionFixtures());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());

        $this->client = static::createClient();
    }

    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/api/geographical-divisions');

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());
        $dbCount = $this->em->getRepository('App:GeographicalDivision')->count([]);
        $this->assertEquals($dbCount, count($decodedJson->_embedded->items));

        $geographicalDivision = $decodedJson->_embedded->items[0];
        $this->assertObjectHasAttribute('id', $geographicalDivision);
        $this->assertObjectHasAttribute('name', $geographicalDivision);
        $this->assertObjectNotHasAttribute('municipalities', $geographicalDivision);
    }

    public function testGetActionWithAValidId()
    {
        $geographicalDivisions =
            $this->em->getRepository('App:GeographicalDivision')->findAll();
        $geographicalDivision = $geographicalDivisions[array_rand($geographicalDivisions)];

        $crawler = $this->client->request('GET',
            "/api/geographical-divisions/{$geographicalDivision->getId()}");

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());

        $geographicalDivision = $decodedJson;
        $this->assertObjectHasAttribute('id', $geographicalDivision);
        $this->assertObjectHasAttribute('name', $geographicalDivision);
        $this->assertObjectNotHasAttribute('municipalities', $geographicalDivision);
    }

    public function testGetActionWithAnInvalidId()
    {
        $crawler = $this->client->request('GET',
            "/api/geographical-divisions/fake");

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());

        $responseObject = $decodedJson;
        $this->assertObjectHasAttribute('status', $responseObject);
        $this->assertObjectHasAttribute('type', $responseObject);
        $this->assertObjectHasAttribute('title', $responseObject);
        $this->assertEquals('about:blank', $responseObject->type);
        $this->assertEquals('Not Found', $responseObject->title);
    }

}
