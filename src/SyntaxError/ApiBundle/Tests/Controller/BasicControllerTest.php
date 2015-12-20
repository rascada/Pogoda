<?php

namespace SyntaxError\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicControllerTest extends WebTestCase
{
    public function testNow()
    {
        $route = '/api/basic';
        $client = static::createClient();

        $crawler = $client->request('GET', $route);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertRegExp('/hljs\.initHighlightingOnLoad\(\)\;/', $crawler->getNode(0)->lastChild->nodeValue);

        $crawler = $client->request('GET', "$route.json");
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $crawler = $client->request('GET', "$route.json?callback=test");
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/javascript; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
    }

    /**
     * @param $type
     * @dataProvider wundergroundProvider
     */
    public function testWunderground($type)
    {
        $route = '/api/wu';
        $client = static::createClient();

        $wu = $client->request('GET', "$route/$type");
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);

        $wu = $client->request('GET', "$route/$type.json");
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $wu = $client->request('GET', "$route/$type.json?callback=test");
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/javascript; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
    }

    public function wundergroundProvider()
    {
        return [
          ['forecast'], ['astronomy']
        ];
    }
}
