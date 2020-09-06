<?php

namespace App;

use CoffeeCode\Router\Router;

$domain = $_ENV['PROJECT_URL'] ?: 'localhost';
$router = new Router($domain);

/* Create your routes here */
$router->namespace('App\Controllers');
$router->get('/', 'IndexController:index');

$router->group('properties')->namespace('App\Controllers');
$router->get('/', 'PropertiesController:index');
$router->get('/{page}', 'PropertiesController:index');
$router->get('/portal/{portal}/{page}', 'PropertiesController:index');

$router->group('error')->namespace('App\Controllers');
$router->get('/{errcode}', 'IndexController:error');

/* End of project routes */

$router->dispatch();

/*
 * Redirect all errors
 */
if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
