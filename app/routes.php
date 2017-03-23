<?php

use  Simplecast\Router\RouteCollection;
use  Simplecast\Router\Router;

require_once '../vendor/autoload.php';

$RoutesCollection = new RouteCollection();

$RoutesCollection->setNamespace('Simplecast\Controller');

$RoutesCollection->addGet('/', 'PagesController@home');

$Router = new Router($RoutesCollection);

$Router->matchRequest();