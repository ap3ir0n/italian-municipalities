<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Tests\Controller\Api;

use App\DataFixtures\MunicipalityFixtures;
use App\Entity\Municipality;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MunicipalitiesControllerFunctionalTest extends WebTestCase
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
        $loader->addFixture(new MunicipalityFixtures());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());

        $this->client = static::createClient();
    }

    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/api/municipalities');

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());
        $dbCount = $this->em->getRepository('App:Municipality')->count([]);
        $this->assertEquals($dbCount, count($decodedJson->_embedded->items));

        $municipality = $decodedJson->_embedded->items[0];
        $attributes = ['id', 'province', 'number', 'name',
            'geographicalDivision', 'isProvincialCapital',
            'cadastralCode', 'licensePlateCode'];
        foreach ($attributes as $attribute) {
            $this->assertObjectHasAttribute($attribute, $municipality);
        }
        $this->assertObjectNotHasAttribute('municipalities', $municipality);
    }

    public function testGetActionWithAValidId()
    {
        $municipalities =
            $this->em->getRepository('App:Municipality')->findAll();
        $municipality = $municipalities[array_rand($municipalities)];

        $crawler = $this->client->request('GET',
            "/api/municipalities/{$municipality->getId()}");

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());

        $municipality = $decodedJson;
        $this->assertObjectHasAttribute('id', $municipality);
        $this->assertObjectHasAttribute('name', $municipality);
        $this->assertObjectHasAttribute('_links', $municipality);
        $this->assertObjectNotHasAttribute('municipalities', $municipality);
    }

    public function testGetActionWithAnInvalidId()
    {
        $crawler = $this->client->request('GET',
            "/api/municipalities/fake");

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

    public function testPostActionWithValidData()
    {
        $province = $this->em->getRepository('App:Province')->findOneByName('Enna');
        $geographicalDivision = $this->em->getRepository('App:GeographicalDivision')->findOneByName('Isole');
    
        $data = [
            'name' => 'Calascibetta',
            'number' => 5,
            'isProvincialCapital' => false,
            'cadastralCode' => 'B381',
            'legalPopulationAt2011' => 4628,
            'licensePlateCode' => 'EN',
            'province' => $province->getId(),
            'geographicalDivision' => $geographicalDivision->getId(),
            'isProvincialCapital' => false
        ];

        $crawler = $this->client->request(Request::METHOD_POST,"/api/municipalities", [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());

        $municipality = $decodedJson;
        $this->assertObjectHasAttribute('id', $municipality);

        $scalars = [
            'name',
            'number',
            'isProvincialCapital',
            'cadastralCode',
            'legalPopulationAt2011',
            'licensePlateCode',
        ];
        foreach ($scalars as $name) {
            $this->assertObjectHasAttribute($name, $municipality);
            $this->assertAttributeEquals($data[$name], $name, $municipality);
        }

        $this->assertEquals($data['province'], $municipality->province->id);
        $this->assertEquals($data['geographicalDivision'], $municipality->geographicalDivision->id);

        $this->assertObjectNotHasAttribute('municipalities', $municipality);
    }

    public function testPostActionWithInvalidData()
    {
        $crawler = $this->client->request(Request::METHOD_POST,"/api/municipalities", [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode([]));

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $errorResponse = json_decode($response->getContent());

        $required = [
            'name',
            'number',
            'cadastralCode',
            'licensePlateCode',
            'province',
            'geographicalDivision',
        ];

        $this->assertObjectHasAttribute('errors', $errorResponse);

        foreach ($required as $name) {
            $this->assertObjectHasAttribute($name, $errorResponse->errors);
            $this->assertEquals('This value should not be blank.', $errorResponse->errors->$name[0]);
        }

        $this->assertObjectNotHasAttribute('municipalities', $errorResponse);
    }

    public function testPutActionWithValidData()
    {
        $caltanissetta = $this->em->getRepository('App:Province')->findOneByName('Caltanissetta');
        $enna = $this->em->getRepository('App:Province')->findOneByName('Enna');
        $isole = $this->em->getRepository('App:GeographicalDivision')->findOneByName('Isole');
        $centro = $this->em->getRepository('App:GeographicalDivision')->findOneByName('Centro');

        $calascibetta = new Municipality();
        $calascibetta
            ->setName('Fake name')
            ->setNumber(90)
            ->setIsProvincialCapital(true)
            ->setCadastralCode('ASDF')
            ->setLegalPopulationAt2011(999999)
            ->setLicensePlateCode('XX')
            ->setProvince($caltanissetta)
            ->setGeographicalDivision($centro);

        $data = [
            'name' => 'Calascibetta',
            'number' => 5,
            'isProvincialCapital' => false,
            'cadastralCode' => 'B381',
            'legalPopulationAt2011' => 4628,
            'licensePlateCode' => 'EN',
            'province' => $enna->getId(),
            'geographicalDivision' => $isole->getId(),
            'isProvincialCapital' => false
        ];

        $crawler = $this->client->request(Request::METHOD_PUT,"/api/municipalities", [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());

        $decodedJson = json_decode($response->getContent());

        $municipality = $decodedJson;
        $this->assertObjectHasAttribute('id', $municipality);

        $scalars = [
            'name',
            'number',
            'isProvincialCapital',
            'cadastralCode',
            'legalPopulationAt2011',
            'licensePlateCode',
        ];
        foreach ($scalars as $name) {
            $this->assertObjectHasAttribute($name, $municipality);
            $this->assertAttributeEquals($data[$name], $name, $municipality);
        }

        $this->assertEquals($data['province'], $municipality->province->id);
        $this->assertEquals($data['geographicalDivision'], $municipality->geographicalDivision->id);

        $this->assertObjectNotHasAttribute('municipalities', $municipality);
    }

}
