<?php
/**
 * @author: Jonty Sponselee <jsponselee@student.scalda.nl>
 * @since: 16-3-2017
 */

require_once '../vendor/autoload.php';

$RouterCollection = new \Simplecast\Router\RouteCollection();

$RouterCollection->setNamespace('Simplecast\Controller');

$RouterCollection->addGet('/users/', 'UserController@index');
$RouterCollection->addGet('/users/1', 'UserController@show');
$RouterCollection->addPost('/users/', 'UserController@save');
$RouterCollection->addDelete('/users/1', 'UserController@delete');
$RouterCollection->addPut('/users/1', 'UserController@update');