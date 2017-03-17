<?php
/**
 * @author: Jonty Sponselee <jsponselee@student.scalda.nl>
 * @since: 16-3-2017
 */
use  Simplecast\Router\RouteCollection;
use  Simplecast\Router\Router;

require_once '../vendor/autoload.php';

$RouterCollection = new RouteCollection();

$RouterCollection->setNamespace('Simplecast\Controller');

$RouterCollection->addGet('/users/', 'UserController@index');
$RouterCollection->addGet('/users/1', 'UserController@show');
$RouterCollection->addPost('/users/', 'UserController@save');
$RouterCollection->addDelete('/users/1', 'UserController@delete');
$RouterCollection->addPut('/users/1', 'UserController@update');

$Router = new Router($RouterCollection);

//TODO set basepath(when request uri is empty, use this instead)
//TODO set 404 callback
//TODO register parameters for function callback

$Router->matchRequest();