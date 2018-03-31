<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Tests\Controller\Api;

use App\DataFixtures\MetropolitanCityFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MetropolitanCitiesControllerFunctionalTest extends WebTestCase
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
        $loader->addFixture(new MetropolitanCityFixtures());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());

        $this->client = static::createClient();
    }

    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/api/metropolitan-cities');

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());
        $dbCount = $this->em->getRepository('App:MetropolitanCity')->count([]);
        $this->assertEquals($dbCount, count($decodedJson->_embedded->items));

        $metropolitanCity = $decodedJson->_embedded->items[0];
        $this->assertObjectHasAttribute('id', $metropolitanCity);
        $this->assertObjectHasAttribute('name', $metropolitanCity);
        $this->assertObjectNotHasAttribute('municipalities', $metropolitanCity);
    }

    public function testGetActionWithAValidId()
    {
        $metropolitanCities =
            $this->em->getRepository('App:MetropolitanCity')->findAll();
        $metropolitanCity = $metropolitanCities[array_rand($metropolitanCities)];

        $crawler = $this->client->request('GET',
            "/api/metropolitan-cities/{$metropolitanCity->getId()}");

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());

        $metropolitanCity = $decodedJson;
        $this->assertObjectHasAttribute('id', $metropolitanCity);
        $this->assertObjectHasAttribute('name', $metropolitanCity);
        $this->assertObjectHasAttribute('_links', $metropolitanCity);
        $this->assertObjectNotHasAttribute('municipalities', $metropolitanCity);
    }

    public function testGetActionWithAnInvalidId()
    {
        $crawler = $this->client->request('GET',
            "/api/metropolitan-cities/fake");

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
