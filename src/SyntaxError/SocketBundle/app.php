<?php
require __DIR__."/../../../vendor/autoload.php";
require_once __DIR__.'/../../../app/AppKernel.php';

use SyntaxError\SocketBundle\Server\Creator;

$app = new Creator();
$app->run();
