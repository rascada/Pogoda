<?php

namespace SyntaxError\ApiBundle\Tools;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Yaml\Parser;

class Overrider
{
    /**
     * @var array
     */
    private $content;

    /**
     * @var bool
     */
    private $enabled = false;

    /**
     * Overrider constructor.
     * @param string $filename
     */
    public function __construct($filename)
    {
        $parser = new Parser();
        $path = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."Resources".DIRECTORY_SEPARATOR."override".DIRECTORY_SEPARATOR.$filename;
        if( !is_readable($path) ) {
            throw new InvalidConfigurationException(sprintf("Cannot read '%s' config file.", $path));
        }

        $this->content = $parser->parse(file_get_contents($path));
        $this->enabled = $this->content !== null && array_key_exists('enabled', $this->content) && $this->content['enabled'] != false;
        if($this->enabled) {
            if( !array_key_exists('override', $this->content) ) {
                throw new InvalidConfigurationException("Not found override rules, but overriding is enabled. [$filename]");
            }
        }
    }

    /**
     * Return true if override rule exist and overriding is enabled.
     *
     * @param string $dateName
     * @return bool
     */
    public function has($dateName)
    {
        if(!$this->enabled) return false;
        return $this->content['override'] !== null && array_key_exists($dateName, $this->content['override']);
    }

    /**
     * Return override data.
     *
     * @param $dataName
     * @return mixed
     */
    public function get($dataName)
    {
        return array_key_exists($dataName, $this->content['override']) ? $this->content['override'][$dataName] : false;
    }
}
