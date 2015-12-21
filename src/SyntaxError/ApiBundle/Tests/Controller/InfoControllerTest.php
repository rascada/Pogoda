<?php

namespace SyntaxError\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoControllerTest extends WebTestCase
{
    public function testResponse()
    {
        $route = '/api/info';
        $client = static::createClient();

        $crawler = $client->request('GET', $route);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);

        $crawler = $client->request('GET', $route.".json");
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $crawler = $client->request('GET', $route.".json?callback=test");
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/javascript; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
    }
}
