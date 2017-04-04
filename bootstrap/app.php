<?php
require "../vendor/autoload.php";

$dotenv = new Dotenv\Dotenv('../');
$dotenv->load();

$whoops = new Whoops\Run();
if (getenv('ENVIRONMENT') !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function($e){
        echo 'Todo: Friendly error page and send an email to the developer';
    });
}
$whoops->register();

require "../app/routes.php";

throw new Exception();