<?php

namespace SyntaxError\ApiBundle\Tools;

final class IconCache
{
    /**
     * @var string
     */
    private $root;

    /**
     * IconCache constructor.
     * @param string $root
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * Parse wunderground forecast json, download pictures and replace paths in returned json string.
     *
     * @param $forecastJsonString
     * @return string
     */
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

    /**
     * Save file on disk from url.
     *
     * @param $urlPath
     * @return int
     */
    private function save($urlPath)
    {
        return file_put_contents(
            $this->root.DIRECTORY_SEPARATOR.$this->getLastName($urlPath),
            file_get_contents($urlPath)
        );
    }

    /**
     * Get only filename from file path.
     *
     * @param $path
     * @return null
     */
    private function getLastName($path)
    {
        $exploded = explode("/", $path);
        if(!$exploded) return null;
        return $exploded[count($exploded)-1];
    }
}
