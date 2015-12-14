<?php

namespace SyntaxError\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DayControllerTest extends WebTestCase
{
    public function testCharts()
    {
        $client = static::createClient();
        $params = ['outTemp', 'outHumidity', 'barometer', 'rain', 'rainRate', 'windSpeed', 'windDir', 'windGust', 'windGustDir'];

        foreach($params as $param) {
            $crawler = $client->request('GET', '/api/day-charts/'.$param);
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);

            $crawler = $client->request('GET', '/api/day-charts/'.$param, [], [], [
                'HTTP_X-Requested-With' => 'XMLHttpRequest'
            ]);
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);
            $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
        }
    }

    public function testRecords()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/day-records');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $crawler = $client->request('GET', '/api/day-records', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

    }
}
