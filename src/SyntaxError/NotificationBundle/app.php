#!/usr/bin/env php
<?php

require __DIR__."/../../../vendor/autoload.php";
require __DIR__."/../../../app/AppKernel.php";

$app = new \SyntaxError\NotificationBundle\Kernel\Notifier();
$app->run();
