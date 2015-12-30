<?php

namespace SyntaxError\ApiBundle\Tools;


class IconCache
{
    private $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function cacheFromWunderground($forecastJsonString)
    {
        $forecast = json_decode($forecastJsonString);
        foreach($forecast->forecast->txt_forecast->forecastday as $i => $day) {
            $this->save($day->icon_url);
            $newUrl = 'https://pogoda.skalagi.pl/bundles/syntaxerrorapi/images/'.$this->getLastName($day->icon_url);

            $forecast->forecast->txt_forecast->forecastday[$i]->icon_url = $newUrl;
        }
        return json_encode($forecast);
    }

    private function save($urlPath)
    {
        return file_put_contents(
            $this->root.DIRECTORY_SEPARATOR.$this->getLastName($urlPath),
            file_get_contents($urlPath)
        );
    }

    private function getLastName($path)
    {
        $exploded = explode("/", $path);
        if(!$exploded) return null;
        return $exploded[count($exploded)-1];
    }
}
