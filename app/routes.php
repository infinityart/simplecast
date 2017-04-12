<?php

use  Simplecast\Router\RouteCollection;
use  Simplecast\Router\Router;

require_once '../vendor/autoload.php';

$RoutesCollection = new RouteCollection();

$RoutesCollection->setNamespace('Simplecast\Controller');

// Start routes

// End routes

$Router = new Router($RoutesCollection);

$Router->matchRequest();