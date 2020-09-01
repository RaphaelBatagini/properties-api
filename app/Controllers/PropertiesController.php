<?php

namespace App\Controllers;

use App\Controllers\Controller;

use App\Services\Properties;

class PropertiesController extends Controller 
{
    public function index()
    {
        $properties = Properties::list();
        var_dump($properties);
    }
}