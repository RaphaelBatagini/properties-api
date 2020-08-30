<?php

namespace App;

use CoffeeCode\Router\Router;

$router = new Router('https://grupo-zap.local');

$router->namespace("App\Controllers");
$router->get('/', 'IndexController:index');

/**
 * This method executes the routes
 */
$router->dispatch();
