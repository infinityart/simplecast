<?php

use  Simplecast\Router\RouteCollection;
use  Simplecast\Router\Router;

require_once '../vendor/autoload.php';

$RoutesCollection = new RouteCollection();

$RoutesCollection->setNamespace('Simplecast\Controller');

//$RoutesCollection->addGet('/users/', 'PagesController@home');
$RoutesCollection->addGet('/{users}/{id}', 'PagesController@home');

//$RoutesCollection->addGet('/user/{id}', 'PagesController@home');

$Router = new Router($RoutesCollection);

$Router->matchRequest();