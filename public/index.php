<?php
/**
 * @author: Jonty Sponselee <jsponselee@student.scalda.nl>
 * @since: 16-3-2017
 */
use  Simplecast\Router\RouteCollection;
use  Simplecast\Router\Router;

require_once '../vendor/autoload.php';

$RoutesCollection = new RouteCollection();

$RoutesCollection->setNamespace('Simplecast\Controller');

$RoutesCollection->addGet('/', 'UserController@index');
$RoutesCollection->addGet('/users/1', 'UserController@show');
$RoutesCollection->addPost('/users/', 'UserController@save');
$RoutesCollection->addDelete('/users/1', 'UserController@delete');
$RoutesCollection->addPut('/users/1', 'UserController@update');
$RoutesCollection->addGet('/', 'UserController@home');

$Router = new Router($RoutesCollection);

//TODO register parameters for function callback

$Router->matchRequest();