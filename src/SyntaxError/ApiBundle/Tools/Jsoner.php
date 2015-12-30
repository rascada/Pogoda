<?php

namespace SyntaxError\ApiBundle\Tools;

use Symfony\Component\HttpFoundation\Response;
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
        $this->serializer = new Serializer(
            [new GetSetMethodNormalizer(), new PropertyNormalizer()],
            [new JsonEncoder()]
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
        $response = new Response( $callback ? ($callback."(".$this->jsonString.")") : $this->jsonString );
        $response->headers->set(
            'Content-Type',
            ($callback ? 'application/javascript': 'application/json' ).'; charset=utf-8'
        );
        $response->headers->set('Access-Control-Allow-Origin', '*');
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
