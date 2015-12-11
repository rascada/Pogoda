<?php

namespace SyntaxError\SocketBundle\Server;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class Config
{
    const required = ['bind', 'port', 'log', 'task'];

    const pidPath = __DIR__."/../.pid";

    const hostsPath = __DIR__."/../.hosts";

    const configPath = __DIR__."/../config/server.yml";

    const timeout = 10;

    public static function create($dev = false)
    {
        if( !is_readable(static::configPath) ) {
            throw new \InvalidArgumentException("Not found server.yml config file.");
        }
        $parser = new Parser();
        $yaml = $parser->parse(file_get_contents(static::configPath));
        if(!$dev) {
            foreach(static::required as $requiredConfig) {
                if( !array_key_exists($requiredConfig, $yaml) ) {
                    throw new InvalidConfigurationException("Required '$requiredConfig' config key.");
                }
            }
        }
        return $yaml;
    }

    public static function save(array $content)
    {
        $configPath = explode("/", static::configPath);
        $cnt = count($configPath);
        $result = '';
        foreach($configPath as $i => $configPathItem) {
            if($i < $cnt-1) $result .= "/$configPathItem";
        }
        if( !is_writable($result) ) {
            throw new \RuntimeException("Access denied to '$result'.");
        }
        $dumper = new Dumper();
        return file_put_contents(static::configPath, $dumper->dump($content, 2));
    }

    public static function getPid()
    {
        if( is_readable(static::pidPath) ) {
            return file_get_contents(static::pidPath);
        }
        return "stopped";
    }

    public static function setPid()
    {
        $pidPath = explode("/", static::pidPath);
        $cnt = count($pidPath);
        $result = '';
        foreach($pidPath as $i => $pidPathItem) {
            if($i < $cnt-1) $result .= "/$pidPathItem";
        }
        if( is_writable($result) ) {
            $pid = getmypid();
            file_put_contents(static::pidPath, $pid);
            return $pid;
        }
        return false;
    }

}
