<?php

use  Simplecast\Router\RouteCollection;
use  Simplecast\Router\Router;

require_once '../vendor/autoload.php';

$RoutesCollection = new RouteCollection();

$RoutesCollection->setNamespace('Simplecast\Controller');

$RoutesCollection->addGet('/', 'PagesController@home');


$RoutesCollection->addGet('/register', 'AuthController@showRegisterPage');
//$RoutesCollection->addPost('/register', 'UserController@create');
$RoutesCollection->addGet('/login', 'AuthController@showLoginPage');
//$RoutesCollection->addPost('/login', 'AuthController@authenticate');

$Router = new Router($RoutesCollection);

$Router->matchRequest();