<?php

namespace SyntaxError\ApiBundle\Tools;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class Jsoner
{
    /**
     * @var Serializer
     */
    private $serializer;
    /**
     * @var string
     */
    private $jsonString;

    public function __construct()
    {
        $normalizers[0] = new GetSetMethodNormalizer();
        $normalizers[0]->setCallbacks([
            'when' => function ($dateTime) {
                if ($dateTime instanceof \DateTime) {
                    return $dateTime->format("Y-m-d H:i");
                }
                return "Source datetime invalid format.";
            }
        ]);
        $normalizers[] = new PropertyNormalizer();

        $this->serializer = new Serializer(
            $normalizers,
            [new JsonEncoder(), new XmlEncoder()]
        );
        $this->serializer->supportsEncoding('utf8');
        $this->jsonString = '';
    }
    /**
     * @param $value
     * @return $this
     */
    public function createJson($value)
    {
        $this->jsonString = $this->serializer->serialize($value, 'json');
        return $this;
    }
    /**
     * @return $this
     */
    public function unescapeUnicode()
    {
        $this->jsonString = preg_replace_callback(
            '/\\\\u([0-9a-fA-F]{4})/',
            function ($match) {
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
            },
            $this->jsonString
        );
        return $this;
    }
    /**
     * @return $this
     */
    public function unescapeSlashes()
    {
        $this->jsonString = str_replace('\\', '', $this->jsonString);
        return $this;
    }
    /**
     * @return $this
     */
    public function eol2Br()
    {
        $this->jsonString = str_replace('\\n', "<br/>", $this->jsonString);
        return $this;
    }
    /**
     * @param $callback
     * @return Response
     */
    public function createResponse($callback)
    {
        $response = new Response( $this->jsonString );
        if($callback) {
            $response = new Response( $callback."(".$this->jsonString.")" );
            $response->headers->set('Access-Control-Allow-Origin', '*');
        }
        $response->headers->set(
            'Content-Type',
            ($callback ? 'application/javascript': 'application/json' ).'; charset=utf-8'
        );
        return $response;
    }
    /**
     * @return string
     */
    public function getJsonString()
    {
        return $this->jsonString;
    }

}
