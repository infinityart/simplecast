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


$RoutesCollection->addGet('/users/', 'UserController@index');
$RoutesCollection->addGet('/users/{id}', 'UserController@showById');

$RoutesCollection->addGet('/users/{fakeid}/{names}', 'UserController@showByIdAndName');
$RoutesCollection->addGet('/users/user/{id}', 'UserController@showUserId');


$RoutesCollection->addPost('/users/', 'UserController@save');
$RoutesCollection->addDelete('/users/1', 'UserController@delete');
$RoutesCollection->addPut('/users/1', 'UserController@update');
$RoutesCollection->addGet('/', 'UserController@home');

$Router = new Router($RoutesCollection);

$Router->matchRequest();