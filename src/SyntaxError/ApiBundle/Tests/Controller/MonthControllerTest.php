<?php

namespace SyntaxError\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MonthControllerTest extends WebTestCase
{
    public function testCharts()
    {
        $client = static::createClient();
        $params = ['outTemp', 'outHumidity', 'barometer', 'rain', 'windGust', 'windGustDir'];

        foreach($params as $param) {
            $crawler = $client->request('GET', '/api/month-charts/'.$param.".json");
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);

            $crawler = $client->request('GET', '/api/month-charts/'.$param.".json", [], [], [
                'HTTP_X-Requested-With' => 'XMLHttpRequest'
            ]);
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);
            $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
        }
    }

    public function testRecords()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/month-records');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $crawler = $client->request('GET', '/api/month-records.json', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

    }
}
