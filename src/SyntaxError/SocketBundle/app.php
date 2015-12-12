<?php
require __DIR__."/../../../vendor/autoload.php";
require_once __DIR__.'/../../../app/AppKernel.php';

use SyntaxError\SocketBundle\Server\Creator;

if( !extension_loaded('redis') ) {
    throw new \RuntimeException("Required PHP-redis extension.");
}

$app = new Creator();
$app->run();
