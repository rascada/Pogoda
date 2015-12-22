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
            $crawler = $client->request('GET', '/api/'.$period.'-charts/'.$param);
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);

            $crawler = $client->request('GET', '/api/'.$period.'-charts/'.$param.".json");
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);
            $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
            $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

            $crawler = $client->request('GET', '/api/'.$period.'-charts/'.$param.".json?callback=test");
            $this->assertTrue($client->getResponse()->getStatusCode() == 200);
            $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
            $this->assertEquals('application/javascript; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));
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

        $crawler = $client->request('GET', '/api/'.$period.'-records.json');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $crawler = $client->request('GET', '/api/'.$period.'-records.json?callback=test');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
        $this->assertTrue( $client->getResponse()->headers->has('Access-Control-Allow-Origin') );
        $this->assertEquals('application/javascript; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

    }

    public function periodProvider()
    {
        return [
          ['day'], ['month'], ['year']
        ];
    }
}
