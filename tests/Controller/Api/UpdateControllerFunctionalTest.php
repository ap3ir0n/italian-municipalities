<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Tests\Controller\Api;

use App\DataFixtures\GeographicalDivisionFixtures;
use App\DataFixtures\MetropolitanCityFixtures;
use App\DataFixtures\MunicipalityFixtures;
use App\DataFixtures\ProvinceFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateControllerFunctionalTest extends WebTestCase
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
        $loader->addFixture(new ProvinceFixtures());

        $purger = new ORMPurger($this->em);
        $purger->purge();

        $this->client = static::createClient();
    }

    public function testUpdateActionWithEmptyDb()
    {
        $crawler = $this->client->request('GET', '/api/update');

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $crawler = $this->client->request('GET', '/api/municipalities');

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());
        $dbCount = $this->em->getRepository('App:Municipality')->count([]);
        $this->assertTrue($dbCount > 0, 'No municipalities loaded');
        $this->assertEquals($dbCount, $decodedJson->total);
    }

    public function testUpdateActionWithNotEmptyDb()
    {
        $loader = new Loader();
        $loader->addFixture(new ProvinceFixtures());
        $loader->addFixture(new GeographicalDivisionFixtures());
        $loader->addFixture(new MetropolitanCityFixtures());
        $loader->addFixture(new MunicipalityFixtures());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());

        $crawler = $this->client->request('GET', '/api/update');

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $crawler = $this->client->request('GET', '/api/municipalities');

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());
        $dbCount = $this->em->getRepository('App:Municipality')->count([]);
        $this->assertTrue($dbCount > 0, 'No municipalities loaded');
        $this->assertEquals($dbCount, $decodedJson->total);
    }

}
