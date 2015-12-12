<?php
if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header("HTTP/1.1 403 Forbidden"); echo "Not allowed"; exit;
}

$pathToHook = __DIR__."/../env/hooks.sh";
echo `$pathToHook > /dev/null 2>/dev/null &`.PHP_EOL;
echo "Deploy running. Check status on ".$_SERVER['SERVER_NAME']."/hooks_stat.html";
