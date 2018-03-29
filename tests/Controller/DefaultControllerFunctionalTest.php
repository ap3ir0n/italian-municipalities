<?php
/**
 * Created by PhpStorm.
 * User: Patrick Luca Fazzi
 * Date: 28/03/2018
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerFunctionalTest extends WebTestCase
{
    public function testHomeAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('#root')->count());
    }
}
