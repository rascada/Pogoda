<?php

namespace SyntaxError\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArchiveControllerTest extends WebTestCase
{
    /**
     * @param $period
     * @dataProvider periodProvider
     */
    public function testCharts($period)
    {
        $client = static::createClient();
        $params = ['outTemp', 'outHumidity', 'barometer', 'rain', 'rainRate', 'windSpeed', 'windDir', 'windGust', 'windGustDir'];

        foreach($params as $param) {
            $crawler = $client->request('GET', '/api/'.$period.'-charts/'.$param.".json");
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);

            $crawler = $client->request('GET', '/api/'.$period.'-charts/'.$param.".json", [], [], [
                'HTTP_X-Requested-With' => 'XMLHttpRequest'
            ]);
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);
            $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
        }
    }

    /**
     * @param $period
     * @dataProvider periodProvider
     */
    public function testRecords($period)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/'.$period.'-records');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $crawler = $client->request('GET', '/api/'.$period.'-records.json', [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

    }

    public function periodProvider()
    {
        return [
          ['day'], ['month'], ['year']
        ];
    }
}
