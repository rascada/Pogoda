<?php
if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header("Location: /hooks_stat.html"); exit;
}

$payload = json_decode(file_get_contents('php://input'));
$pathToProject = __DIR__."/..";
$headContent = trim(str_replace("ref: ", "", file_get_contents($pathToProject."/.git/HEAD")));

if($payload->ref == $headContent) {
    $redis = new \Redis();
    $redis->connect('127.0.0.1');

    if( $redis->exists('deploy_running') && $redis->get('deploy_running') == 'true' ) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo "Deploy is currently running.";
    } else {
        $redis->set('deploy_running', 'true');
        echo `$pathToProject/env/hooks.sh > /dev/null 2>/dev/null &`.PHP_EOL;
        echo "Deploy running. Check status on ".$_SERVER['HTTP_HOST']."/hooks_stat.html";
    }

} else {
    echo "I'm $headContent.";
}
