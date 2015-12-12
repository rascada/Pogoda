<?php
if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header("Location: /hooks_stat.html"); exit;
}

$pathToHook = __DIR__."/../env/hooks.sh";
echo `$pathToHook > /dev/null 2>/dev/null &`.PHP_EOL;
echo "Deploy running. Check status on ".$_SERVER['HTTP_HOST']."/hooks_stat.html";
