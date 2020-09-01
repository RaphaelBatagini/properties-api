<?php

namespace App;

use CoffeeCode\Router\Router;

$router = new Router('https://grupo-zap.local');

/* Create your routes here */
$router->namespace("App\Controllers");
$router->get('/', 'IndexController:index');

$router->group('properties')->namespace("App\Controllers");
$router->get('/', 'PropertiesController:index');
$router->get('/{page}', 'PropertiesController:index');
/* End of project routes */

$router->dispatch();
