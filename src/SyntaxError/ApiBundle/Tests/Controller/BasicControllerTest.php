<?php

namespace SyntaxError\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicControllerTest extends WebTestCase
{
    public function testNow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/basic');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertRegExp('/hljs\.initHighlightingOnLoad\(\)\;/', $crawler->getNode(0)->lastChild->nodeValue);

        $crawler = $client->request('GET', '/api/basic.json', [], [], [
           'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testWunderground()
    {
        $client = static::createClient();

        $forecast = $client->request('GET', '/api/wu/forecast');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $forecast = $client->request('GET', '/api/wu/forecast.json', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));



        $astronomy = $client->request('GET', '/api/wu/astronomy');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $astronomy = $client->request('GET', '/api/wu/astronomy.json', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

    }
}
