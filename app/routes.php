<?php

use  Simplecast\Router\RouteCollection;
use  Simplecast\Router\Router;

require_once '../vendor/autoload.php';

$Router = new Router(new RouteCollection());

$Router->setNamespace('Simplecast\Controller');

// Start routes

// End routes

$Router->matchRequest();