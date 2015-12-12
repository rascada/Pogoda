<?php

namespace SyntaxError\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicControllerTest extends WebTestCase
{
    public function testNow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertRegExp('/hljs\.initHighlightingOnLoad\(\)\;/', $crawler->getNode(0)->lastChild->nodeValue);

        $crawler = $client->request('GET', '/', [], [], [
           'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testWunderground()
    {
        $client = static::createClient();

        $forecast = $client->request('GET', '/wu/forecast');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $forecast = $client->request('GET', '/wu/forecast', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));



        $astronomy = $client->request('GET', '/wu/astronomy');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $astronomy = $client->request('GET', '/wu/astronomy', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

    }
}